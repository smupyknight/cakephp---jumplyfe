<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="transaction">
					<div class="clearfix"></div>
					<h5 class="invite_user_title">INVITED FRIENDS <a href="javaScript:void(0)" class="btn btn-deposite btn-primary pull-right" onclick="openInviteFriendPopUp()">Invite Friend</a></h5>
					
					<div class="clearfix"></div>
					<div class="table-responsive">
						<table cellspacing="0" cellpadding="0" class="table table-bordered text-center">
							<tr>
								<th>Name</th>
								<th>Email Address</th>
								<th>Invited Date</th>	
								<th>Joined Status</th>	
							</tr>
							<?php if(isset($record) && !empty($record)) { ?>
								<?php foreach($record as $key => $value){ ?>
								<tr>
									<td><?php echo $value['BetaRegistrationInvitation']['target_full_name']; ?></td>
									<td><?php echo $value['BetaRegistrationInvitation']['email']; ?></td>
									<td><?php echo date('d M Y h:i A',strtotime($value['BetaRegistrationInvitation']['date'])); ?></td>
									<td><?php 
										if($value['BetaRegistrationInvitation']['is_registered'] == 'Yes'){
									
											echo 'Joined';
										}
										else
										{
											
											echo 'Yet Not Joined';
										}
										
										 ?>
									</td>
								</tr>
								<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="7">No Record Found</td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>

				<ul class="pagination">
					<li>
						<?php //echo $this->element('pagination'); ?>
						<?php //echo $this->Paginator->next('Next Page'); ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
	function openInviteFriendPopUp(){
		
		$('#InviteFriendPopUp').modal('show');
		
	}
</script>
<div class="modal fade" id="InviteFriendPopUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Invite</h4>
			</div>
			<?php echo $this->Form->create('BetaRegistrationInvitation',array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'invite_friends'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('BetaRegistrationInvitation.target_full_name',array('class'=>'form-control','placeholder'=>'Name','label'=>false,'required')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('BetaRegistrationInvitation.email',array('class'=>'form-control','placeholder'=>'Email','label'=>false,'required','type'=>'email')); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("beta_registration_invitations", "Send", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
