<!DOCTYPE html>
<html lang="en">
<head>
<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('bootstrap.css','flexslider.css'));
		echo $this->Html->script(array('jquery.js','jquery-1.7.1.min.js','bootstrap.js','jquery.flexslider.js')); 
	
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
<script>
  var metas = document.getElementsByTagName('meta');
  var i;
  if (navigator.userAgent.match(/iPhone/i)||navigator.userAgent.match(/iPad/i)) {
    for (i=0; i<metas.length; i++) {
      if (metas[i].name == "viewport") {
        metas[i].content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
      }
    }
    document.addEventListener("gesturestart", gestureStart, false);
  }
  function gestureStart() {
    for (i=0; i<metas.length; i++) {
      if (metas[i].name == "viewport") {
        metas[i].content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6";
      }
    }
  }
</script>
<script type="text/javascript">
	// <![CDATA[
	$(function(){
		$(".close").click(function(){
				$(".alert-message").fadeOut();
			
		});
	});
	//]]>
	var SiteUrl =  '<?php echo WEBSITE_URL; ?>';
	</script>

</head>
<body>
	<?php echo $this->element('inner/header'); ?>
	<?php echo $this->element('inner/navigation'); ?>
	<div>&nbsp;</div>
	<div style='text-align:center'><?php echo $this->Session->flash(); ?></div>
	 <div class="container">
    	<div class="mid">
        	<div class="row-fluid">
			<?php echo $this->element('inner/left_content'); ?>
			<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</div>
	
	<?php echo $this->element('inner/footer'); ?>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>