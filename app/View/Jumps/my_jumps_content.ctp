<style>
.myprofile .top_title a{
	color:white;
}
</style>
<script language="javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<?php if(isset($my_jumps_record) && !empty($my_jumps_record)){ ?>
	<div class="pg-post-list">
		<?php foreach($my_jumps_record as $key =>$value){ ?>
		<div class="myprofile post-item">
			<div class="top_title">
				<h3><?php echo $this->Text->truncate($value['Jump']['title'],30); ?><span><?php if(!empty($value['Jump']['city'])) {  echo $this->Text->truncate($value['Jump']['city'],15) .',' ; } ?> <?php echo $this->Text->truncate($value['Jump']['country'],15); ?></span></h3>
				<?php echo $this->Html->link('Edit',array('plugin'=>false,'controller'=>'jumps','action'=>'edit_my_jump',$value['Jump']['slug']),array('class'=>'btn btn-primary text-upper')); ?>
				<?php echo $this->Html->link('Jump Mates','javascript:void(0)',array('class'=>'btn btn-primary text-upper','onclick'=>'friendMates(this)','data-id'=>$value['Jump']['id'])); ?>
				<div class="clearfix"></div>
			</div>
			<div class="row post-item-detail">
				<div class="col-md-3 col-sm-5">
					<?php
					$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
					$file_name		=	$value['Jump']['image'];
					if($file_name && file_exists($file_path . $file_name)) {
					$box_image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',0,0,base64_encode($file_path),$file_name),true);
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',375,425,base64_encode($file_path),$file_name),true);
						$image =  $this->Html->image($image_url,array('class'=>'img-responsive JumpRental_Image'));
						echo $this->Html->link($image,$box_image_url,array('class'=>'fancybox','escape'=>false));
					}
					else 
					{
						echo $this->Html->image('no_image.png',array('class'=>'img-responsive JumpRental_Image'));
					}
					?>
				</div>
				<div class="col-md-4 col-sm-7">
					<ul>
						<li><strong><?php echo $this->Text->truncate($value['Jump']['title'],20); ?></strong></li>						
						<li><?php echo $this->Text->truncate($value['Jump']['description'],100); ?></li>
					</ul>
				</div>
				<div class="col-md-2 col-sm-5">
					<div class="jumps_btns row">
						<div class="col-sm-12 col-xs-3 devicefull">
							<?php echo $this->Html->link('Photos',array('plugin'=>false,'controller'=>'jumps','action'=>'photo_gallery',$value['Jump']['slug']),array('class'=>'btn btn-success text-upper')); ?>
						</div>
						<div class="col-sm-12 col-xs-3 devicefull">
							<?php echo $this->Html->link('Videos',array('plugin'=>false,'controller'=>'jumps','action'=>'video_gallery',$value['Jump']['slug']),array('class'=>'btn btn-primary text-upper')); ?>
						</div>
						<div class="col-sm-12 col-xs-3 devicefull">
							<?php echo $this->Html->link('Delete',array('plugin'=>false,'controller'=>'jumps','action'=>'delete_my_jump',$value['Jump']['slug']),array('confirm'=>'Are you sure you want to delete this Jump?','class'=>'btn btn-danger text-upper')); ?>
						</div>
						<div class="col-sm-12 col-xs-3 devicefull">
							<?php echo $this->Html->link('Details',array('plugin'=>false,'controller'=>'jumps','action'=>'my_jump_details',$value['Jump']['slug']),array('class'=>'btn btn-primary text-upper')); ?>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-7">
					<div style="height:auto; width:100%;" class="map_<?php echo $key; ?> iframe"></div>
					<script>
					$(document).ready(function (){
						var myLatlng = new google.maps.LatLng(<?php echo $value['Jump']['latitude']; ?>,<?php echo $value['Jump']['longitude']; ?>);
						var myOptions = {
							zoom: 12,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						}
						map = new google.maps.Map($('.map_<?php echo $key; ?>')[0], myOptions);
						var marker = new google.maps.Marker({
							position: myLatlng, 
							map: map,
							title:"Fast marker"
						});
					});
					</script>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php } ?>
	</div>
	<?php echo $this->Paginator->next(''); ?>
<?php } else {?>
	<div class="no-record">No Jump created by you</div>
<?php } ?>        
<script>
$(function(){
	//var $container = $('#posts-list');
	$('.pg-post-list').infinitescroll({
		navSelector  : '.next',    // selector for the paged navigation 
		nextSelector : '.next a',  // selector for the NEXT link (to page 2)
		itemSelector : '.post-item',     // selector for all items you'll retrieve
		debug		 	: true,
		dataType	 	: 'html',
		loading: {
		  finishedMsg: '',
		  img: '<?php echo $this->webroot; ?>img/spinner.gif'
		}
	});
});

function friendMates($this){
	var id  = $($this).attr('data-id');
	$.ajax({
		type: "post",
		url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"jumps",'action' => 'jumpMates')); ?>",
		data:{'id':id},
		dataType:"json",
		success:function(data){
			if(data.success)
			{
				$(".my_friend_list").html('');
				$.each(data.friends,function(key,value){
					var html = '<div class="checkbox"><label><input value="'+value.id+'" type="checkbox" name="data[Jump][user_id][]" '+value.checked+'>'+value.name+'</label></div>';
					$(".my_friend_list").append(html);
				});
			}
			$('#jumpMatesPopup').modal('show');
			$('#jumpMatesPopup #jumpIdValue').val(id);
		}
	
	});
}

</script>
<div class="modal fade" id="jumpMatesPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Jump Mates</h4>
            </div>
			<?php echo $this->Form->create('Jump',array('url'=>array('plugin'=>false,'controller'=>'jumps','action'=>'createNewJumpMate'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
			
			<div class="form-group">
			<p>Please Select Your Friends</p>
				<div class="my_friend_list">
					
					
				</div>
				<?php echo $this->Form->input('Jump.jump_id',array('type'=>'hidden','value'=>'','class'=>'','id'=>'jumpIdValue'));?>
			</div>
			
				
			</div>

			<div class="modal-footer">
				<?php echo $this->Form->button(__d("jumps", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
