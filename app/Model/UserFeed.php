<?php 
class UserFeed extends AppModel{
	public $belongsTo = array(
							"FeedType",
							'PrivateProfile' => array(
								'className'     => 'User',
								'conditions'    => '',
								'order'         => '',
								'fields'		=>array('is_private_profile','id'),
								'foreignKey'    => 'user_id'
							)
						);
	public function editFeedValidate(){
		$validate = array(
			'description' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a value for title',
				'allowEmpty' => false
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function addPostValidate(){
		$validate = array(
			'description' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a value for title',
				'allowEmpty' => false
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
	public function addImagePost(){
		$validate = array(
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
	
	public function uploadVideoValidate(){
		$validate = array(
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
	
	public function addVideoPost(){
		$validate = array(
			'video' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please Enter Your YouTube Embeded Url',
				'allowEmpty' => false
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
