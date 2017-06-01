<?php
class UsersController extends AppController{
	public $helper = array('Form','Html');
	public $components = array('Hybridauth');	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('forgot_password','resetpassword','change_password','invalid_reset_link','profile','social_login','social_endpoint','add_friend','user_profile_for_left','profile_content','invite_friend_registration'));
	}
	public function login(){	
		if ($this->request->is('post'))
		{
			$this->{$this->modelClass}->set($this->request->data);
			if ($this->{$this->modelClass}->login_validation()){
				if ($this->Auth->login())
				{
					$success = true;
					$error = false;
					$message = 'Please wait ...';
					$dataResponse['redirectURL'] =  $this->webroot;
				}
				else
				{
					$user = $this->{$this->modelClass}->findByEmail($this->request->data[$this->modelClass]["email"]);
					if (empty($user)) {
						$success = false;
						$error = true;
						$message = 'This email is not registered with us.';
					} else if ($user[$this->modelClass]["is_email_verified"] == 0) {
						
						$error = true;
						$success = false;
						$message = 'Your email is not verified. Please verify your email before login.';
					} else if ($user[$this->modelClass]["status"] == 0) {
						
						$error = true;
						$success = false;
						$message = 'Your account is deactivated. Please contact our team to reactive your account';
					} else {
						
						$error = true;
						$success = false;
						$message = 'Invalid e-mail / password combination. Please try again';
					}
				}
			}else{
				$error = true;
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			
			}
			$dataResponse['message'] = $message;
			$dataResponse['success'] = $success;
			$dataResponse['error'] = $error;
			echo json_encode($dataResponse); die;
		}
	}

	public function mobile_login(){	
		if ($this->request->is('post'))
		{
			$this->{$this->modelClass}->set($this->request->data);
			if ($this->{$this->modelClass}->login_validation()){
				if ($this->Auth->login())
				{
					$success = true;
					$error = false;
					$message = 'Please wait ...';
					$dataResponse['redirectURL'] =  $this->webroot;
				}
				else
				{
					$user = $this->{$this->modelClass}->findByEmail($this->request->data[$this->modelClass]["email"]);
					if (empty($user)) {
						$success = false;
						$error = true;
						$message = 'This email is not registered with us.';
					} else if ($user[$this->modelClass]["is_email_verified"] == 0) {
						
						$error = true;
						$success = false;
						$message = 'Your email is not verified. Please verify your email before login.';
					} else if ($user[$this->modelClass]["status"] == 0) {
						
						$error = true;
						$success = false;
						$message = 'Your account is deactivated. Please contact our team to reactive your account';
					} else {
						
						$error = true;
						$success = false;
						$message = 'Invalid e-mail / password combination. Please try again';
					}
				}
			}else{
				$error = true;
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			
			}
			$dataResponse['message'] = $message;
			$dataResponse['success'] = $success;
			$dataResponse['error'] = $error;
			echo json_encode($dataResponse); die;
		}
	}

	
	public function forgot_password(){
		if($this->request->is('post')){
			$this->{$this->modelClass}->set($this->data);
			if ($this->{$this->modelClass}->forget_password()){
				$record = $this->{$this->modelClass}->find('first',array('conditions'=>array('User.email'=>$this->request->data['User']['email'],'User.is_email_verified'=>1,'User.status'=>1)));
				if($record){
					$email = $record['User']['email'];
					$firstname = $record['User']['firstname'];
					$lastname = $record['User']['lastname'];
					$id = $record['User']['id'];
					$str = '0123456789abcdefghijklmnopqrstuvwxyz';
					$verification_code = substr(str_shuffle($str),0,20);
					$this->loadModel('UserPasswordReset');
					$data = array();
					$data['UserPasswordReset']['user_id'] =  $id;
					$data['UserPasswordReset']['verification_code'] =  $verification_code;
					$expiry_date = strtotime('+2 Days',time());
					$data['UserPasswordReset']['expire_time'] = $expiry_date;
					if($this->UserPasswordReset->save($data,false)){
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
						$this->loadModel('EmailTemplate');
						$record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"forgot_password",'EmailTemplate.status'=>1)));
						if(isset($record) && !empty($record)){
							$body = $record['EmailTemplate']['body'];
							$reset_url = WEBSITE_URL . "users/resetpassword/" . $verification_code;
							$reset_link = '<a href="' . $reset_url . '">Click Here</a>';
							$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
							$site_title = Configure::read("Site.title");
							$string = str_replace('{#logo}',$logo,$body);
							$string = str_replace('{#first_name}',$firstname,$string);
							$string = str_replace('{#site_title}',$site_title,$string);
							$string = str_replace('{#lastname}',$lastname,$string);
							$string = str_replace('{#full_name}',$firstname.' '.$lastname,$string);
							$string = str_replace('{#email}',$email,$string);
							$string = str_replace('{#reset_link}',$reset_link,$string);
							$Email->delivery = "smtp";
							$Email->from = MAIL_FROM;
							$Email->to = $email;
							$Email->subject = $record['EmailTemplate']['subject'];
							//$Email->template = 'dfg';
							$Email->sendAs = 'html';
							$dataResponse = array();
							if($Email->send($string))
							{ 
								$success = true;
								$message = 'Please Check your email for Reset Password';
								$dataResponse['resetForm'] = true;
								//$dataResponse['redirectURL'] =  $this->webroot;
							}
							else
							{
								$message = 'Failed to Send Mail';
								$success = false;
							}
						}
						else
						{
							$message = 'Failed to Send Mail..Please try agin later';
							$success = false;
						}
					}
				}
				else{
				
					$success = false;
					$message = 'This Email Address Does Not Exist';
				}
			}
			else{
			
				$errors = $this->{$this->modelClass}->validationErrors;
				$success = false;
				$message = $errors['email'];
			}			
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;	
		}
	}

	function resetpassword($verification_code){
		if($this->Auth->login()){
			$this->redirect(array('controller'=>'welcomes','action'=>'index'));
		}
		$this->loadModel('UserPasswordReset');
		$record = $this->UserPasswordReset->find('first',array('conditions'=>array('UserPasswordReset.verification_code'=>$verification_code)));
		$this->set('record',$record);
		if($record){
			$user_id = $record['UserPasswordReset']['user_id'];
			if($this->request->is('post')){
				$this->{$this->modelClass}->set($this->data);
				if ($this->{$this->modelClass}->reset_password()){
					$this->User->id = $user_id;
					$data = array();
					$data['password'] = AuthComponent::password($this->data{$this->modelClass}['password']);
					if($this->User->save($data,false)){
						$this->loadModel('UserPasswordReset');
						$conditions = array('UserPasswordReset.user_id'=>$user_id);
						$this->UserPasswordReset->deleteAll($conditions,false);
						$success = true;
						$message = 'Your Password Successfully Changed';
						$dataResponse['resetForm'] = true;
						$dataResponse['redirectURL'] = $this->webroot;
						
					}
				}
				else
				{
					$success = false;
					$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
				}
				$dataResponse['success'] = $success;
				$dataResponse['scrollToThisForm'] = true;
				$dataResponse['message'] = $message;
				echo json_encode($dataResponse); die;
			}
		}
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
	
	public function profile($slug = null)
	{
		if(!$slug && isset($this->request->slug))
		{
			$slug = $this->request->slug;
		}
		if(!isset($slug) && empty($slug)){
			$this->redirect(array('controller'=>'users','action'=>'login'));
		}
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1)));
		$this->checkRecordIsNull($record);
		
		$profile_user_id = $record[$this->modelClass]['id'];
		$this->set('left_part_user_id',$profile_user_id);
		$this->set('user_slug',$slug);
		$this->set('top_menu_selected','My_Jumps');
	}
	
	public function profile_content(){
		//pr($this->request->data); die;
		if(isset($_GET['slug']))
		{
			$slug = $_GET['slug'];	
		}
		else
		{
			$slug = $this->request->data['slug'];
		}
		$this->set('slug',$slug);
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1)));
		if($record[$this->modelClass]['is_private_profile'] == 'Yes' && $record[$this->modelClass]['id'] != $this->Auth->user('id')){
			$this->set('jump_record','');
		}
		else
		{
			$this->checkRecordIsNull($record);
			$profile_user_id = $record[$this->modelClass]['id'];
			$this->loadModel('Jump');
			$this->Paginator->settings = array(
				'Jump'=>array(
					'conditions'=>array('Jump.user_id'=>$profile_user_id,'Jump.status'=>1,'Jump.is_deleted'=>'No'),
					'limit' => 4,
					'order' => 'Jump.created desc',
					'paramType' => 'querystring'
				)
			);
			$jump_record = $this->Paginator->paginate('Jump');
			if($jump_record){
				foreach($jump_record as $key => $value){
				   $jump_record[$key]['Jump']['logo'] = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.id'=>$value['Jump']['user_id']),'fields'=>array($this->modelClass.'.image',$this->modelClass.'.firstname',$this->modelClass.'.lastname')));
				}
			}
			
			$this->set('jump_record',$jump_record);
		}
		$this->render('profile_content','ajax');
	}
	
	
	public function elite()
	{
		$this->set('left_menu_selected','Elite');
		$this->loadModel('User');
		$user_id = $this->Auth->User('id');
		$elite_mebership_status = $this->User->findById($user_id);
		if($elite_mebership_status['User']['elite_membership_status'] == 'Active'){
			$profile_user_id = $user_id;
			$this->set('left_part_user_id',$profile_user_id);
			$date = array();
			$date['current_date'] = date('Y-m-d');
			$date['current_date_to_six_month'] = date('Y-m-d',strtotime('+6 month', time()));
			$date['date_after_six_month'] = date('Y-m-d',strtotime('+6 month', time()));
			$date['date_after_six_to_twelve_month'] = date('Y-m-d',strtotime('+12 month', time()));
			$this->set('date',$date);
			$this->set('elite_membership_expire_date',$elite_mebership_status['User']['elite_membership_expire_date']);
		}
		else 
		{
			$this->redirect(array('controller'=>'welcomes','action'=>'elite_membership_plans'));
		}
	}
	
	public function elite_content(){
		$this->loadModel('EliteOffer');
		$this->loadModel('JumpHostGallery');
		$this->loadModel('JumpHostReview');
		$this->EliteOffer->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = JumpHost.city_code'
		);
		$limit = 1000;
		//pr($this->request->data); die;
		$this->Paginator->settings = array(
			'EliteOffer'=>array(
				'conditions'=>array('AND'=>array('EliteOffer.offer_start_date_time >='=> $this->request->data['start_date'],'EliteOffer.offer_start_date_time <='=> $this->request->data['end_date'],'EliteOffer.offer_end_date_time >='=> $this->request->data['start_date']),'EliteOffer.status'=>1),
				'limit' => $limit,
				'order' => 'EliteOffer.created desc',
				'paramType' => 'querystring'
			)
		);
		$eliteoffer_record = $this->Paginator->paginate('EliteOffer');
		if(isset($eliteoffer_record) && !empty($eliteoffer_record)){
			$record = array();
			foreach($eliteoffer_record as $key => $value){
				if($value['JumpHost']['is_deleted'] == 'Yes' || $value['JumpHost']['status'] == 0)
				{
					$data['success'] = false;
				}
				else
				{
					$eliteoffer_record[$key]['JumpHost']['rating'] = $this->JumpHostReview->find('all',array('conditions'=>array('JumpHostReview.jump_host_id'=>$value['JumpHost']['id'],'status'=>1),'fields'=>array('rating')));
					$count = 0;
					$i = 0;
					if($eliteoffer_record[$key]['JumpHost']['rating'])
					{
						foreach($eliteoffer_record[$key]['JumpHost']['rating'] as $key1 => $value1){
							$i++;
							$count = $value1['JumpHostReview']['rating'] + $count;
						}
						$record[$key]['rating'] = $count / $i ;
					}
					else
					{
						$record[$key]['rating'] = 0;
					}

					$eliteoffer_record[$key]['JumpHost']['image'] = $this->JumpHostGallery->primaryJumpImage($value['EliteOffer']['jump_host_id']);
					$eliteoffer_record[$key]['JumpHost']['image'] = $eliteoffer_record[$key]['JumpHost']['image']['JumpHostGallery']['file_name'];	
					$record[$key]['elite_id'] 		= $value['EliteOffer']['id'];
					$record[$key]['slug'] 			= $value['EliteOffer']['slug'];
					$record[$key]['jump_host_id'] 	= $value['EliteOffer']['jump_host_id'];
					$record[$key]['title']		 	= $this->showLimitedText($value['EliteOffer']['title'],29);
					$record[$key]['description'] 	= $value['EliteOffer']['description'];
					$record[$key]['valid_days'] 	= $value['EliteOffer']['valid_days'];
					$record[$key]['city']			= $value['EliteOffer']['city'];
					$record[$key]['city_code'] 		= $value['JumpHost']['city_code'];
					$record[$key]['price'] 			= $value['JumpHost']['price'];
					$record[$key]['total_price']	= round($value['EliteOffer']['total_price']);
					$record[$key]['image'] 			= $eliteoffer_record[$key]['JumpHost']['image'];
					$record[$key]['total_pri'] 		= $value['JumpHost']['price'] * $value['EliteOffer']['valid_days'];
					$record[$key]['diff_price']		= $record[$key]['total_pri'] - $value['EliteOffer']['total_price']; 
					$record[$key]['off_percent']	= $record[$key]['diff_price'] / $record[$key]['total_pri'] *100; 
					$record[$key]['off_percent']	= round($record[$key]['off_percent']);
					$record[$key]['search_url']		= WEBSITE_URL.'elites/detail/'.$record[$key]['slug'];
					$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
					$file_name		=	$eliteoffer_record[$key]['JumpHost']['image'];
					$base_encode 	=	base64_encode($file_path);
					if($file_name && file_exists($file_path . $file_name)) 
					{
						$record[$key]['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/470/348/'. $base_encode.'/'.$file_name;
					}	
					else
					{
						$record[$key]['image_url'] = '';
					}
					//pr($record); die;
					$data['success'] = true;
					$data['eliteoffer_record'] = $record;
				}
			}
		}
		else 
		{
			$data['success'] = false;
		}
		echo json_encode($data); die; 
	}
	
	public function user_profile_for_left($user_id = null)
	{
		$this->{$this->modelClass}->virtualFields = array(
			'country_name' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code', 
			'state_name' => 'SELECT state_name FROM states WHERE iso_code = User.state_code',
			'city_name' => 'SELECT city_name FROM cities WHERE id = User.city_code'
		);
		$data = array();
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array('id'=>$user_id)));
		$profile_user_id = $record[$this->modelClass]['id'];
		$userData = $record['User'];
		$this->checkRecordIsNull($userData);
		$this->loadModel('Friend');
		$this->loadModel('FriendRequest');
		$friend_record = $this->Friend->find('first',
												array('conditions'=>array(
															'OR' =>
																array(
																	array(
																	'AND'=>array('Friend.user_id_1'=>$this->Auth->user('id'),'Friend.user_id_2'=>$profile_user_id)
																	),
																array(
																	'AND'=>array('Friend.user_id_2'=>$this->Auth->user('id'),'Friend.user_id_1'=>$profile_user_id)
																	)
																)),
														'fields'=>array('id')));
														
		$friend_request_sent = $this->FriendRequest->find('first',array('conditions'=>array('FriendRequest.sender_id'=>$this->Auth->user('id'),'FriendRequest.receiver_id'=>$profile_user_id),'fields'=>array('id')));
		
		
		$friend_list = $this->Friend->find('all',array('conditions'=>array('OR'=>array('Friend.user_id_1'=>$profile_user_id,'Friend.user_id_2'=>$profile_user_id),'Friend.status'=>1),'order'=>'Friend.created DESC','limit'=>6));
		if($friend_list){
			$friends = array();
			foreach($friend_list as $key => $value)
			{
				if($value['Friend']['user_id_1'] != $profile_user_id)
				{
					$friend_id = $value['Friend']['user_id_1'];
				}
				else
				{
					$friend_id = $value['Friend']['user_id_2'];
				}
				$friend_list_record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.id'=>$friend_id),'fields'=>array('image','slug','firstname','lastname','id')));
				$friends[$key] =  $friend_list_record;
			}
			$data['friends'] =  $friends;
		}
		
		$data['profile_user_id'] =  $profile_user_id;
		$data['userData'] =  $userData;
		$data['friend_record'] =  $friend_record;
		$data['friend_request_sent'] =  $friend_request_sent;
		//pr($data); die;
		return $data;	
	}
	
	public function jump_mates(){
		$user_id  = $this->Auth->user('id');
		$this->set('left_part_user_id',$user_id);
		$this->loadModel('User');
		$this->User->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
			'country' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code'
		);
		$friends = $this->findFriends($user_id);
		$this->loadModel('FriendRequest');
		$this->FriendRequest->bindModel(array(
								'belongsTo' => array(
									'Sender' => array(
										'className'     => 'User',
										'order'         => '',
										'foreignKey'    => 'sender_id'
									)
								)
							));
		$friends_requests = $this->FriendRequest->find('all',array('conditions'=>array('FriendRequest.receiver_id'=>$user_id)));
		$this->set('friends',$friends);
		$this->set('friends_requests',$friends_requests);
	}
	
	public function send_friend_request(){
		if($this->Auth->user()){
			$id = $this->request->data['id']; 
			$profile_user = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.id'=>$id,$this->modelClass.'.status'=>1),'fields'=>array($this->modelClass.'.id',$this->modelClass.'.slug')));
			$this->checkRecordIsNull($profile_user);
			$sender_id = $this->Auth->user('id');
			$receiver_id = $profile_user[$this->modelClass]['id'];
			if($receiver_id != $sender_id){
				$this->loadModel('FriendRequest');
				$this->loadModel('Friend');
				$is_friend_request = $this->FriendRequest->find('first',array('conditions'=>array('FriendRequest.sender_id' => $receiver_id,'FriendRequest.receiver_id' => $sender_id)));
				if(isset($is_friend_request) && !empty($is_friend_request)){
					$data = array();
					$data['user_id_1'] = $sender_id;
					$data['user_id_2'] = $receiver_id;	
					$this->Friend->create();
					$this->Friend->save($data,false);
					$this->FriendRequest->delete($is_friend_request['FriendRequest']['id']);
					$session_user = $this->{$this->modelClass}->findById($this->Auth->User('id'));
					$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
					$file_name		=	$session_user[$this->modelClass]['image'];
					$base_encode 	=	base64_encode($file_path);
					if($file_name && file_exists($file_path . $file_name)) 
					{
						$dataResponse['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/40/41/'. $base_encode.'/'.$file_name;
					}	
					else
					{
						$dataResponse['image_url'] = '';
					}
					$dataResponse['name'] = ucfirst($session_user[$this->modelClass]['firstname']).' '.ucfirst($session_user[$this->modelClass]['lastname']);
					$dataResponse['user_id']  	= $this->Auth->user('id');
					$dataResponse['slug'] 		= $session_user[$this->modelClass]['slug'];
					$dataResponse['success'] = true;
					$dataResponse['friends'] = true;
				}
				else
				{	
					$data = array();
					$data['sender_id'] = $sender_id;
					$data['receiver_id'] = $receiver_id;
					$data['status']	   = 1;
					$this->FriendRequest->create();
					$this->FriendRequest->save($data,false);
					$dataResponse['success'] = true;
				}
			}
			else
			{
				$dataResponse['success'] = false;
				$dataResponse['error_type'] = 'same_profile';
				$dataResponse['message'] = 'You cannot send friend request yourself';
				
			}
		}
		else
		{
			$dataResponse['success'] = false;
			$dataResponse['error_type'] = 'auth';
			$dataResponse['redirectURL'] = Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'login'));
			
		}
		echo json_encode($dataResponse); die;
	}
	
	public function confirm_friend_request(){
		$this->loadModel('FriendRequest');
		$this->loadModel('Friend');
		$friend_request_id = $this->request->data['id']; 
		$record = $this->FriendRequest->findById($friend_request_id);
		if(!empty($record)){
			$data = array();
			$data['user_id_1'] = $record['FriendRequest']['sender_id'];
			$data['user_id_2'] = $record['FriendRequest']['receiver_id'];	
			$this->Friend->create();
			$this->Friend->save($data,false);
			$this->FriendRequest->delete($friend_request_id);
			$dataResponse['success'] = true;
		}
		else
		{
			$dataResponse['success'] = false;
		}
		echo json_encode($dataResponse); die;	
	}
	
	public function delete_friend_request(){
		$this->loadModel('FriendRequest');
		$friend_request_id = $this->request->data['id']; 
		$record = $this->FriendRequest->findById($friend_request_id);
		if(!empty($record)){
			$this->FriendRequest->delete($friend_request_id);
			$dataResponse['success'] = true;
		}
		else
		{
			$dataResponse['success'] = false;
		}
		echo json_encode($dataResponse); die;	
	}
	
	public function add_friend(){
		if($this->Auth->user()){
			$id = $this->request->data['id'];
			$user_record = $this->{$this->modelClass}->findById($id);
			$this->checkRecordIsNull($user_record);
			if($user_record[$this->modelClass]['id'] != $this->Auth->user('id')){
				$this->loadModel('Friend');
				$record = $this->Friend->find('first',array('conditions'=>array('AND'=>array('Friend.user_id_1'=>$this->Auth->user('id'),'Friend.user_id_2'=>$user_record[$this->modelClass]['id']))));
				$session_user = $this->{$this->modelClass}->findById($this->Auth->User('id'));
				if(!$record){
					$data = array();
					$data['user_id_1'] = $this->Auth->user('id');
					$data['user_id_2'] = $user_record[$this->modelClass]['id'];
					$data['status']	   = 1;
					$this->Friend->create();
					$this->Friend->save($data);
					$dataResponse['success'] = true;
					$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
					$file_name		=	$session_user[$this->modelClass]['image'];
					$base_encode 	=	base64_encode($file_path);
					if($file_name && file_exists($file_path . $file_name)) 
					{
						$dataResponse['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/40/41/'. $base_encode.'/'.$file_name;
					}	
					else
					{
						$dataResponse['image_url'] = '';
					}
					$dataResponse['name'] = $session_user[$this->modelClass]['firstname'].' '.$session_user[$this->modelClass]['lastname'];
					$dataResponse['user_id']  	= $this->Auth->user('id');
					$dataResponse['slug'] 		= $session_user[$this->modelClass]['slug'];
				}
			}
			else
			{
				$dataResponse['success'] = false;
				$dataResponse['error_type'] = 'same_profile';
				$dataResponse['message'] = 'You cannot make a friend yourself';
			}
		}
		else
		{
			$dataResponse['success'] = false;
			$dataResponse['error_type'] = 'auth';
			$dataResponse['redirectURL'] = Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'login'));
			
		}
		
	}
	
	public function remove_friend(){
		if($this->Auth->user()){
			$this->loadModel('Friend');
			$profile_user_id = $this->request->data['id'];
			$friend_record = $this->Friend->find('first',
												array('conditions'=>array(
															'OR' =>
																array(
																	array(
																	'AND'=>array('Friend.user_id_1'=>$this->Auth->user('id'),'Friend.user_id_2'=>$profile_user_id)
																	),
																array(
																	'AND'=>array('Friend.user_id_2'=>$this->Auth->user('id'),'Friend.user_id_1'=>$profile_user_id)
																	)
																)),
														'fields'=>array('id')));
			$this->checkRecordIsNull($friend_record);
			$friend_id = $friend_record['Friend']['id'];
			$this->Friend->delete($friend_id);
			$friend_count = $this->Friend->find('count',array('conditions'=>array('OR'=>array('Friend.user_id_1'=>$profile_user_id,'Friend.user_id_2'=>$profile_user_id))));
			$dataResponse['success'] = true;
			$dataResponse['user_id'] = $this->Auth->user('id');
			$dataResponse['friends'] = $friend_count;
			
				
		}
		else
		{
			$dataResponse['success'] = false;
		}
		echo json_encode($dataResponse); die;
	}	
	
	public function send_money($profile_user_id = null){
		if($this->request->is('post')){
			$user = $this->Auth->user();
			$this->request->data[$this->modelClass] = $this->request->data['UserSentAmount'];
			$this->{$this->modelClass}->set($this->data);
			if ($this->{$this->modelClass}->sendMoneyAmount()){
				$this->loadModel('UserSentAmount');
				$this->loadModel('UserWalletTransaction');
				$amount = $this->request->data['UserSentAmount']['amount'];
				if($user['wallet_balance'] >= $amount){
					$str =  '0123456789';
					$rand_string = substr(str_shuffle($str),0,5); 
					$user_id = $user['id'];
					$invoice_user_id = time().$rand_string.'-'.$user_id;
					$invoice_profile_user_id = time().$rand_string.'-'.$profile_user_id;
					$record = array();
					$record['invoice_id'] = $invoice_user_id;
					$record['sender_id']  = $user['id'];
					$record['receiver_id'] = $profile_user_id;
					$record['amount'] = $amount;
					$record['status'] = 1;
					
					if($this->UserSentAmount->save($record,false)){
						$this->{$this->modelClass}->updateAll(
							array('User.wallet_balance' => 'User.wallet_balance -'. $amount),
							array('User.id' => $user['id'])
						);
						$this->{$this->modelClass}->updateAll(
							array('User.wallet_balance' => 'User.wallet_balance +'. $amount),
							array('User.id' => $profile_user_id)
						);
						
						$wallet_record = array();
						$wallet_record['user_id'] = $user['id'];
						$wallet_record['transaction_type'] = 'Removed';
						$wallet_record['invoice_id'] = $invoice_user_id;
						$wallet_record['amount'] = $amount;
						$wallet_record['transaction_identifier'] = 'Transfer';
						$wallet_record['comments'] = 'Send to friend';
						$this->UserWalletTransaction->create();
						$user_transaction_data = $this->UserWalletTransaction->save($wallet_record,false);
						$wallet_record1 = array();
						$wallet_record1['user_id'] = $profile_user_id;
						$wallet_record1['transaction_type'] = 'Added';
						$wallet_record1['invoice_id'] = $invoice_profile_user_id;
						$wallet_record1['amount'] = $amount;
						$wallet_record1['transaction_identifier'] = 'Transfer';
						$wallet_record1['comments'] = 'Recieve money from a friend ';
						$this->UserWalletTransaction->create();
						$profile_transaction_data = $this->UserWalletTransaction->save($wallet_record1,false);
						$user_data = $this->{$this->modelClass}->findById($user_transaction_data['UserWalletTransaction']['user_id'],array('fields'=>'wallet_balance'));
						$profile_user_data = $this->{$this->modelClass}->findById($profile_transaction_data['UserWalletTransaction']['user_id'],array('fields'=>'wallet_balance'));
						
						$this->UserWalletTransaction->updateAll(
							array('UserWalletTransaction.available_balance' => $user_data[$this->modelClass]['wallet_balance']),
							array('UserWalletTransaction.id' => $user_transaction_data['UserWalletTransaction']['id'])
						);
						
						$this->UserWalletTransaction->updateAll(
							array('UserWalletTransaction.available_balance' => $profile_user_data[$this->modelClass]['wallet_balance']),
							array('UserWalletTransaction.id' => $profile_transaction_data['UserWalletTransaction']['id'])
						);
							
						$success = true;
						$dataResponse['resetForm'] = true;
						$message = 'Success! Your tarnsaction successfully completed';
					}
					else{
						$success = false;
						$message = 'Error!';
					}
				}
				else{
					$success = false;
					$message = 'You have a insufficient balance for send jumponey';
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
		
	}
	public function my_accounts(){
		$id = $this->Auth->user('id');
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.id'=>$id)));
		$this->set('state_code',$record[$this->modelClass]['state_code']);
		$this->set('city_code',$record[$this->modelClass]['city_code']);
		$this->loadModel('Country');
		$this->loadModel('Language');
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1),'fields'=>array('iso_code','country_name'),'order' => 'Country.country_name ASC'));
		$languages = $this->Language->find('list',array('fields'=>array('language_code','name')));
		$this->set('countries',$countries);
		$this->set('languages',$languages);
		$this->set('id',$id);
		$getYear = date("Y",strtotime("-21 year"));
		$getDate = '12/31/'.$getYear;
		$this->set('getDate',$getDate);
		if($this->request->is('post') || $this->request->is('put')){	
			$this->{$this->modelClass}->set($this->request->data);
			if($this->{$this->modelClass}->basic_information_validate()){
				if(!empty($this->request->data[$this->modelClass]['image']['name'])){
					$file = $this->data[$this->modelClass]['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_IMAGE_PATH. time().$file['name']);
						$this->request->data[$this->modelClass]['image'] = time().$file['name'];
						$file = new File(ALBUM_UPLOAD_IMAGE_PATH . $record[$this->modelClass]['image'], false, 0777);
						$file->delete();
						$dataResponse['selfReload'] = true;
					}
				}else{
					$this->request->data[$this->modelClass]['image'] = $record[$this->modelClass]['image'];
				}
				//pr($this->request->data); die;
				$this->{$this->modelClass}->id = $record[$this->modelClass]['id'];
				$data[$this->modelClass]['firstname']		=	trim($this->request->data{$this->modelClass}['firstname']);
				$data[$this->modelClass]['lastname']		=	trim($this->request->data{$this->modelClass}['lastname']);
				$data[$this->modelClass]['country_code']	=	$this->request->data{$this->modelClass}['country_code'];
				$data[$this->modelClass]['state_code']		=	$this->request->data{$this->modelClass}['state_code'];
				$data[$this->modelClass]['city_code']		=	$this->request->data{$this->modelClass}['city_code'];
				$data[$this->modelClass]['zipcode']			=	trim($this->request->data{$this->modelClass}['zipcode']);
				$data[$this->modelClass]['address']			=	trim($this->request->data{$this->modelClass}['address']);
				$data[$this->modelClass]['image']			=	$this->request->data{$this->modelClass}['image'];
				$data[$this->modelClass]['language_code']	=	$this->request->data{$this->modelClass}['language_code'];
				$data[$this->modelClass]['about_me']		=	$this->request->data{$this->modelClass}['about_me'];
				$data[$this->modelClass]['dob']				=	date('Y-m-d',strtotime($this->request->data{$this->modelClass}['dob']));
				$data[$this->modelClass]['slug']			=	$this->request->data{$this->modelClass}['slug'];
				if($this->{$this->modelClass}->save($data,false)){
					$success = true;
					$message = 'Your Account Has Been Updated Successfully';
					$dataResponse['firstname'] = $data[$this->modelClass]['firstname'];
					$dataResponse['lastname'] 	= $data[$this->modelClass]['lastname'];
					
				}
				else{
					$success = false;
					$message = 'Error: Could Not Updated Your Account! Please try Agian later';
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$image_name = $record[$this->modelClass]['image'];
			$this->set('image',$image_name);
			$dataResponse['success'] = $success;
			$dataResponse['message'] = $message;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['callBackFunction'] = 'actionAfterChangeName';
			
			echo json_encode($dataResponse); die;
		}
		else
		{
			if(!$this->request->data)
			{
				$this->request->data = $record;
				$this->request->data[$this->modelClass]['dob'] = date('m/d/Y',strtotime($record[$this->modelClass]['dob']));
				$image_name = $record[$this->modelClass]['image'];
				$this->set('image',$image_name);
			}
		}
	}
	public function security(){
		$id = $this->Auth->user('id');
		$record = $this->{$this->modelClass}->findById($id);
		if($this->request->is('ajax')){
			$data1	=	$this->request->data;
			$data1[$this->modelClass]['user_pass'] = $record[$this->modelClass]['password'];
			$this->request->data = $data1;
			$this->{$this->modelClass}->set($this->request->data);
			if($this->{$this->modelClass}->change()){
				$this->{$this->modelClass}->id = $id;
				$data = array();
				$data['password'] = authComponent::password($this->request->data[$this->modelClass]['new_password']); 
				if($this->{$this->modelClass}->save($data,false)){
					$success = true;
					$message = 'Password Changed Successfully';
					$dataResponse['resetForm'] = true;	
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
		exit;
	}
	
	public function get_states(){
		$this->loadModel('State');
		$state = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_iso_code'=>$this->request->data['country_iso_code']),'fields'=>array('iso_code','state_name'),'order' => 'State.state_name ASC'));
		$data['success'] = true;
		$data['states'] = $state;
		echo json_encode($data); die;
	}
	
	public function get_cities(){
		$data = array();
		$this->loadModel('City');
		$city = $this->City->find('list',array('conditions'=>array('City.status'=>1,'City.state_iso_code'=>$this->request->data['state_iso_code']),'fields'=>array('id','city_name'),'order' => 'City.city_name ASC'));
		$data1['success'] = true;
		$data1['cities'] = $city;
		echo json_encode($data1); die;
	}
	
	public function social_login($provider) {
		if( $this->Hybridauth->connect($provider) ){
			$this->_successfulHybridauth($provider,$this->Hybridauth->user_profile);
		}else{
			$this->Session->setFlash($this->Hybridauth->error);
			$this->redirect($this->Auth->loginAction);
		}
	}
	
	private function _successfulHybridauth($provider, $incomingProfile){
		$this->loadModel('SocialProfile');
		$this->SocialProfile->recursive = -1;
		$existingProfile = $this->SocialProfile->find('first', array(
			'conditions' => array('social_network_id' => $incomingProfile['SocialProfile']['social_network_id'], 'social_network_name' => $provider)
		));
		 
		if ($existingProfile) {
		
			if($incomingProfile['SocialProfile']['social_network_name'] == 'Twitter'){
				$user = $this->{$this->modelClass}->find('first', array(
					'conditions' => array('id' => $existingProfile['SocialProfile']['user_id'],'status'=>1)
				));
			
			}
			else
			{
				$user = $this->{$this->modelClass}->find('first', array(
					'conditions' => array('id' => $existingProfile['SocialProfile']['user_id'])
				));
			}
			
			$this->_doSocialLogin($user,true);
		} else {
			if ($this->Auth->loggedIn()){
				$incomingProfile['SocialProfile']['user_id'] = $this->Auth->user('id');
				$this->SocialProfile->save($incomingProfile);
				 
				$this->Session->setFlash('Your ' . $incomingProfile['SocialProfile']['social_network_name'] . ' account is now linked to your account.');
				$this->redirect($this->Auth->redirectUrl());
	 
			} else {
				
				if($incomingProfile['SocialProfile']['social_network_name'] == 'Twitter')
				{
					$this->Session->write('twitter_id',$incomingProfile['SocialProfile']['social_network_id']);
					$this->Session->write('user_first_name',$incomingProfile['SocialProfile']['first_name']);
					if($incomingProfile['SocialProfile']['last_name'] != ''){
						$this->Session->write('user_last_name',$incomingProfile['SocialProfile']['last_name']);
					}
					else
					{
						$this->Session->write('user_last_name','');
					}
					$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
				}
				else
				{
					$user = $this->{$this->modelClass}->createFromSocialProfile($incomingProfile);
					$incomingProfile['SocialProfile']['user_id'] = $user['User']['id'];
					$this->SocialProfile->save($incomingProfile);
					
					$this->loadModel('UserEarningPoint');
					$this->loadModel('EarningPointType');
					$earnPointType_id = 3;
					$user_id = $user['User']['id'];
					$earningPoint = $this->EarningPointType->findById($earnPointType_id);
					$record = $this->{$this->modelClass}->findById($user_id);
					$earn_point = $earningPoint['EarningPointType']['points'];
					
					$earningPoint_Data = array();
					$earningPoint_Data['UserEarningPoint']['user_id']					=	$user_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_id']			=	$earnPointType_id;
					$earningPoint_Data['UserEarningPoint']['earning_type_target_id']	=	$user_id;
					$earningPoint_Data['UserEarningPoint']['earn_point'] = 	$earn_point;
					$this->UserEarningPoint->create();
					$this->UserEarningPoint->save($earningPoint_Data);
					
					$this->autoMessage($user_id,$user[$this->modelClass]['firstname']);
					
					$this->loadModel('User');
					$earning_points = $record[$this->modelClass]['earning_points'] + $earn_point;
					$this->{$this->modelClass}->id = $user_id;
					$this->{$this->modelClass}->saveField('earning_points',$earning_points);
					$this->_doSocialLogin($user);
				}
			}
		}  
	}
	function getMyFriendsJSON()
	{
		$this->loadModel('Friend');
		$user_id = $this->Auth->user('id');
		$friend_list = $this->Friend->find('all',array('conditions'=>array('OR'=>array('Friend.user_id_1'=>$user_id,'Friend.user_id_2'=>$user_id))));
		$friends = array();
		if($friend_list){
			
			foreach($friend_list as $key => $value)
			{
				if($value['Friend']['user_id_1'] != $user_id)
				{
					$friend_id = $value['Friend']['user_id_1'];
				}
				else
				{
					$friend_id = $value['Friend']['user_id_2'];
				}
				$userData = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.id'=>$friend_id),'fields'=>array('image','slug','firstname','lastname')));
				$friends[$key]['image'] = $userData['User']['image'];
				$friends[$key]['slug'] = $userData['User']['slug'];
				$friends[$key]['id'] = $userData['User']['id'];
				$friends[$key]['fullname'] = $userData['User']['firstname'].' '.$userData['User']['lastname'];
			}
		}
		$data['success'] = true;
		$data['friends'] = $friends;
		echo json_encode($data); die;
	}
	private function _doSocialLogin($user) {

		if ($this->Auth->login($user['User'])) {
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
			 
		} else {
			$this->Session->setFlash(__('Unknown Error could not verify the user: '. $this->Auth->user('username')));
		}
	}
	
	public function social_endpoint($provider = null) {
		$this->Hybridauth->processEndpoint();
	}
	//Social login section end
	
	public function session_user_data($id = null){
		$this->loadModel('FriendRequest');
		$session_user_record = $this->{$this->modelClass}->findById($id);
		$friend_requests = $this->FriendRequest->find('count',array('conditions'=>array('FriendRequest.receiver_id'=>$id)));
		$session_user_record[$this->modelClass]['friend_requests'] = $friend_requests;
		$this->checkRecordIsNull($session_user_record);
		return $session_user_record;
 	}
	
	
	public function deactiveAccount(){
		$user_id = $this->Auth->user('id');
		$this->{$this->modelClass}->id = $user_id;
		$this->{$this->modelClass}->saveField('status','0');
		$data['redirectUrl'] = WEBSITE_URL.'users/logout';
		echo json_encode($data); die;
		
	}
	
	public function notification(){
		$user_id = $this->Auth->user('id');
		if($this->request->data['state'] == 'true')
		{
			
			$this->{$this->modelClass}->id = $user_id;
			$this->{$this->modelClass}->saveField('notification_promotional','Yes');
		}
		else
		{
			$this->{$this->modelClass}->id = $user_id;
			$this->{$this->modelClass}->saveField('notification_promotional','No');
		}
		
		$dataResponse['success'] = true;
		echo json_encode($dataResponse); die;
	}
	
	public function private_profile(){
		$user_id = $this->Auth->user('id');
		if($this->request->data['state'] == 'true')
		{
			
			$this->{$this->modelClass}->id = $user_id;
			$this->{$this->modelClass}->saveField('is_private_profile','Yes');
		}
		else
		{
			$this->{$this->modelClass}->id = $user_id;
			$this->{$this->modelClass}->saveField('is_private_profile','No');
		}
		
		$dataResponse['success'] = true;
		echo json_encode($dataResponse); die;
	}
	
	public function logout(){
		$this->Hybridauth->logout();
		$this->redirect($this->Auth->logout());
	}
	
	public function invite_friends(){
		$this->loadModel('BetaRegistrationInvitation');
		$user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$user_id);
		$this->Paginator->settings = array(
			'BetaRegistrationInvitation'=>array(
				'conditions'=>array('BetaRegistrationInvitation.sender_user_id'=>$user_id),
				'limit' => 10,
				'order' => 'BetaRegistrationInvitation.created desc',
				'paramType' => 'querystring'
			)
		);
		$this->set('record',$this->Paginator->paginate('BetaRegistrationInvitation'));
		
		if($this->request->isAjax()){
			$this->request->data[$this->modelClass] = $this->request->data['BetaRegistrationInvitation'];
			$this->{$this->modelClass}->set($this->request->data['User']);
			if($this->{$this->modelClass}->inviteFriendValidate()){
				$this->loadModel('BetaRegistrationInvitation');
				$is_record_exist = $this->BetaRegistrationInvitation->findByEmail($this->request->data[$this->modelClass]['email']);
				if(isset($is_record_exist) && !empty($is_record_exist)){
					$success = false;
					$message = 'This email has already been taken';
				}
				else
				{
					$count  = $this->BetaRegistrationInvitation->find('count');
					$allow_record = configure::read('Site.total_beta_mode_registration_allowed');
					if($count <= $allow_record){
						$data  	= array();
						$data['target_full_name']	= 	$this->request->data[$this->modelClass]['target_full_name'];
						$data['email']				= 	$this->request->data[$this->modelClass]['email'];
						$data['date']				= 	date('Y-m-d H:i:s');
						$data['sender_user_id']		= 	$user_id;
						$this->BetaRegistrationInvitation->create();
						if($this->BetaRegistrationInvitation->save($data,false)){
							$this->loadModel('EmailTemplate');
							$record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"invite_friend",'EmailTemplate.status'=>1)));
							if(isset($record) && !empty($record)){
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
								$body = $record['EmailTemplate']['body'];
								$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
								$site_title = Configure::read("Site.title");
								$string = str_replace('{#logo}',$logo,$body);
								$string = str_replace('{#email}',$data['email'],$string);
								$string = str_replace('{#name}',$data['target_full_name'],$string);
								$string = str_replace('{#site_title}',$site_title,$string);
								$Email->delivery = "smtp";
								$Email->from = MAIL_FROM;
								$Email->to = $data['email'];
								$Email->subject = $record['EmailTemplate']['subject'];
								$Email->sendAs = 'html';
								if($Email->send($string))
								{ 
									$success = true;
									$message = 'Your invitation has been successfully completed';
									$dataResponse['resetForm'] = true;
								}
								else
								{
									$message = 'Sorry some error occoured. Please try again later';
									$success = false;
								}
							}
							else
							{
								$message = 'Your invitation has been successfully completed';
								$success = true;
							}
								
						}
						else
						{
							$message = 'Sorry some error occoured. Please try again later';
							$success = false;
						}
					}
					else
					{
						$message = 'Sorry! We have crossed invitation limits, so you cannot invite more friends';
						$success = false;
					}
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
			
		}
		
	}
	
	public function invite_friend_registration(){
		if($this->request->isAjax()){
			$this->request->data[$this->modelClass] = $this->request->data['BetaRegistrationInvitation'];
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if($this->{$this->modelClass}->inviteFriendRegisterValidate()){
				$this->loadModel('BetaRegistrationInvitation');
				$email = $this->request->data[$this->modelClass]['email'];
				$invitation_data = $this->BetaRegistrationInvitation->findByEmail($email);
				$already_registered = $this->{$this->modelClass}->findByEmail($email);
				if(isset($invitation_data) && !empty($invitation_data)){
					if($invitation_data['BetaRegistrationInvitation']['is_registered'] == 'Yes'){ 
						$success = false;
						$message = 'You are already registered';
					}
					else
					{
						$success = true;
						$dataResponse['callBackFunction'] = 'callBackAfterInviteFriendReg';
						$message = false;
					}
				}
				else if(isset($already_registered) && !empty($already_registered)){
					$success = false;
					$message = 'You are already registered';
				}
				else
				{
					$success = false;
					$message = ' You were not invited by anyone. Current registration is by invitation only.';
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
				
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
}
?>
