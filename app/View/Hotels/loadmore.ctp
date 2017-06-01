<?php if(isset($hotelList) && $hotelList) { ?>
<?php foreach($hotelList as $key => $value) { ?>
<div class="search_block">
<?php echo $this->html->image($value->image_url,array('class' => 'img-responsive')); ?>
   
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
	  <address><?php echo $value->address1; ?>, <?php echo $value->city; ?>, <?php echo $value->countryCode; ?><br> </address>
	 
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
	  <a href="#"><?php echo $value->tripAdvisorReviewCount ?> Reviews</a>
	  <?php } ?>
	  
	  <h3 class="block">USD. <?php echo $value->highRate; ?></h3>
	  <h3><a href="#">USD. <?php echo $value->lowRate; ?></a></h3>
	  <span>Rate Per night</span>
	</div>

</div>
</div>
<?php } ?>
<?php } ?>
<?php if(isset($moreResultsAvailable) && $moreResultsAvailable == 1) { ?>
 <div class="blog_button">
          <!--<a class="btn btn-primary" href="#">PREVIEW</a>-->
          <a  class="btn-newpost loadMoreHotels" data-cacheKey="<?php echo $cacheKey; ?>" data-cacheLocation="<?php echo $cacheLocation; ?>" onclick="loadMoreResults(this)" href="JavaScript:">Load More</a>
         </div>
<?php } else { ?>
<div class="no-record">No More Hotels Available...</div>
<?php } ?>
