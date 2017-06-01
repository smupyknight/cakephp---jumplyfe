<?php 
App::uses('Paypal', 'Paypal.Lib'); 
class CheckoutsController extends AppController{
	public $helper = array('Form','Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('index','paypal','success_paypal','failure_paypal','paypal_payment','paypalresponse','payWithWallet'));
		 App::import('Vendor', 'quickbooks/QuickBooks');
	}
	function index($tt = false)
	{
		$invoice_id = $this->Session->read('invoice_id');
		//pr($invoice_id); die;
		$this->loadModel('TmpInvoice');
		$record = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
		$this->checkRecordIsNull($record);
		$this->set('record',$record);
		if($record['TmpInvoice']['payment_method'] == 'Wallet')
		{
			$this->payWithWallet($invoice_id);
		}
	}
	function payWithCC()
	{
		$success = false;
		if($this->request->isAjax()){
			$this->loadModel('TmpInvoice');
			$invoice_id = $this->Session->read('invoice_id');
			$record = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
			if(isset($record) && !empty($record)){
				$this->loadModel('StripeModal');
				$this->StripeModal->set($this->request->data);
				if ($this->StripeModal->cc_information_validate()){
					$name 			= $this->request->data['StripeModal']['full_name'];
					$number 		= $this->request->data['StripeModal']['card_number'];
					$exp_month 		= $this->request->data['StripeModal']['exp_month'];
					$exp_year 		= $this->request->data['StripeModal']['exp_year'];
					$cvc 			= $this->request->data['StripeModal']['cvc'];
					App::import('Vendor', 'Stripe/Stripe');
					Stripe::setApiKey("sk_test_moKwo4UR4MLgNS1DzOwLQ0hV");
					try {
					$result = Stripe_Token::create(
						array(
								"card" => array(
									"name" => $name,
									"number" => $number,
									"exp_month" => $exp_month,
									"exp_year" => $exp_year,
									"cvc" => $cvc
								)
							)
						);

						$token = $result['id'];
						$success = true;
					}
					catch(Stripe_CardError $e) {
						  $error1 = $e->getMessage();
						  $error = $error1;
					} catch (Stripe_InvalidRequestError $e) {
					  // Invalid parameters were supplied to Stripe's API
					  $error2 = $e->getMessage();
					   $error = $error2;
					} catch (Stripe_AuthenticationError $e) {
					  // Authentication with Stripe's API failed
					  $error3 = $e->getMessage();
					   $error = $error3;
					} catch (Stripe_ApiConnectionError $e) {
					  // Network communication with Stripe failed
					  $error4 = $e->getMessage();
					   $error = $error4;
					} catch (Stripe_Error $e) {
					  // Display a very generic error to the user, and maybe send
					  // yourself an email
					  $error5 = $e->getMessage();
					  $error = $error5;
					} catch (Exception $e) {
					  // Something else happened, completely unrelated to Stripe
					  $error6 = $e->getMessage();
					  $error = $error6;
					}


					if($success)
					{
						$success = false;


						try {
						    $charge = Stripe_Charge::create(array(
								  "amount" => $record['TmpInvoice']['total_payable_amout'] * 100,
								  "currency" => "usd",
								  "card" => $token,
								  "description" => $invoice_id 
							));
							$response = $charge->__toArray(true);

							if(isset($response['status']) && $response['status'] == 'succeeded' && !empty($response['paid'])){
								$data = array();
								$data['TmpInvoice']['txn_id']  			=  $response['id'];	
								$data['TmpInvoice']['payment_method']  	=  'Credit_Card';	
								$data['TmpInvoice']['payment_status']  	=  'Paid';	
								$this->TmpInvoice->id = $record['TmpInvoice']['id'];
								$this->TmpInvoice->save($data,false);
								$success = true;
								$message = 'Payment Successful, please wait...';
								$dataResponse['redirectURL'] = $record['TmpInvoice']['success_return_url'].'/'.$invoice_id;
							}

						} catch(Stripe_CardError $e) {
						  $error1 = $e->getMessage();
						  $error = $error1;
						} catch (Stripe_InvalidRequestError $e) {
						  // Invalid parameters were supplied to Stripe's API
						  $error2 = $e->getMessage();
						   $error = $error2;
						} catch (Stripe_AuthenticationError $e) {
						  // Authentication with Stripe's API failed
						  $error3 = $e->getMessage();
						   $error = $error3;
						} catch (Stripe_ApiConnectionError $e) {
						  // Network communication with Stripe failed
						  $error4 = $e->getMessage();
						   $error = $error4;
						} catch (Stripe_Error $e) {
						  // Display a very generic error to the user, and maybe send
						  // yourself an email
						  $error5 = $e->getMessage();
						  $error = $error5;
						} catch (Exception $e) {
						  // Something else happened, completely unrelated to Stripe
						  $error6 = $e->getMessage();
						  $error = $error6;
						}
						if(!$success)
						{
							$message = $error;
							
						}
					}
					else
					{
						$message = $error;
					}
						
				}
				else
				{
				
					$errors = $this->StripeModal->validationErrors;
					$success = false;
					$message = $this->formatErrors($this->StripeModal->validationErrors);
				}
			}
			else
			{
				
				$success = false;
				$message = 'Some error occurred please try again later';
				
			}			
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;		
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
		
	public function paypal(){
		$invoice_id = $this->Session->read('invoice_id');
		$this->loadModel('TmpInvoice');
		$record = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id),'fields'=>array('payment_method')));
		$this->checkRecordIsNull($record);
		if(!$invoice_id)
		{
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		$this->loadModel('TmpInvoice');
		$data = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
		$this->checkRecordIsNull($data);
		$this->Paypal = new Paypal(array(
			'sandboxMode' => true,
			'nvpUsername' => PAYPAL_USERNAME,
			'nvpPassword' => PAYPAL_PASSWORD,
			'nvpSignature' => PAYPAL_SIGNATURE
		));	
		
		$order = array(
			'description' => $data['TmpInvoice']['payment_description'],
			'currency' => 'USD',
			'return' => WEBSITE_URL.'checkouts/success_paypal',
			'cancel' => WEBSITE_URL.'checkouts/failure_paypal',
			'custom' => $invoice_id,
			'items' => array(
				0 => array(
					'name' => $data['TmpInvoice']['payment_title'],
					'description' => $data['TmpInvoice']['payment_description'],
					//'tax' => 2.00,
					'subtotal' => $data['TmpInvoice']['total_payable_amout'],
					'qty' => $data['TmpInvoice']['quantity'],
				),
			)
		);
		
		$this->redirect($this->Paypal->setExpressCheckout($order));	
	}
	
