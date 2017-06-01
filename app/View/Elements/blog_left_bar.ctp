<?php 
	$recent_blog = $this->requestAction(array('controller' => 'blogs', 'action' => 'get_recent_blog'));
	$popular_post = $this->requestAction(array('controller' => 'blogs', 'action' => 'get_popular_post'));
?>

<div class="col-md-3 col-sm-3">
	<div class="section">
		<h2>Blog</h2>
		<hr>
		<a class="btn btn-deposite" href="#">RECENT POSTS</a>
		<ul class="blog_style">
			<?php if($recent_blog){ ?>
			<?php foreach($recent_blog as $key => $value){?> 
			<li><strong><?php echo date('m-d-Y',strtotime($value['Blog']['created']));?></strong><?php echo $value['Blog']['title'];?></li>
			<?php }?>
			<?php } else { ?>
				<li>No Record Found</li>
			<?php } ?>
		</ul>
		<a class="tag_link" href="#">Older Posts <i class="fa fa-angle-right"></i></a>
		<div class="clearfix"></div>
		<hr>
		<div class="clearfix"></div>
		<a class="btn btn-deposite" href="#">POPULAR POSTS</a>
		<ul class="blog_style">
			<?php if($popular_post){ ?>
			<?php foreach($popular_post as $key1 => $value1){?> 
			<li><strong><?php echo date('m-d-Y',strtotime($value1['Blog']['created']));?></strong><?php echo $value1['Blog']['title'];?></li>
			<?php }?>
			<?php } else { ?>
				<li>No Record Found</li>
			<?php } ?>
		</ul>
		<a class="tag_link" href="#">Older Posts <i class="fa fa-angle-right"></i></a> 
	</div>
</div>