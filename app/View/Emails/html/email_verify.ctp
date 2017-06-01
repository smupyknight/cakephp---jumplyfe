
<div>
	Hello <?php echo '{#name}' ; ?>
	<div><?php echo $this->Html->link("Click Here To verify Your Account",array("plugin"=>false,"controller"=>"registers","action"=>"verify",'full_base' => true,$verification_code),array("div"=>false,"escape"=>false));?></div>
</div>

 