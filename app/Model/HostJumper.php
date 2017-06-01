<?php
class HostJumper extends AppModel {
	public $useTable = false;
	public function basic_information_validate(){
		$validate = array(
			'host_jumper_about_me' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for last name.',
					'allowEmpty' => false
				)
			),
			'host_jumper_price' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for price.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[0-9.]*$/',
					'message' => 'Please enter number and floating number in price field.'
				)
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function bookingFormValidate(){
		$validate = array(
			'booking_for_date' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your date.',
					'allowEmpty' => false
				)
			),
			'jump_id' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your jump.',
					'allowEmpty' => false
				)
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function HostJumperReviews(){
		$validate = array(
			'comment' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter your review.'
				)
			),
			'rating' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please fill your rating.'
				),
				'min_length' => array(
					'rule' => 'checkRating', 
					'message' => 'Please Select your rating'
				)
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function checkRating(){
		 $rating = $this->data[$this->alias]['rating'];
		if($rating == 0){
			return false; 
		}
		else{
			return true;
		}
	}
}