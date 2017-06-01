<?php
class Register extends AppModel{
	public $name = 'Register';
	var $actsAs  = 	array('Utils.Sluggable' => array('label' => 'firstname',
														'method' => 'multibyteSlug'
													  ));
	public $useTable = 'users';
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
			),
			'min_length' => array(
				'rule' => array('minLength', '4'), 
				'message' => 'Firstname must have a minimum of 4 characters'
			),
			'maxLength' => array(
				'rule' => array('maxLength', '15'), 
				'message' => 'Firstname must be no larger than 15 characters long'
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
			),
			'min_length' => array(
					'rule' => array('minLength', '4'), 
					'message' => 'Lastname must have a minimum of 4 characters'
			),
			'maxLength' => array(
				'rule' => array('maxLength', '15'), 
				'message' => 'Lastname must be no larger than 15 characters long'
			)
		),
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
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a value for password.'
			),
			'min_length' => array(
				'rule' => array('minLength', '6'), 
				'message' => 'Password must have a minimum of 6 characters'
			)
		),
		'confirm_password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a value for Confirm password.'
			),
			'min_length' => array(
				'rule' => array('minLength', '6'), 
				'message' => 'Confirm Password must have a minimum of 6 characters'
			),
			'match_password' => array(
				'rule' => 'matchpassword', 
				'message' => 'Password must be same'
			)
		),
		'terms' => array(
				'rule'     => array('comparison', '!=', 0),
				'required' => true, 
				'message' => 'Please Checked Terms And Conditions for if you want to proceed',
				'allowEmpty' => false
			
		)
	);
	public function matchpassword(){
		 $password		=	AuthComponent::password($this->data[$this->alias]['password']);
		 $temppassword	=	AuthComponent::password($this->data[$this->alias]['confirm_password']);
		if($password==$temppassword){
			return true;
		}
		else{
			return false; 
		}
	}
}
?>
