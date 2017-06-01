<?php
class ElitesController extends AppController{
	public $helper = array('Form','Html');
	public $components = array('Hybridauth');	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('payment_success'));
	}
	public function detail($slug = null){
		$this->loadModel('EliteOffer');
		$this->loadModel('Amenity');
		$this->loadModel('Home');
		$this->loadModel('Room');
		$this->loadModel('JumpHostGallery');
		$this->loadModel('JumpHostReview');
		$this->loadModel('User');
		$elite_mebership_status = $this->User->findById($this->Auth->user('id'),array('fields'=>'User.elite_membership_status'));
		if($elite_mebership_status['User']['elite_membership_status'] == 'Active'){
			$this->EliteOffer->virtualFields = array(
				'city' => 'SELECT city_name FROM cities WHERE id = JumpHost.city_code'
			);
			$elite_record = $this->EliteOffer->find('first',array('conditions'=>array('EliteOffer.status'=>1,'EliteOffer.slug'=>$slug)));
			$this->checkRecordIsNull($elite_record);

			if($elite_record['JumpHost']['is_deleted'] == 'Yes' || $elite_record['JumpHost']['status'] == 0)
			{
				$this->redirect(array('controller'=>'users','action'=>'elite'));
			}
			else
			{

				$elite_record['EliteOffer']['convertAmount'] = $this->convertCurrencyUSDToLocal($elite_record['EliteOffer']['total_price']);
				
				$this->set('elite_record',$elite_record);
				$amenity_id = explode(',',$elite_record['JumpHost']['amenities']);
				//pr($amenity_id); die;
				
				$most_common = $this->Amenity->find('all',array('conditions'=>array('Amenity.status'=>1,'Amenity.amenitie_type'=>'Most_Common','Amenity.id'=>$amenity_id),'fields'=>array('title')));
				$this->set('most_common',$most_common);
				
				$extras = $this->Amenity->find('all',array('conditions'=>array('Amenity.status'=>1,'Amenity.amenitie_type'=>'Extras','Amenity.id'=>$amenity_id),'fields'=>array('title')));
				$this->set('extras',$extras);
				
				$special_features = $this->Amenity->find('all',array('conditions'=>array('Amenity.status'=>1,'Amenity.amenitie_type'=>'Special_Features','Amenity.id'=>$amenity_id),'fields'=>array('title')));
				$this->set('special_features',$special_features); 
				
				$galleries = $this->JumpHostGallery->find('all',array('conditions'=>array('JumpHostGallery.status'=>1,'JumpHostGallery.jump_host_id'=>$elite_record['JumpHost']['id']),'fields'=>array('JumpHostGallery.file_name')));
				$this->set('galleries',$galleries); 
				
				$home_type = $this->Home->find('first',array('conditions'=>array('Home.status'=>1,'Home.id'=>$elite_record['JumpHost']['home_type_id']),'fields'=>array('Home.title')));
				$this->set('home_type',$home_type); 
				
				$room_type = $this->Room->find('first',array('conditions'=>array('Room.status'=>1,'Room.id'=>$elite_record['JumpHost']['room_type_id']),'fields'=>array('Room.title')));
				$this->set('room_type',$room_type); 
				
				$jumpHost_rating = $this->JumpHostReview->find('all',array('conditions'=>array('JumpHostReview.jump_host_id'=>$elite_record['JumpHost']['id'],'status'=>1),'fields'=>array('rating')));
				$count = 0;
				$i = 0;
				if($jumpHost_rating)
				{
					foreach($jumpHost_rating as $key => $value){
						$i++;
						$count = $value['JumpHostReview']['rating'] + $count;
					}
					$avg_rating = $count / $i ;
					$avg_rating = round($avg_rating);
				}
				else
				{
					$avg_rating = 0;
				}
				
				$this->set('avg_rating',$avg_rating);
			}
		}
		else
		{
			$this->redirect(array('controller'=>'welcomes','action'=>'elite_membership_plans'));
		}
	}
	
	public function check_balance(){
		$dataResponse['success'] = true;
		echo json_encode($dataResponse); die;
	}
	
	public function elite_booking($elite_id = null){
		if($this->request->is('post')){
			$this->request->data['Elite'] = $this->request->data['CartElite'];
			$this->{$this->modelClass}->set($this->request->data['Elite']);
			if ($this->{$this->modelClass}->validates()){
				$this->loadModel('User');
				$this->loadModel('BookingJumpHost');
				$elite_mebership_status = $this->User->findById($this->Auth->user('id'),array('fields'=>'User.elite_membership_status'));
				if($elite_mebership_status['User']['elite_membership_status'] == 'Active'){
					$this->loadModel('CartElite');
					$this->loadModel('EliteOffer');
					$elite_record = $this->EliteOffer->find('first',array('conditions'=>array('EliteOffer.status'=>1,'EliteOffer.id'=>$elite_id),'fields'=>array('EliteOffer.valid_days','EliteOffer.total_price')));
					$record = array();
					$record['elite_id'] 	=	$elite_id;
					$record['check_in'] 	= 	date('Y-m-d',strtotime($this->request->data['CartElite']['check_in']));
					$record['check_out']	=	date('Y-m-d',strtotime('+ '.$elite_record['EliteOffer']['valid_days'].' days',strtotime($this->request->data['CartElite']['check_in'])));
					$record['check_out'] 	= date('Y-m-d',strtotime('- 1 days',strtotime($record['check_out'])));
					
					$Elite_Booking_Record =  $this->BookingJumpHost->find('all',array('conditions'=>array('BookingJumpHost.status'=>1,'BookingJumpHost.elite_id'=>$elite_id,'BookingJumpHost.is_cancelled'=>'No')));
					$result = $this->compareDates($Elite_Booking_Record, $record['check_in'],$record['check_out']);
					if($result == 'true')
					{
						$error = true;
						$success = false;
						$message = 'This Elite is already booked on this date.';
					}
					else
					{
						$record['status'] 		= 	1;
						$cartelite_record = $this->CartElite->save($record,false);
						if($cartelite_record){
							
							$this->loadModel('TransactionCharge');
							$TransactionCharge_Record = $this->TransactionCharge->find('first',array('conditions'=>array('TransactionCharge.status'=>1,'TransactionCharge.transaction_type'=>'Elite_Booking')));
							//pr($TransactionCharge_Record); die;
							$data = array();
							if(!empty($TransactionCharge_Record))
							{
								if($TransactionCharge_Record['TransactionCharge']['fees_type'] == 'Percent'){
									$chargeable_fees  = $TransactionCharge_Record['TransactionCharge']['transaction_fees'];
									$elite_price  = $elite_record['EliteOffer']['total_price'];
									$data['payment_charges'] = $chargeable_fees / 100 * $elite_price;
								}
								else
								{
									$data['payment_charges'] = $TransactionCharge_Record['TransactionCharge']['transaction_fees'];
								}
							}
							else
							{
								$data['payment_charges']	= 0;
							}
							$str =  '0123456789';
							$rand_string = substr(str_shuffle($str),0,5); 
							$user_id = $this->Auth->user('id');
							$invoice_id = time().$rand_string.'-'.$user_id;
							$data['invoice_id'] 			= $invoice_id;
							$data['user_id'] 				= $user_id;
							$data['amount'] 				= $elite_record['EliteOffer']['total_price'];
							$data['payment_method'] 		= false;
							$data['payment_status']			= 'Pending';
							$data['payment_for_type'] 		= 'Book_Elite';
							$data['skip_wallet']			= false;
							$data['target_id'] 				= $cartelite_record['CartElite']['id'];
							$data['total_payable_amout'] 	= $elite_record['EliteOffer']['total_price'] + $data['payment_charges'];
							$data['success_return_url'] 	= WEBSITE_URL.'elites/payment_success';
							$data['failure_return_url'] 	= WEBSITE_URL.'elites/payment_fail';
							$data['ipn_callback_url'] 		= WEBSITE_URL.'elites/payment_success';
							$data['payment_title'] 			= 'Elite Booking';
							$data['payment_description'] 	= 'Elite Booking';
							$data['checkout_title'] 	 	= 'Elite Booking';
							$data['checkout_description'] 	= 'You can book elite through Paypal, Credit Card, Wallet';
							$this->loadModel('TmpInvoice');
							if($this->TmpInvoice->save($data,false)){
								$this->Session->write('invoice_id',$data['invoice_id']);
								$success = true;
								$message = 'Please Wait..';
								$dataResponse['redirectURL'] =  Router::url(array('plugin'=>false,'controller'=>'checkouts','action'=>'index'));
							}	
						}
					}
				}
				else
				{
					$error = true;
					$success = false;
					$message = 'You are not buy any elite membership plan. Please buy a elite membership plan for book elite';
				}
			}
			else
			{
				$error = true;
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}	
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function compareDates($record, $in, $out){
		
		
		foreach($record as $key => $value){
			
			
			if($value['BookingJumpHost']['check_in'] <= $out && $value['BookingJumpHost']['check_out'] >= $in) { 
			
				return "true"; //return how many days overlap
				
			}
		}
		return "false";
	} 
	
	
	public function payment_success($invoice_id){
		if(!$invoice_id){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		
		$this->loadModel('TmpInvoice');
		$this->loadModel('CartElite');
		$this->loadModel('EliteOffer');
		$this->loadModel('UserWalletTransaction');
		$this->loadModel('User');
		$this->loadModel('JumpHost');
		$this->loadModel('BookingJumpHost');
		$this->loadModel('BookingElite');
		$this->loadModel('Booking');
		$this->loadModel('Jump');
		$this->loadModel('JumpHostGallery');
		$TmpInvoice_record = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
		$this->checkRecordIsNull($TmpInvoice_record);
		$CartElite_record = $this->CartElite->find('first',array('conditions'=>array('CartElite.id'=>$TmpInvoice_record['TmpInvoice']['target_id'])));
		$this->checkRecordIsNull($CartElite_record);
		$EliteOffer_record = $this->EliteOffer->find('first',array('conditions'=>array('EliteOffer.id'=>$CartElite_record['CartElite']['elite_id'])));
		//pr($EliteOffer_record); die;
		$this->checkRecordIsNull($EliteOffer_record);
		if($TmpInvoice_record['TmpInvoice']['is_execution_done'] == 'No' && $TmpInvoice_record['TmpInvoice']['payment_status'] == 'Paid'){
		
			$book_jumphost_record	 = array();
			$book_jumphost_record['buyer_id']  =  $TmpInvoice_record['TmpInvoice']['user_id'];  
			$book_jumphost_record['jump_host_id']  =  $EliteOffer_record['EliteOffer']['jump_host_id'];
			$book_jumphost_record['elite_id']  =  $CartElite_record['CartElite']['elite_id'];
			$book_jumphost_record['invoice_id']  =	$invoice_id;
			$book_jumphost_record['paid_amount']  = $TmpInvoice_record['TmpInvoice']['total_payable_amout'];
			$book_jumphost_record['booking_date_time']  = date('Y-m-d H:i:s');
			$book_jumphost_record['check_in']  = $CartElite_record['CartElite']['check_in'];
			$book_jumphost_record['check_out']  = $CartElite_record['CartElite']['check_out'];
			$book_jumphost_record['status']  = 1;
			$this->BookingJumpHost->create();
			$this->BookingJumpHost->save($book_jumphost_record,false);
			
			$book_elite_record	 = array();
			$book_elite_record['buyer_id']  =  $TmpInvoice_record['TmpInvoice']['user_id'];  
			$book_elite_record['jump_host_id']  =  $EliteOffer_record['EliteOffer']['jump_host_id'];
			$book_elite_record['elite_id']  =  $CartElite_record['CartElite']['elite_id'];
			$book_elite_record['invoice_id']  =	$invoice_id;
			$book_elite_record['paid_amount']  = $TmpInvoice_record['TmpInvoice']['total_payable_amout'];
			$book_elite_record['booking_date_time']  = date('Y-m-d H:i:s');
			$book_elite_record['check_in']  = $CartElite_record['CartElite']['check_in'];
			$book_elite_record['check_out']  = $CartElite_record['CartElite']['check_out'];
			$book_elite_record['status']  = 1;
			$this->BookingElite->create();
			$this->BookingElite->save($book_elite_record,false);
			
			
			$JumpHost_record  = array();
			if(date('Y-m-d') >= $CartElite_record['CartElite']['check_in']  &&  date('Y-m-d') <= $CartElite_record['CartElite']['check_out']){
				$JumpHost_record['is_booked'] = 'Yes';
			}
			/* else
			{
				//$JumpHost_record['is_booked'] = 'No';
			} */
			$JumpHost_record['latest_check_in_date_time'] = $CartElite_record['CartElite']['check_in'];
			$JumpHost_record['latest_check_out_date_time'] = $CartElite_record['CartElite']['check_out'];
			$this->JumpHost->id = $EliteOffer_record['EliteOffer']['jump_host_id'];
			$this->JumpHost->save($JumpHost_record,false);
			
			
			$booking_record = array();
			$booking_record['booking_type']  =	'Jump_Host'; 
			$booking_record['type_id'] 		 =	$EliteOffer_record['EliteOffer']['jump_host_id']; 
			$booking_record['user_id']		 =	$TmpInvoice_record['TmpInvoice']['user_id']; 
			$booking_record['jump_host_id']	 =	$EliteOffer_record['EliteOffer']['jump_host_id']; 
			$booking_record['invoice_id']	 =	$invoice_id; 
			$booking_record['user_paid_amount'] =	$TmpInvoice_record['TmpInvoice']['total_payable_amout']; 
			$booking_record['status'] =	1; 
			$this->Booking->create();
			$booking_save_record = $this->Booking->save($booking_record,false);
			
			$gallery_record = $this->JumpHostGallery->primaryJumpImage($EliteOffer_record['EliteOffer']['jump_host_id']);
			//pr($EliteOffer_record); die;
			$jump_record = array();
			$jump_record['user_id']			 =	$TmpInvoice_record['TmpInvoice']['user_id'];
			$jump_record['booking_id']		 =	$booking_save_record['Booking']['id'];
			$jump_record['jump_type']		 =	$booking_save_record['Booking']['booking_type'];
			$jump_record['title']	 		 =	$EliteOffer_record['JumpHost']['title'];
			$jump_record['description']	 	 =	$EliteOffer_record['JumpHost']['description'];
			$jump_record['short_description'] =	$EliteOffer_record['JumpHost']['description'];
			$jump_record['latitude']	 	 =	$EliteOffer_record['JumpHost']['latitude'];
			$jump_record['longitude']	 	 =	$EliteOffer_record['JumpHost']['longitude'];
			$jump_record['country_code']	 =	$EliteOffer_record['JumpHost']['country_code'];
			$jump_record['state_code']	 	 =	$EliteOffer_record['JumpHost']['state_code'];
			$jump_record['city_code']	 	 =	$EliteOffer_record['JumpHost']['city_code'];
			$jump_record['address_line_1']	 =	$EliteOffer_record['JumpHost']['address_line_1'];
			$jump_record['address_line_2']	 =	$EliteOffer_record['JumpHost']['address_line_2'];
			$jump_record['jump_start_date']	 =	date('Y-m-d');
			$jump_record['jump_end_date']	 =	date('Y-m-d');
			$jump_record['zipcode']	 		 =	$EliteOffer_record['JumpHost']['zipcode'];
			$jump_record['status']	 		 =	1;
			$model_name = 'Jump';
			$jump_record['slug']  			 = 	$this->createSlug($EliteOffer_record['JumpHost']['title'],$model_name);
			if($gallery_record){
				$jump_record['image']	 	 =	$gallery_record['JumpHostGallery']['file_name'];
				$copy = copy(ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH.$jump_record['image'],ALBUM_UPLOAD_JUMP_IMAGE_PATH.$jump_record['image']);
			}
			$jumpSaveData = $this->Jump->save($jump_record,false);
			
			$this->loadModel('UserFeed');
			/* $userFeed_Elitedata						= array();
			$userFeed_Elitedata['user_id'] 				= $TmpInvoice_record['TmpInvoice']['user_id'];
			$userFeed_Elitedata['feed_type_id'] 		= 3;
			$userFeed_Elitedata['feed_type_target_id'] 	= $EliteOffer_record['EliteOffer']['id'];
			$this->UserFeed->create();
			$this->UserFeed->save($userFeed_Elitedata,false); */
			
			$userFeed_Jumpdata							= array();
			$userFeed_Jumpdata['user_id'] 				= $TmpInvoice_record['TmpInvoice']['user_id'];
			$userFeed_Jumpdata['feed_type_id'] 			= 2;
			$userFeed_Jumpdata['feed_type_target_id'] 	= $jumpSaveData['Jump']['id'];
			$this->UserFeed->create();
			$this->UserFeed->save($userFeed_Jumpdata,false);
			
			$this->TmpInvoice->id = $TmpInvoice_record['TmpInvoice']['id'];
			$buyer_user_record = $this->User->findById($TmpInvoice_record['TmpInvoice']['user_id']);
			$owner_user_record = $this->User->findById($EliteOffer_record['JumpHost']['user_id']);
			$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
			$site_title = Configure::read("Site.title");
			$this->TmpInvoice->id = $TmpInvoice_record['TmpInvoice']['id'];
			if($this->TmpInvoice->saveField('is_execution_done','Yes')){
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
				$buyer_email_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"booking_elite_buyer",'EmailTemplate.status'=>1)));
				if(isset($buyer_email_record) && !empty($buyer_email_record)){
					$body = $buyer_email_record['EmailTemplate']['body'];
					$string = str_replace('{#logo}',$logo,$body);
					$string = str_replace('{#elite_name}',$EliteOffer_record['EliteOffer']['title'],$string);
					$string = str_replace('{#buyer_name}',$buyer_user_record['User']['firstname'].' '.$buyer_user_record['User']['lastname'],$string);
					$string = str_replace('{#seller_name}',$owner_user_record['User']['firstname'].' '.$owner_user_record['User']['lastname'],$string);
					$string = str_replace('{#site_title}',$site_title,$string);
					$string = str_replace('{#buyer_email}',$buyer_user_record['User']['email'],$string);
					$string = str_replace('{#seller_email}',$owner_user_record['User']['email'],$string);
					$string = str_replace('{#price}',$TmpInvoice_record['TmpInvoice']['total_payable_amout'],$string);
					$string = str_replace('{#check_in_date}',$CartElite_record['CartElite']['check_in'],$string);
					$string = str_replace('{#check_out_date}',$CartElite_record['CartElite']['check_out'],$string);
					$string = str_replace('{#booking_date_time}',$book_elite_record['booking_date_time'],$string);
					$Email->delivery = "smtp";
					$Email->from = MAIL_FROM;
					$Email->to = $buyer_user_record['User']['email'];
					$Email->subject = $buyer_email_record['EmailTemplate']['subject'];
					$Email->sendAs = 'html';
					$Email->send($string);
				}
				
				//Send Mail To Owner
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
				$seller_email_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"booking_elite_owner",'EmailTemplate.status'=>1)));
				if(isset($seller_email_record) && !empty($seller_email_record)){
					$body1 = $seller_email_record['EmailTemplate']['body'];
					$string1 = str_replace('{#logo}',$logo,$body1);
					$string1 = str_replace('{#elite_name}',$EliteOffer_record['EliteOffer']['title'],$string1);
					$string1 = str_replace('{#buyer_name}',$buyer_user_record['User']['firstname'].' '.$buyer_user_record['User']['lastname'],$string1);
					$string1 = str_replace('{#seller_name}',$owner_user_record['User']['firstname'].' '.$owner_user_record['User']['lastname'],$string1);
					$string1 = str_replace('{#site_title}',$site_title,$string1);
					$string1 = str_replace('{#buyer_email}',$buyer_user_record['User']['email'],$string1);
					$string1 = str_replace('{#seller_email}',$owner_user_record['User']['email'],$string1);
					$string1 = str_replace('{#price}',$TmpInvoice_record['TmpInvoice']['total_payable_amout'],$string1);
					$string1 = str_replace('{#check_in_date}',$CartElite_record['CartElite']['check_in'],$string1);
					$string1 = str_replace('{#check_out_date}',$CartElite_record['CartElite']['check_out'],$string1);
					$string1 = str_replace('{#booking_date_time}',$book_elite_record['booking_date_time'],$string1);
					$Email->delivery = "smtp";
					$Email->from = MAIL_FROM;
					$Email->to = $owner_user_record['User']['email'];
					$Email->subject = $seller_email_record['EmailTemplate']['subject'];
					$Email->sendAs = 'html';
					$Email->send($string1);
				}
			 
				$this->Session->setFlash(__('Your booking successfully completed'),'success');
				$this->redirect(array('plugin'=>false,'controller'=>'elites','action'=>'detail',$EliteOffer_record['EliteOffer']['slug']));
				
			}	
			
		}
		else
		{
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
	}
	
	
	public function payment_fail(){
		$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
	}
	
	
	public function buyEliteMemberShipPlan($id = null){
		//pr($this->request->data); die;
		$this->loadModel('EliteMembershipPlan');
		$eliteMembership_id = $id;
		$eliteMembershipPlan_Record =  $this->EliteMembershipPlan->findById($eliteMembership_id);
		$this->checkRecordIsNull($eliteMembershipPlan_Record);
		
		$eliteMembershipPlan_Price = $eliteMembershipPlan_Record['EliteMembershipPlan']['plan_price'];
		
		$this->loadModel('User');
		
		$user_id = $this->Auth->user('id');
		$user = $this->User->find('first',array('conditions'=>array('User.status'=>1,'User.id'=>$user_id),'fields'=>array('User.wallet_balance')));
		
		$this->checkRecordIsNull($user);
		
		$user_WalletBalance = $user['User']['wallet_balance'];
		
		if($user_WalletBalance >= $eliteMembershipPlan_Price)
		{
			$str =  '0123456789';
			$rand_string = substr(str_shuffle($str),0,5);
			$invoice_id = time().$rand_string.'-'.$user_id;
			$data = array();
			$data['invoice_id'] 			= $invoice_id;
			$data['user_id'] 				= $user_id;
			$data['amount'] 				= $eliteMembershipPlan_Price;
			$data['payment_method'] 		= false;
			$data['payment_status']			= 'Pending';
			$data['payment_for_type'] 		= 'Buy_Elite_Membership_Plan';
			$data['target_id'] 				= $eliteMembership_id;
			$data['total_payable_amout'] 	= $eliteMembershipPlan_Price;
			$data['skip_wallet']			= false;
			$data['success_return_url'] 	= WEBSITE_URL.'elites/membership_payment_success';
			$data['failure_return_url'] 	= WEBSITE_URL.'elites/membership_payment_fail';
			$data['ipn_callback_url'] 		= WEBSITE_URL.'elites/membership_payment_success';
			$data['payment_title'] 			= 'Buy Elite Membership Plan';
			$data['payment_description'] 	= 'Buy Elite Membership Plan';
			$data['checkout_title'] 	 	= 'Buy Elite Membership Plan';
			$data['checkout_description'] 	= 'You can buy elite membership plan through Paypal, Credit Card, Wallet.';
			$this->loadModel('TmpInvoice');
			if($this->TmpInvoice->save($data,false)){
				$this->Session->write('invoice_id',$data['invoice_id']);
				$this->redirect(array('plugin'=>false,'controller'=>'checkouts','action'=>'index'));
			}
		}
		else
		{
			$this->Session->setFlash('You have a insufficient wallet balance for buy elite membership plan','error');
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'elite_membership_plans'));
			
		}
	}
	
	public function membership_payment_success($invoice_id = null){
		if(!$invoice_id){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		
		$this->loadModel('TmpInvoice');
		$this->loadModel('UserWalletTransaction');
		$this->loadModel('User');
		$this->loadModel('EliteMembershipPlan');
		$this->loadModel('UserEliteMembership');
		
		$TmpInvoice_record = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
		$this->checkRecordIsNull($TmpInvoice_record);
		
		$eliteMembershipPlan_Record =  $this->EliteMembershipPlan->findById($TmpInvoice_record['TmpInvoice']['target_id']);
		$this->checkRecordIsNull($eliteMembershipPlan_Record);
		
		
		if($TmpInvoice_record['TmpInvoice']['is_execution_done'] == 'No' && $TmpInvoice_record['TmpInvoice']['payment_status'] == 'Paid'){
			$plan_validity = $eliteMembershipPlan_Record['EliteMembershipPlan']['validity'].' '.$eliteMembershipPlan_Record['EliteMembershipPlan']['validity_type'];
			$current_date = date('Y-m-d');
			$expire_plan_date	=	date('Y-m-d',strtotime('+ '.$eliteMembershipPlan_Record['EliteMembershipPlan']['validity']. $eliteMembershipPlan_Record['EliteMembershipPlan']['validity_type'],strtotime($current_date)));
			
			
			$buyer_user_record = $this->User->findById($TmpInvoice_record['TmpInvoice']['user_id']);
			$user_UpdateData = array();
			$user_UpdateData['User']['elite_membership_expire_date'] = $expire_plan_date;
			$user_UpdateData['User']['elite_membership_status'] = 'Active';
			$this->User->id = $TmpInvoice_record['TmpInvoice']['user_id'];
			$this->User->save($user_UpdateData,false);
			
			$this->UserEliteMembership->updateAll(
					array('UserEliteMembership.status' => 0),
					array('UserEliteMembership.user_id' => $TmpInvoice_record['TmpInvoice']['user_id'])
				);
			
			$userEliteMembership_Record = array();
			$userEliteMembership_Record['UserEliteMembership']['user_id'] =	$TmpInvoice_record['TmpInvoice']['user_id'];
			$userEliteMembership_Record['UserEliteMembership']['elite_membership_plan_id'] = $TmpInvoice_record['TmpInvoice']['target_id'];
			$userEliteMembership_Record['UserEliteMembership']['plan'] = $eliteMembershipPlan_Record['EliteMembershipPlan']['plan'];
			$userEliteMembership_Record['UserEliteMembership']['title'] = $eliteMembershipPlan_Record['EliteMembershipPlan']['title'];
			$userEliteMembership_Record['UserEliteMembership']['description'] = $eliteMembershipPlan_Record['EliteMembershipPlan']['description'];
			$userEliteMembership_Record['UserEliteMembership']['validity'] = $eliteMembershipPlan_Record['EliteMembershipPlan']['validity'];
			$userEliteMembership_Record['UserEliteMembership']['validity_type'] = $eliteMembershipPlan_Record['EliteMembershipPlan']['validity_type'];
			$userEliteMembership_Record['UserEliteMembership']['plan_price'] = $eliteMembershipPlan_Record['EliteMembershipPlan']['plan_price'];
			$userEliteMembership_Record['UserEliteMembership']['status'] = 1;
			
			$this->UserEliteMembership->create();
			$this->UserEliteMembership->save($userEliteMembership_Record,false);
			
			$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
			$site_title = Configure::read("Site.title");
			$this->TmpInvoice->id = $TmpInvoice_record['TmpInvoice']['id'];
			
			if($this->TmpInvoice->saveField('is_execution_done','Yes')){
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
				$buyer_email_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"buy_elite_membership_plan",'EmailTemplate.status'=>1)));
				if(isset($buyer_email_record) && !empty($buyer_email_record)){
					$body = $buyer_email_record['EmailTemplate']['body'];
					$string = str_replace('{#logo}',$logo,$body);
					$string = str_replace('{#buyer_name}',$buyer_user_record['User']['firstname'].' '.$buyer_user_record['User']['lastname'],$string);
					$string = str_replace('{#site_title}',$site_title,$string);
					$string = str_replace('{#buyer_email}',$buyer_user_record['User']['email'],$string);
					$string = str_replace('{#plan}',$eliteMembershipPlan_Record['EliteMembershipPlan']['plan'],$string);
					$string = str_replace('{#plan_price}',$eliteMembershipPlan_Record['EliteMembershipPlan']['plan_price'],$string);
					$string = str_replace('{#buy_date_time}',$eliteMembershipPlan_Record['EliteMembershipPlan']['created'],$string);
					$string = str_replace('{#validity}',$expire_plan_date,$string);
					$Email->delivery = "smtp";
					$Email->from = MAIL_FROM;
					$Email->to = $buyer_user_record['User']['email'];
					$Email->subject = $buyer_email_record['EmailTemplate']['subject'];
					$Email->sendAs = 'html';
					$Email->send($string);

				}
				
				$this->Session->setFlash(__('Success! You are successfully buy a elite membership plan'),'success');
				$this->redirect(array('plugin'=>false,'controller'=>'users','action'=>'elite'));
			}
		}
		else
		{
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
	}
	
	
	public function membership_payment_fail(){
		
		$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		
	}
	
	public function manage_membership(){
		$this->set('left_menu_selected','Elite');
		$user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$user_id);
		$this->loadModel('User');
		$this->loadModel('UserEliteMembership');
		$user = $this->User->findById($user_id);
		$this->checkRecordIsNull($user);
		if($user['User']['elite_membership_status'] == 'Active'){
			$this->set('expire_date',$user['User']['elite_membership_expire_date']);
			$this->Paginator->settings = array(
				'UserEliteMembership'=>array(
					'conditions'=>array('UserEliteMembership.user_id'=>$user_id),
					'limit' => 10,
					'order' => 'UserEliteMembership.created desc',
					'paramType' => 'querystring'
				)
			);
			
			$this->set('record',$this->Paginator->paginate('UserEliteMembership'));
			
		}
		else
		{
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'elite_membership_plans'));
		}
	}
	
	public function delete_membership_plan(){
		$this->loadModel('User');
		$this->loadModel('UserEliteMembership');
		$user_id  =	$this->Auth->user('id');
		$user = $this->User->findById($user_id);
		$this->checkRecordIsNull($user);
		
		$this->UserEliteMembership->updateAll(
					array('UserEliteMembership.status' => 0),
					array('UserEliteMembership.user_id' => $user_id)
				);
				
		$data  =  array();
		$data['User']['elite_membership_status']		=	'Inactive';
		$data['User']['elite_membership_expire_date']	=	'0000-00-00';
		$this->User->id	= $user_id;		
		$da =	$this->User->save($data,false);
		$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'elite_membership_plans'));
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
