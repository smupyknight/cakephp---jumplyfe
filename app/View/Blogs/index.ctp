<div class="right_profile blog bgcolor">
	<div class="container">
		<div class="row">
			<?php echo $this->element('blog_left_bar'); ?>
			<div class="col-md-9 col-sm-9">
				<?php if(isset($record) && !empty($record)){ ?>
					<?php foreach($record as $key => $value){ ?>
					<div class="message_block">
						<div class="blog_heading">
							
							<h5><?php echo $this->Html->link($value[$model]['title'],array('plugin'=>false,'controller'=>'blogs','action'=>'view',$value[$model]['slug'],),array('class'=>'title','escape'=>false));?></h5>
							<p>Posted by <i>admin </i> on <?php echo date('d M,Y',strtotime($value[$model]['created'])); ?></p>
							<p><span> Tags :</span><?php echo $value[$model]['tags']; ?> </p>
							<div class="blog_message"><?php echo $this->requestAction(array('controller' => 'app', 'action' => 'showLimitedText'),array($value[$model]['description'],500));?></div>
							<?php echo $this->Html->link('Read More<i class="fa fa-angle-right"></i>',array('plugin'=>false,'controller'=>'blogs','action'=>'view',$value[$model]['slug'],),array('class'=>'tag_link','escape'=>false));?>
							
						</div>
					</div>
					<?php } ?>
						<?php echo $this->element('pagination');?>
				<?php } else { ?>
					<div class ="not_found">No Record Found</div>
				<?php } ?>
				<!--
				<div class="blog_button">
					<a class="btn btn-primary" href="#">OLDER POSTS</a>
					<a  class="btn-newpost" href="#">NEW POSTS</a>
				</div> -->
			</div>
			
		</div>
		
	</div>
</div>
