<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<?php echo $this->Session->flash(); ?>
				<h3 class="title">My Jumps <?php echo $this->Html->link('Add New',array('plugin'=>false,'controller'=>'jumps','action'=>'add_my_jump'),array('class'=>'btn btn-primary pull-right text-upper')); ?></h3>
				<div class="load_my_jumps_content">
				
				
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$.ajax({
		type:"post",
		url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"jumps",'action' => 'my_jumps_content')); ?>",
		success: function(data) {
			$('.load_my_jumps_content').html(data);
		} 	
		
	});
});
</script>
