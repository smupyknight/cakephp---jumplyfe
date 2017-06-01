<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
		<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
        <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
        
		  <div class="col-md-9 col-sm-9">
		  <?php echo $this->Session->Flash(); ?>
          <h3 class="title">Detail</h3>
			<?php //pr($jump_host_record); ?>
			<div class="booked_detail">
              <h3><?php echo $bookedData['BookedHotel']['hotelName'];?><span><?php echo $bookedData['BookedHotel']['hotelCity'];  ?>, <?php echo $bookedData['BookedHotel']['hotelCountryCode'];  ?></span></h3>

            <div class="row">
              <div class="col-sm-4">
                <?php echo $this->Html->image($bookedData['BookedHotel']['imageUrl'],array('class'=>'img-responsive booked_hotel_details_img')); ?>
              </div>

              <div class="col-sm-8">
                <div class="table-responsive">
                    <table class="table table-bordered">
                      <tr>
                        <td>Hotel Id</td>
                        <td><?php echo $bookedData['BookedHotel']['hotel_id']; ?></td>
                      </tr>
                      <tr>
                        <td>Price</td>
                        <td><?php echo round($bookedData['BookedHotel']['convertAmount']); ?> <?php echo $this->Session->read('Currency.default'); ?></td>
                      </tr>
                      <tr>
                        <td>Check in</td>
                        <td><?php echo date('Y-m-d',strtotime($bookedData['BookedHotel']['arrivalDate'])); ?></td>
                      </tr>
                      <tr>
                        <td>Check out</td>
                        <td><?php echo date('Y-m-d',strtotime($bookedData['BookedHotel']['departureDate'])); ?></td>
                      </tr>
                      <tr>
                        <td>Booking Date</td>
                        <td><?php echo date('Y-m-d',strtotime($bookedData['BookedHotel']['created'])); ?></td>
                      </tr> 
                      <tr>
                        <td>Address</td>
                        <td><?php echo $bookedData['BookedHotel']['hotelAddress']; ?></td>
                      </tr>
                      
                    </table>
                  </div>
              </div>
            </div>

            <div class="clearfix"></div>
            <hr>
            <div class="clearfix"></div>

            <div class="table-responsive">
              <table class="table table-bordered">
                <tr>
                <td>Rooms</td>
                <td>Adult</td>
                <td>Children</td>
                <td>Name</td>
				<td>Cancel Reservation</td>
                </tr>
                <?php $i =1; ?>
                <?php foreach($bookedData['HotelRoom'] as $key => $value){ ?>
                <tr>
                <td>Room <?php echo $i; ?></td>
                <td><?php echo $value['total_number_adults']; ?></td>
                <td><?php echo $value['total_number_children']; ?></td>
                <td><?php echo ucfirst($value['first_name']); ?> <?php echo ucfirst($value['last_name']); ?></td>
				<td>
					<?php 
					if($bookedData['BookedHotel']['nonRefundable'] == 'false' && $value['cancellationNumber'] == '')
					{
						
						echo $this->Html->link('Refund',array('plugin'=>false,'controller'=>'hotels','action'=>'cancel_reservation',$value['id']),array('confirm'=>'Are you sure you want to cancel hotel reservation','class'=>'btn btn-primary')); 
					}
					else if($bookedData['BookedHotel']['nonRefundable'] == 'false' && $value['cancellationNumber'] != '')
					{
						
						echo $this->Html->link('Refunded','javascript::void(0)',array('disabled','class'=>'btn btn-primary'));
						
					}
					else
					{
						echo $this->Html->link('Non Refundable','javascript::void(0)',array('disabled','class'=>'btn btn-primary')); 
					} 
					?>
				</td>
                </tr>
                <?php $i++; } ?>
              </table>
            </div>
           <div class="clearfix"></div>
        </div>
          </div>
        </div>
     </div>
  </div>
