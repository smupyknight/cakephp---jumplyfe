<?php echo $this->element('menu'); ?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
			<div class="col-md-9 col-sm-9">
				<div class="btn-style">
					<div class="btn-group btn-group-justified my_active_group">
						
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance" onclick="myBookingUrl(this)">My Bookings</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-advance" onclick="aboutMeUrl(this)">About Me</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-advance" onclick="paymentsUrl(this)">Payments</button>
						</div>
					</div>
				</div>
				<?php if($bookings){ ?>
				<?php foreach($bookings as $key =>$value){ ?>
				<div class="myprofile">
					<div class="top_title">
						<h3><?php echo $value['Jump']['title'];?><span><?php echo $value['HostJumperBooking']['city'];  ?>, <?php echo $value['HostJumperBooking']['country'];  ?></span></h3>
						<div class="clearfix"></div>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td>
									<?php
									$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
									$file_name		=	$value['Jump']['image'];
									if($file_name && file_exists($file_path . $file_name)) {
									$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',375,375,base64_encode($file_path),$file_name),true);
									echo $this->Html->image($image_url,array('class'=>'img-responsive'));
									}
									else 
									{
									echo $this->Html->image('main_profile.png',array('class'=>'img-responsive'));
									}
									?>
								</td>
								<td>
									<div class="table-responsive">
										<table class="table table-bordered">
											<tr>
												<td>Buyer Name</td>
												<td><?php echo $value['Buyer']['firstname'].' '.$value['Buyer']['lastname']; ?></td>
											</tr>
											<tr>
												<td>Booking Date Time</td>
												<td><?php echo date('Y-m-d',strtotime($value['HostJumperBooking']['booking_for_date'])); ?></td>
											</tr>
											<tr>
												<td>Paid Amount</td>
												<td><?php echo round($value['HostJumperBooking']['paid_amount']); ?> <?php echo $this->Session->read('Currency.default'); ?></td>
											</tr>			
										</table>
									</div>
								</td>
								<td>
									<div style="height:auto; width:200px;" class="map_<?php echo $key; ?> iframe"></div>
									<script>
									$(document).ready(function (){
										var myLatlng = new google.maps.LatLng(<?php echo $value['Jump']['latitude']; ?>,<?php echo $value['Jump']['longitude']; ?>);
										var myOptions = {
											zoom: 12,
											center: myLatlng,
											mapTypeId: google.maps.MapTypeId.ROADMAP
										}
										map = new google.maps.Map($('.map_<?php echo $key; ?>')[0], myOptions);
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
					</div>
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				<?php } else {?>
					<div class="no-record">No Booking Found</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
function aboutMeUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'about_me')); ?>';
	window.location = url;
}

function paymentsUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'payments')); ?>';
	window.location = url;
}

function myBookingUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'my_bookings')); ?>';
	window.location = url;
}
</script>
