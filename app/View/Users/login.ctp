<div class="register">
<div class="container">
<div class="row">
	<?php echo $this->Form->create($model, array('class'=>'form-horizontal RegisterIndexForm ajax_form','id'=>'User_Login_Form')); ?>
	<h3>Please Login your Account</h3>
	<div class="alert ajax_alert alert-danger display-hide">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
		<span class="ajax_message"></span>	
	</div>
		<div class="form-group">
			<?php echo $this->Form->label($model.'.email', __('Email',true),array('class'=>'col-sm-3 control-label')); ?>
			<div class="col-sm-9">
				<?php echo $this->Form->input($model.".email",array('class'=>'form-control validate[required]','label'=>false,'placeholder'=>'Enter Your Email','type'=>'email','required'=>'required','id'=>'User_Email_Address')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $this->Form->label($model.'.password', __('Password',true),array('class'=>'col-sm-3 control-label')); ?>
			<div class="col-sm-9">
				<?php echo $this->Form->input($model.".password",array('class'=>'form-control validate[required]','label'=>false,'placeholder'=>'Enter Your Password','type'=>'password','required'=>'required','id'=>'User_Password')); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
				<?php echo $this->Form->button(__d("users", "Sign in", true),array("class"=>"btn btn-default")); ?>
			</div>
		</div>
	<?php echo $this->Form->end();?>
</div>
</div>
</div>



