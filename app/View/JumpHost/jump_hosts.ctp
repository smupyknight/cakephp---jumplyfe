<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
		<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
		<?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
			<div class="col-md-9 col-sm-9">
				<h3 class="title">Jump Rentals</h3>
				
				<div class="load_content">
				
				</div>
				
			</div>
		</div>
	</div>
</div>
<script>
var title = '<?php echo $title; ?>'; 	
var country = '<?php echo $country; ?>'; 	
var state = '<?php echo $state; ?>'; 	
var city = '<?php echo $city; ?>'; 	
$(document).ready(function(){
	$.ajax({
		type: "post",
		url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"jump_hosts",'action' => 'jump_host_content')); ?>",
		data: {'title':title,'country':country,'state':state,'city':city},
		 success: function(data) {
			$('.load_content').html(data);
		} 
	});
});

function goToReview($this){
	var url = $($this).attr('data-url');
	window.location = url+'#reviews_section';

}
</script>