	public function success_paypal(){
		$token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
		$this->Paypal = new Paypal(array(
			'sandboxMode' => true,
			'nvpUsername' => PAYPAL_USERNAME,
			'nvpPassword' => PAYPAL_PASSWORD,
			'nvpSignature' => PAYPAL_SIGNATURE
		));
		
		try {
			$info = $this->Paypal->getExpressCheckoutDetails($token,$payer_id);
			$this->paypal_payment($info);
		} catch (Exception $e) {
			// $e->getMessage();
		}   
		
	}
	
	public function failure_paypal(){  
		$this->redirect(array('plugin'=>false,'controller'=>'accounts','action'=>'wallet_payment_fail'));
	}

	public function paypal_payment($info = null){
		if(!$info){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		$token = $info['TOKEN'];
		$payerId = $info['PAYERID'];
		$this->loadModel('TmpInvoice');
		$data = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$info['CUSTOM'])));
		$this->Paypal = new Paypal(array(
			'sandboxMode' => true,
			'nvpUsername' => PAYPAL_USERNAME,
			'nvpPassword' => PAYPAL_PASSWORD,
			'nvpSignature' => PAYPAL_SIGNATURE
		));	
		$order = array(
			'description' => $data['TmpInvoice']['payment_description'],
			'currency' => 'USD',
			'return' => WEBSITE_URL.'checkouts/success_paypal',
			'cancel' => WEBSITE_URL.'checkouts/failure_paypal',
			'custom' => $info['CUSTOM'],
			'items' => array(
				0 => array(
					'name' => $data['TmpInvoice']['payment_title'],
					'description' => $data['TmpInvoice']['payment_description'],
					//'tax' => 2.00,
					'subtotal' => $data['TmpInvoice']['total_payable_amout'],
					'qty' => $data['TmpInvoice']['quantity'],
				),
			)
		);
		try {
			$this->Paypal->doExpressCheckoutPayment($order, $token, $payerId);
			$paypal_record = $this->Paypal->getExpressCheckoutDetails($token);
			$this->paypalresponse($paypal_record);
		} catch (PaypalRedirectException $e) {
			$this->redirect($e->getMessage());
			} catch (Exception $e) {
				// $e->getMessage();
			}  
	}
	
	public function paypalresponse($paypal_record = null){
		if(!$paypal_record){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		//pr($paypal_record); die;
		$this->loadModel('TmpInvoice');
		$data = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$paypal_record['CUSTOM'])));
		if($data['TmpInvoice']['is_execution_done'] == 'No'){
			$this->TmpInvoice->id = $data['TmpInvoice']['id'];
			$time = time();
			$date = date('Y,m,d h:i:s',time());
			$update_data = array();
			$update_data['txn_id'] = $paypal_record['TOKEN'];
			$update_data['payment_status'] = 'Paid';
			$update_data['payment_date_time'] = $date;
			$update_data['payment_time'] = $time;
			if($this->TmpInvoice->save($update_data)){	//$this->redirect(array('plugin'=>false,'controller'=>'accounts','action'=>'wallet_payment_success',$paypal_record['CUSTOM']));
				$this->redirect($data['TmpInvoice']['success_return_url'].'/'.$paypal_record['CUSTOM']);
			}
		}
		else
		{
			$this->Session->setFlash("Something error occurred..Please try again later or use other payment gateway");
			$this->redirect(array('plugin'=>false,'controller'=>'checkouts','action'=>'index'));
		}
	}
	
	public function payWithWallet(){
		$this->loadModel('User');
		$this->loadModel('TmpInvoice');
		$this->loadModel('UserWalletTransaction');
		$invoice_id = $this->Session->read('invoice_id');
		$data = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
		if(empty($data))
		{
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		$this->checkRecordIsNull($data);
		$user_id = $data['TmpInvoice']['user_id'];
		$user_record = $this->User->find('first',array('conditions'=>array('User.status'=>1,'User.id'=>$user_id),'fields'=>array('User.wallet_balance')));
		$this->checkRecordIsNull($user_record);
		
		if($user_record['User']['wallet_balance'] >= $data['TmpInvoice']['total_payable_amout']){
			if($data['TmpInvoice']['is_execution_done'] == 'No'){
				$this->TmpInvoice->id = $data['TmpInvoice']['id'];
				$time = time();
				$date = date('Y,m,d h:i:s',time());
				$update_data = array();
				//$update_data['txn_id'] = $paypal_record['TOKEN'];
				$update_data['payment_status'] = 'Paid';
				$update_data['payment_method'] = 'Wallet';
				$update_data['payment_date_time'] = $date;
				$update_data['payment_time'] = $time;
				if($this->TmpInvoice->save($update_data))
				{
					$this->UserWalletTransaction->create();
					$wallet_record = array();
					$wallet_record['user_id'] 					= $data['TmpInvoice']['user_id'];
					$wallet_record['transaction_type'] 			= 'Removed';
					$wallet_record['invoice_id'] 				= $invoice_id;
					$wallet_record['amount'] 					= $data['TmpInvoice']['total_payable_amout'];
					$wallet_record['transaction_identifier'] 	= $data['TmpInvoice']['payment_title'];
					$wallet_record['comments'] 					= $data['TmpInvoice']['payment_description'];
					$wallet_savedata = $this->UserWalletTransaction->save($wallet_record,false);
					
					$this->User->updateAll(
						array('User.wallet_balance' => 'User.wallet_balance -'. $wallet_record['amount']),
						array('User.id' => $wallet_record['user_id'])
					);
					
					$available_wallet_balance = $this->User->findById($wallet_record['user_id'],array('fields'=>'User.wallet_balance'));
					$balance = $available_wallet_balance['User']['wallet_balance'];
					
					$this->UserWalletTransaction->updateAll(
							array('UserWalletTransaction.available_balance' => "'$balance'"),
							array('UserWalletTransaction.id' => $wallet_savedata['UserWalletTransaction']['id'])
						);
					
					$this->redirect($data['TmpInvoice']['success_return_url'].'/'.$invoice_id);
				}
				else
				{
					$this->redirect($data['TmpInvoice']['failure_return_url']);
				} 
			}
			else
			{
				$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
			}
		}
		else
		{
			$this->Session->setFlash("You have a insufficient wallet balance for payment in your wallet");
			$this->redirect(array('plugin'=>false,'controller'=>'checkouts','action'=>'index'));
			
		}
	}
}

