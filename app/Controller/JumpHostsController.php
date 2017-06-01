<?php 
class JumpHostsController extends AppController{
	public $name = 'JumpHost';
	public $helper = array('Form','Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('detail'));
	}
	
	public function index($slug = null){
		$this->loadModel('JumpHostGallery');
		$this->loadModel('JumpHostReview');
		$this->loadModel('User');
		$this->checkRecordIsNull($slug);
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$this->set('review_slug',$slug);
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1)));
		$this->checkRecordIsNull($record);
		$this->set('record',$record);
		$galleries = $this->JumpHostGallery->find('all',array('conditions'=>array('JumpHostGallery.status'=>1,'JumpHostGallery.jump_host_id'=>$record[$this->modelClass]['id']),'fields'=>array('JumpHostGallery.file_name')));
		$this->set('galleries',$galleries); 
		$review_record = $this->JumpHostReview->find('all',array('conditions'=>array('JumpHostReview.jump_host_id'=>$record[$this->modelClass]['id'],'JumpHostReview.status'=>1),'limit'=>4,'order'=>'JumpHostReview.created DESC'));
		foreach($review_record as $key => $value){
			$review_record[$key]['User']  =  $this->User->find('first',array('conditions'=>array('User.id'=>$value['JumpHostReview']['user_id'])));
		}
		$this->set('review_record',$review_record);
		//pr($review_record); die;
		$write_review_button = $this->JumpHostReview->find('first',array('conditions'=>array('JumpHostReview.jump_host_id'=>$record[$this->modelClass]['id'],'JumpHostReview.user_id'=>authComponent::user('id'))));
		$this->set('write_review_button',$write_review_button);
		
	}
	
	public function write_review($slug = null){
		$this->loadModel('JumpHost');
		$this->loadModel('JumpHostReview');
		if($this->request->is('post')){
			$this->request->data['JumpHost'] = $this->request->data['JumpHostReview'];
			$this->{$this->modelClass}->set($this->request->data['JumpHost']);
			if ($this->{$this->modelClass}->reviews()){
				$jump_host_record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.slug'=>$slug,'JumpHost.status'=>1),'fields'=>array('JumpHost.id')));
				$this->checkRecordIsNull($jump_host_record);
				$data 				  = array();
				$data['user_id'] 	  = $this->Auth->user('id');
				$data['jump_host_id'] = $jump_host_record['JumpHost']['id'];
				$data['comment']	  = trim($this->request->data['JumpHostReview']['comment']);
				$data['rating']	      = $this->request->data['JumpHostReview']['rating'];
				if($this->JumpHostReview->save($data,false)){
					$success =  true;
					$message = 'Thanks for give your rating';
					$dataResponse['resetForm'] = true;
					$dataResponse['selfReload'] = true;
				}
			}
			else
			{
				$errors = $this->{$this->modelClass}->validationErrors;
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}			
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;	
		}
	}
	
	public function detail($slug = null){
		$this->loadModel('Amenity');
		$this->loadModel('Home');
		$this->loadModel('Room');
		$this->loadModel('JumpHostGallery');
		$this->loadModel('JumpHost');
		$this->loadModel('JumpHostReview');
		$this->loadModel('User');
		$this->JumpHost->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = JumpHost.city_code'
		);
		$booked_jump_record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.slug'=>$slug,'JumpHost.status'=>1,'JumpHost.is_deleted'=>'No'))); 
		$this->checkRecordIsNull($booked_jump_record);
		$booked_jump_record['JumpHost']['convertAmount'] = $this->convertCurrencyUSDToLocal($booked_jump_record['JumpHost']['price']);
		$this->set('review_slug',$slug);
		$this->set('booked_jump_record',$booked_jump_record);
		$amenity_id = explode(',',$booked_jump_record['JumpHost']['amenities']);
		
		$most_common = $this->Amenity->find('all',array('conditions'=>array('Amenity.status'=>1,'Amenity.amenitie_type'=>'Most_Common','Amenity.id'=>$amenity_id),'fields'=>array('title')));
		$this->set('most_common',$most_common);
		
		$jumpHost_rating = $this->JumpHostReview->find('all',array('conditions'=>array('JumpHostReview.jump_host_id'=>$booked_jump_record['JumpHost']['id'],'status'=>1),'fields'=>array('rating')));
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
		$extras = $this->Amenity->find('all',array('conditions'=>array('Amenity.status'=>1,'Amenity.amenitie_type'=>'Extras','Amenity.id'=>$amenity_id),'fields'=>array('title')));
		$this->set('extras',$extras);
		
		$special_features = $this->Amenity->find('all',array('conditions'=>array('Amenity.status'=>1,'Amenity.amenitie_type'=>'Special_Features','Amenity.id'=>$amenity_id),'fields'=>array('title')));
		$this->set('special_features',$special_features); 
		
		$galleries = $this->JumpHostGallery->find('all',array('conditions'=>array('JumpHostGallery.status'=>1,'JumpHostGallery.jump_host_id'=>$booked_jump_record['JumpHost']['id']),'fields'=>array('JumpHostGallery.file_name')));
		$this->set('galleries',$galleries); 
		
		$home_type = $this->Home->find('first',array('conditions'=>array('Home.status'=>1,'Home.id'=>$booked_jump_record['JumpHost']['home_type_id']),'fields'=>array('Home.title')));
		$this->set('home_type',$home_type); 
		
		$room_type = $this->Room->find('first',array('conditions'=>array('Room.status'=>1,'Room.id'=>$booked_jump_record['JumpHost']['room_type_id']),'fields'=>array('Room.title')));
		$this->set('room_type',$room_type); 
		
		$review_record = $this->JumpHostReview->find('all',array('conditions'=>array('JumpHostReview.jump_host_id'=>$booked_jump_record['JumpHost']['id'],'JumpHostReview.status'=>1),'order'=>'JumpHostReview.created DESC'));
		foreach($review_record as $key => $value){
			$review_record[$key]['User']  =  $this->User->find('first',array('conditions'=>array('User.id'=>$value['JumpHostReview']['user_id'])));
		}
		$this->set('review_record',$review_record);
		
		$write_review_button = $this->JumpHostReview->find('first',array('conditions'=>array('JumpHostReview.jump_host_id'=>$booked_jump_record[$this->modelClass]['id'],'JumpHostReview.user_id'=>$this->Auth->user('id'))));
		$this->set('write_review_button',$write_review_button);
	
	}
	
	public function check_user_balance(){
		$dataResponse['success'] = true;
		echo json_encode($dataResponse); die;
	}
	
	public function jump_host_booking($jump_host_slug = null){
		if($this->request->is('post')){
			$this->request->data['JumpHost'] = $this->request->data['CartJumpHost'];
			$this->{$this->modelClass}->set($this->request->data['JumpHost']);
			if ($this->{$this->modelClass}->jump_host_booking()){
				$this->loadModel('CartJumpHost');
				$this->loadModel('JumpHost');
				$this->loadModel('BookingJumpHost');
				$jump_host_record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.status'=>1,'JumpHost.slug'=>$jump_host_slug)));
				$jump_host_id = $jump_host_record['JumpHost']['id'];
				$JumpHostBooking_Record =  $this->BookingJumpHost->find('all',array('conditions'=>array('BookingJumpHost.status'=>1,'BookingJumpHost.jump_host_id'=>$jump_host_id,'BookingJumpHost.is_cancelled'=>'No')));
			
				$record					= array();
				$record['jump_host_id'] =	$jump_host_record['JumpHost']['id'];
				$record['check_in'] 	= 	date('Y-m-d',strtotime($this->request->data['JumpHost']['check_in']));
				$record['check_out']	=	date('Y-m-d',strtotime($this->request->data['JumpHost']['check_out']));
				$record['status'] 		= 	1;
				
				$result = $this->compareDates($JumpHostBooking_Record, $record['check_in'],$record['check_out']);
				if($result == 'true'){
					$error = true;
					$success = false;
					$message = 'This Jump Rental is already booked on this date.';
				}
				else
				{		
					$save_record_return = $this->CartJumpHost->save($record,false);
					if($save_record_return){
						$data = array();
						$this->loadModel('TransactionCharge');
						$TransactionCharge_Record = $this->TransactionCharge->find('first',array('conditions'=>array('TransactionCharge.status'=>1,'TransactionCharge.transaction_type'=>'Jump_Rental')));
						//pr($TransactionCharge_Record); die;
						$data = array();
						if(!empty($TransactionCharge_Record))
						{
							if($TransactionCharge_Record['TransactionCharge']['fees_type'] == 'Percent')
							{
								$chargeable_fees  = $TransactionCharge_Record['TransactionCharge']['transaction_fees'];
								$jumphost_price  = $jump_host_record['JumpHost']['price'];
								$data['payment_charges'] = $chargeable_fees / 100 * $jumphost_price;
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
						$data['amount'] 				= $jump_host_record['JumpHost']['price'];
						$data['payment_method'] 		= false;
						$data['skip_wallet']			= false;
						$data['payment_status']			= 'Pending';
						$data['payment_for_type'] 		= 'Book_Jump_Host';
						$data['target_id'] 				= $save_record_return['CartJumpHost']['id'];
						$data['total_payable_amout'] 	= $jump_host_record['JumpHost']['price'] + $data['payment_charges'];
						$data['success_return_url'] 	= WEBSITE_URL.'jump_hosts/jump_host_payment_success';
						$data['failure_return_url'] 	= WEBSITE_URL.'jump_hosts/jump_host_payment_fail';
						$data['ipn_callback_url'] 		= WEBSITE_URL.'jump_hosts/jump_host_payment_success';
						$data['payment_title'] 			= 'Jump Rental Booking';
						$data['payment_description'] 	= 'Jump Rental Booking';
						$data['checkout_title'] 	 	= 'Jump Rental Booking';
						$data['checkout_description'] 	= 'You can book jump rental through Paypal, Credit Card, Wallet.';
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
	
	public function jump_host_payment_success($invoice_id){
		if(!$invoice_id){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		$this->loadModel('TmpInvoice');
		$this->loadModel('CartJumpHost');
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
		$CartJumpHost_record = $this->CartJumpHost->find('first',array('conditions'=>array('CartJumpHost.id'=>$TmpInvoice_record['TmpInvoice']['target_id'])));
		
		$this->checkRecordIsNull($CartJumpHost_record);
		
		$JumpHost_record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.id'=>$CartJumpHost_record['CartJumpHost']['jump_host_id'])));
		
		$this->checkRecordIsNull($JumpHost_record);
		
		if($TmpInvoice_record['TmpInvoice']['is_execution_done'] == 'No' && $TmpInvoice_record['TmpInvoice']['payment_status'] == 'Paid'){
			$book_jumphost_record	 = array();
			$book_jumphost_record['buyer_id']  =  $TmpInvoice_record['TmpInvoice']['user_id'];  
			$book_jumphost_record['jump_host_id']  =  $JumpHost_record['JumpHost']['id'];
			$book_jumphost_record['invoice_id']  =	$invoice_id;
			$book_jumphost_record['paid_amount']  = $TmpInvoice_record['TmpInvoice']['amount'];
			$book_jumphost_record['booking_date_time']  = date('Y-m-d H:i:s');
			$book_jumphost_record['check_in']  = $CartJumpHost_record['CartJumpHost']['check_in'];
			$book_jumphost_record['check_out']  = $CartJumpHost_record['CartJumpHost']['check_out'];
			$book_jumphost_record['status']  = 1;
			$this->BookingJumpHost->create();
			$this->BookingJumpHost->save($book_jumphost_record,false);
			
			$JumpHost_save_record  = array();
			if(date('Y-m-d') >= $CartJumpHost_record['CartJumpHost']['check_in']  &&  date('Y-m-d') <= $CartJumpHost_record['CartJumpHost']['check_out']){
				$JumpHost_save_record['is_booked'] = 'Yes';
			}
			$JumpHost_save_record['latest_check_in_date_time'] = $CartJumpHost_record['CartJumpHost']['check_in'];
			$JumpHost_save_record['latest_check_out_date_time'] = $CartJumpHost_record['CartJumpHost']['check_out'];
			
			
			$this->JumpHost->id = $JumpHost_record['JumpHost']['id'];
			$this->JumpHost->save($JumpHost_save_record,false);
			
			
			$booking_record = array();
			$booking_record['booking_type']  =	'Jump_Host'; 
			$booking_record['type_id'] 		 =	$JumpHost_record['JumpHost']['id'];
			$booking_record['user_id']		 =	$TmpInvoice_record['TmpInvoice']['user_id']; 
			$booking_record['jump_host_id']	 =	$JumpHost_record['JumpHost']['id'];
			$booking_record['invoice_id']	 =	$invoice_id; 
			$booking_record['user_paid_amount'] =	$TmpInvoice_record['TmpInvoice']['amount']; 
			$booking_record['status'] =	1; 
			
			
			
			$this->Booking->create();
			$booking_save_record = $this->Booking->save($booking_record,false);
			
			$this->checkRecordIsNull($booking_save_record);
			$gallery_record = $this->JumpHostGallery->primaryJumpImage($JumpHost_record['JumpHost']['id']);
			//pr($JumpHost_record); die;
			$jump_record = array();
			$jump_record['user_id']			 =	$TmpInvoice_record['TmpInvoice']['user_id'];
			$jump_record['booking_id']		 =	$booking_save_record['Booking']['id'];
			$jump_record['jump_type']		 =	$booking_save_record['Booking']['booking_type'];
			$jump_record['title']	 		 =	$JumpHost_record['JumpHost']['title'];
			$jump_record['description']	 	 =	$JumpHost_record['JumpHost']['description'];
			$jump_record['short_description'] =	$JumpHost_record['JumpHost']['description'];
			$jump_record['latitude']	 	 =	$JumpHost_record['JumpHost']['latitude'];
			$jump_record['longitude']	 	 =	$JumpHost_record['JumpHost']['longitude'];
			$jump_record['country_code']	 =	$JumpHost_record['JumpHost']['country_code'];
			$jump_record['state_code']	 	 =	$JumpHost_record['JumpHost']['state_code'];
			$jump_record['city_code']	 	 =	$JumpHost_record['JumpHost']['city_code'];
			$jump_record['address_line_1']	 =	$JumpHost_record['JumpHost']['address_line_1'];
			$jump_record['address_line_2']	 =	$JumpHost_record['JumpHost']['address_line_2'];
			$jump_record['jump_start_date']	 =	date('Y-m-d');
			$jump_record['jump_end_date']	 =	date('Y-m-d');
			$jump_record['zipcode']	 		 =	$JumpHost_record['JumpHost']['zipcode'];
			$jump_record['status']	 		 =	1;
			$model_name = 'Jump';
			$jump_record['slug']  			 = 	$this->createSlug($JumpHost_record['JumpHost']['title'],$model_name);
			if($gallery_record){
				$jump_record['image']	 		 =	$gallery_record['JumpHostGallery']['file_name'];
				$copy = copy(ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH.$jump_record['image'],ALBUM_UPLOAD_JUMP_IMAGE_PATH.$jump_record['image']);
			}
			$jumpSaveData = $this->Jump->save($jump_record,false);
			
			
			$this->loadModel('UserFeed');
			/* $userFeed_JumpHostdata							= array();
			$userFeed_JumpHostdata['user_id'] 				= $TmpInvoice_record['TmpInvoice']['user_id'];
			$userFeed_JumpHostdata['feed_type_id'] 			= 4;
			$userFeed_JumpHostdata['feed_type_target_id'] 	= $JumpHost_record['JumpHost']['id'];
			$this->UserFeed->create();
			$this->UserFeed->save($userFeed_JumpHostdata,false); */
			
			$userFeed_Jumpdata							= array();
			$userFeed_Jumpdata['user_id'] 				= $TmpInvoice_record['TmpInvoice']['user_id'];
			$userFeed_Jumpdata['feed_type_id'] 			= 2;
			$userFeed_Jumpdata['feed_type_target_id'] 	= $jumpSaveData['Jump']['id'];
			$this->UserFeed->create();
			$this->UserFeed->save($userFeed_Jumpdata,false);
			
			$buyer_user_record = $this->User->findById($TmpInvoice_record['TmpInvoice']['user_id']);
			$owner_user_record = $this->User->findById($JumpHost_record['JumpHost']['user_id']);
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
				$buyer_email_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"booking_jump_rental_buyer",'EmailTemplate.status'=>1)));
				if(isset($buyer_email_record) && !empty($buyer_email_record)){
					$body = $buyer_email_record['EmailTemplate']['body'];
					$string = str_replace('{#logo}',$logo,$body);
					$string = str_replace('{#jump_rental_name}',$JumpHost_record['JumpHost']['title'],$string);
					$string = str_replace('{#buyer_name}',$buyer_user_record['User']['firstname'].' '.$buyer_user_record['User']['lastname'],$string);
					$string = str_replace('{#seller_name}',$owner_user_record['User']['firstname'].' '.$owner_user_record['User']['lastname'],$string);
					$string = str_replace('{#site_title}',$site_title,$string);
					$string = str_replace('{#buyer_email}',$buyer_user_record['User']['email'],$string);
					$string = str_replace('{#seller_email}',$owner_user_record['User']['email'],$string);
					$string = str_replace('{#price}',$TmpInvoice_record['TmpInvoice']['amount'],$string);
					$string = str_replace('{#check_in_date}',$CartJumpHost_record['CartJumpHost']['check_in'],$string);
					$string = str_replace('{#check_out_date}',$CartJumpHost_record['CartJumpHost']['check_out'],$string);
					$string = str_replace('{#booking_date_time}',$book_jumphost_record['booking_date_time'],$string);
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
				$seller_email_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"booking_jump_rental_owner",'EmailTemplate.status'=>1)));
				if(isset($seller_email_record) && !empty($seller_email_record)){
					$body1 = $seller_email_record['EmailTemplate']['body'];
					$string1 = str_replace('{#logo}',$logo,$body1);
					$string1 = str_replace('{#jump_rental_name}',$JumpHost_record['JumpHost']['title'],$string1);
					$string1 = str_replace('{#buyer_name}',$buyer_user_record['User']['firstname'].' '.$buyer_user_record['User']['lastname'],$string1);
					$string1 = str_replace('{#seller_name}',$owner_user_record['User']['firstname'].' '.$owner_user_record['User']['lastname'],$string1);
					$string1 = str_replace('{#site_title}',$site_title,$string1);
					$string1 = str_replace('{#buyer_email}',$buyer_user_record['User']['email'],$string1);
					$string1 = str_replace('{#seller_email}',$owner_user_record['User']['email'],$string1);
					$string1 = str_replace('{#price}',$TmpInvoice_record['TmpInvoice']['amount'],$string1);
					$string1 = str_replace('{#check_in_date}',$CartJumpHost_record['CartJumpHost']['check_in'],$string1);
					$string1 = str_replace('{#check_out_date}',$CartJumpHost_record['CartJumpHost']['check_out'],$string1);
					$string1 = str_replace('{#booking_date_time}',$book_jumphost_record['booking_date_time'],$string1);
					$Email->delivery = "smtp";
					$Email->from = MAIL_FROM;
					$Email->to = $owner_user_record['User']['email'];
					$Email->subject = $seller_email_record['EmailTemplate']['subject'];
					$Email->sendAs = 'html';
					$Email->send($string1);
				}	
				
				$this->Session->setFlash(__('Your booking successfully completed'),'success');
				$this->redirect(array('plugin'=>false,'controller'=>'jump_hosts','action'=>'detail',$JumpHost_record['JumpHost']['slug']));
			}
		}
		else
		{
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
	}
	
	public function refund_payment($invoice_id =  null){
		$this->loadModel('BookingJumpHost');
		$bookingJumpHost_record = $this->BookingJumpHost->find('first',array('conditions'=>array('BookingJumpHost.invoice_id'=>$invoice_id)));
		//pr($bookingJumpHost_record); die;
		if($bookingJumpHost_record['BookingJumpHost']['is_cancelled'] == 'No'){
			$check_in_Date = $bookingJumpHost_record['BookingJumpHost']['check_in'];
			$before_twoDay_date = date('Y-m-d', strtotime($check_in_Date . '-'.REFUND_PAYMENT_TIME));
			$current_date = date('Y-m-d');
			
			if($before_twoDay_date >= $current_date){
				$str =  '0123456789';
				$rand_string = substr(str_shuffle($str),0,5); 
				$user_id = $this->Auth->user('id');
				$refund_invoice_id = time().$rand_string.'-'.$user_id;
				
				$bookingJumpHost_updateRecord = array();
				$bookingJumpHost_updateRecord['BookingJumpHost']['is_cancelled'] = 'Yes';
				$bookingJumpHost_updateRecord['BookingJumpHost']['cancelled_date_time'] = date('Y-m-d H:i:s',time());
				$bookingJumpHost_updateRecord['BookingJumpHost']['refund_invoice_id'] 	= $refund_invoice_id;
				$this->BookingJumpHost->id = $bookingJumpHost_record['BookingJumpHost']['id'];
				$this->BookingJumpHost->save($bookingJumpHost_updateRecord,false);
				
				$this->loadModel('BookingElite');
				$bookingElite_record = $this->BookingElite->find('first',array('conditions'=>array('BookingElite.invoice_id'=>$bookingJumpHost_record['BookingJumpHost']['invoice_id'])));
				if($bookingElite_record){
					$bookingElite_updateRecord = array();
					$bookingElite_updateRecord['BookingElite']['is_cancelled'] = 'Yes';
					$bookingElite_updateRecord['BookingElite']['cancelled_date_time'] = $bookingJumpHost_updateRecord['BookingJumpHost']['cancelled_date_time'];
					$bookingElite_updateRecord['BookingElite']['refund_invoice_id']   = $refund_invoice_id;
					$this->BookingElite->id = $bookingElite_record['BookingElite']['id'];
					$this->BookingElite->save($bookingElite_updateRecord,false);
				}
				
				$this->loadModel('Booking');
				$booking_record = $this->Booking->find('first',array('conditions'=>array('Booking.invoice_id'=>$bookingJumpHost_record['BookingJumpHost']['invoice_id'])));
				$booking_updateRecord = array();
				$booking_updateRecord['Booking']['is_cancelled'] = 'Yes';
				$booking_updateRecord['Booking']['cancelled_date_time'] = $bookingJumpHost_updateRecord['BookingJumpHost']['cancelled_date_time'];
				$booking_updateRecord['Booking']['refund_invoice_id'] = $refund_invoice_id;
				$charges = $this->calculate_refundCharges($bookingJumpHost_record['BookingJumpHost']['paid_amount'],$booking_record['Booking']['booking_type']);
				$refund_amount = $bookingJumpHost_record['BookingJumpHost']['paid_amount'] - $charges;
				
				$booking_updateRecord['Booking']['refund_amount'] = $refund_amount;
				$this->Booking->id = $booking_record['Booking']['id'];
				$this->Booking->save($booking_updateRecord,false);
				
				$this->loadModel('UserWalletTransaction');
				$this->loadModel('User');
				$wallet_record = array();
				$wallet_record['user_id'] = $bookingJumpHost_record['BookingJumpHost']['buyer_id'];
				$wallet_record['transaction_type'] = 'Added';
				$wallet_record['invoice_id'] = $refund_invoice_id;
				$wallet_record['amount'] = $booking_updateRecord['Booking']['refund_amount'];
				$wallet_record['transaction_identifier'] = 'Refund_Jump_Rental';
				$wallet_record['comments'] = 'Refund of brought Jump Rental';
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
				$this->redirect(array('controller'=>'accounts','action'=>'book_jumps'));
			}
			else
			{
				$this->Session->setFlash(__('Sorry! We Are Unable To Refund Your Amount'),'error');
				$this->redirect(array('controller'=>'accounts','action'=>'book_jumps'));
			}
		}
		else
		{
			$this->redirect(array('controller'=>'accounts','action'=>'book_jumps'));
		}
	}
	
	
	public function jump_host_payment_fail(){
		$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
	}
	
	public function jump_hosts(){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$title = (isset($_GET['query'])&& $_GET['query'])?$_GET['query']:'';
		$country = (isset($_GET['country'])&& $_GET['country'])?$_GET['country']:'';
		$state = (isset($_GET['state'])&& $_GET['state'])?$_GET['state']:'';
		$city = (isset($_GET['city'])&& $_GET['city'])?$_GET['city']:'';
		
		$title = trim($title);
		$country = trim($country);
		$state = trim($state);
		$city = trim($city);
		$this->set('title',$title);
		$this->set('country',$country);
		$this->set('state',$state);
		$this->set('city',$city);
		
	}
	
	public function jump_host_content(){
		$this->loadModel('JumpHostGallery');
		$this->loadModel('JumpHostReview');
		$this->{$this->modelClass}->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = JumpHost.city_code'
		);
		$title = $this->request->data['title'];
		$country = $this->request->data['country'];
		$state = $this->request->data['state'];
		$city = $this->request->data['city'];
		$conditions = array();
		
		if(!empty($country))
		{
			$conditions[] =  array($this->modelClass.'.country_code' => $country);
		}
		if(!empty($state))
		{
			$conditions[] =  array($this->modelClass.'.state_code' => $state);
		}
		if(!empty($city))
		{
			$conditions[] =  array($this->modelClass.'.city_code' => $city);
		}
		$conditions[] =  array($this->modelClass.'.status'=>1);
		$conditions[] =  array($this->modelClass.'.is_deleted'=>'No');
		$conditions[] =  array($this->modelClass.'.title LIKE'=>'%'.$title.'%');
		
		
		$this->Paginator->settings = array(
				'conditions'=>$conditions,
				'limit' => 3,
				'order' => $this->modelClass.'.created desc',
				'paramType' => 'querystring'
			);
			
		$jumpHost_record = $this->Paginator->paginate();
		
		$record = array();
		foreach($jumpHost_record as $key => $value){
			$jumpHost_record[$key]['JumpHost']['image'] = $this->JumpHostGallery->primaryJumpImage($value['JumpHost']['id']);
			$jumpHost_record[$key]['JumpHost']['image'] = $jumpHost_record[$key]['JumpHost']['image']['JumpHostGallery']['file_name'];	
			$jumpHost_record[$key]['JumpHost']['rating'] = $this->JumpHostReview->find('all',array('conditions'=>array('JumpHostReview.jump_host_id'=>$value['JumpHost']['id'],'status'=>1),'fields'=>array('rating')));
			$count = 0;
			$i = 0;
			if($jumpHost_record[$key]['JumpHost']['rating'])
			{
				foreach($jumpHost_record[$key]['JumpHost']['rating'] as $key1 => $value1){
					$i++;
					$count = $value1['JumpHostReview']['rating'] + $count;
				}
				$jumpHost_record[$key]['JumpHost']['rating'] = $count / $i ;
			}
			else
			{
				$jumpHost_record[$key]['JumpHost']['rating'] = 0;
			}
			$jumpHost_record[$key]['JumpHost']['review'] = $this->JumpHostReview->find('count',array('conditions'=>array('JumpHostReview.jump_host_id'=>$value['JumpHost']['id'],'status'=>1)));
			$record[$key]['id'] 			= $value['JumpHost']['id'];
			$record[$key]['slug'] 			= $value['JumpHost']['slug'];
			$record[$key]['title']		 	= $value['JumpHost']['title'];
			$record[$key]['description'] 	= $this->showLimitedText($value['JumpHost']['description'],90);
			$record[$key]['city']			= $value['JumpHost']['city'];
			$record[$key]['price'] 			= round($value['JumpHost']['price']);
			$record[$key]['address_line_1'] = $value['JumpHost']['address_line_1'];
			$record[$key]['address_line_2'] = $value['JumpHost']['address_line_2'];
			$record[$key]['detail_url']		= WEBSITE_URL.'jump_hosts/detail/'.$record[$key]['slug'];
			$record[$key]['rating']			= round($jumpHost_record[$key]['JumpHost']['rating']);
			$record[$key]['review']			= $jumpHost_record[$key]['JumpHost']['review'];
			$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
			$file_name		=	$jumpHost_record[$key]['JumpHost']['image'];
			$base_encode 	=	base64_encode($file_path);
			if($file_name && file_exists($file_path . $file_name)) 
			{
				$record[$key]['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/180/180/'. $base_encode.'/'.$file_name;
			}	
			else
			{
				$record[$key]['image_url'] = '';
			}
			//$record[$key]['next_limit']	= $limit + 2;
			
		}
		//pr($record); die;
		$this->set('record',$record);
		$this->render('jumpHost_content','ajax');
	}
	
	public function booking_history($slug = null){
		$this->set('left_part_user_id',$this->Auth->user('id'));
		$this->loadModel('BookingJumpHost');
		$jumpHost_Record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1)));
		$this->checkRecordIsNull($jumpHost_Record);
		$this->BookingJumpHost->bindModel(array(
										'belongsTo' => array(
											'User' => array(
												'className'     => 'User',
												//'conditions'    => array('User.status' => 1),
												'order'         => '',
												'foreignKey'    => 'buyer_id'
											)
										)
									));
									
		$this->BookingJumpHost->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
			'country' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code'
		);
		$booking_Record = $this->BookingJumpHost->find('all',array('conditions'=>array('BookingJumpHost.jump_host_id'=>$jumpHost_Record['JumpHost']['id']),'order'=>'BookingJumpHost.created DESC'));
		$this->set('booking_Record',$booking_Record);
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
	
	function profile_user_jump_rental($slug = null){
		$this->set('left_menu_selected','My_Jump_Host');
		$this->loadModel('User');
		$profile_user_data = $this->User->findBySlug($slug);
		$this->set('left_part_user_id',$profile_user_data['User']['id']);
	}
	
	public function profile_user_jump_rental_content(){
		$user_id = $this->request->data['user_id'];
		$this->loadModel('JumpHost');
		$this->loadModel('JumpHostGallery');
		$this->loadModel('JumpHostReview');
		$this->JumpHost->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = JumpHost.city_code',
			'country' => 'SELECT country_name FROM countries WHERE iso_code = JumpHost.country_code'
		);
		
		$this->Paginator->settings = array(
			'JumpHost'=>array(
				'conditions'=>array('JumpHost.user_id'=>$user_id,'JumpHost.status'=>1,'JumpHost.is_deleted'=>'No'),
				'limit' => 3,
				'order' => 'JumpHost.created desc',
				'paramType' => 'querystring'
			)
		);
		$jump_rental_record = $this->Paginator->paginate('JumpHost');
		foreach($jump_rental_record as $key =>$value)
		{	
			$jump_rental_record[$key]['JumpHost']['convertAmount'] =  $this->convertCurrencyUSDToLocal($value['JumpHost']['price']);
			$jump_rental_record[$key]['JumpHost']['image'] = $this->JumpHostGallery->primaryJumpImage($value['JumpHost']['id']);
			$jump_rental_record[$key]['JumpHost']['image'] = $jump_rental_record[$key]['JumpHost']['image']['JumpHostGallery']['file_name'];
			$jump_rental_record[$key]['JumpHost']['detail_url'] =  WEBSITE_URL.'jump_hosts/detail/'.$value['JumpHost']['slug'];
			$jump_rental_record[$key]['JumpHost']['rating'] = $this->JumpHostReview->find('all',array('conditions'=>array('JumpHostReview.jump_host_id'=>$value['JumpHost']['id'],'status'=>1),'fields'=>array('rating')));
			$count = 0;
			$i = 0;
			if($jump_rental_record[$key]['JumpHost']['rating'])
			{
				foreach($jump_rental_record[$key]['JumpHost']['rating'] as $key1 => $value1){
					$i++;
					$count = $value1['JumpHostReview']['rating'] + $count;
				}
				$jump_rental_record[$key]['JumpHost']['rating'] = $count / $i ;
			}
			else
			{
				$jump_rental_record[$key]['JumpHost']['rating'] = 0;
			}
			$jump_rental_record[$key]['JumpHost']['review'] = $this->JumpHostReview->find('count',array('conditions'=>array('JumpHostReview.jump_host_id'=>$value['JumpHost']['id'],'status'=>1)));
		}
		//pr($jump_rental_record); die;
		$this->set('record',$jump_rental_record);
		$this->render('profile_user_jump_rental_content','ajax');
	}
	
}
