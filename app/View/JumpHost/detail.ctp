<div class="searchpage">
<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
  <div class="container">
    <div class="row">
	<?php echo $this->Session->flash(); ?>
      <div class="detail_titlebar">
      <div class="col-md-8">
		
        <h3 class="title"><?php echo $this->Text->truncate($booked_jump_record['JumpHost']['title'],40); ?> 
			<?php $ratings = $avg_rating; ?>
			<?php $disable_rating = 5 - $avg_rating;?>
			
			<span class="star-patten">
			<?php for($i=1; $i<=$ratings; $i++) {?>
			
				<i class="fa fa-star"></i>
				
			<?php } ?>
			<?php for($i=1; $i<=$disable_rating; $i++) {?>
			
				<i class="fa fa-star disable"></i>
				
			<?php } ?></span>
		</h3>
        <p>
			<?php if(!empty($booked_jump_record['JumpHost']['address_line_1'])){ echo $booked_jump_record['JumpHost']['address_line_1'].','; } ?>
			<?php if(!empty($booked_jump_record['JumpHost']['address_line_2'])){ echo $booked_jump_record['JumpHost']['address_line_2'].','; }?>
			<?php echo $booked_jump_record['JumpHost']['city']; ?>,
			<?php echo $booked_jump_record['JumpHost']['country_code']; ?>
			<?php if(!empty($booked_jump_record['JumpHost']['zipcode'])){ echo ', '.$booked_jump_record['JumpHost']['zipcode']; } ?>
			<?php  ?>
		</p>
      </div>
      <div class="col-md-4 text-right">
		<?php //$totl_price = $elite_record['JumpHost']['price'] * $elite_record['EliteOffer']['valid_days'];  ?>
        <h3 class="block">Price: <a href="#"><?php echo round($booked_jump_record['JumpHost']['convertAmount']); ?> <?php echo $this->Session->read('Currency.default'); ?></a></h3>
		 <a href="#">Best Price Guarantee</a> <a href="javaScript:void(0)" class="btn-primary review" onclick="openBookingPopup(this)" data-slug="<?php echo $booked_jump_record['JumpHost']['slug']; ?>">Book</a>
      </div>
      </div>
    </div>
	
      
    <div class="row">
		<?php if(isset($galleries) && !empty($galleries)) { ?>
        <div class="col-md-8 col-sm-8">
            <div class="slider side_slider">
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
        </div>
		<?php } else { ?>
		<div class="col-md-8 col-sm-8">
            <div class="slider side_slider">
				<?php echo $this->Html->image(JUMP_HOST_IMAGE_PATH.'no-jump-host-image.jpg');?> 
			</div>
		</div>
		<?php } ?>
            <div class="col-md-4">
              <div class="price_section">
                <h3 class="title">
                <?php
					if($avg_rating >= 4)
					{
						echo "Very Good";
						
					} 
					else if($avg_rating >=3 && $avg_rating < 4 )
					{
						
						echo "Good";
					}
					else if($avg_rating >=2 && $avg_rating < 3)
					{
						echo "Bad";
					}
					else if($avg_rating >0 && $avg_rating < 2)
					{
						echo "Very Bad";
					}
					else
					{
						echo "No Rated";
					}
					
					?>
                </h3>
                   <p class="guests">
					  <?php $rating_per =  $avg_rating / 5 * 100; ?> 
                    <big><?php echo $rating_per; ?> %</big><br>
                    of guests recommend
                   </p>
                   <p class="guests">
                    <big><?php echo $avg_rating; ?>/5</big><br>
                    Expedia Guest Rating
                   </p>
                   
               <div class="map" id="map" style="width:100%; height:100px;"></div>
            </div>
           </div>
        </div>
        
	
        <div class="five_star">
			<p><?php echo $booked_jump_record['JumpHost']['description']; ?></p>
          <div class="row">
            <div class="col-md-8 col-sm-8">
           
			 <div class="map" id="map2" style="width:100%; height:350px;"></div>
            
            </div>
            <div class="col-md-4 col-sm-4">
			<?php if($home_type['Home']['title']) { ?>
              <h5>Home Type</h5>
              <p><?php echo $home_type['Home']['title'] ?></p>
			  <?php } ?>
			  <?php if($room_type['Room']['title']) { ?>
              <h5>Room Type</h5>
              <p><?php echo $room_type['Room']['title'] ?></p>
			  <?php } ?>
              <h5>Accommodates</h5>
              <p><?php echo $booked_jump_record['JumpHost']['accommodates'];?></p>
            </div>
          </div>
        </div>
        <div class="five_star">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <h3 class="title">Amenities</h3>
			  <?php if($most_common) { ?>
              <h5>Most Common</h5>
              <ul class="blog_style">
			  <?php foreach($most_common as $key => $value){ ?>
                <li><?php echo $value['Amenity']['title']; ?></li>
			   <?php } ?>
              </ul>
			  <?php } ?>
			  <?php if($extras) { ?>
			  <div class="clearfix"></div>
			  <h5>Extras</h5>
              <ul class="blog_style">
				<?php foreach($extras as $key1 => $value1){ ?>
					<li><?php echo $value1['Amenity']['title']; ?></li>
				<?php } ?>
              </ul>
              <?php } ?>
              
			  <?php if($special_features) { ?>
				 <div class="clearfix"></div>
			  <h5>Special Features</h5>
              <ul class="blog_style">
                
				<?php foreach($special_features as $key2 => $value2){ ?>
					<li><?php echo $value2['Amenity']['title']; ?></li>
				<?php } ?>
              </ul>
              <?php } ?>
            </div>
            <div class="col-md-6 col-sm-6">
              <h3 class="title">Hotel Policies</h3>
              <h5>Check-in</h5>
              <span>Check-in time starts at <?php echo date('g:i a',strtotime($booked_jump_record['JumpHost']['check_in_time'])); ?></span>
              <p>Special check-in instructions:<br>
				<?php 
					if($booked_jump_record['JumpHost']['check_in_instructions']) 
					{ 
						echo $booked_jump_record['JumpHost']['check_in_instructions']; 
					} 
					else
					{ 
						echo '---'; 
					} 
				?>
			  </p>
              <h5>Check-out</h5>
              <p>Check-out time is <?php echo date('g:i a',strtotime($booked_jump_record['JumpHost']['check_out_time'])); ?></p>
            </div>
          </div>
              
        </div>
		
		<h4 id="reviews_section"><?php echo $this->Html->link('REVIEW',array('controller'=>'jump_hosts','action'=>'jump_hosts'),array('class'=>'about_title'));?></h4> 
		<?php if(isset($review_record) && !empty($review_record)) { ?>
	    <div class="row">
		<?php foreach($review_record as $key =>$value) {?>
		  <div class="col-md-6 col-sm-6">
			  <div class="wages">
				<?php
				$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
				$file_name		=	$value['User']['User']['image'];
				if($file_name && file_exists($file_path . $file_name))
				{
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',70,70,base64_encode($file_path),$file_name),true);
					echo $this->Html->image($image_url,array('class'=>'img-responsive img_radius'));
				}
				else 
				{
					echo $this->Html->image('wages.png',array('class'=>'img-responsive img_radius'));
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
		  <?php  } ?> 
		  </div>
		 <?php } else {?>
		  <div class="row">
			<div class="col-md-12 col-sm-12">
			  <div class="no-record">
					No reviews posted on this Jump Rental
			  </div>
			</div>  
		  </div>
		 
		 <?php } ?>
		 
	   <?php if(!$write_review_button) { ?>
		<a class="btn-primary review" onclick="openReviewPopup(this)" href="javascript:void(0)">WRITE REVIEW</a>
	   <?php } ?>
     </div>
     </div>
  </div>
  <div class="modal fade" id="HotelBookPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Jump Rental</h4>
			</div>
			<?php echo $this->Form->create('CartJumpHost',array('url'=>array('plugin'=>false,'controller'=>'jump_hosts','action'=>'jump_host_booking',$booked_jump_record['JumpHost']['slug']),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php echo $this->Form->input('CartJumpHost.check_in',array('class'=>'form-control check_inDate','placeholder'=>'Check in','aria-describedby'=>'sizing-addon2','label'=>false)); ?>
				</div>
				<br>
				<div class="input-group">
					<?php echo $this->Form->input('CartJumpHost.check_out',array('class'=>'form-control check_outDate','placeholder'=>'Check out','aria-describedby'=>'sizing-addon2','label'=>false)); ?>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("cart_jump_hosts", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
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
  

	$(".check_inDate").datepicker({
        todayBtn:  1,
        startDate: "today",
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.check_outDate').datepicker('setStartDate', minDate);
        $(".check_outDate").datepicker("update", minDate);
    });

    $(".check_outDate").datepicker({
		autoclose: true,
		
		}).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('.check_inDate').datepicker('setEndDate', minDate);
        });
							
});

