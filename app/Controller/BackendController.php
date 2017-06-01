<?php
App::uses('AppController', 'Controller');
class BackendController extends AppController{
	public $helper = array('Form','Html');
	public $components = array('Hybridauth');

	public function beforeFilter() {
		$this->loadModel('User');
		$this->loadModel('UserFeed');
		$this->loadModel('UserFeedComment');
		$this->loadModel('ChatGroupMember');
		$this->loadModel('ChatMessageToUser');
		$this->loadModel('Jump');
		$this->loadModel('JumpMate');
		parent::beforeFilter();
		$this->Auth->allow(array('login', 'signup', 'newsfeed', 'timeline', 'comments', 'profile', 'search_result', 'upload_photo', 'chatlist', 'jumplist', 'chatscreen', 'edit_profile', 
			'login_facebook', 'login_twitter', 'login_instagram', 'new_jump', 'getJumpDetail', 'forgot_password', 'reset_password', 'get_chat_message', 'add_message'));
		$this->autoRender = false;
	}
	public function login(){

		if ($this->request->is('get'))
		{
			$login_info = $this->User->find('all',array('conditions'=>array('User.email'=>$_GET['email'])));
			if (count($login_info) == 0) {
				echo json_encode(array('code' => 201, 'messages' => array('You are not registered user'), 'data' => array('Errors' => array('Invalid username or password'))));
				return;
			}
			if( $this->User->mobile_checkpassword($_GET['password'], $login_info[0]['User']['password'])){
				$user_id = $login_info[0]['User']['id'];
				$name = $login_info[0]['User']['firstname'] . ' ' . $login_info[0]['User']['lastname'];
				$photo = $login_info[0]['User']['image'];
				$location = $login_info[0]['User']['address'];
				echo json_encode(array('code' => 200, 'messages' => array('Successfully logged in'), 'data' => array('user_id' => $user_id, 'name' => $name, 'photo' => $photo, 'location' => $location)));
			} else {
				echo json_encode(array('code' => 201, 'messages' => array('Invalid password'), 'data' => array('Errors' => array('Invalid username or password'))));
			}
		}
	}

	public function login_facebook()
	{
		if ($this->request->is('get'))
		{
			$login_info = $this->User->find('all',array('conditions'=>array('User.email'=>$_GET['email'])));
			if (count($login_info) == 0)
			{
				$login_info = $this->User->create();
				$name = $_GET['name'];
				$login_info['User']['firstname'] = split(' ', $name)[0];
				$login_info['User']['lastname'] = '';
				if (count(split(' ', $name)) == 2)
					$login_info['User']['lastname'] = split(' ', $name)[1];
				$login_info['User']['email'] = $_GET['email'];

				$this->User->save($login_info['User']);
				echo json_encode(array('code' => 200, 'messages' => array('Successfully logged in'), 'data' => array('user_id' => $login_info['User']['user_id'], 'name' => $name, 'photo' => $photo, 'location' => $location)));
			}
			else
			{
				$user_id = $login_info[0]['User']['id'];
				$name = $login_info[0]['User']['firstname'] . ' ' . $login_info[0]['User']['lastname'];
				$photo = $login_info[0]['User']['image'];
				$location = $login_info[0]['User']['address'];
				echo json_encode(array('code' => 200, 'messages' => array('Successfully logged in'), 'data' => array('user_id' => $user_id, 'name' => $name, 'photo' => $photo, 'location' => $location)));
			}
		}
	}

	public function login_twitter()
	{

	}

	public function login_instagram() 
	{

	}

	public function signup() {
		if ($this->request->is('get'))
		{
			$login_info = $this->User->find('all', array('conditions'=>array('User.email'=>$_GET['email'])));
			if (count($login_info) != 0) {
				echo json_encode(array('code' => 201, 'messages' => array('You are already registered'), 'data' => array('Errors' => array('You are already registered'))));
				return;
			}

			$data = array('email' => $_GET['email'], 'password' => AuthComponent::password($_GET['password']));
			$this->User->save($data);
			echo json_encode(array('code' => 200, 'messages' => array('Successfully Registered'), 'data' => array('Success' => 'Successfully Registered')));
		}
	}

