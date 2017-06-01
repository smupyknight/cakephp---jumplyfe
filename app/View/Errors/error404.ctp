<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
	<?php echo $this->Html->css(array('bootstrap','bootstrap-theme')); ?>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
  <body class="body-404">
      <section class="error-wrapper text-center">
          <h1><?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'404.png'); ?></h1>
          <div class="error-desk">
              <h2>page not found</h2>
              <p class="nrml-txt">We Couldn’t Find This Page</p>
          </div>
          <?php echo $this->Html->link('<i class="fa fa-home"></i> Back To Home',array('plugin'=>false,'controller'=>'welcomes','action'=>'index'),array('class'=>'back-btn','escape' => false)); ?>
      </section>
  </body>
</html>
