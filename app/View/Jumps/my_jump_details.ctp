<div class="searchpage"><?php echo $this->element('menu');?></div>

<div class="jump_details bgcolor">
	<div class="container">
		<?php echo $this->Session->Flash();?>
		<div class="details_content">
          <div class="row">
            <div class="col-md-6 col-sm-6">
				<?php
					$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
					$file_name		=	$jumpRecord['Jump']['image'];
					if($file_name && file_exists($file_path . $file_name)) {
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',600,600,base64_encode($file_path),$file_name),true);
						echo $this->Html->image($image_url,array('class'=>'img-responsive'));
					}
					else 
					{
						echo $this->Html->image('main_profile.png',array('class'=>'img-responsive'));
					}
				?>
            </div>
            <div class="col-md-6 col-sm-6">
              <h3 class="title"><?php echo $jumpRecord['Jump']['title']; ?></h3>
              <p><?php echo $jumpRecord['Jump']['description']; ?></p>
            </div>
          </div>
        </div>
        <div class="five_star">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				 <div class="map jump_detail_map" id="map"></div>
			</div>
		</div>
		</div>
		<div class="clearfix"></div>
		<?php if(isset($jumpHost_record) && !empty($jumpHost_record)) { ?>
		<div class="five_star">
			<h3>Jump Host Detail</h3>
          <div class="row">
            <div class="col-md-4 col-sm-4">
				<?php
					$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
					$file_name		=	$jumpHost_record['JumpHost']['image'];
					if($file_name && file_exists($file_path . $file_name)) {
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',350,350,base64_encode($file_path),$file_name),true);
						echo $this->Html->image($image_url,array('class'=>'img-responsive'));
					}
					else 
					{
						echo $this->Html->image('main_profile.png',array('class'=>'img-responsive'));
					}
				?>
            </div>
            <div class="col-md-5 col-sm-5">
              <h5><?php echo $jumpHost_record['JumpHost']['title']; ?></h5>
              <p><?php echo $jumpHost_record['JumpHost']['description']; ?></p>
            </div>
          </div>
        </div>
		<?php } ?>

		<?php if(isset($HostJumperBooking_record) && !empty($HostJumperBooking_record)) { ?>
		<div class="clearfix"></div>
		
		<h3>Host Jumper Detail <?php echo $this->Html->link('Cancel This Host Jumper Booking',array('plugin'=>false,'controller'=>'jumps','action'=>'cancel_host_jumper',$HostJumperBooking_record['HostJumperBooking']['id']),array('class'=>'cancel_button btn btn-danger text-upper pull-right')) ?></h3>
          <div class="row">
            <div class="col-md-7 col-sm-7">
              <h4 class="title"><?php echo $HostJumperBooking_record['HostJumper']['User']['firstname'] .''.$HostJumperBooking_record['HostJumper']['User']['lastname'] ?></h4>
			  
              <p><?php echo $HostJumperBooking_record['HostJumper']['User']['address']; ?>, <?php echo $HostJumperBooking_record['HostJumper']['User']['city']; ?>, <?php echo $HostJumperBooking_record['HostJumper']['User']['country']; ?></p>
			  <h4>Booking Date: <?php echo $HostJumperBooking_record['HostJumperBooking']['booking_for_date']; ?></h4>
			  <h4>Price: $<?php echo $HostJumperBooking_record['HostJumperBooking']['paid_amount']; ?></h4>
			  <p><?php echo $HostJumperBooking_record['HostJumper']['User']['host_jumper_about_me']; ?></p>
            </div>
			<div class="col-md-5 col-sm-5">
				<?php
					$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
					$file_name		=	$HostJumperBooking_record['HostJumper']['User']['image'];
					if($file_name && file_exists($file_path . $file_name)) {
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',350,350,base64_encode($file_path),$file_name),true);
						echo $this->Html->image($image_url,array('class'=>'userimage'));
					}
					else 
					{
						echo $this->Html->image('main_profile.png',array('class'=>'userimage'));
					}
				?>
            </div>
          </div>
       <div class="five_star"> </div>
		<?php } ?>

		<?php if(isset($host_jumpers) && !empty($host_jumpers)) { ?>
		<div class="clearfix"></div>
		<div class="five_star jumper_host">
			<h3>Book a Host Jumper</h3>
			<div class="row">
				<?php foreach($host_jumpers as $key => $value) {?>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="person_detail">
						<?php
						$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
						$file_name		=	$value['User']['image'];
						if($file_name && file_exists($file_path . $file_name)) {
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,80,base64_encode($file_path),$file_name),true);
							echo $this->Html->image($image_url,array('class'=>'img_radius'));
						}
						else 
						{
							echo $this->Html->image('user1.png',array('class'=>'img_radius'));
						}
						?>
						<div class="people_name"><h4 class="user_name"><?php $full_name = $value['User']['firstname'].' '.$value['User']['lastname']; ?><?php echo $this->Html->link($full_name,array('controller'=>'host_jumpers','action'=>'index',$value['User']['slug']));?></h4>
						<p><?php echo $value['User']['city'];  ?> <?php echo $value['User']['country'];  ?></p></div>
					</div>
				</div>
				<?php }  ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script>
function initialize(){
 var myLatlng = new google.maps.LatLng(<?php echo $jumpRecord['Jump']['latitude']?>,<?php echo $jumpRecord['Jump']['longitude']?>);
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
</script>
