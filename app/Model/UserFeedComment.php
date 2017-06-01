<?php  
class UserFeedComment extends AppModel{
	public $useTable = 'user_feed_comments';
	public $belongsTo = array(
						'User' => array(
								'className'     => 'User',
								'conditions'    => array('User.status' => 1),
								'order'         => '',
								'foreignKey'    => 'user_id'
							)
						);

}
?>