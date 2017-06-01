<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
			<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>

			<div class="col-md-9 col-sm-9">
				<?php echo $this->Session->Flash(); ?>
				<h3 class="title">Booked Hotels</h3>
				<?php //pr($jump_host_record); ?>
				<div class="load_booked_hotel_content">
				
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$.ajax({
		type:"post",
		url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"accounts",'action' => 'my_booked_hotel_content')); ?>",
		success: function(data) {
			$('.load_booked_hotel_content').html(data);
		} 	
		
	});
});
</script>
