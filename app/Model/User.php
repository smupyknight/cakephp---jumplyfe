<?php
App::uses('AppModel','Model');
class User extends AppModel {
	 public $hasMany = array(
			'SocialProfile' => array(
			'className' => 'SocialProfile',
		)
	);
	var $actsAs  = 	array('Utils.Sluggable' => array('label' => 'firstname',
														'method' => 'multibyteSlug'
													  )); 
	public function basic_information_validate(){
		$validate = array(
			'firstname' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for first name.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[a-zA-z ]*$/',
					'message' => 'Only alphabets are allowed in firstname.'
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
					'message' => 'Please enter a value for last name.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[a-zA-z ]*$/',
					'message' => 'Only alphabets are allowed in lastname.'
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
			/*'zipcode' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for zipcode.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[0-9]*$/',
					'message' => 'A zipcode field should be integer.'
				)
			),
			
			'address' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter your Address.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid address.'
				)
			),*/
			'country_code' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your country.',
					'allowEmpty' => false
				)
			),
			/*'state_code' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your state.',
					'allowEmpty' => false
				)
			),
			'city_code' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your city.',
					'allowEmpty' => false
				)
			),
			'about_me' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please fill about me field.',
					'allowEmpty' => false
				)
			),*/
			'slug' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please fill username field.',
					'allowEmpty' => false
				),
				'duplicate' => array(
					'rule' => 'isUnique',
					'message' => 'This username is already exist.'
				),
				'rule2' => array(
					'rule' => '/^[a-z0-9]*$/',
					'message' => 'Only lower alphabets and number are allowed in username.'
				),
				'min_length' => array(
					'rule' => array('minLength', '4'), 
					'message' => 'Username must have a minimum of 4 characters'
				),
				'maxLength' => array(
					'rule' => array('maxLength', '15'), 
					'message' => 'Username must be no larger than 15 characters long'
				)
			),
			'dob' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please fill date of birth field.',
					'allowEmpty' => false
				)
			),
			'image' => array(
				'rule1' => array(
					'rule' => array('extension',array('gif', 'jpeg', 'png', 'jpg','')),
					'message' => 'Please supply a valid image.'
				),
				'rule2' => array(
					'rule' => array('checkSize',true),
					'message' => 'Image must be less than '.round(Configure::read("Site.max_upload_image_size") / 1024) . 'MB'
				
				)
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
		
	
	public function reset_password(){
	
		$validate = array(
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
					'rule' => 'matchpassword', 
					'message' => 'Password must be same'
				)
			),	
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
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
	

	public function forget_password(){
		$validate2 = array(
			'email' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please Provide a valid email address',
				'allowEmpty' => false
			)
		);
		$this->validate = $validate2;
		return $this->validates();
	
	}
	public function change(){
		$validate1 = array(
			'new_password' => array(
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
					'message' => 'Confirm must have a minimum of 6 characters'
				),
				'rule2' => array(
					'rule' => 'change_password_match', 
					'message' => 'Password must be same'
				)
			),
			'current_password' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please provide your old password'
				 ),
				'rule2' => array(
					'rule' => 'checkpassword',
					'message' => 'Please enter correct old password',
					'last'=>true
				)
			),

		);
		$this->validate = $validate1;
		return $this->validates();
	}
	
	public function inviteFriendValidate(){
		
		$validate = array(
			'target_full_name' => array(
					'rule1' => array(
						'rule' => array('notEmpty'),
						'message' => 'Please enter a value for name.',
						'allowEmpty' => false
					),
					'rule2' => array(
						'rule' => '/^[a-zA-z ]*$/',
						'message' => 'Only alphabets are allowed in name.'
					)
			),
			'email' => array(
				'required' => array(
					'rule' => array('email', true),   
					'message' => 'Please provide a valid email address.'   
				),
				'unique' => array(
					'rule'    => 'isUnique',
					'message' => 'Your given email address already register with us.'
				)
			),
		
		);
		
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function inviteFriendRegisterValidate(){
		
		$validate = array(
			'email' => array(
				'rule' => array('email', true),   
				'message' => 'Please provide a valid email address.'   
			)
		
		);
		
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function change_password_match(){
		 $password		=	AuthComponent::password($this->data[$this->alias]['new_password']);
		 $temppassword	=	AuthComponent::password($this->data[$this->alias]['confirm_password']);
		if($password==$temppassword){
			return true;
		}
		else{
			return false; 
		}
	}
	
	public function checkpassword(){
		$password	=	$this->data['User']['current_password'];
		$user_pass	=	$this->data['User']['user_pass'];
		if(AuthComponent::password($password) == $user_pass) {
			return true;
		} else {
			return false;
		}
	}

	public function mobile_checkpassword($db_password, $request_password)
	{
		if (AuthComponent::password($db_password) == $request_password){
			return true;
		} else {
			return false;
		}
	}
	
	public function login_validation(){
		$validate4 = array(
			'email' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please Enter Your email address',
				'allowEmpty' => false
			),
			'password' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please Enter Your Password',
				'allowEmpty' => false
			)
		);
			
		$this->validate = $validate4;
		return $this->validates();
	}
	public function createFromSocialProfile($incomingProfile){
		$existingUser = $this->find('first', array(
			'conditions' => array('email' => $incomingProfile['SocialProfile']['email'])));
		 
		if($existingUser){
			
			return $existingUser;
			
		}
		
		$socialUser['User']['email'] = $incomingProfile['SocialProfile']['email'];
		$socialUser['User']['image'] = $incomingProfile['SocialProfile']['picture'];
		$name = explode(" ",$incomingProfile['SocialProfile']['display_name']);
		$socialUser['User']['firstname'] = $name[0];
		$socialUser['User']['lastname'] = $name[1];
		$socialUser['User']['user_role_id'] = 2; 
		$socialUser['User']['status'] = 1; 
		$socialUser['User']['is_email_verified'] = 1; 
		$this->save($socialUser);
		$socialUser['User']['id'] = $this->id;
		 
		return $socialUser;
	}
	public function sendMoneyAmount(){
		$validate = array(
			'amount' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for Amount.'
				),
				'rule2' => array(
					'rule' => '/^[0-9.]*$/',
					'message' => 'Only Integer Are Allowed'
				)
			)
		);
		$this->validate =  $validate;
		return $this->validates();
	}
	
	function checkSize($data){
        $data = array_shift($data);
        if(empty($data)){
			return true;
		}
        if($data['size'] == 0 || $data['size'] / 1024 > Configure::read("Site.max_upload_image_size"))
        {
            return false;
        }
        else
        {
			return true;
		}
    }
}
