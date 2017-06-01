<?php if(isset($bookedHotel) && !empty($bookedHotel)){ ?>
<div id="pagging_post_lists">
<?php foreach($bookedHotel as $key =>$value){ ?>
	<div class="myprofile post-item">
		<div class="top_title">
			<h3><?php echo $value['BookedHotel']['hotelName'];?><span><?php echo $value['BookedHotel']['hotelCity'];  ?>, <?php echo $value['BookedHotel']['hotelCountryCode'];  ?></span></h3>
			<?php echo $this->Html->link('View Detail',array('plugin'=>false,'controller'=>'accounts','action'=>'booked_hotel_detail',$value['BookedHotel']['id']),array('class'=>'btn btn-primary text-upper'));  ?>
			<div class="clearfix"></div>
		</div>
		<div class="table-responsive">
			<table class="table booked_hotel">
				<tr>
					<td>
						<?php echo $this->Html->image($value['BookedHotel']['imageUrl'],array('class'=>'img-responsive booked_hotel_img')); ?>
					</td>
					<td>
						<div class="table-responsive">
							<table class="table table-bordered">
								<tr>
									<td>Price</td>
									<td><?php echo round($value['BookedHotel']['convertAmount']); ?> <?php echo $this->Session->read('Currency.default'); ?></td>
								</tr>
								<tr>
									<td>Check in</td>
									<td><?php echo date('Y-m-d',strtotime($value['BookedHotel']['arrivalDate'])); ?></td>
								</tr>
								<tr>
									<td>Check out</td>
									<td><?php echo date('Y-m-d',strtotime($value['BookedHotel']['departureDate'])); ?></td>
								</tr>
								<tr>
									<td>Booking Date</td>
									<td><?php echo date('Y-m-d',strtotime($value['BookedHotel']['created'])); ?></td>
								</tr>
								<tr>
									<td>Address</td>
									<td><?php echo $value['BookedHotel']['hotelAddress']; ?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
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
	$('#pagging_post_lists').infinitescroll({
		navSelector  : '.next',    // selector for the paged navigation 
		nextSelector : '.next a',  // selector for the NEXT link (to page 2)
		itemSelector : '.post-item',     // selector for all items you'll retrieve
		debug		 : true,
		dataType	 : 'html',
		loading: {
		  finishedMsg: 'No more posts to load. All Hail Star Wars God!',
		  img: '<?php echo $this->webroot; ?>img/spinner.gif'
		}
	});
});
</script>
