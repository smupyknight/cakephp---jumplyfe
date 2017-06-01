<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo stripslashes(Configure::read('Site.title')); ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="shortcut icon" href="/jumplyfe/favicon.ico" />
		<link rel="icon" type="image/png" href="/jumplyfe/favicon.ico" />
		<link rel="apple-touch-icon" href="/jumplyfe/favicon.ico" />
		<meta name="description" content="" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="keywords" content="" />
		<?php echo $this->Html->meta('icon'); ?>
		<?php echo $this->Html->script(array('jquery.min','jquery-ui' ,'bootstrap.min','bootstrap-timepicker','jquery.form','script','select2.min','jquery.noty.packaged.min','star-rating','bootstrap-switch','jwplayer','jquery.infinitescroll.min','typeahead.bundle','jquery.fancybox.pack')); ?>
		<script type="text/javascript">jwplayer.key="1lv5l1D4IRjT0TgGMbiIma9JNzSIB4Q5HUPVCA==";</script>
		<?php echo $this->Html->css(array('jquery-ui','bootstrap','bootstrap-theme','font-awesome.min','my_css','select2.min','notify-animate','star-rating','bootstrap-switch','jquery.fancybox'));?>
		<?php echo $this->fetch('css'); ?>
		<?php echo $this->fetch('script'); ?>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
		<link href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
		<script type="text/javascript">
			$(function(){
				
				$(".close").click(function(){
					$(".alert-message").fadeOut();
				});
				$(".ajax_alert .close").click(function(e){
					e.preventDefault();
					$(this).closest('.ajax_alert').fadeOut();
					return false;
				});
				$(".datepicker").datepicker({
					format: "dd-mm-yyyy",
					startDate: "today"
				}); 
				
				
				$('.datepicker').on('changeDate', function(ev){
					$(this).datepicker('hide');
				});
			});
			
			var SiteUrl =  '<?php echo WEBSITE_URL; ?>';
			</script> 
			
		<script type="text/javascript">
		$(function(){
			$(".fancybox").fancybox();
			//$('.ajax_form').submit(function(event){
			$(document).on("submit", '.ajax_form', function(event) { 
				var $submitBTN = $(this).find('button[type="submit"]');
				var $btnText = $submitBTN.text();
				$submitBTN.text('Loading...');
				$submitBTN.attr('disabled','disabled');
				var posturl=$(this).attr('action');
				var $this = $(this).closest('form');
				var formID =$(this).attr('id');
				var formClass =$(this).attr('class');
				if(!formID)
				formID = formClass;
				$(this).ajaxSubmit({
								url: posturl,
								dataType: 'json',
								success: function(response){
									$submitBTN.removeAttr('disabled');
									$submitBTN.text($btnText);
									$($this).find('.ajax_alert').removeClass('alert-danger').removeClass('alert-success');
									$($this).find('.ajax_alert').fadeOut('fast')
									if(response.success)
									 {
										$($this).find('.ajax_alert').addClass('alert-success');
										window.madeChangeInForm = false;
									 }
									 else
									 {
										 $($this).find('.ajax_alert').addClass('alert-danger');
									 }
									if(response.message)
									{
										if(response.notify)
										{
											var notyData = [];
											notyData.message = response.message;
											if(response.success)
											{
												notyData.type = 'success';
											}
											else
											{
												notyData.type = 'error';
											}
											
											nofifyMessage(notyData);
										}
										else
										{
											$($this).find('.ajax_alert').fadeIn('slow').children('.ajax_message').html(response.message);
										}
									}
									if(response.redirectURL)
									window.location.href=response.redirectURL;
									if(response.scrollToThisForm)
									slideToElement($this);
									if(response.selfReload)
									window.location.reload();
									if(response.resetForm)
									$($this).resetForm();
									if(response.changeLoginState)
									changeLoginState(response);
									if(response.callBackFunction)
									callBackMe(response.callBackFunction,response);
								
								},
								error:function(response){
									$submitBTN.removeAttr('disabled');
								}
							});
				return false;
			});
			$('.modal').on('hidden.bs.modal', function () {
				$(this).find('.ajax_alert').hide('slow');
			});
		});

		function callBackMe(functionName,data)
		{
			window[functionName](data);
		}
		function slideToElement(element,callback)
		{
			$("html, body").animate({scrollTop: $(element).offset().top }, 1000,function(){
				if(callback)
				{
					callback.call();
				}
			});
		}
		function nofifyMessage(data)
		{
			type = data.type;
			message = data.message;
			type = type?type:'warning'; // success,error,information,success
			message = message?message:'This is Test Message <span>by Vikas</span>';
			var iconClass = '';
			if(type == 'warning')
			{
				iconClass = '<i class="fa fa-exclamation-triangle text-danger"></i>';
			}
			else if(type == 'success')
			{
				iconClass = '<i class="fa fa-check-circle text-success"></i>';
			}
			else if(type == 'error')
			{
				iconClass = '<i class="fa fa-times-circle text-danger"></i>';
			}
			else if(type == 'information')
			{
				iconClass = '<i class="fa fa-info-circle text-info"></i>';
			}
			
			message = '<div class="activity-item">'+iconClass+'<div class="activity">'+message+'</div> </div>';
			//$.notify("This is demo message", type);
			var n = noty({
                text        : message,
                type        : type,
                dismissQueue: true,
                layout      : 'topLeft',
                closeWith   : ['click'],
                theme       : 'relax',
                maxVisible  : 10,
				timeout: 4000, 
				force: false,
				modal: false,
                animation   : {
                    open  : 'animated bounceInLeft',
                    close : 'animated bounceOutRight',
                    easing: 'swing',
                    speed : 1200
                }
            });
		}
		</script>
		<?php echo $this->Html->script('browser'); ?>
	</head>
	<body>
		<script type="text/javascript">
			$(function() {
				$(".close").click(function() {
					$(".alert-message").fadeOut();
				});
			});
		</script>
		<?php echo $this->element('header');  ?>
		<?php echo $this->fetch('content');  ?>
		<?php echo $this->element('footer');?> 
	</body>
</html>
