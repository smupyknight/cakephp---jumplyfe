<?php
include ("db/config.php");
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
				//$("#showmore").hide();
				//$("#submitMain").click(function(){
					//$("#showmore").slideToggle();
				//});
				
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
		<script type="text/javascript" src="js/browser.js"></script>	</head>
        
        
 <body>
		<script type="text/javascript">
			$(function() {
				$(".close").click(function() {
					$(".alert-message").fadeOut();
				});
			});
		</script>
		
<div class="navbar-fixed-top" style="margin-bottom:150px; background-color:white;">
<div class="header not_login">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
<a href="index.php" class="logo"><img src="img/popup_logo.png" style="height:60px; width:150px;" class="img-responsive" alt="" /></a>
 </div><div class="col-md-6">
				<div class="top_bar">
	 <a href="signup.php" id="popupsignup" style="float:right; width:50x; background-color:#25ad9f;">Signup</a>
	<a href="login.php" class="login" style="float:right; background-color:#25ad9f;">login</a>
<!--    <a href="contact_agent.php" id="popupsignup" style="float:left; background-color:#25ad9f;">Contact Agent</a> -->
	
	
<div class="social_icon" style="float:right; margin-left:-700px; margin-top:10px;">
<a href="https://www.instagram.com/jumplyfe" target="_blank"><i class="fa fa-instagram"></i></a>
<a href="https://www.pinterest.com/jumplyfe" target="_blank"><i class="fa fa-pinterest-p"></i></a>						
<a href="https://www.twitter.com/jumplyfe" target="_blank"><i class="fa fa-twitter"></i></a>						
<a href="https://www.facebook.com/jumplyfe" target="_blank"><i class="fa fa-facebook"></i></a>				  
</div>
				</div>
		  </div>
		</div>
	</div>
</div>
				
	</div>


<hr style="margin-top:100px;">







<div class="container">

<div style="text-align:center;">


<h2>Contact Agent</h2>
<form name="form" method="post" onSubmit="return validation();" enctype="multipart/form-data" role="form">
   <div class="form-group">
      <div class="col-sm-10">
     	 <input type="text" class="form-control" id="fname" name="firstname" placeholder="First Name" style="width:200px; margin-left:345px;">
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-sm-10">
        <input type="text" class="form-control" id="lname" name="lastname" placeholder="Last Name" style="width:200px; margin-left:595px; margin-top:-34px;">
      </div>
    </div>
    
<div class="form-group">
	<div class="col-sm-10">
		<input type="text" class="form-control" id="mail" name="email" placeholder="Email" style="width:450px; margin-left:345px; margin-top:10px;">
    </div>
</div>



    <div class="form-group">
      <label class="control-label" style="margin-top:85px; margin-left:-1255px;">Choose Your Plan</label>
      </br> 
      
      
      
      <input type="radio" name="plan" value="$100" style="margin-left:-130px;">&nbsp;&nbsp;Within 60 Days
      <input type="radio" name="plan" value="$500" style="margin-left:50px;">&nbsp;&nbsp;Up To 12 Months
      </div>
    
  
  <!--For Destinations-->
  
 <select  name="destination" style="width:450px; height:30px; margin-left:30px;">
  <option  name="destination" value="">Select Your Destinations</option>
  <?php
   $get_catgry=mysql_query("SELECT name FROM destinations")or die(mysql_error());
               $num_cat=mysql_num_rows($get_catgry);
           for($i=0;$i<$num_cat;$i++)
              {
                 $cat_category=mysql_result($get_catgry,$i,'name');
        ?>
        <option name="destination" value=" <?php echo $cat_category;?>"> <?php echo $cat_category;?>
                        <?php
                        }
                        ?></option>
 </select></br></br>

 <select name="month" style="width:450px; height:30px; margin-left:30px;">
  <option value="January">January</option>
  <option value="Feb">February</option>
  <option value="March">March</option>
  <option value="April">April</option>
  <option value="May">May</option>
  <option value="June">June</option>
  <option value="July">July</option>
  <option value="Aug">August</option>
  <option value="Sep">September</option>
  <option value="Oct">October</option>
  <option value="Nov">November</option>
  <option value="Dec">December</option>
</select>
    
    
        
    
    <div class="form-group">
      <div class="col-sm-10">
        <input type="text" class="form-control" id="mnumber" name="mobilenum" placeholder="Enter MobileNumber" style="width:200px; margin-left:345px; margin-top:10px;">
      </div>
    </div>

    
    <div class="form-group">
       <div class="col-sm-10">          
        <input type="text" class="form-control" id="hnumber" name="homenum" placeholder="Home Number" style="width:200px; margin-left:595px; margin-top:-34px;">
      </div>
    </div>

    
    <div class="form-group"> 
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="saddress" name="street" placeholder="Enter street address" style="width:200px; margin-left:345px; margin-top:10px;">
      </div>
    </div>


