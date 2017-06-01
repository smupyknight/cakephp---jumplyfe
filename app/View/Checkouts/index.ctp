<div class="searchpage"><?php echo $this->element('menu');?></div>
<div class="right_profile bgcolor">
	<div class="container">
		<h3 class="title">Jump Checkout</h3>
		<?php echo $this->Session->flash(); ?>
		<div class="row">
			<div class="col-sm-6">
				<div class="checkout_box">
					<h2>Amount :<span><?php echo round($record['TmpInvoice']['amount'],2); ?> USD<?php if($record['TmpInvoice']['payment_charges'] != 0){ echo ' + '. round($record['TmpInvoice']['payment_charges'],2).' USD <small class="checkout_small">(Transaction Charges)</small>';  } ?> </span></h2>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="checkout_box">
					<h3><?php echo $record['TmpInvoice']['checkout_title']; ?></h3>
					<p><?php echo $record['TmpInvoice']['checkout_description']; ?></p>
				</div>
			</div>
		</div>

		<div class="pay_btns">
			<a href="javascript:void(0)" onclick = "openPaypalPopUp()">
				<?php echo $this->Html->image('express-checkout-hero.png',array('class'=>'img-responsive'));?>
	
			<a href="javascript:void(0)" onclick = "openCreditCardPopUp()">
				<?php echo $this->Html->image('pay-with-credit-card-button.png',array('class'=>'img-responsive'));?>
			</a>
			<?php if(!$record['TmpInvoice']['skip_wallet']) { ?>
			<a href="javascript:void(0)" onclick = "openWalletPopUp()"><img src="img/wallet.png" class="img-responsive"></a>
			<?php } ?>
		</div>

		<!--<form class="form-horizontal checkout_form">
		  <div class="form-group">
		    <label class="col-sm-3 control-label">First Name :</label>
		    <div class="col-sm-9">
		      <input type="text" class="form-control">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">Last Name :</label>
		    <div class="col-sm-9">
		      <input type="text" class="form-control">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">Card Name :</label>
		    <div class="col-sm-9">
		      <input type="text" class="form-control">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-3 control-label">Date :</label>
		    <div class="col-sm-9">
		      <select class="form-control">
		      	<option>9 August</option>
		      	<option>17 August</option>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-9 col-sm-offset-3">
				<a href="#" class="btn btn-primary">Proceed</a>
				<a href="#" class="btn btn-default pull-right">Back</a>
				<div class="clearfix"></div>
		    </div>
		  </div>
		</form>-->
	</div>
</div>
<script>

function openPaypalPopUp(){
	$("#payPalPopup").modal('show');
}


function openCreditCardPopUp(){
	
	$("#creditCardPopup").modal('show');
}


function openWalletPopUp(){
	
	$("#walletPayPopup").modal('show');
}


</script>
<div class="modal fade paypal" id="payPalPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Paypal</h4>
            </div>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<p>If you want to pay with Paypal so click on proceed button and pay with paypal</p>	 
			</div>
			<div class="modal-footer">
				<?php echo $this->Html->link("Proceed",array('plugin'=>false,'controller'=>'checkouts','action'=>'paypal'),array("class"=>"btn btn-primary pull-right")); ?>
				<input type ="button" type ="button" data-dismiss = 'modal' value ="Cancel" class="btn btn-primary pull-left" />
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="creditCardPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Credit Card Payment</h4>
            </div>
			<?php echo $this->Form->create('StripeModal',array('url'=>array('plugin'=>false,'controller'=>'checkouts','action'=>'payWithCC'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<div class="input-group">
					<?php echo $this->Form->input('StripeModal.full_name',array('class'=>'form-control','placeholder'=>'Full Name','aria-describedby'=>'sizing-addon2','label'=>false,'required'=>'required')); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<?php echo $this->Form->input('StripeModal.card_number',array('class'=>'form-control','placeholder'=>'Card Number','aria-describedby'=>'sizing-addon2','label'=>false,'required'=>'required')); ?>
				</div>
			</div>
			<?php
				$month = array('01'=>'1','02'=>'2','03'=>'3','04'=>'4','05'=>'5','06'=>'6','07'=>'7','08'=>'8','09'=>'9','10'=>'10','11'=>'11','12'=>'12');
				$year = date('Y');
				$year_list = array();
				for($i=0; $i<=15; $i++){
					$year_list[$year] = $year;
					$year = $year + 1;	
				}
			?>
			<div class="form-group">
				<div class="input-group">
					<?php echo $this->Form->Select('StripeModal.exp_month',$month,array('class'=>'form-control','placeholder'=>'Expiration Month','aria-describedby'=>'sizing-addon2','label'=>false,'required'=>'required','empty'=>'Select Expiry Month')); ?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="input-group">
					<?php echo $this->Form->Select('StripeModal.exp_year',$year_list,array('class'=>'form-control','placeholder'=>'Expiration Year','aria-describedby'=>'sizing-addon2','label'=>false,'required'=>'required','empty'=>'Select Expiry Year')); ?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="input-group">
					<?php echo $this->Form->input('StripeModal.cvc',array('class'=>'form-control','placeholder'=>'CSV','aria-describedby'=>'sizing-addon2','label'=>false,'required'=>'required')); ?>
				</div>
			</div>
				
			</div>

			<div class="modal-footer">
				<?php echo $this->Form->button(__d("stripe_modals", "Proceed To Pay", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<div class="modal fade paypal" id="walletPayPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Wallet</h4>
            </div>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<p>If you want to pay with wallet so click on proceed button and pay with wallet</p>	 
			</div>
			<div class="modal-footer">
				<?php echo $this->Html->link("Proceed",array('plugin'=>false,'controller'=>'checkouts','action'=>'payWithWallet'),array("class"=>"btn btn-primary text-upper pull-right")); ?>
				<input type ="button" type ="button" data-dismiss = 'modal' value ="Cancel" class="btn btn-primary pull-left" />
			</div>
		</div>
	</div>
</div>
