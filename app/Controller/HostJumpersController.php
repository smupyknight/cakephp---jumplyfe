<?php 
class HostJumpersController extends AppController{
	public $helper = array('Form','Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('show_wallet_records','wallet_payment_success','wallet_payment_fail','hostJumper_Payment'));
	}
	
	public function index($slug = null){
		$this->set('left_menu_selected','My_Host_Jumper');	
		$this->loadModel('User');
		$this->loadModel('Jump');
		$this->loadModel('HostJumperReview');
		$host_jumper = $this->User->find('first',array('conditions'=>array('User.slug'=>$slug,'User.status'=>1,'User.is_host_jumper'=>'Yes'),'fields'=>array('User.host_jumper_about_me','User.host_jumper_price','User.id','User.slug')));
		
		$host_jumper['User']['convertPrice']  = $this->convertCurrencyUSDToLocal($host_jumper['User']['host_jumper_price']);
		
		$this->checkRecordIsNull($host_jumper);
		$this->set('left_part_user_id',$host_jumper['User']['id']);
		$this->set('host_jumper',$host_jumper);
		$jumpList = $this->Jump->find('list',array('conditions'=>array('Jump.user_id'=>$this->Auth->user('id'),'Jump.status'=>1,'Jump.is_deleted'=>'No'),'fields'=>array('Jump.id','Jump.title')));
		//pr($jumpList); die;
		$this->set('jumpList',$jumpList);
		
		$review_record = $this->HostJumperReview->find('all',array('conditions'=>array('HostJumperReview.host_jumper_id'=>$host_jumper['User']['id'],'HostJumperReview.status'=>1),'order'=>'HostJumperReview.created DESC'));
		foreach($review_record as $key => $value){
			$review_record[$key]['User']  =  $this->User->find('first',array('conditions'=>array('User.id'=>$value['HostJumperReview']['user_id'])));
		}
		$this->set('review_record',$review_record);
		
		$write_review_button = $this->HostJumperReview->find('first',array('conditions'=>array('HostJumperReview.host_jumper_id'=>$host_jumper['User']['id'],'HostJumperReview.user_id'=>$this->Auth->user('id'))));
		$this->set('write_review_button',$write_review_button);
		
	}
	
	public function my_account(){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
	}
	
