<?php echo $this->element('top_slider');  ?>
<div class="about_us">
 <div class="container">
    <h3 class="title">Contact Us</h3>
	<?php echo $this->Form->create('Contact',array('class'=>'form-horizontal ajax_form','type'=>'file')); ?>
		<div class="alert ajax_alert alert-danger display-hide">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
			<span class="ajax_message"></span>	
		</div>
		<div class="form-group">
			<?php echo $this->Form->label('Contact.name', __('Name:*',true)); ?>
			<?php echo $this->Form->input("Contact.name",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter your name','required')); ?> 
		</div>
		<div class="form-group">
			<?php echo $this->Form->label('Contact.email', __('Email:*',true)); ?>
			<?php echo $this->Form->input("Contact.email",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter email address','required','type'=>'email')); ?> 
		</div>
		<div class="form-group">
			<?php echo $this->Form->label('Contact.subject', __('Subject:*',true)); ?>
			<?php echo $this->Form->input("Contact.subject",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter your subject here','required')); ?> 
		</div>
		<div class="form-group">
			<?php echo $this->Form->label('Contact.message', __('Message:*',true)); ?>
			<?php echo $this->Form->textarea("Contact.message",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter your message here','required')); ?> 
		</div>
		<div class="form-group">
			<?php echo $this->Form->button(__d("contacts", "Submit <i class='fa fa-arrow-circle-right'></i>", true),array("class"=>"btn btn-default pull-right")); ?>
		</div>
	<?php echo $this->Form->end(); ?>

 </div>

</div>
