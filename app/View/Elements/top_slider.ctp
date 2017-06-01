<?php 
	$data = $this->requestAction(array('plugin'=>false,'controller'=>'welcomes','action'=>'getBannerVideo'));
?>
<?php if(isset($data) && !empty($data)) { 
		
		if($data['Banner']['video_type'] == 'Embeded'){	
			
			echo '<div class="bannerIframe">'.$data['Banner']['video'].'</div>';
		
		}
		else
		{ ?>
			<div class="carousel">
				<video autoplay controls loop poster="https://s3-us-west-2.amazonaws.com/s.cdpn.io/4273/polina.jpg" class="bgvid">
					<source src="<?php echo IMAGE_PATH.$data['Banner']['video']; ?>" type="video/webm">
					<source src="<?php echo IMAGE_PATH.$data['Banner']['video']; ?>" type="video/mp4">
				</video>
				<div class="carousel-caption">
					<?php echo $this->Html->link('<strong>Start</strong> a jump <i class="fa fa-play"></i>',array('plugin'=>false,'controller'=>'searches','action'=>'index'),array('class'=>'btn btn-primary','escape'=>false));?>
				</div>
			</div>

<?php 	}	?>
<?php 	} else { ?>
<?php $image_data = $this->requestAction(array('plugin'=>false,'controller'=>'welcomes','action'=>'getBannerImage')); ?>
	<?php if(isset($image_data) && !empty($image_data)) { ?>
	<div class="carousel container">
		<div class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<?php foreach($image_data as $key => $value) {  ?>

				<div class="item <?php echo $key == 0 ?'active':''; ?>">
					<?php echo $this->Html->image(IMAGE_PATH.$value['Banner']['image'],array('class'=>'img-responsive','alt'=>0)); ?>
					<div class="carousel-caption">
					<?php echo $this->Html->link('<strong>Start</strong> a jump <i class="fa fa-play"></i>',array('plugin'=>false,'controller'=>'searches','action'=>'index'),array('class'=>'btn btn-primary','escape'=>false));?>
				</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>	
		
<?php } ?>
<?php } ?>
