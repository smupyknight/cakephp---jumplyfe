<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="transaction">
					<h3 class="title">Jump Credits</h3>
					<div class="balance">
						<p>Remaining Jump Credit : <span><?php echo $totalEarnPoints['User']['earning_points']; ?></span><span><a href="javaScript:void(0)" class="btn btn-deposite btn-primary pull-right" onclick="openDepositPopup()">Redeem</a></span></p>
						
					</div>
					<h5><span class=""> (1 USD = <?php echo configure::read('Site.1_usd_to_jump_credits'); ?> JUMP CREDITS)</span></h5>
					<div class="table-responsive">
						<table cellspacing="0" cellpadding="0" class="table table-bordered text-center">
							<tr>
								<th>JUMP CREDIT</th>
								<th>Description</th>
								<th>DATE</th>
							</tr>
							<?php if(isset($earn_data) && !empty($earn_data)) { ?>
								<?php foreach($earn_data as $key => $value){ ?>
								<tr>
									<td><?php 
									
									if($value['UserEarningPoint']['transaction_type'] == 'Removed')
									{ 
										echo '-';
									}
									else
									{
										echo '+';
									}
									echo $value['UserEarningPoint']['earn_point']; ?></td>
									<?php if($value['UserEarningPoint']['transaction_type'] == 'Removed') { ?>
									<td>Redeem into wallet account</td>
									<?php } else { ?>
									<td><?php echo $value['earning_type']['title']; ?></td>
									<?php } ?>
									<td><?php echo date('m/d/Y',strtotime($value['UserEarningPoint']['created'])); ?></td>
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
						<?php //echo $this->Paginator->next('Next Page'); ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
function openDepositPopup()
{
	var confirmText = "Are you sure you want to Reedem jump credits?";
	if(confirm(confirmText)) {
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"jumps",'action' => 'reddem_point')); ?>",
			dataType:"json",
			success:function(data){
				if(data.success == true)
				{
					location.reload();
				}
				else if(data.error_type == 'insufficient_balance')
				{
					var notyData = [];
					notyData.message = data.message;
					notyData.type = 'warning';
					nofifyMessage(notyData);
				}
			}
		});
	}
	return false;
}

</script>
