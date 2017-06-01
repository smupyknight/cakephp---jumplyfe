<?php
class ChatMessageToUser extends AppModel{
	public $name = 'ChatMessageToUser';
	public $useTable = 'chat_message_to_users';
	public $belongsTo = array('ChatMessage',
						'Sender' => array(
								'className'     => 'User',
								'conditions'    => '',
								'order'         => '',
								'foreignKey'    => 'sender_id'
							)
						);
}