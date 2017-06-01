<?php 
class HotelsController extends AppController{
	public $helper = array('Form','Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('search','detail','loadmore'));
		
		App::build(array('Lib' => array(APP . 'Lib' . DS . 'Expedia' . DS)));
		App::uses('Expedia', 'Lib');
		$this->expedia = new Expedia(array('apiKey'=>'49u4l5i7edisijqkhrgc2lu411','cid' => '482405','secret' => 'dtumeqcj8668j'));
		
	}
	public function search()
	{
		$arrivalDate = isset($_GET['arrivalDate'])?$_GET['arrivalDate']:date('m/d/Y',strtotime('+1 day',time()));
		$departureDate = isset($_GET['departureDate'])?$_GET['departureDate']:date('m/d/Y',strtotime('+2 day',time()));
		$customerSessionId = isset($_GET['customerSessionId'])?$_GET['customerSessionId']:'';
		$cacheKey = isset($_GET['cacheKey'])?$_GET['cacheKey']:'';
		$cacheLocation = isset($_GET['cacheLocation'])?$_GET['cacheLocation']:'';
		//pr($_GET['rooms']); die;
		if($arrivalDate >= $departureDate)
		{
			$departureDate = date('m/d/Y',strtotime('+1 Day',strtotime($arrivalDate)));
		}
		if(!isset($_GET['rooms']))
		{
			$rooms[1]['adults'] = 2;
			$rooms[1]['children'] = array();
		}
		else
		{
			
			$ri = 1;
			foreach($_GET['rooms'] as $key => $value)
			{
				if(isset($value['children']) && $value['children'] > 0)
				{
					$c_size = $value['children'];
					for($i=1; $i<=$c_size;$i++)
					{
						$rooms[$ri]['children'][$i] = $value['child_age'][$i];
					}
					
				}
				else
				{
					$rooms[$ri]['children'] = array();
				}
				$rooms[$ri]['adults'] = $value['adult'];;
				$ri ++;
			}
		}
		$i= 1;
		$string = '';
		$this->Session->write('rooms_session',$rooms);
		$this->set('arrivalDateMin',date('m/d/Y'));
		$this->set('departureDateMin',date('m/d/Y'));
		$this->set('arrivalDate',$arrivalDate);
		$this->set('departureDate',$departureDate);
		$this->set('arrivalDateMax',date('m/d/Y',strtotime('+1 Year',time())));
		foreach($rooms as $key => $value)
		{
			$childrens_count = sizeof($value['children']);
			$string.= '&room'.$key.'=';
			if($value['adults'] > 0)
			{
				$string.= $value['adults'].',';
			}
			else
			{
				$string.= '0,';
			}
			foreach($value['children'] as $ch => $child)
			{
				$string.= $child.',';
			}
			$i++;
		}
		$data = array();
		$city = (isset($_GET['city'])&& $_GET['city'])?$_GET['city']:'Jaipur';
		$city = trim($city);
		$data['city'] = str_replace(' ','+',$city);
		$data['stateProvinceCode'] = '';
		$data['countryCode'] = '';
		$data['numberOfResults'] = '20';
		$data['searchRadius'] = '50';
		$data['arrivalDate'] = $arrivalDate; 
		$data['departureDate'] = $departureDate;
		$data['roomString'] = $string;
		$data['customerIpAddress'] = '';
		$data['cacheLocation'] = $cacheLocation;
		$data['customerSessionId'] = $customerSessionId;
		$data['cacheKey'] = $cacheKey;
		$result = $this->expedia->search($data);
		
		if($result == 'error')
		{
			$this->Session->setFlash(__('Please enter valid data in hotel search box.'),'error');
			$this->redirect(array('plugin'=>false,'controller'=>'searches','action'=>'index'));
			
		}
		else
		{
		
			if(!isset($result->EanWsError))
			{
				$hotelDatas = $result->HotelList;
				$totalHotels = $hotelDatas->{"@activePropertyCount"};
				$hotelList = $result->HotelList->HotelSummary;
				if($hotelList)
				{
					foreach($hotelList as $key => $value)
					{
						$value->image_url = $this->expedia->getImageBySize($value->thumbNailUrl,'d');
						$value->shortDescription = substr($value->shortDescription, 58);
						unset($value->RoomRateDetailsList);
					}
				}
				$this->set('hotelList',$hotelList);
				$this->set('totalHotels',$totalHotels);
				$this->set('city_name',$data['city']);
			}
			$this->set('totalHotels',$totalHotels);
			$this->set('customerSessionId',$result->customerSessionId);
			$this->set('cacheKey',$result->cacheKey);
			$this->set('cacheLocation',$result->cacheLocation);
			$this->set('city_name',$city);
		}
	}
	function loadmore()
	{
		$customerSessionId = isset($_GET['customerSessionId'])?$_GET['customerSessionId']:'';
		$cacheKey = isset($_GET['cacheKey'])?$_GET['cacheKey']:'';
		$cacheLocation = isset($_GET['cacheLocation'])?$_GET['cacheLocation']:'';
		$customerIpAddress = isset($_GET['customerIpAddress'])?$_GET['customerIpAddress']:'';
		
		$data['customerSessionId'] = $customerSessionId;
		$data['cacheKey'] = $cacheKey;
		$data['cacheLocation'] = $cacheLocation;
		$data['customerUserAgent'] = '';
		$data['currencyCode'] = 'USD';
		$result = $this->expedia->moreResult($data);
		if(!isset($result->EanWsError))
		{
			$hotelDatas = $result->HotelList;
			$hotelList = $result->HotelList->HotelSummary;
			if($hotelList)
			{
				foreach($hotelList as $key => $value)
				{
					$value->image_url = $this->expedia->getImageBySize($value->thumbNailUrl,'d');
					$value->shortDescription = substr($value->shortDescription, 58);
					unset($value->RoomRateDetailsList);
				}
			}
			$this->set('hotelList',$hotelList);
		}
		else
		{
			echo '<div class="no-record">No More Result Found</div>'; die;
		}
		$this->set('moreResultsAvailable',$result->moreResultsAvailable);
		$this->set('cacheKey',$result->cacheKey);
		$this->set('cacheLocation',$result->cacheLocation);
		$this->render('loadmore','ajax');
		
	}
	function detail($hotelId)
	{
		
		$arrivalDate = isset($_GET['arrivalDate'])?$_GET['arrivalDate']:date('m/d/Y',strtotime('+1 day',time()));
		$departureDate = isset($_GET['departureDate'])?$_GET['departureDate']:date('m/d/Y',strtotime('+2 day',time()));
		$customerSessionId = isset($_GET['customerSessionId'])?$_GET['customerSessionId']:'';
		$cacheKey = isset($_GET['cacheKey'])?$_GET['cacheKey']:'';
		$cacheLocation = isset($_GET['cacheLocation'])?$_GET['cacheLocation']:'';
		$rooms_session = $this->Session->read('rooms_session');
		$i= 1;
		$rstring = '';
		foreach($rooms_session as $key => $value)
		{
			$childrens_count = sizeof($value['children']);
			$rstring.= '&room'.$key.'=';
			if($value['adults'] > 0)
			{
				$rstring.= $value['adults'].',';
			}
			else
			{
				$rstring.= '0,';
			}
			foreach($value['children'] as $ch => $child)
			{
				$rstring.= $child.',';
			}
			$i++;
		}
		$detail = $this->expedia->getRoomInfo($hotelId);
		
		//echo $rstring; die;
		//$this->set('roomImages',$roomImages);
		$data = array();
		$data['customerIpAddress'] = '';
		$data['cacheLocation'] = $cacheLocation;
		$data['customerSessionId'] = $customerSessionId;
		$data['cacheKey'] = $cacheKey;
		$data['customerUserAgent'] = '';
		$data['currencyCode'] = 'USD';
		$data['hotelId'] = $hotelId;
		$data['arrivalDate'] = $arrivalDate;
		$data['departureDate'] = $departureDate;
		$data['roomString'] = $rstring;
		$data['room1'] = '1';
		//pr($rooms_session); die;
		$result = $this->expedia->getHotelDetail($data);
		if(!$detail->HotelInformationResponse) die('Something went wrong');
		$this->set('hotel',$detail->HotelInformationResponse);
		$this->set('hotelId',$detail->HotelInformationResponse->HotelSummary->hotelId);
		$this->set('hotelRooms',$result->HotelRoomAvailabilityResponse);
		//pr($result); die;
		//pr($detail->HotelInformationResponse); die;
		$hotel_image = $detail->HotelInformationResponse->HotelImages->HotelImage[0];
		$image_url = $hotel_image->url;
		$this->set('hotelPhotoUrl',$image_url);
		
	}
	