	public function about_me(){
		$this->set('left_menu_selected','My_Host_Jumper');	
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$this->loadModel('User');
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'),'User.status'=>1),'fields'=>array('User.host_jumper_about_me','User.host_jumper_price','User.is_host_jumper')));
		if($user['User']['is_host_jumper'] == 'Yes')
		{
			$this->set('status','checked');
		}
		else
		{
			$this->set('status','');
		}
		if($this->request->is('post') || $this->request->is('put')){
			$this->request->data[$this->modelClass] = $this->request->data['User'];
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if($this->{$this->modelClass}->basic_information_validate()){	
				$data = array();
				$this->User->id = $user['User']['id'];
				$data['host_jumper_about_me']  = strip_tags(trim($this->data{$this->modelClass}['host_jumper_about_me']));
				$data['host_jumper_price']     = trim($this->data{$this->modelClass}['host_jumper_price']);
				if($this->User->save($data,false)){
					$success = true;
					$message = 'Your Information Has Been Updated Successfully';
					$dataResponse['selfReload'] = true;
				}
				else{
					$success = false;
					$message = 'Error: Could Not Updated Your Information! Please try Agian later';
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['message'] = $message;
			$dataResponse['scrollToThisForm'] = true;
			echo json_encode($dataResponse); die;
		}
		else
		{
			$this->request->data = $user;
		}
	}
	
	public function host_jumper_booking(){
		$this->loadModel('User');
		if($this->request->is('post')){
			$this->loadModel('HostJumperBooking');
			$this->loadModel('HostJumperBookingRequest');
			$this->loadModel('TmpInvoice');
			$this->request->data[$this->modelClass] = $this->request->data['HostJumperBooking'];
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if($this->{$this->modelClass}->bookingFormValidate()){	
				$buyer_id = $this->Auth->user('id');
				$buyer_record = $this->User->find('first',array('conditions'=>array('User.status'=>1,'User.id'=>$buyer_id),'fields'=>array('User.wallet_balance')));
				$buyer_wallet_amount = $buyer_record['User']['wallet_balance'];
				$host_jumper_price	 = $this->request->data[$this->modelClass]['host_jumper_price'];
				$host_jumper_booking_date	 = date('Y-m-d',strtotime($this->request->data[$this->modelClass]['booking_for_date']));
				
				$already_book = $this->HostJumperBooking->find('first',array('conditions'=>array('HostJumperBooking.booking_for_date'=>$host_jumper_booking_date,'HostJumperBooking.status'=>1)));
				if($already_book)
				{
					$success = false;
					$message = 'A host jumper already book on this date';
				}
				else
				{
					
					$str =  '0123456789';
					$rand_string = substr(str_shuffle($str),0,5); 
					$user_id = $this->Auth->user('id');
					$invoice_id = time().$rand_string.'-'.$user_id;
					$data = array();
					$data['HostJumperBookingRequest']['invoice_id'] 	= $invoice_id;
					$data['HostJumperBookingRequest']['jump_id'] 		= $this->request->data[$this->modelClass]['jump_id'];
					$data['HostJumperBookingRequest']['host_jumper_id'] = $this->request->data[$this->modelClass]['host_jumper_id'];
					$data['HostJumperBookingRequest']['buyer_id'] 		= $buyer_id;
					$data['HostJumperBookingRequest']['booking_for_date'] = $host_jumper_booking_date;
					$data['HostJumperBookingRequest']['paid_amount'] 	= $host_jumper_price;
					$this->HostJumperBookingRequest->create();
					$saveRecord = $this->HostJumperBookingRequest->save($data,false);
					if(!empty($saveRecord)){
						$this->loadModel('TransactionCharge');
						$TransactionCharge_Record = $this->TransactionCharge->find('first',array('conditions'=>array('TransactionCharge.status'=>1,'TransactionCharge.transaction_type'=>'Host_Jumper')));
						
						$record = array();
						if(!empty($TransactionCharge_Record))
						{
							if($TransactionCharge_Record['TransactionCharge']['fees_type'] == 'Percent'){
								$chargeable_fees  = $TransactionCharge_Record['TransactionCharge']['transaction_fees'];
								$record['payment_charges'] = $chargeable_fees / 100 * $host_jumper_price;
							}
							else
							{
								$record['payment_charges'] = $TransactionCharge_Record['TransactionCharge']['transaction_fees'];
							}
						}
						else
						{
							$record['payment_charges']	= 0;
						}
						
						$record['invoice_id'] 			= $invoice_id;
						$record['user_id'] 				= $user_id;
						$record['amount'] 				= $host_jumper_price;
						$record['payment_method'] 		= false;
						$record['payment_status']		= 'Pending';
						$record['payment_for_type'] 	= 'Book_Host_Jumper';
						$record['skip_wallet']			= false;
						$record['target_id'] 			= $saveRecord['HostJumperBookingRequest']['id'];
						$record['total_payable_amout'] 	= $host_jumper_price + $record['payment_charges'];
						$record['success_return_url'] 	= WEBSITE_URL.'host_jumpers/payment_success';
						$record['failure_return_url'] 	= WEBSITE_URL.'host_jumpers/payment_fail';
						$record['ipn_callback_url'] 	= WEBSITE_URL.'host_jumpers/payment_success';
						$record['payment_title'] 		= 'Host Jumper Booking';
						$record['payment_description'] 	= 'Host Jumper Booking';
						$record['checkout_title'] 	 	= 'Host Jumper Booking';
						$record['checkout_description'] = 'You can book host jumper through Paypal, Credit Card, Wallet.';
						if($this->TmpInvoice->save($record,false)){
							$this->Session->write('invoice_id',$invoice_id);
							$success = true;
							$message = 'Please Wait..';
							$dataResponse['redirectURL'] =  Router::url(array('plugin'=>false,'controller'=>'checkouts','action'=>'index'));
						}
						else
						{
							$success = false;
							$message = 'Some error occurred..Please try again later';	
						}
					}
					else
					{
						$success = false;
						$message = 'Some error occurred..Please try again later';	
					}
				}	
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['message'] = $message;
			$dataResponse['notify'] = true;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function payment_success($invoice_id = null){
		$this->loadModel('TmpInvoice');
		$this->loadModel('HostJumperBookingRequest');
		$this->loadModel('HostJumperBooking');
		$this->loadModel('User');
		$TmpInvoice_record = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
		
		$this->HostJumperBookingRequest->bindModel(array(
											'belongsTo' => array(
												'host_jumper' => array(
													'className'     => 'User',
													'order'         => '',
													'foreignKey'    => 'host_jumper_id'
												),
												'buyer_host_jumper' => array(
													'className'     => 'User',
													'order'         => '',
													'foreignKey'    => 'buyer_id'
												)
											)
										));
		
		$HostJumperBookingRequest = $this->HostJumperBookingRequest->findById($TmpInvoice_record['TmpInvoice']['target_id']);
	
		$this->checkRecordIsNull($TmpInvoice_record);
		$this->checkRecordIsNull($HostJumperBookingRequest);
		
		$data = array();
		$data['invoice_id'] 		= $invoice_id;
		$data['jump_id'] 			= $HostJumperBookingRequest['HostJumperBookingRequest']['jump_id'];
		$data['host_jumper_id'] 	= $HostJumperBookingRequest['HostJumperBookingRequest']['host_jumper_id'];
		$data['buyer_id'] 			= $HostJumperBookingRequest['HostJumperBookingRequest']['buyer_id'];
		$data['booking_for_date']	= $HostJumperBookingRequest['HostJumperBookingRequest']['booking_for_date'];
		$data['paid_amount'] 		= $HostJumperBookingRequest['HostJumperBookingRequest']['paid_amount'];
		
		$this->HostJumperBooking->create();
		if($this->HostJumperBooking->save($data,false))
		{
			$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
			$site_title = Configure::read("Site.title");
			$this->loadModel('EmailTemplate');
			$buyer_email_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"booking_host_jumper_buyer",'EmailTemplate.status'=>1)));
			if(isset($buyer_email_record) && !empty($buyer_email_record)){
				
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
				
				$body = $buyer_email_record['EmailTemplate']['body'];
				$string = str_replace('{#logo}',$logo,$body);
				$string = str_replace('{#host_jumper_name}',ucfirst($HostJumperBookingRequest['host_jumper']['firstname']).' '.ucfirst($HostJumperBookingRequest['host_jumper']['lastname']),$string);
				$string = str_replace('{#host_jumper_buyer_name}',ucfirst($HostJumperBookingRequest['buyer_host_jumper']['firstname']).' '.ucfirst($HostJumperBookingRequest['buyer_host_jumper']['lastname']),$string);
				$string = str_replace('{#site_title}',$site_title,$string);
				$string = str_replace('{#buyer_email}',$HostJumperBookingRequest['buyer_host_jumper']['email'],$string);
				$string = str_replace('{#host_jumper_email}',$HostJumperBookingRequest['host_jumper']['email'],$string);
				$string = str_replace('{#price}',$TmpInvoice_record['TmpInvoice']['amount'],$string);
				$string = str_replace('{#booking_for_date}',$HostJumperBookingRequest['HostJumperBookingRequest']['booking_for_date'],$string);
				$string = str_replace('{#booking_date_time}',date('Y-m-d',strtotime($HostJumperBookingRequest['HostJumperBookingRequest']['created'])),$string);
				$Email->delivery = "smtp";
				$Email->from = MAIL_FROM;
				$Email->to = $HostJumperBookingRequest['buyer_host_jumper']['email'];
				$Email->subject = $buyer_email_record['EmailTemplate']['subject'];
				$Email->sendAs = 'html';
				$Email->send($string);
			}
			
			
			$seller_email_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"booking_host_jumper_owner",'EmailTemplate.status'=>1)));
			if(isset($seller_email_record) && !empty($seller_email_record)){
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
			
				$body1 = $seller_email_record['EmailTemplate']['body'];
				$string1 = str_replace('{#logo}',$logo,$body1);
				$string1 = str_replace('{#host_jumper_name}',ucfirst($HostJumperBookingRequest['host_jumper']['firstname']).' '.ucfirst($HostJumperBookingRequest['host_jumper']['lastname']),$string1);
				$string1 = str_replace('{#host_jumper_buyer_name}',ucfirst($HostJumperBookingRequest['buyer_host_jumper']['firstname']).' '.ucfirst($HostJumperBookingRequest['buyer_host_jumper']['lastname']),$string1);
				$string1 = str_replace('{#site_title}',$site_title,$string1);
				$string1 = str_replace('{#buyer_email}',$HostJumperBookingRequest['buyer_host_jumper']['email'],$string1);
				$string1 = str_replace('{#host_jumper_email}',$HostJumperBookingRequest['host_jumper']['email'],$string1);
				$string1 = str_replace('{#price}',$TmpInvoice_record['TmpInvoice']['amount'],$string1);
				$string1 = str_replace('{#booking_for_date}',$HostJumperBookingRequest['HostJumperBookingRequest']['booking_for_date'],$string1);
				$string1 = str_replace('{#booking_date_time}',date('Y-m-d',strtotime($HostJumperBookingRequest['HostJumperBookingRequest']['created'])),$string1);
				$Email->delivery = "smtp";
				$Email->from = MAIL_FROM;
				$Email->to = $HostJumperBookingRequest['host_jumper']['email'];
				$Email->subject = $seller_email_record['EmailTemplate']['subject'];
				$Email->sendAs = 'html';
				$Email->send($string1);
			}
				
			$this->Session->setFlash("You successfully booked a hostjumper",'success');
			$this->redirect(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'index',$HostJumperBookingRequest['host_jumper']['slug']));	
		}
		else
		{
			$this->Session->setFlash("Some error occurred..Please try again later",'error');
			$this->redirect(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'index',$hostJumper['User']['slug']));	
		}
	}
	
	public function payment_fail(){
		$this->Session->setFlash("Some error occurred..Please try again later");
		$this->redirect(array('plugin'=>false,'controller'=>'checkouts','action'=>'index'));
	}
	
	public function my_bookings(){
		$this->set('left_menu_selected','My_Host_Jumper');	
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$this->loadModel('HostJumperBooking');
		$this->HostJumperBooking->virtualFields = array(
				'city' => 'SELECT city_name FROM cities WHERE id = Jump.city_code',
				'country' => 'SELECT country_name FROM countries WHERE iso_code = Jump.country_code'
			);
		$bookings = $this->HostJumperBooking->find('all',array('conditions'=>array('HostJumperBooking.host_jumper_id'=>$this->Auth->user('id'),'HostJumperBooking.status'=>1),'order'=>'HostJumperBooking.created DESC'));
		$this->set('bookings',$bookings);
		$this->set('top_menu_selected','HostJumper');
	}	
	
	public function is_host_jumper(){
		//pr($this->request->data); die;
		$this->loadModel('User');
		$user_id = $this->Auth->user('id');
		if($this->request->data['state'] == 'true')
		{
			$data = array();
			$data['is_host_jumper'] = 'Yes';
			$this->User->id = $user_id;
			$this->User->save($data,false);
		}
		else
		{
			$data1 = array();
			$data1['is_host_jumper'] = 'No';
			$this->User->id = $user_id;
			$this->User->save($data1,false);
		}
		$dataResponse['success'] = true;
		echo json_encode($dataResponse); die;
	}
	
	function hostJumper_review($slug = null){
		$this->loadModel('User');
		$this->loadModel('HostJumperReview');
		if($this->request->is('post')){
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if ($this->{$this->modelClass}->HostJumperReviews()){
				$host_jumper_record = $this->User->find('first',array('conditions'=>array('User.slug'=>$slug,'User.is_host_jumper'=>'Yes','User.status'=>1),'fields'=>array('User.id')));
				$this->checkRecordIsNull($host_jumper_record);
				$data 					  = array();
				$data['user_id'] 	 	  = $this->Auth->user('id');
				$data['host_jumper_id']	  = $host_jumper_record['User']['id'];
				$data['comment']	 	  = trim($this->request->data[$this->modelClass]['comment']);
				$data['rating']	      	  = $this->request->data[$this->modelClass]['rating'];
				$this->HostJumperReview->create();
				if($this->HostJumperReview->save($data,false)){
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
	
	public function payments(){
		$this->set('left_menu_selected','My_Host_Jumper');	
		$this->set('left_part_user_id',$this->Auth->User('id'));
		$this->loadModel('HostJumperBooking');
		$this->Paginator->settings = array(
			'HostJumperBooking'=>array(
				'conditions'=>array('HostJumperBooking.host_jumper_id'=>$this->Auth->User('id'),'HostJumperBooking.is_amount_transferred_to_host_jumper'=>'Yes'),
				'limit' => 10,
				'order' => 'HostJumperBooking.created desc',
				'paramType' => 'querystring'
			)
		);
		
		$this->set('paymentDetails',$this->Paginator->paginate('HostJumperBooking'));
	}
	
	public function hostJumper_Payment(){
		$this->loadModel('HostJumperBooking');
		$this->loadModel('User');
		$this->loadModel('UserWalletTransaction');
		$pay_Date = date('Y-m-d',strtotime('-1 day',time()));
		$bookings = $this->HostJumperBooking->find('all',array('conditions'=>array('HostJumperBooking.is_cancelled'=>'No','HostJumperBooking.status'=>1,'HostJumperBooking.is_amount_transferred_to_host_jumper'=>'No','HostJumperBooking.booking_for_date <'=> $pay_Date)));
		
		if(isset($bookings) && !empty($bookings)){
			foreach($bookings as $key =>$value){
				
				$wallet_record = array();
				$wallet_record['UserWalletTransaction']['user_id'] = $value['HostJumperBooking']['host_jumper_id'];
				$wallet_record['UserWalletTransaction']['transaction_type'] = 'Added';
				$wallet_record['UserWalletTransaction']['invoice_id'] = $value['HostJumperBooking']['invoice_id'];
				$wallet_record['UserWalletTransaction']['amount'] = $value['HostJumperBooking']['paid_amount'];
				$wallet_record['UserWalletTransaction']['transaction_identifier'] = 'EARNING_HOST_JUMPER';
				$wallet_record['UserWalletTransaction']['comments'] = 'Earning Host Jumper';
				$this->UserWalletTransaction->create();
				$wallet_savedata = $this->UserWalletTransaction->save($wallet_record,false);
				
				$this->User->updateAll(
					array('User.wallet_balance' => 'User.wallet_balance +'. $wallet_record['UserWalletTransaction']['amount']),
					array('User.id' => $wallet_record['UserWalletTransaction']['user_id'])
				);
			
				$available_wallet_balance = $this->User->findById($wallet_record['UserWalletTransaction']['user_id'],array('fields'=>'User.wallet_balance'));
				
				$balance = $available_wallet_balance['User']['wallet_balance'];
				
				$this->UserWalletTransaction->updateAll(
						array('UserWalletTransaction.available_balance' => "'$balance'"),
						array('UserWalletTransaction.id' => $wallet_savedata['UserWalletTransaction']['id'])
					);
				
				$data = array();
				$data['HostJumperBooking']['is_amount_transferred_to_host_jumper'] = 'Yes';
				$data['HostJumperBooking']['amount_transferred_date'] = date('Y-m-d');
				$this->HostJumperBooking->id =  $value['HostJumperBooking']['id'];
				$this->HostJumperBooking->save($data,false);
				
				
			}
		}
		else 
		{
			echo "No Record Found"; 
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
	
	
	
}
