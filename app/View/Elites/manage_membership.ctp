<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="transaction">
					<div class="balance">
						
						<p>Your elite membership plan will be expire on &nbsp;<span><?php echo date('d M Y',strtotime($expire_date)); ?></span><span>
							<?php echo $this->Html->link('Delete',array('plugin'=>false,'controller'=>'elites','action'=>'delete_membership_plan'),array('class'=>'btn btn-deposite btn-danger pull-right','confirm'=>'Are you sure you want to delete membership plan'));?>
							<?php echo $this->Html->link('Change',array('plugin'=>false,'controller'=>'welcomes','action'=>'elite_membership_plans'),array('class'=>'btn btn-deposite btn-primary pull-right'));?> </span></p>
						
					</div>
					<h5>RECENT BUY MEMBERSHIP PLANS</h5>
					<div class="table-responsive">
						<table cellspacing="0" cellpadding="0" class="table table-bordered text-center">
							<tr>
								<th>Activation date</th>
								<th>Plan Name</th>
								<th>Plan Description</th>
								<th>Validity</th>
								<th>Plan Price</th>
								<th>Status</th>
								
							</tr>
							<?php if(isset($record) && !empty($record)) { ?>
								<?php foreach($record as $key => $value){ ?>
								<tr>
									<td><?php echo date('d M Y',strtotime($value['UserEliteMembership']['created'])); ?></td>
									<td><?php echo $value['UserEliteMembership']['plan']; ?></td>
									<td><?php echo $value['UserEliteMembership']['description']; ?></td>
									<td><?php echo $value['UserEliteMembership']['validity']; ?> <?php echo $value['UserEliteMembership']['validity_type']; ?></td>
									<td><?php echo $value['UserEliteMembership']['plan_price']; ?></td>
									<?php if($value['UserEliteMembership']['status'] == '1') { ?>
										<td>Active</td>
									<?php } else { ?>
										<td>Inactive</td>
									<?php } ?>
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
						<?php echo $this->element('pagination'); ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
