<div class="searchpage">
	<?php echo $this->element('menu'); ?>
</div>
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
        <div class="col-md-9">
          <div class="room_register">
            <dl id="accordion">
              <dt class="tabOrder_1">Traveler Details</dt>
              <dd>
				<?php if(isset($rooms) && !empty('$rooms')) { ?>
				<?php echo $this->Form->create('Hotel',array('url'=>array('controller'=>'hotels','action'=>'HotelBook'),'class'=>'form-horizontal ajax_form traveler_form')); ?>
				<div class="alert ajax_alert alert-danger display-hide">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
					<span class="ajax_message"></span>	
				</div>
                <h3 class="section_title">Traveler Details</h3>
                <P>Please enter the same name as it is shown on the identification you will bring with you to the hotel. If you have more than one last name, please include all last names.</P>
				<?php $i = 1; foreach($rooms as $key =>$value){ ?>
                <h4><?php echo 'Room '.$i; ?></h4>
                  <div class="form-group">
					<?php echo $this->Form->label("$key.Hotel.firstname", __('First Name * :',true),array('class'=>'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
					  <?php echo $this->Form->text("$key.Hotel.firstname",array('class'=>'form-control','label'=>false,'placeholder'=>'First Name','value'=>$user_data['User']['firstname'])); ?>
                    </div>
                  </div>
                  <div class="form-group">
					<?php echo $this->Form->label("$key.Hotel.lastname", __('Last Name * :',true),array('class'=>'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
					   <?php echo $this->Form->text("$key.Hotel.lastname",array('class'=>'form-control','label'=>false,'placeholder'=>'Last Name','value'=>$user_data['User']['lastname'])); ?>
                    </div>
                  </div>
                  <!--<div class="form-group">
                    <label class="col-sm-3 control-label">Bed Type * : </label>
                    <div class="col-sm-9">
                      <select class="form-control">
                        <option>King Size</option>
                        <option>2 Single Bed</option>
                      </select>
                    </div>
                  </div>-->
                  <p>Make special requests for this room, or tell us about your accessibility needs</p>
                  <div class="form-group">
					<?php echo $this->Form->label("$key.Hotel.smoking_preferences", __('Smoking Preferences * :',true),array('class'=>'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                      <div class="radio-group"><?php echo $this->Form->radio("$key.Hotel.smoking_preferences",array('Non-Smoking'=>'Non-Smoking','Smoking'=>'Smoking'),array('legend'=>false,'required'=>false,'value' => 'Non-Smoking'));?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
					<?php echo $this->Form->label("$key.Hotel.special_requests", __('Special Requests  :',true),array('class'=>'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
					<?php echo $this->Form->textarea("$key.Hotel.special_requests",array('class'=>'form-control','label'=>false,'placeholder'=>'Special Requests')); ?>
                    </div>
                  </div>
				  <?php echo $this->Form->input("$key.Hotel.hotel_booking_id",array('label'=>false,'value'=>$hotel_booking_id,'type'=>'hidden')); ?>
				  <?php $a = 0;?>
				  <?php $age_string = $value['adults'].','; ?>
				  <?php if(isset($value['children']) && !empty($value['children'])){?>
					  <?php 
						foreach($value['children'] as $key1 => $value1){ 
							$age_string = $age_string.$value1.',';
							$a++;
						}
					  ?>
					 
				  <?php } ?>
					<?php echo $this->Form->input("$key.Hotel.total_number_children",array('label'=>false,'value'=>$a,'type'=>'hidden')); ?>
					<?php echo $this->Form->input("$key.Hotel.total_number_adults",array('label'=>false,'value'=>$value['adults'],'type'=>'hidden')); ?>
					<?php echo $this->Form->input("$key.Hotel.children_age",array('label'=>false,'value'=>$age_string,'type'=>'hidden')); ?>
					<?php echo $this->Form->input("$key.Hotel.BedTypeId",array('label'=>false,'value'=>$BedTypeId,'type'=>'hidden')); ?>
					
                  <p>Make special requests for this room, or tell us about your accessibility needs</p>
                  <div class="clearfix"> </div>
                  <hr>
                  <div class="clearfix"> </div>
				  <?php $i++; } ?>
				  <?php } ?>

                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                     <!-- <a href="#" class="btn btn-primary disabled">Previous</a>
                      <a href="#" class="btn btn-primary">Finish</a> -->
					   <?php echo $this->Form->button(__d("hotel_bookings", "Next", true),array("class"=>"btn btn-primary")); ?>
                    </div>
                  </div>
                <?php echo $this->Form->end(); ?>
                <div class="clearfix"> </div>
                  <hr>
                <div class="clearfix"> </div>
              </dd>
                <dt class="tabOrder_2">Contact Details</dt>
                <dd>
                  <?php echo $this->Form->create('HotelContactDetails',array('url'=>array('controller'=>'hotels','action'=>'contactDetailSave'),'class'=>'form-horizontal ajax_form traveler_form')); ?>
					<div class="alert ajax_alert alert-danger display-hide">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
						<span class="ajax_message"></span>	
					</div>
                    <h3 class="section_title">Contact Details</h3>
                    <P>We require a valid email address to contact you with the details of your booking.</P>
					<div class="form-group">
						<?php echo $this->Form->label('HotelContactDetails.email_address', __('Email Address * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("HotelContactDetails.email_address",array('class'=>'form-control','label'=>false,'placeholder'=>'Mail id','required','type'=>'email','value'=>$user_data['User']['email'])); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $this->Form->label('HotelContactDetails.confirm_email_address', __('Confirm Email Address * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("HotelContactDetails.confirm_email_address",array('class'=>'form-control','label'=>false,'placeholder'=>'Re-enter Mail id','required','type'=>'email','value'=>$user_data['User']['email'])); ?>
						</div>
					</div>
               
					<div class="form-group">
						<?php echo $this->Form->label('HotelContactDetails.telephone_number', __('Telephone Number * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("HotelContactDetails.telephone_number",array('class'=>'form-control','label'=>false,'placeholder'=>'Telephone Number','required')); ?>
						</div>
					</div>
					 <?php echo $this->Form->input("HotelContactDetails.hotel_booking_id",array('label'=>false,'value'=>$hotel_booking_id,'type'=>'hidden')); ?>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                        <a href="#" class="btn btn-primary disabled">Previous</a>
                         <?php echo $this->Form->button(__d("hotel_contact_details", "Next", true),array("class"=>"btn btn-primary")); ?>
                        <a href="#" class="btn btn-primary">Finish</a>
                      </div>
                    </div>
                  <?php echo $this->Form->end(); ?>
                  <div class="clearfix"> </div>
                    <hr>
                  <div class="clearfix"> </div>
                </dd>
              <dt class="tabOrder_3">Payment Details</dt>
              <dd>
               <?php echo $this->Form->create('CreditCardDetail',array('url'=>array('controller'=>'hotels','action'=>'creditCardDetailsSave'),'class'=>'form-horizontal ajax_form traveler_form')); ?>
			   <div class="alert ajax_alert alert-danger display-hide">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
						<span class="ajax_message"></span>	
					</div>
                  <h3 class="section_title">Traveler Details</h3>
                  <P>Please enter the same name as it is shown on the identification you will bring with you to the hotel. If you have more than one last name, please include all last names.</P>
                  <h4>Credit Card Information </h4>
                     <?php echo $this->Form->input("CreditCardDetail.hotel_booking_id",array('label'=>false,'value'=>$hotel_booking_id,'type'=>'hidden')); ?>
					<div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.card_type', __('Card Type * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<?php $card_type = array('AX' =>'American Express','DC'=>'DINERS CLUB INTERNATIONAL','CA'=>'Master Card'); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->Select("CreditCardDetail.card_type",$card_type,array('class'=>'form-control','label'=>false,'empty'=>'Select Your Card Type','required')); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.card_number', __('Card Number * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("CreditCardDetail.card_number",array('class'=>'form-control','label'=>false,'placeholder'=>'Card Number','required')); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.cardholder_first_name', __('Cardholder First Name * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("CreditCardDetail.cardholder_first_name",array('class'=>'form-control','label'=>false,'placeholder'=>'First Name','required')); ?>
						</div>
					</div>
                    <div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.cardholder_last_name', __('Cardholder Last
						Name * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("CreditCardDetail.cardholder_last_name",array('class'=>'form-control','label'=>false,'placeholder'=>'Last Name','required')); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.expiration_date', __('Expiration Date * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<div class="row">
							<?php
								$month = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
								$year = date('Y');
								$year_list = array();
								for($i=0; $i<=10; $i++){
									$year_list[$year] = $year;
									$year = $year + 1;	
								}
							?>
							  <div class="col-sm-6">
								  <?php echo $this->Form->select("CreditCardDetail.month",$month,array('class'=>'form-control margin_btm','label'=>false,'empty'=>'Select Month','required')); ?>
							  </div>
							  <div class="col-sm-6">
								 <?php echo $this->Form->select("CreditCardDetail.year",$year_list,array('class'=>'form-control','label'=>false,'empty'=>'Select Year','required')); ?>
							  </div>
							</div>
						</div>
					</div>
					 <div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.security_code', __('Security Code * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("CreditCardDetail.security_code",array('class'=>'form-control','label'=>false,'placeholder'=>'Security Code','required')); ?>
						</div>
					</div>

                    <div class="clearfix"> </div>
                      <hr>
                    <div class="clearfix"> </div>


                    <h4>Billing Address</h4>
                    <p>The billing address provided must match the credit card that is used to reserve your room.</p>
                    <div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.country', __('country * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->Select("CreditCardDetail.country",$countries,array('class'=>'form-control','label'=>false,'empty'=>'Select Country','required','value'=>$user_data['User']['country_code'])); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.state', __('Postal / state * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("CreditCardDetail.state",array('class'=>'form-control','label'=>false,'placeholder'=>'State','required','value'=>$user_data['User']['state'])); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.City', __('City * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("CreditCardDetail.city",array('class'=>'form-control','label'=>false,'placeholder'=>'City','required','value'=>$user_data['User']['city'])); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.street_address', __('Street Address * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
                        <div class="row">
                          <div class="col-sm-6">
                            <?php echo $this->Form->text("CreditCardDetail.address_line_1",array('class'=>'form-control margin_btm','placeholder'=>'Address line 1','label'=>false,'required')); ?>
                          </div>
                          <div class="col-sm-6">
                            <?php echo $this->Form->text("CreditCardDetail.address_line_2",array('class'=>'form-control','placeholder'=>'Address line 2','label'=>false,'required')); ?>
                          </div>
                        </div>
                      </div>
					</div>
					
                    <div class="form-group">
						<?php echo $this->Form->label('CreditCardDetail.zipcode', __('Postal / Zip Code * :',true),array('class'=>'col-sm-3 control-label')); ?>
						<div class="col-sm-9">
							<?php echo $this->Form->input("CreditCardDetail.zipcode",array('class'=>'form-control','label'=>false,'placeholder'=>'Postal / Zip Code','required')); ?>
						</div>
					</div>
                    <div class="clearfix"> </div>
                      <hr>
                    <div class="clearfix"> </div>


                    <h4>Cancellation Policy</h4>
                    <p> <?php echo $cancellationPolicy; ?></p>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                          <label><?php echo $this->Form->input("CreditCardDetail.terms",array('type'=>'checkbox','value'=>1,'label'=>false,'required'=>'required')); ?> I agree to <a href="#">Terms and Conditions</a> and understand Cancellation Policy. </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                        <a href="#" class="btn btn-primary disabled">Previous</a>
                       <?php echo $this->Form->button(__d("credit_cards_detail", "Next", true),array("class"=>"btn btn-primary")); ?>
                        <a href="#" class="btn btn-primary">Finish</a>
                      </div>
                    </div>
                 <?php echo $this->Form->end(); ?>
                </dd>
            </dl>
            <!-- <div class="Traveler">
            </div> -->
          </div>
        </div>

        <div class="col-md-3">
            <div class="section room">
            <div class="user-section">
              <h4 class=""> <?php echo $hotelName; ?> </h4>
              <div class="media">
                <div class="media-left">
                  <a href="javascript:void(0)"><img class="media-object" style="width:108%" src="<?php echo $hotelPhoto; ?>" alt="0"></a>
                </div>
                <!--<div class="media-body text-left">
                  <div class="rating">
                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                  </div>
                  <img src="img/trip.gif" class="img-responsive">
                  <P>124 Reviews</P> 
                </div>-->
              </div>
              <p> <?php echo $hotelAddress; ?> </p>
            </div>
            <ul>
              <li><strong>Check-in : </strong><?php echo $check_in; ?></li>
              <li><strong>Check-out : </strong><?php echo $check_out; ?></li>
              <li><strong>Adults : </strong><?php echo $adults_count; ?></li>
              <li><strong>children : </strong><?php echo $children_count; ?></li>
              <li><strong>Room : </strong><?php echo $room_count; ?></li>
            </ul>
            <div class="clearfix"></div>
              <hr>
            <div class="clearfix"></div>
            <h4>Price Details</h4>
            <strong>Total Price: </strong><span> $<?php echo $chargeableRate; ?></span>
			
            <div class="clearfix"></div>
              <hr>
            <div class="clearfix"></div>
            <?php if(isset($cancellationPolicy) && $cancellationPolicy) { ?>
            <h4>Cancellation Policy</h4>
            <p>
              <?php echo $cancellationPolicy; ?>
            </p>
            <?php } ?>

            <div class="clearfix"></div>
              
        </div>

        </div>

     </div>
  </div>
</div>
<script>
function afterSubmitCloseTab(){
	$('.tabOrder_2').trigger('click');
}

function afterSubmitCloseTablast(){

	$('.tabOrder_3').trigger('click');
}
</script>
