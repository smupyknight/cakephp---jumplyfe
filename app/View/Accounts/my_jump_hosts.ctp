<?php echo $this->element('menu');?>
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
			<h3 class="title">My Jump Rentals  <?php echo $this->Html->link('Add New',array('plugin'=>false,'controller'=>'accounts','action'=>'add_my_jump_host'),array('class'=>'btn btn-primary pull-right')); ?></h3>
			<div class="load_jump_host_content">
				
			</div>


			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$.ajax({
		type:"post",
		url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"accounts",'action' => 'my_jump_hosts_content')); ?>",
		success: function(data) {
			$('.load_jump_host_content').html(data);
		} 	
		
	});
});
</script>
  
