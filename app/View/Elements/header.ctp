<?php  if(authComponent::user('id')){ ?>
<?php $session_user_data = $this->requestAction(array('plugin'=>false,'controller'=>'users','action'=>'session_user_data',authComponent::user('id'))); ?>
<div class="top_section">
  <div class="container">
    <div class="header">
      <div class="row">
          <div class="col-md-3 col-sm-12 device_full">
            <?php $image = $this->Html->image(WEBSITE_IMAGE_PATH.'logo.png',array('class'=>'img-responsive')); ?>
			<?php echo $this->Html->link($image,array('plugin'=>false,'controller'=>'welcomes','action'=>'index'),array('class'=>'logo','escape' => false)); ?>
          </div>
          <div class="col-md-9 col-sm-12 device_full">
            <div class="right_section">
			<?php echo $this->Html->link('Jump Search',array('plugin'=>false,'controller'=>'searches','action'=>'index'),array('class'=>'btn-primary')); ?>
             <div class="user">
			 <span class="dropdown">
              <a class="user_profile dropdown" href="#" aria-expanded="false" role="button" aria-haspopup="true" data-toggle="dropdown"> 
				  <label><?php echo $session_user_data["User"]["friend_requests"]; ?></label>
			  <?php
					$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
					$file_name		=	$session_user_data['User']['image'];
					if($file_name != '')
					{
						$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',34,34,base64_encode($file_path),$file_name),true);
						echo $this->Html->image($image_url,array('class'=>'img_radius'));
					}
					else 
					{
						echo $this->Html->image('user-noimage-small.png');
					}
				?> 
				<span class="session_username"><?php echo $this->Text->truncate($session_user_data['User']['firstname'],15);?></span>
				
				
			   <span class="caret"></span>
			   
			  </a>
			  <ul aria-labelledby="drop2" role="menu" class="dropdown-menu">
				<li role="presentation"><?php echo $this->Html->link('Profile',array('plugin'=>false,'controller'=>'welcomes','action'=>'news_feed',$session_user_data['User']['slug']),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
				<li role="presentation"><?php echo $this->Html->link('Wallet',array('plugin'=>false,'controller'=>'accounts','action'=>'wallet'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
				<!--<li role="presentation"><?php echo $this->Html->link('Elite',array('plugin'=>false,'controller'=>'users','action'=>'elite'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>-->
				<li role="presentation"><?php echo $this->Html->link('My Jump Rentals',array('plugin'=>false,'controller'=>'accounts','action'=>'my_jump_hosts'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
				<li role="presentation"><?php echo $this->Html->link('My Jump Credits',array('plugin'=>false,'controller'=>'jumps','action'=>'jump_credits'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
				<li role="presentation"><?php echo $this->Html->link('Host Jumper',array("plugin"=>false,"controller"=>"host_jumpers",'action' => 'my_bookings'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
				<li role="presentation"><?php echo $this->Html->link('Jump Mates ('.$session_user_data["User"]["friend_requests"].')',array("plugin"=>false,"controller"=>"users",'action' => 'jump_mates'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
			    <li role="presentation"><?php echo $this->Html->link('Account Settings',array('plugin'=>false,'controller'=>'users','action'=>'my_accounts'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
			   <?php  $betaMode = configure::read('Site.use_in_beta_mode'); ?>
			   <?php if($betaMode == 'Yes') { ?>
					<li role="presentation"><?php echo $this->Html->link('Invite (Beta)',array('plugin'=>false,'controller'=>'users','action'=>'invite_friends'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
			    <?php } ?>
				<li role="presentation"><?php echo $this->Html->link('Logout',array('plugin'=>false,'controller'=>'users','action'=>'logout'),array('tabindex'=>'-1','role'=>'menuitem')); ?></li>
              </ul>
			  </span>
			 
            </div>
           
          </div>
          </div>
      </div>
    </div>
  </div>
</div>
<?php } else { ?>


<div class="header not_login">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<?php $image = $this->Html->image(WEBSITE_IMAGE_PATH.'logo.png',array('class'=>'img-responsive')); ?>
				<?php echo $this->Html->link($image,array('plugin'=>false,'controller'=>'welcomes','action'=>'index'),array('class'=>'logo','escape' => false)); ?>
			</div>
			<div class="col-md-6">
				<div class="top_bar">
				  <a href="JavaScript:" onclick="openPreRegisterPopUp()" class="signup active">signup</a>
				  <a href="JavaScript:" onclick="openLoginPopup()" class="login">login</a>
				  <div class="social_icon">
						<?php echo $this->Html->link('<i class="fa fa-instagram"></i>',Configure::read("Site.instagram_url"),array('escape'=>false,'target'=>'_blank')); ?>
						<?php echo $this->Html->link('<i class="fa fa-pinterest-p"></i>',Configure::read("Site.pinteresturl"),array('escape'=>false,'target'=>'_blank')); ?>
						<?php echo $this->Html->link('<i class="fa fa-twitter"></i>',Configure::read("Site.twitter_url"),array('escape'=>false,'target'=>'_blank')); ?>
						<?php echo $this->Html->link('<i class="fa fa-facebook"></i>',Configure::read("Site.facebook_url"),array('escape'=>false,'target'=>'_blank')); ?>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
