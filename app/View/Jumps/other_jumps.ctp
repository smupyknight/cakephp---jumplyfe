<div class="searchpage">
<?php echo $this->element('menu');?>
</div>
<div class="right_profile">
  <div class="container">
		<form method="get" class="other_jumps" action="<?php echo $this->here; ?>">
			<input type="text" placeholder ="Enter Jump Name" name="name" value="<?php echo $jump_name; ?>" class="search" />
	    </form>
		<h3 class="title">Jumps</h3>
          <div class="row">
			<?php  if($jump_record){ ?>
			<?php foreach($jump_record as $key => $value){ ?>
            <div class="col-md-4 col-sm-6 col-xs-6 device_full">
                <div class="profile">
                  <div class="top_title">
                  <a href="#">
					<?php
						$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
						$image_name 	= 	$value['User']['image'];
						if($image_name !='') {
							$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$image_name),true);
							echo $this->Html->image($image_url,array('class'=>'img_radius'));
						}else {
							echo $this->Html->image('johnsmall.png',array('class'=>'img_radius'));
						}
						?>
					<?php //echo $this->html->image('johndoe.png',array('class'=>''))?>
				<?php $full_name = ucfirst($value['User']['firstname']).' '.ucfirst($value['User']['lastname']); ?><?php echo $this->Html->link($this->Text->truncate($full_name,11),array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']));?></a>
                  <div class="date"><?php if($value['Jump']['jump_start_date'] > '2000-01-01') { echo date('d M y',strtotime($value['Jump']['jump_start_date'])); } ?></div>
                </div>
				<?php
						$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
						$image_name 	= 	$value['Jump']['image'];
						if($image_name !='') {
							$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',470,309,base64_encode($file_path),$image_name),true);
							$images =  $this->Html->image($image_url,array('class'=>'img-responsive profile_img'));
							 echo $this->Html->link($images,array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']),array('escape'=>false));
						}else {
							echo $this->Html->image('no_image.png',array('url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']),'class'=>'img-responsive profile_img'));
						}
						?>
				<?php //echo $this->html->image('02_main_profile_v4_03.jpg',array('class'=>'img-responsive profile_img'))?>
                <div class="bottom_title">
				<?php $title = $this->Text->truncate($value['Jump']['title'],20); ?>
                  <?php echo $this->Html->link($title,array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']));?>
                </div>
                </div>
            </div>
            <?php } ?>
			<?php } else {?>
			<div class="no-record">No Record Found</div>
             <?php } ?>
         
        </div>
</div>
