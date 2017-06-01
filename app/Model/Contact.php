<?php
class Contact extends AppModel{
	
	public function contact_us_validate(){
		$validate = array(
			'name' => array(
				'rule1'=>array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter your name',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[a-zA-z ]*$/',
					'message' => 'Only Alphabets Are allowed in name'
				)
			),
			
			'email' => array(
				'required' => array(
					'rule' => array('email', true),   
					'message' => 'Please provide a valid email address.'  
				) 
			),
			'subject' => array(
				'rule' => array('notEmpty'),
				'message' => 'Message field is required',
				'allowEmpty' => false
			),
			'message' => array(
				'rule' => array('notEmpty'),
				'message' => 'Message field is required',
				'allowEmpty' => false
			)
			
		);
		$this->validate = $validate;
		return $this->validates();
	}

}

?>
