<?php  
class Page extends AppModel{
	public $validate = array(
		'email' => array(
			'required' => array(
				'rule' => array('email', true),   
				'message' => 'Please provide a valid email address.'   
			)
		)
	);
}
?>