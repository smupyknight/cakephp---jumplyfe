<div class="searchpage"><?php echo $this->element('menu');?></div>
<?php //die('ddd'); ?>
<?php echo $this->Session->flash(); ?>
<div class="search_forms">
	<div class="container">
		<div class="search_forms_inner">
		  <ul class="nav nav-tabs nan-pills" role="tablist">
		    <!--<li role="presentation" class=""><a href="#home" aria-controls="home" role="tab" data-toggle="tab" onclick="comingSoon()" >Flights</a></li>-->
		    <li role="presentation" class=""><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Flights</a></li>
		    <!--<li role="presentation" class="active" onclick="comingSoon()">Flights</li>-->
		    <li role="presentation" class="tabOrder_2"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Hotels</a></li>
		       <li role="presentation"><a href="#JumpRentalsTab" aria-controls="JumpHostTab" role="tab" data-toggle="tab">Jump Rentals</a></li>
		    <!--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab" onclick="comingSoon()">Car Rentals</a></li>-->
		    <li role="presentation"><a href="#carbook" aria-controls="carbook" role="tab" data-toggle="tab">Car Rentals</a></li>
		    <!--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" onclick="comingSoon()">Holiday Activities</a></li>-->
		    <!--<li role="presentation"><a href="javascript:void(0)" aria-controls="settings" role="tab" data-toggle="tab" onclick="comingSoon()">Holiday Activities</a></li>
		    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" onclick="comingSoon()">Holiday Activities</a></li>-->
			<li role="presentation"><a href="javascript:void(0)" aria-controls="messages" role="tab" data-toggle="tab" onclick="comingSoon()">Cruises</a></li>
			<li role="presentation"><a href="#vacations" aria-controls="messages" role="tab" data-toggle="tab">Vacations</a></li>
			<li role="presentation"><a href="#HostJumperTab" aria-controls="HostJumperTab" role="tab" data-toggle="tab">Host Jumpers</a></li>
		  </ul>
			<div class="row">
				<div class="col-md-9">
				
				
				  <!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="home">
				    	<h3>Flights</h3>
				    	
				    		<script type="text/javascript" src="//static.dohop.com/swl/js/iframe.js?wl=Jumplyfe"></script>
				    		<!-- <form class="flight"><div class="btn-group form-group" data-toggle="buttons">
							  <label class="btn btn-primary active">
							    <input type="radio" name="options" id="option1" autocomplete="off" checked> Return
							  </label>
							  <label class="btn btn-primary">
							    <input type="radio" name="options" id="option2" autocomplete="off"> One way
							  </label>
							</div>
				    		<div class="row">
							  <div class="form-group col-sm-6">
							    <label class>Flying From</label>
							    <input type="text" class="form-control" placeholder="City or Airport">
							  </div>
							  <div class="form-group col-sm-6">
							    <label class>Flying to</label>
							    <input type="text" class="form-control" placeholder="City or Airport">
							  </div>
				    		</div>

				    		<div class="row">
							  <div class="form-group col-sm-3 col-xs-6 devicefull">
							    <label class>Departing</label>
							    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
							  </div>
							  <div class="form-group col-sm-3 col-xs-6 devicefull">
							    <label class>Returning</label>
							    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
							  </div>
				    		</div>
				    		<div class="single_room">
				    		<h4>Room 1</h4>
				    		<div class="row">
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Adults(18+)</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Children(0-17)</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
				    		</div>
				    		<div class="row">
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Child 1</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Child 2</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Child 3</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Child 4</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Child 5</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Child 6</label>
							    <select class="form-control">
							    	<option>Age</option>
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
				    		</div>
				    		</div>
				    		<a href="#">Airline age rules opens in a new window <i class="fa fa-external-link"></i></a>
				    		<div class="clearfix"></div>
						  <button type="submit" class="btn btn-default">Search</button>
						</form> -->

				    </div>
				       <div role="tabpanel" class="tab-pane" id="JumpRentalsTab">
				    	<h3>Jump Rentals</h3>
				    	<form method="get" action="<?php echo $this->Html->url(array('plugin'=>false,'controller'=>'jump_hosts','action'=>'jump_hosts')); ?>">
				    		<div class="row">
							  <div class="form-group col-md-9 col-sm-12">
							    <label class>Title</label>
							    <input type="text" class="form-control" name="query" placeholder="Search By Title">
							  </div>
							  
				    		</div>
							<div class="row">
							  <div class="form-group col-md-3 col-sm-4">
							    <label class>Country</label>
							    <?php echo $this->Form->Select('country',$countries,array('name'=>'country','label'=>false,'class'=>'form-control getCountry','empty'=>'Select Country'))?>
							  </div>
							  <div class="form-group col-md-3 col-sm-4">
							    <label class>State</label>
							   <!-- <select class="form-control getState" name="state">
							    	<option>Select State</option>
							    	
							    </select>-->
							      <?php echo $this->Form->Select('state','',array('name'=>'state','label'=>false,'class'=>'form-control getState','empty'=>'Select State'))?>
							  </div>
							  <div class="form-group col-md-3 col-sm-4">
							    <label class>City</label>
							    <!--<select class="form-control getCity" name="city">
							    	<option>Select City</option>
							    	
							    </select>-->
							    <?php echo $this->Form->Select('city','',array('name'=>'city','label'=>false,'class'=>'form-control getCity','empty'=>'Select City'))?>
							  </div>
							</div>
				    		<div class="clearfix"></div>
						  <button type="submit" class="btn btn-default">Search</button>
						</form>

				    </div>
					<div role="tabpanel" class="tab-pane" id="HostJumperTab">
				    	<h3>HostJumper</h3>
				    	<form method="get" action="<?php echo $this->Html->url(array('plugin'=>false,'controller'=>'searches','action'=>'host_jumpers')); ?>">
				    		<div class="row">
							  <div class="form-group col-sm-6">
							    <label class>Name</label>
							    <input type="text" class="form-control" name="name" placeholder="Search By name">
							  </div>
							   <div class="form-group col-sm-6">
							    <label class>Keyword</label>
							    <input type="text" class="form-control" name="keyword" placeholder="Search By Keyword">
							  </div>
				    		</div>
				    		<div class="clearfix"></div>
						  <button type="submit" class="btn btn-default">Search</button>
						</form>
				    </div>
				    <div role="tabpanel" class="tab-pane" id="carbook">
				    	<h3>Book Car</h3>
				    	<div>
				    	<nolayer><iframe SRC="https://book.cartrawler.com/?client=650558&tv=2EF7BD1D" width="100%" height="620" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="yes"></iframe></nolayer>
				    	</div>
				    </div> 
				    <div role="tabpanel" class="tab-pane" id="vacations">
				    	<h3>Vacations</h3>
				    	
				    	
				    	
				    </div>

				    <div role="tabpanel" class="tab-pane" id="profile">
				    	<h3>Hotels</h3>
				    	<ins class="bookingaff" data-aid="893748" data-target_aid="884266" data-prod="sbp" data-width="750" data-height="300">
						    <!-- Anything inside will go away once widget is loaded. -->
						    <a href="//www.booking.com?aid=884266">Booking.com</a>
						</ins>
						<script type="text/javascript">
						    (function(d, sc, u) {
						      var s = d.createElement(sc), p = d.getElementsByTagName(sc)[0];
						      s.type = 'text/javascript';
						      s.async = true;
						      s.src = u + '?v=' + (+new Date());
						      p.parentNode.insertBefore(s,p);
						      })(document, 'script', '//aff.bstatic.com/static/affiliate_base/js/flexiproduct.js');
						</script>
						<!-- <form class="flight" method="get" action="<?php echo $this->Html->url(array('plugin'=>false,'controller'=>'hotels','action'=>'search')); ?>">
						  	<div class="row">
							  	<div class="form-group col-md-8">
									<label class>Going to</label>
									<input type="text" name="city" class="form-control going_to_auto" placeholder="City, State, Country" >
							  	</div>
						  	</div>

				    		<div class="row">
							  <div class="form-group col-md-3 col-sm-5 col-xs-6 devicefull">
							    <label class>Check in</label>
								<input type="text" class="arrivalDate form-control" value="<?php echo $arrivalDate; ?>" name="arrivalDate" placeholder="dd/mm/yyyy">
							  </div>
							  <div class="form-group col-md-3 col-sm-5 col-xs-6 devicefull">
							    <label class>Check out</label>
								<input type="text" class="departureDate form-control" value="<?php echo $departureDate; ?>" name="departureDate" placeholder="dd/mm/yyyy">
							  </div>
							  <div class="form-group col-md-2 col-sm-2 col-xs-4 half_devece">
							    <label class>Rooms</label>
							     <select class="form-control roomCount">
							    	<option value="1">1</option>
							    	<option value="2">2</option>
							    	<option value="3">3</option>
							    	<option value="4">4</option>
							    </select>
							  </div>
				    		</div>
				    		
							
							 <style>
								/*.going_to_auto{
									width:532px;
								}*/
								.tt-menu {
									background-color: #fff;
									border: 1px solid rgba(0, 0, 0, 0.2);
									margin: 10px 0;
									padding: 10px 0;
									width: 100%;
								}
								.tt-menu, .gist {
									text-align: left;
								}
								.tt-query, .tt-hint {
									border: 2px solid #ccc;
									border-radius: 8px;
									font-size: 24px;
									height: 30px;
									line-height: 30px;
									outline: medium none;
									padding: 8px 12px;
									width: 396px;
								}
								.tt-hint{
									display: none !important;
								}
								.twitter-typeahead, .tt-input{
									width:532px;
									background: #fff !important;
								}
								.user_ids_form .label{
									font-size: 14px;
									color: white;
									margin: 1px;
								}
							</style>
							 <div class="roomsLength">
				    		<div class="single_room">
				    		<h4>Room 1</h4>
				    		<div class="row">
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Adults(18+)</label>
							    <select class="form-control" name="rooms[1][adult]">
							    	<option value="1">1</option>
							    	<option value="2">2</option>
							    	<option value="3">3</option>
							    	<option value="4">4</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-4 half_devece">
							    <label class>Children(0-17)</label>
							    <select class="form-control" onchange="child_count(this)" name="rooms[1][children]" data-room_number="1">
							    	<option value="0">0</option>
							    	<option value="1">1</option>
							    	<option value="2">2</option>
							    	<option value="3">3</option>
							    	<option value="4">4</option>
							    </select>
							  </div>
				    		</div>
				    		<div class="row">
								<div class="childAge_Div">
							  
								</div>
				    		</div>
				    		</div>
							</div>
				    		
				    		<div class="clearfix"></div>
						  <button type="submit" class="btn btn-default">Search</button>
						  <?php //echo $this->Form->end(); ?>
						</form> -->
				    </div>
					
					<script>
						$(document).ready(function(){
							$('.roomCount').change(function(){
								var roomselected = $(this).val();
								var get_room_length  = $('.roomsLength .single_room').length;
								var value = parseInt(roomselected);
								var room_length = parseInt(get_room_length);
								if(value == room_length){
									
								}
								else if(value > room_length){
									var i = value - room_length;
									var j;
									for(j=1;j<=i;j++){
										room_length++;
										var html = '<div class="single_room"><h4>Room '+room_length+'</h4><div class="row"><div class="form-group col-xs-2 half_devece"><label class>Adults(18+)</label><select class="form-control" name="rooms['+room_length+'][adult]"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></div> <div class="form-group col-xs-2 half_devece"><label class>Children(0-17)</label><select class="form-control" onchange="child_count(this)" data-room_number="'+room_length+'" name="rooms['+room_length+'][children]"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></div></div><div class="row"><div class="childAge_Div"></div></div></div>';
										$('.roomsLength').append(html);
									}
								}
								else{
									var i = room_length - value;
									var j;
									for(j=1;j<=i;j++){
										$('.roomsLength .single_room').last().remove();
									}
								}
							});
						});
						
						function child_count($this){
							var childSelected = $($this).val();
							var roomCount = $($this).attr('data-room_number');
							$($this).closest('.single_room').find('.childAge_Div').html('');
							var j;
							var age = new Array;
							for(j=1;j<=17;j++){
								age[j] = '<option value="'+j+'">'+j+'</option>';
							}
							var i;
							for(i=1;i<=childSelected;i++){
								var html ='<div class="form-group col-xs-2 half_devece"><label>Child '+i+'</label><select class="form-control" name="rooms['+roomCount+'][child_age]['+i+']"><option>Age</option>'+age+'</select></div>'; 
								$($this).closest('.single_room').find('.childAge_Div').append(html);
							}
						}
					</script>
				    <div role="tabpanel" class="tab-pane" id="messages">
				    	<h3>Car Rental</h3>
				    	<form class="flight">
				    		<div class="row">
							  <div class="form-group col-sm-6">
							    <label class>Picking up</label>
							    <input type="text" class="form-control" placeholder="City, Airport or Address">
							  </div>
							  <div class="form-group col-sm-6">
							    <label class>Dropping off</label>
							    <input type="text" class="form-control" placeholder="Same as Pick-Up">
							  </div>
							</div>

				    		<div class="row">
							  <div class="form-group col-sm-3 col-xs-4 devicefull">
							    <label class>Pick up date</label>
							    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
							  </div>
							  <div class="form-group col-xs-2 half_devece">
							    <label class>&nbsp;</label>
							    <select class="form-control">
							    	<option>10.00</option>
							    	<option>20.00</option>
							    	<option>30.00</option>
							    	<option>40.00</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-3 col-xs-4 devicefull">
							    <label class>Drop off date</label>
							    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
							  </div>
							  <div class="form-group col-xs-2 half_devece">
							    <label class>&nbsp;</label>
							    <select class="form-control">
							    	<option>10.00</option>
							    	<option>20.00</option>
							    	<option>30.00</option>
							    	<option>40.00</option>
							    </select>
							  </div>
							  <div class="form-group col-sm-2 col-xs-6 half_devece">
							    <label class>Age</label>
							     <select class="form-control">
							    	<option>1</option>
							    	<option>2</option>
							    	<option>3</option>
							    	<option>4</option>
							    </select>
							  </div>
				    		</div>
						  <button type="submit" class="btn btn-default">Search</button>
						</form>
				    </div>
				    <div role="tabpanel" class="tab-pane" id="settings">
				    	<h3>Holiday Activities</h3>
				    	<form class="flight">
							  <div class="form-group">
							    <label class>Destination</label>
							    <input type="text" class="form-control" placeholder="City">
							  </div>

				    		<div class="row">
							  <div class="form-group col-sm-3 col-xs-4 devicefull">
							    <label class>From</label>
							    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
							  </div>
							  <div class="form-group col-sm-3 col-xs-4 devicefull">
							    <label class>To</label>
							    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
							  </div>
				    		</div>
						  <button type="submit" class="btn btn-default">Search</button>
						</form>
				    </div>
				  </div>

			  </div>
			  <div class="col-md-3">
			  	<h3>Weather</h3>
			  	<?php if(isset($weather_info) && !empty($weather_info)){ ?>
			  	<div class="weather">
			  		<h3><?php echo $weather_info['city'];?>, <span><?php echo $weather_info['country'];?></span></h3>
			  		<p><strong><?php echo $weather_info['clouds'];?></strong></p>
			  		<p><?php echo $weather_info['description'];?></p>
			  		<span><?php if($weather_info['temp']){ echo round($weather_info['temp'],1); } ?>&deg; F</span>
			  		<?php echo $this->Html->image($weather_info['icon'].'.png',array('class'=>'pull-right'));?>
			  		<!--<img src="img/01d.png" class="pull-right"> -->
			  		<div class="clearfix"></div>
			  	</div>
			  	<?php } else { ?>
					<p>Sorry! Server error occurred so we can't provide weather information to you (Please Login to see your nearby weather).</p>
				<?php } ?>
			  </div>

		  </div>
		  <?php echo $this->element('advertisement_bottom');  ?>
	    </div>
	</div>
