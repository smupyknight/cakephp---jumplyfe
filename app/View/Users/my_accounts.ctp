
<div class="searchpage">
 <?php echo $this->element('menu'); 
 
 ?>
</div> 

<div class="container">
	<h2>Account Settings</h2>
	<hr>
	<h3>Basic Information :</h3>
		<?php echo $this->Form->create($model,array('id'=>'myaccountform1','class'=>'form-horizontal ajax_form','type'=>'file')); ?>
		<?php echo $this->Form->hidden($model.'.id'); ?>
		<div class="alert ajax_alert alert-danger display-hide">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
			<span class="ajax_message"></span>	
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.firstname', __('First Name:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input($model.".firstname",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Your First Name','required')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.lastname', __('Last Name:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input($model.".lastname",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Your Last Name','required')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.country_code', __('Country:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->select($model.".country_code",$countries,array('class'=>'form-control country','label'=>false,'empty'=>'Select Country','required')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.state_code', __('State:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->select($model.".state_code",'',array('class'=>'form-control states','label'=>false,'empty'=>'Select State')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.city_code', __('City:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->select($model.".city_code",'',array('class'=>'form-control cities','label'=>false,'empty'=>'Select City')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.zipcode', __('Zipcode:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input($model.".zipcode",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Zipcode Here')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.house_number', __('House Number:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea($model.".address",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Your House Number')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.language', __('Language:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->select($model.".language_code",$languages,array('class'=>'form-control','label'=>false,'empty'=>false,'required')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.about_me', __('About Me:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea($model.".about_me",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter About Me')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.slug', __('Username:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input($model.".slug",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Slug','required')); ?>
					  <small>(www.jumplyfe.com/username)</small>
					</div>
					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.dob', __('Date Of Birth:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->text($model.".dob",array('class'=>'form-control dob_datepicker','label'=>false,'placeholder'=>'Fill date of Birth','required','readonly')); ?>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $this->Form->label($model.'.image', __('Update Image:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
						<?php echo $this->Form->file($model.".image",array('class'=>'validate[required] check_size','data-max_size' => Configure::read("Site.max_upload_image_size"),'label'=>false)); ?>
					
						<?php
						$image_name = isset($image) ? $image : 'no_image.jpg';
						$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
						// $file_name		=	$image;
						if($image_name !='') {
							$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',202,0,base64_encode($file_path),$image_name),true);
							echo $this->Html->image($image_url,array('class'=>''));
						} else {
							echo $this->Html->image('main_profile.png',array('class'=>''));
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="set_btn">
					
					<?php echo $this->Form->button(__d("users", "Submit <i class='fa fa-arrow-circle-right'></i>", true),array("class"=>"btn btn-info pull-right")); ?>
				</div>
			</div>
		</div>
	  <?php echo $this->Form->end();?>
	  <hr>
	  <h3>Close Account:</h3>
	  <p>If you close your account, you will need to register again in order to log back into our website.
	  <?php echo $this->Html->link("Close Account <i class='fa fa-times-circle'></i>",'javascript:void(0)',array('onclick'=>'deactiveAccount()','class'=>"btn btn-danger pull-right","escape"=>false)); ?></p>
	  <div class="clearfix"></div>
	  <hr>
	  <h3>Notification Promotional:</h3>
	  <?php 
		$checked = '';
		if($this->request->data['User']['notification_promotional'] == 'Yes')
		{
			$checked = 'checked="checked"';
			
		}
	  ?>
	  <p><input type="checkbox" name="my-checkbox" id="notificationStatus" data-on-text="ON" <?php echo $checked; ?> ></p>
	  <div class="clearfix"></div>
	  <hr>
	  <h3>Private Profile:</h3>
	  <?php 
		$checked = '';
		if($this->request->data['User']['is_private_profile'] == 'Yes')
		{
			$checked = 'checked="checked"';
			
		}
	  ?>
	  <p><input type="checkbox" name="my-checkbox" id="privateProfile" data-on-text="ON" <?php echo $checked; ?> <?php echo $this->request->data['User']['notification_promotional']; ?> ></p>
	  <div class="clearfix"></div>
	  <hr>
	  <h3>Security :</h3>
		<?php echo $this->Form->create($model,array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'security'),'class'=>'form-horizontal ajax_form','id'=>'myaccountform2')); ?>
		<div class="row">
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="col-md-12">
				<div class="form-group col-md-6">
					<?php echo $this->Form->label($model.'.new_password', __('New Password:*',true),array('class'=>'col-sm-4 control-label ajax-form')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input($model.".new_password",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Your New Password','type'=>'password','required')); ?>
					</div>
				</div>
				<div class="form-group col-md-6">
					<?php echo $this->Form->label($model.'.confirm_password', __('Confirm Password:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input($model.".confirm_password",array('class'=>'form-control','label'=>false,'placeholder'=>'Re-Enter Your Password','type'=>'password','required')); ?>
					</div>
				</div>
				<div class="form-group col-md-6">
					<?php echo $this->Form->label($model.'.current_password', __('Current Password:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
						<?php echo $this->Form->input($model.".current_password",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Your Current Password','type'=>'password','required')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php echo $this->Form->button(__d("users", "Save Changes <i class='fa fa-arrow-circle-right'></i>", true),array("class"=>"btn btn-info pull-right",'escape'=>false)); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
	
<script>
var state_code = '<?php echo $state_code?>';
var city_code = '<?php echo $city_code?>';
$(document).ready(function(){
	getState(state_code,city_code);
	
	$('.country').change(function(e){
		getState($(this).val());
	});
	
	$('.states').change(function(e){
		getCities($(this).val());
	});
	
	$(".dob_datepicker").datepicker({
		format: "mm/dd/yyyy",
		endDate: '<?php echo $getDate; ?>'
	}); 
});

</script>
<script>
function getState(state_code,city_code){
	var country_iso_code = $('.country').val();
	if(country_iso_code != '')
	{
		$.ajax({
			type:"post",
			url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'get_states'));?>",
			data:{'country_iso_code':country_iso_code},
			dataType :"json",
			success:function(data) {
				$(".states").html('');
				$(".states").html('<option value="">Select State</option>');
				$.each(data.states,function(key,value){
					var selected = '';
					if(state_code == key)
					{
						selected = "selected";
					}
					var html = '<option '+selected+' value="'+key+'">'+value+'</option>';
					$(".states").append(html);
				});
				getCities(state_code,city_code);
				
			}
		});
	}
}

function getCities(state_iso_code,city_code){
	if(state_iso_code != '')
	{
		$.ajax({
			type:"post",
			
			url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'get_cities'));?>",
			data:{'state_iso_code':state_iso_code},
			dataType :"json",
			success:function(data1) {
				$(".cities").html('');
				$(".cities").html('<option value="">Select City</option>');
				$.each(data1.cities,function(key,value){
					var selected = '';
					if(city_code == key)
					{
						selected = 'selected';
					}
					var html = '<option '+selected+' value="'+key+'">'+value+'</option>';
					$(".cities").append(html);
				})
			}
		});
	}
}

function actionAfterChangeName(data){
	$('.device_full').find('.session_username').text(data.firstname);
	
}

function deactiveAccount(){
	var confirmText = "Are you sure you want to close your account ?";
	if(confirm(confirmText)) {
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'deactiveAccount')); ?>",
			dataType:"json",
			success:function(r){
				location.href = r.redirectUrl;
			}
		});
	}
	return false;
}

$(document).ready(function(){
	$("#notificationStatus").bootstrapSwitch();
	$('#notificationStatus').on('switchChange.bootstrapSwitch',function(event, state) {
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'notification')); ?>",
			data:{'state':state},
			dataType:"json",
			success:function(){
			
			
			}
		});
	});
	
	$("#privateProfile").bootstrapSwitch();
	$('#privateProfile').on('switchChange.bootstrapSwitch',function(event, state) {
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'private_profile')); ?>",
			data:{'state':state},
			dataType:"json",
			success:function(){
			
			
			}
		});
	});
	
	$("input.check_size").change(function () {
		
		var max_size = $(this).attr('data-max_size');
		var show_size = Math.round(max_size / 1024);
		if ($(this).val() !== "") {
			
			var file = $('.check_size')[0].files[0];
			var file_size = file.size / 1024;
			if(file_size > max_size)
			{
				
				$(this).closest("form").find('.ajax_alert').slideDown().find('.ajax_message').text('Image must be less than '+show_size+'MB');
				return false;
			}
			else
			{
				$(this).closest("form").find('.ajax_alert').slideUp();
				return true;
			}
		}
	});
});

</script>
