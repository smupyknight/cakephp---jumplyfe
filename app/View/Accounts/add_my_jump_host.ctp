<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
        <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
		<div class="col-md-9 col-sm-9">
          <h3 class="title">Add Jump Rentals</h3>
		<?php echo $this->Form->create('JumpHost',array('class'=>'form-horizontal ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
				<span class="ajax_message"></span>	
			</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.title', __('Title:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->text("JumpHost.title",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Rental Title','required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.description', __('Description:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("JumpHost.description",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Rental Description','required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.home_type_id', __('Home Type:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("JumpHost.home_type_id",$home_type,array('class'=>'form-control','empty'=>'Select Home Type','label'=>false,'required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.room_type_id', __('Room Type:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("JumpHost.room_type_id",$room_type,array('class'=>'form-control','empty'=>'Select Room Type','label'=>false,'required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.accommodates', __('Accommodations:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpHost.accommodates",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Rental Accommodations','required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.address_line_1', __('Address Line 1:',true),array('class'=>'col-sm-4 control-label','required')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("JumpHost.address_line_1",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Rental Address Line 1')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.address_line_2', __('Address Line 2:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("JumpHost.address_line_2",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Rental Address Line 2')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.country_code', __('Country:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("JumpHost.country_code",$countries,array('class'=>'form-control country','empty'=>'Select Country','label'=>false,'required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.state_code', __('State:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("JumpHost.state_code",'',array('class'=>'form-control states','empty'=>'Select State','label'=>false,'required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.city_code', __('City:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("JumpHost.city_code",'',array('class'=>'form-control cities','empty'=>'Select City','label'=>false,'required')); ?>
					</div>
				</div>
			
			<div class="form-group">
					<?php echo $this->Form->label('JumpHost.zipcode', __('Zipcode:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpHost.zipcode",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Zipcode Here')); ?>
					</div>
				</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.bedrooms', __('Number of Bedrooms:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpHost.bedrooms",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Number of Bedrooms')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.beds', __('Number of Beds:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpHost.beds",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Number of Beds')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.bathrooms', __('Number of Bathrooms:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpHost.bathrooms",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Number of Bathrooms')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.amenities', __('Amenities:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					 <?php echo $this->Form->select("JumpHost.amenities",$amenitie_type,array('class'=>'select2 input-lg','empty'=>false,'multiple'=>'multiple')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.price', __('Price:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpHost.price",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Rental Price','required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.check_in_time', __('Check in Time:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->text("JumpHost.check_in_time",array('class'=>'form-control timepicker1','label'=>false,'placeholder'=>'Select Check In Time','required','readonly'=>true)); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.check_in_insturctions', __('Check in Instructions:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("JumpHost.check_in_instructions",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Check In Instructions')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->label('JumpHost.check_out_time', __('Check out Time:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->text("JumpHost.check_out_time",array('class'=>'form-control timepicker1','label'=>false,'placeholder'=>'Select Check Out Time','required','readonly'=>true)); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<?php echo $this->Form->input("JumpHost.latitude",array('value'=>$city_latitude,'class'=>'','id'=>'lat','type'=>'hidden')); ?>
					<?php echo $this->Form->input("JumpHost.longitude",array('value'=>$city_longitude,'class'=>'','id'=>'lng','type'=>'hidden')); ?>	
					<?php echo $this->Form->label('JumpHost.google_map', __('Google Map Address:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpHost.google_map",array('class'=>'form-control',"id"=>"currentlocation","name"=>"currentlocation","data-placeholder"=>"City Map Location",'label'=>false,'required')); ?>
					</div>
				</div>
			
			
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<div id="mapCanvas" class="add_my_jump_map"></div>
					</div>
				</div>
			
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<div class="set_btn">
						<?php echo $this->Form->button(__d("jump_hosts", "Submit <i class='fa fa-arrow-circle-right'></i>", true),array("class"=>"btn btn-info pull-right")); ?>
					</div>
				</div>
			</div>
			<?php echo $this->Form->end();?>
        </div>
     </div>
  </div>
</div>
<script>
$(document).ready(function() {
	$( ".timepicker1" ).timepicker();	
	$(".select2").select2();
	$('.country').change(function(e){
		var country_iso_code = $(this).val();
		if($(this).val() != '')
		{
			$.ajax({
				type:"post",
				url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'get_states'));?>",
				data:{'country_iso_code':country_iso_code},
				dataType :"json",
				success:function(data) {
					$(".states").html('');
					$(".states").html('<option value="">Select State</option>');
					$.each(data.states,function(key,value){
						var html = '<option value="'+key+'">'+value+'</option>';
						$(".states").append(html);
					})
				}
			});
		}
	});
	$('.states').change(function(e){
		var state_iso_code = $(this).val();
		if($(this).val() != '')
		{
			$.ajax({
				type:"post",
				url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'get_cities'));?>",
				data:{'state_iso_code':state_iso_code},
				dataType :"json",
				success:function(data1) {
					$(".cities").html('');
					$(".cities").html('<option value="">Select City</option>');
					$.each(data1.cities,function(key,value){
						var html = '<option value="'+key+'">'+value+'</option>';
						$(".cities").append(html);
					})
				}
			});
		}
	});
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  //document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
	$('#lat').val(latLng.lat());
	$('#lng').val(latLng.lng());
}

function updateMarkerAddress(str) {
 
  $('#currentlocation').val(str);
  
}
function initialize() {
		  
		    var latLng = new google.maps.LatLng(<?php echo $city_latitude;?>,<?php echo $city_longitude;?>);
		  
        var mapOptions = {
          center: latLng,
          zoom: 7,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
		
        var map = new google.maps.Map(document.getElementById('mapCanvas'),
          mapOptions);

        var input = document.getElementById('currentlocation');
		
        var autocomplete = new google.maps.places.Autocomplete(input);

        //autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map,
		  position: latLng,
          title: 'Drag to change',
          map: map,
          draggable: true
        });
         updateMarkerPosition(latLng);
         geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {

    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          infowindow.close();
          var place = autocomplete.getPlace();
		 
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(10);  // Why 17? Because it looks good.
          }

          var image = new google.maps.MarkerImage(
              place.icon,
              new google.maps.Size(71, 71),
              new google.maps.Point(0, 0),
              new google.maps.Point(17, 34),
              new google.maps.Size(35, 35));
          marker.setIcon(image);
          marker.setPosition(place.geometry.location);
           updateMarkerPosition(place.geometry.location);
       //  geocodePosition(place.geometry.location);
          var address = '';
         

         // infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        //  infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          google.maps.event.addDomListener(radioButton, 'click', function() {
            autocomplete.setTypes(types);
          });
        }
      }
      google.maps.event.addDomListener(window, 'load', initialize);
</script>
