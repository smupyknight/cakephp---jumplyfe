<?php echo $this->element('menu');?>
<div class="right_profile bgcolor">
	<div class="container">
		<div class="row">
			<?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
				<?php echo $this->element('user_profile_left_bar');?>
			<?php } ?>
			<div class="col-md-9 col-sm-9">
				<div class="jumper_search">
					<h6>JUMP MATES</h6>
					<div class="row">
						<?php if(isset($friends) && !empty($friends)) { ?>
							<?php foreach($friends as $key => $value) {?>
								<div class="col-md-4 col-sm-6 col-xs-6 device_full">
									<div class="person_detail">
										<?php
											$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
											$file_name		=	$value['User']['image'];
											if($file_name && file_exists($file_path . $file_name)) {
												$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,80,base64_encode($file_path),$file_name),true);
												echo $this->Html->image($image_url,array('url'=>'/'.$value['User']['slug'],'class'=>'img_radius'));
											}
											else 
											{
												echo $this->Html->image('user1.png',array('url'=>'/'.$value['User']['slug'],'class'=>'img_radius'));
											}
										?>
										<div class="people_name"><h4 class="user_name"><?php $full_name = $value['User']['firstname'].' '.$value['User']['lastname']; ?><?php echo $this->Html->link($this->Text->truncate($full_name,18),'/'.$value['User']['slug']);?></h4>
										<p><?php if(!empty($value['User']['city'])){ echo $value['User']['city'].', '; } ?> <?php if(!empty($value['User']['country'])){ echo $value['User']['country']; } ?></p></div>
									</div>
								</div>
							<?php } ?>
						<?php } else { ?>
							<div class="no-record">No Jump Mates Found</div>
						<?php } ?>
					</div>
				</div>
				<?php if(isset($friends_requests) && !empty($friends_requests)) { ?>
				<div class="jumper_search">
					<h6>FRIEND REQUESTS</h6>
					<div class="row">
						<?php foreach($friends_requests as $key => $value) {?>
							<div class="col-md-6 col-sm-6 col-xs-6 device_full friendRequests">
								<div class="person_detail frnd_reqst">
									<?php
										$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
										$file_name		=	$value['Sender']['image'];
										if($file_name && file_exists($file_path . $file_name)) {
											$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,80,base64_encode($file_path),$file_name),true);
											echo $this->Html->image($image_url,array('url'=>'/'.$value['Sender']['slug'],'class'=>'img_radius'));
										}
										else 
										{
											echo $this->Html->image('user1.png',array('url'=>'/'.$value['Sender']['slug'],'class'=>'img_radius'));
										}
									?>
									<div class="people_name"><h4 class="user_name"><?php $full_name = $value['Sender']['firstname'].' '.$value['Sender']['lastname']; ?><?php echo $this->Html->link($this->Text->truncate($full_name,30),'/'.$value['Sender']['slug']);?></h4>
									<span class="btn btn-info" onclick="confirmRequest(this)" data-id = "<?php echo $value['FriendRequest']['id']; ?>">Confirm</span> <span class="btn btn-danger" onclick="deleteRequest(this)" data-id="<?php echo $value['FriendRequest']['id']; ?>">Delete Request</span>
									</div>
								</div>
							</div>
						<?php } ?>	
					</div>
				</div>
				<?php }  ?>
			</div> 
		</div>
	</div>
</div>
		
<script>
function confirmRequest($this){
	var id = $($this).attr('data-id');
	if(id != ''){
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'confirm_friend_request')); ?>",
			data:{'id':id},
			dataType:"json",
			success:function(data){
				if(data.success){
					location.reload(); 
					
				}
			}
		});
	}
}

function deleteRequest($this){
	var id = $($this).attr('data-id');
	if(id != ''){
		$.ajax({
			type: "post",
			url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'delete_friend_request')); ?>",
			data:{'id':id},
			dataType:"json",
			success:function(data){
				if(data.success){
					location.reload();
				}
			}
		});
	}
}
</script>
