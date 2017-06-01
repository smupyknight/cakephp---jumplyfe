<?php echo $this->element('menu'); ?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<?php echo $this->Session->flash(); ?>
				<div class="slider">
					<div class="carousel slide" data-ride="carousel" id="carousel">
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<?php echo $this->Html->image('img_03.png',array('alt'=>0));?>
							</div>
							<div class="item">
								<?php echo $this->Html->image('img_03.png',array('alt'=>0));?>
							</div>
						</div>
						<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
							<span class="arrow-left" aria-hidden="true"><?php echo $this->Html->image('arrow_left.png');?></span>
						</a>
						<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
							<span class="arrow-right" aria-hidden="true"><?php echo $this->Html->image('arrow_right.png'); ?></span>
						</a>

					</div>
				</div>
				<div class="price_section">
					<div class="row">
						<div class="price_tag">
							<div class="price">
								<p>Price: <span class="rupess"><?php echo $host_jumper['User']['convertPrice']; ?></span> <span>INR</span></p>
							</div>
							<div class="price_right">
								<?php echo $this->Form->create('HostJumperBooking',array('url'=>array('controller'=>'host_jumpers','action'=>'host_jumper_booking'),'class'=>'ajax_form'));?>
								<div class="alert ajax_alert alert-danger display-hide">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
									<span class="ajax_message"></span>	
								</div>
								<div class="input-group">
									<?php echo $this->Form->text('HostJumperBooking.booking_for_date',array('class'=>'form-control datepicker','label'=>false,'placeholder'=>'Select Date'));?>
									<span class="input-group-btn">
										<button type="button" class="btn btn-default showCalender"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
								<?php echo $this->Form->input('HostJumperBooking.host_jumper_id',array('class'=>'form-control datepicker','label'=>false,'type'=>'hidden','value'=> $host_jumper['User']['id'])); ?>
								<?php echo $this->Form->input('HostJumperBooking.host_jumper_price',array('class'=>'form-control datepicker','label'=>false,'type'=>'hidden','value'=> $host_jumper['User']['host_jumper_price'])); ?>
								<?php echo $this->Form->Select('HostJumperBooking.jump_id',$jumpList,array('class'=>'form-control','empty'=>'Select Jump'));?>
								<?php echo $this->Form->button(__d("host_jumper_bookings", "Book", true),array("class"=>"btn btn-primary"));?>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
				<h4 class="about_title">ABOUT : </h4>
				<p class="parg"><?php if($host_jumper['User']['host_jumper_about_me'] != ''){ echo $host_jumper['User']['host_jumper_about_me']; }else { echo 'No information available' ; } ?></p>
				<h4 class="about_title">REVIEW : </h4>
				<?php if(isset($review_record) && !empty($review_record)) { ?>
				<div class="row">
				<?php foreach($review_record as $key =>$value) {?>
				  <div class="col-md-6">
					  <div class="wages">
						<?php
						$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
						$file_name		=	$value['User']['User']['image'];
						if($file_name && file_exists($file_path . $file_name)) {
							$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',70,70,base64_encode($file_path),$file_name),true);
							echo $this->Html->image($image_url,array('class'=>'img-responsive img_radius'));
						}
						else 
						{
							echo $this->Html->image('wages.png',array('class'=>'img-responsive img_radius'));
						}
						?>
						  <div class="wages_parg">
						  <p><?php echo $value['HostJumperReview']['comment']; ?></p> </div>
						  <div class="clearfix"></div>
						  <h5 class="olivia_wages"><?php $name = $value['User']['User']['firstname'] .' '. $value['User']['User']['lastname']; ?><?php echo $this->Text->truncate($name,16); ?></h5>
						  
						  <div class="star-patten">
							<?php $ratings = $value['HostJumperReview']['rating']; ?>
							<?php $disable_rating = 5 - $value['HostJumperReview']['rating'];?>
							<?php for($i=1; $i<=$ratings; $i++) { ?>
								<i class="fa fa-star"></i>
							<?php } ?>
							<?php for($i=1; $i<=$disable_rating; $i++) { ?>
								<i class="fa fa-star disable"></i>
							<?php } ?>
						 </div>
						  

					  </div>
				  </div>
				  <?php  } ?> 
				  </div>
				 <?php } else {?>
				  <div class="row">
					<div class="col-md-6 col-sm-6">
					  <div class="wages">
							No-record Found
					  </div>
					</div>  
				  </div>
				 
				 <?php } ?>
				 
			   <?php if(!$write_review_button) { ?>
				<a class="btn-primary review" onclick="openHostJumperReviewPopup(this)" href="javascript:void(0)">WRITE REVIEW</a>
			   <?php } ?>
				
				
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('.showCalender').click(function(){
		$('#HostJumperBookingBookingForDate').datepicker("show");
	});
});

 function openHostJumperReviewPopup($this){
	$("#hostJumperReviewPopup").modal('show');
 }
</script>
 <div class="modal fade" id="hostJumperReviewPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Write Review</h4>
			</div>
			<?php echo $this->Form->create('HostJumper',array('url'=>array('plugin'=>false,'controller'=>'host_jumpers','action'=>'hostJumper_review',$host_jumper['User']['slug']),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="">
					<?php echo $this->Form->textarea('HostJumper.comment',array('class'=>'form-control','placeholder'=>'Write Review','aria-describedby'=>'sizing-addon2','label'=>false)); ?>
				</div><br>
				<div class="">
				<?php echo $this->Form->input('HostJumper.rating',array('class'=>'rating-input','type'=>'number','label'=>false)); ?>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("host_jumpers", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.rating-input').rating({
		min: 0,
		max: 5,
		step: 1,
		size: 'md'
    }); 
});
</script>
