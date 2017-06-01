<?php echo $this->element('menu');?>
<script>
$(document).ready(function(){
	$('.delete_media').click(function(){
		var id = $(this).attr("data-id");
		$this = $(this);
		var confirmText = "Are you sure you want to delete this video?";
		if(confirm(confirmText)) {
			if(id != ""){
				$.ajax({
					type: "post",
					url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"jumps",'action' => 'delete_video')); ?>",
					data:{'id':id},
					dataType:"json",
					success:function(){
						$($this).closest('li').hide('slow');
						return false;
					}
				});
			}
		}
		return false;
	});
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
		if ($(this).val() !== "") {
			
			var file = $('.check_size')[0].files[0];
			var file_size = file.size / 1024;
			if(file_size > max_size)
			{
				
				$(this).closest("form").find('.ajax_alert').slideDown().find('.ajax_message').text('Video must be less than '+show_size+'MB');
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
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
        <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
        <div class="col-md-9 col-sm-9">
          <h3 class="title">Video Gallery</h3>
			<?php echo $this->Form->create('JumpGallery',array('class'=>'form-horizontal ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
				<span class="ajax_message"></span>	
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $this->Form->label('JumpGallery.media_title', __('Title:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpGallery.media_title",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Video Title')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $this->Form->label('JumpGallery.media_description', __('Description:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("JumpGallery.media_description",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Video Description')); ?>
					</div>
				</div>
			</div>
			<?php $video_type = array('Upload' => 'Upload','Embeded' => 'Embeded'); ?>
			<div class="col-md-12">
			<div class="form-group">
				<?php echo $this->Form->label('JumpGallery.video_type', __('Video Type:*',true),array('class'=>'col-sm-4 control-label')); ?>
				<div class="col-sm-8">
					<?php echo $this->Form->select('JumpGallery.video_type',$video_type,array('class'=>'form-control videoType','label'=>false,'empty'=>false)); ?>
				</div>
			</div>
			<div class="col-md-12" id="Embeded_Url">
				<div class="form-group">
					<?php echo $this->Form->label('JumpGallery.video', __('Video:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("JumpGallery.video",array('class'=>'form-control','placeholder'=>'Enter Your Youtube Embeded Code','label'=>false)); ?>
					  <small><b>Example Embeded Code:</b><br> &lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/TFWwireGl5o&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;</small>
					</div>
				</div>
			</div>
			<div class="col-md-12" id="Upload_Video">
				<div class="form-group">
					<?php echo $this->Form->label('JumpGallery.video', __('Video:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->file('JumpGallery.upload_video',array('class'=>'check_size','label'=>false,'data-max_size' => Configure::read("Site.max_upload_video_size"))); ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="set_btn">
						<?php echo $this->Form->button(__d("jump_galleries", "Submit <i class='fa fa-arrow-circle-right'></i>", true),array("class"=>"btn btn-info pull-right")); ?>
					</div>
				</div>
			</div>
			<?php echo $this->Form->end();?>
			 <hr>
				<?php if(isset($videos) && !empty($videos)){?>
			 <ul class="photo_gallery">
			 <?php foreach($videos as $key => $value){ ?>
				 <li>
					<?php //echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>
					 <?php if($value['JumpGallery']['video_type'] == 'Upload'){ ?>
						<!--<div id ="myElements_<?php echo $key; ?>"></div>
						<script type="text/javascript">
							$(document).ready(function(){
								jwplayer("myElements_<?php echo $key; ?>").setup({
									file: '<?php echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>',
									height: 280,
									width: "100%"
								});
							});
						</script>-->
						<video controls loop class="bgvid">
							<source src="<?php echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>" type="video/webm">
							<source src="<?php echo JUMP_IMAGE_PATH.$value['JumpGallery']['video']; ?>" type="video/mp4">
						</video>
					 <?php  }
					 else 
					 {
						echo $value['JumpGallery']['video'];
					 }
					
					 echo $this->Html->link('<i class="fa fa-times"></i>','javascript:void(0)',array('data-id'=>$value['JumpGallery']['id'],'class'=>'btn btn-danger delete_media', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Delete', 'escape'=>false));
					 ?>
				 </li>
			 <?php } ?>
			 <?php } ?>
			 </ul>
          </div>
        </div>
     </div>
  </div>
 </div>
