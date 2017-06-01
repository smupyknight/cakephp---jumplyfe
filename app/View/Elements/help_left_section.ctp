<?php $data = $this->requestAction(array('plugin'=>false,'controller'=>'welcomes','action'=>'help_left_section_data')); ?>
<div class="col-md-3 col-sm-3">
	<div class="section">
		<ul class="job_link">
			<li class="active"><a href="#">Getting Started</a></li>
			<?php if(isset($data) && !empty($data)){ ?>
				<?php foreach($data as $key => $value){ ?>
					<li class="<?php echo (isset($left_menu_selected) && $left_menu_selected == $value['HelpCategory']['slug'])?'active':''?>">
						<?php echo $this->Html->link($value['HelpCategory']['category_name'],array('plugin'=>false,'controller'=>'welcomes','action'=>'help',$value['HelpCategory']['slug'])); ?>
					</li>
				<?php } ?>
			<?php } else { ?>
				<li>No Record Found</li>
			<?php } ?>
		</ul>
	</div>
</div>
