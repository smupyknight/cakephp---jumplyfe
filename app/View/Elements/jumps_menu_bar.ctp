<?php if(authComponent::user('id')){ ?>
<?php $session_user_data = $this->requestAction(array('plugin'=>false,'controller'=>'users','action'=>'session_user_data',authComponent::user('id'))); ?>
<div class="menu">
	<div class="container">
		<nav class="navbar navbar-default">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="nav">
				<ul class="nav nav-pills">
					<li><?php echo $this->Html->link('<span class="newsfeed"></span> JUMP FEED',array('controller'=>'welcomes','action'=>'news_feed',$session_user_data['User']['slug']),array('escape'=>false)); ?></li>
					<li><?php echo $this->Html->link('<span class="timeline"></span> TIMELINE',array('controller'=>'welcomes','action'=>'timeline',$session_user_data['User']['slug']),array('escape'=>false));?></li>
					<li class="dropdown"><?php  echo $this->Html->link('<span class="myjumps"></span> MY JUMPS',array('controller'=>'users','action'=>'profile',authComponent::user('firstname')),array('escape'=>false,'class'=>'dropdown-toggle','data-toggle'=>'dropdown'));?>
						<ul class="dropdown-menu" role="menu">
				            <li><?php  echo $this->Html->link('<span class="newjumps"></span> NEW JUMPS',array('controller'=>'jumps','action'=>'add_my_jump',$session_user_data['User']['slug']),array('escape'=>false));?></li>
						    <li><a href="javascript:void(0)" onclick="openJumpVideoPopup(this)"><span class="newjumpsvid"></span>NEW JUMP VIDEO</a></li>
						    <li><a href="javascript:void(0)" onclick="openJumpShotPopup(this)"><span class="newjumpsshots"></span>NEW JUMP PIC</a></li>
				        </ul>
					</li>
					<!-- <li><?php  echo $this->Html->link('<span class="newjumps"></span> New JUMPS',array('controller'=>'jumps','action'=>'add_my_jump',authComponent::user('firstname')),array('escape'=>false));?></li>
					<li><a href="javascript:void(0)" onclick="openJumpVideoPopup(this)"><span class="newjumpsvid"></span>NEW JUMPS vID</a></li>
					<li><a href="javascript:void(0)" onclick="openJumpShotPopup(this)"><span class="newjumpsshots"></span>NEW JUMPS SHOTS</a></li> -->
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div>
</div>
<?php } else { ?>
<div class="menu">
	<div class="container">
		<nav class="navbar navbar-default">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="nav">
				<ul class="nav nav-pills">
					<li><?php echo $this->Html->link('<span class="newsfeed"></span> NEWS FEED',array('controller'=>'welcomes','action'=>'news_feed',authComponent::user('slug')),array('escape'=>false)); ?></li>
					<li><?php echo $this->Html->link('<span class="timeline"></span> TIMELINE',array('controller'=>'welcomes','action'=>'timeline',authComponent::user('slug')),array('escape'=>false));?></li>
					<!--<li class=""><?php  //echo $this->Html->link('<span class="myjumps"></span> MY JUMPS',array('controller'=>'users','action'=>'profile',authComponent::user('firstname')),array('escape'=>false));?></li> -->
					<li class=""><?php  //echo $this->Html->link('<span class="newjumps"></span> New JUMPS',array('controller'=>'jumps','action'=>'add_my_jump',authComponent::user('firstname')),array('escape'=>false));?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div>
</div>
<?php } ?>
<script>
	function openJumpShotPopup($this){
		$('#JumpShotPopup').modal('show');
	}
	
	function openJumpVideoPopup($this){
		$('#JumpVideoPopup').modal('show');
	}
</script>
<script>
$(document).ready(function(){
	var type = $(this).val();
	if(type == 'Embeded')
	{
		$('#Embeded_Url').show();
		$('#Upload_Video').hide();
	}
	else
	{
		$('#Embeded_Url').hide();
		$('#Upload_Video').show();
	}
	$('.videoType').change(function(){
		var type = $(this).val();
		if(type == 'Embeded')
		{
			$('#Embeded_Url').show();
			$('#Upload_Video').hide();
		}
		else
		{
			$('#Embeded_Url').hide();
			$('#Upload_Video').show();
		}
	});
	
	$("input.check_size").change(function () {
		
		var max_size = $(this).attr('data-max_size');
		var show_size = Math.round(max_size / 1024);
		var media_type = $(this).attr('data-media_type');
		
		if ($(this).val() !== "") 
		{
			
			var file = $(this)[0].files[0];
			var file_size = file.size / 1024;
			
			if(file_size > max_size)
			{
				$(this).closest("form").find('.ajax_alert').slideDown().find('.ajax_message').text(media_type+' must be less than '+show_size+'MB');
				return false;
			}
			else
			{
				$(this).closest("form").find('.ajax_alert').slideUp();
				return true;
			}
		}
	});
});
</script>
<div class="modal fade" id="JumpShotPopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Add Jump Shots</h4>
            </div>
			<?php echo $this->Form->create('JumpGallery',array('url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'add_jumpShot',$jumps_slug),'class'=>'ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('JumpGallery.media_title',array('class'=>'form-control','placeholder'=>'Enter Title','label'=>false,'id'=>'jump_gallery_media_title')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="">
						<?php echo $this->Form->textarea('JumpGallery.media_description',array('class'=>'form-control','placeholder'=>'Enter Description','label'=>false,'id'=>'jump_gallery_media_description')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->file('JumpGallery.image',array('class'=>'check_size','data-max_size' => Configure::read("Site.max_upload_image_size"),'data-media_type'=>'Image','label'=>false,'required'=>'required')); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("jump_galleries", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<div class="modal fade" id="JumpVideoPopup" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Add Jump Video</h4>
            </div>
			<?php echo $this->Form->create('JumpGallery',array('url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'add_jumpVideo',$jumps_slug),'class'=>'ajax_form','type'=>'file','id'=>'JumpGallery_Index_Form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('JumpGallery.media_title',array('class'=>'form-control','placeholder'=>'Enter Title','label'=>false)); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="">
						<?php echo $this->Form->textarea('JumpGallery.media_description',array('class'=>'form-control','placeholder'=>'Enter Description','label'=>false)); ?>
					</div>
				</div>
				<?php $video_type = array('Upload' => 'Upload','Embeded' => 'Embeded'); ?>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->select('JumpGallery.video_type',$video_type,array('class'=>'form-control videoType','label'=>false,'empty'=>false)); ?>
					</div>
				</div>
				<div class="form-group" id="Embeded_Url">
					<div class="">
						<?php echo $this->Form->textarea('JumpGallery.video',array('class'=>'form-control','placeholder'=>'Enter Embeded Youtube Url','label'=>false)); ?>
					</div>
					<small><b>Example Embeded Code:</b><br> &lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/TFWwireGl5o&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;&lt;</small>
				</div>
				<div class="form-group" id = "Upload_Video">
					<div class="input-group">
						<?php echo $this->Form->file('JumpGallery.upload_video',array('class'=>'check_size','data-max_size' => Configure::read("Site.max_upload_video_size"),'data-media_type'=>'Video','label'=>false,'required'=>'required')); ?>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<?php echo $this->Form->button(__d("jump_galleries", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
