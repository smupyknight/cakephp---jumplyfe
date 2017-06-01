<?php
class ChatMessage extends AppModel{
	public $name = 'ChatMessageToUser';
	public $useTable = 'chat_messages';
	public $belongsTo = array('ChatGroupMembers');
}