                <div class="right_profile job bgcolor">
	<div class="container">
		<div class="row">
			<?php echo $this->element('help_left_section');  ?>
			<div class="col-md-9 col-sm-9">
				<div class="message_block" >
					<div class="help_block">
						<h5>Help Center</h5>
						<div class="popular_topic">
							<?php if(isset($topic_data) && !empty($topic_data)) { ?>
							
								<h3><?php echo $topic_data['HelpTopic']['title']; ?></h3>
								
								<p><?php echo $topic_data['HelpTopic']['description']; ?></p>	
								
							</ul>
							<?php } else { ?>
								<div class="no-record">No Record Found</div>
							
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
