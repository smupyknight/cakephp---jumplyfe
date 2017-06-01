<?php $userData = $this->requestAction(array('controller' => 'users', 'action' => 'user_profile_for_left',$left_part_user_id)); 
?>

<div class="col-md-3 col-sm-3">
	<div class="section">
		<div class="user-section">
			<?php
			$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
			$file_name		=	$userData['userData']['image'];
			if($file_name && file_exists($file_path . $file_name)) {
				$box_image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',0,0,base64_encode($file_path),$file_name),true);
				$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',202,0,base64_encode($file_path),$file_name),true);
				$image =  $this->Html->image($image_url,array('class'=>'userimage'));
				echo $this->Html->link($image,$box_image_url,array('class'=>'fancybox','escape'=>false));
			}
			else 
			{
				echo $this->Html->image('main_profile.png',array('class'=>'userimage'));
			}
			?>
			<div class="clearfix"></div>
			<?php if($userData['userData']['elite_membership_status'] == 'Active') { ?><?php echo $this->html->image('icon.png')?> <?php } ?>
			<span class="profile_user_name"><?php echo $this->Text->truncate(ucfirst($userData['userData']['firstname']).' '.ucfirst($userData['userData']['lastname']),20); ?></span>
		</div>
		<hr>
		<?php if($userData['userData']['country_name'] && $userData['userData']['city_name']) { ?>
			
			<div class="location"><i class="fa fa-map-marker"></i><?php echo $userData['userData']['city_name'];?>, <?php echo $userData['userData']['country_name'];?></div>
		
		<?php } ?>
		<?php if($userData['userData']['id'] != authComponent::user('id')) { ?>
		<ul class="menu_right">
			
				<?php if($userData['friend_record']['Friend']['id']){ ?>
					<li><?php echo $this->Html->link('Remove','javascript:void(0)',array('onClick'=>'removeFriend(this)','data-id'=>$userData['profile_user_id'])); ?></li>
				<?php } else { ?>
					<?php if(isset($userData['friend_request_sent']['FriendRequest']['id']) && !empty($userData['friend_request_sent']['FriendRequest']['id'])) { ?>
						<li><?php echo $this->Html->link('Pending','javascript:void(0)',array()); ?></li>
					<?php } else { ?>
						<li class="removeAddButton"><?php echo $this->Html->link('Add','javascript:void(0)',array('onClick'=>'addFriend(this)','data-id'=>$userData['profile_user_id'])); ?></li>
					<?php } ?>
				<?php } ?>
			
			<li class=""><?php echo $this->Html->link('Message',array("plugin"=>false,"controller"=>"messages",'action' => 'index',$userData['userData']['slug']),array('class'=>(isset($left_menu_selected) && $left_menu_selected == 'Message')?'active':'')); ?></li>
			<?php if(authComponent::user('id')){?>
				<li><?php echo $this->Html->link('Send Jump Cash','javascript:void(0)',array('onClick'=>'sendMoney()')); ?></li>
			<?php } ?>
			<?php if($userData['userData']['is_jump_host'] == 'Yes') { ?>
			<li><?php echo $this->Html->link('Jump Rental',array("plugin"=>false,"controller"=>"jump_hosts",'action' => 'profile_user_jump_rental',$userData['userData']['slug']),array('class'=>(isset($left_menu_selected) && $left_menu_selected == 'My_Jump_Host')?'active':'')); ?></li>
			<?php } ?>
			
				<?php if($userData['userData']['is_host_jumper'] == 'Yes'){ ?>
				
				<li class=""><?php echo $this->Html->link('Host Jumper',array("plugin"=>false,"controller"=>"host_jumpers",'action' => 'index',$userData['userData']['slug']),array('class'=>'')); ?></li>
				<?php } ?>
			
		
		</ul>
		<?php } else { ?>
			
			<ul class="menu_right">
			
			<li class=""><?php echo $this->Html->link('Inbox',array("plugin"=>false,"controller"=>"messages",'action' => 'index'),array('class'=>(isset($left_menu_selected) && $left_menu_selected == 'Message')?'active':'')); ?></li>
			
		
			<li class=""><?php echo $this->Html->link('Groups',array("plugin"=>false,"controller"=>"groups",'action' => 'index'),array('class'=>(isset($left_menu_selected) && $left_menu_selected == 'Groups')?'active':'')); ?></li>
			
			</ul>
			
		<?php } ?>
		<hr>
			<h2 class="title"><?php echo $this->Html->link('JUMP MATES',array('plugin'=>false,'controller'=>'users','action'=>'jump_mates'),array('class'=>'jump_mates_text')); ?></h2>
			<form method="get"  action="<?php echo $this->Html->url(array('plugin'=>false,'controller'=>'searches','action'=>'jumpers')); ?>">
				<input type="text" placeholder ="Search" name="name" class="search jumper_serches" />
			</form>
			<?php if(isset($userData['friends']) && !empty($userData['friends'])) { ?>
			
			<ul class="user_icon no_jump_mate">
				<li><span class="no_jump_mate_found"></span></li>
				<?php //pr($userData['friends']); ?>
				<?php foreach($userData['friends'] as $key => $value){ ?>
				<?php
				$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
				$file_name		=	$value['User']['image'];
				$name  = ucfirst($value['User']['firstname']).' '.ucfirst($value['User']['lastname']);
				if($file_name && file_exists($file_path . $file_name)) {
					$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$file_name),true);
					echo '<li class = "friend_Record_List_'.$value['User']['id'].'">';
					echo $this->Html->image($image_url,array('url'=>'/'.$value['User']['slug'],'class'=>'img_radius','title'=>$name));
					echo '</li>';
				} else {
					echo '<li class = "friend_Record_List_'.$value['User']['id'].'">';
					echo $this->html->image('johnsmall.png',array('url'=>'/'.$value['User']['slug'],'class'=>'img_radius','title'=>$name));
					echo '</li>';
				}
				?>
				<?php } ?>
			
			</ul>
			<?php } else { ?>
				<ul class="user_icon no_jump_mate">
					<li><span class="no_jump_mate_found">No Jump Mates Found</span></li>
				</ul>
			<?php } ?>
			<!--<a class="see" href="#">See All<i class="fa fa-angle-right"></i></a>-->
	</div>
		<?php echo $this->element('advertisement_left'); ?>