<div class="form-group">
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="city" name="city" placeholder="Enter city name"style="width:200px; margin-left:595px; margin-top:-34px;">
      </div>
    </div>


    <div class="form-group">     
      <div class="col-sm-10">          
        <input type="country" class="form-control" id="country" name="country" placeholder="Enter Country Name" style="width:200px; margin-left:345px; margin-top:10px;" />
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-sm-10">
        <input type="text" class="form-control" id="z" name="zip" placeholder="Enter Zip Code" style="width:200px; margin-left:595px; margin-top:-34px;">
      </div>
    </div>

	

    
   <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
<input type="submit" class="btn btn-default" id="submitMain" name="submit" value="Submit" onClick="return validation1();" style="height:30px; width:450px; margin-left:-155px; margin-top:10px; padding:3px; background-color:#06C; color:white;">
      </div>
    </div>
  </form>
  
 

</div>


 














        

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
  <a href="contact_agent.php" style="margin-top:50px;" class=""><span>Start  Your</span> <img src="img/jump.png" alt="" /> Today
  </a>
  </div>
    
    
    
 




    
    

  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-6"> 
          <ul class="footer_menu">
<li>
<a href="index.php" class="logo"><img src="img/comingsoon.png" class="img-responsive" alt="" style=" margin-top:-5px; width:140px; margin-left:40px; height:70px;" /></a>
</li>
</ul>
</br></br></br>
<div style="height:30px;"></div>

<a href="about-us.php" style="margin-left:90px; text-decoration:none; color:#009966;">About Us</a></br>
<a href="blog_page.php" style="margin-left:90px; margin-top:20px; text-decoration:none; color:#009966;">Blog</a></br>
<a href="#" style="margin-left:90px; text-decoration:none; color:#009966;">Jump Rentals</a>

          

      </div>
        <div class="col-md-3 col-sm-3 col-xs-6 text-center">
          <!--<ul class="footer_menu">
			<li><a href="/welcomes/hospitality ">HOSPITALITY</a></li> 
            <li><a href="#">RESPONSIVE HOUSING</a></li>
            <li><a href="/welcomes/home_safety">HOME SAFETY</a></li>
            <li><a href="/pages/why-host">WHY HOST?</a></li>
          </ul> -->
          			<div class="clearfix"></div>
                    
                      
                    
			<a href="javascript:void(0)" onClick="window.open('https://www.sitelock.com/verify.php?site=www.jumplyfe.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="SiteLock" title="SiteLock" class="site_security_image" src="http://shield.sitelock.com/shield/www.jumplyfe.com" style="width:140px; height:70px;"/></a> </br></br>
        
<a href="contactagent.php" id="popupsignup" style="margin-top:200px; margin-left:-10px; text-decoration:none; color:#009966;"> Contact Agent </a> </br>
<a href="record_week.php" id="popupsignup" style="margin-top:200px; margin-left:-10px; text-decoration:none; color:#009966;"> Top Destinations </a> </br> 
<a href="#" id="popupsignup" style="margin-top:200px; margin-left:-10px; text-decoration:none; color:#009966;"> Travel Booking </a>


		</div>
        
			
          <div class="col-md-3 col-sm-3  col-xs-12">
           <div class="join">
            <p>We are social</p>
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
             <div class="download_img">
              <a href="#"> <img src="img/app.png" style="width:140px; margin-top:-4px; height:70px;" class="img-responsive" alt="" /> </a>
              <a href="#"> <img src="img/google.png" style="width:140px; margin-top:-4px; height:70px;" class="img-responsive" alt="" /></a></br>
			              <p style="margin-top:15px;">download our app</p>
<a href="contactagent.php" id="popupsignup" style="margin-top:200px; margin-left:80px; text-decoration:none; color:#009966;"> We are Jumpers </a> </br>
<a href="contactagent.php" id="popupsignup" style="margin-top:200px; margin-left:80px; text-decoration:none; color:#009966;"> Be a Jumper </a> </br>


            </div> 
          </div>
      </div>
    </div>
  </div>
</div>
<div class="copyright">
	<div class="container">
		<a href="#">HELP</a> | <a href="#">FAQ</a> | <a href="#">POLICIES</a> | <a href="#">TERMS &amp; PRIVACY.</a> | <a href="#">CONTACT US</a> <span>Copyright© 2015 JumpLyfe.com All Rights Reserved.</span> </br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Powered By :<a href="http://www.itsultan.com/" style="text-decoration:none;"> www.itsultan.com</a>


	</div>
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
				<span><a href="JavaScript:void(0)" onClick="openForgotPasswordPopup()">Forgot Password</a></span>
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
				<span><a href="JavaScript:void(0)" onClick="openLoginPopup()">Login</a></span>
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
