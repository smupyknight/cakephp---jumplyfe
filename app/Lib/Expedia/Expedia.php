<?php 

class Expedia 
{
	protected $lastRequest = 0;
	protected $api_connection_retries = 5;
	function __construct($var) 
	{
		$this->searchUrl = 'http://api.ean.com/ean-services/rs/hotel/v3/list?';
		$this->hotalDetailUrl = 'http://api.ean.com/ean-services/rs/hotel/v3/avail?';
		$this->hotalInfoUrl = 'http://api.ean.com/ean-services/rs/hotel/v3/info?';
		$this->hotalBookingUrl = 'https://book.api.ean.com/ean-services/rs/hotel/v3/res?';
		$this->hotalImagesUrl = 'http://api.ean.com/ean-services/rs/hotel/v3/roomImages?';
		$this->hotalCancelUrl = 'http://api.ean.com/ean-services/rs/hotel/v3/cancel?';
		$this->apiKey = $var['apiKey'];
		$this->secret = $var['secret'];
		
		$this->minorRev = '28';
		//$this->cid = $var['cid'];
		$this->cid = 55505;
		$this->supplierCacheTolerance = 'MED_ENHANCED';
		$this->locale = 'en_US';
		$this->currencyCode = 'USD';
		$this->lastRequest = 0;
		$this->customerUserAgent = $_SERVER['HTTP_USER_AGENT'];
		//$this->customerIpAddress = $_SERVER['SERVER_ADDR'];
		$this->customerIpAddress = '61.16.138.242';
		
    }
    
	function search($data)
	{
		$url = $this->searchUrl.'&apiKey='.$this->apiKey.'&minorRev='.$this->minorRev.'&cid='.$this->cid.'&supplierCacheTolerance='.$this->supplierCacheTolerance.'&locale='.$this->locale;
		$cacheKey = isset($data['cacheKey'])?$data['cacheKey']:'';
		$cacheLocation = isset($data['cacheLocation'])?$data['cacheLocation']:'';
		$city = $data['city']?$data['city']:'';
		$stateProvinceCode = $data['stateProvinceCode']?$data['stateProvinceCode']:'';
		$countryCode = $data['countryCode']?$data['countryCode']:'';
		$numberOfResults = $data['numberOfResults']?$data['numberOfResults']:'';
		$searchRadius = $data['searchRadius']?$data['searchRadius']:'50';
		$rooms = $data['roomString']?$data['roomString']:'&room1=2';
		//echo $rooms; die;
		$arrivalDate = $data['arrivalDate']?$data['arrivalDate']:'';
		$departureDate = $data['departureDate']?$data['departureDate']:'';
		$getURL = $url.'&city='.$city.'&cacheKey='.$cacheKey.'&cacheLocation='.$cacheLocation.'&stateProvinceCode='.$stateProvinceCode.'&countryCode='.$countryCode.'&numberOfResults='.$numberOfResults.'&searchRadius='.$searchRadius.'&arrivalDate='.$arrivalDate.'&departureDate='.$departureDate.$rooms;
		
		$response = $this->executeCurl($getURL);
		//pr($getURL); die('j');
		if($response == '')
		{
			return 'error';
			
		}
		else if(isset($response->HotelListResponse->EanWsError) && !empty($response->HotelListResponse->EanWsError))
		{
			return 'error';	
			
		}
		else
		{
			return $response->HotelListResponse;
		}
	}
	
