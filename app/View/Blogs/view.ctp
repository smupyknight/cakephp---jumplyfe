<div class="right_profile blog bgcolor">
  <div class="container">
		<div class="row">
			<?php echo $this->element('blog_left_bar'); ?>
			<div class="col-md-9 col-sm-9">
				<div class="message_block">
					<div class="blog_heading">
						<h5><?php echo $record[$model]['title']; ?></h5>
						<p>Posted by <i>admin </i> on <?php echo date('d M,Y',strtotime($record[$model]['created'])); ?></p>
						<p><span> Tags :</span><?php echo $record[$model]['tags']; ?></p>
						<div class="blog_message"><?php echo $record[$model]['description'];?></div>
					</div>
				</div>
				<div class="blog_button">
					<?php //pr($new_record); die; ?>
					<?php if($older_record){ ?>
					<?php echo $this->Html->link('Older Posts',array('plugin'=>false,'controller'=>'blogs','action'=>'view',$older_record[$model]['slug']),array('class'=>'btn btn-primary')); ?>
					<?php } ?>
					<?php if($new_record){ ?>
					<?php echo $this->Html->link('NEW POSTS',array('plugin'=>false,'controller'=>'blogs','action'=>'view',$new_record[$model]['slug']),array('class'=>'btn-newpost')); ?>
					<?php } ?>
				</div>   
			</div>
		</div>
	</div>
</div>