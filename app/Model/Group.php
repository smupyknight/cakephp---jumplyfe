<?php 
class Group extends AppModel{
	public $useTable = false;
	
	public function createGroup(){
		$validate = array(
			'group_name' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter a value for Group Name.',
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
