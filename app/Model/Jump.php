<?php
class Jump extends AppModel{
	var $actsAs = 	array('Utils.Sluggable' => array('label' => 'title',
														'method' => 'multibyteSlug'
													  ));
	public function add_JumpShot(){
		$validate = array(
			/*'media_title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot title.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot title.'
				)
			),
			'media_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot description.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot description.'
				)
			),*/
			'image' => array(
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
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function add_JumpVideo(){
		$validate = array(
			/*'media_title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot title.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot title.'
				)
			),
			'media_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot description.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot description.'
				)
			),*/
			'video' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot video.'
				)
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function upload_JumpVideo(){
		$validate = array(
			/*'media_title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot title.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot title.'
				)
			),
			'media_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot description.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot description.'
				)
			),*/
			'upload_video' => array(
				'rule1' => array(
					'rule' => array('extension',array('flv', 'mp4','WebM')),
					'message' => 'Please supply a valid video.'
				),
				'rule2' => array(
					'rule' => array('checkVideoSize',true),
					'message' => 'Video must be less than '.round(Configure::read("Site.max_upload_video_size") / 1024) . 'MB'
				
				)
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function MyJumpAdd(){
		$validate = array(
			'title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump title.'
				)/*,
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump title.'
				)*/
			),
			/*'short_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a jump short description.'
				)
			),*/
			'description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a jump description.'
				)/*,
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump description.'
				)*/
			),
			'image' => array(
				'rule1' => array(
					'rule' => array('extension',array('gif', 'jpeg', 'png', 'jpg')),
					'message' => 'Please supply a valid image.'
				),
				'rule2' => array(
					'rule' => array('checkSize',true),
					'message' => 'Image must be less than '.round(Configure::read("Site.max_upload_image_size") / 1024) . 'MB'
				
				)
			),
			/*'address_line_1' => array(
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
			),*/
			/*'address_line_2' => array(
				'valid' => array(
						'rule' => 'notEmpty',
						'required' => true,
						'allowEmpty' => false,
						'message' => 'Address Line 2 is Required.'
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
						'message' => 'Please Select a value for Country.'
				)
			)/*,
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
			),*/
			
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function MyJumpEdit(){
		$validate = array(
			'title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump title.'
				)/*,
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump title.'
				)*/
			),
			/*'short_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a jump short description.'
				) ,
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump short description.'
				) 
			),*/
			'description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a jump description.'
				)/*,
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump description.'
				) */
			),
			'image' => array(
				'rule1' => array(
					'rule' => array('extension',array('gif', 'jpeg', 'png', 'jpg','')),
					'message' => 'Please supply a valid image.'
				),
				'rule2' => array(
					'rule' => array('checkSizeEdit',true),
					'message' => 'Image must be less than '.round(Configure::read("Site.max_upload_image_size") / 1024) . 'MB'
				
				)
			),
			/*'address_line_1' => array(
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
			),*/
			/*'address_line_2' => array(
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
						'message' => 'Please Select a value for Country.'
				)
			)/*,
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
			),*/
			
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function photoGalleryValidate(){
		$validate = array(
			/*'media_title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot title.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot title.'
				)
			),
			'media_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot description.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot description.'
				)
			),*/
			'image' => array(
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
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function videoGalleryValidate(){
		$validate = array(
			/*'media_title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot title.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot title.'
				)
			),
			'media_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot description.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot description.'
				)
			),*/
			'video' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot description.'
				)
			),
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	
	public function uploadVideoGallery(){
		$validate = array(
			/*'media_title' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot title.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot title.'
				)
			),
			'media_description' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter jump shot description.'
				),
				'rule2' => array(
					'rule' => '/^[0-9a-zA-z ,-]*$/',
					'message' => 'Please enter a valid value for jump shot description.'
				)
			),*/
			'upload_video' => array(
				'rule1' => array(
					'rule' => array('extension',array('flv', 'mp4','WebM')),
					'message' => 'Please supply a valid video.'
				),
				'rule2' => array(
					'rule' => array('checkVideoSize',true),
					'message' => 'Video must be less than '.round(Configure::read("Site.max_upload_video_size") / 1024) . 'MB'
				
				)
			)
		);
		$this->validate = $validate;
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
	
	function checkSizeEdit($data){
        $data = array_shift($data);
        if(empty($data))
        {
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
    
	function checkVideoSize($data){
        $data = array_shift($data);
        if($data['size'] == 0 || $data['size'] / 1024 > Configure::read("Site.max_upload_video_size"))
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
