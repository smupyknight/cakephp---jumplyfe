<?php 
class RegistersController extends AppController{
	public $helper = array('Form','Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->loadModel('User');
		$this->Auth->allow(array('index','verify','formatErrors', 'reset_password'));
	}
	public function index(){
		if($this->Auth->login()){
			$this->redirect(array('controller'=>'welcomes','action'=>'index'));
		}
		$str = '0123456789abcdefghijklmnopqrstuvwxyz';
		$verification_code = substr(str_shuffle($str),0,20);
		if($this->request->is('post')){
			$this->{$this->modelClass}->set($this->data);
			if ($this->{$this->modelClass}->validates()){
				$betaMode = configure::read('Site.use_in_beta_mode');
				$email_address = trim($this->data{$this->modelClass}['email']);
				$this->loadModel('BetaRegistrationInvitation');
				if($betaMode == 'Yes'){
					$invitation_data = $this->BetaRegistrationInvitation->findByEmail($email_address);
					if(isset($invitation_data) && !empty($invitation_data)){
						if($invitation_data['BetaRegistrationInvitation']['is_registered'] == 'Yes'){ 
							$dataResponse['success'] = false;
							$dataResponse['message'] = 'You are already registered';
							echo json_encode($dataResponse); die;
						}
						else
						{
							$data['email']	=  $email_address;
							$invite_user_data  						= 	array();
							$invite_user_data['is_registered']		= 	'Yes';
							$invite_user_data['registration_date']	= 	date('Y-m-d H:i:s');
							$this->BetaRegistrationInvitation->id 	= $invitation_data['BetaRegistrationInvitation']['id'];
							$this->BetaRegistrationInvitation->save($invite_user_data,false);
						}
					}
					else
					{
						$dataResponse['success'] = false;
						$dataResponse['message'] = 'You are not invited by anyone, so you cannot register with our site';
						echo json_encode($dataResponse); die;
					}
				}
				else
				{
					$data['email']	=  $email_address;
				}
				$data = array();
				$data['firstname']			=	trim($this->data{$this->modelClass}['firstname']);
				$data['lastname']			=	trim($this->data{$this->modelClass}['lastname']);	
				$data['password']			=   AuthComponent::password($this->data{$this->modelClass}['password']);
				$data['verification_code']	=	$verification_code;
				$user = $this->{$this->modelClass}->save($data, false);
				if($this->request->data{$this->modelClass}['twitter_id'] != ''){
					$social_profileData = array();
					$social_profileData['SocialProfile']['user_id'] = $user[$this->modelClass]['id'];
					$social_profileData['SocialProfile']['social_network_id'] = $this->request->data{$this->modelClass}['twitter_id'];
					$social_profileData['SocialProfile']['social_network_name'] = 'Twitter';
					$this->loadModel('SocialProfile');
					$this->SocialProfile->create();
					$this->SocialProfile->save($social_profileData,false);
				}
				
				if($user)
				{
					$this->loadModel('UserEarningPoint');
					$this->loadModel('EarningPointType');
					$earnPointType_id = 3;
					$user_id = $user[$this->modelClass]['id'];
					$earningPoint = $this->EarningPointType->findById($earnPointType_id);
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
					$this->{$this->modelClass}->id = $user_id;
					$this->{$this->modelClass}->saveField('earning_points',$earn_point);
					$news_email = $user[$this->modelClass]['email'];
					$this->loadModel('NewsletterSubscriber');
					$news_record = array('NewsletterSubscriber.email'=>$news_email);
					if($news_record){
						if($this->NewsletterSubscriber->deleteAll($news_record)){
							
							$this->loadModel('EmailTemplate');
							$record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"registeration_to_user",'EmailTemplate.status'=>1)));
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
								$varify_url = WEBSITE_URL . "registers/verify/" . $verification_code;
								$verify_link = '<a href="' . $varify_url . '">Click Here</a>';
								$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
								$site_title = Configure::read("Site.title");
								$string = str_replace('{#logo}',$logo,$body);
								$string = str_replace('{#first_name}',$data['firstname'],$string);
								$string = str_replace('{#lastname}',$data['lastname'],$string);
								$string = str_replace('{#full_name}',$data['firstname'].' '.$data['lastname'],$string);
								$string = str_replace('{#site_title}',$site_title,$string);
								$string = str_replace('{#email}',$email_address,$string);
								$string = str_replace('{#verify_link}',$verify_link,$string);
								$Email->delivery = "smtp";
								$Email->from = MAIL_FROM;
								$Email->to = $this->data[$this->modelClass]['email'];
								$Email->subject = $record['EmailTemplate']['subject'];
								$Email->sendAs = 'html';
								if($Email->send($string))
								{ 
									$success = true;
									$message = 'Please Check your email for verify Your Account';
									$dataResponse['resetForm'] = true;
								}
								else
								{
									$message = 'Failed to Send Mail';
									$success = false;
								}
							}
							else
							{
								$success = true;
								$message = 'Your Account has been successfully registered';
								$dataResponse['resetForm'] = true;
								
							}
						}
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
	
	public function verify($verification_code){
		if($this->Auth->login()){
			$this->redirect(array('controller'=>'welcomes','action'=>'index'));
		}
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array('Register.verification_code'=>$verification_code)));
		if($record){
			$this->{$this->modelClass}->id = $record[$this->modelClass]['id'];
			$data   =   array();
			$data[$this->modelClass]['is_email_verified']=1;
			$data[$this->modelClass]['user_role_id']=2;
			$this->{$this->modelClass}->save($data,false);
		}else{
			$this->Session->setFlash(__('Error!'),'error');
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

	public function reset_password()
	{
		
	}
}
?>
