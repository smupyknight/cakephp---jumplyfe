<?php
	include("db/config.php");
?>

<!DOCTYPE html>
<html lang="en">
	
<!-- Mirrored from www.jumplyfe.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Sep 2015 16:27:32 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>JumpLyfe - Be A Jumper!</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="shortcut icon" href="jumplyfe/favicon.html" />
		<link rel="icon" type="image/png" href="jumplyfe/favicon.html" />
		<link rel="apple-touch-icon" href="jumplyfe/favicon.html" />
		<meta name="description" content="" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="keywords" content="" />
		<link href="favicon.ico" type="image/x-icon" rel="icon" /><link href="favicon.ico" type="image/x-icon" rel="shortcut icon" />		
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/select2.min.js"></script>
	<script type="text/javascript" src="js/jquery.noty.packaged.min.js"></script>
	<script type="text/javascript" src="js/star-rating.js"></script>
	<script type="text/javascript" src="js/bootstrap-switch.js"></script>
	<script type="text/javascript" src="js/jwplayer.js"></script>
	<script type="text/javascript" src="js/jquery.infinitescroll.min.js"></script>
	<script type="text/javascript" src="js/typeahead.bundle.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
		<script type="text/javascript">jwplayer.key="1lv5l1D4IRjT0TgGMbiIma9JNzSIB4Q5HUPVCA==";</script>
        
        
        <!-- Files for slider -->        
<script type="text/javascript" language="javascript" src="js/New folder/jquery.carouFredSel-6.2.1-packed.js"></script>

		<!-- optionally include helper plugins -->
<script type="text/javascript" language="javascript" src="js/New folder/jquery.mousewheel.min.js"></script>
<script type="text/javascript" language="javascript" src="js/New folder/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" language="javascript" src="js/New folder/jquery.transit.min.js"></script>
<script type="text/javascript" language="javascript" src="js/New folder/jquery.ba-throttle-debounce.min.js"></script>

<script type="text/javascript" language="javascript">
	$(function() {

		//	Basic carousel, no options
		$('#foo0').carouFredSel({
					items : 3,
        		direction : "left",
        		   scroll : {
            		items : 1,
            	   easing : "",
            	 duration : 500,
             pauseOnHover : true
        }
			});
		})
</script>

		<style type="text/css" media="all">
			.wrapper {
					}
			.list_carousel {
				margin: 0px;
				width: 1260px;
			}
			.list_carousel ul {
				margin: 0;
				padding: 0;
				list-style: none;
				display: block;
			}
			.list_carousel li {
				width: 400px;
				height: 300px;
				margin: 6px;
				float: left;
			}
			.list_carousel.responsive {
				width: auto;
				margin-left: 0;
			}
			.clearfix {
				float: none;
				clear: both;
			}
		</style>

        
        
        
		
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/my_css.css" />
	<link rel="stylesheet" type="text/css" href="css/select2.min.css" />
	<link rel="stylesheet" type="text/css" href="css/notify-animate.css" />
	<link rel="stylesheet" type="text/css" href="css/star-rating.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-switch.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" />
						<script src="../cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
		<link href="../eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
        
        
        <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
  </style>
        
        
        
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
			
			var SiteUrl =  'index.html';
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
		<script type="text/javascript" src="js/browser.js"></script>
        </head>
	<body>
		<script type="text/javascript">
			$(function() {
				$(".close").click(function() {
					$(".alert-message").fadeOut();
				});
			});
		</script>
		
<div class="navbar-fixed-top" style="margin-bottom:200px;">
<div class="header not_login">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
<a href="index.php" class="logo"><img src="img/logo.png" class="img-responsive" alt="" /></a>
 </div>
 
 
 
 
 
 
 
 
 
 
	<div class="col-md-6">
				<div class="top_bar">
	 <a href="signup.php" id="popupsignup" style="float:left; width:50x;">Signup</a>
	<a href="login.php" class="login" style="float:left;">login</a>
    <a href="contact_agent.php" id="popupsignup" style="float:left;">Contact Agent</a>
