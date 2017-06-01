<?php 
App::uses('Paypal', 'Paypal.Lib'); 
App::uses('HostJumpersController', 'Controller');
class CronController extends AppController{
	public $helper = array('Html');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('updateCurrencies','cronForOneHour','payment_To_Host_Jumper','change_jump_rental_booking_status','check_elite_membership_expiry_date');
	}
	public function updateCurrencies()
	{
		$this->loadModel('Currencies');
		$currencies = $this->Currencies->find('all');
		foreach($currencies as $key => $value)
		{
			$response = json_decode(file_get_contents('http://rate-exchange.appspot.com/currency?from=USD&to='.$value['Currencies']['currency_code']));
			$exchange_rate_usd = $response->rate;
			$this->Currencies->id = $value['Currencies']['id'];
			$this->Currencies->saveField('exchange_rate_usd',$exchange_rate_usd);
			pr($response);
		}
	}
	
	public function cronForOneHour(){
		$this->updateCurrencies();
		$this->payment_To_Host_Jumper();
		$this->change_jump_rental_booking_status();
		$this->check_elite_membership_expiry_date();
		die('Cron Done');
	}
	
	public function payment_To_Host_Jumper(){
		App::import('Controller','HostJumpersController.php');
		$Users = new HostJumpersController;
		$data = $Users->hostJumper_Payment();
	
	}
	
	public function change_jump_rental_booking_status(){
		$this->loadModel('JumpHost');
		$jumpRentals = $this->JumpHost->find('all',array('JumpHost.status'=>1));
		$this->loadModel('BookingJumpHost');
		$current_date = date('Y-m-d');
		if(isset($jumpRentals) && !empty($jumpRentals)){
			foreach($jumpRentals as $key => $value){
				$id = $value['JumpHost']['id'];
				$data = $this->BookingJumpHost->find('first',array('conditions'=>array('BookingJumpHost.jump_host_id'=>$id,'BookingJumpHost.check_in <='=>$current_date,'BookingJumpHost.check_out >='=>$current_date,'BookingJumpHost.is_cancelled'=>'No')));
				if(isset($data) && !empty($data)){
					$update_record = array();
					$update_record['JumpHost']['is_booked'] = 'Yes';
					$update_record['JumpHost']['latest_check_in_date_time'] = $data['BookingJumpHost']['check_in'];
					$update_record['JumpHost']['latest_check_out_date_time'] = $data['BookingJumpHost']['check_out'];
					$this->JumpHost->id = $id;
					$this->JumpHost->save($update_record,false);
				}
			}
		}
	}
	
	public function check_elite_membership_expiry_date(){
		$this->loadModel('User');
		$users = $this->User->find('all',array('User.status'=>1,'User.elite_membership_status'=>'Active'));
		$current_date = date('Y-m-d');
		if(isset($users) && !empty($users)){
			foreach($users as $key => $value){
				if($value['User']['elite_membership_expire_date'] < $current_date){
					$update_record = array();
					$update_record['User']['elite_membership_status'] = 'Inactive';
					$update_record['User']['elite_membership_expire_date'] = '0000-00-00';
					$this->User->id = $value['User']['id'];
					$this->User->save($update_record,false);
				}
			}
		}
	}
}

