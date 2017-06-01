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
          <h3 class="title">Bookings</h3>
			<?php //pr($jump_host_record); ?>
		   <?php if(isset($booking_Record) && !empty($booking_Record)){ ?>
		   <?php foreach($booking_Record as $key =>$value){ ?>
			<div class="myprofile">
            <div class="top_title">
              <h3><?php echo $value['User']['firstname'];?> <?php echo $value['User']['lastname'];?><span><?php if(!empty($value['BookingJumpHost']['city'])) { echo $value['BookingJumpHost']['city'].', '; } ?><?php if(!empty($value['BookingJumpHost']['country'])) { echo $value['BookingJumpHost']['country'];  } ?></span></h3>
			  
              <?php echo $this->Html->link('View Profile','/'.$value['User']['slug'],array('class'=>'btn btn-primary text-upper'));  ?>
              <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
              <table class="table">
              <tr>
                <td>
				  <?php
						$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
						$file_name		=	$value['User']['image'];
						if($file_name && file_exists($file_path . $file_name)) 
						{
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
                        <td>Price</td>
                        <td><?php echo '$'.round($value['BookingJumpHost']['paid_amount']); ?></td>
                      </tr>
                        <td>Check in</td>
                        <td><?php echo date('M d Y',strtotime($value['BookingJumpHost']['check_in'])); ?></td>
                      </tr>
                      <tr>
                        <td>Check out</td>
                        <td><?php echo date('M d Y',strtotime($value['BookingJumpHost']['check_out'])); ?></td>
                      </tr>
					   <tr>
                        <td>Booking Date Time</td>
                        <td><?php echo date('M d Y',strtotime($value['BookingJumpHost']['booking_date_time'])); ?></td>
                      </tr>
					  
					 
                    </table>
                  </div>
                </td>
                 <td> </td>
              </tr>
            </table>
          </div>
           <div class="clearfix"></div>
        </div>
		  <?php } ?>
		<?php } else {?>
			<div class="no-record">No Record Found</div>
        <?php } ?>
          </div>
        </div>
     </div>
  </div>
</div>
