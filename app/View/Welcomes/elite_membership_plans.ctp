<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
			<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<?php echo $this->Session->Flash(); ?>
				<h3 class="title">Elite Membership Plans</h3>
				<?php if(isset($eliteMembershipPlan_Record) && !empty($eliteMembershipPlan_Record)) { ?>
				<p>Please buy atleast one elite membership plan for elite</p>
				<div class="plans_page">
					<div class="row">
						 <?php foreach($eliteMembershipPlan_Record as $key => $value){ ?>
							<div class="col-sm-4">
								<div class="elite_plans">
								<h3><?php echo $value['EliteMembershipPlan']['plan']; ?></h3>
									<h5><strong><?php echo $value['EliteMembershipPlan']['plan']; ?></strong></h5>
									<p><?php echo $value['EliteMembershipPlan']['description']; ?></p>
									<h5><strong>Validity : </strong> <?php echo $value['EliteMembershipPlan']['validity']; ?> <?php echo $value['EliteMembershipPlan']['validity_type']; ?></h5>
									<h5><strong>Price : </strong>	 <?php echo $value['EliteMembershipPlan']['convertPrice']; ?> <?php echo $this->Session->read('Currency.default'); ?></h5>
									<?php echo $this->Html->link('Buy Now',array("plugin"=>false,"controller"=>"elites",'action' => 'buyEliteMemberShipPlan',$value['EliteMembershipPlan']['id']),array('class'=>'btn btn-primary','confirm'=>'Are you sure you want to buy this elite membership plan.')); ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
					<div class="no-record">No Elite Memership Plan Found</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
/* function buyEliteMemberShip($this){
	var id = $($this).attr('data-id');
	if(id != ''){
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"elites",'action' => 'buyEliteMemberShipPlan')); ?>",
			data:{'id':id},
			dataType:"json",
			success:function(data){
				if(data.success == true){
				
					alert('dfg');
				
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
} */
</script>
