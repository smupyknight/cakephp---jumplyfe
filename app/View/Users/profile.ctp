
<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
  <div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
			  <!--<div class="icon">
				<a href="#"> <i class="fa fa-play"></i>add JUMPS vID</a>
				<a href="#"> 
					
					<?php echo $this->html->image('newjumpshots.png',array('class'=>'jumpicon'))?>
				ADD JUMPS SHOTS</a>
			  </div> -->
				<div class="row">
					<div class="load_profile_content">
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	var slug ="<?php echo $user_slug; ?>";
	$.ajax({
		type:"post",
		url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'profile_content')); ?>",
		data:{'slug':slug},
		success: function(data) {
			$('.load_profile_content').html(data);
		} 	
		
	});
});
</script>
