<?php if(isset($timeline_record) && !empty($timeline_record)) {?>
<div id="" class="posts-lists">
<?php foreach($timeline_record as $key =>$value) {?>
<div class="post-item">
<?php if($value['UserFeed']['feed_type_id'] == 1){ ?>
<?php //if(isset($value['User']['is_private_profile']) && $value['User']['is_private_profile'] == 'No' || $value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
<div class="my_timeline timeline_feed_<?php echo $value['UserFeed']['id']; ?>" >
	<?php if($value['UserFeed']['is_shared'] == 'Yes'){ ?>
	<div class="timeline_header">
		<div class="timeline_heading userFeedDetail">
			
			<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
				<div class="dropdown pull-right">
				<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
				<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
					<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
				</ul>
				</div>
			<?php } ?>
			
			<p>
				<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong> shared a post of  <strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?></strong> <?php if(isset($value['Jump'])){ echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); } ?>
			</p>
			
			<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['UserParentData']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img_radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img_radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
			<p><strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?></strong> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> </p>
			<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeedParentData']['UserFeed']['description']; ?></p>
	</div>
	<?php } else { ?>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
		
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>
		
		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> 
		</p>
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<?php } ?>
	<!--<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading userFeedDetail">
			<p><a href="javascript:void(0)"><strong><?php echo $value['User']['name']; ?></strong></a> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> <?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); }?></p>
			<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeed']['description']; ?></p>
	</div>-->
	<div class="timeline_body">
		<?php
			$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
			$file_name		=	$value['Jump']['Jump']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',550,450,base64_encode($file_path),$file_name),true);
				$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
				echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
			}
			else
			{
				echo $this->Html->image('no_image.png',array('class'=>'post_img img-responsive','onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
			}
		?>
		<p>
			<a href="javascript:void(0)" class="likes" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="counter"><?php if($value['Feedlikes']){ echo $value['Feedlikes']; } else {echo 0; } ?></span> Likes</a>
			<a href="javascript:void(0)" class="comments" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="commentCounter"><?php if($value['FeedComments']){ echo $value['FeedComments']; } else {echo 0; } ?></span> Comments</a>
			<a href="javascript:void(0)" class="share" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="shareCounter"><?php if($value['FeedShare']){ echo $value['FeedShare']; } else {echo 0; } ?></span> Shares</a>
		</p>
		<ul>
			<?php if($value['UserFeedlike']){ ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } else { ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } ?>
			<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$value['UserFeed']['id']));?></li>
			<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$value['UserFeed']['id'],'data-feed_type_target_id'=>$value['Jump']['Jump']['id']));?></li>
		</ul>
		<!--<p class="total_likes"><a href="#">Vikas</a> and <a href="#">246 Others</a> Like This</p>-->
		<div class="commentRecord">
		<?php if($value['comments'] != ''){ ?>
		<?php $value['comments'] = array_reverse($value['comments']); ?>
		<?php foreach($value['comments'] as $key1 => $value1){ ?>
		<div class="indi_comment comment_id_<?php echo $value1['UserFeedComment']['id']; ?>">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value1['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=> '/'.$value1['User']['slug'],'class'=>'img_radius'));
			}
			else 
			{
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			}
			?>
			<?php if($value['UserFeed']['user_id'] == authComponent::user('id') || $value1['UserFeedComment']['user_id'] == authComponent::user('id')){ ?>
			<span class="comment_options">
				<i class="delete_this_comment fa fa-close" onclick="deleteComment(this);" data-comment_id = "<?php echo $value1['UserFeedComment']['id']; ?>"></i>
			</span>
			<?php } ?>
			<div class="timeline_heading">
				<p><?php echo $this->Html->link($value1['User']['firstname'] .' '.$value1['User']['lastname'],'/'.$value1['User']['slug']); ?>
				<span><?php echo $value1['UserFeedComment']['comment']; ?></span></p>
				<span><?php echo date('d M Y  g:i A',strtotime($value1['UserFeedComment']['created'])); ?> </span>
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
			<?php echo $this->Form->input('UserFeedLike.user_feed_id',array('class'=>'form-control', 'placeholder'=>'Write Here...','label'=>false,'type'=>'hidden','value'=>$value['UserFeed']['id']));?>
			<?php echo $this->form->end();?>
			<span>Please enter to post.</span>
		</div>
	</div>
</div>
<?php //} ?>
<?php } else if($value['UserFeed']['feed_type_id'] == 2){ ?>
<?php //if(isset($value['User']['is_private_profile']) && $value['User']['is_private_profile'] == 'No' || $value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
<div class="my_timeline timeline_feed_<?php echo $value['UserFeed']['id']; ?>">
	<?php if($value['UserFeed']['is_shared'] == 'Yes'){ ?>
	<div class="timeline_header">
		<div class="timeline_heading userFeedDetail">
		
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>
		
		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong> shared a post of  <strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?></strong> <?php if(isset($value['Jump'])){ echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); } ?> 
		</p>
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['UserParentData']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
			
		<p>
			<strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?></strong> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> 
		</p>
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeedParentData']['UserFeed']['description']; ?></p>
	</div>
	<?php } else { ?>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			}
		?>
		
		<div class="timeline_heading userFeedDetail">
		
		
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>
		
		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> 
		</p>
		
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<?php } ?>
	<!--<div class="timeline_header ">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img_radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading userFeedDetail">
		<p><a href="javascript:void(0)"><strong><?php echo $value['User']['name']; ?></strong></a> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> <?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); }?></p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeed']['description']; ?></p>
	</div>-->
	<div class="timeline_body">
		<?php
			$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
			$file_name		=	$value['Jump']['Jump']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',550,450,base64_encode($file_path),$file_name),true);
				$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
				echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
			}
			else
			{
				echo $this->Html->image('no_image.png',array('class'=>'post_img img-responsive','onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
			}
		?>
		<p>
			<a href="javascript:void(0)" class="likes" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="counter"><?php if($value['Feedlikes']){ echo $value['Feedlikes']; } else {echo 0; } ?></span> Likes</a>
			<a href="javascript:void(0)" class="comments" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="commentCounter"><?php if($value['FeedComments']){ echo $value['FeedComments']; } else {echo 0; } ?></span> Comments</a>
			<a href="javascript:void(0)" class="share" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="shareCounter"><?php if($value['FeedShare']){ echo $value['FeedShare']; } else {echo 0; } ?></span> Shares</a>
		</p>
		<ul>
			<?php if(isset($value['UserFeedlike']) && !empty($value['UserFeedlike'])){ ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } else { ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } ?>
			<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$value['UserFeed']['id']));?></li>
			<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$value['UserFeed']['id'],'data-feed_type_target_id'=>$value['Jump']['Jump']['id']));?></li>
		</ul>
		<!--<p class="total_likes"><a href="#">Vikas</a> and <a href="#">246 Others</a> Like This</p>-->
		<div class="commentRecord">
		<?php if($value['comments'] != ''){ ?>
		<?php foreach($value['comments'] as $key1 => $value1){ ?>
		<div class="indi_comment comment_id_<?php echo $value1['UserFeedComment']['id']; ?>">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value1['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			}
			?>
			<?php if($value['UserFeed']['user_id'] == authComponent::user('id') || $value1['UserFeedComment']['user_id'] == authComponent::user('id')){ ?>
			<span class="comment_options">
				<i class="delete_this_comment fa fa-close" onclick="deleteComment(this);" data-comment_id = "<?php echo $value1['UserFeedComment']['id']; ?>"></i>
			</span>
			<?php } ?>
			<div class="timeline_heading">
				<p><?php echo $this->Html->link($value1['User']['firstname'] .' '.$value1['User']['lastname'],'/'.$value1['User']['slug']); ?>
				<span><?php echo $value1['UserFeedComment']['comment']; ?></span></p>
				<span><?php echo date('d M Y  g:i A',strtotime($value1['UserFeedComment']['created'])); ?> </span>
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
			if($file_name && file_exists($file_path . $file_name)) 
			{
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
			<?php echo $this->Form->input('UserFeedLike.user_feed_id',array('class'=>'form-control', 'placeholder'=>'Write Here...','label'=>false,'type'=>'hidden','value'=>$value['UserFeed']['id']));?>
			<?php echo $this->form->end();?>
			<span>Please enter to post.</span>
		</div>
	</div>
</div>
<?php //} ?>
<?php } else if($value['UserFeed']['feed_type_id'] == 5){ ?>
<div class="my_timeline timeline_feed_<?php echo $value['UserFeed']['id']; ?>">
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'profile',$value['User']['slug']),'class'=>'img-radius'));
			}else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'profile',$value['User']['slug']),'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
		<p><a href="javascript:void(0)"><strong><?php echo $value['User']['name']; ?></strong></a> <?php echo $value['FeedType']['title']; ?>  <strong><?php echo $value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname']; ?> </strong> <?php if(isset($value['Jump'])){ echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); } ?> <?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); }?></p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		
	</div>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['UserParentData']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-radius'));
			}else {
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading">
		<p><a href="javascript:void(0)"><strong><?php echo $value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname']; ?></strong></a></p>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<div class="timeline_body">
		<?php
			if(isset($value['Jump'])){
				$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
				$file_name		=	$value['Jump']['Jump']['image'];
				if($file_name && file_exists($file_path . $file_name)) {
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',470,309,base64_encode($file_path),$file_name),true);
					$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
					echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
				}
			}
			else
			{
				if($value['UserFeed']['feed_media'] == 'Image'){
					$file_path		=	ALBUM_UPLOAD_FEED_IMAGE_PATH;
					$file_name		=	$value['UserFeed']['image'];
					if($file_name && file_exists($file_path . $file_name)) {
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',470,309,base64_encode($file_path),$file_name),true);
						$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
						echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
					}
				}
				else if($value['UserFeed']['feed_media'] == 'Video')
				{
					if($value['UserFeed']['video_type'] == 'Upload'){ ?>
						<div id ="myElement_<?php echo $key; ?>"></div>
						<script type="text/javascript">
							$(document).ready(function(){
								jwplayer("myElement_<?php echo $key; ?>").setup({
									file: '<?php echo FEED_IMAGE_PATH.$value['UserFeed']['video']; ?>',
									height: 250,
									width: 250
								});
							});
						</script>
					<?php }
					else
					{
						echo $value['UserFeed']['video'];
					}
				}
			}
		?>
		<p>
			<a href="javascript:void(0)" class="likes" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="counter"><?php if($value['Feedlikes']){ echo $value['Feedlikes']; } else {echo 0; } ?></span> Likes</a>
			<a href="javascript:void(0)" class="comments" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="commentCounter"><?php if($value['FeedComments']){ echo $value['FeedComments']; } else {echo 0; } ?></span> Comments</a>
			<a href="javascript:void(0)" class="share" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="shareCounter"><?php if($value['FeedShare']){ echo $value['FeedShare']; } else {echo 0; } ?></span> Shares</a>
		</p>
		<ul>
			<?php if(isset($value['UserFeedlike'])){ ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } else { ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } ?>
			<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$value['UserFeed']['id']));?></li>
			
			<?php if(isset($value['Jump'])) { ?>
			
			<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$value['UserFeed']['id'],'data-feed_type_target_id'=>$value['Jump']['Jump']['id']));?></li>
			
			<?php } else { ?>
			
				<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$value['UserFeed']['id'],'data-feed_type_target_id'=>''));?></li>
			
			<?php } ?>
		</ul>
		<!--<p class="total_likes"><a href="#">Vikas</a> and <a href="#">246 Others</a> Like This</p>-->
		<div class="commentRecord">
		<?php if($value['comments'] != ''){ ?>
		<?php foreach($value['comments'] as $key1 => $value1){ ?>
		<div class="indi_comment">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value1['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img_radius'));
			}else {
				echo $this->Html->image('user-noimage-small.png');
			}
			?>
			<div class="timeline_heading">
				<p><a href="javascript:void(0)"><?php echo $value1['User']['firstname'] .' '.$value1['User']['lastname']; ?></a> <span><?php echo $value1['UserFeedComment']['comment']; ?></span></p>
				<span><?php echo date('d M Y  g:i A',strtotime($value1['UserFeedComment']['created'])); ?> </span>
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
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img_radius'));
			}
			else 
			{
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading">
			<?php echo $this->Form->create('UserFeedLike',array('url'=>array('controller'=>'welcomes','action'=>'user_feed_comment'),'class'=>'ajax_form'));?>
			<?php echo $this->Form->input('UserFeedLike.comment',array('class'=>'form-control submit-enter cmtFormField', 'placeholder'=>'Write Here...','label'=>false));?>
			<?php echo $this->Form->input('UserFeedLike.user_feed_id',array('class'=>'form-control', 'placeholder'=>'Write Here...','label'=>false,'type'=>'hidden','value'=>$value['UserFeed']['id']));?>
			<?php echo $this->form->end();?>
			<span>Please enter to post.</span>
		</div>
	</div>
</div>
<?php } else if($value['UserFeed']['feed_type_id'] == 6){ ?>
<div class="my_timeline timeline_feed_<?php echo $value['UserFeed']['id']; ?>">
	<?php if($value['UserFeed']['is_shared'] == 'Yes'){ ?>
	<div class="timeline_header">
		<div class="timeline_heading userFeedDetail">
		
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>

		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong> shared a post of  <strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?> </strong> <?php if(isset($value['Jump'])){ echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); } ?> 
		</p>
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['UserParentData']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
		
		<p>
			<strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'] .' '.$value['UserParentData']['User']['lastname'],array('plugin'=>false,'controller'=>'users','action'=>'profile',$value['UserParentData']['User']['slug'])); ?></strong></a> <?php echo $value['FeedType']['title']; ?> 
		</p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeedParentData']['UserFeed']['description']; ?></p>
	</div>
	<?php } else { ?>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
			
		<?php 
		if($value['UserFeed']['group_id'] == 0){
			if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
				<div class="dropdown pull-right">
				
				<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
				
				<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?></li>
				
				<li role="presentation"><?php echo  $this->Html->link('Delete','javascript:void(0)',array('class'=>'pull-right deletePost','onclick'=>'deleteGroupPost(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-type'=>'timeline')); ?> </li>
				</ul>
				</div>
			<?php 
			}
			
		}
		?>
		
		<?php if($value['UserFeed']['group_id'] != 0){
			if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
				<div class="dropdown pull-right">
				<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
				<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
					<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?></li>
					<?php if(isset($value['GroupMember'])){
					if($value['GroupMember']['TotalGroupMember']['is_administrator'] == 'Yes' || $value['UserFeed']['user_id'] == authComponent::user('id')){ ?>
						<li role="presentation"><?php echo $this->Html->link('Delete','javascript:void(0)',array('class'=>'pull-right deletePost','onclick'=>'deleteGroupPost(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-type'=>'group_timeline'));  ?> </li>
						<?php } ?>
					<?php } ?>
				</ul>
				</div>
			<?php 
			}
		}
		?>
		
		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong></a> <?php echo $value['FeedType']['title']; ?>
		</p>
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<?php } ?>
	<!--<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading userFeedDetail">
		<p><a href="javascript:void(0)"><strong><?php echo $value['User']['name']; ?></strong></a> <?php echo $value['FeedType']['title']; ?> <?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); }?></p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeed']['description']; ?></p>
	</div>-->
	<div class="timeline_body">
		
		<?php
			if($value['UserFeed']['feed_media'] == 'Image'){
				$file_path		=	ALBUM_UPLOAD_FEED_IMAGE_PATH;
				$file_name		=	$value['UserFeed']['image'];
				if($file_name && file_exists($file_path . $file_name)) {
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',550,450,base64_encode($file_path),$file_name),true);
					$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
					echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
				}
			}
			else if($value['UserFeed']['feed_media'] == 'Video')
			{
				if($value['UserFeed']['video_type'] == 'Upload')
				{
					?>
					<div id ="myElement_<?php echo $key; ?>"></div>
					<script type="text/javascript">
						$(document).ready(function(){
							jwplayer("myElement_<?php echo $key; ?>").setup({
								file: '<?php echo FEED_IMAGE_PATH.$value['UserFeed']['video']; ?>',
								height: 300,
								width: "100%" 
							});
						});
					</script>
				<?php }
				else
				{ ?>
					<div class="video"><?php echo $value['UserFeed']['video']; ?> </div>
				<?php }
			}
		?>
		<p>
			<a href="javascript:void(0)" class="likes" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="counter"><?php if($value['Feedlikes']){ echo $value['Feedlikes']; } else {echo 0; } ?></span> Likes</a>
			<a href="javascript:void(0)" class="comments" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="commentCounter"><?php if($value['FeedComments']){ echo $value['FeedComments']; } else {echo 0; } ?></span> Comments</a>
			<?php if($value['UserFeed']['group_id'] == 0){ ?>
				<a href="javascript:void(0)" class="share" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="shareCounter"><?php if($value['FeedShare']){ echo $value['FeedShare']; } else {echo 0; } ?></span> Shares</a>
			<?php } ?>
		</p>
		
			<?php if($value['UserFeed']['group_id'] == 0){ ?>
			<ul>
				<?php if(isset($value['UserFeedlike']) && !empty($value['UserFeedlike'])){ ?>
				<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
				<?php } else { ?>
				<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
				<?php } ?>
				<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$value['UserFeed']['id']));?></li>
				<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$value['UserFeed']['id'],'data-feed_type_target_id'=>''));?></li>
			</ul>
			<?php } else { ?>
			<ul class="no-share">
				<?php if(isset($value['UserFeedlike']) && !empty($value['UserFeedlike'])){ ?>
				<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
				<?php } else { ?>
				<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
				<?php } ?>
				<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$value['UserFeed']['id']));?></li>
			</ul>
			<?php } ?>
		
		<!--<p class="total_likes"><a href="#">Vikas</a> and <a href="#">246 Others</a> Like This</p>-->
		<div class="commentRecord">
		<?php if($value['comments'] != ''){ ?>
		<?php $value['comments'] = array_reverse($value['comments']); ?>
		<?php foreach($value['comments'] as $key1 => $value1){ ?>
		<div class="indi_comment comment_id_<?php echo $value1['UserFeedComment']['id']; ?>">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value1['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			}else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			}
			?>
			<?php if($value['UserFeed']['user_id'] == authComponent::user('id') || $value1['UserFeedComment']['user_id'] == authComponent::user('id')){ ?>
			<span class="comment_options">
				<i class="delete_this_comment fa fa-close" onclick="deleteComment(this);" data-comment_id = "<?php echo $value1['UserFeedComment']['id']; ?>"></i>
			</span>
			<?php } ?>
			<div class="timeline_heading">
				<p><?php echo $this->Html->link($value1['User']['firstname'] .' '.$value1['User']['lastname'],'/'.$value1['User']['slug']); ?> <span><?php echo $value1['UserFeedComment']['comment']; ?></span></p>
				<span><?php echo date('d M Y  g:i A',strtotime($value1['UserFeedComment']['created'])); ?> </span>
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
			<?php echo $this->Form->input('UserFeedLike.user_feed_id',array('class'=>'form-control', 'placeholder'=>'Write Here...','label'=>false,'type'=>'hidden','value'=>$value['UserFeed']['id']));?>
			<?php echo $this->form->end();?>
			<span>Please enter to post.</span>
		</div>
	</div>
</div>
<?php } else if($value['UserFeed']['feed_type_id'] == 7){ ?>
<div class="my_timeline timeline_feed_<?php echo $value['UserFeed']['id']; ?>">
	<?php if($value['UserFeed']['is_shared'] == 'Yes'){ ?>
	<div class="timeline_header">
		<div class="timeline_heading userFeedDetail">
		
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>
		
		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong> shared a post of  <strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?> </strong> <?php if(isset($value['Jump'])){ echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); } ?> 
		</p>
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['UserParentData']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
		<p><strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],array('plugin'=>false,'controller'=>'users','action'=>'profile',$value['UserParentData']['User']['slug'])); ?></strong> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> </p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeedParentData']['UserFeed']['description']; ?></p>
	</div>
	<?php } else { ?>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['User']['slug'],'class'=>'img-radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>
		
		<p>
			<a href="javascript:void(0)"><strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong></a> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> 
		</p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<?php } ?>
	<div class="timeline_body">
		<?php
			$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
			$file_name		=	$value['JumpGallery']['JumpGallery']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',550,450,base64_encode($file_path),$file_name),true);
				$image = $this->Html->image($image_url,array('class'=>'post_img img-responsive'));
				echo $this->Html->link($image,'javascript:void(0)',array('onclick'=>'showImageDetailPopup(this)','data-user_feed_id'=>$value['UserFeed']['id'],'escape'=>false));
			}
			else
			{
				echo $this->Html->image('no_image.png',array('class'=>'post_img img-responsive'));
			}
		?>
		<p>
			<a href="javascript:void(0)" class="likes" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="counter"><?php if($value['Feedlikes']){ echo $value['Feedlikes']; } else {echo 0; } ?></span> Likes</a>
			<a href="javascript:void(0)" class="comments" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="commentCounter"><?php if($value['FeedComments']){ echo $value['FeedComments']; } else {echo 0; } ?></span> Comments</a>
			<a href="javascript:void(0)" class="share" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="shareCounter"><?php if($value['FeedShare']){ echo $value['FeedShare']; } else {echo 0; } ?></span> Shares</a>
		</p>
		<ul>
			<?php if(isset($value['UserFeedlike']) && !empty($value['UserFeedlike'])){ ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } else { ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } ?>
			<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$value['UserFeed']['id']));?></li>
			<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$value['UserFeed']['id'],'data-feed_type_target_id'=>$value['Jump']['Jump']['id']));?></li>
		</ul>
		
		<div class="commentRecord">
		<?php if($value['comments'] != ''){ ?>
		<?php $value['comments'] = array_reverse($value['comments']); ?>
		<?php foreach($value['comments'] as $key1 => $value1){ ?>
		<div class="indi_comment comment_id_<?php echo $value1['UserFeedComment']['id']; ?>">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value1['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			}
			?>
			<?php if($value['UserFeed']['user_id'] == authComponent::user('id') || $value1['UserFeedComment']['user_id'] == authComponent::user('id')){ ?>
			<span class="comment_options">
				<i class="delete_this_comment fa fa-close" onclick="deleteComment(this);" data-comment_id = "<?php echo $value1['UserFeedComment']['id']; ?>"></i>
			</span>
			<?php } ?>
			<div class="timeline_heading">
				<p> <?php echo $this->Html->link($value1['User']['firstname'] .' '.$value1['User']['lastname'],'/'.$value1['User']['slug']); ?>  <span><?php echo $value1['UserFeedComment']['comment']; ?></span></p>
				<span><?php echo date('d M Y  g:i A',strtotime($value1['UserFeedComment']['created'])); ?> </span>
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
			<?php echo $this->Form->input('UserFeedLike.user_feed_id',array('class'=>'form-control', 'placeholder'=>'Write Here...','label'=>false,'type'=>'hidden','value'=>$value['UserFeed']['id']));?>
			<?php echo $this->form->end();?>
			<span>Please enter to post.</span>
		</div>
	</div>
</div>
<?php } else if($value['UserFeed']['feed_type_id'] == 8){ ?>
<div class="my_timeline timeline_feed_<?php echo $value['UserFeed']['id']; ?>">
	<?php if($value['UserFeed']['is_shared'] == 'Yes'){ ?>
	<div class="timeline_header">
		<div class="timeline_heading userFeedDetail">
		
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>
		
		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],'/'.$value['User']['slug']); ?></strong> shared a post of  <strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?> </strong> <?php if(isset($value['Jump'])){ echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); } ?> 
		</p>
		
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['UserParentData']['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img_radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value['UserParentData']['User']['slug'],'class'=>'img_radius'));
			}
		?>
		<div class="timeline_heading userFeedDetail">
		<p><strong><?php echo $this->Html->link($value['UserParentData']['User']['firstname'].' '.$value['UserParentData']['User']['lastname'],'/'.$value['UserParentData']['User']['slug']); ?></strong> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> </p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeedParentData']['UserFeed']['description']; ?></p>
		
	</div>
	<?php } else { ?>
	<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading userFeedDetail">
		
		<?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { ?>
			<div class="dropdown pull-right">
			<a data-toggle="dropdown" href=""><i class="fa fa-cog fa-fw"></i></a>
			<ul aria-labelledby="dropdown" role="menu" class="dropdown-menu">
				<li role="presentation" class=""><?php echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); ?> </li>
			</ul>
			</div>
		<?php } ?>
	
		<p>
			<strong><?php echo $this->Html->link($value['User']['name'],array('plugin'=>false,'controller'=>'users','action'=>'profile',$value['User']['slug'])); ?></strong></a> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> 
		</p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont showDescription"><?php echo $value['UserFeed']['description']; ?></p>
	</div>
	<?php } ?>
	<!--<div class="timeline_header">
		<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value['User']['logo'];
			if($file_name && file_exists($file_path . $file_name)) {
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-radius'));
			} else {
				echo $this->Html->image('user-noimage-small.png');
			}
		?>
		<div class="timeline_heading userFeedDetail">
		<p><a href="javascript:void(0)"><strong><?php echo $value['User']['name']; ?></strong></a> <?php echo $value['FeedType']['title']; ?> <?php echo $this->Html->link($value['Jump']['Jump']['title'],array('controller'=>'jumps','action'=>'index',$value['Jump']['Jump']['slug'])); ?> <?php if($value['UserFeed']['user_id'] == authComponent::user('id')) { echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'pull-right editFeedLink','onclick'=>'openEditFeedPopUp(this)','data-user_feed_id'=>$value['UserFeed']['id'],'data-user_feed_title'=>$value['UserFeed']['description'])); }?></p>
		<span><?php echo date('d M Y  g:i A',strtotime($value['UserFeed']['feed_make_time'])); ?></span>
		</div>
		<p class="time_header_cont"><?php echo $value['UserFeed']['description']; ?></p>
	</div>-->
	<div class="timeline_body">
		<?php
			if($value['JumpGallery']['JumpGallery']['video_type'] == 'Upload')
			{
				?><div id ="myElement_<?php echo $key; ?>"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						jwplayer("myElement_<?php echo $key; ?>").setup({
							file: '<?php echo JUMP_IMAGE_PATH.$value['JumpGallery']['JumpGallery']['video']; ?>',
							height: 300,
							width: "100%"
						});
					});
				</script>
			<?php 
			}
			else
			{ ?>
				<div class="video"><?php echo $value['JumpGallery']['JumpGallery']['video']; ?></div>
			<?php }
		?>
		<p>
			<a href="javascript:void(0)" class="likes" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="counter"><?php if($value['Feedlikes']){ echo $value['Feedlikes']; } else {echo 0; } ?></span> Likes</a>
			<a href="javascript:void(0)" class="comments" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="commentCounter"><?php if($value['FeedComments']){ echo $value['FeedComments']; } else {echo 0; } ?></span> Comments</a>
			<a href="javascript:void(0)" class="share" onclick = "showImageDetailPopup(this)" data-user_feed_id = "<?php echo $value['UserFeed']['id'];?>"><span class="shareCounter"><?php if($value['FeedShare']){ echo $value['FeedShare']; } else {echo 0; } ?></span> Shares</a>
		</p>
		<ul>
			<?php if(isset($value['UserFeedlike']) && !empty($value['UserFeedlike'])){ ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Unlike</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } else { ?>
			<li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> <span class="like_text">Like</span>','javascript:void(0)',array('escape'=>false,'class'=>'do_like','data-id'=>$value['UserFeed']['id']));?></li>
			<?php } ?>
			<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Comment</a>','javascript:void(0)',array('escape'=>false,'onclick'=>'commentFocus(this)','data-feed_type_id'=>$value['UserFeed']['id']));?></li>
			<li><?php echo $this->Html->link('<i class="fa fa-share-o"></i> Share','javascript:void(0)',array('escape'=>false,'onclick'=>'openShareFeedPopup(this)','data-feed_type_id'=>$value['UserFeed']['id'],'data-feed_type_target_id'=>$value['Jump']['Jump']['id']));?></li>
		</ul>
		<!--<p class="total_likes"><a href="#">Vikas</a> and <a href="#">246 Others</a> Like This</p>-->
		<div class="commentRecord">
		<?php if($value['comments'] != ''){ ?>
		<?php $value['comments'] = array_reverse($value['comments']); ?>
		<?php foreach($value['comments'] as $key1 => $value1){ ?>
		<div class="indi_comment comment_id_<?php echo $value1['UserFeedComment']['id']; ?>">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$value1['User']['image'];
			if($file_name && file_exists($file_path . $file_name)) 
			{
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,81,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			}
			else 
			{
				echo $this->Html->image('user-noimage-small.png',array('url'=>'/'.$value1['User']['slug'],'class'=>'img_radius'));
			}
			?>
			<?php if($value['UserFeed']['user_id'] == authComponent::user('id') || $value1['UserFeedComment']['user_id'] == authComponent::user('id')){ ?>
			<span class="comment_options">
				<i class="delete_this_comment fa fa-close" onclick="deleteComment(this);" data-comment_id = "<?php echo $value1['UserFeedComment']['id']; ?>"></i>
			</span>
			<?php } ?>
			<div class="timeline_heading">
				<p><?php echo $this->Html->link($value1['User']['firstname'] .' '.$value1['User']['lastname'],'/'.$value1['User']['slug']); ?>  <span><?php echo $value1['UserFeedComment']['comment']; ?></span></p>
				<span><?php echo date('d M Y  g:i A',strtotime($value1['UserFeedComment']['created'])); ?> </span>
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
			<?php echo $this->Form->input('UserFeedLike.user_feed_id',array('class'=>'form-control', 'placeholder'=>'Write Here...','label'=>false,'type'=>'hidden','value'=>$value['UserFeed']['id']));?>
			<?php echo $this->form->end();?>
			<span>Please enter to post.</span>
		</div>
	</div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<?php 

echo $this->Paginator->options(array("url"=>array("pluign"=>$this->params["plugin"],"controller"=>$this->params["controller"],"action"=>$this->params["action"],"?"=>array("friends"=>$friends,"group_id"=>$group_id,"user_id"=>$user_id))));
echo $this->Paginator->next('');

 ?>
<?php } ?>

<script>
$(function(){
	//var $container = $('#posts-list');
	$('.posts-lists').infinitescroll({
		navSelector  : '.next',    // selector for the paged navigation 
		nextSelector : '.next a',  // selector for the NEXT link (to page 2)
		itemSelector : '.post-item',     // selector for all items you'll retrieve
		debug		 : true,
		dataType	 : 'html',
		loading: {
		  finishedMsg: 'No more posts to load. All Hail Star Wars God!',
		  img: '<?php echo $this->webroot; ?>img/spinner.gif'
		}
	});
});
</script>
<script>
function highlightBorder($this)
{
	$this.addClass("my_timeline_alert");
	setTimeout(function(){
		$this.removeClass("my_timeline_alert");
	},2000);
}
function addBorderClass($this)
{
	$this.addClass("my_timeline_alert");
}
function removeBorderClass($this)
{
	setTimeout(function(){
		$this.removeClass("my_timeline_alert");
	},300);
}
function actionAfterTimeLineCommentPost(data)
{
	if(data.success)
	{
		if(data.user_image != '')
		{
			var image = '<a href="'+data.user_profile_url+'"><img src="'+data.user_image+'" class="img-responsive img_radius"/></a>';
		} 
		else 
		{ 
			var image =	'<?php echo $this->Html->image('user-noimage-small.png',array('class'=>'img-responsive'));?>';
		}
		var html = '<div class="indi_comment comment_id_'+data.comment_id+'">'+image+'<span class="comment_options"><i class="delete_this_comment fa fa-close" onclick="deleteComment(this);" data-comment_id = '+data.comment_id+'></i></span><div class="timeline_heading"><p><a href="'+data.user_profile_url+'">'+data.user_name+'</a><span>' +data.comment+'</span></p><span>'+data.created_date+'</span></div></div>';
		//alert(html);
		$('.timeline_feed_'+data.feed_id).find(".commentRecord").append(html);
		$('.timeline_feed_'+data.feed_id).find('.comments .commentCounter').text(data.comment_counter);
	}
}

function actionAfterSharePost(data)
{
	if(data.success)
	{
		$('.timeline_feed_'+data.feed_id).find('.share .shareCounter').text(data.share_counter);
		closeShareFeedPopup();
	}
}

function openShareFeedPopup($this)
{
	var feed_type_target_id = $($this).attr('data-feed_type_target_id');
	var feed_type_id = $($this).attr('data-feed_type_id');
	$('#shareFeedPopup .feed_type_target_id').val(feed_type_target_id);
	$('#shareFeedPopup .feed_type_id').val(feed_type_id);
	$("#shareFeedPopup").modal('show');
}

function showImageDetailPopup($this)
{
	var id = $($this).attr('data-user_feed_id');
	if(id != ""){
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"welcomes",'action' => 'show_one_timeline_record')); ?>",
			data:{'id':id},
			success: function(data) {
				$('#showRecordPopup .showRecord').html(data);
				$("#showRecordPopup").modal('show');
			}
		});
	}	
}

