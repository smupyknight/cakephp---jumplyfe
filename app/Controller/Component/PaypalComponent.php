<?php
App::import('Vendor','paypal' ,array('file'=>'paypal.class.php')); 
class PaypalComponent extends Object 
{
	
	var $controller;
	var $data = array();
	public function __construct($file = null, $watermark = null)
	{
		/* if ( !empty($file) )
			$this->setImage($file);

		if ( !empty($watermark) )
			$this->setWatermark($watermark); */
	}

	/**
	 * Contructor function for CakePHP
	 * @param Object &$controller pointer to calling controller
	 */
	public function initialize(&$controller, $options = array())
	{
		
	}
	
	public function beforeRedirect(&$controller, $options = array())
	{
	}
	public function startup(&$controller, $options = array())
	{
	}
	public function beforeRender(&$controller, $options = array())
	{
	}
	public function shutdown(&$controller, $options = array())
	{
	}
	function get_response($action = null){
		
		//require_once('paypal.class.php');
		
		$p = new paypal_class;
		if(Configure::read('Site.Paypalmode')=="test"){
			$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}else{
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
		}
		//$this_script = 'MYDOMAIN.COM/paypal.php';
		$this_script = Configure::read('App.Siteurl').'products/paypal_response/';
		switch ($action) {	  
		   		  
		   case 'ipn':
			  

			  $this->test_log();
				
			  if($p->validate_ipn()){
			  // Send email
					
					

				}			  
			  break;
		 } 
	}
	/* write test_log file added by S.R. */
	function test_log(){
		
		$myFile = "test_log.txt";
		$fh = fopen($myFile, 'a+') or die("can't open file");
		$stringData = "\r\n---------created date::".date('Y-m-d H:m:s')."------------\r\n";
		fwrite($fh, $stringData);
		
		fwrite($fh, $this->data);
		
		$stringData = "\r\n------------------------\r\n";
		fwrite($fh, $stringData);
		fclose($fh);	
	}
	
	function actionactivate($orderItemArr,$paypal_tmp_id){
	
	$customsettings = array(
			'cpp_header_image' => WEBSITE_IMG_URL."paypal_lady.png", 
			'page_style' =>"paypal", 
			'cbt'  => __("To complete your order Go Back to ".Configure::read('Site.title'))
		);
		$nvpArray = array_merge($customsettings);
		//$nvp = http_build_query($nvpArray);
		foreach($nvpArray as $param => $value) {
		$paramsJoined[] = "$param=$value";
		}
		$nvp = implode('&', $paramsJoined);
		//$nvp = '';
		$p = new paypal_class;
		if(Configure::read('Site.Paypalmode')=="test"){
			$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'.$nvp;
		}else{
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr/'.$nvp;
		}
		
		
		$this_script 	= Router::url(array('plugin'=>false,'controller'=>'users','action'=>'paypal_response'),true);
		$paypal_success = Router::url(array('plugin'=>false,'controller'=>'users','action'=>'paypal_response'),true);
		$paypal_cancle 	= Router::url(array('plugin'=>false,'controller'=>'users','action'=>'paypal_response'),true);
		
		$i = 1;
		
		// $p->add_field('cmd','_xclick');//type cart
		//$p->add_field('cmd','_cart');//type cart
		//$p->add_field('upload','1');// multiple orders
		
		$p->add_field('username','Lady Library Registration');//$_POST['paypalemail']
		$p->add_field('business',Configure::read('Site.Paypalemailid'));//$owner_paypal_email
		$p->add_field('return', $paypal_success);
		$p->add_field('cancel_return', $paypal_cancle);
		$p->add_field('notify_url', $this_script.'?action=ipn');
		$p->add_field('currency_code',PAYPAL_CURRENCY_CODE);
		$p->add_field('os0',PAYPAL_CURRENCY_CODE);
		
		$p->add_field('item_name', 'Registration');
		$p->add_field('amount', $orderItemArr['price']);
			
		$p->add_field('custom', $paypal_tmp_id);
		$p->submit_paypal_post();
		exit;
		 
	}
	
