<?php
class MessagesController extends AppController{
	public $helper = array('Form','Html','Text');
	public $components = array('Hybridauth');	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array(''));
	}
	public function index($slug =NULL){
		$this->set('chat_group_id',false);
		if($slug)
		{
			$this->loadModel('User');
			$this->loadModel('ChatGroup');
			$this->loadModel('ChatGroupMember');
			$user  = $this->User->findBySlug($slug);
			if($user['User'])
			{
				$user_id_2 = $user['User']['id'];
				$user_id = $this->Auth->user('id');

				$chatGroupData = $this->ChatGroup->find('first',
				array(
					'conditions'=>array(
						"OR"=>array(
							array(
								'ChatGroup.admin_user_id'=>$user_id_2,
								'ChatGroup.single_user_id'=>$user_id
							),
							array(
								'ChatGroup.admin_user_id'=>$user_id,
								'ChatGroup.single_user_id'=>$user_id_2
							)
						)
					)
				));
				if($chatGroupData)
				{
					$chat_group_id = $chatGroupData['ChatGroup']['id'];
				}
				else
				{
					$this->ChatGroup->create();
					$ChatGroup_record = array();
					$ChatGroup_record['ChatGroup']['group_title'] = $user['User']['firstname'];
					$ChatGroup_record['ChatGroup']['admin_user_id'] = $this->Auth->user('id');
					$ChatGroup_record['ChatGroup']['single_user_id'] = $user_id_2;
					$ChatGroup_record['ChatGroup']['status'] = 1;
					$ChatGroup_saveData = $this->ChatGroup->save($ChatGroup_record,false);

					$chat_group_id = $ChatGroup_saveData['ChatGroup']['id'];

					$this->ChatGroupMember->create();
					$ChatGroupMember_record1 = array();
					$ChatGroupMember_record1['ChatGroupMember']['chat_group_id'] = $ChatGroup_saveData['ChatGroup']['id'];
					$ChatGroupMember_record1['ChatGroupMember']['user_id'] 	  	= $this->Auth->user('id'); 
					$ChatGroupMember_record1['ChatGroupMember']['status'] 	  	= 1;
					$ChatGroupMember_record1['ChatGroupMember']['lastest_message_time'] 	  	= time();
					$this->ChatGroupMember->save($ChatGroupMember_record1,false);

					$this->ChatGroupMember->create();
					$ChatGroupMember_record1 = array();
					$ChatGroupMember_record1['ChatGroupMember']['chat_group_id'] = $ChatGroup_saveData['ChatGroup']['id'];
					$ChatGroupMember_record1['ChatGroupMember']['user_id'] 	  	= $user_id_2; 
					$ChatGroupMember_record1['ChatGroupMember']['status'] 	  	= 1;
					//$ChatGroupMember_record1['ChatGroupMember']['lastest_message_time'] 	  	= time();
					$this->ChatGroupMember->save($ChatGroupMember_record1,false);
				}
				$this->set('chat_group_id',$chat_group_id);

			}
			
		}
		$user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$user_id);
		$this->set('left_menu_selected','Message');
		App::uses('String', 'Utility');
	}
	public function newPost()
	{
		$user_id = $this->Auth->user('id');
		$postData = $this->data{'ChatMessages'};
		$message = trim(strip_tags($postData['message']));
		$chat_group_id = trim($postData['chat_group_id']);
		if($chat_group_id && $message)
		{
			$this->loadModel('ChatGroupMember');
			$this->loadModel('ChatMessage');
			$this->loadModel('ChatMessageToUser');
			
			$users = $this->ChatGroupMember->find('all',array('conditions'=> array('ChatGroupMember.chat_group_id' => $chat_group_id,'ChatGroupMember.status' =>1)));
			$user_ids = array();
			//pr($users); die;
			foreach($users as $key => $value)
			{
				$user_ids[] = $value['ChatGroupMember']['user_id']; 
				$this->ChatGroupMember->id = $value['ChatGroupMember']['id']; 
				$this->ChatGroupMember->saveField('lastest_message_time',time());
			}
			$saveCMData['ChatMessage']['chat_group_id'] = $chat_group_id;
			$saveCMData['ChatMessage']['sender_id'] = $user_id;
			$saveCMData['ChatMessage']['receiver_ids'] = implode(',',$user_ids);
			$saveCMData['ChatMessage']['message'] = $message;
			$returnData = $this->ChatMessage->save($saveCMData,false);
			$chat_message_id = $returnData['ChatMessage']['id'];
			foreach($users as $key => $value)
			{
				$this->ChatMessageToUser->create;
				$saveData[$key]['ChatMessageToUser']['sender_id'] = $user_id;
				$saveData[$key]['ChatMessageToUser']['chat_group_id'] = $chat_group_id;
				$saveData[$key]['ChatMessageToUser']['chat_message_id'] = $chat_message_id;
				$saveData[$key]['ChatMessageToUser']['receiver_id'] = $value['ChatGroupMember']['user_id'];
				$saveData[$key]['ChatMessageToUser']['message'] = $message;
				
			}
			$this->ChatMessageToUser->saveAll($saveData);
			$data['success'] = true;
			$data['callBackFunction'] = 'actionAfterChatResponse';
		}
		else
		{
			$data['success'] = false;
			$data['callBackFunction'] = 'actionAfterChatResponse';
			$data['message'] = 'Tags are not allowed in message';
		}
		echo json_encode($data); die;
	}
	function loadChatSessions()
	{
		
		$this->loadModel('ChatGroupMember');
		$this->loadModel('ChatMessage');
		$this->loadModel('ChatMessageToUser');
		$this->loadModel('User');
		App::uses('CakeTime', 'Utility');
		$user_id = $this->Auth->user('id');
		
		$latestSessions = $this->ChatGroupMember->find('all',array('conditions'=> array('ChatGroupMember.user_id' => $user_id),'order' => 'ChatGroupMember.lastest_message_time DESC','group' => 'ChatGroupMember.chat_group_id'));
		//die('nsdj');
		//echo $user_id; die;
		//pr($latestSessions); die;
		$chatsessions = array();
		
		foreach($latestSessions as $key => $value)
		{
			$lastUser = array();
			//$lastUser = $this->ChatMessageToUser->find('first',array('conditions' => array('ChatMessageToUser.sender_id !=' => $user_id,'ChatMessageToUser.chat_group_id' => $value['ChatGroup']['id']),'order' => 'ChatMessageToUser.id DESC'));
			$lastUser = $this->ChatMessageToUser->find('first',array('conditions' => array('ChatMessageToUser.chat_group_id' => $value['ChatGroup']['id']),'order' => 'ChatMessageToUser.id DESC'));
			$lastMessage = $lastUser;
			//pr($lastUser); die;
			
			$chatsessions[$key]['title'] = $value['ChatGroup']['group_title'];
			$chatsessions[$key]['chat_group_id'] = $value['ChatGroup']['id'];
			$chatsessions[$key]['message_time_ago'] = ' -- ';
			$chatsessions[$key]['message'] = ' no message ';
			if($lastMessage['ChatMessageToUser'])
			{
				
				if($lastUser['ChatMessageToUser']['receiver_id'] == $user_id)
				{
					$chatsessions[$key]['is_owner'] = 'Yes';
				}
				else
				{
					$chatsessions[$key]['is_owner'] = 'No';
				}
				$chatsessions[$key]['message'] = $this->showLimitedText($lastMessage['ChatMessageToUser']['message'],20);
				
				$chatsessions[$key]['latest_message_id'] = $lastMessage['ChatMessageToUser']['id'];
				$chatsessions[$key]['sender_id'] = $lastMessage['ChatMessageToUser']['sender_id'];
				$chatsessions[$key]['sender_name'] = $lastMessage['Sender']['firstname'];
				$chatsessions[$key]['receiver_id'] = $lastMessage['ChatMessageToUser']['receiver_id'];
				$chatsessions[$key]['read_status'] = $lastMessage['ChatMessageToUser']['read_status'];
				$chatsessions[$key]['message_time'] = $lastMessage['ChatMessageToUser']['modified'];
				
				$chatsessions[$key]['message_time_ago'] = CakeTime::timeAgoInWords($chatsessions[$key]['message_time']);
				$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
				$file_name		=	$lastUser['Sender']['image'];
				$base_encode 	=	base64_encode($file_path);
				if($file_name && file_exists($file_path . $file_name)) 
				{
					$chatsessions[$key]['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/470/348/'. $base_encode.'/'.$file_name;
				}	
				else
				{
					$chatsessions[$key]['image_url'] = '';
				}
			}
			
		}
		$latestChat = $this->ChatMessageToUser->find('first',array('conditions'=> array('ChatMessageToUser.receiver_id' => $user_id),'order' => 'ChatMessageToUser.id DESC'));
		$data['last_message_to_user_id'] = $latestChat['ChatMessageToUser']['id'];
		$data['success'] = true;
		$data['chatsessions'] = $chatsessions;
		echo json_encode($data); die;
	}
	function loadChatSessionsOld()
	{
		$this->loadModel('ChatGroupMember');
		$this->loadModel('ChatMessage');
		$this->loadModel('ChatMessageToUser');
		$this->loadModel('User');
		App::uses('CakeTime', 'Utility');
		$user_id = $this->Auth->user('id');
		$latestSessions = $this->ChatMessageToUser->find('all',array('conditions'=> array('ChatMessageToUser.receiver_id' => $user_id),'order' => 'ChatMessageToUser.id DESC','group' => 'ChatMessageToUser.chat_group_id'));
		//echo $user_id; die;
		$chatsessions = array();
		foreach($latestSessions as $key => $value)
		{
			$lastUser = $this->ChatMessageToUser->find('first',array('conditions' => array('ChatMessageToUser.sender_id !=' => $user_id,'ChatMessageToUser.chat_group_id' => $value['ChatMessageToUser']['chat_group_id']),'order' => 'ChatMessageToUser.id DESC'));
			
			$lastUserData = $this->User->findById($lastUser['ChatMessageToUser']['sender_id']);
			//pr($lastUser); die;
			if($value['ChatMessageToUser']['receiver_id'] == $user_id)
			{
				$chatsessions[$key]['is_owner'] = 'Yes';
			}
			else
			{
				$chatsessions[$key]['is_owner'] = 'No';
			}
			$chatsessions[$key]['message'] = $this->showLimitedText($value['ChatMessageToUser']['message'],20);
			$chatsessions[$key]['chat_group_id'] = $value['ChatMessageToUser']['chat_group_id'];
			$chatsessions[$key]['latest_message_id'] = $value['ChatMessageToUser']['id'];
			$chatsessions[$key]['sender_id'] = $value['ChatMessageToUser']['sender_id'];
			$chatsessions[$key]['sender_name'] = $lastUserData['User']['firstname'];
			$chatsessions[$key]['receiver_id'] = $value['ChatMessageToUser']['receiver_id'];
			$chatsessions[$key]['read_status'] = $value['ChatMessageToUser']['read_status'];
			$chatsessions[$key]['message_time'] = $lastUser['ChatMessageToUser']['modified'];
			
			$chatsessions[$key]['message_time_ago'] = CakeTime::timeAgoInWords($chatsessions[$key]['message_time']);
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$lastUserData['User']['image'];
			$base_encode 	=	base64_encode($file_path);
			if($file_name && file_exists($file_path . $file_name)) 
			{
				$chatsessions[$key]['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/470/348/'. $base_encode.'/'.$file_name;
			}	
			else
			{
				$chatsessions[$key]['image_url'] = '';
			}
		}
		$latestChat = $this->ChatMessageToUser->find('first',array('conditions'=> array('ChatMessageToUser.receiver_id' => $user_id),'order' => 'ChatMessageToUser.id DESC'));
		$data['last_message_to_user_id'] = $latestChat['ChatMessageToUser']['id'];
		$data['success'] = true;
		$data['chatsessions'] = $chatsessions;
		echo json_encode($data); die;
	}
	function getLastChatByGroupId()
	{
		App::uses('CakeTime', 'Utility');
		$user_id = $this->Auth->user('id');
		$this->loadModel('ChatMessageToUser');
		$chat_group_id  = $this->request->query['open_chat_group_id'];
		$latestMeassages = $this->ChatMessageToUser->find('all',array('conditions'=> array('ChatMessageToUser.chat_group_id' => $chat_group_id,'ChatMessageToUser.receiver_id' => $user_id),'order' => 'ChatMessageToUser.id ASC'));
		$messages = array();
		//pr($latestMeassages); die;
		foreach($latestMeassages as $key => $value)
		{
			if($value['ChatMessageToUser']['sender_id'] == $user_id)
			{
				$messages[$key]['is_owner'] = 'Yes';
			}
			else
			{
				$messages[$key]['is_owner'] = 'No';
			}
			$messages[$key]['message'] = $value['ChatMessageToUser']['message'];
			$messages[$key]['chat_group_id'] = $value['ChatMessageToUser']['chat_group_id'];
			$messages[$key]['latest_message_id'] = $value['ChatMessageToUser']['id'];
			$messages[$key]['sender_id'] = $value['ChatMessageToUser']['sender_id'];
			$messages[$key]['sender_name'] = $value['Sender']['firstname'];
			$messages[$key]['receiver_id'] = $value['ChatMessageToUser']['receiver_id'];
			$messages[$key]['read_status'] = $value['ChatMessageToUser']['read_status'];
			$messages[$key]['message_time'] = $value['ChatMessageToUser']['modified'];
			$messages[$key]['message_id'] = $value['ChatMessageToUser']['id'];
			
			$messages[$key]['message_time_ago'] = CakeTime::timeAgoInWords($messages[$key]['message_time']);
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['Sender']['image'];
			$base_encode 	=	base64_encode($file_path);
			if($file_name && file_exists($file_path . $file_name)) 
			{
				$messages[$key]['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/470/348/'. $base_encode.'/'.$file_name;
			}	
			else
			{
				$messages[$key]['image_url'] = '';
			}
		}
		$data['success'] = true;
		$data['messages'] = $messages;
		echo json_encode($data); die;
	}
	function fetchNewChat()
	{
		$latest_message_id  = $this->request->query['latest_message_id'];
		App::uses('CakeTime', 'Utility');
		$user_id = $this->Auth->user('id');
		$this->loadModel('ChatMessageToUser');
		
		$latestMeassages = $this->ChatMessageToUser->find('all',array('conditions'=> array('ChatMessageToUser.receiver_id' => $user_id,'ChatMessageToUser.id >' => $latest_message_id),'order' => 'ChatMessageToUser.id ASC'));
		$messages = array();
		foreach($latestMeassages as $key => $value)
		{
			if($value['ChatMessageToUser']['sender_id'] == $user_id)
			{
				$messages[$key]['is_owner'] = 'Yes';
			}
			else
			{
				$messages[$key]['is_owner'] = 'No';
			}
			$messages[$key]['message'] = $value['ChatMessageToUser']['message'];
			$messages[$key]['chat_group_id'] = $value['ChatMessageToUser']['chat_group_id'];
			$messages[$key]['id'] = $value['ChatMessageToUser']['id'];
			$messages[$key]['message_id'] = $value['ChatMessageToUser']['chat_message_id'];
			$messages[$key]['sender_id'] = $value['ChatMessageToUser']['sender_id'];
			$messages[$key]['sender_name'] = $value['Sender']['firstname'];
			$messages[$key]['receiver_id'] = $value['ChatMessageToUser']['receiver_id'];
			$messages[$key]['read_status'] = $value['ChatMessageToUser']['read_status'];
			$messages[$key]['message_time'] = $value['ChatMessageToUser']['modified'];
			if($messages[$key]['message_time'] > date("Y-m-d H:i:s",strtotime('-4 Seconds',time())))
			{
				$messages[$key]['notify_message'] = true;
			}
			$messages[$key]['message_time_ago'] = CakeTime::timeAgoInWords($messages[$key]['message_time']);
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['Sender']['image'];
			$base_encode 	=	base64_encode($file_path);
			if($file_name && file_exists($file_path . $file_name)) 
			{
				$messages[$key]['image_url']	=	WEBSITE_URL.'imageresize/imageresize/get_image/470/348/'. $base_encode.'/'.$file_name;
			}	
			else
			{
				$messages[$key]['image_url'] = '';
			}
		}
		$data['success'] = true;
		$data['messages'] = $messages;
		echo json_encode($data); die;
		//pr($messages); die;
	}
	
	function createNewChat()
	{
		$this->loadModel('ChatGroup');
		$this->loadModel('ChatGroupMember');
		$users = isset($this->data['users'])?$this->data['users']:NULL;
		$group_title = trim($this->data{'group_title'});
		if($group_title && sizeof($users)>0)
		{
			$this->ChatGroup->create();
			$ChatGroup_record = array();
			$ChatGroup_record['ChatGroup']['group_title'] = $group_title;
			$ChatGroup_record['ChatGroup']['admin_user_id'] = $this->Auth->user('id');
			$ChatGroup_record['ChatGroup']['status'] = 1;
			$ChatGroup_saveData = $this->ChatGroup->save($ChatGroup_record,false);
			if($ChatGroup_saveData){
			
				foreach($users as $key =>$value){
					$this->ChatGroupMember->create();
					$ChatGroupMember_record = array();
					$ChatGroupMember_record['ChatGroupMember']['chat_group_id'] = $ChatGroup_saveData['ChatGroup']['id'];
					$ChatGroupMember_record['ChatGroupMember']['user_id'] 	  	= $value; 
					$ChatGroupMember_record['ChatGroupMember']['status'] 	  	= 1;
					$ChatGroupMember_record['ChatGroupMember']['lastest_message_time'] 	  	= time();
					$this->ChatGroupMember->save($ChatGroupMember_record,false);
				}
				
				$this->ChatGroupMember->create();
				$ChatGroupMember_record1 = array();
				$ChatGroupMember_record1['ChatGroupMember']['chat_group_id'] = $ChatGroup_saveData['ChatGroup']['id'];
				$ChatGroupMember_record1['ChatGroupMember']['user_id'] 	  	= $this->Auth->user('id'); 
				$ChatGroupMember_record1['ChatGroupMember']['status'] 	  	= 1;
				$ChatGroupMember_record1['ChatGroupMember']['lastest_message_time'] 	  	= time();
				$this->ChatGroupMember->save($ChatGroupMember_record1,false);
			}
			$data['success'] = true;
			$data['callBackFunction'] = 'callBackActionAfterGroupCreated';
		}
		else
		{
			$data['message'] = 'Please correct the errors: Set Title and select one friend atleast';
			$data['success'] = false;
		}
		echo json_encode($data); die;
	}
	
	
	
	public function translateLanguage(){
		$message_id = $this->request->data['message_id'];
		$this->loadModel('ChatMessageToUser');
		$this->loadModel('User');
		$message_record = $this->ChatMessageToUser->find('first',array('conditions'=>array('ChatMessageToUser.id'=>$message_id)));
		if(!empty($message_record)){
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$message_record['ChatMessageToUser']['receiver_id']),'fields'=>array('User.language_code')));
			if(!empty($user)){
				$message = $message_record['ChatMessageToUser']['message'];           
				$language_type  =  $user['User']['language_code'];
				$translated_Language = $this->translate($message,'',$language_type);
				$data['success'] = true;
				$data['translated_Language'] = $translated_Language;
			}
			else
			{
				$data['success'] = false;
			}
		}
		else
		{
			$data['success'] = false;
		}
		echo $data['translated_Language']; die;
	}
	
	
}
