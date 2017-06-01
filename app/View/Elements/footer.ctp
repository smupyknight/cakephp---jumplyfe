<?php $copyright_content = $this->requestAction(array('controller'=>'welcomes','action'=>'footer')); ?>


<?php if(AuthComponent::user('id')){ ?>
<div class="copyright">
	<div class="container">
	<a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.jumplyfe.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.jumplyfe.com"/></a> 
		<?php echo $this->Html->link('HELP',array('plugin'=>false,'controller'=>'welcomes','action'=>'help')); ?> | <?php echo $this->Html->link('FAQ',array('plugin'=>false,'controller'=>'welcomes','action'=>'faqs')); ?> | <?php echo $this->Html->link('POLICIES',array('plugin'=>false,'controller'=>'welcomes','action'=>'policies')); ?> | <?php echo $this->Html->link('TERMS & PRIVACY',array('plugin'=>false,'controller'=>'pages','action'=>'index','terms-and-privacy')); ?> | <?php echo $this->Html->link('CONTACT US',array('plugin'=>false,'controller'=>'welcomes','action'=>'contact_us')); ?> <span><?php echo $copyright_content['Setting']['value']; ?></span>
	</div>
</div>
<?php }else{ ?>
<div class="footer">
  <div class="btn_start">
  <!--<a href="#"><span>Start  Your</span>  Today</a>-->
  <?php $image = $this->Html->image(WEBSITE_IMAGE_PATH.'jump.png'); ?>
  <?php echo $this->Html->link('<span>Start  Your</span> '. $image .' Today',array('plugin'=>false,'controller'=>'searches','action'=>'index'),array('class'=>'','escape'=>false));?>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-6"> 
          <ul class="footer_menu">
            <li><?php echo $this->Html->link('about',array('plugin'=>false,'controller'=>'pages','action'=>'index','about-us')); ?></li>
           <!-- <li><?php echo $this->Html->link('press',array('plugin'=>false,'controller'=>'welcomes','action'=>'press')); ?></li>-->
            <li><?php echo $this->Html->link('jobs',array('plugin'=>false,'controller'=>'welcomes','action'=>'jobs')); ?></li>
          </ul> 

      </div>
        <div class="col-md-3 col-sm-3 col-xs-6 text-center">
          <!--<ul class="footer_menu">
			<li><?php echo $this->Html->link('HOSPITALITY',array('plugin'=>false,'controller'=>'welcomes','action'=>'hospitality ')); ?></li> 
            <li><a href="#">RESPONSIVE HOUSING</a></li>
            <li><?php echo $this->Html->link('HOME SAFETY',array('plugin'=>false,'controller'=>'welcomes','action'=>'home_safety')); ?></li>
            <li><?php echo $this->Html->link('WHY HOST?',array('plugin'=>false,'controller'=>'pages','action'=>'index','why-host')); ?></li>
          </ul> -->
          <?php $image = $this->Html->image(WEBSITE_IMAGE_PATH.'logo_icon.png',array('class'=>'img-responsive')); ?>
			<?php echo $this->Html->link($image,array('plugin'=>false,'controller'=>'welcomes','action'=>'index'),array('class'=>'ftr-logo','escape' => false)); ?><div class="clearfix"></div>
			<a href="javascript:void(0)" onclick="window.open('https://www.sitelock.com/verify.php?site=www.jumplyfe.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="SiteLock" title="SiteLock" class="site_security_image" src="//shield.sitelock.com/shield/www.jumplyfe.com"/></a> 
		</div>
			
          <div class="col-md-3 col-sm-3  col-xs-12">
           <div class="join">
            <p>join us on</p>
            <ul class="social_icon">
              <li><?php echo $this->Html->link('<i class="fa fa-facebook"></i>',Configure::read("Site.facebook_url"),array('escape'=>false,'target'=>'_blank')); ?></li>
              <li><?php echo $this->Html->link('<i class="fa fa-twitter"></i>',Configure::read("Site.twitter_url"),array('escape'=>false,'target'=>'_blank')); ?></li>
              <li><?php echo $this->Html->link('<i class="fa fa-pinterest-p"></i>',Configure::read("Site.pinteresturl"),array('escape'=>false,'target'=>'_blank')); ?></li>
              <li><?php echo $this->Html->link('<i class="fa fa-instagram"></i>',Configure::read("Site.instagram_url"),array('escape'=>false,'target'=>'_blank')); ?></li>
            </ul>
          </div> 
      </div>
       <div class="col-md-3 col-sm-3  col-xs-12">
           <div class="download">
            <p>download our app</p>
             <div class="download_img">
              <a href="#"> <?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'app.png',array('class'=>'img-responsive')); ?> </a>
              <a href="#"> <?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'google.png',array('class'=>'img-responsive')); ?></a>
            </div> 
          </div>
      </div>
    </div>
  </div>
</div>
<div class="copyright">
	<div class="container">
		<?php echo $this->Html->link('HELP',array('plugin'=>false,'controller'=>'welcomes','action'=>'help')); ?> | <?php echo $this->Html->link('FAQ',array('plugin'=>false,'controller'=>'welcomes','action'=>'faqs')); ?> | <?php echo $this->Html->link('POLICIES',array('plugin'=>false,'controller'=>'welcomes','action'=>'policies')); ?> | <?php echo $this->Html->link('TERMS & PRIVACY',array('plugin'=>false,'controller'=>'pages','action'=>'index','terms-and-privacy')); ?> | <?php echo $this->Html->link('CONTACT US',array('plugin'=>false,'controller'=>'welcomes','action'=>'contact_us')); ?> <span><?php echo $copyright_content['Setting']['value']; ?></span>
	</div>