<div class="social_icon" style="float:left; margin-left:-700px; margin-top:10px;">
<a href="https://www.instagram.com/jumplyfe" target="_blank"><i class="fa fa-instagram"></i></a>						<a href="https://www.pinterest.com/jumplyfe" target="_blank"><i class="fa fa-pinterest-p"></i></a>						<a href="https://www.twitter.com/jumplyfe" target="_blank"><i class="fa fa-twitter"></i></a>						<a href="https://www.facebook.com/jumplyfe" target="_blank"><i class="fa fa-facebook"></i></a>				  </div>
				</div>
			</div>
		</div>
	</div>
</div>
				
	</div>				<!--<img src="uploads/photos/1437404566Dollarphotoclub_68878771.jpg" class="img-responsive" alt="0" />-->
                            
                            
  <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top:100px;">
    

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="img/11.jpg" style="height:475px; width:1000px;" />
      </div>

      <div class="item">
        <img src="img/12.jpg" style="height:475px; width:1000pxpx;" />
      </div>
    
      <div class="item">
        <img src="img/13.jpg" style="height:475px; width:1000pxpx;" />
      </div>

      <div class="item">
        <img src="img/14.jpg" style="height:475px; width:1000pxpx;" />
      </div>
  
   </div>
</div>
                    
                    
                    
                    
                    
                    
<div class="carousel-caption">
	<a href="login.html" class="btn btn-primary" style="margin-top:-150px;"><strong>Start</strong> a jump <i class="fa fa-play">
    </i>
    </a>
</div>
			
<div style="width:880px; margin-left:300px; margin-top:50px;">            
<h3>Create Your Own Blog</h3>
<form enctype="multipart/form-data" method="post">
	<b>Select Image To Upload</b>  <input type="file" name="fileimage" id="fileimage">
    <input type="text" name="desc1" id="desc" placeholder="Enter Decription" rows="10" style="margin-top:10px;"   /><br>
    <input type="submit" name="submit" value="Submit" style="margin-top:10px;">
</form>    		
</div>

<?php





	$photo = mysql_query ("SELECT MAX(id) FROM blog");
    $photoid = mysql_result($photo,0,'max(id)');


// function to get the characters after .!!
   function getExtension($str)
  {
   $i = strrpos($str,".");
   if (!$i)
   {
     return "";
   }
   $len = strlen($str) - $i;
   $ext = substr($str,$i+1,$len);
   return $ext;
  }
   if ($_SERVER["REQUEST_METHOD"] == "POST")
   {
   $image=$_FILES['fileimage']['name'];
   
   if (isset ($_FILES['fileimage']['name']))
   {   
     $imagename = $_FILES['fileimage']['name']; //original image
     $source = $_FILES['fileimage']['tmp_name']; //source image 
     $type=$_FILES['fileimage']['type'];
     $size=$_FILES['fileimage']['size'];
     
     $extension = getExtension($imagename);
     $extension = strtolower($extension);
     if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") ) 
 	{
          // if file extension is not .jpg, .jpeg, .png, .gif
          echo "<script>alert('Image Extenction Should be .jpg, .jpeg, .png, .gif only !!');</script>";
        } else {
          $target = "dbimages/$photoid._".$photoid.".jpg";
          move_uploaded_file($source, $target);
          

          //$imagepath = $imagename;
          $save =  "dbimages/$photoid._".$photoid.".jpg"; //This is the new file you saving
          $file =  "dbimages/$photoid._".$photoid.".jpg"; //This is the original file

          list($width, $height) = getimagesize($file) ; 

          $tn = imagecreatetruecolor($width, $height) ; 
          $image = imagecreatefromjpeg($file) ; 
          imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height) ; 

          imagejpeg($tn, $save, 200) ; 

          $save =  "dbimages/" .$photoid.".jpg"; //This is the new file you saving
          $file = "dbimages/$photoid._".$photoid.".jpg"; //This is the original file

          list($width, $height) = getimagesize($file) ; 

          $modwidth = 150; 
          $modheight = 140; 
          $tn = imagecreatetruecolor($modwidth, $modheight) ; 
          $image = imagecreatefromjpeg($file) ; 
          imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 

          imagejpeg($tn, $save, 200) ; 
          $imageval=$photoid.".jpg";
          unlink("dbimages/$photoid._".$photoid.".jpg");
          }
     }
}
?>





<?php


error_reporting(0);
 
        if($_REQUEST['submit']!="")