	public function newsfeed() {

		if ($this->request->is('get')) {
			$user_feed = $this->UserFeed->find('all');

			$data = array();
			foreach ($user_feed as $key => $value) {
				$user_info = $this->User->find('first', array('conditions' => array('User.id' => $value['UserFeed']['id'])));

				$user_name = $user_info['User']['firstname'] . ' ' . $user_info['User']['lastname'];
				$user_photo = $user_info['User']['image'];
				$created_date = $value['UserFeed']['created'];
				$comment_count = $this->comment_counter($value['UserFeed']['id']);
				$feed_media = $value['UserFeed']['feed_media'];
				$video = $value['UserFeed']['video'];
				$image = $value['UserFeed']['image'];

				array_push($data, array('user_name' => $user_name, 'photo_url' => $user_photo, 'created_date' => $created_date, 'comment_count' => $comment_count, 
					'feed_media' => $feed_media, 'background_video' => $video, 'background_image' => $image));
			}
			if (count($data) == 0)
			{
				array_push($data, array('Errors' => array('No newsfeed data')));
			}

			echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('timeline' => $data)));
		}
	}

	public function timeline() {

		if ($this->request->is('get')) {
			$user_feed = $this->UserFeed->find('all', array('conditions' => array('UserFeed.user_id' => $_GET['user_id'])));

			$data = array();
			foreach ($user_feed as $key => $value) {
				$user_info = $this->User->find('first', array('conditions' => array('User.id' => $value['UserFeed']['id'])));

				$feed_id = $value['UserFeed']['id'];
				$user_name = $user_info['User']['firstname'] . ' ' . $user_info['User']['lastname'];
				$user_photo = $user_info['User']['image'];
				$created_date = $value['UserFeed']['created'];
				$comment_count = $this->comment_counter($value['UserFeed']['id']);
				$feed_media = $value['UserFeed']['feed_media'];
				$video = $value['UserFeed']['video'];
				$image = $value['UserFeed']['image'];
				$feed_type_id = $value['UserFeed']['feed_type_id'];

				array_push($data, array('user_name' => $user_name, 'photo_url' => $user_photo, 'created_date' => $created_date, 'comment_count' => $comment_count, 
					'feed_media' => $feed_media, 'background_video' => $video, 'background_image' => $image, 'feed_type_id' => $feed_type_id));
			}
			if (count($data) == 0)
			{
				array_push($data, array('Errors' => array('No newsfeed data')));
			}

			echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('timeline' => $data)));
		}
	}

	public function comments() {
		if ($this->request->is('get')) {
			$comments = $this->UserFeedComment->find('all', array('conditions' => array('UserFeedComment.user_feed_id' => $_GET['feed_id'])));

			$comment_data = array();
			foreach ($comments as $key => $value) {
				$feed_user_info = $this->User->find('first', array('conditions' => array('User.id' => $value['UserFeedComment']['user_id'])));
				$name = $feed_user_info['User']['firstname'] . ' ' . $feed_user_info['User']['lastname'];
				$photo = $feed_user_info['User']['image'];
				$comment = $value['UserFeedComment']['comment'];
				$hours = $value['UserFeedComment']['created'];
				array_push($comment_data, array('name' => $name, 'photo' => $photo, 'text' => $comment, 'hours' => $hours));
			}

			if (count($comment_data) == 0)
				echo json_encode(array('code' => 201, 'messages' => array('Successfully Retrieved'), 'data' => array('Errors' => array('No comments'))));
			else
				echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('comments' => $comment_data)));
		}
	}

	public function profile() {
		if ($this->request->is('get')) {

			$user_info = $this->User->find('first', array('conditions' => array('User.id' => $_GET['user_id'])));

			$name = $user_info['User']['firstname'] . ' ' . $user_info['User']['lastname'];
			$photo = $user_info['User']['image'];
			$location = $user_info['User']['address'];

			echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('name' => $name, 'photo' => $photo, 'location' => $location)));
		}
	}

	public function edit_profile() {
		if ($this->request->is('get')) {

			$user_info = $this->User->find('first', array('conditions' => array('User.id' => $_GET['user_id'])));
			$name = $_GET['name'];
			$names = split(' ', $name);

			$user_info['User']['firstname'] = $names[0];
			if (count($names) == 2)
			{
				$user_info['User']['lastname'] = $names[1];
			}

			$user_info['User']['image'] = $_GET['photo'] . '.JPG';
			$user_info['User']['address'] = $_GET['location'];

			$this->User->save($user_info);

			echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('name' => $name, 'photo' => $_GET['photo'], 'location' => $_GET['location'])));
		}
	}

	public function chatlist()
	{
		if ($this->request->is('get')) {
			$chat_groups = $this->ChatGroupMember->find('all', array('conditions' => array('ChatGroupMember.user_id' => $_GET['user_id'])));

			$chat_list = array();
			foreach ($chat_groups as $key => $value)
			{
				$chat_group_number = $value['ChatGroupMember']['chat_group_id'];

				$chat_group = $this->ChatGroupMember->find('all', array('conditions' => array('ChatGroupMember.chat_group_id' => $chat_group_number)));

				foreach ($chat_group as $key => $value) {
					$chat_group_member = $this->User->find('first', array('conditions' => array('User.id' => $value['ChatGroupMember']['user_id'])));

					if ($value['ChatGroupMember']['user_id'] != $_GET['user_id'])
					{
						$user_id = $chat_group_member['User']['id'];
						$image = $chat_group_member['User']['image'];
						$name = $chat_group_member['User']['firstname'] . ' ' . $chat_group_member['User']['lastname'];
						$chat_member = array('user_id' => $user_id, 'image' => $image, 'name' => $name);

						array_push($chat_list, $chat_member);
					}
				}
			}
			if (count($chat_list) == 0)
				echo json_encode(array('code' => 201, 'messages' => array('Successfully Retrieved'), 'data' => array('Errors' => array('No chatdata'))));
			else
				echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('chat_list' => $chat_list)));
		}
	}

	public function jumplist()
	{
		if ($this->request->is('get')) {
			$jumps = $this->Jump->find('all');

			$jump_list = array();
			foreach($jumps as $key => $value)
			{
				array_push($jump_list, array('id' => $value['Jump']['id'], 'photo' => $value['Jump']['image'], 'name' => $value['Jump']['title']));
			}

			if (count($jump_list) == 0)
				echo json_encode(array('code' => 201, 'messages' => array('Successfully Retrieved'), 'data' => array('Errors' => array('No JumpData'))));
			else
				echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('jump_list' => $jump_list)));
		}
	}

	public function chatscreen() {
		if ($this->request->is('get')) {
			$chat_messages = $this->ChatMessageToUser->find('all', 
			 	array('conditions' => array( 
			 		'OR' => array(
			 			array('ChatMessageToUser.sender_id' => $_GET['user_id'], 'ChatMessageToUser.receiver_id' => $_GET['opponent_id']),
			 			array('ChatMessageToUser.sender_id' => $_GET['opponent_id'], 'ChatMessageToUser.receiver_id' => $_GET['user_id'])
			 			))));
			
			$chatContents = array();
			foreach ($chat_messages as $key => $value) {
				$chatContent = array();
				if ($value['ChatMessageToUser']['sender_id'] == $_GET['user_id'])
				{
					$chatContent['user_type'] = 1;
					$user_data = $this->User->find('first', array('conditions' => array('User.id' => $_GET['user_id'])));
				}
				else
				{
					$chatContent['user_type'] = 2;
					$user_data = $this->User->find('first', array('conditions' => array('User.id' => $value['ChatMessageToUser']['sender_id'])));
				}

				$chatContent['photo_url'] = $user_data['User']['image'];
				$chatContent['text'] = $value['ChatMessageToUser']['message'];
				$chatContent['date'] = $value['ChatMessageToUser']['created'];
				
				array_push($chatContents, $chatContent);
			}

			if (count($chatContents) == 0)
				echo json_encode(array('code' => 201, 'messages' => array('Successfully Retrieved'), 'data' => array('Errors' => array('No chatdata'))));
			else
				echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('chatContents' => $chatContents)));
		}
	}

	public function search_result() {

	}

	public function add_jumpmate() {
		if ($this->request->is('get')) {

		}
	}

	public function new_jump() {
		if ($this->request->is('get')) {
			$user_id = $_GET['user_id'];
			$data 						=	array();
			$data['user_id']			=	$_GET['user_id'];
			$data['image']				=	$_GET['image'];
			$data['title']				=	$_GET['title'];
			$data['description']		=	$_GET['description'];
			$this->Jump->create();
			$jumpSave_record = $this->Jump->save($data, false);

			if($jumpSave_record){
				$this->loadModel('UserFeed');
				$userFeed_data = array();
				$userFeed_data['user_id'] 				= $data['user_id'];
				$userFeed_data['feed_type_id'] 			= 1;
				$userFeed_data['feed_type_target_id'] 	= $jumpSave_record['Jump']['id'];
				$this->UserFeed->create();
				$this->UserFeed->save($userFeed_data,false);
				$success =  true;
				$message = 'Your jump has been added successfully';
			}
			else
			{
				$errors = $this->{$this->modelClass}->validationErrors;
				$success =  false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}
			echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('Errors' => array('Successfully added'))));
		}
	}

	public function getJumpDetail()
	{
		if ($this->request->is('get')) {
			$jump_detail = $this->Jump->find('first', array('conditions' => array('Jump.id' => $_GET['jump_id'])));

			$jump_name = $jump_detail['Jump']['title'];
			$jumpMate_photos = array();

			$jump_mates = $this->JumpMate->find('all', array('conditions' => array('JumpMate.jump_id' => $_GET['jump_id'])));

			foreach ($jump_mates as $key => $value) {
				$user_detail = $this->User->find('first', array('conditions' => array('User.id' => $value['JumpMate']['user_id'])));
				array_push($jumpMate_photos, array('photo' => $user_detail['User']['image']));
			}

			echo json_encode(array('code' => 201, 'messages' => array('Successfully Retrieved'), 'data' => array('name' => $jump_name, 'jump_mates' => $jumpMate_photos)));
		}
	}

	public function forgot_password()
	{
		$Email = new CakeEmail();
		$Email->template('forgot_password')
		    ->emailFormat('html')
		    ->to('manfredclaus502@outlook.com')
		    ->from('dmytromalieiev@outlook.com')
		    ->send();

		echo json_encode(array('code' => 201, 'messages' => array('Successfully Retrieved'), 'data' => array('Errors' => array('Please check your email inbox'))));
	}

	public function reset_password()
	{
		$user = $this->User->find('first',array('conditions'=>array('User.email'=>$_GET['email'])));
		$user['User']['password'] = AuthComponent::password($_GET['password']);
		$this->User->save($user);
		echo "Success";
	}

	public function get_chat_message()
	{
		$chat_messages = $this->ChatMessageToUser->find('all', 
			 	array('conditions' => array( 'ChatMessageToUser.receiver_id' => $_GET['user_id'],'ChatMessageToUser.sender_id' => $_GET['opponent_id'], 'ChatMessageToUser.server_read_status' => 0)));

		$chatContents = array();

		foreach ($chat_messages as $key => $value) {
			$chatContent = array();
			$chatContent['user_type'] = 2;
			
			$user_data = $this->User->find('first', array('conditions' => array('User.id' => $value['ChatMessageToUser']['sender_id'])));
			$chatContent['photo_url'] = $user_data['User']['image'];
			$chatContent['text'] = $value['ChatMessageToUser']['message'];
			$chatContent['date'] = $value['ChatMessageToUser']['created'];

			array_push($chatContents, $chatContent);

			$value['ChatMessageToUser']['server_read_status'] = 1;
			$this->ChatMessageToUser->save($value);
		}

		if (count($chatContents) == 0)
			echo json_encode(array('code' => 201, 'messages' => array('Successfully Retrieved'), 'data' => array('Errors' => ('No chatdata'))));
		else
			echo json_encode(array('code' => 200, 'messages' => array('Successfully Retrieved'), 'data' => array('chatContents' => $chatContents)));

	}

	public function add_message()
	{
		$message = array('sender_id' => $_GET['user_id'], 'receiver_id' => $_GET['opponent_id'], 'message' => $_GET['message'], 'server_read_status' => 0);
		$this->ChatMessageToUser->save($message);
		echo "Success";
	}
}
?>
