<?php echo $this->element('menu'); ?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)) { ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="btn_tab">
					<div class="btn-group btn-group-justified my_active_group">
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-advance"  onclick="aboutGroupUrl(this)" data-slug="<?php echo $group_slug; ?>">About Group</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance">Members</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-advance" onclick="groupTimeline_Url(this)" data-slug="<?php echo $group_slug; ?>">Timeline</button>
						</div>
					</div>
				</div>
				<?php if($Admin == 'Yes'){?>
					<h3 class="title"><?php echo $this->Html->link('Add Member','javascript:void(0)',array('class'=>'btn btn-primary','onclick'=>'openAddMemberPopUp()'));?></h3>
				<?php } ?>
				<div class="clearfix"></div>
				<?php if(isset($memberGroup) && !empty($memberGroup)){?>
				<div class="plans_page">
					<div class="row">
						 <?php foreach($memberGroup as $key => $value){ ?>
							<div class="col-md-4 col-sm-6 col-xs-6 device_full">
								<div class="elite_plans">
									<div class="dropdown pull-right">
										<?php if($Admin == 'Yes'){ ?>
											<a href="" data-toggle="dropdown"><i class="fa fa-cog fa-fw" ></i></a>
										<?php } else if($value['TotalGroupMember']['user_id'] == authComponent::user('id')){ ?>
											<a href="" data-toggle="dropdown"><i class="fa fa-cog fa-fw" ></i></a>
										<?php } ?>
										
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdown">
											<?php if($Admin == 'Yes'){ ?>
											
											<?php if($value['TotalGroupMember']['is_administrator'] == 'Yes'){ ?>
												<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0)" data-group_member_id="<?php echo $value['TotalGroupMember']['id'];?>" data-group_id="<?php echo $value['TotalGroup']['id'];?>" data-status ="remove" onclick="make_admin(this)">Remove From Admin</a></li>
											<?php } else { ?>
												<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0)" data-group_member_id="<?php echo $value['TotalGroupMember']['id'];?>" data-group_id="<?php echo $value['TotalGroup']['id'];?>" data-status ="add"  value="add" onclick="make_admin(this)">Make Admin</a></li>
											<?php } ?>
											
											<?php } ?>
											<li role="presentation"><a role="menuitem" tabindex="-1" data-group_member_id="<?php echo $value['TotalGroupMember']['id'];?>" data-group_id="<?php echo $value['TotalGroup']['id'];?>" onclick="remove_member(this)">Remove from group</a></li>
										</ul>
									</div>
								
									<h3><?php echo $this->Text->truncate(ucfirst($value['User']['firstname']).' '.$value['User']['lastname'],19); ?></h3>
									<div class="elite_plans_img">
									<?php
									$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
									$file_name		=	$value['User']['image'];
									if($file_name && file_exists($file_path . $file_name)) {
										$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',150,150,base64_encode($file_path),$file_name),true);
										echo $this->Html->image($image_url,array('class'=>'userimage'));
									}
									else 
									{
										echo $this->Html->image('no_image.jpg',array('class'=>'userimage'));
									}
									?>
									</div>
									<h5><strong>Group Administrator : </strong> <?php echo $value['TotalGroupMember']['is_administrator']; ?></h5>
									<h5><strong>Address : </strong>	 <?php echo $value['TotalGroupMember']['city']; ?>, <?php echo $value['TotalGroupMember']['country']; ?></h5>
									<?php //echo $this->Html->link('Buy Now',array("plugin"=>false,"controller"=>"elites",'action' => 'buyEliteMemberShipPlan',$value['EliteMembershipPlan']['id']),array('class'=>'btn btn-primary')); ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
					<div class="no-record">No Group Member Found</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
function aboutGroupUrl($this){
	var slug = $($this).attr('data-slug');
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'groups','action'=>'about_group')); ?>/'+slug;
	window.location = url;
}
function groupTimeline_Url($this){
	var slug = $($this).attr('data-slug');
	var url = '<?php echo Router::url(array('plugin'=>false,'controller'=>'groups','action'=>'group_timeline')); ?>/'+slug;
	window.location = url;
}
function make_admin($this){
	var group_member_id = $($this).attr('data-group_member_id');
	var status 	= $($this).attr('data-status');
	var group_id = $($this).attr('data-group_id');
	if(group_member_id != ''){
		$.ajax({
			type:'post',
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"groups",'action' => 'make_admin')); ?>",
			data:{'group_member_id':group_member_id,'status': status,'group_id':group_id},
			dataType:"json",
			success:function(){
				window.location.reload();
			
			}
		});
	}
}
function remove_member($this){
	var group_member_id = $($this).attr('data-group_member_id');
	var group_id = $($this).attr('data-group_id');
	var confirmText = "Are you sure you want to delete this member from group?";
	if(confirm(confirmText)) {
		if(group_member_id != ''){
			$.ajax({
				type:'post',
				url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"groups",'action' => 'remove_member')); ?>",
				data:{'group_member_id':group_member_id,'group_id':group_id},
				dataType:"json",
				success:function(){
					window.location.reload();
				
				}
			});
		}
	}
}

function openAddMemberPopUp(){
	$("#addMemberPopUp").modal('show');
}
</script>
<div class="modal fade" id="addMemberPopUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Add Member</h4>
            </div>
			<?php echo $this->Form->create('users',array('url'=>array('plugin'=>false,'controller'=>'groups','action'=>'add_member'),'class'=>'ajax_form','type'=>'file')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php echo $this->Form->input('User.member_name',array('class'=>'form-control member_name_auto','placeholder'=>'','aria-describedby'=>'sizing-addon2','label'=>false)); ?>
					
				</div>
				<?php echo $this->Form->text('User.group_id',array('value'=>$group_id,'aria-describedby'=>'sizing-addon2','label'=>false,'type'=>'hidden')); ?>
				<div class="user_ids_form"></div>
				
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("users", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<?php echo $this->fetch('bloodhound.min'); ?>
<style>
/*.member_name_auto{
	width:500px;
}
.tt-menu {
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    margin: 12px 0;
    padding: 8px 0;
    width: 422px;
    left: unset !important;
    
    z-index: 100;
}
.tt-menu, .gist {
    text-align: left;
}
.tt-query, .tt-hint {
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 24px;
    height: 30px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
    width: 396px;
}
.tt-hint{
	display: none !important;
}
.twitter-typeahead, .tt-input{
	width:500px !important;
}
.user_ids_form .label{
	font-size: 14px;
	color: white;
	margin: 1px;
}*/


</style>
<script>
$(function(){
	var source = '<?php echo Router::url(array('plugin'=>false,'controller'=>'groups','action'=>'getMembersAuto')); ?>';
	var bestPictures = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  //prefetch: '../data/films/post_1960.json',
  remote: {
    url: source+'/%QUERY',
    wildcard: '%QUERY',
    
  },

});
 
$('.member_name_auto').typeahead(null, {
  display: 'value',
  source: bestPictures,
 
});



	$('.member_name_auto').on('typeahead:selected', function(evt, item) {
		$('#addMemberPopUp').find('.user_ids_form').append('<label class="label label-primary"><input type="hidden" name="data[User][user_id][]" value="'+item.id+'" /> '+item.value+' <i onClick="removeThisUser(this)" class="fa fa-close"></i></label>');
		//$(".member_name_auto").val('dfg');
		$('.member_name_auto').typeahead('val', '');
		
	});
});
function removeThisUser($this)
{
	$($this).closest('label').remove();
}
</script>
