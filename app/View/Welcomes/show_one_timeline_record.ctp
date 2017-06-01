<div class="my_timeline timeline_feed_<?php echo $feed_record['UserFeed']['id']; ?>">
	<?php if($feed_record['UserFeed']['is_shared'] == 'Yes'){ ?>
	<div class="timeline_header">
		<?php
			/* $file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$feed_record['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-radius'));
			}else {
				echo $this->Html->image('user-noimage-small.png');
			} */
		?>
		<div class="timeline_heading">
		<p><strong><?php echo $this->Html->link($feed_record['User']['name'],'/'.$feed_record['User']['slug']); ?></strong> shared a post of  <strong><?php echo $this->Html->link($feed_record['UserParentData']['User']['firstname'].' '.$feed_record['UserParentData']['User']['lastname'],'/'.$feed_record['UserParentData']['User']['slug']); ?> </strong></p>
		<span><?php echo date('d M Y  g:i A',strtotime($feed_record['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $feed_record['UserFeed']['description']; ?></p>
		
	</div>
	
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$feed_record['UserParentData']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$feed_record['UserParentData']['User']['slug'],'class'=>'img-radius'));
			}else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$feed_record['UserParentData']['User']['slug'],'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading">
		<p><strong><?php echo $this->Html->link(ucfirst($feed_record['UserParentData']['User']['firstname']).' '.ucfirst($feed_record['UserParentData']['User']['lastname']),'/'.$feed_record['UserParentData']['User']['slug']); ?></strong> <?php if(isset($feed_record['FeedType']) && !empty($feed_record['FeedType'])){ echo $feed_record['FeedType']['title']; } ?> <?php if(isset($feed_record['Jump']) && !empty($feed_record['Jump'])){ echo $feed_record['Jump']['Jump']['title']; } ?></p>
		</div>
		<p class="time_header_cont"><?php echo $feed_record['UserFeedParentData']['UserFeed']['description']; ?></p>
		
	</div>
	
	<?php } else { ?>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$feed_record['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-radius'));
			}else {
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading">
			<p><a href="javascript:void(0)"><strong><?php echo $this->Html->link(ucfirst($feed_record['User']['name']),'/'.$feed_record['User']['slug']); ?></strong></a> <?php echo $feed_record['FeedType']['title']; ?> </p>
			<span><?php echo date('d M Y  g:i A',strtotime($feed_record['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $feed_record['UserFeed']['description']; ?></p>
	</div>
	
	<?php } ?>
	<div class="timeline_body">
		<?php 
			if($feed_record['UserFeed']['feed_type_id'] == 6){ 
				if($feed_record['UserFeed']['feed_media'] == 'Image'){
					$file_path		=	ALBUM_UPLOAD_FEED_IMAGE_PATH;
					$file_name		=	$feed_record['UserFeed']['image'];
					if($file_name && file_exists($file_path . $file_name)) {
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',650,550,base64_encode($file_path),$file_name),true);
						$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
						echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$feed_record['UserFeed']['id'],'escape'=>false));
					}
				}
				else if($feed_record['UserFeed']['feed_media'] == 'Video')
				{
					if($feed_record['UserFeed']['video_type'] == 'Upload')
					{ ?>
						<div id ="myElement"></div>
						<script type="text/javascript">
							 $(document).ready(function(){
								jwplayer("myElement").setup({
									file: '<?php echo FEED_IMAGE_PATH.$feed_record['UserFeed']['video']; ?>',
									height: 400,
									width: '100%'
								});
							});
						</script>
					<?php	//echo $feed_record['UserFeed']['video'];
					}
					else
					{ ?>
						<div class="big_video"><?php echo $feed_record['UserFeed']['video']; ?></div>
					<?php }
				}
			}
			else if($feed_record['UserFeed']['feed_type_id'] == 7){ 
				$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
				$file_name		=	$feed_record['JumpGallery']['JumpGallery']['image'];
				if($file_name && file_exists($file_path . $file_name)) {
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',650,550,base64_encode($file_path),$file_name),true);
					$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
					echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$feed_record['UserFeed']['id'],'escape'=>false));
				}
			}
			else if($feed_record['UserFeed']['feed_type_id'] == 8){ 
				if($feed_record['JumpGallery']['JumpGallery']['video_type'] == 'Upload')
				{ ?>
					<div id ="myElementFirst"></div>
					<script type="text/javascript">
						 $(document).ready(function(){
							jwplayer("myElementFirst").setup({
								file: '<?php echo JUMP_IMAGE_PATH.$feed_record['JumpGallery']['JumpGallery']['video']; ?>',
								height: 400,
								width: '100%'
							});
						}); 
					</script>
				<?php	//echo $feed_record['JumpGallery']['JumpGallery']['video'];
				}
				else
				{ ?>
					<div class="big_video"><?php echo $feed_record['JumpGallery']['JumpGallery']['video']; ?></div>
				<?php }
			}
			
			else {
				$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
				$file_name		=	$feed_record['Jump']['Jump']['image'];
				if($file_name && file_exists($file_path . $file_name)) {
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',650,550,base64_encode($file_path),$file_name),true);
					$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
					echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$feed_record['UserFeed']['id'],'escape'=>false));
				}
				else
				{
					echo $this->Html->image('no_image.png',array('class'=>'post_img img-responsive','onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$feed_record['UserFeed']['id'],'escape'=>false));
				}
			}
		?>
		<p>
			<a href="javascript:void(0)" class="likes"><span class="counter"><?php if($feed_record['Feedlikes']){ echo $feed_record['Feedlikes']; } else {echo 0; } ?></span> Likes</a>
			<a href="javascript:void(0)" class="comments"><span class="commentCounter"><?php if($feed_record['FeedComments']){ echo $feed_record['FeedComments']; } else {echo 0; } ?></span> Comments</a>
			
			<?php if($feed_record['UserFeed']['group_id'] == 0){ ?>
				<a href="javascript:void(0)" class="comments"><span class="shareCounter"><?php if($feed_record['FeedShare']){ echo $feed_record['FeedShare']; } else {echo 0; } ?></span> Shares</a>
			<?php } ?>
		</p>
		<ul>
			<?php if($feed_record['UserFeedlike']){ ?>
				<li>
					<?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$feed_record['UserFeed']['id']));?>
				</li>
			<?php } else { ?>
				<li>
					<?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$feed_record['UserFeed']['id']));?>
				</li>
			<?php } ?>
			<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$feed_record['UserFeed']['id']));?></li>

			<!--share button -->
			<?php if($feed_record['UserFeed']['group_id'] == 0){ ?>
				<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$feed_record['UserFeed']['id'],'data-feed_type_target_id'=>'')); ?></li>
			<?php } ?>
			
			
		</ul>
		<!--<p class="total_likes"><a href="#">Vikas</a> and <a href="#">246 Others</a> Like This</p>-->
		<div class="commentRecord">
		<?php if(isset($commentRecords) && !empty($commentRecords)){ ?>
		<?php foreach($commentRecords as $key => $value){ ?>
		<div class="indi_comment comment_id_<?php echo $value['UserFeedComment']['id']; ?>">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['User']['slug'],'class'=>'img_radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['User']['slug'],'class'=>'img_radius'));
			}
			?>
			<?php if($feed_record['UserFeed']['user_id'] == authComponent::user('id') || $value['UserFeedComment']['user_id'] == authComponent::user('id')){ ?>
			<span class="comment_options">
				<i class="delete_this_comment fa fa-close" onclick="deleteComment(this);" data-comment_id = <?php echo $value['UserFeedComment']['id']; ?>></i>
			</span>
			<?php } ?>
			<div class="timeline_heading">
				<p><?php echo $this->Html->link(ucfirst($value['User']['firstname']) .' '.ucfirst($value['User']['lastname']),'/'.$value['User']['slug']); ?></a> <span><?php echo $value['UserFeedComment']['comment']; ?></span></p>
				<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeedComment']['created'])); ?> </span>
			</div>
		</div>
		<?php } ?>
		<?php } ?>
		</div>
	</div>
	<div class="timeline_footer">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$sessionUserData['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$sessionUserData['User']['slug'],'class'=>'img_radius'));
			}
			else 
			{
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$sessionUserData['User']['slug'],'class'=>'img_radius'));
			}
		?>
		<div class="timeline_heading">
			<?php echo $this->Form->create('UserFeedLike',array('url'=>array('controller'=>'welcomes','action'=>'user_feed_comment'),'class'=>'ajax_form'));?>
			<?php echo $this->Form->input('UserFeedLike.comment',array('class'=>'form-control submit-enter cmtFormField', 'placeholder'=>'Write Here...','label'=>false));?>
			<?php echo $this->Form->input('UserFeedLike.user_feed_id',array('class'=>'form-control', 'placeholder'=>'Write Here...','label'=>false,'type'=>'hidden','value'=>$feed_record['UserFeed']['id']));?>
			<?php echo $this->form->end();?>
			<span>Please enter to post.</span>
		</div>
	</div>
</div>
<script>
	/*function deleteComment($this){
		var comment_id = $($this).attr('data-comment_id');
		var confirmText = "Are you sure you want to delete this comment?";
		if(confirm(confirmText)) {
			$.ajax({
				type: "post",
				url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"welcomes",'action' => 'deleteComment')); ?>",
				data:{'comment_id':comment_id},
				dataType:"json",
				success: function(data) {
					if(data.success){
						$('.comment_id_'+data.comment_id).remove();
						$('.timeline_feed_'+data.user_feed_id).find('.commentCounter').text(data.comment_counter);
					}
				}
			});
		}
	}*/

</script>