	function action($orderItemArr,$paypal_tmp_id){
/* 	pr($orderItemArr);
	echo $paypal_tmp_id;
	
	die;  */
	$customsettings = array(
			'cpp_header_image' => WEBSITE_IMG_URL."logo.png", 
			'page_style' =>"paypal", 
			'cbt'  => __("To complete your order Go Back to ".Configure::read('Site.title'))
		);
		$nvpArray = array_merge($customsettings);
		//$nvp = http_build_query($nvpArray);
		foreach($nvpArray as $param => $value) {
		$paramsJoined[] = "$param=$value";
		}
		$nvp = implode('&', $paramsJoined);
		//$nvp = '';
		$p = new paypal_class;
		if(Configure::read('Site.Paypalmode')=="test"){
			$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'.$nvp;
		}else{
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr/'.$nvp;
		}
		
		
		$this_script 	= Router::url(array('plugin'=>false,'controller'=>'users','action'=>'paypal_response'),true);
		$paypal_success = Router::url(array('plugin'=>false,'controller'=>'users','action'=>'paypal_response'),true);
		$paypal_cancle 	= Router::url(array('plugin'=>false,'controller'=>'users','action'=>'paypal_response'),true);
		
		$i = 1;
		
		// $p->add_field('cmd','_xclick');//type cart
		//$p->add_field('cmd','_cart');//type cart
		//$p->add_field('upload','1');// multiple orders
		
		$p->add_field('username','4Yourchild Success');//$_POST['paypalemail']
		$p->add_field('business',Configure::read('Site.Paypalemailid'));//$owner_paypal_email
		$p->add_field('return', $paypal_success);
		$p->add_field('cancel_return', $paypal_cancle);
		$p->add_field('notify_url', $this_script.'?action=ipn');
		$p->add_field('currency_code',PAYPAL_CURRENCY_CODE);
		$p->add_field('os0',PAYPAL_CURRENCY_CODE);
		
		$p->add_field('item_name', 'Buy Words CD');
		$p->add_field('amount', $orderItemArr['price']);
			
		$p->add_field('custom', $paypal_tmp_id);
		$p->submit_paypal_post();
		exit;
		 
	}
	
	
	
	
	function actionschedule($orderItemArr,$paypal_tmp_id){
	
	//pr($orderItemArr); die;
	
	$customsettings = array(
			'cpp_header_image' => WEBSITE_IMG_URL."paypal_lady.png", 
			'page_style' =>"paypal", 
			'cbt'  => __("To complete your order Go Back to ".Configure::read('Site.title'))
		);
		$nvpArray = array_merge($customsettings);
		//$nvp = http_build_query($nvpArray);
		foreach($nvpArray as $param => $value) {
		$paramsJoined[] = "$param=$value";
		}
		$nvp = implode('&', $paramsJoined);
		//$nvp = '';
		$p = new paypal_class;
		//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr/'.$nvp;
		
		if(Configure::read('Site.Paypalmode')=="test"){
			$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'.$nvp;
		}else{
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr/'.$nvp;
		}
		
		
		$this_script 	= Router::url(array('plugin'=>false,'controller'=>'finds','action'=>'paypal_response'),true);
		$paypal_success = Router::url(array('plugin'=>false,'controller'=>'finds','action'=>'paypal_response'),true);
		$paypal_cancle 	= Router::url(array('plugin'=>false,'controller'=>'finds','action'=>'paypal_response'),true);
		
		$i = 1;
		
		// $p->add_field('cmd','_xclick');//type cart
		//$p->add_field('cmd','_cart');//type cart
		//$p->add_field('upload','1');// multiple orders
		
		$p->add_field('username','Lady Library Schedule Appointment'); //$_POST['paypalemail']
		$p->add_field('business',$orderItemArr['User']['paypalemailid']); //$owner_paypal_email
		$p->add_field('return', $paypal_success);
		$p->add_field('cancel_return', $paypal_cancle);
		$p->add_field('notify_url', $this_script.'?action=ipn');
		$p->add_field('currency_code',PAYPAL_CURRENCY_CODE);
		$p->add_field('os0',PAYPAL_CURRENCY_CODE);
		
		$p->add_field('item_name', 'Schedule Appointment');
		$p->add_field('amount', ($orderItemArr['User']['initial_cunsult'] == 30) ? $orderItemArr['User']['initial_cunsult_30'] :$orderItemArr['User']['initial_cunsult_60']); //$orderItemArr['User']['price']
			
		$p->add_field('custom', $paypal_tmp_id);
		$p->submit_paypal_post();
		exit;
		 
	}
	
	
	
	
	
