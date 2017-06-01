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
						<p>Your Current Balance : <span><?php echo $current_balance['User']['convert_walletBalance']; ?> <?php echo $this->Session->read('Currency.default'); ?></span><span><a href="javaScript:void(0)" class="btn btn-deposite btn-primary pull-right" onclick="openDepositPopup()">deposit</a></span></p>
						
					</div>
					<h5>TRANSACTION DETAILS</h5>
					<div class="table-responsive">
						<table cellspacing="0" cellpadding="0" class="table table-bordered text-center">
							<tr>
								<th>DATE</th>
								<th>ID</th>
								<th>TRANSACTION</th>
								<th>AMOUNT</th>
								<th>BALANCE</th>
								<th>DETAILS</th>
							</tr>
							<?php if(isset($transaction_details) && !empty($transaction_details)) { ?>
								<?php foreach($transaction_details as $key => $value){ ?>
								<tr>
									<td><?php echo date('m/d/Y',strtotime($value['UserWalletTransaction']['created'])); ?></td>
									<td><?php echo $value['UserWalletTransaction']['invoice_id']; ?></td>
									<td>
										<?php 
											if($value['UserWalletTransaction']['transaction_type'] == 'Added') {
												echo 'Deposited';
											}
											else
											{
												echo 'Debit';
											}
										?>
									</td>
									<td><?php echo $value['UserWalletTransaction']['convertAmount']; ?> <?php echo $this->Session->read('Currency.default'); ?></td>
									<td><?php echo $value['UserWalletTransaction']['convert_available_balance']; ?> <?php echo $this->Session->read('Currency.default'); ?></td>
									
									<td>
									<?php $icon = $this->Html->image(WEBSITE_IMAGE_PATH.'eye.png'); ?>
									<?php echo $this->Html->link($icon,'javascript:void(0);',array('class'=>'getrecord','data-id'=>$value['UserWalletTransaction']['id'],'escape'=>false)); ?>
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
	
	$("#DepositPopup").modal('show');
}
function showRecordPopup()
{
	$("#ShowRecord").modal('show');
}
</script>
<script>
$(document).ready(function(){
	$('.getrecord').click(function(){
		var id = $(this).attr("data-id");
		if(id != ""){
			$.ajax({
				type: "post",
				url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"accounts",'action' => 'show_wallet_records')); ?>",
				data:{'id':id},
				dataType:"json",
				success:function(response){
					$("#ShowRecord").modal('show');
					$(".invoice_report_popup .transcation_date").text(response.record.created);
					$(".invoice_report_popup .invoice_id_value").text(response.record.invoice_id);
					if(response.record.transaction_type == 'Added'){
						$(".invoice_report_popup .transaction_type_value").text('Deposited');
					}
					else{
						$(".invoice_report_popup .transaction_type_value").text('Debit');
					}
					$(".invoice_report_popup .amount_value").text(response.record.convertAmount);
					$(".invoice_report_popup .balance_value").text(response.record.convert_available_balance);
					$(".invoice_report_popup .description_value").text(response.record.comments);
				}
			});
		}
	});

});
</script> 
<div class="modal fade" id="DepositPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Deposit Amount</h4>
			</div>
			<?php echo $this->Form->create('UserWalletTransaction',array('url'=>array('plugin'=>false,'controller'=>'accounts','action'=>'deposit'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php echo $this->Form->input('UserWalletTransaction.amount',array('class'=>'form-control','placeholder'=>'Amount','aria-describedby'=>'sizing-addon2','label'=>false,'min'=>200)); ?>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("user_wallet_transactions", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<div class="modal fade" id="ShowRecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">View Detail</h4>
			</div>
			<div class="modal-body invoice_report_popup table-responsive">
				<table class="table">
					<tr>
						<th>Date:</th>
						<td class="transcation_date"></td>
					</tr>
					<tr>
						<th>Invoice ID:</th>
						<td class="invoice_id_value"></td>
					</tr>
					<tr>
						<th>Transaction:</th>
						<td class="transaction_type_value"></td>
					</tr>
					<tr>
						<th>Amount:</th>
						<td><span class="amount_value"></span> <?php echo $this->Session->read('Currency.default'); ?></td>
					</tr>
					<tr>
						<th>Balance:</th>
						<td><span class="balance_value"></span> <?php echo $this->Session->read('Currency.default'); ?></td>
					</tr>
					<tr>
						<th>Description:</th>
						<td class="description_value"></td>
					</tr>
				</table>	
			</div>
			
		</div>
	</div>
</div>
