<?php  
class Article extends AppModel{
	public $useTable = 'pages';
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