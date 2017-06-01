<?php echo $this->element('menu');?>
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
			<h3 class="title">Jump Rentals</h3>
			<div class="load_jump_host_content">
				
			</div>


			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	var user_id = "<?php echo $left_part_user_id; ?>";
	$.ajax({
		type:"post",
		url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"jump_hosts",'action' => 'profile_user_jump_rental_content')); ?>",
		data:{'user_id':user_id},
		success: function(data) {
			$('.load_jump_host_content').html(data);
		} 	
		
	});
});
</script>
  
