
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo stripslashes(Configure::read('Site.title')); ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="shortcut icon" href="/studentcompass/favicon.ico" />
<link rel="icon" type="image/png" href="/studentcompass/favicon.ico" />
<link rel="apple-touch-icon" href="/studentcompass/favicon.ico" />
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->script(array('jquery-1.9.1.min','jquery-ui.min','jquery.form','bootstrap.min','owl.carousel.min','jquery.datetimepicker','script','star-rating'));
	echo $this->Html->css(array('bootstrap.css','bootstrap-theme.css','font-awesome.css','mystyle','jquery.datetimepicker','star-rating'));
?>
<?php		
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body>
<?php echo $this->element('header');  ?>
<div class="container">
    <div class="page_content">
		<?php echo $this->element('advertisement_top');  ?>
		<div class="notfound_error"><h1>404 Not Found</h1><br>
			<?php echo $this->html->link('Go To Home',array('controller'=>'welcomes','action'=>'index'),array('class'=>'btn btn-primary'));  ?>
		</div>
		<?php echo $this->element('advertisement_bottom'); ?>
    </div>
</div>
<?php echo $this->element('footer');  ?>
</body>
</html>