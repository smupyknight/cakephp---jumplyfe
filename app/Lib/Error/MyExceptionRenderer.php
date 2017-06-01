<?php
 App::uses('ExceptionRenderer', 'Error');

 class MyExceptionRenderer extends ExceptionRenderer 
 {
     protected function _outputMessage($template) {
		$this->controller->layout = '404error';
		parent::_outputMessage($template);
  }
 }
?>