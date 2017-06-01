<?php echo $this->element('menu'); ?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="btn-style">
					<div class="btn-group btn-group-justified my_active_group">
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance">About Group</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance" onclick="membersUrl(this)" data-slug="<?php echo $group_slug; ?>">Members</button>
						</div>
						<div class="btn-group " role="group">
							<button type="button" class="btn active btn-advance" onclick="groupTimeline_Url(this)" data-slug="<?php echo $group_slug; ?>">Group Timeline</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
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