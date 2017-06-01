<?php echo $this->element('jumps_menu_bar');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php echo $this->element('user_profile_left_bar'); ?>
			<div class="col-md-9 col-sm-9">
				<div class="row">
					<?php echo $this->Html->link('Show Jump Detail','javascript:void(0)',array('class'=>'btn btn-primary showJumpDetailBtn','onclick'=>'showJumpDetail()'));?>
					<div class="load_content">
					
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function showJumpDetail(){
	$('.jump_details .jump_title').text('<?php echo $jump_record['title']; ?>');
	$('.jump_details .jump_description').text('<?php echo $jump_record['description']; ?>');
	$('.jump_details .jump_address').text('<?php echo $jump_record['location']; ?>');
	$('.jump_details .jumper_name').text('<?php echo $jump_record['jumper_detail']; ?>');
	$('.jump_details .jump_end_date').text('<?php echo $jump_record['jump_end_date']; ?>');
	$('.jump_details .jump_start_date').text('<?php echo $jump_record['jump_start_date']; ?>');
	$('#ShowJumpRecord').modal('show');
	
}
$(function(){
	var slug ="<?php echo $slug; ?>";
	$.ajax({
		type:"post",
		url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"jumps",'action' => 'index_content')); ?>",
		data:{'slug':slug},
		success: function(data) {
			$('.load_content').html(data);
		} 	
		
	});
	
	var latitude = '<?php if(isset($jump_record['latitude'])){ echo $jump_record['latitude']; } ?>';
	var longitude = '<?php if(isset($jump_record['longitude'])){ echo $jump_record['longitude']; } ?>';
	if(latitude != '' && longitude != ''){
		var myLatlng = new google.maps.LatLng(latitude,longitude);
		var myOptions = {
			zoom: 12,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map($('.jump_map_location')[0], myOptions);
		var marker = new google.maps.Marker({
			position: myLatlng, 
			map: map,
			title:"Fast marker"
		});
		$('.jump_details .jump_map_location').addClass('jump_detail_map_popup');
	}
	else
	{
		$('.jump_details .jump_map_location').text('---');
		
	}	
		
});
</script>
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<div class="modal fade" id="ShowJumpRecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Jump Detail</h4>
			</div>
			<div class="modal-body jump_details">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-3"><h4>Title:</h4></div>
						<div class="col-md-9">
							<p class="jump_title"></p>
						</div>
					</div>	
					<div class="col-md-12">
						<div class="col-md-3"><h4>Description:</h4></div>
						<div class="col-md-9">
							<p class="jump_description"></p>
						</div>
					</div>	
					<div class="col-md-12">
						<div class="col-md-3"><h4>Jump Location:</h4></div>
						<div class="col-md-9">
							<p class="jump_address"></p>
						</div>
					</div>	
					<div class="col-md-12">
						<div class="col-md-3"><h4>Start Date:</h4></div>
						<div class="col-md-9">
							<p class="jump_start_date"></p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-3"><h4>End Date:</h4></div>
						<div class="col-md-9">
							<p class="jump_end_date"></p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-3"><h4>Map Location:</h4></div>
						<div class="col-md-9">
						<div class="jump_map_location iframe"></div>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
