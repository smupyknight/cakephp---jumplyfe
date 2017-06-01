<?php
session_start();
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::uses('File', 'Utility');
class AppController extends Controller {
	public $helpers = array(
							'Html',
							'Form',
							'Session',
							'Time',
							'Text');

	public $components = array(
					'Auth',
					'Session',
					'Cookie',
					'Paginator',
					'Email',
					'Search.Prg'
				);

	public function beforeFilter() {
		$this->city_id = 0;
		$scope = array('User.status' => 1,'User.is_email_verified'=>1,'User.user_role_id'=>2);
		$loginAction = array('plugin'=>false,'controller' => 'users', 'action' => 'login');
		$loginRedirect	=array('plugin'=>false,'controller' => 'users', 'action' => 'settings');
		$logoutRedirect	='/';
		$this->Auth->authenticate = array('Form' => array('fields' => array('username' => 'email','password' => 'password'),'scope' => $scope));
		$this->Auth->authError = 'Did you really think you are allowed to see that?';
		$this->Auth->loginRedirect 		= 	$loginRedirect;
		$this->Auth->logoutRedirect 	= 	$logoutRedirect;
		$this->Auth->loginAction 		= 	$loginAction;
		$this->Auth->allow(array('login','showLimitedText'));
		if(!$this->Session->read('Currency.default'))
		{
			$this->Session->write('Currency.default', 'USD');
			$this->Session->write('Currency.icon', NULL);
		}
	}
	
	function showLimitedText($string,$len=100) 
	{
		$string = strip_tags($string);
		if (strlen($string) > $len)
			$string = substr($string, 0, $len-3) . "...";
		return $string;
	}
	
	function checkRecordIsNull($record, $forcely_show_404 =false)
	{
		if($forcely_show_404)
			throw new NotFoundException();
		else if(!$record)
			throw new NotFoundException();
		else
			return true;
	}
	
