<?php 
class SearchesController extends AppController{
	public $helper = array('Form','Html');
	public $components = array('Paginator','RequestHandler','Search.Prg');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('index','demo','getCitiesAuto'));
	}

	public function jumpers(){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$this->loadModel('User');
		$this->User->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
			'country' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code'
		);
		$name = (isset($_GET['name'])&& $_GET['name'])?$_GET['name']:'';
		$name = trim($name);
		$this->set('name',$name);
		$this->Paginator->settings = array(
			'User'=>array(
				'conditions'=>array(
					'User.firstname LIKE' => '%'.$name.'%',
					'User.id !='=>$this->Auth->user('id'),
					'User.status'=>1,'User.user_role_id'=>2
				),
				'limit' => 6,
				'order' => 'User.created desc',
				'paramType' => 'querystring'
			)
		);
		$this->set('users',$this->Paginator->paginate('User'));
	} 
	
	public function host_jumpers(){
		$user_id = $this->Auth->User('id');
		$profile_user_id = $user_id;
		$this->set('left_part_user_id',$profile_user_id);
		$this->loadModel('User');
		$this->User->virtualFields = array(
			'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
			'country' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code'
		);
		$name = (isset($_GET['name'])&& $_GET['name'])?$_GET['name']:'';
		$keyword = (isset($_GET['keyword'])&& $_GET['keyword'])?$_GET['keyword']:'';
		$name = trim($name);
		$keyword = trim($keyword);
		$this->set('name',$name);
		
		$this->Paginator->settings = array(
			'User'=>array(
				'conditions'=>array(
					'User.firstname LIKE' => '%'.$name.'%',
					'OR'=>array(
						'User.host_jumper_about_me LIKE' => '%'.$keyword.'%',
						'User.firstname LIKE' => '%'.$keyword.'%',
					),	
					'User.id !='=>$this->Auth->user('id'),
					'User.status'=>1,'User.user_role_id'=>2,
					'User.is_host_jumper'=>'Yes'
				),
				'limit' => 6,
				'order' => 'User.created desc',
				'paramType' => 'querystring'
			)
		);
		$this->set('users',$this->Paginator->paginate('User'));
	} 
	
	public function search_page(){
		$this->loadModel('JumpHost');
		$this->loadModel('JumpHostReview');
		$this->loadModel('JumpHostGallery');
		$this->loadModel('User');
		$startDateFrom = date('d-m-Y');
		$endDateFrom = date('d-m-Y',strtotime("+1 Year",time()));
		$this->set('startDateFrom',$startDateFrom);
		$this->set('endDateFrom',$endDateFrom);
		$startDateTo = date('d-m-Y');
		$endDateTo = date('d-m-Y',strtotime("+1 Year",time()));
		$this->set('startDateTo',$startDateTo);
		$this->set('endDateTo',$endDateTo);
		$keyword = (isset($_GET['keyword'])&& $_GET['keyword'])?$_GET['keyword']:'';
		$min_price = (isset($_GET['min_price'])&& $_GET['min_price'])?$_GET['min_price']:'1';
		$max_price = (isset($_GET['max_price'])&& $_GET['max_price'])?$_GET['max_price']:'100000';
		$date_from = date('Y-m-d',strtotime((isset($_GET['date_from'])&& $_GET['date_from'])?$_GET['date_from']:date('Y-m-d')));
		$date_to = date('Y-m-d',strtotime((isset($_GET['date_to'])&& $_GET['date_to'])?$_GET['date_to']:date('Y-m-d',strtotime('+2 months',time()))));
		$this->set('keyword',$keyword);
		$this->set('date_from',date('d-m-Y',strtotime($date_from)));
		$this->set('date_to',date('d-m-Y',strtotime($date_to)));
		
		$this->Paginator->settings = array(
			'JumpHost'=>array(
				'conditions'=>array(
									'JumpHost.title LIKE' => '%'.$keyword.'%',
									'JumpHost.price  >=' => $min_price,
									'JumpHost.price <=' => $max_price,
									'JumpHost.latest_check_in_date_time  >=' => $date_from,
									'JumpHost.latest_check_out_date_time <=' => $date_to,
									'JumpHost.status'=>1
								),
				'limit' => 6,
				'order' => 'JumpHost.created DESC',
				'fields' => array('id','slug'),
				'paramType' => 'querystring'
			)
		);
		$JumpHost_record = $this->Paginator->paginate('JumpHost');
		foreach($JumpHost_record as $key =>$value){
			$JumpHost_record[$key]['JumpHost']['image'] = $this->JumpHostGallery->primaryJumpImage($value['JumpHost']['id']);
			$JumpHost_record[$key]['JumpHost']['image'] = $JumpHost_record[$key]['JumpHost']['image']['JumpHostGallery']['file_name'];
		}
		
		$this->User->virtualFields = array(
				'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
				'country' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code'
			);
		$host_jumpers = $this->User->find('all',array('conditions'=>array('User.id !='=>$this->Auth->user('id'),'User.firstname LIKE' => '%'.$keyword.'%','User.is_host_jumper'=>'Yes','User.status'=>1),'order'=>'User.created DESC','fields'=>array('User.firstname','User.lastname','User.city','User.country','User.image','User.slug')));
		
		$this->set('host_jumpers',$host_jumpers);
		$this->set('JumpHost_record',$JumpHost_record);
		
		$this->loadModel('Jump');
		$jump_record = $this->Jump->find('all',array('conditions'=>array('Jump.title LIKE'=>'%'.$keyword.'%','Jump.status'=>1),'order'=>'Jump.created DESC'));
		if($jump_record){
			foreach($jump_record as $key => $value){
			   $jump_record[$key]['Jump']['logo'] = $this->User->find('first',array('conditions'=>array('User.id'=>$value['Jump']['user_id']),'fields'=>array('User.image','User.firstname','User.lastname')));
			}
		}
		$this->set('jump_record',$jump_record);
		
	}
	
	
	public function index(){
		
		$arrivalDate = 	 date('m/d/Y',strtotime('+1 day',time()));
		$departureDate = date('m/d/Y',strtotime('+2 day',time()));
		$this->set('arrivalDate',$arrivalDate);
		$this->set('departureDate',$departureDate);
		$this->set('arrivalDateMin',date('m/d/Y'));
		$this->set('departureDateMin',date('m/d/Y'));
		
		$this->loadModel('User');
		$this->loadModel('Country');
		$this->User->virtualFields = array(
			'city_name' => 'SELECT city_name FROM cities WHERE id = User.city_code'
		);
		
		if($this->Auth->user())
		{
			$user_info = $this->User->findById($this->Auth->user('id'));
			
			
			$weather_info = @file_get_contents('http://api.openweathermap.org/data/2.5/weather?APPID=d6b348e6d8f85b7b96fe55166e71ddc9&q='.$user_info['User']['city_name'].','.$user_info['User']['country_code']);
			
			$weather_information = json_decode($weather_info);
			//pr($weather_information); die;
			if(!$weather_information)
			{
				$this->set('weather_info','');
			}
			else if(isset($weather_information->message) && !empty($weather_information->message))
			{
				$this->set('weather_info','');
			}
			else
			{
				
				$record = array();
				$record['city']   		= 	$user_info['User']['city_name'];
				$record['country']	   	=	$user_info['User']['country_code'];
				$record['clouds']  		= 	$weather_information->weather[0]->main;
				$record['description']  = 	$weather_information->weather[0]->description;
				$record['temp']  		= 	$weather_information->main->temp;
				$record['icon']  		= 	$weather_information->weather[0]->icon;
				
				if(!empty($record['temp']))		
				{
					$record['temp']  	= 	$record['temp'] - 273.15;
					$record['temp']  	= 	$record['temp'] * 9/5 + 32;
					
				}
				
				$this->set('weather_info',$record);
			}
		}	
		
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1),'fields'=>array('iso_code','country_name')));
		$this->set('countries',$countries);
		
		
	}
	
	
	public function getCitiesAuto($query){
		$query = strtolower($query);
		$this->loadModel('City');
		$this->City->virtualFields = array(
			'country' => 'SELECT country_name FROM countries WHERE iso_code = City.country_iso_code'
		);
		
		$cities = $this->City->find('all',array('conditions'=>array('LOWER(City.city_name) LIKE' => '%'.$query.'%','City.status'=>1),'limit'=>10))	;
		//pr($cities); die;
		if(!empty($cities))
		{
			$data = array();
			foreach($cities as $key => $value){
				$data[$key]['id'] 	= $value['City']['id'];
				$data[$key]['name'] = $value['City']['city_name'];
				$data[$key]['full_name'] = $value['City']['city_name'].', '.$value['City']['country'];

			}
		}
		else
		{
			$data[1]['id'] = '';
			$data[1]['name'] = '';
			$data[1]['value'] = '';
		}
		//pr($data); die;
		echo json_encode($data); die;
	}
	
	public function demo(){
		
		$this->layout = false;
		
	}
}
	
