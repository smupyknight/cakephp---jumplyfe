<!--<?php if($eliteoffer_record){ ?>
	<?php foreach($eliteoffer_record as $key => $value) { ?>
		<?php $total_price = $value['JumpHost']['price'] * $value['EliteOffer']['valid_days']; ?>
		<?php $off_percent = $value['JumpHost']['price'] / $total_price *100; ?>
		<div class="grand">
			<div class="price_tag"><?php echo round($off_percent); ?>% Off</div>
			<?php 
			$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
			$file_name		=	$value['JumpHost']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
			$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',470,348,base64_encode($file_path),$file_name),true);
			echo $this->Html->image($image_url,array('class'=>'img-responsive'));
			}
			else 
			{
			echo $this->Html->image('main_profile.png',array('class'=>'img-responsive'));
			}
			?>
			<h3 class="grand_title"><?php echo $value['EliteOffer']['title']; ?></h3>
			<div class="grand_right">
				<p><?php echo $value['EliteOffer']['description']; ?></p>
				<div class="star-patten">
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star disable"></i>
				</div>
				<div class="destination">Destination :<span><?php echo $value['EliteOffer']['city'];?></span>
					<h4>price :  </h4>
				</div>
				<div class="duration">Duration :<span> <?php echo $value['EliteOffer']['valid_days'];?> days</span>
					<h4><span class="rate"> <?php echo '$'.$total_price; ?> </span> <?php echo '$'.round($value['JumpHost']['price']);?> </h4>
				</div>
				<div class="clearfix"></div>
				<a class="btn btn-primary btn-block" href="#">Book</a>
			</div>
		</div>
	<?php } ?>
<?php } ?> -->