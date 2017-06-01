<?php
 $url = $this->params['controller'].'/'.$this->params['action'];

$homeclass 		= 	'';
$about 			= 	'';
$faq 			= 	'';
$privacy 		= 	'';
$contact 		= 	'';

if($url == 'users/index'){
$homeclass 		= 	'active';
}else if($url == 'pages/about_us'){
$about 		= 	'active';
}else if($url == 'faqs/index'){
$faq 		= 	'active';
}else if($url == 'pages/privacy_policy'){
$privacy 		= 	'active';
}else if($url == 'pages/contact_us'){
$contact 		= 	'active';
}


?> 

  
<nav class="navbar navbar-default" role="navigation">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
         	<?php 
				echo $this->Html->link($this->Html->image('logo.png',array('class'=>'img-responsive')),array('plugin'=>false,'controller'=>'users','action'=>'index'),array('escape'=>false,'class'=>'navbar-brand'));
			
			?>
         </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
           <div class="collapse navbar-collapse" id="navigation">
              <ul class="nav navbar-nav navbar-right">
                 <li class="<?php echo $homeclass; ?>">
					<?php 
						echo $this->Html->link('Home',array('plugin'=>false,'controller'=>'users','action'=>'index'),array('escape'=>false));
					?>
				</li>
                 <li class="<?php echo $about; ?>">
					<?php 
						echo $this->Html->link('About Us',array('plugin'=>false,'controller'=>'pages','action'=>'about_us'),array('escape'=>false));
					?>
				</li>
                 <li class="<?php echo $faq; ?>">
					<?php 
						echo $this->Html->link('Faq',array('plugin'=>false,'controller'=>'faqs','action'=>'index'),array('escape'=>false));
					?>
				</li>
                 <li class="<?php echo $privacy; ?>">
					<?php 
						echo $this->Html->link('Privacy Policy',array('plugin'=>false,'controller'=>'pages','action'=>'privacy_policy'),array('escape'=>false));
					?>
				</li>
                 <li class="<?php echo $contact; ?>">
				 <?php 
						echo $this->Html->link('Contact Us',array('plugin'=>false,'controller'=>'pages','action'=>'contact_us'),array('escape'=>false));
					?>
				</li>
              </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>