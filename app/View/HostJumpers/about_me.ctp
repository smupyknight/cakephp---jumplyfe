<?php echo $this->element('menu'); ?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="btn-style">
					<div class="btn-group btn-group-justified my_active_group">
						
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-advance" onclick="myBookingUrl(this)">My Bookings</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance" onclick="aboutMeUrl(this)">About Me</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-advance" onclick="paymentsUrl(this)">Payments</button>
						</div>
					</div>
				</div>
				<div class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-4 control-label">Host jumper status:</label>
						<div class="col-sm-8">
							<input type="checkbox" name="my-checkbox" id="hostJumperStatus" <?php echo $status; ?> ><br>
							<small>(Check it ON if u want to work as a Host Jumper)</small>
						</div>
					</div>
				</div>
				
				<?php echo $this->Form->create('User',array('class'=>'form-horizontal ajax_form')); ?>
				
				<div class="form-group">
					<?php echo $this->Form->label('User.host_jumper_about_me', __('About me:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("User.host_jumper_about_me",array('class'=>'form-control','label'=>false,'placeholder'=>'About me','required','rows'=>8)); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('User.host_jumper_price', __('Price (USD):*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("User.host_jumper_price",array('class'=>'form-control','label'=>false,'placeholder'=>'Price','required','min'=>100)); ?>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="btn-style">
							<div class="set_btn">
								<?php echo $this->Form->button(__d("users", "Save <i class='fa fa-arrow-circle-right'></i>", true),array("class"=>"btn btn-info pull-right")); ?>
							</div>
						</div>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
<script>
function paymentsUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'payments')); ?>';
	window.location = url;
}

function aboutMeUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'about_me')); ?>';
	window.location = url;
}

function myBookingUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'my_bookings')); ?>';
	window.location = url;
}
$(document).ready(function(){
	$("#hostJumperStatus").bootstrapSwitch();
	$('#hostJumperStatus').on('switchChange.bootstrapSwitch',function(event, state) {
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"host_jumpers",'action' => 'is_host_jumper')); ?>",
			data:{'state':state},
			dataType:"json",
			success:function(){
			
			
			}
		});
	});
});
</script>