{
	   $image  =       $imageval;
	   $desc   =       $_REQUEST['desc1'];
	   				  
	   $query = "INSERT INTO blog(image, description)
				VALUES
				('$image', '$desc')";
               $rs = mysql_query($query);
                echo("data inserted...");
				echo "<script> window.location = 'index.php'; </script>";
}
?>




        
       
        
        

<div class="footer">






<!-- Recent Jump Portion 2 -->
        
        
<div class="Recent_Jumps">
	<div class="container">
		
			<div class="row">
        		<div class="col-md-4 col-sm-4">
					<div class="recent front_iframe_video">
						<div id="myElement_0"></div>
							<img src="imageresize/imageresize/get_image/375/425/L2hvbWUvanVtcGx5ZmUvcHVibGljX2h0bWwvYXBwL3dlYnJvb3QvdXBsb2Fkcy9qdW1wLw%3d%3d/1437406016Dollarphotoclub_78131400.jpg" style="" class="img-responsive" alt="" />								    						<div class="title">
						<p><a href="blog_page.php">&quot;Be a Jumper&quot; </a></p> 
							</div>
						</div>
					</div>
			<div class="col-md-4 col-sm-4">
				<div class="recent front_iframe_video">
					<div id="myElement_1"></div>
					<img src="imageresize/imageresize/get_image/375/425/L2hvbWUvanVtcGx5ZmUvcHVibGljX2h0bWwvYXBwL3dlYnJvb3QvdXBsb2Fkcy9qdW1wLw%3d%3d/1437406064Dollarphotoclub_64072526.jpg" style="margin-left:10px;"  class="img-responsive" alt="" />					<div class="title">
					 <p><a href="blog_page.php">&quot;We are Jumpers&quot;</a></p>  
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4">
				<div class="recent front_iframe_video">
					 
					<div id="myElement_2"></div>
					<img src="imageresize/imageresize/get_image/375/425/L2hvbWUvanVtcGx5ZmUvcHVibGljX2h0bWwvYXBwL3dlYnJvb3QvdXBsb2Fkcy9qdW1wLw%3d%3d/1437406095Dollarphotoclub_60357917.jpg" style="margin-left:10px;"  class="img-responsive" alt="" />				<div class="title">
						<p><a href="blog_page.php">&quot;JumpLyfe&quot;</a></p> 
					</div>
				</div>
			</div>
								</div>
	</div>
</div>








  <div class="btn_start">
  <!--<a href="#"><span>Start  Your</span>  Today</a>-->
    <a href="login.html" class=""><span>Start  Your</span> <img src="img/jump.png" alt="" /> Today</a>  </div>
    
    
    
 




    
    

  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-6"> 
          <ul class="footer_menu">
<li>
<a href="index.html" class="logo"><img src="img/logo.png" class="img-responsive" alt="" style="margin-bottom:10px;" /></a>
</li>  
 <li><a href="pages/about-us.html"><p style="font-size:13pt; margin-top:5px; margin-left:40px;"><b>About Us</b></p></a></li>
       <!-- <li><a href="/welcomes/press">press</a></li>-->
     <li><a href="blog_page.php"><p style="font-size:13pt; margin-top:5px; margin-left:40px;"><b>Blog</b></p></a></li>
 <li><a href="record_week.php"><p style="font-size:13pt; margin-top:5px; margin-left:40px;"><b>Record Weeks</b></p></a></li>

          </ul> 

      </div>
        <div class="col-md-3 col-sm-3 col-xs-6 text-center">
          <!--<ul class="footer_menu">
			<li><a href="/welcomes/hospitality ">HOSPITALITY</a></li> 
            <li><a href="#">RESPONSIVE HOUSING</a></li>
            <li><a href="/welcomes/home_safety">HOME SAFETY</a></li>
            <li><a href="/pages/why-host">WHY HOST?</a></li>
          </ul> -->
          			<div class="clearfix"></div>
                    
                      
                    
			<a href="javascript:void(0)" onclick="window.open('https://www.sitelock.com/verify.php?site=www.jumplyfe.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="SiteLock" title="SiteLock" class="site_security_image" src="http://shield.sitelock.com/shield/www.jumplyfe.com"/></a> 
        
