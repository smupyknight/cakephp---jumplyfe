<?php if(authComponent::user('id')) { ?><div class="searchpage"><?php echo $this->element('menu'); ?></div> <?php } ?>
<div class="right_profile job bgcolor">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-3">
				<div class="section">
					<ul class="job_link">
						<li class="active"><a href="#">Jumplyfe News</a></li>
						<li><a href="javascript:void(0)">Media Resources</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-9 col-sm-9">
				<div class="message_block" >
					<div class="press">
						<h5>In The News</h5>
						<div class="row">
							<div class="col-md-6 press_list">
								<?php echo $this->Html->image('new_york_times.png',array('class'=>'img-responsive'));?>
								<p>Lorem ipsum dolor sit amet: The news headlines would go here</p>
								<span>December 15 2015</span>
							</div>
							<div class="col-md-6 press_list">
								<?php echo $this->Html->image('travelnews.png',array('class'=>'img-responsive'));?>
								<p>Lorem ipsum dolor sit amet: The news headlines would go here</p>
								<span>December 15 2015</span>
							</div>

							<div class="col-md-6 press_list">
								<?php echo $this->Html->image('yahoo.png',array('class'=>'img-responsive'));?>
								<p>Lorem ipsum dolor sit amet: The news headlines would go here</p>
								<span>December 15 2015</span>
							</div>

							<div class="col-md-6 press_list">
								<?php echo $this->Html->image('bbc_travel.png',array('class'=>'img-responsive'));?>
								<p>Lorem ipsum dolor sit amet: The news headlines would go here</p>
								<span>December 15 2015</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
