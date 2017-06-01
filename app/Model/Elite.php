<?php
class Elite extends AppModel{
	public $useTable = false;
	public $validate = array(
		'check_in' => array(
			'rule1' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please fill a value for check in.'
			)
		)
	);
}

?>