	function getHotelDetail($data)
	{
		$url = $this->hotalDetailUrl.'&apiKey='.$this->apiKey.'&minorRev='.$this->minorRev.'&cid='.$this->cid.'&supplierCacheTolerance='.$this->supplierCacheTolerance.'&locale='.$this->locale;
		$customerUserAgent = $data['customerUserAgent']?$data['customerUserAgent']:'PARTNER_WEBSITE';
		$customerIpAddress = $data['customerIpAddress']?$data['customerIpAddress']:'';
		$customerSessionId = $data['customerSessionId']?$data['customerSessionId']:'';
		$cacheKey = $data['cacheKey']?$data['cacheKey']:'';
		$cacheLocation = $data['cacheLocation']?$data['cacheLocation']:'';
		$currencyCode = $data['currencyCode']?$data['currencyCode']:'USD';
		$hotelId = $data['hotelId']?$data['hotelId']:'';
		$arrivalDate = $data['arrivalDate']?$data['arrivalDate']:'';
		$departureDate = $data['departureDate']?$data['departureDate']:'';
		$includeDetails = 'true';
		$includeRoomImages = 'true';
		$rooms = $data['roomString']?$data['roomString']:'&room1=2';
		
		$getURL = $url.'&customerUserAgent='.$customerUserAgent.'&customerIpAddress='.$customerIpAddress.'&cacheKey='.$cacheKey.'&customerSessionId='.$customerSessionId.'&cacheLocation='.$cacheLocation.'&currencyCode='.$currencyCode.'&hotelId='.$hotelId.'&arrivalDate='.$arrivalDate.'&departureDate='.$departureDate.'&includeDetails='.$includeDetails.'&includeRoomImages='.$includeRoomImages.$rooms;
		
		$response = $this->executeCurl($getURL);
		return $response;	
	}
	function moreResult($data)
	{
		$url = $this->searchUrl.'&apiKey='.$this->apiKey.'&minorRev='.$this->minorRev.'&cid='.$this->cid.'&locale='.$this->locale;
		$cacheKey = isset($data['cacheKey'])?$data['cacheKey']:'';
		$cacheLocation = isset($data['cacheLocation'])?$data['cacheLocation']:'';
		$customerUserAgent = isset($data['customerUserAgent'])?$data['customerUserAgent']:'';
		$customerIpAddress = isset($data['customerIpAddress'])?$data['customerIpAddress']:'';
		$customerSessionId = isset($data['customerSessionId'])?$data['customerSessionId']:'';
		
		$getURL = $url.'&customerUserAgent='.$customerUserAgent.'&cacheKey='.$cacheKey.'&cacheLocation='.$cacheLocation.'&customerIpAddress='.$customerIpAddress.'&customerSessionId='.$customerSessionId;
		$response = $this->executeCurl($getURL);
		return $response->HotelListResponse;
	}
	function executeCurl($url)
	{
		$header[] = "Accept: application/json";
		$header[] = "Accept-Encoding: gzip";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$response = json_decode(curl_exec($ch));
		return $response;
	}
	function getImageBySize($path,$image_size = 'z')
	{
		$fullpath = 'http://media.expedia.com'.$path;
		$path_parts = pathinfo($fullpath);
		$full_directry = $path_parts['dirname'].'/';
		$extension = $path_parts['extension'];
		$file_name = $path_parts['filename'];
		$file_name = substr($file_name, 0, -1).$image_size; 
		$return = $full_directry.$file_name.'.'.$extension;
		return $return;
	}
	function getHotelImages($hotelId)
	{
		$url = $this->hotalImagesUrl.'&apiKey='.$this->apiKey.'&minorRev='.$this->minorRev.'&cid='.$this->cid.'&supplierCacheTolerance='.$this->supplierCacheTolerance.'&locale='.$this->locale;
	
		$xml= '<HotelRoomImageRequest><hotelId>'.$hotelId.'</hotelId></HotelRoomImageRequest>';
		$getURL = $url.'&xml='.$xml;
		$response = $this->executeCurl($getURL);
		return $response;
	}
	function getRoomInfo($hotelId)
	{
		$url = $this->hotalInfoUrl.'&apiKey='.$this->apiKey.'&minorRev='.$this->minorRev.'&cid='.$this->cid.'&supplierCacheTolerance='.$this->supplierCacheTolerance.'&locale='.$this->locale;
	
		$hotelId= $hotelId;
		$getURL = $url.'&hotelId='.$hotelId;
		$response = $this->executeCurl($getURL);
		return $response;
	}
	function doHotelBooking($data)
	{
		//$url =	$this->hotalBookingUrl.'&cid='.$this->cid.'&apiKey='.$this->apiKey.'&customerUserAgent='.$this->customerUserAgent.'&customerIpAddress='.$this->customerIpAddress.'&customerSessionId='.$data['customerSessionId'].'&locale='.$this->locale.'&minorRev='.$this->minorRev.'&currencyCode=USD';
		$url =	$this->hotalBookingUrl;
		$data['cid'] 				= urlencode($this->cid);
		$data['apiKey'] 			= urlencode($this->apiKey);
		$data['customerUserAgent']  = urlencode($this->customerUserAgent);
		$data['customerIpAddress'] 	= urlencode($this->customerIpAddress);
		$data['locale'] 			= urlencode($this->locale);
		$data['minorRev'] 			= urlencode($this->minorRev);
		$data['currencyCode'] 		= 'USD';
		$hotelId = urlencode($data['hotelId']);
		$arrivalDate = urlencode(date('m/d/y',strtotime($data['arrivalDate'])));
		$departureDate = urlencode(date('m/d/y',strtotime($data['departureDate'])));
		$supplierType = 'E';
		$rateKey = urlencode($data['rateKey']);
		$roomTypeCode = urlencode($data['roomTypeCode']);
		$rateCode = urlencode($data['rateCode']);
		$chargeableRate = urlencode($data['chargeableRate']);
		$currencyCode = $data['currencyCode']; 
		$rooms = $data['rooms'];

		$email = urlencode($data['contact_email']);
		$firstName = urlencode($data['cardFirstName']);
		$lastName = urlencode($data['cardLastName']);
		$homePhone = urlencode($data['contact_phone']);
		$workPhone = urlencode($data['contact_workPhone']);
		$creditCardType = urlencode($data['creditCardType']);
		$creditCardNumber = urlencode($data['creditCardNumber']);
		$creditCardIdentifier = urlencode($data['creditCardIdentifier']);
		$creditCardExpirationMonth = urlencode($data['creditCardExpirationMonth']);
		$creditCardExpirationYear = urlencode($data['creditCardExpirationYear']);

		$address1 = urlencode($data['address1']);
		$city = $data['city'];
		$stateProvinceCode = urlencode($data['stateProvinceCode']);
		$countryCode = urlencode($data['countryCode']);
		$postalCode = urlencode($data['postalCode']);
		
		
		$return = $this->post_to_url($this->hotalBookingUrl,$data);
		//pr($return); die; ///// showing black page here..................... please note I am using sandbox account
		
		$getURL = $url.'cid='.$this->cid.'&minorRev='.$this->minorRev.'&apiKey='.$this->apiKey.'&locale='.$this->locale.'&currencyCode='.$currencyCode.'&hotelId='.$hotelId.'&arrivalDate='.$arrivalDate.'&departureDate='.$departureDate.'&supplierType='.$supplierType.'&rateKey='.$rateKey.'&roomTypeCode='.$roomTypeCode.'&rateCode='.$rateCode.'&chargeableRate='.$chargeableRate.'&email='.$email.'&firstName='.$firstName.'&lastName='.$lastName.'&homePhone='.$homePhone.'&workPhone='.$workPhone.'&creditCardType='.$creditCardType.'&creditCardNumber='.$creditCardNumber.'&creditCardIdentifier='.$creditCardIdentifier.'&creditCardExpirationMonth='.$creditCardExpirationMonth.'&creditCardExpirationYear='.$creditCardExpirationYear.'&address1='.$address1.'&city='.$city.'&stateProvinceCode='.$stateProvinceCode.'&countryCode='.$countryCode.'&postalCode='.$postalCode.$rooms;
		
		
		echo $getURL;
		$response = $this->executeCurl($getURL);
		pr($response); die;
		return $response;	
	}
	function post_to_url($url, $data) 
	{
		$fields = '';
		foreach ($data as $key => $value) {
			$fields .= $key . '=' . $value . '&';
		}
		rtrim($fields, '&');

		$post = curl_init();

		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_POST, count($data));
		curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

		
		$result = curl_exec($post);

