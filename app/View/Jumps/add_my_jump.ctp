<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
        <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
		<div class="col-md-9 col-sm-9">
			<h3 class="title">Add Jump</h3>
			<?php echo $this->Form->create('Jump',array('class'=>'form-horizontal ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
				<span class="ajax_message"></span>	
			</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.title', __('Title:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->text("Jump.title",array('class'=>'form-control jump_title_focus','label'=>false,'placeholder'=>'Enter Jump Title','required')); ?>
					</div>
				</div>
			
				
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.description', __('Description:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("Jump.description",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Description','required')); ?>
					</div>
				</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.image', __('Image:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->file("Jump.image",array('class'=>'check_size','data-max_size' => Configure::read("Site.max_upload_image_size"),'label'=>false,'placeholder'=>'Enter Jump Description','required')); ?>
					</div>
				</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.address_line_1', __('Address Line 1:',true),array('class'=>'col-sm-4 control-label','required')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("Jump.address_line_1",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Address Line 1')); ?>
					</div>
				</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.address_line_2', __('Address Line 2:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("Jump.address_line_2",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Jump Address Line 2')); ?>
					</div>
				</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.country_code', __('Country:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("Jump.country_code",$countries,array('class'=>'form-control country','empty'=>'Select Country','label'=>false,'required')); ?>
					</div>
				</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.state_code', __('State:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("Jump.state_code",'',array('class'=>'form-control states','empty'=>'Select State','label'=>false)); ?>
					</div>
				</div>
			
				<div class="form-group">
					<?php echo $this->Form->label('Jump.city_code', __('City:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("Jump.city_code",'',array('class'=>'form-control cities','empty'=>'Select City','label'=>false)); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $this->Form->label('Jump.zipcode', __('Zipcode:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("Jump.zipcode",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Zipcode Here')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $this->Form->label('Jump.jump_start_date', __('Jump Start Date:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->text("Jump.jump_start_date",array('class'=>'form-control jump_start_datepicker','label'=>false,'placeholder'=>'Select Jump Start Date','readonly'=>true)); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $this->Form->label('Jump.jump_end_date', __('Jump End Date:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->text("Jump.jump_end_date",array('class'=>'form-control jump_end_datepicker','label'=>false,'placeholder'=>'Select Jump End Date','readonly'=>true)); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $this->Form->label('Jump.show_map', __('Show Map:',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->Select("Jump.show_map",array('Yes'=>'Yes','No'=>'No'),array('class'=>'form-control showMap','label'=>false,'empty'=>false,'value'=>$show_map)); ?>
					</div>
				</div>
				<div class="Show_Google_Map">
					<div class="form-group">
						<?php echo $this->Form->input("Jump.latitude",array('value'=>$city_latitude,'class'=>'','id'=>'lat','type'=>'hidden')); ?>
						<?php echo $this->Form->input("Jump.longitude",array('value'=>$city_longitude,'class'=>'','id'=>'lng','type'=>'hidden')); ?>	
						<?php echo $this->Form->label('Jump.google_map', __('Google Map Address:*',true),array('class'=>'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						  <?php echo $this->Form->input("Jump.google_map",array('class'=>'form-control',"id"=>"currentlocation","name"=>"currentlocation","data-placeholder"=>"City Map Location",'label'=>false,'required')); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"></label>
						<div class="col-sm-8">
							<div id="mapCanvas" class="add_my_jump_map"></div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="set_btn">
							<?php echo $this->Form->button(__d("jumps", "Submit <i class='fa fa-arrow-circle-right'></i>", true),array("class"=>"btn btn-info pull-right")); ?>
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
	$('.jump_title_focus').focus();
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
	
	
	$("input.check_size").change(function () {
		
		var max_size = $(this).attr('data-max_size');
		var show_size = Math.round(max_size / 1024);
		if ($(this).val() !== "") {
			
			var file = $('.check_size')[0].files[0];
			var file_size = file.size / 1024;
			if(file_size > max_size)
			{
				
				$(this).closest("form").find('.ajax_alert').slideDown().find('.ajax_message').text('Image must be less than '+show_size+'MB');
				return false;
			}
			else
			{
				$(this).closest("form").find('.ajax_alert').slideUp();
				return true;
			}
		}
	});
	
	var value = $(this).val();
	if(value == 'Yes')
	{
		$('.Show_Google_Map').show();
		
	}
	else
	{
		$('.Show_Google_Map').hide();
	}
	
	$(".showMap").change(function(){
		var value = $(this).val();
		if(value == 'Yes')
		{
			$('.Show_Google_Map').show();
			
		}
		else
		{
			$('.Show_Google_Map').hide();
		}
		
	});
	
	$(".jump_start_datepicker").datepicker({
		format: "mm/dd/yyyy",
		endDate: "today",
		todayBtn:  1,
		autoclose: true,
	}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('.jump_end_datepicker').datepicker('setStartDate', minDate);
			$(".jump_end_datepicker").datepicker("update", minDate);
		});

	$(".jump_end_datepicker").datepicker({
		format: "mm/dd/yyyy",
		endDate: "today",
		autoclose: true,
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('.startdate').datepicker('setEndDate', minDate);	
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
