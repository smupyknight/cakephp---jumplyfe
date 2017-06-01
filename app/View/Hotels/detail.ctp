<script>
$(document).ready(function(){
		replaceAreInfo();
	
});
function replaceAreInfo()
{
	$('.areaInfoContent').html($('.areaInfoContent').text());
}
</script>
<div class="searchpage">
<?php echo $this->element('menu');?>

<div class="right_profile job">
  <div class="container">
    <div class="row">
      <div class="detail_titlebar">
      <div class="col-md-8">
        <h3 class="title"><?php echo $hotel->HotelSummary->name; ?></h3>
		<?php $hotelAddress = $hotel->HotelSummary->address1.', '.$hotel->HotelSummary->city.', '.$hotel->HotelSummary->countryCode;  ?>
        <p><?php echo $hotelAddress; ?>, <?php echo isset($hotel->HotelSummary->postalCode)?$hotel->HotelSummary->postalCode:''; ?> </p>
      </div>
     <!-- <div class="col-md-4 text-right">
        <h3 class="block"><span>USD.<?php echo $hotel->HotelSummary->highRate; ?></span> <a href="#">USD.<?php echo $hotel->HotelSummary->lowRate; ?></a></h3>
        <a href="#">Best Price Guarantee</a> <a class="btn-primary review" href="#">Book</a>
      </div> -->
      </div>
    </div>

      
		<div class="row">
        <div class="col-md-7">
            <div class="slider side_slider">
              <div class="carousel slide" data-ride="carousel" id="carousel">
               <div class="carousel-inner" role="listbox">
				<?php foreach($hotel->HotelImages->HotelImage as $key => $value) { ?>
				<?php 	//pr($value); ?>
					
                <div class="item <?php echo $key==0?'active':'';?>">
                 <img style="width:100%; height:auto;" src="<?php echo $value->url; ?>">
                </div>
				<?php } ?>
				<?php //die; ?>
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
		<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
		<script>
		function initialize(){
		 var myLatlng = new google.maps.LatLng(<?php echo $hotel->HotelSummary->latitude?>,<?php echo $hotel->HotelSummary->longitude?>);
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
		 var myLatlng = new google.maps.LatLng(<?php echo $hotel->HotelSummary->latitude?>,<?php echo $hotel->HotelSummary->longitude?>);
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
            <div class="col-md-5">
              <div class="price_section">
                <h3 class="title">Very Good</h3>
                   <p class="guests">
                    <big>92%</big><br>
                    of guests recommend
                   </p>
                   <p class="guests">
                    <big><?php echo $hotel->HotelSummary->tripAdvisorRating?>/5</big><br>
                    Expedia Guest Rating
                   </p>
					<div class ="clearfix"></div>
                   <div class="tripadvisor">
                       <?php echo $this->Html->image('ta4.png');?>
                      <P>TripAdvisor Traveller Rating <BR>Based on <?php echo $hotel->HotelSummary->tripAdvisorReviewCount?> reviews</P>
                   </div>
                <div class="map" id="map" style="width:100%; height:100px;"></div>
            </div>
           </div>
        </div>
        <div class="Choose_room">
          <div class="Choose_room_title">
            <h3>Choose your room</h3>
            
          </div>
         <!-- <form class="form-inline">
            <div class="form-group">
              <label for="exampleInputName2">Check in</label>
              <input type="date" class="form-control" placeholder="Select Date">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Check out</label>
              <input type="date" class="form-control" placeholder="Select Date">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Rooms</label>
              <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Adults</label>
              <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Children</label>
              <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form> -->
          <div class="table-responsive">
            <table class="table table-bordered">
              <tr>
                <th>Room Type</th>
                <th>Max</th>
                <th>Options</th>
                <th>Avg rate per night</th>
                <th></th>
              </tr>
			  
			  <?php if($hotelRooms->{'@size'} == 1) {
				$roomsDe[0] =   $hotelRooms->HotelRoomResponse; 
				} else { 
					
				$roomsDe = $hotelRooms->HotelRoomResponse;
				
			}
				?>
			  <?php foreach($roomsDe as $key => $value) { ?>
				  
              <tr>
                <td>
                  <?php if(isset($value->RoomImages)) { ?>
				  <?php if(isset($value->RoomImages->RoomImage->url)) { ?>
				   <img src="<?php echo $value->RoomImages->RoomImage->url; ?>">
				  <?php } else { ?>
				  <img src="<?php echo $value->RoomImages->RoomImage[0]->url; ?>">
				  <?php } ?>
				  <?php } ?>
                  <div class="room_type">
                    <h4><?php echo $value->roomTypeDescription ?>
                      
                    </h4>
                    <p>
					<?php if(isset($value->BedTypes->BedType->description)) {  $BedTypeId = $value->BedTypes->BedType->{'@id'}?>
					<strong><?php echo $value->BedTypes->BedType->description; ?> </strong>
					<?php } else { $BedTypeId = $value->BedTypes->BedType[0]->{'@id'} ?>
					<strong><?php echo $value->BedTypes->BedType[0]->description; ?> </strong>
					<?php } ?>
					
                    (Extra beds available: Crib, Rollaway bed)</p>
                    
                  </div>
                </td>
                <td>
				<?php
				$rateOccupancyPerRoom = $value->rateOccupancyPerRoom;
					for($i=1; $i<=$rateOccupancyPerRoom; $i++) { ?>
							<i class="fa fa-user"></i>
				<?php } ?>
				<br>
				<?php
				$quotedOccupancy = $value->quotedOccupancy;
					for($j=1; $j<=$quotedOccupancy; $j++) { ?>
							<i  style="font-size: 12px" class="fa fa-user"></i>
				<?php } ?>
                </td>
                <td>
                  <ul class="blog_style">
					  <?php 
						if(isset($value->ValueAdds))
						{
							if($value->ValueAdds->{'@size'} == 1)
							{
								echo '<li>'.$value->ValueAdds->ValueAdd->description.'</li>';
							}
							else
							{
								foreach($value->ValueAdds->ValueAdd as $va => $vav)
								{
									echo '<li>'.$vav->description.'</li>';
								}
							}
						}	
					  ?>
                  </ul>
                </td>
                <td>
                  <div class="search_right">
                 
                  <h3>USD <?php echo $value->RateInfos->RateInfo->ChargeableRateInfo->{'@averageRate'}; ?></h3>
                  <h3 class="block">USD <?php echo $value->RateInfos->RateInfo->ChargeableRateInfo->{'@averageBaseRate'}; ?></h3>
                  
                </div>
              </td>
              <td>
			<?php if(isset($value->RateInfos->RateInfo->RoomGroup->Room->rateKey))
			{
				$rateKey = $value->RateInfos->RateInfo->RoomGroup->Room->rateKey;

			}
			else
			{
				$rateKey = $value->RateInfos->RateInfo->RoomGroup->Room[0]->rateKey;
			}	
       $cancellationPolicy = $value->RateInfos->RateInfo->cancellationPolicy;
			?>
			  <a href="<?php echo $this->webroot.'hotels/book/'.$hotelId.'/'.$value->roomTypeCode.'?rateCode='.$value->rateCode.'&chargeableRate='.$value->RateInfos->RateInfo->ChargeableRateInfo->{'@total'}.'&customerSessionId='.$hotelRooms->customerSessionId.'&BedTypeId='.$BedTypeId.'&arrivalDate='.$hotelRooms->arrivalDate.'&departureDate='.$hotelRooms->departureDate.'&rateKey='.$rateKey.'&hotelPhoto='.$hotelPhotoUrl.'&hotelName='.$hotel->HotelSummary->name.'&hotelAddress='.$hotelAddress.'&cancellationPolicy='.$cancellationPolicy; ?>" class="btn btn-deposite">Book</a>
			  
			 <!-- <?php echo $this->Html->link('Book',array('controller'=>'hotels','action'=>'book',$hotelId,$value->roomTypeCode.'?rateCode='.$value->rateCode.'&chargeableRate='.$value->RateInfos->RateInfo->ChargeableRateInfo->{'@total'}.'&customerSessionId='.$hotelRooms->customerSessionId.'&BedTypeId='.$BedTypeId.'&arrivalDate='.$hotelRooms->arrivalDate.'&departureDate='.$hotelRooms->departureDate.'&rateKey='.$value->RateInfos->RateInfo->RoomGroup->Room->rateKey.'&hotelPhoto='.$hotelPhotoUrl),array('class' => 'btn btn-deposite')); ?> -->
			  <br>It only takes 2 minutes</td>
              </tr>
			  <?php } ?>
             
            </table>
          </div>
        </div>
        <div class="five_star">
          <div class="row">
            <div class="col-md-6 col-sm-6">
             <div class="map" id="map2" style="width:100%; height:460px;"></div>
              <a href="#">Expand Map</a>
            </div>
            <div class="col-md-6 col-sm-6">
			<?php if(isset($hotel->HotelDetails->propertyInformation)) { ?>
              <h4>Property Information</h4>
             
              <p><?php echo $hotel->HotelDetails->propertyInformation; ?></p>
			 <?php } ?>
              <h5>Area Information</h5>
              <p class="areaInfoContent"><?php echo $hotel->HotelDetails->areaInformation; ?></p>
              <h5>Hotel Policy</h5>
              <p><?php echo $hotel->HotelDetails->hotelPolicy; ?></p>
              
            </div>
          </div>
        </div>
        <div class="five_star">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <h3 class="title">Hotel Amenities</h3>
              <h5>Hotel Amenities</h5>
              <ul class="blog_style">
			         <?php foreach($hotel->PropertyAmenities->PropertyAmenity as $key => $value) { ?>
                <li><?php echo $value->amenity; ?></li>
              <?php } ?>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6">
              <h3 class="title">Hotel Policies</h3>
              <h5>Check-in</h5>
      			  <?php if(isset($hotel->HotelDetails->checkInTime)) { ?>
                   <span>Check-in time is <?php echo $hotel->HotelDetails->checkInTime; ?></span>
      			  <?php } ?>
                    <p><?php echo $hotel->HotelDetails->checkInInstructions; ?></p>
      			  <?php if(isset($hotel->HotelDetails->checkOutTime)) { ?>
                    <h5>Check-out</h5>
                    <p>Check-out time is <?php echo $hotel->HotelDetails->checkOutTime; ?></p>
      			  <?php } ?>
              <div class="clearfix"></div>
              <div class="policies">
      			  <?php if(isset($hotel->HotelDetails->knowBeforeYouGoDescription)) { ?>
                    <h5>Also</h5>
                    <p><?php echo $hotel->HotelDetails->knowBeforeYouGoDescription; ?></p>
      			  <?php } ?>
              </div>
              <div class="clearfix"></div>
                    <h5>Location</h5> 
      			  <p><?php echo $hotel->HotelDetails->locationDescription; ?></p>
                    <h5>Dinning</h5> 
      			  <p><?php echo $hotel->HotelDetails->diningDescription; ?></p>
             
            </div>
          </div>
              
        </div>
     </div>
        
  </div>
</div>
</div>

