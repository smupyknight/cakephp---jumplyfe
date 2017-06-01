<?php if(isset($record) && !empty($record)){ ?>
<div class="pg-post-list">
<?php foreach($record as $key => $value){ ?>
	<div class="search_block post-item">
		<?php if($value['image_url'] != ''){ ?>
			<?php echo $this->Html->image($value["image_url"],array('url'=>array('controller'=>'jump_hosts','action'=>'detail',$value['slug']),'escape'=>false,'class'=>'JumpRental_Image')); ?>
		<?php } else { ?>
			<?php echo $this->Html->image(JUMP_HOST_IMAGE_PATH.'no_image.png',array('url'=>array('controller'=>'jump_hosts','action'=>'detail',$value['slug']),'escape'=>false,'class'=>'JumpRental_Image')); ?>
		<?php } ?>
		
		<div class="blog_heading">
			
			<div class="search_left">
				<h5><?php echo $this->Html->link($this->Text->truncate($value['title'],35),array('controller'=>'jump_hosts','action'=>'detail',$value['slug'])); ?></h5>
				
				<div class="star-patten">
					<?php $ratings = $value['rating']; ?>
					<?php $disable_rating = 5 - $value['rating'];?>
					<?php for($i=1; $i<=$ratings; $i++) {?>
						<i class="fa fa-star"></i>
					<?php } ?>
					<?php for($i=1; $i<=$disable_rating; $i++) {?>
						<i class="fa fa-star disable"></i>
					<?php } ?>
				   </div>
				<address><?php echo $value['address_line_1']; ?>, <?php echo $value['address_line_2']; ?>, <?php echo $value['city']; ?> </address>
				<span><?php echo $this->text->truncate($value['description'],100); ?> </span>
			</div>
			<div class="search_right">
				<h5><?php
					if($value['rating'] >= 4)
					{
						echo "Very Good!";
						
					} 
					else if($value['rating'] >=3 && $value['rating'] < 4 )
					{
						
						echo "Good!";
					}
					else if($value['rating'] >=2 && $value['rating'] < 3)
					{
						echo "Bad";
					}
					else if($value['rating'] >0 && $value['rating'] < 2)
					{
						echo "Very Bad!";
					}
					else
					{
						echo "No Rated!";
					}
					
					?>   <span><?php echo $value['rating'];?> /5</span> </h5>
				<a href="javascript:void(0)" onclick="goToReview(this)" data-url="<?php echo $value['detail_url']; ?>"> <?php echo $value['review']; ?> Reviews<i class="fa fa-angle-right"></i></a>
				<h3><a href="javascript:void(0)">USD. <?php echo $value['price']; ?></a></h3><span>Rate Per night</span>
				<?php echo $this->Html->link('View Details',array('controller'=>'jump_hosts','action'=>'detail',$value['slug']),array('class'=>'btn btn-primary')); ?>
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