	function book($hotelId,$roomTypeCode)
	{
		$rate_code 			= 	$_GET['rateCode'];
		$chargeableRate 	= 	$_GET['chargeableRate'];
		$customerSessionId 	= 	$_GET['customerSessionId'];
		$BedTypeId 			= 	$_GET['BedTypeId'];
		$arrivalDate 		= 	$_GET['arrivalDate'];
		$departureDate 		=	$_GET['departureDate'];
		$rateKey 			=	$_GET['rateKey'];
		$hotelPhoto 		=	$_GET['hotelPhoto'];
		$hotelAddress 		=	$_GET['hotelAddress'];
		$hotelName 			=	$_GET['hotelName'];
		$cancellationPolicy =	$_GET['cancellationPolicy'];
		$hotelId 			= 	$hotelId;
		$roomTypeCode 		= 	$roomTypeCode;
		$user_id			= 	$this->Auth->user('id');
		
		$this->set('check_in',$arrivalDate);
		$this->set('check_out',$departureDate);
		$this->set('chargeableRate',$chargeableRate);
		$this->set('hotelPhoto',$hotelPhoto);
		$this->set('hotelAddress',$hotelAddress);
		$this->set('hotelName',$hotelName);
		$this->set('cancellationPolicy',$cancellationPolicy);
		
		$this->loadModel('User');
		$this->User->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
			'state' => 'SELECT state_name FROM states WHERE iso_code = User.state_code'
		);
		$session_user_data = $this->User->findById($this->Auth->user('id'));
		//pr($session_user_data); die;
		$this->set('user_data',$session_user_data);
		
