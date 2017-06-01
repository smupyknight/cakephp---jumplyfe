<?php
App::uses('AppController', 'Controller');
class WelcomesController extends AppController {
	public $components = array('Paginator','Email','Session','RequestHandler');
	public $helpers = array('Html','Form','Session','Time','Text');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('home_safety','index','footer','timeline_content','policies','faqs','hospitality','press','jobs','getBannerImage','showTopFeatureRecord','contact_us','help','help_left_section_data','help_topic_detail','getBannerVideo','advertisement'));
	}
	
	public function index(){
		$this->loadModel('JumpGallery');
		$this->loadModel('JumpHostReview');
		$this->JumpGallery->bindModel(array(
							'belongsTo' => array(
								'Jump' => array(
									'className'     => 'Jump',
									'foreignKey'    => 'jump_id'
								)
							)
						));
	
		$recent_jumps = $this->JumpGallery->find('all',array('conditions'=>array('JumpGallery.show_in_recent_jump'=>'Yes'),'limit'=>3,'order'=>'JumpGallery.modified DESC'));
		$this->set('recent_jumps',$recent_jumps);
		
		$this->loadModel('TopFeature');
		$top_features = $this->TopFeature->find('all',array('conditions'=>array('TopFeature.status'=>1),'limit'=>5,'order'=>'TopFeature.display_order ASC'));
		$this->set('top_features',$top_features);
	}
	
	public function getBannerImage(){
		$this->loadModel('Banner');
		$banners = $this->Banner->find('all',array('conditions'=>array('Banner.status'=>1),'order'=>'Banner.display_order DESC'));
		return $banners;	
		
	}
	
	
	public function getBannerVideo(){
		$this->loadModel('Banner');
		$video_banner = $this->Banner->find('first',array('conditions'=>array('Banner.status'=>1,'Banner.media_type'=>'Video'),'order'=>'Banner.created DESC'));
		return $video_banner;
	}
	
	
	public function contact_us(){
		if($this->request->isAjax()){
			$this->loadModel('Contact');
			$this->Contact->set($this->request->data['Contact']);
			if($this->Contact->contact_us_validate()){
				$data = array();
				$data['name'] 		= strip_tags(trim($this->request->data['Contact']['name']));
				$data['email'] 		= trim($this->request->data['Contact']['email']);
				$data['subject'] 	= strip_tags(trim($this->request->data['Contact']['subject']));
				$data['message'] 	= strip_tags(trim($this->request->data['Contact']['message']));
				$this->Contact->create();
				$saveData = $this->Contact->save($data,false);

				$this->loadModel('EmailTemplate');
				$temp_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"contact_us",'EmailTemplate.status'=>1)));
				$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
				$site_title = Configure::read("Site.title");
				$email_address = Configure::read("Site.email");
				if(isset($temp_record) && !empty($temp_record)){
					$Email = $this->Email;
					$Email->smtpOptions = array(
					'port' => MAIL_PORT,
					'host' => MAIL_HOST,
					'username' => MAIL_USERNAME,
					'password' => MAIL_PASSWORD,
					'client' => MAIL_CLIENT,
					"timeout" => 120,
					"log" => true
					);
					
					$body = $temp_record['EmailTemplate']['body'];
					$string = str_replace('{#logo}',$logo,$body);
					$string = str_replace('{#name}',$data['name'],$string);
					$string = str_replace('{#subject}',$data['subject'],$string);
					$string = str_replace('{#email}',$data['email'],$string);
					$string = str_replace('{#message}',$data['message'],$string);
					$string = str_replace('{#site_title}',$site_title,$string);
					$Email->delivery = "smtp";
					$Email->from = MAIL_FROM;
					$Email->to = $data['email'];
					$Email->subject = $temp_record['EmailTemplate']['subject'];
					$Email->sendAs = 'html';
					$Email->send($string);
				}
				
				$admin_contact_us_temp = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"contact_us_admin",'EmailTemplate.status'=>1)));
				
				if(isset($admin_contact_us_temp) && !empty($admin_contact_us_temp)){
					$Email = $this->Email;
					$Email->smtpOptions = array(
					'port' => MAIL_PORT,
					'host' => MAIL_HOST,
					'username' => MAIL_USERNAME,
					'password' => MAIL_PASSWORD,
					'client' => MAIL_CLIENT,
					"timeout" => 120,
					"log" => true
					);
					
					$body 	= $admin_contact_us_temp['EmailTemplate']['body'];
					$string = str_replace('{#logo}',$logo,$body);
					$string = str_replace('{#name}',$data['name'],$string);
					$string = str_replace('{#subject}',$data['subject'],$string);
					$string = str_replace('{#email}',$data['email'],$string);
					$string = str_replace('{#message}',$data['message'],$string);
					$string = str_replace('{#site_title}',$site_title,$string);
					$Email->delivery = "smtp";
					$Email->from = MAIL_FROM;
					$Email->to = $email_address;
					$Email->subject = $admin_contact_us_temp['EmailTemplate']['subject'];
					$Email->sendAs = 'html';
					$Email->send($string);
				}
				
				$success = true;
				$message = 'Your message has been successfully sent. We will contact you very soon!';
				$dataResponse['resetForm'] = true;
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->Contact->validationErrors);
			}

			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function advertisement(){
		$this->loadModel('Advertisement');
		$this->loadModel('AdvertisementLogs');
		$current_date = date('Y-m-d');
		$ads = $this->Advertisement->find('all',array('conditions'=>array('AND'=>array('Advertisement.start_date <= '=>$current_date,'Advertisement.end_date >= '=>$current_date),'Advertisement.status'=>1,'Advertisement.position'=>$this->params['pass'][0]),'order' => 'Advertisement.created DESC'));
		return $ads;
	}
	
	public function home_safety(){
		$this->loadModel('HomeSafety');
		$record = $this->HomeSafety->find('all',array('conditions'=>array('HomeSafety.status'=>1),'fields'=>array('title','description'),'order'=>'HomeSafety.created DESC'));
		$this->set('record',$record);
	}
	
	public function policies(){
		$this->loadModel('Policy');
		$record = $this->Policy->find('all',array('conditions'=>array('Policy.status'=>1),'fields'=>array('title','description'),'order'=>'Policy.created DESC'));
		$this->set('record',$record);
	}
	
	public function faqs(){
		$this->loadModel('Faq');
		$record = $this->Faq->find('all',array('fields'=>array('question','answer'),'order'=>'Faq.created DESC'));
		$this->set('record',$record);
	}
	
	public function help($slug = null){
		$this->loadModel('HelpCategory');
		$this->loadModel('HelpTopic');
		$this->HelpCategory->bindModel(array(
								'hasMany' => array(
									'HelpTopic' => array(
										'className'     => 'HelpTopic',
										'order'         => 'created DESC',
										'conditions'    => array('status'=>1),
										'foreignKey'    => 'help_category_id'
										
									)
								)
							));
							
		if(!isset($slug) && empty($slug))
		{	
			$data = $this->HelpCategory->find('first',array('conditions'=>array('HelpCategory.status'=>1),'order'=>'HelpCategory.display_order ASC'));
		}
		else
		{
			$data = $this->HelpCategory->findBySlug($slug);
			$this->checkRecordIsNull($data);
		}
		$highlight_light_record = 	$this->HelpTopic->find('all',array('conditions'=>array('HelpTopic.help_category_id'=>$data['HelpCategory']['id'],'HelpTopic.highlight_this_topic'=>'Yes')));
		$this->set('height_light_record',$highlight_light_record);
		$this->set('left_menu_selected',$data['HelpCategory']['slug']);
		$this->set('record',$data);
		
	}
	
	public function help_left_section_data(){
		$this->loadModel('HelpCategory');
		$data = $this->HelpCategory->find('all',array('conditions'=>array('HelpCategory.status'=>1),'order'=>'HelpCategory.display_order ASC','fields'=>array('HelpCategory.category_name','HelpCategory.slug')));
		return $data;
	}
	
	public function help_topic_detail($category_slug,$topic_slug){
		$this->loadModel('HelpTopic');
		$this->loadModel('HelpCategory');
		
		$category_data = $this->HelpCategory->findBySlug($category_slug);
		$this->checkRecordIsNull($category_data);
		
		$topic_data = $this->HelpTopic->findBySlug($topic_slug);
		$this->checkRecordIsNull($topic_data);
		$this->set('topic_data',$topic_data);
		$this->set('left_menu_selected',$category_data['HelpCategory']['slug']);
	}
	
	public function showTopFeatureRecord(){
		$slug = $this->request->data['slug'];
		$this->loadModel('TopFeature');
		$record = $this->TopFeature->find('first',array('conditions'=>array('TopFeature.slug'=>$slug),'fields'=>array('TopFeature.title','TopFeature.description','TopFeature.image')));
		
		$data['success'] 	 =  true;
		$data['title'] 		 =  $record['TopFeature']['title'];
		$data['description'] =  $record['TopFeature']['description'];
		$file_path			 =	ALBUM_UPLOAD_IMAGE_PATH;
		$file_name			 =	$record['TopFeature']['image'];
		$base_encode 		 =	base64_encode($file_path);
		if($file_name && file_exists($file_path . $file_name)) 
		{
			$data['image']	=	WEBSITE_URL.'imageresize/imageresize/get_image/196/196/'. $base_encode.'/'.$file_name;
		}
		else
		{
			$data['image']	=  '';	
		}
		echo json_encode($data); die;

	}
	
	public function timeline($slug = null){
		$this->loadModel('User');
		$session_user_data = $this->User->findById($this->Auth->user('id'),array('fileds'=>'User.slug'));
		$this->checkRecordIsNull($session_user_data);
		if($session_user_data['User']['slug'] != $slug){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'news_feed',$session_user_data['User']['slug']));
		}
		else
		{
			$profile_user_id = $session_user_data['User']['id'];
			$this->set('left_part_user_id',$profile_user_id);
			$this->set('timeline_id',$profile_user_id);
			$this->set('top_menu_selected','Timeline');
			
			/*$this->loadModel('Advertisement');
			
			$current_date = date('Y-m-d');
			
			
			$left_ad = $this->Advertisement->find('all',array('conditions'=>array('AND'=>array('Advertisement.start_date <= '=>$current_date,'Advertisement.end_date >= '=>$current_date),'Advertisement.status'=>1,'Advertisement.position'=>'left'),'order' => 'rand()'));
			$this->set('ad_left',$left_ad);*/
			
		}
	}
	
	public function news_feed($slug = null){
		$this->loadModel('User');
		$session_user_data = $this->User->findById($this->Auth->user('id'),array('fileds'=>'User.slug'));
		$this->checkRecordIsNull($session_user_data);
		if($session_user_data['User']['slug'] != $slug){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'news_feed',$session_user_data['User']['slug']));
		}
		else
		{
			$profile_user_id = $session_user_data['User']['id'];
			$this->set('timeline_id',$profile_user_id);
			$this->set('left_part_user_id',$profile_user_id);
			
			$this->set('top_menu_selected','Feeds');
		
			$this->loadModel('Advertisement');
			
			/*$current_date = date('Y-m-d');
			
			
			$left_ad = $this->Advertisement->find('all',array('conditions'=>array('AND'=>array('Advertisement.start_date <= '=>$current_date,'Advertisement.end_date >= '=>$current_date),'Advertisement.status'=>1,'Advertisement.position'=>'left'),'order' => 'rand()'));
			$this->set('ad_left',$left_ad);*/
			
			
		}
	}
	
	public function timeline_content(){
		$this->loadModel('User');
		$this->loadModel('UserFeed');
		$this->loadModel('Jump');
		$this->loadModel('JumpGallery');
		$this->loadModel('UserFeedLike');
		$this->loadModel('JumpHost');
		$this->loadModel('EliteOffer');
		$this->loadModel('UserFeedComment');
		$this->loadModel('TotalGroupMember');
		if(isset($_GET['friends'])){
			
			$this->request->data['friends'] 	= $_GET['friends'];
			$this->request->data['id'] 			= $_GET['user_id'];
			
		}
		
		if(isset($_GET['group_id']) && $_GET['group_id']!= 'null'){
			
			$this->request->data['group_id'] 	= $_GET['group_id'];
			$this->request->data['id'] 			= $_GET['user_id'];
			$this->request->data['friends'] 	= $_GET['friends'];
			
		}
		
		$user_record = $this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['id'],'User.status'=>1)));
		$this->checkRecordIsNull($user_record);
		$sessionUser = $this->User->findById($this->Auth->user('id'));
		$this->set('sessionUserData',$sessionUser);
		
		if(isset($this->request->data['group_id']) && $this->request->data['friends'] == 'true'){
			$this->Paginator->settings = array(
				'UserFeed'=>array(
					'conditions'=>array('UserFeed.group_id'=>$this->request->data['group_id'],'UserFeed.status'=>1),
					'limit' => 5,
					'order' => 'UserFeed.created desc',
					'paramType' => 'querystring'
				)
			);
			
			$UserFeed_record = $this->Paginator->paginate('UserFeed');
		}
		
		else if($this->request->data['friends'] == 'true'){
			$friend_record = $this->findFriends($this->request->data['id']);
			if($friend_record){
				foreach($friend_record as $key => $value){
					$User_id[$key] = $value['User']['id'];
				}
			}
			$User_id[] = $this->request->data['id'];
			$conditions[] = array('OR'=>array('PrivateProfile.is_private_profile'=>'No','PrivateProfile.id'=>$this->Auth->user('id')));
			$conditions[] = array('UserFeed.user_id'=>$User_id);
			$conditions[] = array('UserFeed.status'=>1);
			$conditions[] = array('UserFeed.group_id' => 0);
			$this->Paginator->settings = array(
				'UserFeed'=>array(
					'conditions'=>$conditions,
					'limit' => 5,
					'order' => 'UserFeed.created desc',
					'paramType' => 'querystring'
				)
			);
			
			$UserFeed_record = $this->Paginator->paginate('UserFeed');
			//pr($UserFeed_record); die;
		}
		else
		{
			$this->Paginator->settings = array(
				'UserFeed'=>array(
					'conditions'=>array('UserFeed.user_id'=>$this->request->data['id'],'UserFeed.status'=>1,'UserFeed.group_id' => 0),
					'limit' => 5,
					'order' => 'UserFeed.created desc',
					'paramType' => 'querystring'
				)
			);
			
			$UserFeed_record = $this->Paginator->paginate('UserFeed');
		}
		$this->set('friends',$this->request->data['friends']);
		if(isset($this->request->data['group_id'])){
			$this->set('group_id',$this->request->data['group_id']);
		}
		else
		{
			$this->set('group_id','null');
		}
		$this->set('user_id',$this->request->data['id']);
	
		$feeds = array();
		foreach($UserFeed_record as $key => $value){
			if($value['UserFeed']['feed_type_id'] == 1){
				//When user create jump manually
				$feeds[$key]['UserFeed']['id']  =   $value['UserFeed']['id'];
				$feeds[$key]['UserFeed']['feed_type_id']  =   $value['UserFeed']['feed_type_id'];
				$feeds[$key]['UserFeed']['feed_make_time']  =   $value['UserFeed']['created'];
				$feeds[$key]['UserFeed']['user_id']  =   $value['UserFeed']['user_id'];	
				$feeds[$key]['UserFeed']['description']  =   $value['UserFeed']['description'];	
				$feeds[$key]['UserFeed']['is_shared']  =   $value['UserFeed']['is_shared'];
				
				$feeds[$key]['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$value['UserFeed']['feed_type_target_id'],'Jump.status'=>1)));
				
				$feeds[$key]['Feedlikes'] 	= $this->like_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedComments'] = $this->comment_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedShare']	 = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$value['UserFeed']['id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
				
				$feeds[$key]['UserFeedlike'] = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$value['UserFeed']['id'],'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
				
				$feeds[$key]['comments'] = $this->UserFeedComment->find('all',array('conditions'=>array('UserFeedComment.user_feed_id'=>$value['UserFeed']['id'],'UserFeedComment.status'=>1),'order'=>'UserFeedComment.created DESC','limit'=>2));
			
				if($value['UserFeed']['is_shared'] == 'Yes'){
				
					$feeds[$key]['UserFeedParentData'] = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$value['UserFeed']['parent_id'],'UserFeed.status'=>1),'fields'=>array('UserFeed.user_id','UserFeed.description')));
					
					$feeds[$key]['UserParentData'] = $this->User->find('first',array('conditions'=>array('User.id'=>$feeds[$key]['UserFeedParentData']['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.image','User.slug')));
				
				}
				
				if($this->request->data['friends'] == 'true'){
					$newsFeed_userRecord = $this->User->find('first',array('conditions'=>array('User.id'=>$value['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.image','User.firstname','User.lastname','User.slug','User.is_private_profile')));
					
					$feeds[$key]['User']['logo']  =   $newsFeed_userRecord['User']['image'];
					$feeds[$key]['User']['name']  =   $newsFeed_userRecord['User']['firstname'] .' '.$newsFeed_userRecord['User']['lastname'];
					$feeds[$key]['User']['slug']  =   $newsFeed_userRecord['User']['slug'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['is_private_profile']  =   $newsFeed_userRecord['User']['is_private_profile'];
				}				
				else
				{ 
					$feeds[$key]['User']['logo']  =   $user_record['User']['image'];
					$feeds[$key]['User']['name']  =   $user_record['User']['firstname'] .' '.$user_record['User']['lastname'];
					$feeds[$key]['User']['slug']  =   $user_record['User']['slug'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
				}
			}	
			
			else if($value['UserFeed']['feed_type_id'] == 2){
				//when jump create through jump rental and elite booking
				$feeds[$key]['UserFeed']['id']  =   $value['UserFeed']['id'];
				$feeds[$key]['UserFeed']['feed_type_id']  =   $value['UserFeed']['feed_type_id'];
				$feeds[$key]['UserFeed']['feed_make_time']  =   $value['UserFeed']['created'];
				$feeds[$key]['UserFeed']['user_id']  =   $value['UserFeed']['user_id'];	
				$feeds[$key]['UserFeed']['description']  =   $value['UserFeed']['description'];
				$feeds[$key]['UserFeed']['is_shared']  	 =   $value['UserFeed']['is_shared'];
				
				$feeds[$key]['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$value['UserFeed']['feed_type_target_id'],'Jump.status'=>1)));
				
				$feeds[$key]['Feedlikes'] = $this->like_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedComments'] = $this->comment_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedShare']	 = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$value['UserFeed']['id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
				
				$feeds[$key]['UserFeedlike'] = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$value['UserFeed']['id'],'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
				
				$feeds[$key]['comments'] = $this->UserFeedComment->find('all',array('conditions'=>array('UserFeedComment.user_feed_id'=>$value['UserFeed']['id'],'UserFeedComment.status'=>1),'order'=>'UserFeedComment.created DESC','limit'=>2));
				
				if($value['UserFeed']['is_shared'] == 'Yes'){
				
					$feeds[$key]['UserFeedParentData'] = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$value['UserFeed']['parent_id'],'UserFeed.status'=>1),'fields'=>array('UserFeed.user_id','UserFeed.description')));
					
					$feeds[$key]['UserParentData'] = $this->User->find('first',array('conditions'=>array('User.id'=>$feeds[$key]['UserFeedParentData']['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.image','User.slug')));
				
				}
				
				if($this->request->data['friends'] == 'true'){
					//die('xz'); 
					$newsFeed_userRecord = $this->User->find('first',array('conditions'=>array('User.id'=>$value['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.image','User.firstname','User.lastname','User.slug','User.is_private_profile')));
					
					$feeds[$key]['User']['logo']  				=   $newsFeed_userRecord['User']['image'];
					$feeds[$key]['User']['name'] 				=   $newsFeed_userRecord['User']['firstname'] .' '.$newsFeed_userRecord['User']['lastname'];
					$feeds[$key]['FeedType']['title']  			=   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['slug']  				=   $newsFeed_userRecord['User']['slug'];
					$feeds[$key]['User']['is_private_profile']  =   $newsFeed_userRecord['User']['is_private_profile'];
				}				
				else
				{
					//die('xzFDXG'); 
					$feeds[$key]['User']['logo']  =   $user_record['User']['image'];
					$feeds[$key]['User']['name']  =   $user_record['User']['firstname'] .' '.$user_record['User']['lastname'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['slug']  =   $user_record['User']['slug'];
					
				}		
				
			}
			
			else if($value['UserFeed']['feed_type_id'] == 5){
				
				$feeds[$key]['UserFeed']['id']  			=   $value['UserFeed']['id'];
				$feeds[$key]['UserFeed']['feed_type_id']  	=   $value['UserFeed']['feed_type_id'];
				$feeds[$key]['UserFeed']['user_id']  		=   $value['UserFeed']['user_id'];	
				$feeds[$key]['UserFeed']['description'] 	=   $value['UserFeed']['description'];	
				$feeds[$key]['UserFeed']['feed_type']  		=   $value['UserFeed']['feed_type'];	
				$feeds[$key]['UserFeed']['feed_media']  	=   $value['UserFeed']['feed_media'];	
				$feeds[$key]['UserFeed']['video_type']  	=   $value['UserFeed']['video_type'];	
				$feeds[$key]['UserFeed']['video']  			=   $value['UserFeed']['video'];	
				$feeds[$key]['UserFeed']['image']  			=   $value['UserFeed']['image'];	
				$feeds[$key]['UserFeed']['feed_make_time']  =   $value['UserFeed']['created'];	
		
			
				$feeds[$key]['UserFeedlike'] = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$value['UserFeed']['id'],'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
				
				$feeds[$key]['Feedlikes'] = $this->like_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedComments'] = $this->comment_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedShare']	 = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.feed_type_id'=>5,'UserFeed.parent_id'=>$value['UserFeed']['id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
				
				if($value['UserFeed']['feed_type'] == 'Booking'){
					
					$feeds[$key]['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$value['UserFeed']['feed_type_target_id'],'Jump.status'=>1)));
				}
				
				$feeds[$key]['UserFeedParentData'] = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$value['UserFeed']['parent_id'],'UserFeed.status'=>1),'fields'=>array('UserFeed.user_id')));
				
				$feeds[$key]['comments'] = $this->UserFeedComment->find('all',array('conditions'=>array('UserFeedComment.user_feed_id'=>$value['UserFeed']['id'],'UserFeedComment.status'=>1),'order'=>'UserFeedComment.created DESC','limit'=>2));
				
				$feeds[$key]['UserParentData'] = $this->User->find('first',array('conditions'=>array('User.id'=>$feeds[$key]['UserFeedParentData']['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.image')));
				
				if($this->request->data['friends'] == 'true'){
					//die('xz'); 
					$newsFeed_userRecord = $this->User->find('first',array('conditions'=>array('User.id'=>$value['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('image','firstname','lastname')));
					
					$feeds[$key]['User']['logo']  =   $newsFeed_userRecord['User']['image'];
					$feeds[$key]['User']['name']  =   $newsFeed_userRecord['User']['firstname'] .' '.$newsFeed_userRecord['User']['lastname'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
				}				
				else
				{
					//die('xzFDXG'); 
					$feeds[$key]['User']['logo']  =   $user_record['User']['image'];
					$feeds[$key]['User']['name']  =   $user_record['User']['firstname'] .' '.$user_record['User']['lastname'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					
				}
				
			} 
			
			else if($value['UserFeed']['feed_type_id'] == 6){
				$feeds[$key]['UserFeed']['id']  			=   $value['UserFeed']['id'];
				$feeds[$key]['UserFeed']['feed_type_id']  	=   $value['UserFeed']['feed_type_id'];
				$feeds[$key]['UserFeed']['user_id']  		=   $value['UserFeed']['user_id'];	
				$feeds[$key]['UserFeed']['description'] 	=   $value['UserFeed']['description'];	
				$feeds[$key]['UserFeed']['feed_type']  		=   $value['UserFeed']['feed_type'];	
				$feeds[$key]['UserFeed']['feed_media']  	=   $value['UserFeed']['feed_media'];	
				$feeds[$key]['UserFeed']['video_type']  	=   $value['UserFeed']['video_type'];	
				$feeds[$key]['UserFeed']['video']  			=   $value['UserFeed']['video'];	
				$feeds[$key]['UserFeed']['image']  			=   $value['UserFeed']['image'];	
				$feeds[$key]['UserFeed']['feed_make_time']  =   $value['UserFeed']['created'];	
				$feeds[$key]['UserFeed']['is_shared']  		=   $value['UserFeed']['is_shared'];
				$feeds[$key]['UserFeed']['group_id']  		=   $value['UserFeed']['group_id'];
				if($value['UserFeed']['group_id'] != 0){
					$feeds[$key]['GroupMember']  = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=>$value['UserFeed']['group_id'],'TotalGroupMember.user_id'=>$this->Auth->user('id'))));
				}
				
				$feeds[$key]['Feedlikes'] = $this->like_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedComments'] = $this->comment_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedShare']	 = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$value['UserFeed']['id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
				
				if($value['UserFeed']['is_shared'] == 'Yes'){
				
					$feeds[$key]['UserFeedParentData'] = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$value['UserFeed']['parent_id'],'UserFeed.status'=>1),'fields'=>array('UserFeed.user_id','UserFeed.description')));
					
					$feeds[$key]['UserParentData'] = $this->User->find('first',array('conditions'=>array('User.id'=>$feeds[$key]['UserFeedParentData']['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.image','User.slug')));
				
				}
				
				$UserFeedlike = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$value['UserFeed']['id'],'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
				
				//if(!empty($UserFeedlike)){
					//$feeds[$key]['UserFeedlike'] = $UserFeedlike;
				//}
				//pr($feeds); die;
				
				$feeds[$key]['comments'] = $this->UserFeedComment->find('all',array('conditions'=>array('UserFeedComment.user_feed_id'=>$value['UserFeed']['id'],'UserFeedComment.status'=>1),'order'=>'UserFeedComment.created DESC','limit'=>2));
				
				if($this->request->data['friends'] == 'true'){
					//die('xz'); 
					$newsFeed_userRecord = $this->User->find('first',array('conditions'=>array('User.id'=>$value['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.image','User.firstname','User.lastname','User.slug')));
					
					$feeds[$key]['User']['logo']  =   $newsFeed_userRecord['User']['image'];
					$feeds[$key]['User']['name']  =   $newsFeed_userRecord['User']['firstname'] .' '.$newsFeed_userRecord['User']['lastname'];
					$feeds[$key]['User']['slug']  =   $newsFeed_userRecord['User']['slug'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					
				}				
				else
				{
					//die('xzFDXG'); 
					$feeds[$key]['User']['logo']  =   $user_record['User']['image'];
					$feeds[$key]['User']['name']  =   $user_record['User']['firstname'] .' '.$user_record['User']['lastname'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['slug']  =   $user_record['User']['slug'];
					
				}		
				
			}
			
			if($value['UserFeed']['feed_type_id'] == 7){
				$feeds[$key]['UserFeed']['id']  =   $value['UserFeed']['id'];
				$feeds[$key]['UserFeed']['feed_type_id']  =   $value['UserFeed']['feed_type_id'];
				$feeds[$key]['UserFeed']['feed_make_time']  =   $value['UserFeed']['created'];
				$feeds[$key]['UserFeed']['user_id']  =   $value['UserFeed']['user_id'];	
				$feeds[$key]['UserFeed']['description']  =   $value['UserFeed']['description'];	
				$feeds[$key]['UserFeed']['is_shared']  =   $value['UserFeed']['is_shared'];	
				
				$feeds[$key]['JumpGallery'] = $this->JumpGallery->find('first',array('conditions'=>array('JumpGallery.id'=>$value['UserFeed']['feed_type_target_id'],'JumpGallery.status'=>1)));
				
				$feeds[$key]['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$feeds[$key]['JumpGallery']['JumpGallery']['jump_id'],'Jump.status'=>1)));
				
				$feeds[$key]['Feedlikes'] 	= $this->like_counter($value['UserFeed']['id']);
				
				if($value['UserFeed']['is_shared'] == 'Yes'){
				
					$feeds[$key]['UserFeedParentData'] = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$value['UserFeed']['parent_id'],'UserFeed.status'=>1),'fields'=>array('UserFeed.user_id','UserFeed.description')));
					
					$feeds[$key]['UserParentData'] = $this->User->find('first',array('conditions'=>array('User.id'=>$feeds[$key]['UserFeedParentData']['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.image','User.slug')));
				
				}
				
				$feeds[$key]['FeedComments'] = $this->comment_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedShare']	 = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$value['UserFeed']['id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
				
				
				$feeds[$key]['UserFeedlike'] = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$value['UserFeed']['id'],'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
				
				$feeds[$key]['comments'] = $this->UserFeedComment->find('all',array('conditions'=>array('UserFeedComment.user_feed_id'=>$value['UserFeed']['id'],'UserFeedComment.status'=>1),'order'=>'UserFeedComment.created DESC','limit'=>2));
			
				if($this->request->data['friends'] == 'true'){
					//die('xz'); 
					$newsFeed_userRecord = $this->User->find('first',array('conditions'=>array('User.id'=>$value['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.image','User.firstname','User.lastname','User.slug','User.is_private_profile')));
					
					$feeds[$key]['User']['logo']  =   $newsFeed_userRecord['User']['image'];
					$feeds[$key]['User']['name']  =   $newsFeed_userRecord['User']['firstname'] .' '.$newsFeed_userRecord['User']['lastname'];
					$feeds[$key]['User']['slug']  =   $newsFeed_userRecord['User']['slug'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['slug']  =   $newsFeed_userRecord['User']['slug'];
					$feeds[$key]['User']['is_private_profile']  =   $newsFeed_userRecord['User']['is_private_profile'];
				}				
				else
				{
					//die('xzFDXG'); 
					$feeds[$key]['User']['logo']  =   $user_record['User']['image'];
					$feeds[$key]['User']['name']  =   $user_record['User']['firstname'] .' '.$user_record['User']['lastname'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['slug']  =   $user_record['User']['slug'];
				}
			}
			
			if($value['UserFeed']['feed_type_id'] == 8){
				$feeds[$key]['UserFeed']['id']  =   $value['UserFeed']['id'];
				$feeds[$key]['UserFeed']['feed_type_id']  =   $value['UserFeed']['feed_type_id'];
				$feeds[$key]['UserFeed']['feed_make_time']  =   $value['UserFeed']['created'];
				$feeds[$key]['UserFeed']['user_id']  =   $value['UserFeed']['user_id'];	
				$feeds[$key]['UserFeed']['description']  =   $value['UserFeed']['description'];	
				$feeds[$key]['UserFeed']['is_shared']  =   $value['UserFeed']['is_shared'];
				
				$feeds[$key]['JumpGallery'] = $this->JumpGallery->find('first',array('conditions'=>array('JumpGallery.id'=>$value['UserFeed']['feed_type_target_id'],'JumpGallery.status'=>1)));
				
				$feeds[$key]['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$feeds[$key]['JumpGallery']['JumpGallery']['jump_id'],'Jump.status'=>1)));
				
				$feeds[$key]['Feedlikes'] 	= $this->like_counter($value['UserFeed']['id']);
				
				$feeds[$key]['FeedComments'] = $this->comment_counter($value['UserFeed']['id']);
				
				if($value['UserFeed']['is_shared'] == 'Yes'){
				
					$feeds[$key]['UserFeedParentData'] = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$value['UserFeed']['parent_id'],'UserFeed.status'=>1),'fields'=>array('UserFeed.user_id','UserFeed.description')));
					
					$feeds[$key]['UserParentData'] = $this->User->find('first',array('conditions'=>array('User.id'=>$feeds[$key]['UserFeedParentData']['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.image','User.slug')));
				
				}
				
				$feeds[$key]['FeedShare']	 = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$value['UserFeed']['id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
				
				$feeds[$key]['UserFeedlike'] = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$value['UserFeed']['id'],'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
				
				$feeds[$key]['comments'] = $this->UserFeedComment->find('all',array('conditions'=>array('UserFeedComment.user_feed_id'=>$value['UserFeed']['id'],'UserFeedComment.status'=>1),'order'=>'UserFeedComment.created DESC','limit'=>2));
			
				if($this->request->data['friends'] == 'true'){
					//die('xz'); 
					$newsFeed_userRecord = $this->User->find('first',array('conditions'=>array('User.id'=>$value['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.image','User.firstname','User.lastname','User.slug','User.is_private_profile')));
					
					$feeds[$key]['User']['logo']  =   $newsFeed_userRecord['User']['image'];
					$feeds[$key]['User']['name']  =   $newsFeed_userRecord['User']['firstname'] .' '.$newsFeed_userRecord['User']['lastname'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['slug']  =   $newsFeed_userRecord['User']['slug'];
					$feeds[$key]['User']['is_private_profile']  =   $newsFeed_userRecord['User']['is_private_profile'];
				}				
				else
				{
					//die('xzFDXG'); 
					$feeds[$key]['User']['logo']  =   $user_record['User']['image'];
					$feeds[$key]['User']['name']  =   $user_record['User']['firstname'] .' '.$user_record['User']['lastname'];
					$feeds[$key]['FeedType']['title']  =   $value['FeedType']['title_singular'];
					$feeds[$key]['User']['slug']  =   $user_record['User']['slug'];
					
				}
			}	
		}
		
		//pr($feeds); die;
		$this->set('timeline_record',$feeds);
		$this->render('timeline_content','ajax');
	}
	
	public function user_feed_like(){
		$this->loadModel('UserFeedLike');
		$user_feedId = $this->request->data['id'];
		$feedsRecord = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$user_feedId,'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
		$table_name = 'UserFeedLike';
		$feedsLikeId = $feedsRecord['UserFeedLike']['id'];
		if($feedsRecord)
		{ 
			$this->UserFeedLike->delete($feedsLikeId);
			$next_task = 'Like';
			$like_counter = $this->like_counter($user_feedId);
		}
		else
		{
			$save_record = array();
			$save_record['user_id'] = $this->Auth->user('id');
			$save_record['user_feed_id'] = $this->request->data['id'];
			$this->UserFeedLike->create();
			$this->UserFeedLike->save($save_record,false);	
			$next_task = 'Unlike';
			$like_counter = $this->like_counter($user_feedId);
		}
		$data['success'] = true;
		$data['next_task'] = $next_task;
		$data['like_counter'] = $like_counter;
		echo json_encode($data); die;
	}
	
	public function user_feed_comment(){
		$this->loadModel('UserFeedComment');
		$this->loadModel('User');
		if($this->request->is('post')){
			$data = array();
			$data['UserFeedComment']['comment'] 	 = strip_tags(trim($this->request->data['UserFeedLike']['comment']));
			$data['UserFeedComment']['user_id'] 	 = $this->Auth->user('id');
			$data['UserFeedComment']['user_feed_id'] = $this->request->data['UserFeedLike']['user_feed_id'];
			$user_data = $this->User->findById($data['UserFeedComment']['user_id']);
			$full_name = $user_data['User']['firstname'].' '.$user_data['User']['lastname'];
			$user_slug = $user_data['User']['slug'];
			$user_image = $user_data['User']['image'];
			if($data['UserFeedComment']['comment'] && $data['UserFeedComment']['user_feed_id'])
			{
				$this->UserFeedComment->create();
				$saveRecord = $this->UserFeedComment->save($data,false);
				$dataR['success'] = true;
				$dataR['comment'] = $data['UserFeedComment']['comment'];
				$dataR['created_date'] = date('d M Y  g:i A',strtotime($saveRecord['UserFeedComment']['created']));
				$dataR['user_name'] = $full_name;
				$dataR['user_profile_url'] = WEBSITE_URL.$user_slug;
				$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
				$file_name		=	$user_image;
				$base_encode 	=	base64_encode($file_path);
				if($file_name && file_exists($file_path . $file_name)) {
					$dataR['user_image']	=	WEBSITE_URL.'imageresize/imageresize/get_image/80/81/'. $base_encode.'/'.$file_name;
				}	
				else{
					$dataR['user_image'] = '';
				}
				$dataR['resetForm'] = true;
				
				$comment_counter = $this->comment_counter($saveRecord['UserFeedComment']['user_feed_id']);
				$dataR['comment_counter'] = $comment_counter;
				$dataR['comment_id'] = $saveRecord['UserFeedComment']['id'];
			}
			else
			{
				$dataR['success'] = false;
			}
			$dataR['callBackFunction'] = 'actionAfterTimeLineCommentPost';
			$dataR['feed_id'] = $data['UserFeedComment']['user_feed_id'];
			echo json_encode($dataR); die;
		}
	}
	
	public function user_feed_share(){
		if($this->request->is('ajax')){
			$this->loadModel('Jump');
			$this->loadModel('UserFeed');
			$this->loadModel('UserFeedShare');
			$userFeed_Data = $this->UserFeed->findById($this->request->data['UserFeed']['feed_type_id']);
			$feed_type_target_id = $userFeed_Data['UserFeed']['feed_type_target_id'];
			if($userFeed_Data){
				if($userFeed_Data['UserFeed']['feed_type_id']==6){
					$userFeed_Data = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$this->request->data['UserFeed']['feed_type_id'],'UserFeed.status'=>1)));
					$userFeed_record = array();
					$userFeed_record['user_id'] = $this->Auth->user('id');
					$userFeed_record['feed_type_id'] = $userFeed_Data['UserFeed']['feed_type_id'];
					$userFeed_record['parent_id'] 	= 	$this->request->data['UserFeed']['feed_type_id'];
					$userFeed_record['feed_type'] 	= 	$userFeed_Data['UserFeed']['feed_type'];
					$userFeed_record['feed_media'] 	= 	$userFeed_Data['UserFeed']['feed_media'];
					if($userFeed_Data['UserFeed']['feed_media'] == 'Video'){
					
						$userFeed_record['video_type'] 	= 	$userFeed_Data['UserFeed']['video_type'];
						$userFeed_record['video']		= 	$userFeed_Data['UserFeed']['video'];
						
					}
					else if($userFeed_Data['UserFeed']['feed_media'] == 'Image'){
					
						$userFeed_record['image'] 		= 	$userFeed_Data['UserFeed']['image'];
						
					}
					$userFeed_record['is_shared'] = 'Yes';
					//pr($userFeed_record); die;
					$this->UserFeed->create();
					$userFeed_saveRecord = $this->UserFeed->save($userFeed_record,false);
					$dataResponse['success'] = true;
					$dataResponse['callBackFunction'] = 'actionAfterSharePost';
					$dataResponse['share_counter'] = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$userFeed_saveRecord['UserFeed']['parent_id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
					$dataResponse['feed_id'] = $userFeed_saveRecord['UserFeed']['parent_id']; 
					
				} elseif($userFeed_Data['UserFeed']['feed_type_id']==7){
					
					$userFeed_record = array();
					$userFeed_record['user_id'] = $this->Auth->user('id');
					$userFeed_record['feed_type_id'] = $userFeed_Data['UserFeed']['feed_type_id'];
					$userFeed_record['feed_type_target_id'] = $feed_type_target_id;
					$userFeed_record['parent_id'] = $this->request->data['UserFeed']['feed_type_id'];
					$userFeed_record['is_shared'] = 'Yes';
					$this->UserFeed->create();
					$userFeed_saveRecord = $this->UserFeed->save($userFeed_record,false);
				
					$dataResponse['success'] = true;
					$dataResponse['callBackFunction'] = 'actionAfterSharePost';
					$dataResponse['share_counter'] = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.feed_type_id'=>5,'UserFeed.parent_id'=>$userFeed_saveRecord['UserFeed']['parent_id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
					$dataResponse['feed_id'] = $userFeed_saveRecord['UserFeed']['parent_id'];
				
				} elseif($userFeed_Data['UserFeed']['feed_type_id']==8){
					$userFeed_record = array();
					$userFeed_record['user_id'] = $this->Auth->user('id');
					$userFeed_record['feed_type_id'] = $userFeed_Data['UserFeed']['feed_type_id'];
					$userFeed_record['feed_type_target_id'] = $feed_type_target_id;
					$userFeed_record['parent_id'] = $this->request->data['UserFeed']['feed_type_id'];
					$userFeed_record['is_shared'] = 'Yes';
					$this->UserFeed->create();
					$userFeed_saveRecord = $this->UserFeed->save($userFeed_record,false);
				
					$dataResponse['success'] = true;
					$dataResponse['callBackFunction'] = 'actionAfterSharePost';
					$dataResponse['share_counter'] = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$userFeed_saveRecord['UserFeed']['parent_id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
					$dataResponse['feed_id'] = $userFeed_saveRecord['UserFeed']['parent_id'];
				
				} else {
				
					$userFeed_record = array();
					$userFeed_record['user_id'] = $this->Auth->user('id');
					$userFeed_record['feed_type_id'] = $userFeed_Data['UserFeed']['feed_type_id'];
					$userFeed_record['feed_type_target_id'] = $feed_type_target_id;
					$userFeed_record['parent_id'] = $this->request->data['UserFeed']['feed_type_id'];
					$userFeed_record['is_shared'] = 'Yes';
					$this->UserFeed->create();
					$userFeed_saveRecord = $this->UserFeed->save($userFeed_record,false);
				
					$dataResponse['success'] = true;
					$dataResponse['callBackFunction'] = 'actionAfterSharePost';
					$dataResponse['share_counter'] = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.is_shared'=>'Yes','UserFeed.parent_id'=>$userFeed_saveRecord['UserFeed']['parent_id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
					$dataResponse['feed_id'] = $userFeed_saveRecord['UserFeed']['parent_id'];
			
				}
			}
			else
			{
				$dataResponse['success'] = false;
			}

			echo json_encode($dataResponse); die;		
		}
	}
	
	public function show_one_timeline_record(){
		$this->loadModel('User');
		$this->loadModel('UserFeed');
		$this->loadModel('Jump');
		$this->loadModel('UserFeedLike');
		$this->loadModel('JumpGallery');
		$this->loadModel('UserFeedComment');
		$UserFeed_record = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$this->request->data['id'],'UserFeed.status'=>1)));
		//pr($UserFeed_record); die;
		$sessionUser = $this->User->findById($this->Auth->user('id'));
		$this->set('sessionUserData',$sessionUser);
		if($UserFeed_record){
			$feeds = array();
			$feeds['UserFeed']['id'] 			 =   $UserFeed_record['UserFeed']['id'];
			$feeds['UserFeed']['feed_type_id'] 	 =   $UserFeed_record['UserFeed']['feed_type_id'];
			$feeds['UserFeed']['feed_make_time'] =   $UserFeed_record['UserFeed']['created'];
			$feeds['UserFeed']['user_id']  		 =   $UserFeed_record['UserFeed']['user_id'];	
			$feeds['UserFeed']['description'] 	 =   $UserFeed_record['UserFeed']['description'];	
			$feeds['UserFeed']['feed_type']  	 =   $UserFeed_record['UserFeed']['feed_type'];	
			$feeds['UserFeed']['feed_media']  	 =   $UserFeed_record['UserFeed']['feed_media'];	
			$feeds['UserFeed']['video_type']  	 =   $UserFeed_record['UserFeed']['video_type'];	
			$feeds['UserFeed']['video']  		 =   $UserFeed_record['UserFeed']['video'];	
			$feeds['UserFeed']['image']  		 =   $UserFeed_record['UserFeed']['image'];	
			$feeds['UserFeed']['feed_make_time'] =   $UserFeed_record['UserFeed']['created'];
			$feeds['UserFeed']['is_shared'] 	 =   $UserFeed_record['UserFeed']['is_shared'];
			$feeds['UserFeed']['group_id'] 		 =   $UserFeed_record['UserFeed']['group_id'];
			
			if($UserFeed_record['FeedType']['id'] == 7){
			
				$feeds['JumpGallery'] = $this->JumpGallery->find('first',array('conditions'=>array('JumpGallery.id'=>$UserFeed_record['UserFeed']['feed_type_target_id'],'JumpGallery.status'=>1)));
				
				$feeds['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$feeds['JumpGallery']['JumpGallery']['jump_id'],'Jump.status'=>1)));
				
			}
			else if($UserFeed_record['FeedType']['id'] == 8){
			
				$feeds['JumpGallery'] = $this->JumpGallery->find('first',array('conditions'=>array('JumpGallery.id'=>$UserFeed_record['UserFeed']['feed_type_target_id'],'JumpGallery.status'=>1)));
				
				$feeds['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$feeds['JumpGallery']['JumpGallery']['jump_id'],'Jump.status'=>1)));
			}
			else
			{
			
				$feeds['Jump'] = $this->Jump->find('first',array('conditions'=>array('Jump.id'=>$UserFeed_record['UserFeed']['feed_type_target_id'],'Jump.status'=>1)));
			}
			
			$feeds['Feedlikes'] 	= $this->like_counter($UserFeed_record['UserFeed']['id']);
			
			$feeds['FeedComments'] = $this->comment_counter($UserFeed_record['UserFeed']['id']);
			
			$feeds['FeedShare']	 = $this->UserFeed->find('count',array('conditions'=>array('UserFeed.feed_type_id'=>5,'UserFeed.parent_id'=>$UserFeed_record['UserFeed']['id'],'UserFeed.status'=>1),'order'=>'UserFeed.created DESC'));
			
			$feeds['UserFeedlike'] = $this->UserFeedLike->find('first',array('conditions'=>array('AND'=>array('UserFeedLike.user_feed_id'=>$UserFeed_record['UserFeed']['id'],'UserFeedLike.user_id'=>$this->Auth->user('id')),'UserFeedLike.status'=>1)));
			
			if($UserFeed_record['UserFeed']['parent_id'] != 0)
			{
			
				$feeds['UserFeedParentData'] = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$UserFeed_record['UserFeed']['parent_id'],'UserFeed.status'=>1),'fields'=>array('UserFeed.user_id','UserFeed.description')));
					
				$feeds['UserParentData'] = $this->User->find('first',array('conditions'=>array('User.id'=>$feeds['UserFeedParentData']['UserFeed']['user_id'],'User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.image','User.slug')));
			
			}
			
			$comments = $this->UserFeedComment->find('all',array('conditions'=>array('UserFeedComment.user_feed_id'=>$UserFeed_record['UserFeed']['id'],'UserFeedComment.status'=>1),'order'=>'UserFeedComment.created ASC'));
			
			$this->set('commentRecords',$comments);
			
			
			
			$user_record = $this->User->findById($UserFeed_record['UserFeed']['user_id']);
			
			$feeds['User']['logo'] 		 =   $user_record['User']['image'];
			$feeds['User']['name']  	 =   $user_record['User']['firstname'] .' '.$user_record['User']['lastname'];
			$feeds['User']['slug']  	 =   $user_record['User']['slug'];
			$feeds['FeedType']['title']  =   $UserFeed_record['FeedType']['title_singular'];
			
			//pr($comments); die;
			$this->set('feed_record',$feeds);
			$this->render('show_one_timeline_record','ajax');
		}		
	}
	
	public function deleteComment(){
		$comment_id = $this->request->data['comment_id']; 
		$user_id = $this->Auth->user('id');
		$this->loadModel('UserFeedComment');
		$this->loadModel('UserFeed');
		$comment_record = $this->UserFeedComment->findById($comment_id);
		$user_feed_record = $this->UserFeed->findById($comment_record['UserFeedComment']['user_feed_id']);
		if($user_feed_record['UserFeed']['user_id'] == $user_id || $comment_record['UserFeedComment']['user_id'] == $user_id)
		{ 
			$this->UserFeedComment->delete($comment_id);
			$comment_counter = $this->comment_counter($user_feed_record['UserFeed']['id']);
			$data['success'] = true;
			$data['comment_id'] = $comment_id;
			$data['comment_counter'] = $comment_counter;
			$data['user_feed_id'] = $user_feed_record['UserFeed']['id'];
			
		} 
		else
		{
			$data['success'] = false;
			
		}
		echo json_encode($data); die;
		
	}
	
	public function elite_membership_plans(){
		$this->set('left_menu_selected','Elite');
		$this->set('left_part_user_id',$this->Auth->user('id'));
		$this->loadModel('EliteMembershipPlan');
		$this->loadModel('User');
		$eliteMembershipPlan_Record =  $this->EliteMembershipPlan->find('all',array('conditions'=>array('EliteMembershipPlan.status'=>1),'order'=>'EliteMembershipPlan.created DESC'));
		foreach($eliteMembershipPlan_Record as $key => $value){
			$eliteMembershipPlan_Record[$key]['EliteMembershipPlan']['convertPrice'] = $this->convertCurrencyUSDToLocal($value['EliteMembershipPlan']['plan_price']);
		}
		$this->set('eliteMembershipPlan_Record',$eliteMembershipPlan_Record);
	}

	public function editUserFeed(){
		if($this->request->isAjax()){
			$this->loadModel('UserFeed');
			$this->UserFeed->set($this->request->data['UserFeed']);
			if($this->UserFeed->editFeedValidate()){
				$data = array();
				$data['description'] = strip_tags(trim($this->request->data['UserFeed']['description']));
				$this->UserFeed->id  = $this->request->data['UserFeed']['user_feed_id'];
				if($this->UserFeed->save($data,false)){
					$success = true;
					$message = 'You are successfully changed jump title';
					$dataResponse['resetForm'] = true;
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->UserFeed->validationErrors);
			}

			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['callBackFunction'] = 'actionAfterEditUserFeed';
			$dataResponse['description'] 	  = strip_tags(trim($this->request->data['UserFeed']['description']));
			$dataResponse['user_feed_id'] 	  = $this->request->data['UserFeed']['user_feed_id'];
			$dataResponse['message'] 		  = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function addPost(){
		if($this->request->isAjax()){
			$this->loadModel('UserFeed');
			$this->UserFeed->set($this->request->data['UserFeed']);
			if($this->UserFeed->addPostValidate()){
				//pr($this->request->data); die;
				$data = array();
				$data['description'] = strip_tags($this->request->data['UserFeed']['description']);
				$data['feed_type_id'] = 6;
				$data['user_id'] = $this->Auth->user('id');
				$data['feed_type'] = 'Feed';
				if(isset($this->request->data['UserFeed']['group_id'])){
					$data['group_id'] = $this->request->data['UserFeed']['group_id'];
				}
				$this->UserFeed->create();
				if($this->UserFeed->save($data,false)){
					$success = true;
					$message = false;
					$dataResponse['resetForm']  = true;
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->UserFeed->validationErrors);
			}

			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['callBackFunction'] = 'actionAfterTimeLineAddPost';
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function addImagePost(){
		if($this->request->isAjax()){
			$this->loadModel('UserFeed');
			$this->UserFeed->set($this->request->data['UserFeed']);
			if($this->UserFeed->addImagePost()){
				if(!empty($this->request->data['UserFeed']['image']['name'])){
					$file = $this->data['UserFeed']['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_FEED_IMAGE_PATH. time().$file['name']);
						$this->request->data['UserFeed']['image'] = time().$file['name'];
					}
				}
				$data = array();
				$data['description'] = strip_tags($this->request->data['UserFeed']['description']);
				$data['feed_type_id'] = 6;
				$data['feed_media'] = 'Image';
				$data['user_id'] = $this->Auth->user('id');
				$data['image'] = $this->request->data['UserFeed']['image'];
				$data['feed_type'] = 'Feed';
				if(isset($this->request->data['UserFeed']['group_id'])){
					$data['group_id'] = $this->request->data['UserFeed']['group_id'];
				}
				$this->UserFeed->create();
				if($this->UserFeed->save($data,false)){
					$success = true;
					$message = false;
					$dataResponse['resetForm'] = true;
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->UserFeed->validationErrors);
			}

			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			$dataResponse['callBackFunction'] = 'actionAfterTimeLineAddPost';
			echo json_encode($dataResponse); die;
		}
	}
	
	public function addVideoPost(){
		if($this->request->isAjax()){
			$this->loadModel('UserFeed');
			$this->UserFeed->set($this->request->data['UserFeed']);
			if($this->request->data['UserFeed']['video_type'] == 'Embeded')
			{
				$validates = $this->UserFeed->addVideoPost();
			}
			else
			{
				$validates = $this->UserFeed->uploadVideoValidate();
			}
			if($validates){
				$data = array();
				if($this->request->data['UserFeed']['video_type'] == 'Upload')
				{
					if(!empty($this->request->data['UserFeed']['upload_video']['name'])){
						$file = $this->data['UserFeed']['upload_video'];
						$ext = substr(strtolower(strrchr($file['name'],'.')),1);
						$arr_ext = array('WebM', 'mp4','flv');
						if(in_array($ext, $arr_ext))
						{                            
							move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_FEED_IMAGE_PATH. time().$file['name']);
							$this->request->data['UserFeed']['upload_video'] = time().$file['name'];
						}
					}
					$data['video'] = $this->request->data['UserFeed']['upload_video'];
				}
				else
				{
					$data['video']				=	$this->request->data['UserFeed']['video'];	
				}
				
				$data['description'] = strip_tags($this->request->data['UserFeed']['description']);
				$data['video_type'] = $this->request->data['UserFeed']['video_type'];
				$data['feed_type_id'] = 6;
				$data['user_id'] = $this->Auth->user('id');
				$data['feed_type'] = 'Feed';
				$data['feed_media'] = 'Video';
				if(isset($this->request->data['UserFeed']['group_id'])){
					$data['group_id'] = $this->request->data['UserFeed']['group_id'];
				}
				$this->UserFeed->create();
				if($this->UserFeed->save($data,false))
				{
					$success = true;
					$message = false;
					$dataResponse['resetForm'] = true;
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->UserFeed->validationErrors);
			}

			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['callBackFunction'] = 'actionAfterTimeLineAddPost';
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function deleteGroupPost(){
		$this->loadModel('UserFeed');
		$this->loadModel('UserFeedLike');
		$this->loadModel('UserFeedComment');
		$this->loadModel('TotalGroupMember');	
		$UserFeed_data = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$this->request->data['id'],'UserFeed.status'=>1)));
		if($UserFeed_data['UserFeed']['feed_media'] == 'Image'){
			$file = new File(ALBUM_UPLOAD_FEED_IMAGE_PATH . $UserFeed_data['UserFeed']['image'], false, 0777);
			$file->delete();
		}
		else if($UserFeed_data['UserFeed']['feed_media'] == 'Video' && $UserFeed_data['UserFeed']['video_type'] == 'Upload'){
			$file = new File(ALBUM_UPLOAD_FEED_IMAGE_PATH . $UserFeed_data['UserFeed']['video'], false, 0777);
			$file->delete();
		}
		
		if(isset($UserFeed_data) && !empty($UserFeed_data)){
			if($this->request->data['type'] == "group_timeline"){
				$GroupMemberRecord = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.user_id'=>$this->Auth->user('id'),'TotalGroupMember.is_administrator'=>'Yes','TotalGroupMember.group_id'=>$UserFeed_data['UserFeed']['group_id'])));
				if($UserFeed_data['UserFeed']['user_id'] == $this->Auth->user('id')){
				
					$this->UserFeedLike->deleteAll(array('UserFeedLike.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
					$this->UserFeedComment->deleteAll(array('UserFeedComment.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
					$this->UserFeed->delete($UserFeed_data['UserFeed']['id']);
					$data['success'] = true;
					
				}
				else if(!empty($GroupMemberRecord)){
				
					$this->UserFeedLike->deleteAll(array('UserFeedLike.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
					$this->UserFeedComment->deleteAll(array('UserFeedComment.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
					$this->UserFeed->delete($UserFeed_data['UserFeed']['id']);
					$data['success'] = true;
					
				}
				else
				{
					$data['success'] = false;
				}
			}
			else if($this->request->data['type'] == "timeline")
			{
				$this->UserFeedLike->deleteAll(array('UserFeedLike.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
				$this->UserFeedComment->deleteAll(array('UserFeedComment.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
				$this->UserFeed->deleteAll(array('UserFeed.parent_id'=>$UserFeed_data['UserFeed']['id']), false);
				$this->UserFeed->delete($UserFeed_data['UserFeed']['id']);
				$data['success'] = true;
			}
		}
		else
		{
			$data['success'] = false;
		}
		
		echo json_encode($data); die; 
	}
	
	
	public function footer(){
		$this->loadModel('Setting');
		$footers =	$this->Setting->find('first',array('fields'=>array('id','key','value'),'conditions'=>array('key'=>'Site.copyright_text')));
		return $footers;
	}
	
	public function hospitality(){
	
		// static page
		
	}	
	
	public function press(){
	
		// static page
		
	}	
	
	public function jobs(){
		$this->loadModel('Job');
		$this->Job->virtualFields = array(
			'city_name' => 'SELECT city_name FROM cities WHERE id = Job.city_code'
		);
		$this->Job->bindModel(array(
								'belongsTo' => array(
									'Country' => array(
										'className'     => 'Country',
										'order'         => '',
										'foreignKey'    => false,
										'conditions'	=> array("Job.country_code = Country.iso_code")
									),
									'JobCategory' => array(
										'className'     => 'JobCategory',
										'order'         => '',
										'foreignKey'    => 'job_category_id'
									),
								)
							));
		$order = '';
		if(isset($_GET['order']) && !empty($_GET['order'] && $_GET['order'] == 'location')){
			$order = 'Country.country_name ASC';
			$this->set('left_menu_selected','by_location');
		}
		else if(isset($_GET['order']) && !empty($_GET['order'] && $_GET['order'] == 'category')){
			$order = 'JobCategory.category_name ASC';
			$this->set('left_menu_selected','by_category');
		}
		else
		{
			$this->set('left_menu_selected','all_job');
		}
		$conditions[] = array('Job.status'=>1);
		$record = $this->Job->find('all',array('conditions'=>$conditions,'order'=>$order));
		$this->set('record',$record);
	}
	
	function formatErrors($errorsArray)
	{
		$errors = '';
		foreach ($errorsArray as $key => $validationError)
		{
		  $errors.= '<p>'.$validationError[0].'</p>';
		}
		return $errors;
	}

}
