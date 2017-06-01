<?php echo $this->element('menu');?>
<script>
var open_chat_group_id = '<?php echo $chat_group_id; ?>';
function actionBeforeSubmit()
{
	$(".chat_form_main .message").attr('readonly','readonly');
	$(".chat_form_main submit-btn").attr('disabled','disabled');
	$(".chat_form_main .submit-btn").val('wait...');
}
function actionAfterChatResponse(data)
{
	$(".chat_form_main .message").removeAttr('readonly').val('');
	$(".chat_form_main button").removeAttr('disabled');
	$(".chat_form_main .submit-btn").val('Send');
}
$(function(){
	
	$(".submit-enter").keypress(function(event) {
		if (event.which == 13) {
			

			var attr = $(".chat_form_main .submit-btn").attr('disabled');

			if($(this).val() && (typeof attr == typeof undefined && attr !== false))
			{
				event.preventDefault();
				actionBeforeSubmit();
				$(this).closest("form").submit();
			}
			else
			{
				$(this).focus();
				event.preventDefault(); return false;
			}
			
		}
	});
	//$(".chatUsers li").click(function(){
	$(document).on("click", '.chatUsers li', function(e) { 
	
		var chat_group_id = ($(this).attr('data-chat_group_id'));
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		$("#form_chat_group_id").val(chat_group_id);
		$(".open_chat_window").attr('data-chat_group_id',chat_group_id);
		$(".submit-btn").removeAttr('disabled');
		loadFrameChat();
	});
	loadChatSessions();
	setInterval(function(){
		fetchNewChat();
	},2000)
});
function loadChatSessions()
{
	var url = '<?php echo Router::url(array('controller' => 'messages', 'action' => 'loadChatSessions')); ?>';
	$.getJSON(url,function(data){
		if(data.chatsessions.length)
		{
			$(".chat_session_list").html('');
		}
		else
		{
			$(".chat_session_list .no_chat_list").text('Chat User list.... You have not started any chat yet');
		}
		
		$.each(data.chatsessions,function(key,value){
			if(value.image_url)
			{
				image_url = '<img src="'+value.image_url+'" class="img_radius">';
			}
			else
			{
				image_url = '<?php echo $this->Html->image('user-noimage-small.png',array("class"=>"img_radius")); ?>';
			}
			var html = '<li class="li_chat_group_'+value.chat_group_id+'" data-chat_group_id="'+value.chat_group_id+'" data-latest_message_id="'+value.latest_message_id+'">'+image_url+'<div class="chat_content"><h5>'+value.title+' </h5><p class="p_message">'+value.message+'</p><span class="time_ago">'+value.message_time_ago+'</span></div></li>';
			$(".chat_session_list").append(html);
			$(".chat_session_list").addClass('chat_group_'+value.chat_group_id);
		});
		$(".chatDataOverall").attr('data-latest_message_id',data.last_message_to_user_id);
		setTimeout(function(e){
			if(open_chat_group_id)
			{
				$(".chat_session_list .li_chat_group_"+open_chat_group_id).trigger('click');
				slideToElement(".submit-enter");
					$(".submit-enter").focus();
				
			}
			else
			{
				$(".chat_session_list li:first").trigger('click');
			}
			
		},200);
		
	});
}
function loadFrameChat()
{
	$(".open_chat_window").html('');
	var open_chat_group_id = $(".open_chat_window").attr('data-chat_group_id');
	var url = '<?php echo Router::url(array('controller' => 'messages', 'action' => 'getLastChatByGroupId')); ?>';
	$.getJSON(url+'?open_chat_group_id='+open_chat_group_id,function(data){
		if(data.success)
		{
			$.each(data.messages,function(key,value){
				if(value.is_owner == 'Yes')
				{
					var float_class = 'right';
				}
				else
				{
					var float_class = 'left';
				}
				if(value.image_url)
				{
					image_url = '<img src="'+value.image_url+'" class="img_radius">';
				}
				else
				{
					image_url = '<?php echo $this->Html->image('user-noimage-small.png',array("class"=>"img_radius"))?>';
				}
				var html = '<li class="'+float_class+'">'+image_url+'<div class="message_content"><p><strong>'+value.sender_name+' : </strong><span class="userMessage">'+value.message+'</span></p><date>'+value.message_time_ago+'</date><span class="languageLink"><a href="javascript:void(0)" class="changeLanguage label label-default" onclick="changeLanguage(this)" data-original_message="'+value.message+'"  data-message_id = "'+value.message_id+'">Translate</a></span></div></li>';
				$(".open_chat_window").append(html);
				$(".open_chat_window").scrollTop($(".open_chat_window")[0].scrollHeight);
			});
		}
		
	});
}
function fetchNewChat()
{
	var latest_message_id = $(".chatDataOverall").attr('data-latest_message_id');
	if(!latest_message_id)
	{
		latest_message_id = 0;
	}
	var url = '<?php echo Router::url(array('controller' => 'messages', 'action' => 'fetchNewChat')); ?>';
	$.getJSON(url+'?latest_message_id='+latest_message_id,function(data){
		$.each(data.messages,function(key,value){
			$(".chatDataOverall").attr('data-latest_message_id',value.id);
				if(value.is_owner == 'Yes')
				{
					var float_class = 'right';
				}
				else
				{
					var float_class = 'left';
				}
				if(value.image_url)
				{
					image_url = '<img src="'+value.image_url+'" class="img_radius">';
				}
				else
				{
					image_url = '<?php echo $this->Html->image('user-noimage-small.png',array("class"=>"img_radius"))?>';
				}
				if($(".open_chat_window").attr('data-chat_group_id') == value.chat_group_id)
				{
					var html = '<li class="'+float_class+'">'+image_url+'<div class="message_content"><p><strong>'+value.sender_name+' : </strong><span class="userMessage">'+value.message+'</span></p><date>'+value.message_time_ago+'</date><span class="languageLink"><a href="javascript:void(0)" class="changeLanguage label label-default" onclick="changeLanguage(this)" data-original_message="'+value.message+'"  data-message_id = "'+value.id+'">Translate </a></span></div></li>';
					$(".open_chat_window").append(html);
					$(".open_chat_window").scrollTop($(".open_chat_window")[0].scrollHeight);
				}
				if($(".chat_session_list").hasClass('chat_group_'+value.chat_group_id))
				{
					$thisLi = $(".chat_session_list .li_chat_group_"+value.chat_group_id);
					$thisLi.find('img').replaceWith(image_url);
					$thisLi.find('.p_message').html(value.message);
					$thisLi.find('.time_ago').html(value.message_time_ago);
					if(value.notify_message)
					{
						$thisLi.addClass('message_notify_new');
						setTimeout(function(){
							$thisLi.removeClass('message_notify_new');
						},1000);
					}
				}
				
			});
	});
}
function sendChatMessage($this)
{
	if($("#ChatMessagesMessage").val() == '')
	{
		$("#ChatMessagesMessage").focus();
		return false;
	}
	else
	{
		actionBeforeSubmit();
		$($this).closest('form').submit();
	}
		
}
function openCreateChatPopup()
{
	$('#createChatUserPopup').modal('show');
	$(".main_body_open").hide();
	$(".no_record_body").hide();
	var url = '<?php echo Router::url(array('controller' => 'users', 'action' => 'getMyFriendsJSON')); ?>';
	$.getJSON(url,function(data){
		if(data.success)
		{
			if(data.friends.length)
			{
				$(".no_record_body").hide();
				$(".main_body_open").show();

				$(".my_friend_list").html('');
				$.each(data.friends,function(key,value){
					var html = '<div class="checkbox"><label><input value="'+value.id+'" type="checkbox" name="users[]">'+value.fullname+'</label></div>';
					$(".my_friend_list").append(html);
				});
			}
			else
			{
				$(".main_body_open").hide();
				$(".no_record_body").show();
			}
			
		}
	});
}
function callBackActionAfterGroupCreated()
{
	$('#createChatUserPopup').modal('hide');
	loadChatSessions();
}
function changeLanguage($this)
{
	var message_id = $($this).attr('data-message_id');
	this_text = $($this).text();
	$($this).addClass('disabled');
	$($this).removeAttr('onclick');
	$($this).text('wait...');
	$.ajax({
		type: "post",
		url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"messages",'action' => 'translateLanguage')); ?>",
		data:{'message_id':message_id},
		success:function(data){
			$($this).closest('li').find('.userMessage').text(data);
			$($this).attr('onclick','showOriginalMessage(this)');
			$($this).text('See Original');
			$($this).removeClass('disabled');
		}
		
		
	});
}
function showOriginalMessage($this){
	$($this).closest('li').find('.userMessage').text($($this).attr('data-original_message'));
	$($this).attr('onclick','changeLanguage(this)');
	$($this).text('Translate');
	
}
</script>
<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
	 <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
        <div class="col-md-9 col-sm-9">
		<button onClick="openCreateChatPopup()" type="button" class="btn btn-primary pull-right" style="margin:6px;">Start New Conversion</button>
			<div class="chatSection chatDataOverall" data-last_message_id="">
				<ul class="chatUsers chat_session_list">
					<div class="no-record no_chat_list" style="padding: 10px">Your All Chat Users Will List Here...</div>
				</ul>
				<div class="chatBlock">
					<ul class="chat_messages open_chat_window" data-chat_group_id="">
						<div style="padding: 50px" class="no-record"><a href="JavaScript:" class="default_link_style" type="button" onclick="openCreateChatPopup()">Click here to start a new chat</a></div>
					</ul>
				<?php echo $this->Form->create('ChatMessages', array('class'=>'ajax_form chat_form_main','url' => array('controller' => 'Messages','action' => 'newPost'))); ?>
					<div class="messageBox">
					<?php echo $this->Form->input('ChatMessages.message',array('class' =>'form-control submit-enter message','label'=>false,'placeholder' => 'Type here...'));?>
						<input type="hidden" id="form_chat_group_id" name="data[ChatMessages][chat_group_id]">
			        	<input class="btn btn-primary submit-btn" disabled="disabled" onClick="sendChatMessage(this)" type="button" value="Send">
				    </div>
				<?php echo $this->Form->end();?>


				</div>
			</div> 
        </div>
     </div>
  </div>
</div>

<div class="modal fade" id="createChatUserPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title" id="myModalLabel">Start New Conversion</h4>
            </div>
			<?php echo $this->Form->create('Users',array('url'=>array('plugin'=>false,'controller'=>'messages','action'=>'createNewChat'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body main_body_open">
			<div class="form-group">
			<p>Please Select Your Friends and Create Group Chat</p>
			<div class="input text"><input type="text" id="GroupName" value="" maxlength="255" required="required" placeholder="Enter Group Title" class="form-control validate[required]" name="group_title"></div>
				<div class="my_friend_list">
					
					
				</div>
			</div>
			</div>
			<div class="modal-body no_record_body">
				<div class="no-record">Please make atleast one friend to start a new chat</div>
			</div>

			<div class="modal-footer main_body_open">
				<?php echo $this->Form->button(__d("users", "START NOW", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
