<?php  if(isset($jump_record) && !empty($jump_record)){ ?>
<div class="pg-posts-list">
<?php foreach($jump_record as $key => $value){ ?>
<div class="col-md-6 post-item">
	<div class="profile">
		<div class="top_title">
			<a href="javascript:void(0)">
				<?php
					$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
					$image_name 	= 	$value['Jump']['logo']['User']['image'];
					if($image_name !='') {
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$image_name),true);
						echo $this->Html->image($image_url,array('class'=>'img_radius'));
					}else {
						echo $this->Html->image('johnsmall.png',array('class'=>'img_radius'));
					}
					?>
				<?php $full_name = ucfirst($value['Jump']['logo']['User']['firstname']).' '.ucfirst($value['Jump']['logo']['User']['lastname']);?><?php echo $this->Html->link($this->Text->truncate($full_name,16),array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']));?>
			</a>
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
				echo $this->Html->image(JUMP_HOST_IMAGE_PATH.'no_image.png',array('url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']),'class'=>'img-responsive profile_img'));
			}
		?>
		<div class="bottom_title">
			<?php $title = $this->Text->truncate($value['Jump']['title'],20); ?>
			<?php echo $this->Html->link($title,array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']));?>
		</div>
	</div>
</div>
<?php } ?>
</div>
<?php echo $this->Paginator->options(array("url"=>array("pluign"=>$this->params["plugin"],"controller"=>$this->params["controller"],"action"=>$this->params["action"],"?"=>array("slug"=>$slug)))); ?>
<?php echo $this->Paginator->next(''); ?>
<?php } else {?>
<div class="no-record">No Record Found</div>
<?php } ?>
<script>
$(function(){
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
