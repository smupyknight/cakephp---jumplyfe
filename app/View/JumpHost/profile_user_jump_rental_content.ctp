<?php if(isset($record) && !empty($record)){ ?>
<div class="pg-post-list">
<?php foreach($record as $key => $value){ ?>
	<div class="search_block post-item">
		<?php
			$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
			$file_name		=	$value['JumpHost']['image'];
			if($file_name && file_exists($file_path . $file_name)) 
			{
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',180,180,base64_encode($file_path),$file_name),true);
				echo $this->Html->image($image_url,array('class'=>'img-responsive','url'=>array('controller'=>'jump_hosts','action'=>'detail',$value['JumpHost']['slug']),'class'=>'JumpRental_Image'));
			}
			else 
			{
				echo $this->Html->image(JUMP_HOST_IMAGE_PATH.'no_image.png',array('class'=>'img-responsive','url'=>array('controller'=>'jump_hosts','action'=>'detail',$value['JumpHost']['slug']),'class'=>'JumpRental_Image'));
			}
		?>
		
		<div class="blog_heading">
			<div class="search_left">
				<h5><?php echo $this->Html->link($this->Text->truncate($value['JumpHost']['title'],35),array('controller'=>'jump_hosts','action'=>'detail',$value['JumpHost']['slug'])); ?></h5>
				<div class="star-patten">
					<?php $ratings = $value['JumpHost']['rating']; ?>
					<?php $disable_rating = 5 - $value['JumpHost']['rating'];?>
					<?php for($i=1; $i<=$ratings; $i++) {?>
						<i class="fa fa-star"></i>
					<?php } ?>
					<?php for($i=1; $i<=$disable_rating; $i++) {?>
						<i class="fa fa-star disable"></i>
					<?php } ?>
				   </div>
				<address><?php echo $value['JumpHost']['address_line_1']; ?>, <?php echo $value['JumpHost']['address_line_2']; ?>, <?php echo $value['JumpHost']['city']; ?> </address>
				<span><?php echo $this->text->truncate($value['JumpHost']['description'],100); ?> </span>
			</div>
			<div class="search_right">
				<h5><?php
					if($value['JumpHost']['rating'] >= 4)
					{
						echo "Very Good!";
						
					} 
					else if($value['JumpHost']['rating'] >=3 && $value['JumpHost']['rating'] < 4 )
					{
						
						echo "Good!";
					}
					else if($value['JumpHost']['rating'] >=2 && $value['JumpHost']['rating'] < 3)
					{
						echo "Bad";
					}
					else if($value['JumpHost']['rating'] >0 && $value['JumpHost']['rating'] < 2)
					{
						echo "Very Bad!";
					}
					else
					{
						echo "No Rated!";
					}
					
					?>  <span><?php echo $value['JumpHost']['rating'];?> /5</span> </h5>
				<a href="javascript:void(0)" onclick="goToReview(this)" data-url="<?php echo $value['JumpHost']['detail_url']; ?>"> <?php echo $value['JumpHost']['review']; ?> Reviews<i class="fa fa-angle-right"></i></a>
				<h3><a href="javascript:void(0)">USD. <?php echo $value['JumpHost']['price']; ?></a></h3><span>Rate Per night</span>
				<?php echo $this->Html->link('View Details',array('controller'=>'jump_hosts','action'=>'detail',$value['JumpHost']['slug']),array('class'=>'btn btn-primary')); ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>
<?php echo $this->Paginator->next('');?>
<?php } else { ?>
	<div class="no-record">No Jump Rental Found</div>
<?php } ?>
<script>
function goToReview($this){
	var url = $($this).attr('data-url');
	window.location = url+'#reviews_section';
}

$(document).ready(function(){
	$('.pg-post-list').infinitescroll({
		navSelector  : '.next',    // selector for the paged navigation 
		nextSelector : '.next a',  // selector for the NEXT link (to page 2)
		itemSelector : '.post-item',     // selector for all items you'll retrieve
		debug		 	: true,
		dataType	 	: 'html',
		loading: {
		  finishedMsg: 'No more posts to load. All Hail Star Wars God!',
		  img: '<?php echo $this->webroot; ?>img/spinner.gif'
		}
	});
});
</script>
