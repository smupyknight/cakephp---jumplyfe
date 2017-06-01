<div class="right_profile blog">
  <div class="container">
     <div class="row">
        <div class="col-md-12">
          <h3 class="title"><?php echo $totalHotels;?> hotels in <?php echo $city_name;?></h3>
        <div class="listing_ajax">
		<?php if(isset($hotelList) && $hotelList) { ?>
		  <?php foreach($hotelList as $key => $value) { ?>
			 
          <div class="search_block">
		  <?php echo $this->html->image($value->image_url,array('class' => 'img-responsive',"data-hotel_id"=>$value->hotelId,"onclick"=>"goToHotelURL(this)")); ?>
               
                <div class="blog_heading">
                <div class="search_left">
                  <h5><a href="javaScript:void(0)" data-hotel_id=<?php echo $value->hotelId; ?> onclick="goToHotelURL(this)"><?php echo $value->name; ?>, <?php echo $value->locationDescription ?></a></h5>
                  <div class="star-patten">
					 <?php if(isset($value->tripAdvisorRating)) { ?>
					  <?php $ratings = round($value->tripAdvisorRating); ?>
						<?php $disable_rating = 5 - $ratings;?>
						<?php for($i=1; $i<=$ratings; $i++) {?>
							<i class="fa fa-star"></i>
						<?php } ?>
						<?php for($i=1; $i<=$disable_rating; $i++) { ?>
							<i class="fa fa-star disable"></i>
						<?php } ?>
					<?php } ?>
					  </div>
                  <address><?php echo $value->address1; ?>, <?php echo $value->city; ?>, <?php echo $value->countryCode; ?><br></address>
                  <span><?php echo $value->shortDescription ?></span>
                </div>

                <div class="search_right">
                  <h5>
				  <?php if(isset($value->tripAdvisorRating)) { ?>
					<?php
						$avg_rating = round($value->tripAdvisorRating);
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
				  <span>(<?php echo round($value->tripAdvisorRating) ?>/5)</span>
				  <?php } ?>
				  </h5>
				  <?php if(isset($value->tripAdvisorReviewCount)) { ?>
                  <?php echo $value->tripAdvisorReviewCount ?> Reviews </i>
				  <?php } ?>
                  
                  <h3 class="block">USD. <?php echo $value->highRate; ?></h3>
                  <h3><a href="#">USD. <?php echo $value->lowRate; ?></a></h3>
                  <span>Rate Per night</span>
                </div>

            </div>
          </div>
		  <?php } ?>
		   <?php } ?>
         

         <div class="blog_button">
          <a  class="btn-newpost loadMoreHotels" data-cacheKey="<?php echo $cacheKey; ?>" data-cacheLocation="<?php echo $cacheLocation; ?>" onclick="loadMoreResults(this)" href="JavaScript:">Load More</a>
         </div>
		</div>
		 
          
        
  </div>
</div>
</div>
</div>
<script>
var counter = 2;
var arrivalDate = '<?php echo $arrivalDate; ?>';
var departureDate = '<?php echo $departureDate; ?>';
var customerSessionId = '<?php echo $customerSessionId; ?>';
var cacheKey = '<?php echo $cacheKey; ?>';
var cacheLocation = '<?php echo $cacheLocation; ?>';
function goToHotelURL($this)
{
	var hotelId = $($this).attr('data-hotel_id');
	window.location.href = SiteUrl+'hotels/detail/'+hotelId+'?arrivalDate='+arrivalDate+'&departureDate='+departureDate+'&cacheKey='+cacheKey+'&cacheLocation='+cacheLocation+'&customerSessionId='+customerSessionId;
}
function loadMoreResults($this)
{
	$($this).removeAttr('onclick').addClass('disabled').text('Please Wait...');
	var cacheKey = $($this).attr('data-cacheKey');
	var cacheLocation = $($this).attr('data-cacheLocation');
	$.get(SiteUrl+'hotels/loadmore?cacheKey='+cacheKey+'&cacheLocation='+cacheLocation+'&customerSessionId='+customerSessionId,function(data){
		$($this).closest('.blog_button').remove();
		$('.listing_ajax').append(data);
	})
	
}



$(document).ready(function(){
	$('.addMore').click(function(){
		var html = '<div class="roomsDiv"><h6>Room '+counter+'</h6><div class="form-group"><div class=""><select name="rooms['+counter+'][adult]"><option value="1">1 Adult</option><option value="2">2 Adult</option><option value="3">3 Adult</option></select> <select name="rooms['+counter+'][children]"><option value="0">No Children</option><option value="1">1 Children</option><option value="2">2 Children</option><option value="3">3 Children</option></select><?php echo $this->Html->link("Remove",'javascript:void(0)',array('class'=>'pull-right','onclick'=>'removeDiv(this)'));?></div></div></div>'
		$('.form_room_list').append(html);
		window.counter = parseInt(counter)+1;
	});	
	
	
	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
			$('.loadMoreHotels').trigger('click');
			$('.loadMoreHotels').closest('.blog_button').remove();
		}
	});
	
});
function removeDiv($this){
	$($this).closest('.roomsDiv').remove();
}
</script>
