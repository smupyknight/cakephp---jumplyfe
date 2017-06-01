<?php echo $this->element('top_slider'); ?>
<div class="Recent_Jumps">
	<div class="container">
		<h1>Recent Jumps</h1>
		<div class="row">
			<?php if(isset($recent_jumps) && !empty($recent_jumps)) {?>
			<?php foreach($recent_jumps as $key => $value){ ?>
			<div class="col-md-4 col-sm-4">
				<div class="recent front_iframe_video">
					<?php
						/*$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
						$file_name		=	$value['Jump']['image'];
						if($file_name && file_exists($file_path . $file_name)) {
							$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',375,425,base64_encode($file_path),$file_name),true);
							echo $this->Html->image($image_url,array('url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']),'class'=>'img-responsive'));
						}
						else 
						{
							echo $this->Html->image('no_image.png',array('url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']),'class'=>'img-responsive'));
						}*/
					?> 
					<div id="myElement_<?php echo $key; ?>"></div>
					<?php 
					if($value['JumpGallery']['media_type'] == 'Image') { 
						$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
						$image_name 	= 	$value['JumpGallery']['image'];
						if($image_name !='') {
							$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',375,425,base64_encode($file_path),$image_name),true);
							echo $this->Html->image($image_url,array('class'=>'img-responsive','url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug'])));
						}else {
							echo $this->Html->image('no_image.png',array('class'=>'img-responsive','url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug'])));
						}
					} 
					else if($value['JumpGallery']['media_type'] == 'Video') { 
						if($value['JumpGallery']['video_type'] == 'Upload'){ ?>
							<?php //echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>
							<script type="text/javascript">
								$(document).ready(function(){
									jwplayer("myElement_<?php echo $key; ?>").setup({
										file: '<?php echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>'
										
									});
								});
							</script>
						<?php 
						} else {
							
							echo $value['JumpGallery']['video'];
						}
					
					} ?>
					<div class="title">
						<p><?php echo $this->Html->link($this->text->truncate($value['JumpGallery']['media_title'],40),array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug'])); ?></p>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php } else { ?>
				<div class="no-record">No Jumps Found</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="top_feature">
	<div class="container">
		<h1>Top Features</h1>
		<?php if(isset($top_features) && !empty($top_features)) { ?>
			<div class="row">
			<?php foreach($top_features as $key =>$value) { ?>
					<?php 
						if($key > 2)
						{
							echo '<div class="col-md-6 col-sm-6">';
						}
						else
						{
							echo '<div class="col-md-4 col-sm-4">';
						}
					?>
					
						<div class="feature_section">
							<?php
								$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
								$file_name		=	$value['TopFeature']['image'];
								if($file_name && file_exists($file_path . $file_name))
								{
									$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',375,425,base64_encode($file_path),$file_name),true);
									echo $this->Html->image($image_url,array('class'=>'img-responsive'));
								}
								else 
								{
									echo $this->Html->image('main_profile.png',array('class'=>'img-responsive'));
								}
							?>
							<p><i><?php echo $this->text->truncate($value['TopFeature']['title'],28); ?></i><br>
							<?php echo $this->text->truncate($value['TopFeature']['description'],85); ?></p> 
							<?php echo $this->Html->link('Know More','javascript:void(0)',array('onclick'=>'getTopFeatureContent(this)','class'=>'btn-primary','data-slug'=>$value['TopFeature']['slug']));?>
						</div>
					</div>
			<?php } ?>
			</div>
		<?php } else {  ?>
			<div class="no-record">No Top Features Found</div>	
		<?php } ?>		
	</div>
</div>
<script>
function getTopFeatureContent($this){
	
	var slug = $($this).attr('data-slug');
	if(slug != ''){
		
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"welcomes",'action' => 'showTopFeatureRecord')); ?>",
			data:{'slug':slug},
			dataType:"json",
			success:function(data){
				if(data.success){
					if(data.image != '')
					{
						var image = '<img src="'+data.image+'" class="img-responsive popup_img"/>';
					} 
					else 
					{ 
						var image =	'<?php echo $this->Html->image('main_profile.png',array('class'=>'img-responsive pull-left'));?>';
					}
					
					var html = image+'<div class="topFeature_content"><h3>'+data.title+'</h3>'+data.description+'</div><div class="clearfix"></div>'; 
					$('#showTopFeatureRecord').find('.topFeatureContent').text('');
					$('#showTopFeatureRecord').find('.topFeatureContent').append(html);
					$('#showTopFeatureRecord').modal('show');
				}
				else
				{	
					return false;
				}
			}
		});
	}
}
</script>
<div class="modal fade" id="showTopFeatureRecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Top Feature</h4>
			</div>
			<div class="modal-body topFeatureContent">
				
			</div>
		</div>
	</div>
</div>