function closeShareFeedPopup()
{
	$("#shareFeedPopup").modal('hide');
}

function closeEditUserFeedPopup()
{
	$("#editUserFeedPopup").modal('hide');
}

function commentFocus($this)
{
	var feed_type_id = $($this).attr('data-feed_type_id');
	$('.timeline_feed_'+feed_type_id).find('.timeline_footer .cmtFormField').focus();
}

function openEditFeedPopUp($this){
	var user_feed_id = $($this).attr('data-user_feed_id');
	var user_feed_title = $($this).attr('data-user_feed_title');
	$('#editUserFeedPopup .user_feed_id').val(user_feed_id);
	$('#editUserFeedPopup .userFeedTitle').val(user_feed_title);
	$('#editUserFeedPopup .ajax_alert').css({"display": "none"});
	$("#editUserFeedPopup").modal('show');
}

function actionAfterEditUserFeed(data)
{
	if(data.success)
	{
		$('.timeline_feed_'+data.user_feed_id).find('.showDescription').text(data.description);
		$('.timeline_feed_'+data.user_feed_id).find('.userFeedDetail .editFeedLink').attr('data-user_feed_title',data.description);
		closeEditUserFeedPopup();
	}
}



function deleteGroupPost($this){
	var id = $($this).attr('data-user_feed_id');
	var type = $($this).attr('data-type');
	var group_id = $($this).attr('data-group_id');
	var confirmText = "Are you sure you want to delete this post from group?";
	if(confirm(confirmText)) {
		if(id != ""){
			$.ajax({
				type: "post",
				url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"welcomes",'action' => 'deleteGroupPost')); ?>",
				data:{'id':id,'group_id':group_id,'type':type},
				success: function(data) {
					location.reload();
				}
			});
		}
	}
}

