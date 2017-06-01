<?php 
class GroupsController extends AppController{
	public $helper = array('');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow('');
	}

	public function index(){
		$session_user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$session_user_id);
		$this->loadModel('TotalGroup');
		$this->loadModel('TotalGroupMember');
		$this->TotalGroupMember->virtualFields = array(
			'members' => 'SELECT COUNT(*) FROM total_group_members WHERE group_id = TotalGroupMember.group_id'
		);
		$groups = $this->TotalGroupMember->find('all',array('conditions'=>array('TotalGroupMember.user_id'=>$session_user_id,'TotalGroupMember.status'=>1),'order'=>'TotalGroupMember.created DESC'));
		/*foreach($groups as $key => $value) {
			$groups[$key]['TotalGroupMember']['members'] = $this->TotalGroupMember->find('count',array('conditions'=>array('TotalGroupMember.group_id'=>$value['TotalGroupMember']['group_id'],'TotalGroupMember.status'=>1)));
		}*/
		$this->set('groups',$groups);
		$this->set('left_menu_selected','Groups');
	}
	public function create_group(){
		if($this->request->isAjax()){
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if($this->{$this->modelClass}->createGroup()){
				if(!empty($this->request->data[$this->modelClass]['image']['name'])){
					$file = $this->data[$this->modelClass]['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_GROUP_IMAGE_PATH. time().$file['name']);
						$this->request->data[$this->modelClass]['image'] = time().$file['name'];
					}
				}
				$this->loadModel('TotalGroup');
				$data = array();
				$data['group_name'] = $this->request->data[$this->modelClass]['group_name'];
				$data['user_id'] 	= $this->Auth->user('id');
				$data['image'] 		= $this->request->data[$this->modelClass]['image'];
				$data['slug']		= $this->createSlug($this->request->data[$this->modelClass]['group_name'],'TotalGroup');
				$this->TotalGroup->create();
				$savedData = $this->TotalGroup->save($data,false);
				if($savedData){
					$this->loadModel('TotalGroupMember');
					$G_Member_Record  = array();
					$G_Member_Record['TotalGroupMember']['group_id'] = $savedData['TotalGroup']['id'];
					$G_Member_Record['TotalGroupMember']['user_id']	 = $this->Auth->user('id');
					$G_Member_Record['TotalGroupMember']['is_administrator'] = 'Yes';
					$this->TotalGroupMember->create();
					$this->TotalGroupMember->save($G_Member_Record,false);
					$success = true;
					$message = false;
					$dataResponse['selfReload'] = true;
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}

			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	public function edit_group_information($slug = null){
		if($this->request->isAjax() || $this->request->is('put')){
			$this->loadModel('TotalGroup');
			$record  = $this->TotalGroup->find('first',array('conditions'=>array('TotalGroup.slug'=>$slug,'TotalGroup.status'=>1)));
			$this->checkRecordIsNull($record);
			$this->{$this->modelClass}->set($this->request->data[$this->modelClass]);
			if($this->{$this->modelClass}->createGroup()){
				if(isset($this->request->data[$this->modelClass]['image']['name']) && !empty($this->request->data[$this->modelClass]['image']['name'])){
					$file = $this->data[$this->modelClass]['image'];
					$ext = substr(strtolower(strrchr($file['name'],'.')),1);
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
					if(in_array($ext, $arr_ext))
					{                            
						move_uploaded_file($file['tmp_name'],ALBUM_UPLOAD_GROUP_IMAGE_PATH. time().$file['name']);
						$this->request->data[$this->modelClass]['image'] = time().$file['name'];
					}
				}
				else
				{
					$this->request->data[$this->modelClass]['image'] = $record['TotalGroup']['image'];
				}
				$data = array();
				$data['group_name'] = $this->request->data[$this->modelClass]['group_name'];
				$data['user_id'] 	= $this->Auth->user('id');
				$data['image'] 		= $this->request->data[$this->modelClass]['image'];
				$this->TotalGroup->id = $record['TotalGroup']['id'];
				if($this->TotalGroup->save($data,false)){
					$success = true;
					$message = false;
					$dataResponse['selfReload'] = true;
				}
			}
			else
			{
				$success = false;
				$message = $this->formatErrors($this->{$this->modelClass}->validationErrors);
			}

			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	
	public function detail($slug = null){
		$session_user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$session_user_id);
		$this->loadModel('TotalGroup');
		$record = $this->TotalGroup->find('first',array('conditions'=>array('TotalGroup.slug'=>$slug,'TotalGroup.status'=>1)));
		$this->checkRecordIsNull($record);
		$this->set('group_slug',$slug);
	}
	
	public function about_group($slug = null){
		$this->loadModel('TotalGroup');
		$this->loadModel('TotalGroupMember');
		$session_user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$session_user_id);
		$groupRecord = $this->TotalGroup->find('first',array('conditions'=>array('TotalGroup.slug'=>$slug,'TotalGroup.status'=>1)));
		$this->checkRecordIsNull($groupRecord);
		$groupRecord['TotalGroup']['members'] = $this->TotalGroupMember->find('count',array('conditions'=>array('TotalGroupMember.group_id'=>$groupRecord['TotalGroup']['id'],'TotalGroupMember.status'=>1)));
		$is_GroupMember = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=>$groupRecord['TotalGroup']['id'],'TotalGroupMember.user_id'=>$this->Auth->user('id'),'TotalGroupMember.status'=>1)));
		if($is_GroupMember)
		{
			$this->set('groups',$groupRecord);
			$this->set('is_GroupMemberAdmin',$is_GroupMember['TotalGroupMember']['is_administrator']);
		}
		else
		{
			$this->redirect(array('plugin'=>false,'controller'=>'groups','action'=>'index'));
		}
		$this->set('left_menu_selected','Groups');
	}
	
	public function members($slug = null){
		$this->loadModel('TotalGroup');
		$this->loadModel('TotalGroupMember');
		$session_user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$session_user_id);
		$groupRecord = $this->TotalGroup->find('first',array('conditions'=>array('TotalGroup.slug'=>$slug,'TotalGroup.status'=>1)));
			if($groupRecord){
			$this->checkRecordIsNull($groupRecord);
			$this->set('group_slug',$groupRecord['TotalGroup']['slug']);
			$this->set('group_id',$groupRecord['TotalGroup']['id']);
			
			$is_GroupMember = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=>$groupRecord['TotalGroup']['id'],'TotalGroupMember.user_id'=>$this->Auth->user('id'),'TotalGroupMember.status'=>1)));
			
			if($is_GroupMember){
				//pr($is_GroupMember); die;
				$this->set('Admin',$is_GroupMember['TotalGroupMember']['is_administrator']);
				
				$this->TotalGroupMember->virtualFields = array(
					'city' => 'SELECT city_name FROM cities WHERE id = User.city_code',
					'country' => 'SELECT country_name FROM countries WHERE iso_code = User.country_code'
				);
				
				$memberGroup = $this->TotalGroupMember->find('all',array('conditions'=>array('TotalGroupMember.group_id'=>$groupRecord['TotalGroup']['id'],'TotalGroupMember.status'=>1),'order'=>'TotalGroupMember.created DESC'));
				$this->set('memberGroup',$memberGroup);
			} 
			else 
			{
				$this->redirect(array('plugin'=>false,'controller'=>'groups','action'=>'index'));
			}
			$this->set('left_menu_selected','Groups');
		}
		else 
		{
			$this->redirect(array('plugin'=>false,'controller'=>'groups','action'=>'index'));
		}
	}
	
	public function getMembersAuto($query){
		
		
		$this->loadModel('User');
		$users = $this->User->find('all',array('conditions'=>array('User.firstname LIKE' => '%'.$query.'%','User.status'=>1),'fields'=>array('User.firstname','User.lastname','User.id')));
		if(!empty($users))
		{
			$data = array();
			foreach($users as $key => $value){
				$data[$key]['id'] 	= $value['User']['id'];
				$data[$key]['name'] = $value['User']['firstname'].' '.$value['User']['lastname'];
				$data[$key]['value'] = $value['User']['firstname'].' '.$value['User']['lastname'];	
			}
		}
		else
		{
			$data[1]['id'] = '';
			$data[1]['name'] = '';
			$data[1]['value'] = '';
		}
		echo json_encode($data);
		die;
	}
	
	public function make_admin(){
		$group_member_id = $this->request->data['group_member_id'];
		$group_id  = $this->request->data['group_id'];
		$this->loadModel('TotalGroupMember');
		$this->loadModel('TotalGroup');
		$memberGroup_Record = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.id'=>$group_member_id,'TotalGroupMember.status'=>1)));
		if($memberGroup_Record)
		{
			if($this->request->data['status'] == 'add')
			{
				$this->TotalGroupMember->id = $group_member_id;
				$this->TotalGroupMember->saveField('is_administrator','Yes');
				$data['success'] = true;
			}
			else
			{
				if($memberGroup_Record['TotalGroupMember']['user_id'] == $this->Auth->user('id')){
					$memberGroup_Count = $this->TotalGroupMember->find('count',array('conditions'=>array('TotalGroupMember.group_id'=> $group_id,'TotalGroupMember.status'=>1)));
					
					if($memberGroup_Count > 1){
						$is_administrator = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=> $group_id,'TotalGroupMember.is_administrator'=>'Yes','TotalGroupMember.user_id !='=>$this->Auth->user('id'),'TotalGroupMember.status'=>1)));
						if(!empty($is_administrator)){
							$this->TotalGroupMember->id = $group_member_id;
							$this->TotalGroupMember->saveField('is_administrator','No');
							$data['success'] = true;
						}
						else
						{
							$newAdmin = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=> $group_id,'TotalGroupMember.user_id !='=>$this->Auth->user('id'),'TotalGroupMember.status'=>1)));
							$this->TotalGroupMember->id = $newAdmin['TotalGroupMember']['id'];
							$this->TotalGroupMember->saveField('is_administrator','Yes');
							
							$this->TotalGroupMember->id = $group_member_id;
							$this->TotalGroupMember->saveField('is_administrator','No');
							$data['success'] = true;
						}
						
					}
					else
					{
						$conditions = array('TotalGroupMember.group_id'=>$group_id);
						$this->TotalGroupMember->deleteAll($conditions);
						$this->TotalGroup->delete($group_id);
						$data['success'] = true;
					}
				}
				else
				{
					$this->TotalGroupMember->id = $group_member_id;
					$this->TotalGroupMember->saveField('is_administrator','No');
					$data['success'] = true;
					
				}
			}
		}
		else
		{
			$data['success'] = false;
		}
		
		echo json_encode($data); die; 
	}
	
	public function remove_member(){
		$group_member_id = $this->request->data['group_member_id'];
		$group_id  = $this->request->data['group_id'];
		$this->loadModel('TotalGroupMember');
		$this->loadModel('TotalGroup');
		$memberGroup_Record = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.id'=> $group_member_id,'TotalGroupMember.status'=>1)));
		if($memberGroup_Record['TotalGroupMember']['is_administrator'] == 'No'){
			$this->TotalGroupMember->delete($group_member_id);
			$data['success'] = true;
		}
		else
		{
			$memberGroup_Count = $this->TotalGroupMember->find('count',array('conditions'=>array('TotalGroupMember.group_id'=> $group_id,'TotalGroupMember.status'=>1)));
			if($memberGroup_Count > 1)
			{
				$is_administrator = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=> $group_id,'TotalGroupMember.is_administrator'=>'Yes','TotalGroupMember.user_id !='=>$this->Auth->user('id'),'TotalGroupMember.status'=>1)));
				if(!empty($is_administrator)){
					$this->TotalGroupMember->delete($group_member_id);
					$data['success'] = true;
				}
				else
				{
					$this->TotalGroupMember->delete($group_member_id);
					$newAdmin = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=>$group_id,'TotalGroupMember.status'=>1)));
					$this->TotalGroupMember->id = $newAdmin['TotalGroupMember']['id'];
					$this->TotalGroupMember->saveField('is_administrator','Yes');
					$data['success'] = true;
				}	
			}
			else
			{
				$conditions = array('TotalGroupMember.group_id'=>$group_id);
				$this->TotalGroupMember->deleteAll($conditions);
				$this->loadModel('UserFeed');
				$user_feed = $this->UserFeed->find('all',array('conditions'=>array('UserFeed.group_id'=>$group_id),'fields'=>array('UserFeed.id','UserFeed.feed_media','UserFeed.video_type','UserFeed.image','UserFeed.video')));
				if(!empty($user_feed)){
					foreach($user_feed as $key => $value){
						if($value['UserFeed']['feed_media'] == 'Image'){
							$file = new File(ALBUM_UPLOAD_FEED_IMAGE_PATH . $value['UserFeed']['image'], false, 0777);
							$file->delete();
						}
						else if($value['UserFeed']['feed_media'] == 'Video' && $value['UserFeed']['video_type'] == 'Upload'){
							$file = new File(ALBUM_UPLOAD_FEED_IMAGE_PATH . $value['UserFeed']['video'], false, 0777);
							$file->delete();
						}
					}
				}
				$user_feed_conditions = array('UserFeed.group_id'=>$group_id);
				$this->UserFeed->deleteAll($user_feed_conditions);
				$this->TotalGroupMember->deleteAll($conditions);
				$this->TotalGroup->delete($group_id);
				$data['success'] = true;
			}
		}
		echo json_encode($data); die; 
	}
	
	function group_timeline($slug = null){
		$this->loadModel('TotalGroup');
		$this->loadModel('TotalGroupMember');
		$session_user_id = $this->Auth->user('id');
		$this->set('left_part_user_id',$session_user_id);
		$groupRecord = $this->TotalGroup->find('first',array('conditions'=>array('TotalGroup.slug'=>$slug,'TotalGroup.status'=>1)));
		$this->checkRecordIsNull($groupRecord);
		$is_GroupMember = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.group_id'=>$groupRecord['TotalGroup']['id'],'TotalGroupMember.user_id'=>$this->Auth->user('id'),'TotalGroupMember.status'=>1)));
		
		if($is_GroupMember)
		{
			$this->set('group_slug',$groupRecord);
		}
		else
		{
			$this->redirect(array('plugin'=>false,'controller'=>'groups','action'=>'index'));
		}
		$this->set('left_menu_selected','Groups');
	}
	
	public function deleteGroupPost(){
		$this->loadModel('UserFeed');
		$this->loadModel('UserFeedLike');
		$this->loadModel('UserFeedComment');
		$this->loadModel('TotalGroupMember');
		
		$UserFeed_data = $this->UserFeed->find('first',array('conditions'=>array('UserFeed.id'=>$this->request->data['id'],'UserFeed.status'=>1)));
		$this->checkRecordIsNull($UserFeed_data);
		$GroupMemberRecord = $this->TotalGroupMember->find('first',array('conditions'=>array('TotalGroupMember.user_id'=>$this->Auth->user('id'),'TotalGroupMember.is_administrator'=>'Yes','TotalGroupMember.group_id'=>$UserFeed_data['UserFeed']['group_id'])));
		if($UserFeed_data['UserFeed']['user_id'] == $this->Auth->user('id')){
		
			$this->UserFeedLike->deleteAll(array('UserFeedLike.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
			$this->UserFeedComment->deleteAll(array('UserFeedComment.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
			$this->UserFeed->delete($UserFeed_data['UserFeed']['id']);
			$data['success'] = true;
			
		}
		else if(!empty($GroupMemberRecord)){
		
			$this->UserFeedLike->deleteAll(array('UserFeedLike.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
			$this->UserFeedComment->deleteAll(array('UserFeedComment.user_feed_id'=>$UserFeed_data['UserFeed']['id']), false);
			$this->UserFeed->delete($UserFeed_data['UserFeed']['id']);
			$data['success'] = true;
			
		}
		else
		{
			$data['success'] = false;
		}
		
		echo json_encode($data); die; 
	}
	
	function add_member(){
		if($this->request->isAjax()){
			$record = $this->request->data['User'];
			$group_id = $record['group_id'];
			$this->loadModel('TotalGroupMember');
			if(isset($record['user_id']) && !empty($record['user_id'])){
				foreach($record['user_id'] as $key => $value){
					$is_already_member  = $this->TotalGroupMember->find('first',array('conditions'=>array('AND'=>array('TotalGroupMember.group_id'=>$group_id,'TotalGroupMember.user_id'=>$value))));	
					if(isset($is_already_member) && !empty($is_already_member))
					{
						
						
					}
					else
					{
						$data = array();
						$data['TotalGroupMember']['group_id'] 	= $group_id; 
						$data['TotalGroupMember']['user_id'] 	= $value; 
						$this->TotalGroupMember->create();
						$this->TotalGroupMember->save($data,false);
					}
					
				}
				$success = true;
				$dataResponse['selfReload'] = true;
				$message  = false;
			}
			else
			{
				$success = false;
				$message = 'Please select atleast one user for a group member.';
				
			}
	
			$dataResponse['success'] = $success;
			$dataResponse['scrollToThisForm'] = false;
			$dataResponse['message'] = $message;
			echo json_encode($dataResponse); die;
		}
	}
	
	function formatErrors($errorsArray)
	{
		$errors = '';
		foreach ($errorsArray as $key => $validationError)
		{
		  $errors.= '<p>'.$validationError[0].'</p>';
		}
		return $errors;
	}
	
}