	function createSlug ($string, $table=null) {
		$this->loadModel($table);
		//pr($string); pr($table); die;
		$slug = Inflector::slug ($string,'-');
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params ['conditions']= array();
		$params ['conditions'][$table.'.slug']= $slug;
		
		while (count($this->$table->find('all',$params))) {
			if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
				$slug .= '-' . ++$i;
			} else {
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			}
			$params ['conditions'][$table.'.slug']= $slug;
		}
		//echo $slug; die;
		return $slug;
	}

	function calculate_refundCharges($paid_amount = null , $type = null){
		
		$charges = Configure::read("Site.refund_charges");
		
		return $charges;
	
	}
	
	function like_counter($id = null){
		$this->loadModel('UserFeedLike');
		$total_likes = $this->UserFeedLike->find('count',array('conditions'=>array('user_feed_id'=>$id,'status'=>1)));
		return $total_likes;
	}
	
	function comment_counter($id = null){
		$this->loadModel('UserFeedComment');
		$total_comments = $this->UserFeedComment->find('count',array('conditions'=>array('UserFeedComment.user_feed_id'=>$id,'UserFeedComment.status'=>1)));
		return $total_comments;
	} 
	
	function share_counter($id = null){
		$this->loadModel('UserFeedShare');
		$total_share = $this->UserFeedShare->find('count',array('conditions'=>array('user_feed_id'=>$id,'status'=>1)));
		return $total_share;
	}
	
	function findFriends($user_id = null){
		$this->loadModel('Friend');
		$this->loadModel('User');
		$friend_list = $this->Friend->find('all',array('conditions'=>array('OR'=>array('Friend.user_id_1'=>$user_id,'Friend.user_id_2'=>$user_id),'Friend.status'=>1),'order'=>'Friend.created DESC'));
		$friends = array();
		if($friend_list){
			foreach($friend_list as $key => $value){
				if($value['Friend']['user_id_1'] != $user_id)
				{
					$friend_id = $value['Friend']['user_id_1'];
				}
				else
				{
					$friend_id = $value['Friend']['user_id_2'];
				}
				$friend_list_record = $this->User->find('first',array('conditions'=>array('User.id'=>$friend_id)));
				$friends[$key] =  $friend_list_record;
			}
		}
		/* if($addSelf){
			$friends[] = $user_id;
		} */
		//pr($friends); die;
		return $friends;
	}	
	
	function convertCurrencyUSDToLocal($amount =NULL,$array =false)
	{
		return $amount;
		if($amount == 0){
			return '0' ;
		}
		if($amount)
		{
			$this->loadModel('Currency');
			$rateRow = $this->Currency->find('first',array('conditions' => array('Currency.currency_code' => $this->Session->read('Currency.default'))));
			$amount_local = $rateRow['Currency']['exchange_rate_usd'] * $amount;
			
		}
		if($array)
		{
			$return[0] = $amount_local;
			$return[1] = $this->Session->read('Currency.default');
			$return[2] = '$';
		}
		else
		{
			$return = $amount_local;
			
		}
		return $return;
	}
	
	function translate($text, $from = '', $to = 'en') {
        //$url = 'http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q='.rawurlencode($text).'&langpair='.rawurlencode($from.'|'.$to); 

		$url = 'http://api.microsofttranslator.com/V2/Ajax.svc/Translate?oncomplete=MicrosoftTranslateComplete&appId=EF45DE6734F756B2F1DEF91B9DFCE3FD0B03748B&text='.urlencode($text).'&from='.urlencode($from).'&to='.urlencode($to).''; 
		
		$response     =     file_get_contents($url);
		
		$result        =  	str_replace('");','',substr($response,31,strlen($response)));
		
		return $result;
    }
    
    
    function autoMessage($new_user_id = null,$new_user_name = null){
		if(!empty($new_user_id)){	
			$this->loadModel('User');
			$auto_msg_user = $this->User->find('first',array('conditions'=>array('User.is_auto_user'=>'Yes','User.status'=>1)));
			if(!empty($auto_msg_user))
			{
				$this->loadModel('ChatGroup');
				$chatGroup = array();
				$chatGroup['ChatGroup']['group_title'] 		= ucfirst($auto_msg_user['User']['firstname']);
				$chatGroup['ChatGroup']['admin_user_id'] 	= $auto_msg_user['User']['id'];
				$chatGroup['ChatGroup']['single_user_id'] 	= $new_user_id;
				$this->ChatGroup->create();
				$chatGroup_saveData = $this->ChatGroup->save($chatGroup,false);
				
				$this->loadModel('ChatGroupMember');
				$chatGroupMember_1 = array();
				$chatGroupMember_1['ChatGroupMember']['chat_group_id'] 		= $chatGroup_saveData['ChatGroup']['id'];
				$chatGroupMember_1['ChatGroupMember']['user_id'] 			= $auto_msg_user['User']['id'];
				$chatGroupMember_1['ChatGroupMember']['lastest_message_time'] = time();
				$this->ChatGroupMember->create();
				$chatGroupMember1_saveData = $this->ChatGroupMember->save($chatGroupMember_1,false);
				
				$chatGroupMember_2 = array();
				$chatGroupMember_2['ChatGroupMember']['chat_group_id'] 		= $chatGroup_saveData['ChatGroup']['id'];
				$chatGroupMember_2['ChatGroupMember']['user_id'] 			= $new_user_id;
				$chatGroupMember_2['ChatGroupMember']['lastest_message_time'] = time();
				$this->ChatGroupMember->create();
				$chatGroupMember2_saveData = $this->ChatGroupMember->save($chatGroupMember_2,false);
				
				$this->loadModel('ChatMessage');
				$chatMessage = array();
				$chatMessage['ChatMessage']['chat_group_id'] 		= $chatGroup_saveData['ChatGroup']['id'];
				$chatMessage['ChatMessage']['sender_id']	 		= $auto_msg_user['User']['id'];
				$chatMessage['ChatMessage']['receiver_ids'] 		= $new_user_id;
				$chatMessage['ChatMessage']['message'] 				= "Welcome to the wonderful world of Jumplyfe.com.";
				$this->ChatMessage->create();
				$chatMessage_saveData = $this->ChatMessage->save($chatMessage,false);
				
				$this->loadModel('ChatMessageToUser');
				$chatMessageToUser_1 = array();
				$chatMessageToUser_1['ChatMessageToUser']['chat_group_id'] 	= $chatGroup_saveData['ChatGroup']['id'];
				$chatMessageToUser_1['ChatMessageToUser']['chat_message_id'] = $chatMessage_saveData['ChatMessage']['id'];
				$chatMessageToUser_1['ChatMessageToUser']['sender_id'] 		= $auto_msg_user['User']['id'];
				$chatMessageToUser_1['ChatMessageToUser']['receiver_id'] 	= $new_user_id;
				$chatMessageToUser_1['ChatMessageToUser']['message'] 		= $chatMessage_saveData['ChatMessage']['message'];
				$chatMessageToUser_1['ChatMessageToUser']['read_status'] 	= 'Unread';
				$this->ChatMessageToUser->create();
				$chatMessageToUser1_saveData = $this->ChatMessageToUser->save($chatMessageToUser_1,false);
				
				$chatMessageToUser_2 = array();
				$chatMessageToUser_2['ChatMessageToUser']['chat_group_id'] 	= $chatGroup_saveData['ChatGroup']['id'];
				$chatMessageToUser_2['ChatMessageToUser']['chat_message_id'] = $chatMessage_saveData['ChatMessage']['id'];
				$chatMessageToUser_2['ChatMessageToUser']['sender_id'] 		= $auto_msg_user['User']['id'];
				$chatMessageToUser_2['ChatMessageToUser']['receiver_id'] 	= $auto_msg_user['User']['id'];
				$chatMessageToUser_2['ChatMessageToUser']['message'] 		= $chatMessage_saveData['ChatMessage']['message'];
				$chatMessageToUser_2['ChatMessageToUser']['read_status'] 	= 'Unread';
				$this->ChatMessageToUser->create();
				$chatMessageToUser2_saveData = $this->ChatMessageToUser->save($chatMessageToUser_2,false);
			}
		}
	}
}