		$this->loadModel('BookingHotel');
		$data				 		= 	array();
		$data['hotelId'] 			=	$hotelId;
		$data['roomTypeCode'] 		=	$roomTypeCode;
		$data['user_id'] 			=	$user_id;
		$data['arrivalDate'] 		=	date('Y-m-d',strtotime($arrivalDate));
		$data['departureDate'] 		=	date('Y-m-d',strtotime($departureDate));
		$data['customerSessionId'] 	=	$customerSessionId;
		$data['rate_key'] 			= 	$rateKey;
		$data['roomTypeCode'] 		= 	$roomTypeCode;
		$data['rate_code'] 			= 	$rate_code;
		$data['chargeable_rate'] 	= 	$chargeableRate;
		$data['hotelPhoto'] 		= 	$hotelPhoto;
		
		
		
		$bookingHotel_Record = $this->BookingHotel->find('first',array('conditions'=>array('AND'=>array('BookingHotel.customerSessionId'=>$customerSessionId,'BookingHotel.hotelId'=>$hotelId,'BookingHotel.roomTypeCode'=>$roomTypeCode),'BookingHotel.status'=>1)));
		
		
		if($bookingHotel_Record){
			$this->BookingHotel->id = $bookingHotel_Record['BookingHotel']['id'];
			$this->BookingHotel->save($data,false);
			$this->set('hotel_booking_id',$bookingHotel_Record['BookingHotel']['id']);
		}
		else{
			$this->BookingHotel->create();
			$saveData = $this->BookingHotel->save($data,false);
			$this->set('hotel_booking_id',$saveData['BookingHotel']['id']);
		}
		
