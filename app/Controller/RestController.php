<?php 
class RestController extends AppController{
	public $helper = array('Form','Html');
	public function beforeFilter() 
	{
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array(''));
		App::import('Vendor', 'Factual/Factual');
		$this->factual = new Factual("Jp3ks0VnYZTCEZmj4bkyO5GImFnXZ05rJCelU7lj","lKRCH0zQymMNfvyeDbaQOPle7MH0Y2wcWzUBvy06");
	}
	public function index(){
		$query = new FactualQuery;
		$query->limit(3);
		$query->field("name")->beginsWith("restaurant");
		//$query->at(new FactualPoint(26.9000, -75.8000));
		$res = $this->factual->fetch("places", $query);
		pr($res->getData()); die;
	}
}	