<div class="top_bar"><a href="contactagent.html" id="popupsignup" style="margin-top:30px;">Contact Agent</a></div>  
		</div>
        
			
          <div class="col-md-3 col-sm-3  col-xs-12">
           <div class="join">
            <p>join us on</p>
            <ul class="social_icon">
              <li><a href="https://www.facebook.com/jumplyfe" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="https://www.twitter.com/jumplyfe" target="_blank"><i class="fa fa-twitter"></i></a></li>
              <li><a href="https://www.pinterest.com/jumplyfe" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
              <li><a href="https://www.instagram.com/jumplyfe" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div> 
      </div>
       <div class="col-md-3 col-sm-3  col-xs-12">
           <div class="download">
            <p>download our app</p>
             <div class="download_img">
              <a href="#"> <img src="img/app.png" class="img-responsive" alt="" /> </a>
              <a href="#"> <img src="img/google.png" class="img-responsive" alt="" /></a>
            </div> 
          </div>
      </div>
    </div>
  </div>
</div>
<div class="copyright">
	<div class="container">
		<a href="welcomes/help.html">HELP</a> | <a href="welcomes/faqs.html">FAQ</a> | <a href="welcomes/policies.html">POLICIES</a> | <a href="pages/terms-and-privacy.html">TERMS &amp; PRIVACY.</a> | <a href="welcomes/contact_us.html">CONTACT US</a> <span>Copyright© 2015 JumpLyfe.com All Rights Reserved.</span> 


	</div>
    <p style="margin-left:1000px; padding-bottom:5px;">Powered By ITSultan.com</p>
</div>
<script>
function openLoginPopup()
{
	$("#forgotpasswordPopup").modal('hide');
	
	$("#loginPopup").modal('show');
	$('#loginPopup').on('shown.bs.modal', function() {
		$("#loginPopup .email").focus();
	})
	
}


function openPreRegisterPopUp()
{
	var is_beta_site = 'Yes';
	if(is_beta_site == 'Yes'){
		$("#inviteFriendRegisterPopup").modal('show');
	}
	else
	{
		openRegisterPopup();
	}
}

function openRegisterPopup()
{
	$("#registerPopup").modal('show');
}
function openForgotPasswordPopup()
{
	$("#loginPopup").modal('hide');
	$("#forgotpasswordPopup").modal('show');
}

function callBackAfterInviteFriendReg(){
	$("#inviteFriendRegisterPopup").modal('hide');
	$('#registerPopup').find('.extraButton').hide();
	$("#registerPopup").modal('show');
	
}

var twitter_id = '';
	var twitter_firstName = '';
	var twitter_lastName = '';
$(document).ready(function(){
	
	if(twitter_id != ''){
		$('#registerPopup').find('.twitter_fname').val(twitter_firstName);
		$('#registerPopup').find('.twitter_lname').val(twitter_lastName);
		$('#registerPopup').find('.twitter_ids').val(twitter_id);
		$('#registerPopup').find('.extraButton').hide();
		$("#registerPopup").modal('show');
	}
});
</script>

<div class="modal fade" id="loginPopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<img src="img/popup_logo.png" alt="" />				<h4 class="modal-title">Sign In</h4>
            </div>
			<form action="http://www.jumplyfe.com/login" class="ajax_form" id="UsersIndexForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<div class="input-group">
					<div class="input email"><input name="data[User][email]" class="form-control email" placeholder="Email" required id="User_Email" type="email"/></div>					
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input password"><input name="data[User][password]" class="form-control" placeholder="Password" required type="password" id="UserPassword"/></div>				</div>
			</div>
				<span><a href="JavaScript:void(0)" onclick="openForgotPasswordPopup()">Forgot Password</a></span>
			</div>

			<div class="modal-footer">
				<button class="btn btn-primary" type="submit">SIGN IN</button>			</div>
			</form>		</div>
	</div>