		//$rateCode = $this->request->query['rateCode'];
		//$chargeableRate = $this->request->query['chargeableRate'];
		//$customerSessionId = $this->request->query['customerSessionId'];
		$rooms_session = $this->Session->read('rooms_session');
		//pr($rooms_session); die;
		$rooms = $rooms_session;
		$this->set('rooms',$rooms);
		$room_count = 0;
		$adults_count = 0;
		$children_count = 0;
		foreach($rooms_session as $key => $value){
			if(!empty($value['children'])){
				foreach($value['children'] as $key1 => $value1){
					$children_count++;
				}
			}
			$adults_count = $value['adults'] + $adults_count;
			$room_count++;
		}
		$this->set('adults_count',$adults_count);
		$this->set('children_count',$children_count);
		$this->set('room_count',$room_count);
		
		$this->loadModel('Country');
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1),'fields'=>array('iso_code','country_name')));
		$this->set('countries',$countries);
		$this->set('BedTypeId',$BedTypeId);
		
	}
	
	function HotelBook(){
		if($this->request->isAjax()){
			$failure = false;
			$this->{$this->modelClass}->set($this->request->data);
			$members = $this->request->data;
			foreach($members as $key => $value)
			{
				$this->{$this->modelClass}->set($value);
				if ($this->{$this->modelClass}->saveAll($value,array("validate"=>"only")))
				{
					
				}
				else
				{
					$errors = $this->{$this->modelClass}->validationErrors;
					$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
					$failure = true;
					break;
				}
			}
			if($failure)
			{
				$success = false;
			}
			else
			{
				//pr($this->request->data); die;
				$this->loadModel('BookingHotelRoom');
				$information = $this->request->data;
				$record = array();
				foreach($information as $key => $value){
					$record[$key]['BookingHotelRoom']['first_name']		   		= 	$value['Hotel']['firstname'];
					$record[$key]['BookingHotelRoom']['last_name']			   	= 	$value['Hotel']['lastname'];
					$record[$key]['BookingHotelRoom']['smoking_preferences']	= 	'NS';
					$record[$key]['BookingHotelRoom']['special_requests'] 		= 	$value['Hotel']['special_requests'];
					$record[$key]['BookingHotelRoom']['hotel_booking_id'] 		= 	$value['Hotel']['hotel_booking_id'];
					$record[$key]['BookingHotelRoom']['total_number_children'] 	= 	$value['Hotel']['total_number_children'];
					$record[$key]['BookingHotelRoom']['total_number_adults'] 	= 	$value['Hotel']['total_number_adults'];
					$record[$key]['BookingHotelRoom']['children_age'] 			= 	$value['Hotel']['children_age'];
					$record[$key]['BookingHotelRoom']['BedTypeId'] 				= 	$value['Hotel']['BedTypeId'];
					
				}
				$this->BookingHotelRoom->saveAll($record); 
				$success = true;
				$message = false;
				$dataResponse['callBackFunction'] = 'afterSubmitCloseTab';
				
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;		
		}
	}
	
	public function contactDetailSave(){
		if($this->request->isAjax()){
			//pr($this->request->data); die;
			$this->request->data['Hotel'] = $this->request->data['HotelContactDetails'];
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if($this->{$this->modelClass}->contactDetailValidate()){
				$this->loadModel('BookingHotel');
				//pr($this->request->data); die;
				$email = $this->request->data[$this->modelClass]['email_address'];
				$telephone_number = $this->request->data[$this->modelClass]['telephone_number'];
				$hotel_booking_id = $this->request->data[$this->modelClass]['hotel_booking_id'];
				$this->BookingHotel->updateAll(
					array('BookingHotel.email' => "'$email'" ,'BookingHotel.telephone_number' =>"'$telephone_number'"),
					array('BookingHotel.id' =>$hotel_booking_id)
				);
			
				$success = true;
				$message = false;
				$dataResponse['callBackFunction'] = 'afterSubmitCloseTablast';
			}
			else{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;	
		}
	}
	
	public function creditCardDetailsSave(){
		if($this->request->isAjax()){
			//pr($this->request->data); die;
			$this->request->data['Hotel'] = $this->request->data['CreditCardDetail'];
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if($this->{$this->modelClass}->creditCardDetailValidate()){
				$this->loadModel('BookingHotel');
				$card_type 				= $this->request->data[$this->modelClass]['card_type'];
				$card_number 			= $this->request->data[$this->modelClass]['card_number'];
				$cardholder_first_name 	= $this->request->data[$this->modelClass]['cardholder_first_name'];
				$cardholder_last_name 	= $this->request->data[$this->modelClass]['cardholder_last_name'];
				$month 					= $this->request->data[$this->modelClass]['month'];
				$year 					= $this->request->data[$this->modelClass]['year'];
				$security_code 			= $this->request->data[$this->modelClass]['security_code'];
				$country 				= $this->request->data[$this->modelClass]['country'];
				$state 					= $this->request->data[$this->modelClass]['state'];
				$city 					= $this->request->data[$this->modelClass]['city'];
				$address_line_1 		= $this->request->data[$this->modelClass]['address_line_1'];
				$address_line_2 		= $this->request->data[$this->modelClass]['address_line_2'];
				$zipcode 				= $this->request->data[$this->modelClass]['zipcode'];
				$hotel_booking_id 		= $this->request->data[$this->modelClass]['hotel_booking_id'];
				$this->BookingHotel->updateAll(
					array(
						'BookingHotel.cc_card_type' => "'$card_type'" ,
						'BookingHotel.cc_card_number' =>"'$card_number'",
						'BookingHotel.cc_cardholder_first_name' =>"'$cardholder_first_name'",
						'BookingHotel.cc_cardholder_last_name' =>"'$cardholder_last_name'",
						'BookingHotel.cc_expiration_year' =>"'$year'",
						'BookingHotel.cc_expiration_month' =>"'$month'",
						'BookingHotel.cc_security_code' =>"'$security_code'",
						'BookingHotel.cc_country_code' =>"'$country'",
						'BookingHotel.cc_state' =>"'$state'",
						'BookingHotel.cc_city' =>"'$city'",
						'BookingHotel.cc_address_line_1' =>"'$address_line_1'",
						'BookingHotel.cc_address_line_2' =>"'$address_line_2'",
						'BookingHotel.cc_zipcode' =>"'$zipcode'"
					),
					array('BookingHotel.id' =>$hotel_booking_id)
				);
				$this->final_Book($hotel_booking_id);
				$success = true;
				$message = false;
			}
			else{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = true;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;	
		}
		
	}
	
	public function final_Book($hotel_booking_id = null){
		
		$this->loadModel('BookingHotel');
		$record = $this->BookingHotel->findById($hotel_booking_id); 
		//pr($record); die;
		$data = array();
		$data['hotelId'] 			= $record['BookingHotel']['hotelId'];
		$data['arrivalDate']		= date('m/d/Y',strtotime($record['BookingHotel']['arrivalDate']));
		$data['departureDate']		= date('m/d/Y',strtotime($record['BookingHotel']['departureDate']));
		$data['rateKey']			= $record['BookingHotel']['rate_key'];
		$data['roomTypeCode']		= $record['BookingHotel']['roomTypeCode'];
		$data['rateCode']			= $record['BookingHotel']['rate_code'];
		$data['chargeableRate']		= $record['BookingHotel']['chargeable_rate'];
		$data['contact_email']		= $record['BookingHotel']['email'];
		$data['cardFirstName']		= $record['BookingHotel']['cc_cardholder_first_name'];
		$data['cardLastName']		= $record['BookingHotel']['cc_cardholder_last_name'];
		$data['contact_phone']		= $record['BookingHotel']['telephone_number'];
		$data['contact_workPhone']	= '';
		$data['creditCardType']		= $record['BookingHotel']['cc_card_type'];
		$data['creditCardNumber']	= $record['BookingHotel']['cc_card_number'];
		$data['creditCardIdentifier']		= $record['BookingHotel']['cc_security_code'];
		$data['creditCardExpirationMonth']	= $record['BookingHotel']['cc_expiration_month'];
		$data['creditCardExpirationYear']	= $record['BookingHotel']['cc_expiration_year'];
		$data['address1']			= $record['BookingHotel']['cc_address_line_1'];
		$data['city']				= $record['BookingHotel']['cc_city'];
		$data['stateProvinceCode']	= $record['BookingHotel']['cc_state'];
		$data['countryCode']		= $record['BookingHotel']['cc_country_code'];
		$data['postalCode']			= $record['BookingHotel']['cc_zipcode'];
		$data['customerSessionId']	= $record['BookingHotel']['customerSessionId'];
		
		
		$this->loadModel('BookingHotelRoom');
		$hotelRoomRecord = $this->BookingHotelRoom->find('all',array('conditions'=>array('BookingHotelRoom.hotel_booking_id'=>$hotel_booking_id),'order'=>'BookingHotelRoom.created DESC'));
		//pr($hotelRoomRecord); die;
		$i =0;
		$j =0;
		$rooms_session = $this->Session->read('rooms_session');
		
		$roomString = '';
		foreach($hotelRoomRecord as $key =>$value){
			
			$roomString = $roomString.'&room'.$i.'='.$value['BookingHotelRoom']['children_age'];
			$roomString = $roomString.'&room'.$i.'FirstName='.$value['BookingHotelRoom']['first_name'];
			$roomString = $roomString.'&room'.$i.'Lastname='.$value['BookingHotelRoom']['last_name'];
			$roomString = $roomString.'&room'.$i.'BedTypeId='.$value['BookingHotelRoom']['BedTypeId'];
			$roomString = $roomString.'&room'.$i.'SmokingPreference='.$value['BookingHotelRoom']['smoking_preferences'];
			
			$data['room-'.$i.'-adult-total'] = $value['BookingHotelRoom']['total_number_adults'];
			$data['room-'.$i.'-child-total'] = $value['BookingHotelRoom']['total_number_children'];
			$data['room-'.$i.'-firstName'] 	 = $value['BookingHotelRoom']['first_name'];
			$data['room-'.$i.'-lastName']    = $value['BookingHotelRoom']['last_name'];
			$data['room-'.$i.'-bedTypeId'] 	 = $value['BookingHotelRoom']['BedTypeId'];
			$data['room-'.$i.'-smokingPreference'] = $value['BookingHotelRoom']['smoking_preferences'];
			$children  = explode(',',$value['BookingHotelRoom']['children_age']);
			unset($children[0]);
			//pr($children); die;
			foreach($children as $key1 => $value1){
				if(!empty($value1)){
					$data['room-'.$i.'-child-'.$j.'-age'] = $value1;
					$j++;
				}
			}
			$i++;
		}
		
		$data['numberOfRooms'] = sizeof($hotelRoomRecord);			
		$data['rooms'] = $roomString;
		$bookingResponse = $this->expedia->getReservation($data);
		$simpleXml = simplexml_load_string($bookingResponse);
		//pr($simpleXml); die;
		$bookedRecord_Saved  =  array();
		$bookedRecord_Saved['user_id']	 	 		 = $this->Auth->user('id');
		$bookedRecord_Saved['booking_hotel_id']	 	 = $hotel_booking_id;
		$bookedRecord_Saved['hotel_id']	 	 		 = $record['BookingHotel']['hotelId'];
		$bookedRecord_Saved['imageUrl']	 	 		 = $record['BookingHotel']['hotelPhoto'];
		$bookedRecord_Saved['email_id']	 	 		 = $record['BookingHotel']['email'];
		$bookedRecord_Saved['customerSessionId']	 = (string) $simpleXml->customerSessionId;
		$bookedRecord_Saved['itineraryId'] 		 	 = (string) $simpleXml->itineraryId;
		$c_Number 									 = (array) $simpleXml->confirmationNumbers;
		//pr($c_Number); die;
		$bookedRecord_Saved['confirmationNumbers'] 	 = implode(',',$c_Number);
		$bookedRecord_Saved['supplierType'] 		 = (string) $simpleXml->supplierType;
		$bookedRecord_Saved['reservationStatusCode'] = (string) $simpleXml->reservationStatusCode;
		$bookedRecord_Saved['numberOfRoomsBooked']	 = (string) $simpleXml->numberOfRoomsBooked;
		$bookedRecord_Saved['arrivalDate']			 = date('Y-m-d',strtotime($simpleXml->arrivalDate));
		$bookedRecord_Saved['departureDate']		 = date('Y-m-d',strtotime($simpleXml->departureDate));
		$bookedRecord_Saved['hotelName']	 		 = (string) $simpleXml->hotelName;
		$bookedRecord_Saved['hotelAddress']	 		 = (string) $simpleXml->hotelAddress;
		$bookedRecord_Saved['hotelCity']	 		 = (string) $simpleXml->hotelCity;
		$bookedRecord_Saved['hotelPostalCode']	 	 = (string) $simpleXml->hotelPostalCode;
		$bookedRecord_Saved['hotelCountryCode']	 	 = (string) $simpleXml->hotelCountryCode;
		$bookedRecord_Saved['roomDescription']	 	 = (string) $simpleXml->roomDescription;
		$bookedRecord_Saved['rateOccupancyPerRoom']	 = (string) $simpleXml->rateOccupancyPerRoom;
		$bookedRecord_Saved['commissionableUsdTotal'] = (string) $simpleXml->RateInfos->RateInfo->ChargeableRateInfo->attributes()->commissionableUsdTotal;
		$bookedRecord_Saved['total_chargeable_amount'] = (string) $simpleXml->RateInfos->RateInfo->ChargeableRateInfo->attributes()->total;
		$bookedRecord_Saved['currencyCode']	 		 = (string) $simpleXml->RateInfos->RateInfo->ChargeableRateInfo->attributes()->currencyCode;
		$bookedRecord_Saved['cancellationPolicy']	 = (string) $simpleXml->RateInfos->RateInfo->cancellationPolicy;
		$bookedRecord_Saved['nonRefundable']	 	 = (string) $simpleXml->RateInfos->RateInfo->nonRefundable;
		$this->loadModel('BookedHotel');
		$this->loadModel('BookedHotelRoom');
		$this->BookedHotel->create();
		$saveData  = $this->BookedHotel->save($bookedRecord_Saved,false);
		//pr($saveData); die;
		if($saveData){
			$confirmation_Numbers 	= (array) $simpleXml->confirmationNumbers;
			$i = 0;
			foreach($simpleXml->RateInfos->RateInfo->RoomGroup->Room as $key => $value){
				$value  = (array) $value;
				$bookedRoom_Record = array();
				$this->BookedHotelRoom->create();
				$bookedRoom_Record['BookedHotelRoom']['first_name'] = $value['firstName'];
				$bookedRoom_Record['BookedHotelRoom']['last_name']	= $value['lastName'];
				$bookedRoom_Record['BookedHotelRoom']['smoking_preferences'] =  $value['smokingPreference'];
				$bookedRoom_Record['BookedHotelRoom']['total_number_adults'] =  $value['numberOfAdults'];
				$bookedRoom_Record['BookedHotelRoom']['total_number_children'] = $value['numberOfChildren'];
				
				if(isset($value['childAges'])){
					if(is_array($value['childAges'])){
						$bookedRoom_Record['BookedHotelRoom']['children_age'] =  implode(',',$value['childAges']);
					}
					else
					{
						$bookedRoom_Record['BookedHotelRoom']['children_age'] =  $value['childAges'];
					}
				}
				
				if(is_array($confirmation_Numbers)){
					
					$bookedRoom_Record['BookedHotelRoom']['confirmation_number'] = $confirmation_Numbers[$i];
					
				}
				else 
				{
					$bookedRoom_Record['BookedHotelRoom']['confirmation_number'] = $confirmation_Numbers;
				}
				$bookedRoom_Record['BookedHotelRoom']['BedTypeId'] =  $value['bedTypeId'];
				$bookedRoom_Record['BookedHotelRoom']['bedTypeDescription'] =  $value['bedTypeDescription'];
				$bookedRoom_Record['BookedHotelRoom']['rateKey'] = $value['rateKey'];
				$bookedRoom_Record['BookedHotelRoom']['booked_hotel_id'] = $saveData['BookedHotel']['id'];
				$this->BookedHotelRoom->save($bookedRoom_Record,false);
				//$this->redirect(array('plugin'=>false,'controller'=>'accounts','action'=>'my_booked_hotels'));
				
				$i++;		
			}
			//die('dfs');
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
			$temp_record = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.action" =>"booking_hotel",'EmailTemplate.status'=>1)));
			if(isset($temp_record) && !empty($temp_record)){
				//pr($temp_record); die('ds');
				$body = $temp_record['EmailTemplate']['body'];
				$bookingDate = date('Y-m-d',strtotime($saveData['BookedHotel']['created']));
				$logo = "<img src= '".WEBSITE_IMAGE_PATH."logo.png'>";
				$site_title = Configure::read("Site.title");
				$string = str_replace('{#logo}',$logo,$body);
				$string = str_replace('{#customer_name}',$data['cardFirstName'].' '.$data['cardLastName'],$string);
				$string = str_replace('{#price}',$bookedRecord_Saved['total_chargeable_amount'],$string);
				$string = str_replace('{#site_title}',$site_title,$string);
				$string = str_replace('{#check_in_date}',$bookedRecord_Saved['arrivalDate'],$string);
				$string = str_replace('{#check_out_date}',$bookedRecord_Saved['departureDate'],$string);
				$string = str_replace('{#booking_date_time}',$bookingDate,$string);
				$string = str_replace('{#site_title}',$site_title,$string);
				
				$Email->delivery = "smtp";
				$Email->from = MAIL_FROM;
				$Email->to = $data['contact_email'];
				$Email->subject = $temp_record['EmailTemplate']['subject'];
				//$Email->template = $string;
				$Email->sendAs = 'html';
				$Email->send($string);
			}
			
			$dataResponse['success'] = true;
			$dataResponse['redirectURL'] = Router::url(array('plugin'=>false,'controller'=>'accounts','action'=>'my_booked_hotels'));
			echo json_encode($dataResponse); die;
			
		}
		
	} 
	
	public function cancel_reservation($id = null){
		$this->loadModel('BookedHotelRoom');
		$this->BookedHotelRoom->bindModel(array(
							'belongsTo' => array(
								'BookedHotel' => array(
									'className'     => 'BookedHotel',
									'order'         => '',
									'foreignKey'    => 'booked_hotel_id'
								)
							)
						));
						
		$booked_Room = $this->BookedHotelRoom->findById($id);
		$user_id = $this->Auth->user('id');
		//pr($booked_Room); die;
		if($booked_Room['BookedHotel']['user_id'] == $user_id){
			$data = array();
			$data['itineraryId'] 		= $booked_Room['BookedHotel']['itineraryId'];	
			$data['customerSessionId'] 	= $booked_Room['BookedHotel']['customerSessionId'];
			$data['confirmationNumber'] = $booked_Room['BookedHotelRoom']['confirmation_number'];
			$data['email_id'] 			= $booked_Room['BookedHotel']['email_id'];
			$data['reason'] 			= 'COP';
			$dataResponse = $this->expedia->cancelResevation($data);
			$cancellationNumber = $dataResponse->HotelRoomCancellationResponse->cancellationNumber;
			$this->BookedHotelRoom->id = $id;
			$this->BookedHotelRoom->saveField('cancellationNumber',$cancellationNumber);
			$this->Session->setFlash(__('Room reservation cancelled successfully'),'success');
			$this->redirect(array('plugin'=>false,'controller'=>'accounts','action'=>'my_booked_hotels'));
		}
		else
		{
			throw new NotFoundException('404 Not Found');
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