<div class="modal fade" id="SendMoneyPopUp" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Send Jump Cash</h4>
			</div>
			<?php echo $this->Form->create('UserSentAmount',array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'send_money',$userData['profile_user_id']),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php echo $this->Form->input('UserSentAmount.amount',array('class'=>'form-control','placeholder'=>'Amount','label'=>false)); ?>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("user_sent_amounts", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
function sendMoney()
{
	$("#SendMoneyPopUp").modal('show');
}
</script>
<script>
	function addFriend($this){
		var id = $($this).attr('data-id');
		if(id != ""){
			$.ajax({
				type: "post",
				url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'send_friend_request')); ?>",
				data:{'id':id},
				dataType:"json",
				success:function(data){
					if(data.success == true){
						if(data.friends){
							$('.user_icon').find('.no_jump_mate_found').text('');
							$($this).text('Remove');
							$($this).attr('onClick','removeFriend(this)');
							if(data.image_url != '')
							{
								var image = '<img src="'+data.image_url+'" class="img_radius" title="'+data.name+'" />';	
								
							}
							else
							{
								var image = '<img src="img/johndoe.png" class="img_radius" title="'+data.name+'" />';
							}
							var html = '<li class = "friend_Record_List_'+data.user_id+'"><a href="'+SiteUrl+data.slug+'">'+image+'</a></li>';
							$('.user_icon').prepend(html);
							var notyData = [];
							notyData.message = 'Added to your friend list. <span>just now</span>';
							notyData.type = 'success';
							nofifyMessage(notyData);
						}
						else
						{
							$('.removeAddButton').html('');
							$('.removeAddButton').html('<a href="javascript:void(0)" class="">Pending</a>');
							var notyData = [];
							notyData.message = 'Your friend request has been successfully sent. <span>just now</span>';
							notyData.type = 'success';
							nofifyMessage(notyData);
							
						}
					}
					else if(data.error_type == 'auth')
					{
						window.location.href = data.redirectURL;
					}
					else if(data.error_type == 'same_profile')
					{
						var notyData = [];
						notyData.message = data.message;
						notyData.type = 'warning';
						nofifyMessage(notyData);
						//alert(data.message); return false;
					}	
				}	
			});
		}
	}
	
	/*function addFriend($this){
		var id = $($this).attr('data-id');
		if(id != ""){
			$.ajax({
				type: "post",
				url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'add_friend')); ?>",
				data:{'id':id},
				dataType:"json",
				success:function(data){
					if(data.success == true){
						//window.location.reload();
						$($this).text('Remove');
						$($this).attr('onClick','removeFriend(this)');
						var notyData = [];
						notyData.message = 'Added to your friend list <span>just now</span>';
						notyData.type = 'success';
						nofifyMessage(notyData);
						$('.user_icon').find('.no_jump_mate_found').text('');
						if(data.image_url != '')
						{
							var image = '<img src="'+data.image_url+'" class="img_radius" title="'+data.name+'" />';	
							
						}
						else
						{
							var image = '<img src="img/johndoe.png" class="img_radius" title="'+data.name+'" />';
						}
						var html = '<li class = "friend_Record_List_'+data.user_id+'"><a href="'+SiteUrl+'profile/'+data.slug+'">'+image+'</a></li>';
						$('.user_icon').prepend(html);
					}
					else if(data.error_type == 'auth')
					{
						window.location.href = data.redirectURL;
					}
					else if(data.error_type == 'same_profile')
					{
						var notyData = [];
						notyData.message = data.message;
						notyData.type = 'warning';
						nofifyMessage(notyData);
						//alert(data.message); return false;
					}	
				}	
			});
		}
	}*/

	function removeFriend($this)
	{
		var id = $($this).attr('data-id');
		if(id != ""){
			$.ajax({
				type: "post",
				url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'remove_friend')); ?>",
				data:{'id':id},
				dataType:"json",
				 success:function(data){
					if(data.success == true){
						$($this).text('Add');
						$($this).attr('onClick','addFriend(this)');
						var notyData = [];
						notyData.message = 'Removed from your friend list <span>just now</span>';
						notyData.type = 'success';
						nofifyMessage(notyData);
						$('.user_icon').find('.friend_Record_List_'+data.user_id).remove();
						if(data.friends == 0){
							$('.user_icon').find('.no_jump_mate_found').text('No Jump Mates Found');
						}
					}
					else
					{
						window.location.href = "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'login')); ?>"
					}	
				}
			});
		
		}
	}
	

</script>
