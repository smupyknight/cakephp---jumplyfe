<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="btn-style">
					<div class="btn-group btn-group-justified my_active_group">
						
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-advance" onclick="myBookingUrl(this)">My Bookings</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn  btn-advance" onclick="aboutMeUrl(this)">About Me</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn active btn-advance" onclick="paymentsUrl(this)">Payments</button>
						</div>
					</div>
				</div>
				<div class="transaction">
					<h5>PAYMENT DETAILS</h5>
					<div class="table-responsive">
						<table cellspacing="0" cellpadding="0" class="table table-bordered text-center">
							<tr>
								<th>DATE</th>
								<th>INVOICE ID</th>
								<th>JUMP NAME</th>
								<th>AMOUNT</th>
								<th>STATUS</th>
							</tr>
							<?php if(isset($paymentDetails) && !empty($paymentDetails)) { ?>
								<?php foreach($paymentDetails as $key => $value){ ?>
								<tr>
									<td><?php echo date('m/d/Y',strtotime($value['HostJumperBooking']['booking_for_date'])); ?></td>
									<td><?php echo $value['HostJumperBooking']['invoice_id']; ?></td>
									<td><?php echo $value['Jump']['title']; ?></td>
									<td><?php echo $value['HostJumperBooking']['paid_amount']; ?> <?php echo $this->Session->read('Currency.default'); ?></td>
									
									<td>
										<?php 
											if($value['HostJumperBooking']['is_cancelled'] == 'Yes') {
												echo 'Cancelled';
											}
											else
											{
												echo 'Paid';
											}
										?>
									</td>
								</tr>
								<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="7">No Record Found</td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>

				<ul class="pagination">
					<li>
						<?php echo $this->element('pagination'); ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
function paymentsUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'payments')); ?>';
	window.location = url;
}

function aboutMeUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'about_me')); ?>';
	window.location = url;
}

function myBookingUrl($this){
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'host_jumpers','action'=>'my_bookings')); ?>';
	window.location = url;
}
</script>
