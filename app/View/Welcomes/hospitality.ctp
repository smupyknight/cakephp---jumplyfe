<?php if(authComponent::user('id')) { ?><div class="searchpage"><?php echo $this->element('menu'); ?></div> <?php } ?>
<div class="profile bgcolor"> 
	<div class="container">
		<div class="hospital">
			<div class="Hospitality">
				<h5>Hospitality</h5>
				<?php echo $this->Html->image('Hospitality.png',array('class'=>'img-responsive'));?>
				<div class="hospital_title">
					<p><strong>Receiving a guest</strong><br>Hosts who don't let their calendar get a month or more out of date are 70% more likely to get booked.</p>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="hospital_tools">
							<div class="hospital_img"> <?php echo $this->Html->image('Accuracy.png',array('class'=>'img-responsive'));?></div>
							<h6> Accuracy</h6>
							<p>Ensure that your listing's photos, property type, number of bedrooms, and general description accurately reflect the listing guests will experience. </p>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="hospital_tools">
							<div class="hospital_img"> <?php echo $this->Html->image('Communication.png',array('class'=>'img-responsive'));?></div>
							<h6> Communication</h6>
							<p>Respond to all inquiries and reservation requests within 24 hours.  </p>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="hospital_tools">
							<div class="hospital_img"> <?php echo $this->Html->image('Availability.png',array('class'=>'img-responsive'));?></div>
							<h6>Availability</h6>
							<p>
								Update each listing's calendar to accurately reflect dates when it's available for bookings.  
							</p>
						</div>
					</div>
				</div>
				<?php echo $this->Html->image('Hospitality2.png',array('class'=>'img-responsive'));?>
				<div class="hospital_title">
					<p><strong>Preparing for a guest </strong><br>Listings with 5 star cleanliness ratings receive 20% more bookings.</p>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="hospital_tools">
							<div class="hospital_img"> <?php echo $this->Html->image('Commitment .png',array('class'=>'img-responsive'));?></div>
							<h6> Commitment </h6>
							<p>Ensure that you can commit to your guest before accepting a reservation. If a cancellation is unavoidable, make every effort to help guests find somewhere else to stay.  </p>

						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="hospital_tools">
							<div class="hospital_img"> <?php echo $this->Html->image('Cleanliness.png',array('class'=>'img-responsive'));?></div>
							<h6>Cleanliness </h6>
							<p>Ensure that your listing's bedrooms and common areas are cleaned before each guest's arrival. This includes changing linens and cleaning surfaces in the bathroom and kitchen </p>

						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="hospital_tools">
							<div class="hospital_img"> <?php echo $this->Html->image('Amenities.png',array('class'=>'img-responsive'));?></div>
							<h6>Amenities </h6>
							<p>Any amenities, appliances, and features promised at the time of booking should be available and operational during the stay. Provide fresh bedding and towels, soap, and toilet paper upon your guest's arrival.  </p>

						</div>
					</div>
				</div>
				<div class="Personality">
					<h4> Personality</h4>
					<p>Let the personality of you and your listing transform the trip experience. </p>
				</div>
				<?php echo $this->Html->image('Personality.png',array('class'=>'img-responsive'));?>
				<div class="personality_images">
					<div class="row">
						<div class="col-md-4">
							<div class="Personality_img">
							<?php echo $this->Html->image('personality1.jpg',array('class'=>'img-responsive'));?>
							<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet .</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="Personality_img">
								<?php echo $this->Html->image('personality2.jpg',array('class'=>'img-responsive'));?>
								<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet .</p>
							</div>
						</div>

						<div class="col-md-4">
							<div class="Personality_img">
								<?php echo $this->Html->image('personality3.png',array('class'=>'img-responsive'));?>
								<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet .</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
