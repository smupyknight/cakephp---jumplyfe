<?php if(authComponent::user('id')) { ?>
<?php $session_user_data = $this->requestAction(array('plugin'=>false,'controller'=>'users','action'=>'session_user_data',authComponent::user('id'))); ?>
<div class="menu">
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="nav">
				<ul class="nav nav-pills">
					<li class="<?php echo (isset($top_menu_selected) && $top_menu_selected == 'Feeds')?'active':'';?>"><?php echo $this->Html->link('<span class="newsfeed"></span> JUMP FEED',array('controller'=>'welcomes','action'=>'news_feed',$session_user_data['User']['slug']),array('escape'=>false));?></li>
					<li class="<?php echo (isset($top_menu_selected) && $top_menu_selected == 'Timeline')?'active':'';?>"><?php echo $this->Html->link('<span class="timeline"></span> TIMELINE',array('controller'=>'welcomes','action'=>'timeline',$session_user_data['User']['slug']),array('escape'=>false));?></li>
					<li class="<?php echo (isset($top_menu_selected) && $top_menu_selected == 'My_Jumps')?'active':'';?>"><?php echo $this->Html->link('<span class="myjumps"></span> JUMPS','javascript:void(0)',array('escape'=>false,'class'=>'dropdown-toggle','data-toggle'=>'dropdown'));?>
						<ul class="dropdown-menu" role="menu">
				            <li><?php  echo $this->Html->link('<span class="myjumps"></span> MY JUMPS',array('controller'=>'users','action'=>'profile',$session_user_data['User']['slug']),array('escape'=>false));?></li>
						   <li><?php  echo $this->Html->link('<span class="myjumps"></span> OTHER JUMPS',array('controller'=>'jumps','action'=>'other_jumps'),array('escape'=>false));?></li></a></li>
						   <li class="<?php echo (isset($top_menu_selected) && $top_menu_selected == 'My_Booked_Jump_Rentals')?'active':'';?>"><?php echo $this->Html->link('<span class="myjumps"></span> BOOKED JUMP RENTALS',array('controller'=>'accounts','action'=>'book_jumps'),array('escape'=>false));?> </li>
							<li class="<?php echo (isset($top_menu_selected) && $top_menu_selected == 'My_Booked_Hotels')?'active':'';?>"><?php echo $this->Html->link('<span class="myjumps"></span> BOOKED HOTELS',array('controller'=>'accounts','action'=>'my_booked_hotels'),array('escape'=>false));?></li>
							<li class="<?php echo (isset($top_menu_selected) && $top_menu_selected == 'Manage_Jumps')?'active':'';?>"><?php echo $this->Html->link('<span class="myjumps"></span> MANAGE JUMPS',array('controller' => 'jumps', 'action' => 'my_jumps'),array('escape'=>false));?></li>
				        </ul>
					</li>
					
				</ul>
			</div>
		</nav>
	</div>
</div>
<?php } ?>
