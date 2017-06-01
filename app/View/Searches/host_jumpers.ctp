<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
		      <div class="jumper_search">
				<form method="get"  action="<?php echo $this->here; ?>">
				<h6>JUMPERS
				<input type="text" placeholder ="Search" name="name" value="<?php echo $name; ?>" class="search pull-right" /></h6>
				</form>
			<div class="row">
			<?php //pr($users); die; ?>
			<?php if(isset($users) && !empty($users)) { ?>
			<?php foreach($users as $key => $value) {?>
              <div class="col-md-4 col-sm-6 col-xs-6 device_full">
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
                <div class="people_name"><h4 class="user_name"><?php $full_name = $value['User']['firstname'].' '.$value['User']['lastname']; ?><?php echo $this->Html->link($full_name,'/'.$value['User']['slug']);?></h4>
                  <p><?php echo $value['User']['city'];  ?> <?php echo $value['User']['country'];  ?></p></div>
               </div>
             </div>
			 <?php }  ?>
			 <?php } else { ?>
				<div class="no-record">No Host Jumpers Found</div>
			 <?php } ?>
			</div>

  
            <ul class="pagination">
              <!-- <li>
                <a href="#" aria-label="Previous">
                  <span class="fa fa-caret-left"></span>
                </a>
              </li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">6</a></li>
              <li><a href="#">7</a></li>
              <li><a href="#">8</a></li>

              <li>
                <a href="#" aria-label="Next">
                  <span class="fa fa-caret-right"></span>
                </a>
              </li> -->
			  <li>
				<?php echo $this->element('pagination'); ?>
			  </li>
            </ul>
       
          </div>
        </div> 
		</div>
	</div>
</div>
		
