<?php echo $this->element('menu'); ?>
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
							<button type="button" class="btn active btn-advance">My Bookings</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance">About Me</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-advance">Post Bookings</button>
						</div>
					</div>
				</div>
				<div class="">
				
				</div>
			</div>
		</div>
	</div>
</div>
	

