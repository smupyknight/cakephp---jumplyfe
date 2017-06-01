<?php if($record) { ?>
<div class="register">
<div class="container">
<div class="row">
	<?php echo $this->Form->create($model, array('class'=>'form-horizontal RegisterIndexForm ajax_form')); ?>
	<h3>Reset Your Password</h3>
	<div class="alert ajax_alert alert-danger display-hide">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
		<span class="ajax_message"></span>	
	</div>
	<div class="form-group">
		<?php echo $this->Form->label($model.'.password', __('Password: *',true),array('class'=>'col-sm-4 control-label')); ?>
		<div class="col-sm-8">
			<?php echo $this->Form->input($model.".password",array('class'=>'form-control validate[required]','label'=>false,'placeholder'=>'Enter Your Password','type'=>'password','required')); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $this->Form->label($model.'.confirm_password', __('Confirm Password: *',true),array('class'=>'col-sm-4 control-label')); ?>
		<div class="col-sm-8">
			<?php echo $this->Form->input($model.".confirm_password",array('class'=>'form-control validate[required]','label'=>false,'placeholder'=>'Re-Enter Your Password','type'=>'password','required')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<?php echo $this->Form->button(__d("users", "Sign in", true),array("class"=>"btn btn-default")); ?>
		</div>
	</div>
	<?php echo $this->Form->end();?>
</div>
</div>
</div>
<?php } else { ?>
<div class="show_message">
	<h3>Sorry! This Is a invalid Link. Please Try Again</h3>
</div>
<?php } ?>
