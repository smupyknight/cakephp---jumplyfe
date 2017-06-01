<?php
class PagesController extends AppController{
	public $components = array('Paginator','Email','Session','RequestHandler');
	public $helpers = array('Html','Form','Session','Time','Text');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('index','contact_us'));
	}
	public function index($slug = null){
		$record = $this->{$this->modelClass}->find('first',array('conditions'=>array($this->modelClass.'.slug'=>$slug,$this->modelClass.'.status'=>1)));
		$this->set('record',$record);
	}
	
	
	
}


