<?php 
class Account extends AppModel{
	public $useTable = false;
	public $validate = array(
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
	
	public function add_jumpHost(){
		$validate = array(
			 'title' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Title is Required.'
				),
				'rule2' => array(
						'rule' => '/^[a-zA-z0-9,.!$ ]*$/',
						'message' => 'Only 	Alphabets Are allowed in Title'
					)
			),
			'description' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Description is Required.'
				)
			),
			'accommodates' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Accommodations is Required.'
				),
				'rule2' => array(
						'rule' => '/^[0-9+]*$/',
						'message' => 'Only Number Are allowed in Accommodations'
				)
			),
			/*'bathrooms' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Enter a value for number of bathrooms.'
				),
				'rule2' => array(
						'rule' => '/^[0-9]*$/',
						'message' => 'Only Number Are allowed in this field'
				)
			),
			'bedrooms' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Enter a value for number of bedrooms.'
				),
				'rule2' => array(
						'rule' => '/^[0-9]*$/',
						'message' => 'Only Number Are allowed in this field'
				)
			),*/
			'price' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Enter a value for price.'
				),
				'rule2' => array(
						'rule' => '/^[0-9.]*$/',
						'message' => 'Only Number and floating number Are allowed in this field'
				)
			),
			/*'beds' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Enter a value for number of beds.'
				),
				'rule2' => array(
						'rule' => '/^[0-9]*$/',
						'message' => 'Only Number Are allowed in this field'
				)
			),
			'address_line_1' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Address Line 1 is Required.'
				),
				'rule2' => array(
						'rule' => '/^[A-Za-z 0-9,-. ]*$/',
						'message' => 'Please enter a valid address line 1'
				)
			),
			'address_line_2' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Address Line 2 is Required.'
				),
				'rule2' => array(
						'rule' => '/^[A-Za-z 0-9,-. ]*$/',
						'message' => 'Please enter a valid address line 2'
				)
			),
			'zipcode' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Zipcode is Required.'
				),
				'rule2' => array(
						'rule' => '/^[0-9 -]*$/',
						'message' => 'Only 	Number Are allowed in Zipcode'
				)
			),*/
			'country_code' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for Country.'
				)
			),
			'state_code' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for State.'
				)
			),
			'city_code' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for City.'
				)
			),
			'home_type_id' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for Home Type.'
				)
			),
			'room_type_id' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for Room Type.'
				)
			),
			/* 'amenities' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for Amenities.'
				)
			), */
			'check_in_time' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for Check In Time.'
				)
			),
			'check_out_time' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Select A value for Check Out Time.'
				)
			)
			/*'check_in_instructions' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Please Enter A value for Check Out Instructions.'
				)
			)*/
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function JumpHostGalleryValidate(){
		$validate1 = array(
			'file_name' => array(
				'rule1' => array(
					'rule' => array('extension',array('gif', 'jpeg', 'png', 'jpg')),
					'message' => 'Please supply a valid image.'
				),
				'rule2' => array(
					'rule' => array('checkSize',true),
					'message' => 'Image must be less than '.round(Configure::read("Site.max_upload_image_size") / 1024) . 'MB'
				
				)
			)
		);
		
		$this->validate = $validate1;
		return $this->validates();
	}
	
	function checkSize($data){
        $data = array_shift($data);
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
?>
