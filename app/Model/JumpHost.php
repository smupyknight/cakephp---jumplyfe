<?php
class JumpHost extends AppModel{
	public function reviews(){
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
	
	public function jump_host_booking(){
		$validate = array(
			'check_in' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please fill a value for check in.'
				)
			),
			'check_out' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please fill a value for check out.'
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


?>