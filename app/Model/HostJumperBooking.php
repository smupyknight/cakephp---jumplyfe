<?php
class HostJumperBooking extends AppModel {
	public $belongsTo = array(
						'Buyer' => array(
							'className'     => 'User',
							'conditions'    => array('Buyer.status' => 1),
							'order'         => '',
							'foreignKey'    => 'buyer_id'
						),
						'Jump' => array(
							'className'     => 'Jump',
							'conditions'    => array('Jump.status' => 1),
							'order'         => '',
							'foreignKey'    => 'jump_id'
						)
					);
}