function deleteComment($this){
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
	}
</script>
<div class="modal fade" id="shareFeedPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Share Feed</h4>
			</div>
			<?php echo $this->Form->create('UserFeed',array('url'=>array('controller'=>'welcomes','action'=>'user_feed_share'),'class'=>'ajax_form')); ?>
			<div class="modal-body">
				<?php echo $this->Form->input('UserFeed.feed_type_id',array('class'=>'feed_type_id','aria-describedby'=>'sizing-addon2','label'=>false,'type'=>'hidden','value'=>'')); ?>
				<?php echo $this->Form->input('UserFeed.feed_type_target_id',array('class'=>'feed_type_target_id','aria-describedby'=>'sizing-addon2','label'=>false,'type'=>'hidden','value'=>'')); ?>
				<h4>Are you want you sure share this post on your timeline?</h4>
			</div>
			<div class="modal-footer">
				<input type="button" class="btn btn-default pull-left" value="Cancel" onclick="closeShareFeedPopup();" />
				<?php echo $this->Form->button(__d("user_feeds", "Share Now", true),array("class"=>"btn btn-primary pull-right")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<div class="modal fade" id="showRecordPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body showRecord">
				
	
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editUserFeedPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Edit Feed</h4>
			</div>
			<?php echo $this->Form->create('UserFeed',array('url'=>array('controller'=>'welcomes','action'=>'editUserFeed'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php echo $this->Form->text('UserFeed.description',array('placeholder'=>'Title','aria-describedby'=>'sizing-addon2','label'=>false,'value'=>'','class'=>'userFeedTitle form-control')); ?>
				</div>
				<?php echo $this->Form->input('UserFeed.user_feed_id',array('class'=>'user_feed_id','aria-describedby'=>'sizing-addon2','label'=>false,'type'=>'hidden','value'=>'')); ?>
			</div>
			<div class="modal-footer">
				<input type="button" class="btn btn-default pull-left" value="Cancel" onclick="closeEditUserFeedPopup();" />
				<?php echo $this->Form->button(__d("user_feeds", "Save", true),array("class"=>"btn btn-primary pull-right")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
