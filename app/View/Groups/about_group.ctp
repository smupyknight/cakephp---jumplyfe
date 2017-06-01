<?php echo $this->element('menu'); ?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="btn_tab">
					<div class="btn-group btn-group-justified my_active_group">
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance">About Group</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-advance" onclick="membersUrl(this)" data-slug="<?php echo $groups['TotalGroup']['slug']; ?>">Members</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-advance" onclick="groupTimeline_Url(this)" data-slug="<?php echo $groups['TotalGroup']['slug']; ?>">Timeline</button>
						</div>
					</div>
				</div>
				<h3 class="title">About Group </h3>
				<?php if(isset($groups) && !empty($groups)){ ?>

				<div class="about_group">
					<a href="#">
					<?php
						$file_path		=	ALBUM_UPLOAD_GROUP_IMAGE_PATH;
						$file_name		=	$groups['TotalGroup']['image'];
						if($file_name && file_exists($file_path . $file_name)) {
							$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',200,200,base64_encode($file_path),$file_name),true);
							echo $this->Html->image($image_url,array('class'=>'img-responsive'));
						}
						else 
						{
							echo $this->Html->image('no_image.png',array('class'=>'img-responsive about_group_no_Image'));
						}
					?>
					<div class="clearfix"></div>
				</a>
					<div class="blog_heading">
						<div class="search_left">
							<h5><?php echo $groups['TotalGroup']['group_name']; ?>
								<?php if($is_GroupMemberAdmin == 'Yes') { echo $this->Html->link('Edit','javascript:void(0)',array('class'=>'btn btn-primary pull-right','onclick'=>'openCreateGroupPopUp()')); } ?>
							</h5>
							<span>Created Date : <?php echo date('d M Y',strtotime($groups['TotalGroup']['created'])); ?></span>
							<span>Members : <?php echo $groups['TotalGroup']['members']; ?> </span>
						</div>
						<div class="search_right">
							
						</div>
					</div>
				</div>
				<?php } else { ?>
				<div class="no-record">No Record Found</div>
				
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
function openCreateGroupPopUp(){
	$("#createGroupPopUp").modal('show');
}

function membersUrl($this){
	var slug = $($this).attr('data-slug');
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'groups','action'=>'members')); ?>/'+slug;
	window.location = url;
}

function groupTimeline_Url($this){
	var slug = $($this).attr('data-slug');
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'groups','action'=>'group_timeline')); ?>/'+slug;
	window.location = url;
}
</script>
<div class="modal fade" id="createGroupPopUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Edit Information</h4>
            </div>
			<?php echo $this->Form->create('Group',array('url'=>array('plugin'=>false,'controller'=>'groups','action'=>'edit_group_information',$groups['TotalGroup']['slug']),'class'=>'ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('Group.group_name',array('class'=>'form-control','placeholder'=>'Group Name','aria-describedby'=>'sizing-addon2','value'=>$groups['TotalGroup']['group_name'],'label'=>false,'required'=>'required')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->file('Group.image',array('class'=>'form-control check_size','data-max_size' => Configure::read("Site.max_upload_image_size"),'label'=>false,'value'=>$groups['TotalGroup']['image'])); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("groups", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
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
</script>
