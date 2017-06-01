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
<script type="text/javascript" language="javascript" src="js/New folder/jquery.ba-throttle-debounce.min.js">
</script>
<script type="text/javascript" language="javascript" src="js/New folder/jquery-ui.min.js" ></script>
<script type="text/javascript" language="javascript" src="js/New folder/jquery.js" ></script>

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

        
        
        
	<link rel="stylesheet" type="text/css" href="css/mynew.css"	/>
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
				$("#dob").datepicker({
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
	
		<script type="text/javascript">
			$(function() {
				$(".close").click(function() {
					$(".alert-message").fadeOut();
				});
			});
		</script>
        <script type="text/javascript">
			$(function() {
				$(".close").(function() {
					$(".alert-message").fadeOut();
				});
			});
		</script>
<body>
<div class="navbar-fixed-top" style="margin-bottom:200px;">
<div class="header not_login">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
	<a href="index.html" class="logo"><img src="img/logo.png" class="img-responsive" alt="" /></a>			</div>
	<div class="col-md-6">
				<div class="top_bar">
	 <a href="signup.php" id="popupsignup">Signup</a>
	<a href="login.php" class="login">login</a>
    <a href="contact_agent.php" id="popupsignup" style="float:right;">Contact Agent</a>
<div class="social_icon" style="float:left; margin-left:-150px; margin-top:10px;">
<a href="https://www.instagram.com/jumplyfe" target="_blank"><i class="fa fa-instagram"></i></a>						<a href="https://www.pinterest.com/jumplyfe" target="_blank"><i class="fa fa-pinterest-p"></i></a>						<a href="https://www.twitter.com/jumplyfe" target="_blank"><i class="fa fa-twitter"></i></a>						<a href="https://www.facebook.com/jumplyfe" target="_blank"><i class="fa fa-facebook"></i></a>				  </div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
            
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
<form method="post" action="createblog.php">
<a href="createblog.php"><input type="button" value="Create Blog"></a>
</form>
	            

<?php
     $get_catgry=mysql_query("SELECT image FROM blog ")or die(mysql_error());
     $num_cat=mysql_num_rows($get_catgry);
	 for($i=0;$i<$num_cat;$i++)
              {  
		         $cat_category=mysql_result($get_catgry,$i,'image');
?>
<div class="mynew-working-area">
	<ul class="mynew-ul">
		<li class="mynew-list">
    		<!--<a href="homesub.php?cat_category=-->
          <img src="dbimages/<?php echo $cat_category; ?>" class="mynew-image" />
        	
		</li>
	</ul>
</div>
<?php
    }
?>
<div class="mynew-clearsec"></div>



<?php





	$photo = mysql_query ("SELECT MAX(id) FROM blog");
    $photoid = mysql_result($photo,0,'max(id)')+50;


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
	   $desc   =       $_REQUEST['desc'];
	   				  
	   $query = "INSERT INTO blog(image, description)
				VALUES
				('$image', '$desc')";
               $rs = mysql_query($query);
                echo("data inserted...");
}
?>




</body>
</html>