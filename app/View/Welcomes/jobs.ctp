<?php if(authComponent::user('id')) { ?><div class="searchpage"><?php echo $this->element('menu'); ?></div> <?php } ?>
<div class="right_profile job bgcolor">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-3">
				<div class="section">
					<ul class="job_link">
						<li class="<?php echo (isset($left_menu_selected) && $left_menu_selected == 'all_job')?'active':'' ?>">
							<?php echo $this->Html->link('All Jobs',array('plugin'=>false,'controller'=>'welcomes','action'=>'jobs')); ?>
						</li>
						<li class="<?php echo (isset($left_menu_selected) && $left_menu_selected == 'by_category')?'active':'' ?>">
							<?php echo $this->Html->link('By Category',array('plugin'=>false,'controller'=>'welcomes','action'=>'jobs'.'?order=category')); ?>
						</li>
						<li class="<?php echo (isset($left_menu_selected) && $left_menu_selected == 'by_location')?'active':'' ?>">
							<?php echo $this->Html->link('By Location',array('plugin'=>false,'controller'=>'welcomes','action'=>'jobs'.'?order=location')); ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-9 col-sm-9">
				<div class="message_block" >
					<h5>Job Openings</h5>
					<table class="table job_section">
						<tr>
							<th>Job Title </th>
							<th>Location </th>
						</tr>
						<?php if(isset($record) && !empty($record)){ ?>
							<?php foreach($record as $key => $value){ ?>
								<tr>
									<td><strong><?php echo $value['Job']['title']; ?> </strong><?php echo $value['JobCategory']['category_name']; ?></td>
									<td><?php echo $value['Job']['city_name']; ?>, <?php echo $value['Country']['iso_code']; ?></td>
								</tr>
							<?php } ?>
						<?php } else { ?>
							<tr>
								<td colspan="2">Job Not Found</th>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
