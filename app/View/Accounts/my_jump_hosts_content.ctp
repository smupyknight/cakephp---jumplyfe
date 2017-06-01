<?php if(isset($my_jump_host_record) && !empty($my_jump_host_record)){ ?>
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<?php foreach($my_jump_host_record as $key =>$value){ ?>
<div class="pg-post-list">
	<div class="myprofile post-item">
		<div class="top_title">
			<h3><?php echo $this->Text->truncate($value['JumpHost']['title'],30); ?><span><?php echo $this->Text->truncate($value['JumpHost']['city'],15); ?>, <?php echo $this->Text->truncate($value['JumpHost']['country'],15); ?></span></h3>
			<?php echo $this->Html->link('View Detail',array('plugin'=>false,'controller'=>'jump_hosts','action'=>'detail',$value['JumpHost']['slug']),array('class'=>'btn btn-primary text-upper'));  ?> <?php echo $this->Html->link('Booking History',array('plugin'=>false,'controller'=>'jump_hosts','action'=>'booking_history',$value['JumpHost']['slug']),array('class'=>'btn btn-primary text-upper'));  ?>
			<div class="clearfix"></div>
		</div>
		<div class="row post-item-detail">
			<div class="col-md-3 col-sm-5">
				<?php
					$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
					$file_name		=	$value['JumpHost']['image'];
					if($file_name && file_exists($file_path . $file_name)) 
					{
						$box_image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',0,0,base64_encode($file_path),$file_name),true);
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',375,375,base64_encode($file_path),$file_name),true);
						$image = $this->Html->image($image_url,array('class'=>'img-responsive JumpRental_Image'));
						echo $this->Html->link($image,$box_image_url,array('class'=>'fancybox','escape'=>false));
						
					}
					else 
					{
						echo $this->Html->image(JUMP_HOST_IMAGE_PATH.'no_image.png',array('class'=>'img-responsive JumpRental_Image'));
					}
				?>
			</div>
			<div class="col-md-4 col-sm-7">
				<ul class="rental_price_list">
					<li><span>Price :</span><?php echo round($value['JumpHost']['convertAmount']).' '.$this->Session->read('Currency.default') ; ?></li>
					<?php if($value['JumpHost']['is_booked'] == 'Yes') { ?>
						<li><span>STATUS :</span>Booked</li>
						<li><span>Check in :</span><?php echo date('M d Y',strtotime($value['JumpHost']['latest_check_in_date_time'])); ?></li>
						<li><span>Check out :</span><?php echo date('M d Y',strtotime($value['JumpHost']['latest_check_out_date_time'])); ?></li>
					<?php } else {?>
						<li><span>STATUS :</span>Not Booked</li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-md-2 col-sm-5">
				<div class="jumps_btns row">
					<div class="col-sm-12 col-xs-3 devicefull">
						<?php echo $this->Html->link('Edit',array('plugin'=>false,'controller'=>'accounts','action'=>'edit_my_jump_host',$value['JumpHost']['slug']),array('class'=>'btn btn-primary')); ?><br>
					</div>
					<div class="col-sm-12 col-xs-3 devicefull">
						<?php echo $this->Html->link('Gallery',array('plugin'=>false,'controller'=>'accounts','action'=>'my_jump_gallery',$value['JumpHost']['slug']),array('class'=>'btn btn-primary')); ?>
					</div>
				</div>
			</div>	
			<div class="col-md-3 col-sm-7">
				<div class="map_<?php echo $value['JumpHost']['id']; ?> iframe"></div>
				<script>
				$(document).ready(function (){
					 var myLatlng = new google.maps.LatLng(<?php echo $value['JumpHost']['latitude']; ?>,<?php echo $value['JumpHost']['longitude']; ?>);
					 var myOptions = {
						 zoom: 12,
						 center: myLatlng,
						 mapTypeId: google.maps.MapTypeId.ROADMAP
						 }
					  map = new google.maps.Map($('.map_<?php echo $value['JumpHost']['id']; ?>')[0], myOptions);
					  var marker = new google.maps.Marker({
						  position: myLatlng, 
						  map: map,
					  title:"Fast marker"
					 });
				});
				</script>
			</div>	
		</div>
		<div class="clearfix"></div>
	</div>
	<?php } ?>
</div> 
<?php echo $this->Paginator->next(''); ?>
<?php } else {?>
	<div class="no-record">No Jump Rental Found</div>
<?php } ?>
          
<script>
$(function(){
	//var $container = $('#posts-list');
	$('.pg-post-list').infinitescroll({
		navSelector  : '.next',    // selector for the paged navigation 
		nextSelector : '.next a',  // selector for the NEXT link (to page 2)
		itemSelector : '.post-item',     // selector for all items you'll retrieve
		debug		 	: true,
		dataType	 	: 'html',
		loading: {
		  finishedMsg: 'No more posts to load. All Hail Star Wars God!',
		  img: '<?php echo $this->webroot; ?>img/spinner.gif'
		}
	});
});
</script>
  
