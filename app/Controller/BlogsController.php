<?php
class BlogsController extends AppController{
	public $helper = array('Form','Html'); 
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('index','view','get_recent_blog','get_popular_post'));
	}
	
	public function index(){
		$this->Paginator->settings = array(
			'conditions'=>array($this->modelClass.'.status'=>1),
			'order' => $this->modelClass.'.created DESC',
			'limit' => 3,
			'paramType' =>'querystring'
		);
		$record = $this->{$this->modelClass}->find('all',array('conditions'=>array($this->modelClass.'.status'=>1)));
		$this->set('record',$this->Paginator->paginate());	
	}
	
	public function view($slug = null){
		$record = $this->{$this->modelClass}->findByslug($slug);
		$this->checkRecordIsNull($record);
		$id = $record[$this->modelClass]['id'];
		if($record){
			$this->{$this->modelClass}->updateAll(
				array('Blog.view_counter' => 'Blog.view_counter + 1'),
				array('Blog.id' => $id)
			);
		}
		$this->set('record',$record);
		$older_record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.id <'=>$id),'order'=>$this->modelClass.'.id DESC'));
		$new_record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.id >'=>$id),'order'=>$this->modelClass.'.id ASC'));
		$this->set('older_record',$older_record);
		$this->set('new_record',$new_record);
		
	}
	
	public function get_recent_blog(){
		$recent_record = $this->{$this->modelClass}->find('all',array('conditions'=>array($this->modelClass.'.status'=>1),'fields'=>array('title','created','slug'),'order' =>$this->modelClass.'.created DESC','limit'=>3));
		return $recent_record;	
	}
	
	public function get_popular_post(){
		$record = $this->{$this->modelClass}->find('all',array('conditions'=>array($this->modelClass.'.status'=>1),'fields'=>array('title','created','slug'),'order' =>$this->modelClass.'.view_counter DESC','limit'=>6));
		return $record;	
	}
		
}
?>