</div>
<div class="modal fade signup-modal" id="registerPopup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<img src="img/popup_logo.png" alt="" />				<h4 class="modal-title">Be a Jumper</h4>
			</div>
			<form action="http://www.jumplyfe.com/registers" class="ajax_form" id="RegisterIndexForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<div class="input text required"><input name="data[Register][firstname]" class="form-control twitter_fname" placeholder="First Name" required value="" maxlength="255" type="text" id="RegisterFirstname"/></div>					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input text required"><input name="data[Register][lastname]" class="form-control twitter_lname" placeholder="Last Name" required value="" maxlength="255" type="text" id="RegisterLastname"/></div>					</div>
				</div>
				<input name="data[Register][twitter_id]" class="twitter_ids" value="" type="hidden" id="RegisterTwitterId"/>				<div class="form-group">
					<div class="input-group">
						<div class="input email required"><input name="data[Register][email]" class="form-control" placeholder="Email" required type="email" id="RegisterEmail"/></div>					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input password required"><input name="data[Register][password]" class="form-control" placeholder="Password" required type="password" id="RegisterPassword"/></div>					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input password required"><input name="data[Register][confirm_password]" class="form-control" placeholder="Confirm Password" required type="password" id="RegisterConfirmPassword"/></div>					</div>
				</div>
				<div class="checkbox">
					<label	>
						<div class="input checkbox required"><input type="hidden" name="data[Register][terms]" id="RegisterTerms_" value="0"/><input type="checkbox" name="data[Register][terms]"  value="1" required id="RegisterTerms"/></div> I agree to accept the terms and conditions
					</label>
				</div>
				<div class="register_page">
					<button class="btn btn-primary" type="submit">REGISTER</button><br>
					<span class="sign extraButton">- OR - <br>Sign up with</span>
				</div>
			</div>
			<div class="modal-footer">
				<a href="https://www.facebook.com/dialog/oauth?client_id=454679808045827&amp;redirect_uri=http%3A%2F%2Fwww.jumplyfe.com%2Fsocial_endpoint%3Fhauth.done%3DFacebook&amp;state=eecbe6b4cffb85d5b7e93609ea398d4d&amp;scope=email%2C+user_about_me%2C+read_stream&amp;display=page" class="btn btn-default btn-facebook btn-block extraButton"><i class='fa fa-facebook'></i>Login with Facebook</a><a href="https://api.twitter.com/oauth/authenticate?oauth_token=eoztGAAAAAAAgpuHAAABT9wjKzk" class="btn btn-default btn-twitter btn-block extraButton"><i class='fa fa-twitter'></i>Login with Twitter</a><a href="https://accounts.google.com/o/oauth2/auth?client_id=199655855456-m4eq3cn97t79kn9pogdmj0sishg9giv9.apps.googleusercontent.com&amp;redirect_uri=http%3A%2F%2Fwww.jumplyfe.com%2Fsocial_endpoint%3Fhauth.done%3DGoogle&amp;response_type=code&amp;scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.google.com%2Fm8%2Ffeeds%2F&amp;access_type=offline" class="btn btn-default btn-instagram btn-block extraButton"><i class='fa fa-google'></i>Login with Google+</a>			</div>
			</form>		</div>
	</div>
</div>
<div class="modal fade" id="forgotpasswordPopup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<img src="img/popup_logo.png" alt="" />				<h4 class="modal-title">Forgot Password</h4>
			</div>
			<form action="http://www.jumplyfe.com/users/forgot_password" class="ajax_form" id="UserIndexForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<div class="input text"><input name="data[User][email]" class="form-control" placeholder="Email" maxlength="255" type="text" id="UserEmail"/></div>				</div><br>
				<span><a href="JavaScript:void(0)" onclick="openLoginPopup()">Login</a></span>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="submit">Submit</button>			</div>
			</form>		</div>
	</div>
</div>
<div class="modal fade" id="inviteFriendRegisterPopup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<img src="img/popup_logo.png" alt="" />				<h4 class="modal-title">Please Enter Your Email</h4>
			</div>
			<form action="http://www.jumplyfe.com/users/invite_friend_registration" class="ajax_form" id="BetaRegistrationInvitationIndexForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
                <div class="input text"><input type="text" class="form-control" id="BetaRegistrationInvitationEmail" name="data[BetaRegistrationInvitation][Name]"/></div>
					<div class="input text"><input name="data[BetaRegistrationInvitation][email]" class="form-control" placeholder="Email" type="text" id="BetaRegistrationInvitationEmail"/></div>				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="submit">Submit</button>			</div>
			</form>		</div>
	</div>
</div>
<script>
$('#registerPopup').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#loginPopup').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#forgotpasswordPopup').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});
</script>







            

</body>
</html>