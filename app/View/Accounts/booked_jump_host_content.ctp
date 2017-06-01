<?php if(isset($jump_host_record) && !empty($jump_host_record)){ ?>
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<div id="posts-list" class="grid_entry row masonry">
	<?php foreach($jump_host_record as $key =>$value){ ?>
	<div class="myprofile post-item">
		<div class="top_title">
			<h3><?php echo $this->Text->truncate($value['JumpHost']['title'],30);?><span><?php echo $this->Text->truncate($value['JumpHost']['city'],15);  ?>, <?php echo $this->Text->truncate($value['JumpHost']['country'],15);  ?></span></h3>
			<?php if($value['JumpHost']['is_deleted'] == 'No') { ?>
				
				<?php echo $this->Html->link('View Detail',array('plugin'=>false,'controller'=>'jump_hosts','action'=>'detail',$value['JumpHost']['slug']),array('class'=>'btn btn-primary text-upper'));  ?>
			
				<?php $check_in_Date = $value['BookingJumpHost']['check_in']; ?>
				<?php $before_twoDay_date = date('Y-m-d', strtotime($check_in_Date .'-'.REFUND_PAYMENT_TIME)); ?>
	
				<?php $current_date = date('Y-m-d'); ?>
			
				<?php if($value['BookingJumpHost']['is_cancelled'] == 'Yes'){?>
					<?php echo $this->Html->link('Refunded','javascript:void(0)',array('class'=>'btn btn-primary text-upper disabled','disabled'=>true)); ?>
					
				<?php } else if($before_twoDay_date <= $current_date){ ?>
						<?php echo $this->Html->link('Not Refundable','javascript:void(0)',array('class'=>'btn btn-primary disabled text-upper'));  ?>		
				<?php } else { ?>
				
					<?php echo $this->Html->link('Refund',array('plugin'=>false,'controller'=>'jump_hosts','action'=>'refund_payment',$value['BookingJumpHost']['invoice_id']),array('class'=>'btn btn-primary text-upper'));  ?>
				<?php } ?>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<td>
						<?php
							$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
							$file_name		=	$value['JumpHost']['image'];
							if($file_name && file_exists($file_path . $file_name)) {
								$box_image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',0,0,base64_encode($file_path),$file_name),true);
								$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',375,375,base64_encode($file_path),$file_name),true);
								$image = $this->Html->image($image_url,array('class'=>'img-responsive Book_JumpRental_Image'));
								echo $this->Html->link($image,$box_image_url,array('class'=>'fancybox','escape'=>false));
							}
							else 
							{
								echo $this->Html->image('no_image.png',array('class'=>'img-responsive Book_JumpRental_Image'));
							}
						?>
					</td>
					<td>
						<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Price</td>
								<td><?php echo round($value['BookingJumpHostAmount'] ) .' '. $this->Session->read('Currency.default'); ?></td>
							</tr>
							<tr>
								<td>Check in</td>
								<td><?php echo date('Y-m-d',strtotime($value['BookingJumpHost']['check_in'])); ?></td>
							</tr>
							<tr>
								<td>Check out</td>
								<td><?php echo date('Y-m-d',strtotime($value['BookingJumpHost']['check_out'])); ?></td>
							</tr>
							<tr>
								<td>Booking Date</td>
								<td><?php echo date('Y-m-d',strtotime($value['BookingJumpHost']['booking_date_time'])); ?></td>
							</tr>
						</table>
						</div>
					</td>
					<td>
						<div style="height:auto; width:200px;" class="map_<?php echo $value['BookingJumpHost']['id']; ?> iframe"></div>
			   
					   <script>
						$(document).ready(function (){
							 var myLatlng = new google.maps.LatLng(<?php echo $value['JumpHost']['latitude']; ?>,<?php echo $value['JumpHost']['longitude']; ?>);
							 var myOptions = {
								 zoom: 12,
								 center: myLatlng,
								 mapTypeId: google.maps.MapTypeId.ROADMAP
								 }
							  map = new google.maps.Map($('.map_<?php echo $value['BookingJumpHost']['id']; ?>')[0], myOptions);
							  var marker = new google.maps.Marker({
								  position: myLatlng, 
								  map: map,
							  title:"Fast marker"
							 });
						});
						</script>
					</td>
				</tr>
			</table>
			<?php if($value['JumpHost']['is_deleted'] == 'Yes') { ?>
				<div class="top_title">
					<h3>This Jump Host Deleted By Admin.</h3>
				<div class="clearfix"></div>
				</div>
				
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php } ?>
</div>
<?php echo $this->Paginator->next(''); ?>
<?php } else { ?>
		<div class="no-record">No Record Found</div>
<?php } ?>
<script>
$(function(){
	$('#posts-list').infinitescroll({
		navSelector  : '.next',    // selector for the paged navigation 
		nextSelector : '.next a',  // selector for the NEXT link (to page 2)
		itemSelector : '.post-item',     // selector for all items you'll retrieve
		debug		 	: true,
		dataType	 	: 'html',
		loading: {
		  finishedMsg: 'No more posts to load. All Hail Star Wars God!',
		  img: '<?php echo $this->webroot; ?>img/spinner.gif'
		}
	});
});
</script>
