<?php
class JumpHostGallery extends AppModel{
	public $name = 'JumpHostGallery';
	public $useTable = 'jump_host_galleries';
	
	public function primaryJumpImage($id = null){
		$primary_image = $this->find('first',array('conditions'=>array('JumpHostGallery.jump_host_id'=>$id),'order' => 'JumpHostGallery.is_default ASC'));	
		return $primary_image;
	}
}
?>