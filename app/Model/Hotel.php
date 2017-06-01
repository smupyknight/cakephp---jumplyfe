<?php
class Hotel extends AppModel{
											  
		public $validate = array(
			'firstname' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Enter Your Firstname',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[a-zA-z ]*$/',
					'message' => 'Only Alphabets Are allowed in Firstname'
				)
			),
			'lastname' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Enter Your Lastname',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[a-zA-z ]*$/',
					'message' => 'Only Alphabets Are allowed in Lastname'
				)
			),
			'smoking_preferences' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Select Your smoking preferences',
					'allowEmpty' => false
				)
			)
			/*'special_requests' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please fill Your special requests',
					'allowEmpty' => false
				)
			),*/
		);
	public function contactDetailValidate(){
		$validate = array(
			'email' => array(
				'required' => array(
					'rule' => array('email', true),   
					'message' => 'Please provide a valid email address.'   
				),
				'unique' => array(
					'rule'    => 'isUnique',
					'message' => 'This email has already been taken.'
				)
			),
			'confirm_email_address' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for Confirm Email.'
				),
				'match_email' => array(
					'rule' => 'matchEmail', 
					'message' => 'Email and Confirm email address must be same.'
				)
			),
			'telephone_number' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter your telephone number.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[0-9 +]*$/',
					'message' => 'A Telephone Number Field should be integer'
				)
			)
		);
		
		$this->validate = $validate;
		return $this->validates();
	
	}
	
	public function creditCardDetailValidate(){
		$validate = array(
			'card_type' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Select Your card_type',
					'allowEmpty' => false
				)
			),
			'card_number' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter your card number.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[0-9]*$/',
					'message' => 'Only Integer Are allowed in Card Number Field.'
				),
				'max_length' => array(
					'rule' => array('maxLength', '19'), 
					'message' => 'Password must have a maximum of 19 characters'
				)
			),
			'cardholder_first_name' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Enter Card Holder Firstname',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[a-zA-z ]*$/',
					'message' => 'Only Alphabets Are allowed in Firstname'
				)
			),
			'cardholder_last_name' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Enter Card Holder Lastname',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[a-zA-z ]*$/',
					'message' => 'Only Alphabets Are allowed in Card Holder Lastname'
				)
			),
			'month' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select Your expiration date month',
					'allowEmpty' => false
				)
			),
			'year' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select Your expiration date year',
					'allowEmpty' => false
				)
			),
			'security_code' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Enter Card Security Code',
					'allowEmpty' => false
				)
			),
			'country' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please Select Your Country',
					'allowEmpty' => false
				)
			),
			'state' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter Your state',
					'allowEmpty' => false
				)
			),
			'city' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter Your city',
					'allowEmpty' => false
				)
			),
			'address_line_1' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for address line 1',
					'allowEmpty' => false
				)
			),
			'address_line_2' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for address line 2',
					'allowEmpty' => false
				)
			),
			'zipcode' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for zipcode',
					'allowEmpty' => false
				)
			),
			'terms' => array(
				'rule'     => array('comparison', '!=', 0),
				'required' => true, 
				'message' => 'Please Checked Terms And Conditions for if you want to proceed',
				'allowEmpty' => false
			
			)
		);
		
		$this->validate = $validate;
		return $this->validates();
	
	}
	public function matchEmail(){
		 $email			=	$this->data[$this->alias]['email_address'];
		 $comfirm_email	=	$this->data[$this->alias]['confirm_email_address'];
		if($email==$comfirm_email){
			return true;
		}
		else
		{
			return false; 
		}
	}
}
