<?php 
class JumpsController extends AppController{
	public $helper = array('Form','Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('index','index_content'));
	}
	
	
	public function index($slug = null){
		$this->loadModel('JumpGallery');
		$this->loadModel('User');
		$this->{$this->modelClass}->bindModel(array(
								'belongsTo' => array(
									'User' => array(
										'className'     => 'User',
										'order'         => '',
										'foreignKey'    => 'user_id'
									)
								)
							));
		$jump_record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1,$this->modelClass.'.is_deleted'=>'No')));
		$this->checkRecordIsNull($jump_record);
		if($jump_record['User']['is_private_profile'] == 'Yes' && $jump_record['User']['id'] != $this->Auth->user('id')){
			 throw new NotFoundException();
		}
		else
		{
			$this->set('left_part_user_id',$jump_record[$this->modelClass]['user_id']);
			$this->set('slug',$slug);
			$this->set('jumps_slug',$slug);
			$jump_details = array();
			$jump_details['title'] 			= $jump_record[$this->modelClass]['title'];
			$jump_details['description'] 	= $jump_record[$this->modelClass]['description'];
			if($jump_record[$this->modelClass]['jump_start_date'] > '2000-1-1'){
				$jump_details['jump_start_date'] = date('M d Y',strtotime($jump_record[$this->modelClass]['jump_start_date']));
			}
			else
			{
				$jump_details['jump_start_date'] = '---';
			}
			if($jump_record[$this->modelClass]['jump_end_date'] > '2000-1-1'){
				$jump_details['jump_end_date'] = date('M d Y',strtotime($jump_record[$this->modelClass]['jump_end_date']));
			}
			else
			{
				$jump_details['jump_end_date'] = '---';
			}
			$location = $jump_record[$this->modelClass]['address_line_1'].' '.$jump_record[$this->modelClass]['address_line_2'];
			if(empty(trim($location)))
			{
				$jump_details['location'] = '---';
			}
			else
			{
				$jump_details['location'] = $location;
			}
			$jump_details['jumper_detail'] 	= ucfirst($jump_record['User']['firstname']).' '.ucfirst($jump_record['User']['lastname']);
			if($jump_record[$this->modelClass]['show_map'] == 'No')
			{
				$jump_details['latitude'] = $jump_record[$this->modelClass]['latitude'];
				$jump_details['longitude'] = $jump_record[$this->modelClass]['longitude'];
			}
			
			$this->set('jump_record',$jump_details);
		}
	}
	
	
	public function index_content($slug = null){
		$this->loadModel('JumpGallery');
		$this->loadModel('User');
		if(isset($_GET['slug']))
		{
			$slug = $_GET['slug'];	
		}
		else
		{
			$slug = $this->request->data['slug'];
		}
		
		$jump_record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1)));
		$this->set('left_part_user_id',$jump_record[$this->modelClass]['user_id']);
		$this->checkRecordIsNull($jump_record);
		$this->set('slug',$jump_record[$this->modelClass]['slug']);
		
		$this->Paginator->settings = array(
			'JumpGallery'=>array(
				'conditions'=>array('JumpGallery.jump_id'=>$jump_record[$this->modelClass]['id'],'JumpGallery.status'=>1),
				'limit' => 4,
				'order' => 'JumpGallery.created DESC',
				'paramType' => 'querystring'
			)
		);
		$JumpGallery_record = $this->Paginator->paginate('JumpGallery');
		foreach($JumpGallery_record as $key => $value){
			$JumpGallery_record[$key]['JumpGallery']['User'] = $this->User->find('first',array('conditions'=>array('User.id'=>$value['JumpGallery']['uploader_id']),'fields'=>array('User.image','User.firstname','User.lastname','User.slug')));
		}
		
		$this->set('JumpGallery_record',$JumpGallery_record);
		$this->render('index_content', 'ajax');
	}
	
	public function add_jumpVideo($slug = null){
		if($this->request->is('post')){
			$this->request->data['Jump']  = $this->request->data['JumpGallery'];
			$this->{$this->modelClass}->set($this->request->data['Jump']);
			if($this->request->data[$this->modelClass]['video_type'] == 'Embeded')
			{
				$validates = $this->{$this->modelClass}->add_JumpVideo();
			}
			else
			{
				$validates = $this->{$this->modelClass}->upload_JumpVideo();
			}
			if($validates){
				$jump_record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1),'fields'=>array($this->modelClass.'.id')));
				$this->checkRecordIsNull($jump_record);
				$data = array();
				if($this->request->data[$this->modelClass]['video_type'] == 'Upload')
				{
					$this->request->data[$this->modelClass]['upload_video']['name'] = str_replace(' ','_',$this->request->data[$this->modelClass]['upload_video']['name']);
					if(!empty($this->request->data[$this->modelClass]['upload_video']['name'])){
						$file = $this->data[$this->modelClass]['upload_video'];
						$ext = substr(strtolower(strrchr($file['name'],'.')),1);
						$arr_ext = array('WebM ', 'mp4','flv');
						if(in_array($ext, $arr_ext))
						{                            
							move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_JUMP_IMAGE_PATH. time().$file['name']);
							$this->request->data[$this->modelClass]['upload_video'] = time().$file['name'];
						}
					}
					$data['video'] = $this->request->data[$this->modelClass]['upload_video'];
				}
				else
				{
					$data['video']				=	$this->request->data{$this->modelClass}['video'];	
				}
				$data['uploader_id']		=	$this->Auth->user('id');
				$data['jump_id']			=	$jump_record[$this->modelClass]['id'];
				$data['media_type']			=	'Video';
				$data['video_type']			=	$this->request->data{$this->modelClass}['video_type'];
				$data['media_title']		=	trim($this->data{$this->modelClass}['media_title']);
				$data['media_description']	=	$this->request->data{$this->modelClass}['media_description'];
				$data['status']				=	1;	 
				$this->loadModel('JumpGallery');
				$this->JumpGallery->create();
				$saveData = $this->JumpGallery->save($data,false);
				if($saveData){
					$this->loadModel('UserFeed');
					$userFeed_data = array();
					$userFeed_data['UserFeed']['user_id'] 				= $saveData['JumpGallery']['uploader_id'];
					$userFeed_data['UserFeed']['feed_type_id'] 			= 8;
					$userFeed_data['UserFeed']['feed_type_target_id'] 	= $saveData['JumpGallery']['id'];
					$this->UserFeed->save($userFeed_data);
					
					$this->loadModel('UserEarningPoint');
					$this->loadModel('EarningPointType');
					$earnPointType_id = 2;
					$user_id = $this->Auth->user('id');
					$earningPoint = $this->EarningPointType->findById($earnPointType_id);
					$earn_point = $earningPoint['EarningPointType']['points'];
					
					$earningPoint_Data = array();
					$earningPoint_Data['UserEarningPoint']['user_id']					=	$user_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_id']			=	$earnPointType_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_target_id']	=	$jump_record[$this->modelClass]['id'];
					$earningPoint_Data['UserEarningPoint']['earn_point'] = 	$earn_point;
					$this->UserEarningPoint->create();
					$this->UserEarningPoint->save($earningPoint_Data);
					
					$this->loadModel('User');
					$user = $this->User->findById($user_id,array('fields'=>'earning_points'));
					$earning_points = $user['User']['earning_points'] + $earn_point;
					$this->User->id = $user_id;
					$this->User->saveField('earning_points',$earning_points);
					
					$success = true;
					$message = 'A jump shots has been added successfully.';
					$dataResponse['selfReload'] = true;
				}
			}
			else{
			
				$errors = $this->{$this->modelClass}->validationErrors;
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function add_jumpShot($slug = null){
		if($this->request->is('post')){
			$this->request->data['Jump']  = $this->request->data['JumpGallery'];
			$this->{$this->modelClass}->set($this->request->data['Jump']);
			if($this->{$this->modelClass}->add_JumpShot()){
				$jump_record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1),'fields'=>array($this->modelClass.'.id')));
				$this->checkRecordIsNull($jump_record);
				if(!empty($this->request->data[$this->modelClass]['image']['name'])){
					$file = $this->data[$this->modelClass]['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_JUMP_IMAGE_PATH. time().$file['name']);
						$this->request->data[$this->modelClass]['image'] = time().$file['name'];
						$dataResponse['selfReload'] = true;
					}
				}
				
				$data = array();
				$data['uploader_id']		=	$this->Auth->user('id');
				$data['jump_id']			=	$jump_record[$this->modelClass]['id'];
				$data['media_type']			=	'Image';
				$data['media_title']		=	trim($this->data{$this->modelClass}['media_title']);
				$data['media_description']	=	$this->request->data{$this->modelClass}['media_description'];
				$data['image']				=	$this->request->data{$this->modelClass}['image'];	
				$data['status']				=	1;
				$this->loadModel('JumpGallery');
				$this->JumpGallery->create();
				$saveData = $this->JumpGallery->save($data,false);
				if($saveData){
					$this->loadModel('UserFeed');
					$userFeed_data = array();
					$userFeed_data['UserFeed']['user_id'] 		= $saveData['JumpGallery']['uploader_id'];
					$userFeed_data['UserFeed']['feed_type_id'] 	= 7;
					$userFeed_data['UserFeed']['feed_type_target_id'] = $saveData['JumpGallery']['id'];
					$this->UserFeed->save($userFeed_data);
					$success = true;
					$message = 'A jump shots has beem added successfully.';
					
					$this->loadModel('UserEarningPoint');
					$this->loadModel('EarningPointType');
					$earnPointType_id = 1;
					$user_id = $this->Auth->user('id');
					$earningPoint = $this->EarningPointType->findById($earnPointType_id);
					$earn_point = $earningPoint['EarningPointType']['points'];
					
					$earningPoint_Data = array();
					$earningPoint_Data['UserEarningPoint']['user_id']					=	$user_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_id']			=	$earnPointType_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_target_id']	=	$jump_record[$this->modelClass]['id'];
					$earningPoint_Data['UserEarningPoint']['earn_point'] = 	$earn_point;
					$this->UserEarningPoint->create();
					$this->UserEarningPoint->save($earningPoint_Data);
					
					$this->loadModel('User');
					$user = $this->User->findById($user_id,array('fields'=>'earning_points'));
					$earning_points = $user['User']['earning_points'] + $earn_point;
					$this->User->id = $user_id;
					$this->User->saveField('earning_points',$earning_points);
				}
			}
			else{
			
				$errors = $this->{$this->modelClass}->validationErrors;
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function my_jumps(){
		$profile_user_id = $this->Auth->User('id');
		$this->set('left_part_user_id',$profile_user_id);
		
	}
	
	public function my_jumps_content(){
		$user_id = $this->Auth->User('id');
		$this->Jump->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = Jump.city_code',
			'country' => 'SELECT country_name FROM countries WHERE iso_code = Jump.country_code'
		);
		$this->Paginator->settings = array(
				'conditions'=>array('Jump.user_id'=>$user_id,'Jump.status'=>1,'Jump.is_deleted'=>'No'),
				'limit' => 3,
				'order' => 'Jump.created desc',
				'paramType' => 'querystring'
			
		);
		
		$this->set('my_jumps_record',$this->Paginator->paginate());
		$this->render('my_jumps_content','ajax');
		
	}

	public function add_my_jump(){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$latitude = Configure::read('latitude');
		$this->set("city_latitude",$latitude);
		$longitude = Configure::read('longitude');
		$this->set("city_longitude",$longitude);
		$this->loadModel('Country');
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1),'fields'=>array('iso_code','country_name'),'order' => 'Country.country_name ASC'));
		$this->set('countries',$countries);
		$this->set('show_map','No');
		if($this->request->is('post')){
			$this->{$this->modelClass}->set($this->request->data);
			if($this->{$this->modelClass}->MyJumpAdd()){
				if(!empty($this->request->data[$this->modelClass]['image']['name'])){
					$file = $this->data[$this->modelClass]['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_JUMP_IMAGE_PATH. time().$file['name']);
						$this->request->data[$this->modelClass]['image'] = time().$file['name'];
					}
				}
				$data 						=	array();	
				$data['user_id']			=	$this->Auth->user('id');
				$data['title']				=	trim($this->request->data[$this->modelClass]['title']);
				$data['description']		=	trim($this->request->data[$this->modelClass]['description']);
				$data['latitude']			=	trim($this->request->data[$this->modelClass]['latitude']);
				$data['longitude']			=	trim($this->request->data[$this->modelClass]['longitude']);
				$data['jump_type']			=	'Jump';
				$data['address_line_1']		=	trim($this->request->data[$this->modelClass]['address_line_1']);
				$data['address_line_2']		=	trim($this->request->data[$this->modelClass]['address_line_2']);
				$data['image']				=	trim($this->request->data[$this->modelClass]['image']);
				$data['country_code']		=	trim($this->request->data[$this->modelClass]['country_code']);
				$data['state_code']			=	trim($this->request->data[$this->modelClass]['state_code']);
				$data['city_code']			=	trim($this->request->data[$this->modelClass]['city_code']); 
				$data['zipcode']			=	trim($this->request->data[$this->modelClass]['zipcode']);
				$data['show_map']			=	trim($this->request->data[$this->modelClass]['show_map']);
				$data['jump_start_date']	=	date('Y-m-d',strtotime($this->request->data{$this->modelClass}['jump_start_date']));
				$data['jump_end_date']		=	date('Y-m-d',strtotime($this->request->data{$this->modelClass}['jump_end_date']));
				$data['status']				=	1;
				$this->{$this->modelClass}->create();
				$jumpSave_record = $this->{$this->modelClass}->save($data,false);
				if($jumpSave_record){
					$this->loadModel('UserFeed');
					$userFeed_data = array();
					$userFeed_data['user_id'] 				= $data['user_id'];
					$userFeed_data['feed_type_id'] 			= 1;
					$userFeed_data['feed_type_target_id'] 	= $jumpSave_record[$this->modelClass]['id'];
					$this->UserFeed->create();
					$this->UserFeed->save($userFeed_data,false);
					$success =  true;
					$message = 'Your jump has been added successfully';
					$dataResponse['redirectURL'] =  Router::url(array('plugin'=>false,'controller'=>'jumps','action'=>'my_jumps'));
				}
			}
			else
			{
				$errors = $this->{$this->modelClass}->validationErrors;
				$success =  false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}			
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;	
		}
	}
	
	public function edit_my_jump($slug = null){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array('Jump.slug'=>$slug,'Jump.status'=>1)));
		$this->checkRecordIsNull($record);
		$this->loadModel('Country');
		$latitude = $record[$this->modelClass]['latitude'];
		$this->set("city_latitude",$latitude);
		$longitude = $record[$this->modelClass]['longitude'];
		$this->set("city_longitude",$longitude);
		$this->set('state_code',$record[$this->modelClass]['state_code']);
		$this->set('city_code',$record[$this->modelClass]['city_code']);
		$this->set('show_map',$record[$this->modelClass]['show_map']);
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1),'fields'=>array('iso_code','country_name'),'order' => 'Country.country_name ASC'));
		$this->set('countries',$countries);
		//pr($record); die;
		if($this->request->is('put') || $this->request->is('post')){
			$this->{$this->modelClass}->set($this->request->data);
			if($this->{$this->modelClass}->MyJumpEdit()){
				if(isset($this->request->data[$this->modelClass]['image']['name']) && !empty($this->request->data[$this->modelClass]['image']['name'])){
					$file = $this->data[$this->modelClass]['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_JUMP_IMAGE_PATH. time().$file['name']);
						$this->request->data[$this->modelClass]['image'] = time().$file['name'];
					}
				}
				else
				{
					$this->request->data[$this->modelClass]['image'] = $record[$this->modelClass]['image'];
				}
				$data 						=	array();	
				$data['user_id']			=	$this->Auth->user('id');
				$data['title']				=	trim($this->request->data[$this->modelClass]['title']);
				$data['description']		=	trim($this->request->data[$this->modelClass]['description']);
				$data['latitude']			=	trim($this->request->data[$this->modelClass]['latitude']);
				$data['longitude']			=	trim($this->request->data[$this->modelClass]['longitude']);
				$data['jump_type']			=	'Jump';
				$data['address_line_1']		=	trim($this->request->data[$this->modelClass]['address_line_1']);
				$data['address_line_2']		=	trim($this->request->data[$this->modelClass]['address_line_2']);
				$data['image']				=	trim($this->request->data[$this->modelClass]['image']);
				$data['country_code']		=	trim($this->request->data[$this->modelClass]['country_code']);
				$data['state_code']			=	trim($this->request->data[$this->modelClass]['state_code']);
				$data['city_code']			=	trim($this->request->data[$this->modelClass]['city_code']); 
				$data['zipcode']			=	trim($this->request->data[$this->modelClass]['zipcode']);
				$data['show_map']			=	trim($this->request->data[$this->modelClass]['show_map']);
				$data['jump_start_date']	=	date('Y-m-d',strtotime($this->request->data{$this->modelClass}['jump_start_date']));
				$data['jump_end_date']		=	date('Y-m-d',strtotime($this->request->data{$this->modelClass}['jump_end_date']));
				$data['status']				=	1;
				
				$this->{$this->modelClass}->id = $record[$this->modelClass]['id'];
				if($this->{$this->modelClass}->save($data,false)){
					$success =  true;
					$message = 'Your jump has been added successfully';
					$dataResponse['redirectURL'] =  Router::url(array('plugin'=>false,'controller'=>'jumps','action'=>'my_jumps'));
				}
			}
			else
			{
				$errors = $this->{$this->modelClass}->validationErrors;
				$success =  false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}	
			$image_name = $record[$this->modelClass]['image'];
			$this->set('image',$image_name);
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;	
		}
		if(!$this->request->data){
			$this->request->data = $record;
			$image_name = $record[$this->modelClass]['image'];
			$this->request->data[$this->modelClass]['jump_start_date'] = date('m/d/Y',strtotime($record[$this->modelClass]['jump_start_date']));
			$this->request->data[$this->modelClass]['jump_end_date'] = date('m/d/Y',strtotime($record[$this->modelClass]['jump_end_date']));
			$this->set('image',$image_name);
		}
	}
	
	public function delete_my_jump($slug = null){
		$jump_record = $this->{$this->modelClass}->find('first',array('conditions'=>array('Jump.slug'=>$slug,'Jump.status'=>1)));
		$this->checkRecordIsNull($jump_record);
		$saveData = array();
		$saveData['is_deleted'] = 'Yes';
		$this->{$this->modelClass}->id	= $jump_record[$this->modelClass]['id'];
		if($this->{$this->modelClass}->save($saveData,false)){
			$this->Session->setFlash(__('Your Jump successfully Deleted'),'success');
			$this->redirect(array('plugin'=>false,'controller'=>'jumps','action'=>'my_jumps'));
		}
	}
	
	public function photo_gallery($slug = null){
		$this->loadModel('JumpGallery');
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$jump_record = $this->Jump->find('first',array('conditions'=>array('Jump.slug'=>$slug,'Jump.status'=>1)));
		$this->checkRecordIsNull($jump_record);
		$this->set('slug',$slug);
		$JumpGallery_record = $this->JumpGallery->find('all',array('conditions'=>array('JumpGallery.jump_id'=>$jump_record['Jump']['id'],'JumpGallery.status'=>1,'JumpGallery.media_type'=>'Image'),'order'=>'JumpGallery.created DESC'));
		$this->set('photos',$JumpGallery_record);
		if($this->request->is('post')){
			$this->request->data['Jump'] = $this->request->data['JumpGallery'];
			$this->{$this->modelClass}->set($this->request->data['Jump']);
			if($this->{$this->modelClass}->photoGalleryValidate()){
				if(!empty($this->request->data['JumpGallery']['image']['name'])){
					$file = $this->request->data['JumpGallery']['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_JUMP_IMAGE_PATH. time().$file['name']);
						$this->request->data['JumpGallery']['image'] = time().$file['name'];
						$dataResponse['selfReload'] = true;
					}
				}
				
				$data 						=	array();
				$data['jump_id']			=	$jump_record[$this->modelClass]['id'];
				$data['media_title']		=	$this->request->data['JumpGallery']['media_title'];
				$data['media_description']	=	$this->request->data['JumpGallery']['media_description'];
				$data['image']				=	$this->request->data['JumpGallery']['image'];
				$data['media_type']			=	'Image';
				$data['uploader_id']		=	$this->Auth->user('id');
				$data['status']				=	1;
				$this->JumpGallery->create();
				$saveData = $this->JumpGallery->save($data,false);
				if($saveData){
					$this->loadModel('UserFeed');
					$userFeed_data = array();
					$userFeed_data['UserFeed']['user_id'] 		= $saveData['JumpGallery']['uploader_id'];
					$userFeed_data['UserFeed']['feed_type_id'] 	= 7;
					$userFeed_data['UserFeed']['feed_type_target_id'] = $saveData['JumpGallery']['id'];
					$this->UserFeed->save($userFeed_data);
					
					$this->loadModel('UserEarningPoint');
					$this->loadModel('EarningPointType');
					$earnPointType_id = 1;
					$user_id = $this->Auth->user('id');
					$earningPoint = $this->EarningPointType->findById($earnPointType_id);
					$earn_point = $earningPoint['EarningPointType']['points'];
					
					$earningPoint_Data = array();
					$earningPoint_Data['UserEarningPoint']['user_id']					=	$user_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_id']			=	$earnPointType_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_target_id']	=	$jump_record[$this->modelClass]['id'];
					$earningPoint_Data['UserEarningPoint']['earn_point'] = 	$earn_point;
					$this->UserEarningPoint->create();
					$this->UserEarningPoint->save($earningPoint_Data);
					
					$this->loadModel('User');
					$user = $this->User->findById($user_id,array('fields'=>'earning_points'));
					$earning_points = $user['User']['earning_points'] + $earn_point;
					$this->User->id = $user_id;
					$this->User->saveField('earning_points',$earning_points);
					
					$success =  true;
					$message = 'Jump photo has been added successfully';
					$dataResponse['resetForm'] = true;
					
					
				}
			}
			else
			{
				$errors = $this->{$this->modelClass}->validationErrors;
				$success =  false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}			
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;	
		}	
	}
	
	public function video_gallery($slug = null){
		$this->loadModel('JumpGallery');
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$jump_record = $this->Jump->find('first',array('conditions'=>array('Jump.slug'=>$slug,'Jump.status'=>1)));
		
		$this->checkRecordIsNull($jump_record);
		$this->set('slug',$slug);
		
		$jumpGallery_record = $this->JumpGallery->find('all',array('conditions'=>array('JumpGallery.jump_id'=>$jump_record['Jump']['id'],'JumpGallery.status'=>1,'JumpGallery.media_type'=>'Video'),'order'=>'JumpGallery.created DESC'));
		
		$this->set('videos',$jumpGallery_record);
		
		if($this->request->is('post')){
			$this->request->data['Jump']  = $this->request->data['JumpGallery'];
			$this->{$this->modelClass}->set($this->request->data['Jump']);
			if($this->request->data[$this->modelClass]['video_type'] == 'Embeded')
			{
				$validates = $this->{$this->modelClass}->add_JumpVideo();
			}
			else
			{
				$validates = $this->{$this->modelClass}->upload_JumpVideo();
			}
			if($validates){
				$data = array();
				if($this->request->data[$this->modelClass]['video_type'] == 'Upload')
				{
					if(!empty($this->request->data[$this->modelClass]['upload_video']['name'])){
						$file = $this->data[$this->modelClass]['upload_video'];
						$ext = substr(strtolower(strrchr($file['name'],'.')),1);
						$arr_ext = array('avi', 'mp4','mov');
						if(in_array($ext, $arr_ext))
						{                            
							move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_JUMP_IMAGE_PATH. time().$file['name']);
							$this->request->data[$this->modelClass]['upload_video'] = time().$file['name'];
							$dataResponse['selfReload'] = true;
						}
					}
					$data['video'] = $this->request->data[$this->modelClass]['upload_video'];
				}
				else
				{
					$data['video']				=	$this->request->data{$this->modelClass}['video'];	
				}
				$data['uploader_id']		=	$this->Auth->user('id');
				$data['jump_id']			=	$jump_record[$this->modelClass]['id'];
				$data['media_type']			=	'Video';
				$data['video_type']			=	$this->request->data{$this->modelClass}['video_type'];
				$data['media_title']		=	trim($this->data{$this->modelClass}['media_title']);
				$data['media_description']	=	$this->request->data{$this->modelClass}['media_description'];	
				$data['status']				=	1;	
				$this->loadModel('JumpGallery');
				$this->JumpGallery->create();
				$saveData = $this->JumpGallery->save($data,false);
				if($saveData){
					$this->loadModel('UserFeed');
					$userFeed_data = array();
					$userFeed_data['UserFeed']['user_id'] 		= $saveData['JumpGallery']['uploader_id'];
					$userFeed_data['UserFeed']['feed_type_id'] 	= 8;
					$userFeed_data['UserFeed']['feed_type_target_id'] = $saveData['JumpGallery']['id'];
					$this->UserFeed->save($userFeed_data);
					
					$this->loadModel('UserEarningPoint');
					$this->loadModel('EarningPointType');
					$earnPointType_id = 2;
					$user_id = $this->Auth->user('id');
					$earningPoint = $this->EarningPointType->findById($earnPointType_id);
					$earn_point = $earningPoint['EarningPointType']['points'];
					
					$earningPoint_Data = array();
					$earningPoint_Data['UserEarningPoint']['user_id']					=	$user_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_id']			=	$earnPointType_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_target_id']	=	$jump_record[$this->modelClass]['id'];
					$earningPoint_Data['UserEarningPoint']['earn_point'] = 	$earn_point;
					$this->UserEarningPoint->create();
					$this->UserEarningPoint->save($earningPoint_Data);
					
					$this->loadModel('User');
					$user = $this->User->findById($user_id,array('fields'=>'earning_points'));
					$earning_points = $user['User']['earning_points'] + $earn_point;
					$this->User->id = $user_id;
					$this->User->saveField('earning_points',$earning_points);
					
					$success = true;
					$message = 'A jump shots has beem added successfully.';
					$dataResponse['resetForm'] = true;
					$dataResponse['redirectURL'] = Router::url(array('controller'=>'jumps','action'=>'video_gallery',$slug));
				}
			}
			else{
			
				$errors = $this->{$this->modelClass}->validationErrors;
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	
	public function delete_photo(){
		if($this->request->is('ajax')){
			$this->loadModel('JumpGallery');
			$record = $this->JumpGallery->findById($this->request->data['id']);
			$image = $record['JumpGallery']['image'];
			if($record){
				$this->checkRecordIsNull($record);
				$this->loadModel('UserFeed');
				$conditions = array('UserFeed.feed_type_id'=>7,'UserFeed.feed_type_target_id'=>$this->request->data['id']);
				$this->UserFeed->deleteAll($conditions);
				$file = new File(ALBUM_UPLOAD_JUMP_IMAGE_PATH . $image, false, 0777);
				$file->delete();
				if($this->JumpGallery->delete($this->request->data['id']))
				{
					$success =  true;
				}
			}
			else
			{
				$success =  false;
			}
			$dataResponse['success'] = $success;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function delete_video(){
		if($this->request->is('ajax')){
			$this->loadModel('JumpGallery');
			$record = $this->JumpGallery->findById($this->request->data['id']);
			$video = $record['JumpGallery']['video'];
			if($record)
			{
				$this->loadModel('UserFeed');
				$conditions = array('UserFeed.feed_type_id'=>8,'UserFeed.feed_type_target_id'=>$this->request->data['id']);
				$this->UserFeed->deleteAll($conditions);
				if($record['JumpGallery']['video_type'] == 'Upload'){
					$file = new File(ALBUM_UPLOAD_JUMP_IMAGE_PATH . $video, false, 0777);
					$file->delete();
				}
				if($this->JumpGallery->delete($this->request->data['id']))
				{
					$success =  true;
				}
			}
			else
			{
				$success = false;
			}
			$dataResponse['success'] = $success;
			echo json_encode($dataResponse); die;
		}
	
	}
	
	public function my_jump_details($slug){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$jumpRecord = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1)));
		//pr($jumpRecord); die;
		$this->checkRecordIsNull($jumpRecord);
		$this->set('jumpRecord',$jumpRecord);
		$this->loadModel('Booking');
		$this->loadModel('HostJumperBooking');
		$this->loadModel('User');
		$bookingRecord = $this->Booking->find('first',array('conditions'=>array('Booking.id'=>$jumpRecord[$this->modelClass]['booking_id'],'Booking.booking_type'=>'Jump_Host','Booking.status'=>1)));
		if($bookingRecord){
			$this->loadModel('JumpHost');
			$this->loadModel('JumpHostGallery');
			$jumpHost_record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.id'=>$bookingRecord['Booking']['jump_host_id'],'JumpHost.status'=>1)));
			$jumpHost_record['JumpHost']['image'] = $this->JumpHostGallery->primaryJumpImage($jumpHost_record['JumpHost']['id']);
			$jumpHost_record['JumpHost']['image'] = $jumpHost_record['JumpHost']['image']['JumpHostGallery']['file_name'];
			$this->set('jumpHost_record',$jumpHost_record);
		}
		$this->User->virtualFields = array(
				'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
				'country' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code'
			);
		$HostJumperBooking_record = $this->HostJumperBooking->find('first',array('conditions'=>array('HostJumperBooking.jump_id'=>$jumpRecord['Jump']['id'], 'HostJumperBooking.is_cancelled' => 'No', 'HostJumperBooking.status' => 1)));
		//pr($HostJumperBooking_record); die;
		if($HostJumperBooking_record){
			$HostJumperBooking_record['HostJumper'] = $this->User->find('first',array('conditions'=>array('User.id'=>$HostJumperBooking_record['HostJumperBooking']['host_jumper_id'],'User.status'=>1)));
			$this->set('HostJumperBooking_record',$HostJumperBooking_record);
		}	
		else
		{
			$host_jumpers = $this->User->find('all',array('conditions'=>array('User.id !='=>$this->Auth->user('id'),'User.country_code'=>$jumpRecord['Jump']['country_code'],'User.is_host_jumper'=>'Yes','User.status'=>1),'order'=>'User.created DESC'));
			$this->set('host_jumpers',$host_jumpers);
		}
	}
	
	public function cancel_host_jumper($id = null){
		//Cancel Host Jumper
		$this->loadModel('HostJumperBooking');
		$this->loadModel('Jump');
		$bookingRecord = $this->HostJumperBooking->find('first',array('conditions'=>array('AND'=>array('HostJumperBooking.id'=>$id,'HostJumperBooking.buyer_id'=>$this->Auth->user('id')),'HostJumperBooking.status'=>1)));
		$this->checkRecordIsNull($bookingRecord);
		$jump_record = $this->Jump->findById($bookingRecord['HostJumperBooking']['jump_id'],array('fields'=>'Jump.slug'));
		if($bookingRecord['HostJumperBooking']['is_cancelled'] == 'No'){
			$booking_Date = $bookingRecord['HostJumperBooking']['booking_for_date'];
			$before_twoDay_date = date('Y-m-d', strtotime($booking_Date . '-'.REFUND_PAYMENT_TIME));
			$current_date = date('Y-m-d');
			if($before_twoDay_date >= $current_date){
				$str =  '0123456789';
				$rand_string = substr(str_shuffle($str),0,5); 
				$user_id = $this->Auth->user('id');
				$refund_invoice_id = time().$rand_string.'-'.$user_id;				
				
				$charges = $this->calculate_refundCharges($bookingRecord['HostJumperBooking']['paid_amount']);
				$refund_amount = $bookingRecord['HostJumperBooking']['paid_amount'] - $charges;				
				if($refund_amount < 1)
				{
					$refund_amount = 0;
				}

				$hostJumper_updateRecord = array();
				$hostJumper_updateRecord['HostJumperBooking']['is_cancelled'] = 'Yes';
				$hostJumper_updateRecord['HostJumperBooking']['cancelled_date_time'] = date('Y-m-d H:i:s',time());
				$hostJumper_updateRecord['HostJumperBooking']['refund_invoice_id'] 	= $refund_invoice_id;
				$hostJumper_updateRecord['HostJumperBooking']['refund_amount'] 	= $refund_amount;
				$this->HostJumperBooking->id = $bookingRecord['HostJumperBooking']['id'];
				$this->HostJumperBooking->save($hostJumper_updateRecord,false);
				
				$this->loadModel('UserWalletTransaction');
				$this->loadModel('User');
				$wallet_record = array();
				$wallet_record['user_id'] = $bookingRecord['HostJumperBooking']['buyer_id'];
				$wallet_record['transaction_type'] = 'Added';
				$wallet_record['invoice_id'] = $refund_invoice_id;
				$wallet_record['amount'] = $hostJumper_updateRecord['HostJumperBooking']['refund_amount'];
				$wallet_record['transaction_identifier'] = 'Host_Jumper_Refund_Amount';
				$wallet_record['comments'] = 'Host Jumper Refund Amount';
				$this->UserWalletTransaction->create();
				$wallet_savedata = $this->UserWalletTransaction->save($wallet_record,false);
				
				if($wallet_savedata){
					$this->User->updateAll(
						array('User.wallet_balance' => 'User.wallet_balance +'. $wallet_record['amount']),
						array('User.id' => $wallet_record['user_id'])
					);
					
					$available_wallet_balance = $this->User->findById($wallet_record['user_id'],array('fields'=>'User.wallet_balance'));
					$balance = $available_wallet_balance['User']['wallet_balance'];
					$this->UserWalletTransaction->updateAll(
							array('UserWalletTransaction.available_balance' => "'$balance'"),
							array('UserWalletTransaction.id' => $wallet_savedata['UserWalletTransaction']['id'])
						);
				}
				$this->Session->setFlash(__('Your Amount Successfully Refund in your wallet'),'success');
				$this->redirect(array('controller'=>'jumps','action'=>'my_jump_details',$jump_record['Jump']['slug']));
			}
			else
			{
				$this->Session->setFlash(__('Sorry! We Are Unable To Refund Your Amount'),'error');
				$this->redirect(array('controller'=>'jumps','action'=>'my_jump_details',$jump_record['Jump']['slug']));
			}
		}
		else
		{
			$this->redirect(array('controller'=>'jumps','action'=>'my_jump_details',$jump_record['Jump']['slug']));
		}
	}
	
	
	public function jumpMates(){
		$session_user_id  = $this->Auth->user('id');
		$friend_list = $this->findFriends($session_user_id);
		$jump_id  = $this->request->data['id'];
		$this->loadModel('JumpMate');
		$friends = array();
		foreach($friend_list as $key => $value){
			$friends[$key]['id'] = $value['User']['id'];
			$friends[$key]['name'] = $value['User']['firstname'].' '.$value['User']['lastname'];
			$friend_list[$key]['JumpMates'] = $this->JumpMate->find('all',array('conditions'=>array('AND'=>array('JumpMate.jump_id'=>$jump_id,'JumpMate.user_id'=>$value['User']['id']))));
			if(!empty($friend_list[$key]['JumpMates']))
			{
			
				$friends[$key]['checked'] = 'checked';
			
			}
			else
			{
			
				$friends[$key]['checked'] = '';
				
			}
			
		}
		
		$dataResponse['success'] = true;
		$dataResponse['friends'] = $friends;
		echo json_encode($dataResponse); die;
	}
	
	function createNewJumpMate(){
		if($this->request->isAjax()){
			$this->loadModel('JumpMates');
			$conditions = array('JumpMates.jump_id'=>$this->request->data['Jump']['jump_id']);
			$this->JumpMates->deleteAll($conditions);
			foreach($this->request->data['Jump']['user_id'] as $key =>$value){
				$record = array();
				$record['user_id'] = $value;
				$record['jump_id'] = $this->request->data['Jump']['jump_id'];
				$record['status']  = 1;
				$this->JumpMates->create();
				$this->JumpMates->save($record,false);
			}
			$dataResponse['success'] =  true;
			$dataResponse['message'] = 'Success! Your operation has been successfully completed.';
			echo json_encode($dataResponse); die;
		}
	}
	
	public function other_jumps(){
		$this->loadModel('User');
		$name = (isset($_GET['name'])&& $_GET['name'])?$_GET['name']:'';
		$name = trim($name);
		$this->set('jump_name',$name);
		$this->{$this->modelClass}->bindModel(array(
								'belongsTo' => array(
									'User' => array(
										'className'     => 'User',
										'order'         => '',
										'foreignKey'    => 'user_id',
										'type' => 'RIGHT',
										'conditions' => array('User.is_private_profile'=>'No')
									)
								)
							));
		 
		$this->Paginator->settings = array(
			'conditions'=>array(
						'Jump.title LIKE' => '%'.$name.'%',
						'Jump.user_id !='=>$this->Auth->user('id'),
						'Jump.status'=>1,
						'Jump.is_deleted'=>'No'
					),
			'limit' => 6,
			'order' => 'Jump.created DESC',
			'paramType' => 'querystring'
		);
		$jumps = $this->Paginator->paginate();
		$this->set('jump_record',$jumps);
		$this->set('top_menu_selected','My_Jumps');
	}
	
	public function jump_credits(){
		$this->loadModel('UserEarningPoint');
		$this->loadModel('User');
		$user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$user_id);
		$this->Paginator->settings = array(
			'UserEarningPoint'=>array(
				'conditions'=>array('UserEarningPoint.user_id'=>$user_id,'UserEarningPoint.status'=>1),
				'limit' => 10,
				'order' => 'UserEarningPoint.created DESC',
				'paramType' => 'querystring'
			)
		);
		$this->set('earn_data',$this->Paginator->paginate('UserEarningPoint'));
		$totalEarnPoints = $this->User->findById($user_id,array('fields'=>'earning_points'));
		$this->set('totalEarnPoints',$totalEarnPoints);
		$this->set('left_menu_selected','credits');
	}
	
	public function reddem_point(){
		$this->loadModel('User');
		$user_id = $this->Auth->user('id');
		$user_record = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id,'User.status'=>1),'fields'=>array('User.id','User.earning_points','User.wallet_balance')));
		$total_earning_points = $user_record['User']['earning_points'];
		$one_usd_to_jump_credits  = configure::read('Site.1_usd_to_jump_credits');
		if($total_earning_points >= $one_usd_to_jump_credits)
		{
			$reddem_amount = floor($total_earning_points / $one_usd_to_jump_credits); 
			$reedem_point  = $reddem_amount * $one_usd_to_jump_credits;
			$transfer_points_into_jump_credits = $total_earning_points - $reedem_point;
			
			$this->loadModel('UserEarningPoint');
			$earningPoint_Data = array();
			$earningPoint_Data['UserEarningPoint']['user_id']			=	$user_id;
			$earningPoint_Data['UserEarningPoint']['earn_point'] 		= 	$reedem_point;
			$earningPoint_Data['UserEarningPoint']['transaction_type'] 	= 	'Removed';
			$this->UserEarningPoint->create();
			$saveRecord = $this->UserEarningPoint->save($earningPoint_Data);
			
			$this->User->id = $user_id;
			$this->User->saveField('earning_points',$transfer_points_into_jump_credits);
			
			$this->loadModel('UserWalletTransaction');
			$str =  '0123456789';
			$rand_string = substr(str_shuffle($str),0,5); 
			$user_id = $this->Auth->user('id');
			$invoice_id = time().$rand_string.'-'.$user_id;
			$wallet_record = array();
			$wallet_record['user_id'] = $user_id;
			$wallet_record['transaction_type'] = 'Added';
			$wallet_record['invoice_id'] = $invoice_id;
			$wallet_record['amount'] = $reddem_amount;
			$wallet_record['transaction_identifier'] = 'Redeem_Jump_Credits';
			$wallet_record['comments'] = 'Redeem Jump Credits';
			$this->UserWalletTransaction->create();
			$wallet_savedata = $this->UserWalletTransaction->save($wallet_record,false);
			
			$this->User->id = $user_id;
			$wallet_balance = $user_record['User']['wallet_balance'] + $reddem_amount;
			$this->User->saveField('wallet_balance',$wallet_balance);
			
			$this->UserWalletTransaction->id = $wallet_savedata['UserWalletTransaction']['id'];
			$this->UserWalletTransaction->saveField('available_balance',$wallet_balance);
	
			$data['success'] = true;
		}
		else
		{
			$data['success'] = false;
			$data['error_type'] = 'insufficient_balance';
			$data['message'] = 'You have a insufficient Jump credits for Redeem';
		}
		
		echo json_encode($data); die;
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
