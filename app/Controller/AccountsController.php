<?php 
class AccountsController extends AppController{
	public $helper = array('Form','Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('show_wallet_records','wallet_payment_success','wallet_payment_fail'));
	}
	
	public function wallet(){
		$this->set('left_part_user_id',$this->Auth->User('id'));
		$this->loadModel('UserWalletTransaction');
		$this->loadModel('User');
		$this->Paginator->settings = array(
			'UserWalletTransaction'=>array(
				'conditions'=>array('UserWalletTransaction.user_id'=>$this->Auth->User('id')),
				'limit' => 10,
				'order' => 'UserWalletTransaction.created desc',
				'paramType' => 'querystring'
			)
		);
		$transaction_details = $this->Paginator->paginate('UserWalletTransaction');
		foreach($transaction_details as $key => $value){
			$transaction_details[$key]['UserWalletTransaction']['convertAmount'] = $this->convertCurrencyUSDToLocal($value['UserWalletTransaction']['amount']);
			$transaction_details[$key]['UserWalletTransaction']['convert_available_balance'] = $this->convertCurrencyUSDToLocal($value['UserWalletTransaction']['available_balance']);
			
		}
		$this->set('transaction_details',$transaction_details);
		$current_balance = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->User('id')),'fields'=>array('wallet_balance')));
		$current_balance['User']['convert_walletBalance'] = $this->convertCurrencyUSDToLocal($current_balance['User']['wallet_balance']);
		//pr($current_balance); die;
		$this->set('current_balance',$current_balance);
		$this->set('left_menu_selected','Wallet');
	}
	
	public function deposit(){
		//pr($this->request->data); die;
		if($this->request->is('post')){
			$this->request->data['Account'] = $this->request->data['UserWalletTransaction'];
			$this->{$this->modelClass}->set($this->request->data['Account']);
			if ($this->{$this->modelClass}->validates()){
				$str =  '0123456789';
				$rand_string = substr(str_shuffle($str),0,5); 
				$user_id = $this->Auth->user('id');
				$invoice_id = time().$rand_string.'-'.$user_id;
				$data = array();
				$data['invoice_id'] = $invoice_id;
				$data['user_id'] = $user_id;
				$data['amount'] = trim($this->request->data['UserWalletTransaction']['amount']);
				$data['payment_method'] = 'Paypal';
				$data['payment_status'] = 'Pending';
				$data['payment_for_type'] = 'Wallet';
				$data['target_id'] = 0;
				$data['skip_wallet'] = true;
				$data['total_payable_amout'] = trim($this->request->data['UserWalletTransaction']['amount']);
				$data['success_return_url'] = WEBSITE_URL.'accounts/wallet_payment_success';
				$data['failure_return_url'] = WEBSITE_URL.'accounts/wallet_payment_fail';
				$data['ipn_callback_url'] = WEBSITE_URL.'accounts/wallet_payment_success';
				$data['payment_title'] = 'Deposit in Wallet';
				$data['payment_description'] = 'Deposit in Wallet';
				$data['checkout_title'] 	 = 'Deposit in Wallet';
				$data['checkout_description'] = 'You can deposit amount through Paypal and Credit Card. After then you can buy elite membership plans, elites, jump rentals and host jumpers from our website';
				$this->loadModel('TmpInvoice');
				if($this->TmpInvoice->save($data,false)){
					$this->Session->write('invoice_id',$data['invoice_id']);
					$success = true;
					$message = 'Please Wait..';
					$dataResponse['redirectURL'] =  Router::url(array('plugin'=>false,'controller'=>'checkouts','action'=>'index'));
				}	
			}
			else
			{
				$errors = $this->{$this->modelClass}->validationErrors;
				$success = false;
				$message = $errors['amount'];
			}			
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;		
		}
	}
	
	public function wallet_payment_success($invoice_id = null){
		if(!$invoice_id){
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
		$this->loadModel('TmpInvoice');
		$this->loadModel('UserWalletTransaction');
		$this->loadModel('User');
		$TmpInvoice_record = $this->TmpInvoice->find('first',array('conditions'=>array('TmpInvoice.invoice_id'=>$invoice_id)));
		if($TmpInvoice_record['TmpInvoice']['is_execution_done'] == 'No' && $TmpInvoice_record['TmpInvoice']['payment_status'] == 'Paid'){
			$this->UserWalletTransaction->create();
			$wallet_record = array();
			$wallet_record['user_id'] = $TmpInvoice_record['TmpInvoice']['user_id'];
			$wallet_record['transaction_type'] = 'Added';
			$wallet_record['invoice_id'] = $invoice_id;
			$wallet_record['amount'] = $TmpInvoice_record['TmpInvoice']['amount'];
			$wallet_record['transaction_identifier'] = 'Cash';
			$wallet_record['comments'] = 'Cash Deposit';
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
					
				$this->TmpInvoice->id = $TmpInvoice_record['TmpInvoice']['id'];
				$this->TmpInvoice->saveField('is_execution_done','Yes');
				$this->redirect(array('plugin'=>false,'controller'=>'accounts','action'=>'wallet'));
			}
		}
		else
		{
			$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
		}
	}
	public function wallet_payment_fail(){
	
		$this->redirect(array('plugin'=>false,'controller'=>'welcomes','action'=>'index'));
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
	
	public function show_wallet_records(){
		$this->loadModel('UserWalletTransaction');
		$record = $this->UserWalletTransaction->findById($this->request->data['id']);
		$this->checkRecordIsNull($record);
		$record['UserWalletTransaction']['convertAmount'] = $this->convertCurrencyUSDToLocal($record['UserWalletTransaction']['amount']);
		$record['UserWalletTransaction']['convert_available_balance'] = $this->convertCurrencyUSDToLocal($record['UserWalletTransaction']['available_balance']);
		$data['success'] = true;
		$data['record'] = $record['UserWalletTransaction'];
		$data['record']['created'] = date('m/d/y h:i A',strtotime($data['record']['created']));
		echo json_encode($data); die; 
	}
	
	public function book_jumps(){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
	}

	public function booked_jump_host_content(){
		$user_id = $this->Auth->User('id');
		$this->loadModel('BookingJumpHost');
		$this->loadModel('JumpHost');
		$this->loadModel('JumpHostGallery');
		
		$this->JumpHost->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = JumpHost.city_code',
			'country' => 'SELECT country_name FROM countries WHERE iso_code = JumpHost.country_code'
		);
		$this->BookingJumpHost->bindModel(array(
								'belongsTo' => array(
									'JumpHost' => array(
										'className'     => 'JumpHost',
										'order'         => '',
										'foreignKey'    => 'jump_host_id'
									)
								)
							));
		$this->Paginator->settings = array(
			'BookingJumpHost'=>array(
				'conditions'=>array('BookingJumpHost.buyer_id'=>$user_id,'BookingJumpHost.status'=>1),
				'limit' => 3,
				'order' => 'BookingJumpHost.created DESC',
				'paramType' => 'querystring'
			)
		);
		$book_jump_record = $this->Paginator->paginate('BookingJumpHost');
		foreach($book_jump_record as $key =>$value){
			$book_jump_record[$key]['BookingJumpHostAmount'] = $this->convertCurrencyUSDToLocal($value['BookingJumpHost']['paid_amount']);
			$book_jump_record[$key]['JumpHost']['image'] = $this->JumpHostGallery->primaryJumpImage($value['BookingJumpHost']['jump_host_id']);
			$book_jump_record[$key]['JumpHost']['image'] = $book_jump_record[$key]['JumpHost']['image']['JumpHostGallery']['file_name'];
		}
		//pr($book_jump_record); die;
		$this->set('jump_host_record',$book_jump_record);
		$this->render('booked_jump_host_content','ajax');
		
	}
	
	public function my_jump_hosts(){
		$this->set('left_menu_selected','My_Jump_Host');
		$profile_user_id = $this->Auth->User('id');
		$this->set('left_part_user_id',$profile_user_id);
		
	}
	
	public function my_jump_hosts_content(){
		$user_id = $this->Auth->User('id');
		$this->loadModel('JumpHost');
		$this->loadModel('JumpHostGallery');
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
		$my_jump_host_record = $this->Paginator->paginate('JumpHost');
		foreach($my_jump_host_record as $key =>$value)
		{	
			$my_jump_host_record[$key]['JumpHost']['convertAmount'] =  $this->convertCurrencyUSDToLocal($value['JumpHost']['price']);
			$my_jump_host_record[$key]['JumpHost']['image'] = $this->JumpHostGallery->primaryJumpImage($value['JumpHost']['id']);
			$my_jump_host_record[$key]['JumpHost']['image'] = $my_jump_host_record[$key]['JumpHost']['image']['JumpHostGallery']['file_name'];
		}
		
		$this->set('my_jump_host_record',$my_jump_host_record);
		$this->render('my_jump_hosts_content','ajax');
	}
	
	public function add_my_jump_host(){
		$this->loadModel('Amenitie');
		$this->loadModel('Home');
		$this->loadModel('Room');
		$this->loadModel('Country');
		$this->loadModel('JumpHost');
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$latitude = Configure::read('latitude');;
		$this->set("city_latitude",$latitude);
		$longitude = Configure::read('longitude');;
		$this->set("city_longitude",$longitude);
		$amenitie_type = $this->Amenitie->find('list',array('conditions'=>array('Amenitie.status'=>1),'fields'=>array('id','title')));
		$this->set('amenitie_type',$amenitie_type);
		$home_type = $this->Home->find('list',array('conditions'=>array('Home.status'=>1),'fields'=>array('id','title')));
		$this->set('home_type',$home_type);
		$room_type = $this->Room->find('list',array('conditions'=>array('Room.status'=>1),'fields'=>array('id','title')));
		$this->set('room_type',$room_type);
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1),'fields'=>array('iso_code','country_name'),'order' => 'Country.country_name ASC'));
		$this->set('countries',$countries);
		if($this->request->is('post')){
			$this->request->data['Account'] = $this->request->data['JumpHost'];
			$this->{$this->modelClass}->set($this->request->data['Account']);
			if($this->{$this->modelClass}->add_jumpHost()){
				$data 						=	array();
				if($this->request->data{$this->modelClass}['amenities'] != ''){
					$data['amenities'] = implode(',',$this->request->data{$this->modelClass}['amenities']);
				}
				else{
					$data['amenities']		=	'';
				}
				if($this->request->data{$this->modelClass}['bathrooms'] != ''){
					$data['bathrooms']			=	trim($this->data['JumpHost']['bathrooms']);
				}
				if($this->request->data{$this->modelClass}['beds'] != ''){
					$data['beds']				=	trim($this->data['JumpHost']['beds']);
				}
				if($this->request->data{$this->modelClass}['bedrooms'] != ''){
					$data['bedrooms']			=	trim($this->data['JumpHost']['bedrooms']);
				}
				$model_name = 'JumpHost';
				$data['slug']  				= 	$this->createSlug($this->data['JumpHost']['title'],$model_name);
				$data['user_id']			=	$this->Auth->user('id');
				$data['home_type_id']		=	trim($this->data['JumpHost']['home_type_id']);
				$data['room_type_id']		=	trim($this->data['JumpHost']['room_type_id']);
				$data['title']				=	trim($this->data['JumpHost']['title']);
				$data['description']		=	trim($this->data['JumpHost']['description']);
				$data['address_line_1']		=	trim($this->data['JumpHost']['address_line_1']);
				$data['address_line_2']		=	trim($this->data['JumpHost']['address_line_2']);
				$data['country_code']		=	trim($this->data['JumpHost']['country_code']);
				$data['state_code']			=	trim($this->data['JumpHost']['state_code']);
				$data['city_code']			=	trim($this->data['JumpHost']['city_code']); 
				$data['zipcode']			=	trim($this->data['JumpHost']['zipcode']);
				$data['accommodates']		=	trim($this->data['JumpHost']['accommodates']);
				$data['price']				=	trim($this->data['JumpHost']['price']);
				
				
				$data['latitude']			=	trim($this->data['JumpHost']['latitude']);
				$data['longitude']			=	trim($this->data['JumpHost']['longitude']);
				
				$data['check_in_time']		=	date("H:i",strtotime($this->data['JumpHost']['check_in_time']));
				$data['check_in_instructions']	=	$this->data['JumpHost']['check_in_instructions'];
				$data['check_out_time']		=	date("H:i",strtotime($this->data['JumpHost']['check_out_time']));
				$data['status']				=	1;
				//pr($data); die;
				$this->JumpHost->create();
				if($this->JumpHost->save($data,false)){
					$success =  true;
					$message = 'Your jump host has been added successfully';
					$dataResponse['redirectURL'] =  Router::url(array('plugin'=>false,'controller'=>'accounts','action'=>'my_jump_hosts'));
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
	public function edit_my_jump_host($slug = null){
		$this->loadModel('JumpHost');
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.slug'=>$slug,'JumpHost.status'=>1)));
		$this->checkRecordIsNull($record);
		$this->loadModel('Amenitie');
		$this->loadModel('Home');
		$this->loadModel('Room');
		$this->loadModel('Country');
		$latitude = $record['JumpHost']['latitude'];
		$this->set("city_latitude",$latitude);
		$longitude = $record['JumpHost']['longitude'];
		$this->set("city_longitude",$longitude);
		$this->set('state_code',$record['JumpHost']['state_code']);
		$this->set('city_code',$record['JumpHost']['city_code']);
		$amenitie_type = $this->Amenitie->find('list',array('conditions'=>array('Amenitie.status'=>1),'fields'=>array('id','title')));
		$this->set('amenitie_type',$amenitie_type);
		$home_type = $this->Home->find('list',array('conditions'=>array('Home.status'=>1),'fields'=>array('id','title')));
		$this->set('home_type',$home_type);
		$room_type = $this->Room->find('list',array('conditions'=>array('Room.status'=>1),'fields'=>array('id','title')));
		$this->set('room_type',$room_type);
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1),'fields'=>array('iso_code','country_name'),'order' => 'Country.country_name ASC'));
		$this->set('countries',$countries);
		if($this->request->is('put') || $this->request->is('post')){
			$this->request->data['Account'] = $this->request->data['JumpHost'];
			$this->{$this->modelClass}->set($this->request->data['Account']);
			if($this->{$this->modelClass}->add_jumpHost()){
				$data 						=	array();	
				if($this->request->data{$this->modelClass}['amenities'] != ''){
					$data['amenities'] = implode(',',$this->request->data['JumpHost']['amenities']);
				}
				else{
					$data['amenities']		=	'';
				}
				if($this->request->data{$this->modelClass}['bathrooms'] != ''){
					$data['bathrooms']			=	trim($this->data['JumpHost']['bathrooms']);
				}
				if($this->request->data{$this->modelClass}['beds'] != ''){
					$data['beds']				=	trim($this->data['JumpHost']['beds']);
				}
				if($this->request->data{$this->modelClass}['bedrooms'] != ''){
					$data['bedrooms']			=	trim($this->data['JumpHost']['bedrooms']);
				}
				
				$data['user_id']			=	$this->Auth->user('id');
				$data['home_type_id']		=	trim($this->data['JumpHost']['home_type_id']);
				$data['room_type_id']		=	trim($this->data['JumpHost']['room_type_id']);
				$data['title']				=	trim($this->data['JumpHost']['title']);
				$data['description']		=	trim($this->data['JumpHost']['description']);
				$data['address_line_1']		=	trim($this->data['JumpHost']['address_line_1']);
				$data['address_line_2']		=	trim($this->data['JumpHost']['address_line_2']);
				$data['country_code']		=	trim($this->data['JumpHost']['country_code']);
				$data['state_code']			=	trim($this->data['JumpHost']['state_code']);
				$data['city_code']			=	trim($this->data['JumpHost']['city_code']); 
				$data['zipcode']			=	trim($this->data['JumpHost']['zipcode']);
				$data['accommodates']		=	trim($this->data['JumpHost']['accommodates']);
				$data['price']				=	trim($this->data['JumpHost']['price']);
				$data['latitude']			=	trim($this->data['JumpHost']['latitude']);
				$data['longitude']			=	trim($this->data['JumpHost']['longitude']);
				$data['check_in_time']		=	date("H:i",strtotime($this->data['JumpHost']['check_in_time']));
				$data['check_in_instructions']	=	$this->data['JumpHost']['check_in_instructions'];
				$data['check_out_time']		=	date("H:i",strtotime($this->data['JumpHost']['check_out_time']));
				$data['status']				=	1;
				//pr($data); die;
				$this->JumpHost->id = $record['JumpHost']['id'];
				if($this->JumpHost->save($data,false)){
					$success =  true;
					$message = 'Your jump host has been added successfully';
					$dataResponse['redirectURL'] =  Router::url(array('plugin'=>false,'controller'=>'accounts','action'=>'my_jump_hosts'));
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
		if(!$this->request->data){
			$this->request->data = $record;
			if($record['JumpHost']['amenities'] != ''){
				$amenities = explode(',',$record['JumpHost']['amenities']);
				$this->request->data['JumpHost']['amenities'] = $amenities;
			}
			else{
				$this->request->data['JumpHost']['amenities'] = '';
			}
			$this->request->data['JumpHost']['check_in_time'] = date('g:i a',strtotime($this->request->data['JumpHost']['check_in_time']));
			$this->request->data['JumpHost']['check_out_time'] = date('g:i a',strtotime($this->request->data['JumpHost']['check_out_time']));
		}
	}
	
	public function my_jump_gallery($slug = null){
		//It's a Jump Host Gallery
		$this->loadModel('JumpHostGallery');
		$this->loadModel('JumpHost');
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.slug'=>$slug,'JumpHost.status'=>1),'fields'=>array('JumpHost.id')));
		$this->checkRecordIsNull($record);
		$this->set('slug',$slug);
		$gallery_record = $this->JumpHostGallery->find('all',array('conditions'=>array('JumpHostGallery.jump_host_id'=>$record['JumpHost']['id'],'JumpHostGallery.status'=>1),'order'=>'JumpHostGallery.created DESC'));
		$this->set('gallery',$gallery_record);
		if($this->request->is('post')){
			$this->request->data['Account'] = $this->request->data['JumpHostGallery'];
			//pr($this->request->data); die;
			$this->{$this->modelClass}->set($this->request->data['Account']);
			if($this->{$this->modelClass}->JumpHostGalleryValidate()){
			//pr($this->request->data); die;
				if(!empty($this->request->data['JumpHostGallery']['file_name']['name'])){
					$file = $this->request->data['JumpHostGallery']['file_name'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH. time().$file['name']);
						$this->request->data['JumpHostGallery']['file_name'] = time().$file['name'];
						$dataResponse['selfReload'] = true;
					}
				}
				$data 						=	array();
				$data['file_name']			=	$this->request->data['JumpHostGallery']['file_name'];
				$data['jump_host_id']		=	$record['JumpHost']['id'];
				$data['status']				=	1;
				//pr($data); die;
				$this->JumpHostGallery->create();
				if($this->JumpHostGallery->save($data,false)){
					$success =  true;
					$message = 'Jump host photo has been added successfully';
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
	
	public function delete_jump_photo(){
		if($this->request->is('ajax')){
			$this->loadModel('JumpHostGallery');
			$record = $this->JumpHostGallery->findById($this->request->data['id']);
			if($record)
			{
				$file = new File(ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH . $record['JumpHostGallery']['file_name'], false, 0777);
				$file->delete();
				if($this->JumpHostGallery->delete($this->request->data['id']))
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
	
	public function make_default_photo(){
		if($this->request->is('ajax')){
			$this->loadModel('JumpHostGallery');
			$this->loadModel('JumpHost');
			$jump_host_record = $this->JumpHost->find('first',array('conditions'=>array('JumpHost.slug'=>$this->request->data['slug'],'JumpHost.status'=>1),'fields'=>array('JumpHost.id')));
			$this->checkRecordIsNull($jump_host_record);
			$gallery_record = $this->JumpHostGallery->findById($this->request->data['id']);
			$this->checkRecordIsNull($gallery_record);
			$this->JumpHostGallery->updateAll(
				array('JumpHostGallery.is_default' => "'No'"),
				array('JumpHostGallery.jump_host_id' => $jump_host_record['JumpHost']['id'])
			);
			$this->JumpHostGallery->id = $this->request->data['id'];
			if($this->JumpHostGallery->saveField('is_default','Yes'))
			{
				$success =  true;
			}
			$dataResponse['success'] = $success;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function my_booked_hotels(){
		$user_id = $this->Auth->User('id');
		$this->set('left_part_user_id',$user_id);	
	}
	
	public function my_booked_hotel_content(){
		$user_id = $this->Auth->User('id');
		$this->loadModel('User');
		$this->loadModel('BookedHotel');
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id,'User.status'=>1)));
		$this->checkRecordIsNull($user);
		$this->Paginator->settings = array(
			'BookedHotel'=>array(
				'conditions'=>array('BookedHotel.user_id'=>$user_id,'BookedHotel.status'=>1),
				'limit' => 3,
				'order' => 'BookedHotel.created desc',
				'paramType' => 'querystring'
			)
		);
		$bookedHotel = $this->Paginator->paginate('BookedHotel');
		foreach($bookedHotel as $key => $value){
			$bookedHotel[$key]['BookedHotel']['convertAmount'] = $this->convertCurrencyUSDToLocal($value['BookedHotel']['total_chargeable_amount']);
		}
		$this->set('bookedHotel',$bookedHotel);
		$this->render('my_booked_hotel_content','ajax');
	}
	public function booked_hotel_detail($id = null){
		$sessionUserId = $this->Auth->user('id');
		$this->set('left_part_user_id',$sessionUserId);	
		$this->loadModel('BookedHotel');
		$this->loadModel('BookingHotel');
		$this->loadModel('BookedHotelRoom');
		$this->BookedHotel->bindModel(array(
								'hasMany' => array(
									'HotelRoom' => array(
										'className'     => 'BookedHotelRoom',
										'order'         => '',
										'foreignKey'    => 'booked_hotel_id'
									)
								)
							));
		$bookedData = $this->BookedHotel->findById($id);
		$this->checkRecordIsNull($bookedData);
		$user_id = $bookedData['BookedHotel']['user_id'];
		if($user_id == $sessionUserId)
		{
			$bookedData['BookedHotel']['convertAmount'] = $this->convertCurrencyUSDToLocal($bookedData['BookedHotel']['total_chargeable_amount']);
			$this->set('bookedData',$bookedData);
		}
		else
		{
			throw new NotFoundException('404 Not Found');
		}
	}
	
}

