<?php if(isset($JumpGallery_record) && !empty($JumpGallery_record)){ ?>
<div class="pg-posts-list">
<?php foreach($JumpGallery_record as $key => $value){ ?>
<div class="col-md-6 post-item">
	<div class="profile">
		<div class="top_title">
			<a href="#"><?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$image_name 	= 	$value['JumpGallery']['User']['User']['image'];
			if($image_name !='') {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$image_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['JumpGallery']['User']['User']['slug'],'class'=>'img-responsive img_radius profile_img'));
			}
			else 
			{
				echo $this->Html->image('main_profile.png',array('url'=>'/'.$value['JumpGallery']['User']['User']['slug'],'class'=>'img-responsive img_radius profile_img'));
			} 
			?><?php $full_name = $value['JumpGallery']['User']['User']['firstname'].' '.$value['JumpGallery']['User']['User']['lastname'];?><?php echo $this->Html->link($this->Text->truncate($full_name,15),'/'.$value['JumpGallery']['User']['User']['slug']); ?>
			</a>
			<div class="date"><?php echo date('d M y',strtotime($value['JumpGallery']['created']));?></div>
		</div>
		<div id="myElement_<?php echo $key; ?>"></div>
		<?php 
		if($value['JumpGallery']['media_type'] == 'Image') { 
			$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
			$image_name 	= 	$value['JumpGallery']['image'];
			if($image_name !='') {
				$box_image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',0,0,base64_encode($file_path),$image_name),true);
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',470,309,base64_encode($file_path),$image_name),true);
				$image = $this->Html->image($image_url,array('class'=>'img-responsive profile_img'));
				echo $this->Html->link($image,$box_image_url,array('class'=>'fancybox','escape'=>false));
			}else {
				echo $this->Html->image('no_image.png',array('class'=>'img-responsive profile_img'));
			}
		} 
		else if($value['JumpGallery']['media_type'] == 'Video') { 
			if($value['JumpGallery']['video_type'] == 'Upload'){ ?>
				<?php //echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>
				<script type="text/javascript">
					$(document).ready(function(){
						jwplayer("myElement_<?php echo $key; ?>").setup({
							file: '<?php echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>',
							height: 280,
							width: "100%"
						});
					});
				</script>
			<?php 
			} else {
				echo $value['JumpGallery']['video'];
			}
		
		} ?>
		
		<div class="bottom_title">
			<a href="javascript:void(0)"><?php echo $this->Text->truncate($value['JumpGallery']['media_title'],50); ?></a>
		</div>
	</div>
</div>	
<?php } ?>
</div>
<?php echo $this->Paginator->options(array("url"=>array("pluign"=>$this->params["plugin"],"controller"=>$this->params["controller"],"action"=>$this->params["action"],"?"=>array("slug"=>$slug)))); ?>
<?php echo $this->Paginator->next(''); ?>
<?php } else { ?>
	<div class ="no-record">No Photo and Video uploaded in this jump</div>
<?php } ?>

<script>
$(function(){
	//var $container = $('#posts-list');
	$('.pg-posts-list').infinitescroll({
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
