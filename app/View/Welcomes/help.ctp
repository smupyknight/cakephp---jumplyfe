<div class="right_profile job bgcolor">
	<div class="container">
		<div class="row">
			<?php echo $this->element('help_left_section');  ?>
			<div class="col-md-9 col-sm-9">
				<div class="message_block" >
					<div class="help_block">
						<h5>Help Center</h5>
						<?php if(!authComponent::user('id')){ ?>
						<div class="help_login_box">
							<p>Please log in to your account to access help</p>
							<a class="btn btn-primary" href="javascript:void(0)" onclick="openLoginPopup()">Login</a>
							<a class="btn btn-default" href="javascript:void(0)" onclick="openPreRegisterPopUp()">Signup</a>
							<div class="clear-fix"></div>
						</div>
						<?php }?>	
						<div class="popular_topic">
							<h3>Popular Topics</h3>
							<?php if(isset($record['HelpTopic']) && !empty($record['HelpTopic'])) { ?>
							<ul>
								<?php foreach($record['HelpTopic'] as $key => $value){ ?>
									<li><?php echo $this->Html->link($value['title'],array('plugin'=>false,'controller'=>'welcomes', 'action'=>'help_topic_detail',$record['HelpCategory']['slug'],$value['slug']),array('class'=>'help_title')) ?></li>
								<?php } ?>
							</ul>
							<?php } else { ?>
							<div class="no-record">No Topics Found</div>
							
							<?php } ?>
							<div class="clear-fix"></div>
							<?php if(isset($height_light_record) && !empty($height_light_record)) { ?>
								<h5 class="get_start_title"><?php echo $record['HelpCategory']['category_name']?></h5>
								<?php foreach($height_light_record as $key => $value){ ?>	
								<div class="get_start">
									<?php //echo $this->Html->image('big_check.png',array('class'=>'img-responsive'));
									$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
									$image_name 	= 	$value['HelpTopic']['image'];
									if($image_name !='') {
										$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',500,500,base64_encode($file_path),$image_name),true);
										echo $this->Html->image($image_url,array('url'=>array('plugin'=>false,'controller'=>'welcomes', 'action'=>'help_topic_detail',$record['HelpCategory']['slug'],$value['HelpTopic']['slug']),'class'=>'img-responsive'));
									}
									else 
									{
										echo $this->Html->image('no_image.png',array('url'=>array('plugin'=>false,'controller'=>'welcomes', 'action'=>'help_topic_detail',$record['HelpCategory']['slug'],$value['HelpTopic']['slug']),'class'=>'img-responsive'));
									} 
									
									?>
									<div class="get_start_cont">
										<h4><?php echo $this->Html->link($value['HelpTopic']['title'],array('plugin'=>false,'controller'=>'welcomes', 'action'=>'help_topic_detail',$record['HelpCategory']['slug'],$value['HelpTopic']['slug']),array('class'=>'help_title')) ?></h4>
										
										<p><?php echo $this->Text->truncate($value['HelpTopic']['description'],350); ?> </p>
										
										<?php echo $this->Html->link('Read More',array('plugin'=>false,'controller'=>'welcomes', 'action'=>'help_topic_detail',$record['HelpCategory']['slug'],$value['HelpTopic']['slug']),array('class'=>'')) ?>
									</div>
									<div class="clear-fix"></div>
								</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
