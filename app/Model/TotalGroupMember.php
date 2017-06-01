<?php
class TotalGroupMember extends AppModel{
	public $name  = 'TotalGroupMember';
	public $useTable = 'total_group_members';
	public $belongsTo = array('TotalGroup' => array(
								'className'     => 'TotalGroup',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'group_id'
							),
							'User' => array(
								'className'     => 'User',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'user_id',
								'fields'		=> array('firstname','lastname','image','city_code','country_code')
							)
						);
}