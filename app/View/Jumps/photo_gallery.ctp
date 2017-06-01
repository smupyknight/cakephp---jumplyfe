<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
		<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
        <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
        <div class="col-md-9 col-sm-9">
          <h3 class="title">Photo Gallery</h3>
			<?php echo $this->Form->create('JumpGallery',array('class'=>'form-horizontal ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
				<span class="ajax_message"></span>	
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $this->Form->label('JumpGallery.media_title', __('Title:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->input("JumpGallery.media_title",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Photo Title')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $this->Form->label('JumpGallery.media_description', __('Description:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->textarea("JumpGallery.media_description",array('class'=>'form-control','label'=>false,'placeholder'=>'Enter Photo Description')); ?>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $this->Form->label('JumpGallery.image', __('Select File:*',true),array('class'=>'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					  <?php echo $this->Form->file("JumpGallery.image",array('class'=>'check_size','label'=>false,'required','data-max_size' => Configure::read("Site.max_upload_image_size"))); ?>
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
			 <?php if(isset($photos) && !empty($photos)){ ?>
			 <ul class="photo_gallery">
			 <?php foreach($photos as $key => $value){ ?>
			 <li>
			 <?php 
			$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
			$file_name		=	$value['JumpGallery']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$box_image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',0,0,base64_encode($file_path),$file_name),true);
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',250,250,base64_encode($file_path),$file_name),true);
				$image = $this->Html->image($image_url,array('class'=>'img-responsive'));
				echo $this->Html->link($image,$box_image_url,array('class'=>'fancybox','escape'=>false));
				
			}
				echo $this->Html->link('<i class="fa fa-times"></i>','javascript:void(0)',array('data-id'=>$value['JumpGallery']['id'],'class'=>'btn btn-danger delete_photo', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Delete', 'escape'=>false));
			 ?>
			 </li>
			 
			 <?php } ?>
			 </ul>
			 <?php } ?>
          </div>
		 
        </div>
     </div>
  </div>
<script>
$(document).ready(function(){
	$('.delete_photo').click(function(){
		var id = $(this).attr("data-id");
		$this = $(this);
		var confirmText = "Are you sure you want to delete this photo?";
		if(confirm(confirmText)) {
			if(id != ""){
				$.ajax({
					type: "post",
					url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"jumps",'action' => 'delete_photo')); ?>",
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
	
	$("input.check_size").change(function () {
		
		var max_size = $(this).attr('data-max_size');
		var show_size = Math.round(max_size / 1024);
		if ($(this).val() !== "") {
			
			var file = $('.check_size')[0].files[0];
			var file_size = file.size / 1024;
			if(file_size > max_size)
			{
				
				$(this).closest("form").find('.ajax_alert').slideDown().find('.ajax_message').text('Image must be less than '+show_size+'MB');
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