function openBookingPopup($this)
{
	var slug = $($this).attr('data-slug');
	if(slug != ""){
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"jump_hosts",'action' => 'check_user_balance')); ?>",
			data:{'slug':slug},
			dataType:"json",
			success:function(data){
				if(data.success == true){
					$("#HotelBookPopup").modal('show');
				}
				else if(data.error_type == 'insufficient_balance')
				{
					var notyData = [];
					notyData.message = data.message;
					notyData.type = 'warning';
					nofifyMessage(notyData);
					//alert(data.message); return false;
				}	
			}	
		});
	}
}
</script>
 <script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
			<script>
			function initialize(){
			 var myLatlng = new google.maps.LatLng(<?php echo $booked_jump_record['JumpHost']['latitude']?>,<?php echo $booked_jump_record['JumpHost']['longitude']?>);
			 var myOptions = {
					 zoom: 12,
					 center: myLatlng,
					 mapTypeId: google.maps.MapTypeId.ROADMAP
					 }
				  map = new google.maps.Map(document.getElementById("map"), myOptions);
				  var marker = new google.maps.Marker({
					  position: myLatlng, 
					  map: map,
				  title:"Fast marker"
				 });
			} 
			google.maps.event.addDomListener(window,'load', initialize);

			function initialize2(){
			 var myLatlng = new google.maps.LatLng(<?php echo $booked_jump_record['JumpHost']['latitude']?>,<?php echo $booked_jump_record['JumpHost']['longitude']?>);
			 var myOptions = {
					 zoom: 12,
					 center: myLatlng,
					 mapTypeId: google.maps.MapTypeId.ROADMAP
					 }
				  map = new google.maps.Map(document.getElementById("map2"), myOptions);
				  var marker = new google.maps.Marker({
					  position: myLatlng, 
					  map: map,
				  title:"Fast marker"
				 });
			} 
			google.maps.event.addDomListener(window,'load', initialize2);
			</script>
