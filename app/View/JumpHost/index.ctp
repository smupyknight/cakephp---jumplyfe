<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
        <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
	<div class="col-md-9 col-sm-9">
	<?php if(isset($galleries) && !empty($galleries)) { ?>
	  <div class="slider">
		  <div class="carousel slide" data-ride="carousel" id="carousel">
		   <div class="carousel-inner" role="listbox">
		   <?php foreach($galleries as $key => $value) {?>
			<div class="item <?php echo $key==0?'active':''; ?>">
				<?php
					$image_name		= $value['JumpHostGallery']['file_name'];
					$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',942,304,base64_encode($file_path),$image_name),true);
					echo $this->Html->image($image_url,array('class'=>''));
				?>
			</div>
			<?php } ?>
		  </div>
			<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
			<span class="arrow-left" aria-hidden="true"><?php echo $this->Html->image('arrow_left.png');?></span>
		  </a>
		  <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
			<span class="arrow-right" aria-hidden="true"><?php echo $this->Html->image('arrow_right.png');?></span>
		  </a>
		 
		</div>
	  </div>
	<?php  } ?>
   <div class="price_section">
	   <div class="row">
		<div class="price_tag">
		  <div class="price">
		   <p>Price:<span>$</span> <span class="rupess"><?php echo round($record['JumpHost']['price']); ?></span></p>
		 </div>
		 <div class="price_right">
		  <div class="input-group">
			  <input type="text" class="form-control" placeholder="21 Dec 2014">
				<span class="input-group-btn">
				 <button class="btn btn-default"><i class="fa fa-calendar"></i></button>
				</span>
			</div>
			  <select class="form-control">
					<option>SELECT JUMP</option>
		  </select>
		 <a class="btn-primary" href="#">Book</a>
	  </div>
		</div>
	  
	</div>
   </div>
   <h4 class="about_title">ABOUT : </h4>
   <div class="row">
	<div class="col-md-6 col-sm-6">
	  <div class="parg">
	  <p><?php echo $record['JumpHost']['description'];?></p></div>
	</div>
	<div class="col-md-6 col-sm-6">
			<div style="height:140px; width:100%;" class="map iframe"></div>
           <script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
				   <script>
					$(document).ready(function (){
						 var myLatlng = new google.maps.LatLng(<?php echo $record['JumpHost']['latitude']; ?>,<?php echo $record['JumpHost']['longitude']; ?>);
						 var myOptions = {
							 zoom: 12,
							 center: myLatlng,
							 mapTypeId: google.maps.MapTypeId.ROADMAP
							 }
						  map = new google.maps.Map($('.map')[0], myOptions);
						  var marker = new google.maps.Marker({
							  position: myLatlng, 
							  map: map,
						  title:"Fast marker"
						 });
					});
					</script>
		  <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d14225.20871080889!2d75.77783465!3d26.9573285!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1425284696322" width="100%" height="140" frameborder="0" style="border:1"></iframe> -->

	</div>
 </div>
	<?php if(isset($review_record) && !empty($review_record)) { ?>
   <h4 class="about_title">REVIEW : </h4> 
   <div class="row">
		<?php $i = 0; ?>
		<?php foreach($review_record as $key =>$value) {?>
		<?php $i++; ?>
	  <div class="col-md-6 col-sm-6">
		  <div class="wages">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',70,70,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-responsive'));
			}
			else 
			{
				echo $this->Html->image('wages.png',array('class'=>'img-responsive'));
			}
			?>
			  <!-- <img class="img-responsive" src="img/wages.png"> -->
			  <div class="wages_parg">
			  <p><?php echo $value['JumpHostReview']['comment']; ?></p> </div>
			  <h5 class="olivia_wages"><?php echo $value['User']['User']['firstname']; ?> <?php echo $value['User']['User']['lastname']; ?></h5>
			  
			  <div class="star-patten">
				<?php $ratings = $value['JumpHostReview']['rating']; ?>
				<?php $disable_rating = 5 - $value['JumpHostReview']['rating'];?>
				<?php for($i=1; $i<=$ratings; $i++) {?>
					<i class="fa fa-star"></i>
				<?php } ?>
				<?php for($i=1; $i<=$disable_rating; $i++) {?>
					<i class="fa fa-star disable"></i>
				<?php } ?>
			 </div>
			  

		  </div>
	  </div>
	  <?php if($i%2==0){ echo "</div><div class='row'>";} ?>
	 <?php  } ?>
 	  </div>
	  <?php } ?>
	 <?php if(!$write_review_button) { ?>
		<a class="btn-primary review" onclick="openReviewPopup(this)" href="javascript:void(0)">WRITE REVIEW</a>
	<?php } ?>
 </div>
 </div>
 </div>
 </div>
 <script>
	 function openReviewPopup($this){
		$("#ReviewPopup").modal('show');
	 }
 </script>
 <div class="modal fade" id="ReviewPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Write Review</h4>
			</div>
			<?php echo $this->Form->create('JumpHostReview',array('url'=>array('plugin'=>false,'controller'=>'jump_hosts','action'=>'write_review',$review_slug),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="">
					<?php echo $this->Form->textarea('JumpHostReview.comment',array('class'=>'form-control','placeholder'=>'Write Review','aria-describedby'=>'sizing-addon2','label'=>false)); ?>
				</div><br>
				<div class="">
				<?php echo $this->Form->input('JumpHostReview.rating',array('class'=>'rating-input','type'=>'number','label'=>false)); ?>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("jump_host_reviews", "Submit", true),array("class"=>"btn btn-primary")); ?>
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