</div>
<?php } ?>
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
	var is_beta_site = '<?php echo configure::read('Site.use_in_beta_mode'); ?>';
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

var twitter_id = '<?php echo $this->Session->read('twitter_id'); ?>';
	var twitter_firstName = '<?php echo $this->Session->read('user_first_name'); ?>';
	var twitter_lastName = '<?php echo $this->Session->read('user_last_name'); ?>';
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
<?php
	unset($_SESSION['twitter_id']);
	unset($_SESSION['user_first_name']);
	unset($_SESSION['user_last_name']);
?>

<div class="modal fade" id="loginPopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Sign In</h4>
            </div>
			<?php echo $this->Form->create('Users',array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'login'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<div class="input-group">
					<?php echo $this->Form->input('User.email',array('class'=>'form-control email','placeholder'=>'Email','label'=>false,'type'=>'email','required'=>'required','id'=>'User_Email')); ?>
					
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<?php echo $this->Form->input('User.password',array('class'=>'form-control','placeholder'=>'Password','label'=>false,'required'=>'required')); ?>
				</div>
			</div>
				<span><a href="JavaScript:void(0)" onclick="openForgotPasswordPopup()">Forgot Password</a></span>
			</div>

			<div class="modal-footer">
				<?php echo $this->Form->button(__d("users", "SIGN IN", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<div class="modal fade signup-modal" id="registerPopup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Be a Jumper</h4>
			</div>
			<?php echo $this->Form->create('Register',array('url'=>array('plugin'=>false,'controller'=>'registers','action'=>'index'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('Register.firstname',array('class'=>'form-control twitter_fname','placeholder'=>'First Name','label'=>false,'required'=>'required','value'=>'')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('Register.lastname',array('class'=>'form-control twitter_lname','placeholder'=>'Last Name','label'=>false,'required'=>'required','value'=>'')); ?>
					</div>
				</div>
				<?php echo $this->Form->text('Register.twitter_id',array('class'=>'twitter_ids','label'=>false,'value'=>'','type'=>'hidden')); ?>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('Register.email',array('class'=>'form-control','placeholder'=>'Email','label'=>false,'type'=>'email','required'=>'required')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('Register.password',array('class'=>'form-control','placeholder'=>'Password','label'=>false,'type'=>'password','required'=>'required')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<?php echo $this->Form->input('Register.confirm_password',array('class'=>'form-control','placeholder'=>'Confirm Password','label'=>false,'type'=>'password','required'=>'required')); ?>
					</div>
				</div>
				<div class="checkbox">
					<label	>
						<?php echo $this->Form->input("Register.terms",array('type'=>'checkbox','value'=>1,'label'=>false,'required'=>'required')); ?> I agree to accept the terms and conditions
					</label>
				</div>
				<div class="register_page">
					<?php echo $this->Form->button(__d("registers", "REGISTER", true),array("class"=>"btn btn-primary")); ?><br>
					<span class="sign extraButton">- OR - <br>Sign up with</span>
				</div>
			</div>
			<div class="modal-footer">
				<?php
					echo $this->Html->link("<i class='fa fa-facebook'></i>Login with Facebook", array('plugin'=>false,'controller'=>'users','action'=>'social_login','Facebook'),array('escape'=>false,'class'=>'btn btn-default btn-facebook btn-block extraButton'));
					
					 echo $this->Html->link("<i class='fa fa-twitter'></i>Login with Twitter", array('plugin'=>false,'controller'=>'users','action'=>'social_login','Twitter'),array('escape'=>false,'class'=>'btn btn-default btn-twitter btn-block extraButton'));
					 
					  echo $this->Html->link("<i class='fa fa-google'></i>Login with Google+", array('plugin'=>false,'controller'=>'users','action'=>'social_login','Google'),array('escape'=>false,'class'=>'btn btn-default btn-instagram btn-block extraButton'));
					?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<div class="modal fade" id="forgotpasswordPopup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Forgot Password</h4>
			</div>
			<?php echo $this->Form->create('User',array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'forgot_password'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php echo $this->Form->input('User.email',array('class'=>'form-control','placeholder'=>'Email','label'=>false)); ?>
				</div><br>
				<span><a href="JavaScript:void(0)" onclick="openLoginPopup()">Login</a></span>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("users", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<div class="modal fade" id="inviteFriendRegisterPopup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="text-center modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'popup_logo.png'); ?>
				<h4 class="modal-title">Please Enter Your Email</h4>
			</div>
			<?php echo $this->Form->create('BetaRegistrationInvitation',array('url'=>array('plugin'=>false,'controller'=>'users','action'=>'invite_friend_registration'),'class'=>'ajax_form')); ?>
			<div class="alert ajax_alert alert-danger display-hide">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
					<i class="fa fa-close"></i>
				</button>
				<span class="ajax_message"></span>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php echo $this->Form->input('BetaRegistrationInvitation.email',array('class'=>'form-control','placeholder'=>'Email','label'=>false)); ?>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button(__d("beta_registration_invitations", "Submit", true),array("class"=>"btn btn-primary")); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
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
