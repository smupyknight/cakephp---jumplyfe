<?php echo $this->element('menu'); ?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<h3 class="title">Groups <?php echo $this->Html->link('Create a new Group','javascript:void(0)',array('class'=>'btn btn-primary pull-right text-upper','onclick'=>'openCreateGroupPopUp()'));?></h3>
				<?php if(isset($groups) && !empty($groups)){ ?>
				<div class="plans_page">
					<div class="row">
						<?php foreach($groups as $key => $value){?>
						<div class="col-sm-4">
							<div class="elite_plans">
								<h3>
									<?php echo $this->Html->link($this->Text->truncate($value['TotalGroup']['group_name'],20),array('plugin'=>false,'controller'=>'groups','action'=>'members',$value['TotalGroup']['slug']),array('class'=>'')); ?>
								</h3>
								<div class="elite_plans_img">
										
									<?php
									$file_path		=	ALBUM_UPLOAD_GROUP_IMAGE_PATH;
									$file_name		=	$value['TotalGroup']['image'];
									if($file_name && file_exists($file_path . $file_name)) {
										$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',150,150,base64_encode($file_path),$file_name),true);
										echo $this->Html->image($image_url,array('url'=>array("plugin"=>false,"controller"=>"groups",'action' => 'members',$value['TotalGroup']['slug']),'class'=>'img-responsive userimage'));
									}
									else 
									{
										echo $this->Html->image('no_image.png',array('class'=>'img-responsive group_no_Image userimage'));
									}
									?>
								</div>
							
								<h5><strong>Created Date : </strong><?php echo date('d M Y',strtotime($value['TotalGroup']['created'])); ?></h5>
								<h5><strong>Members : </strong><?php echo $value['TotalGroupMember']['members']; ?></h5>
								<?php echo $this->Html->link('View Detail',array("plugin"=>false,"controller"=>"groups",'action' => 'members',$value['TotalGroup']['slug']),array('class'=>'btn btn-primary btn-full')); ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
				<div class="no-record">No Group Found</div>
				
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
function openCreateGroupPopUp(){
	$("#createGroupPopUp").modal('show');
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
				<h4 class="modal-title" id="myModalLabel">New Group</h4>
            </div>
			<?php echo $this->Form->create('Group',array('url'=>array('plugin'=>false,'controller'=>'groups','action'=>'create_group'),'class'=>'ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('Group.group_name',array('class'=>'form-control','placeholder'=>'Group Name','aria-describedby'=>'sizing-addon2','label'=>false,'required'=>'required')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->file('Group.image',array('class'=>'form-control check_size','data-max_size' => Configure::read("Site.max_upload_image_size"),'label'=>false)); ?>
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