	function actionhighlight($orderItemArr,$paypal_tmp_id){
	$customsettings = array(
			'cpp_header_image' => WEBSITE_IMG_URL."logo.png", 
			'page_style' =>"paypal", 
			'cbt'  => __("To complete your order Go Back to ".Configure::read('Site.title'))
		);
		$nvpArray = array_merge($customsettings);
		//$nvp = http_build_query($nvpArray);
		foreach($nvpArray as $param => $value) {
		$paramsJoined[] = "$param=$value";
		}
		$nvp = implode('&', $paramsJoined);
		//$nvp = '';
		$p = new paypal_class;
		if(Configure::read('Paypal.Paypalmode')=="test"){
			$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr/'.$nvp;
		}else{
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr/'.$nvp;
		}
		
		$this_script 	= Router::url(array('plugin'=>'campaign','controller'=>'campaigns','action'=>'paypal_highlight_response'),true);
		$paypal_success = Router::url(array('plugin'=>'campaign','controller'=>'campaigns','action'=>'paypal_highlight_response'),true);
		$paypal_cancle 	= Router::url(array('plugin'=>'campaign','controller'=>'campaigns','action'=>'paypal_highlight_response'),true);
		
		$i = 1;
		
		// $p->add_field('cmd','_xclick');//type cart
		//$p->add_field('cmd','_cart');//type cart
		//$p->add_field('upload','1');// multiple orders
		
		$p->add_field('username',Configure::read('Paypal.username') );//$_POST['paypalemail']
		$p->add_field('business',Configure::read('Paypal.Paypalemailid'));//$owner_paypal_email
		$p->add_field('return', $paypal_success);
		$p->add_field('cancel_return', $paypal_cancle);
		$p->add_field('notify_url', $this_script.'?action=ipn');
		$p->add_field('currency_code',PAYPAL_CURRENCY_CODE);
		$p->add_field('os0',PAYPAL_CURRENCY_CODE);
		
		
			$p->add_field('item_name', $orderItemArr['campaign_name']);
			$p->add_field('amount', $orderItemArr['price']);
			
			$p->add_field('custom', $paypal_tmp_id);
			$p->submit_paypal_post();
		exit;
		 
	}
	
	function action1($orderItemArr,$paypal_tmp_id,$cmpntnt,$discnt=null){
		$customsettings = array(
			'cpp_header_image' => Configure::read('App.SiteUrl')."/img/logo.png", 
			'page_style' =>"paypal ", 
			'cbt'  => __("To complete your order Go Back to Luxby"),
		);
		$nvpArray = array_merge($customsettings);
		//$nvp = http_build_query($nvpArray);
		foreach($nvpArray as $param => $value) {
		$paramsJoined[] = "$param=$value";
		}
		$nvp = implode('&', $paramsJoined);
		
		
		$p = new paypal_class;
		if(Configure::read('Paypal.Paypalmode')=="test"){
			$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr/'.$nvp;
			
			}else{
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr/'.$nvp;
			}
		$this_script = Configure::read('App.SiteUrl').'/'.$cmpntnt.'/paypal_response';
		
		//echo  $this_script.'?action=ipn';die;
		$p->add_field('cmd','_cart' );//type cart
		
		
		$p->add_field('username','Luxby' );//$_POST['paypalemail']
		$p->add_field('business',Configure::read('PaypalId') );
		$p->add_field('return', $this_script.'?action=success');
		$p->add_field('cancel_return', $this_script.'?action=cancel');
		$p->add_field('notify_url', $this_script.'?action=ipn');
		$p->add_field('currency_code','SGD');
		$p->add_field('os0','SGD');
		//echo '<pre>'; print_r($p); die;
		$i = 1;
			$p->add_field('item_name_'.$i, $orderItemArr['title']);
			$p->add_field('item_number_'.$i, $orderItemArr['plan_id']);
			$p->add_field('amount_'.$i, $orderItemArr['price']);
			$p->add_field('quantity_'.$i,1);
			$i++;
			

		//$p->add_field('item_name', 'product 01');
		//$p->add_field('amount', 100);		
		

		//MY THREE VARIABLES FOR RECURING
		//$p->add_field('reattempt', '1');
		//$p->add_field('recur_times', '1');
		//$p->add_field('recurring', '1');
		$p->add_field('custom', $paypal_tmp_id);
		$p->add_field('upload','1' );//type cart
		if(isset($discnt) && $discnt > 0){
			$p->add_field('discount_amount_cart',$discnt);
		}
		
		$p->submit_paypal_post();
		 
	}
}
?>