		curl_close($post);
		return $result;
	}
	public function getReservation($infoArray)
	{
		//pr($infoArray); die;
		$rooms = intval($infoArray['numberOfRooms']);
		
		
		// Begin defining XML request string
		$xml = "<HotelRoomReservationRequest>";
		$xml .= "<hotelId>" . $infoArray['hotelId'] . "</hotelId>";
		$xml .= "<arrivalDate>". $infoArray['arrivalDate'] . "</arrivalDate>";
		$xml .= "<departureDate>" . $infoArray['departureDate'] . "</departureDate>";
		$xml .= "<supplierType>E</supplierType>";
		$xml .= "<rateKey>" . $infoArray['rateKey'] . "</rateKey>";
		$xml .= "<roomTypeCode>" . $infoArray['roomTypeCode'] . "</roomTypeCode>";
		$xml .= "<rateCode>" . $infoArray['rateCode'] . "</rateCode>";
		$xml .= "<chargeableRate>" . $infoArray['chargeableRate'] . "</chargeableRate>";
		//pr($infoArray); die;
		// Set Up Room object
		$xml .= '<RoomGroup>';
			for($i=0;$i<$rooms;$i++){
				$xml .= "<Room>";
				$xml .= "<numberOfAdults>" . $infoArray['room-'.$i.'-adult-total'] . "</numberOfAdults>";

        // If children were passed, set up appropriate XML vars
				if(intval($infoArray['room-'.$i.'-child-total']) > 0){
					$xml .= "<numberOfChildren>" . $infoArray['room-'.$i.'-child-total'] . "</numberOfChildren>";
					$xml .= "<childAges>";
					for($j=0;$j<$infoArray['room-'.$i.'-child-total'];$j++){
						if($j == 0)
							$childAgesStr = $infoArray['room-'.$i.'-child-'.$j.'-age'];
						else
							$childAgesStr .= ','. $infoArray['room-'.$i.'-child-'.$j.'-age'];
					}
					$xml .= $childAgesStr;
					$xml .= "</childAges>";
				}else{
				  //$xml .= "<numberOfChildren>0</numberOfChildren>";
				}
				
				$xml .= "<firstName>".$infoArray['room-'.$i.'-firstName']."</firstName>";
				$xml .= "<lastName>".$infoArray['room-'.$i.'-lastName']."</lastName>";
				$xml .= "<bedTypeId>".$infoArray['room-'.$i.'-bedTypeId']."</bedTypeId>";
				
				// If a room smoking preference was passed
				if($infoArray['room-'.$i.'-smokingPreference'])
					$xml .= "<smokingPreference>".$infoArray['room-'.$i.'-smokingPreference']."</smokingPreference>";
				
				$xml .= "</Room>";
			}
		$xml .= '</RoomGroup>';
		//-- End Room Obj
		
		// Set up ReservationInfo Obj
		$xml .= "<ReservationInfo>";
		$xml .= "<email>".$infoArray['contact_email']."</email>";
		$xml .= "<firstName>".$infoArray['cardFirstName']."</firstName>";
		$xml .= "<lastName>".$infoArray['cardLastName']."</lastName>";
		$xml .= "<homePhone>".$infoArray['contact_phone']."</homePhone>";

    // If a work-phone was passed
		if(!empty($infoArray['contact_workPhone']))
			$xml .= "<workPhone>".$infoArray['contact_workPhone']."</workPhone>";
			
		$xml .= "<creditCardType>".$infoArray['creditCardType']."</creditCardType>";
		$xml .= "<creditCardNumber>".$infoArray['creditCardNumber']."</creditCardNumber>";
		$xml .= "<creditCardIdentifier>".$infoArray['creditCardIdentifier']."</creditCardIdentifier>";
		$xml .= "<creditCardExpirationMonth>".$infoArray['creditCardExpirationMonth']."</creditCardExpirationMonth>";
		$xml .= "<creditCardExpirationYear>".$infoArray['creditCardExpirationYear']."</creditCardExpirationYear>";
		$xml .= "</ReservationInfo>";
		//-- End ResInfo Obj
		
		// Set up Address Info Obj
		$xml .= "<AddressInfo>";
		$xml .= "<address1>".$infoArray['address1']."</address1>";
		$xml .= "<city>".$infoArray['city']."</city>";
		$xml .= "<stateProvinceCode>".$infoArray['stateProvinceCode']."</stateProvinceCode>";
		$xml .= "<countryCode>".$infoArray['countryCode']."</countryCode>";
		$xml .= "<postalCode>".$infoArray['postalCode']."</postalCode>";
		$xml .= "</AddressInfo>";
		//-- End AddressInfo Obj

		$xml .= "</HotelRoomReservationRequest>";
			
		$result = $this->make_res_xml_request($xml);
		return $result;
	}
	public function make_res_xml_request($xml){
			
		if(empty($timestamp))
			$timestamp = gmdate('U');
			$sig = md5($this->apiKey . $this->secret . $timestamp);
		
		// Set post-data array
		$postData = array(
			'minorRev' => $this->minorRev,
			'cid' => $this->cid,
			'apiKey' => urlencode($this->apiKey),
			'sig' => $sig,
			'customerUserAgent' => urlencode($_SERVER['HTTP_USER_AGENT']),
			'customerIpAddress' => urlencode($_SERVER['REMOTE_ADDR']),
			'locale' => urlencode($this->locale),
			'currencyCode' => urlencode($this->currencyCode),
			//'_type' => urlencode($this->dataType),
			//'xml' => urlencode($xml)
			'xml' => ($xml)
		);
		//pr($postData); die;
		$url = "https://book.api.ean.com/ean-services/rs/hotel/v3/res";
		
		$postDataString = "";
		//pr($xml); die;
		foreach($postData as $key => $value){ 
			$postDataString .= $key.'='.$value.'&'; 
			}
		$postDataString = substr($postDataString, 0, -1);
		//pr($postDataString); die;
		// Expedia 1 Query-Per-Second Rule
		$time = microtime();
		//$microSeconds = $time - $lastRequest;
		//if($microSeconds < 1000000 && $microSeconds > 0)
			//usleep($microSeconds);
			

		// Begin executing CURL
		$curl_attempts = 0;
		$MAXIMUM_CURL_ATTEMPTS = $this->api_connection_retries;
		do{
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL, $url);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl,CURLOPT_TIMEOUT,30);
			curl_setopt($curl,CURLOPT_VERBOSE,1);
			curl_setopt($curl,CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl,CURLOPT_FRESH_CONNECT, 1);
			curl_setopt($curl,CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($curl,CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded',
														'Accept: application/xml'
														));

			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl,CURLOPT_POST, count($postData));
			curl_setopt($curl,CURLOPT_POSTFIELDS, $postDataString);

			$response = trim(curl_exec($curl));
			//pr($response); die;
			//flush();
			//ob_flush();
			curl_close($curl);
		} while (strlen($response) == 0 && ++$curl_attempts < $MAXIMUM_CURL_ATTEMPTS);
		$this->lastRequest = microtime();
		
		// Remove junk characters from response
		$response = str_replace("&amp;lt;","&lt;",$response);
		$response = str_replace("&amp;gt;","&gt;",$response);
		$response = str_replace("&amp;apos;","&apos;",$response);
		$response = str_replace("&amp;#x0A","",$response);
		$response = str_replace("&amp;#x0D","",$response);
		$response = str_replace("&#x0D","",$response);
		$response = str_replace("&#x0A","",$response);
		$response = str_replace("&amp;#x09","",$response);
		$response = str_replace("&amp;amp;amp;","&amp;",$response);
		$response = str_replace("&lt;br&gt;","<br />",$response);
		$xml_response = simplexml_load_string($response);
		
		if((string)$xml_response->EanWsError->handling == 'RECOVERABLE' && (string)$xml_response->EanWsError->category == 'AUTHENTICATION'){
			$newServerTime = $xml_response->EanWsError->ServerInfo['timestamp'];
			//return $this->make_res_xml_request($xml);
		}
		
		// If we cannot connect to the EAN API
		if (strlen($response) == 0)
			$response = '<response><error>Error reaching XML gateway. We\'re working on this problem and apologize for the inconvenience</error></response>';
		else{
			//if(isset($response['']
			//$_SESSION['customerSessionId'] = $response[]['customerSeassionId'];
		}
			//pr($response); die;
		return $response;
	}
	
	public function cancelResevation($data = null){
		$url =	$this->hotalCancelUrl;
		$record = array();
		$record['cid'] 					= urlencode($this->cid);
		$record['apiKey'] 				= urlencode($this->apiKey);
		$record['customerUserAgent']  	= urlencode($this->customerUserAgent);
		$record['customerIpAddress'] 	= urlencode($this->customerIpAddress);
		$record['locale'] 				= urlencode($this->locale);
		$record['minorRev'] 			= urlencode($this->minorRev);
		$customerSessionId				= $data['customerSessionId'];
		$record['currencyCode'] 		= 'USD';
		

		$xml = "<HotelRoomCancellationRequest>";
		$xml .= "<itineraryId>" . $data['itineraryId'] . "</itineraryId>";
		$xml .= "<email>". $data['email_id'] . "</email>";
		$xml .= "<reason>". $data['reason'] . "</reason>";
		$xml .= "<confirmationNumber>". $data['confirmationNumber'] . "</confirmationNumber>";
		$xml .= "</HotelRoomCancellationRequest>";
		$record['xml'] = $xml;
		//$response = $this->post_to_url($url,$record);
		//pr($response); die;
		
		$currencyCode	= 'USD';
		$itineraryId = $data['itineraryId'];
		$email = $data['email_id'];
		$reason = $data['reason'];
		$confirmationNumber = $data['confirmationNumber'];
		$getURL = $url.'cid='.urlencode($this->cid).'&minorRev='.urlencode($this->minorRev).'&apiKey='.urlencode($this->apiKey).'&locale='.urlencode($this->locale).'&currencyCode='.urlencode($currencyCode).'&customerSessionId='.urlencode($customerSessionId).'&customerUserAgent='.urlencode($this->customerUserAgent).'&customerIpAddress='.urlencode($this->customerIpAddress).'&itineraryId='.urlencode($itineraryId).'&email='.urlencode($email).'&reason='.urlencode($reason).'&confirmationNumber='.urlencode($confirmationNumber);
		//pr($getURL); die;
		$response = $this->executeCurl($getURL);
		
		return json_decode($response);
	} 
}
