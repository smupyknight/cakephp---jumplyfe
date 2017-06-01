<?php
class ChatGroupMember extends AppModel{
	public $name = 'ChatGroupMember';
	public $useTable = 'chat_group_members';
	public $belongsTo = array(
						'User' => array(
								'className'     => 'User',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'user_id'
							),
						'ChatGroup' => array(
								'className'     => 'ChatGroup',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'chat_group_id'
							)
						);
}