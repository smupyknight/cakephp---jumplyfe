<?php 
	class UserEarningPoint extends AppModel{
		public $belongsTo = array(
						'User' => array(
								'className'     => 'User',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'user_id'
							),
						'Jump' => array(
								'className'     => 'Jump',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'earning_type_target_id'
							),
							
						'earning_type' => array(
								'className'     => 'EarningPointType',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'earning_type_id'
							)
						);

	}
?>
