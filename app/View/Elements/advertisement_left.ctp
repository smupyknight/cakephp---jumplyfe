<?php $ad_left = $this->requestAction(
   array('controller' => 'welcomes', 'action' => 'advertisement'),
        array('pass' => array('left'))
      ); 
$value = $ad_left;
   ?>
<?php if(isset($ad_left) && !empty($ad_left)) { ?>
		<?php foreach($ad_left as $key =>$value) { ?>
		<?php  if(isset($value['Advertisement']['image_ad']) && !empty($value['Advertisement']['image_ad']) && ($value['Advertisement']['ad_type'] == 1)){
			echo '<a href="'.$value['Advertisement']['image_ad_url'].'" target="_BLANK">';
			echo $this->Html->image(IMAGE_PATH.$value['Advertisement']['image_ad'],array('class'=>'img-responsive')); 
			echo '</a>';
		}
		else if(isset($value['Advertisement']['script_ad']) && !empty($value['Advertisement']['script_ad']) && ($value['Advertisement']['ad_type'] == 2)){
				echo $value['Advertisement']['script_ad'];	
		}
		else if(isset($value['Advertisement']['video_ad']) && !empty($value['Advertisement']['video_ad']) && ($value['Advertisement']['ad_type'] == 3)){
			echo $value['Advertisement']['video_ad'];	
		} ?>
		<?php } ?>		
	<?php } ?>
</div>