</div>
<script>
function comingSoon(){
	//return true;
	$('#comingSoonPopup').modal('show');
	setTimeout(function(){
								
		$('.tabOrder_2 a').trigger('click');

	},1);
}
</script>
<div class="modal fade" id="comingSoonPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body">
				<h3 class="comingSoon">Coming Soon</h3>
	
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	var user = "<?php echo authComponent::user('id'); ?>";
	if(user == '')
	{
		openLoginPopup();
	}
	$('.getCountry').change(function(e){
		var country_iso_code = $(this).val();
		if($(this).val() != '')
		{
			$.ajax({
				type:"post",
				url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'get_states'));?>",
				data:{'country_iso_code':country_iso_code},
				dataType :"json",
				success:function(data) {
					$(".getState").html('');
					$(".getState").html('<option value="">Select State</option>');
					$.each(data.states,function(key,value){
						var html = '<option value="'+key+'">'+value+'</option>';
						$(".getState").append(html);
					})
				}
			});
		}
	});
	$('.getState').change(function(e){
		var state_iso_code = $(this).val();
		if($(this).val() != '')
		{
			$.ajax({
				type:"post",
				url:"<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'get_cities'));?>",
				data:{'state_iso_code':state_iso_code},
				dataType :"json",
				success:function(data1) {
					$(".getCity").html('');
					$(".getCity").html('<option value="">Select City</option>');
					$.each(data1.cities,function(key,value){
						var html = '<option value="'+key+'">'+value+'</option>';
						$(".getCity").append(html);
					})
				}
			});
		}
	});
});
</script>
<script>
							 $(function(){
								
								setTimeout(function(){
									
									$('.tabOrder_2 a').trigger('click');
									$('.going_to_auto').focus();
	
								},10);
																
								
								$(".arrivalDate").datepicker({
									todayBtn:  1,
									startDate: "today",
									autoclose: true,
								}).on('changeDate', function (selected) {
										var minDate = new Date(selected.date.valueOf());
										$('.departureDate').datepicker('setStartDate', minDate);
										$(".departureDate").datepicker("update", minDate);
									});

								$(".departureDate").datepicker({
									autoclose: true,
									}).on('changeDate', function (selected) {
										var minDate = new Date(selected.date.valueOf());
										$('.startdate').datepicker('setEndDate', minDate);	
								});
									
								var source = '<?php echo Router::url(array('plugin'=>false,'controller'=>'searches','action'=>'getCitiesAuto')); ?>';
								var bestPictures = new Bloodhound({
									datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
									queryTokenizer: Bloodhound.tokenizers.whitespace,
									//prefetch: '../data/films/post_1960.json',
									remote: {
										url: source+'/%QUERY',
										wildcard: '%QUERY',
									},
								});

								$('.going_to_auto').typeahead(null, {
									display: 'full_name',
									source: bestPictures,
								});
								
								$('.going_to_auto').on('typeahead:selected', function(evt, item) {
									
									
								});	
														
							 });
							 </script>
