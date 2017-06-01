<?php 


class HeaderMenuHelper extends AppHelper{

	public $helpers = Array('Html', 'Javascript');
	
	public function header_menu($header_menu, $children){
		foreach($children as $key => $value){
			if(is_array($value)){
				if(array_key_exists($value['id'], $header_menu)){
					$header_menus = $this->requestAction(array('plugin' => false, 'controller' => 'pages', 'action' => 'find_category', $value['id']));
					
					if(isset($value['children']) && !empty($value['children'])){
						/* echo '<li class="">';
						
						echo '<a class="" aria-expanded="false" role="button" data-toggle="dropdown" href="#">'.$header_menus['title'].'</a>';
						echo '<div class="dropdown-menu" role="menu">';
						echo '<ul class="submenu">';
						// echo '<li>dsf</li>';
						
						$s_i = 0;						
						echo $this->header_menu($header_menu, $value['children']);
						
						echo '</ul>';
						echo '</div>';
						echo '</li>'; */
						
						/* echo '<li>';
						
						echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']));
						
						echo '</li>'; */
						
						echo '<li>';
						
						$target = ($header_menus['url_target'] == 1) ? 'target="_BLANK"' : '';
						
						// pr($header_menus);
						if($header_menus['open_as'] == 'Page'){
							$page_slug = $this->requestAction(array('plugin' => false, 'controller' => 'pages', 'action' => 'find_page', $header_menus['page_id']));
							
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'articles', 'action' => 'index', $page_slug));
						}
						else if($header_menus['open_as'] == 'List'){
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']));
						}
						else{
							echo '<a '.$target.' href="'.$header_menus['url_action'].'">'.$header_menus['title'].'</a>';
						}
						
						// echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['id']));
						// echo '<a href="#">'.$header_menus['title'].'</a>';
						echo '</li>';
						
					}
					else{
						echo '<li>';
						
						$target = ($header_menus['url_target'] == 1) ? 'target="_BLANK"' : '';
						
						// pr($header_menus);
						if($header_menus['open_as'] == 'Page'){
							$page_slug = $this->requestAction(array('plugin' => false, 'controller' => 'pages', 'action' => 'find_page', $header_menus['page_id']));
							
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'articles', 'action' => 'index', $page_slug));
						}
						else if($header_menus['open_as'] == 'List'){
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']));
						}
						else{
							echo '<a '.$target.' href="'.$header_menus['url_action'].'">'.$header_menus['title'].'</a>';
						}
						
						// echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['id']));
						// echo '<a href="#">'.$header_menus['title'].'</a>';
						echo '</li>';
					}
						 
				}
			}
		}
	}
	
	public function header_menu_list($header_menu, $children, $show_image){
		foreach($children as $key => $value){
			if(is_array($value)){
				if(array_key_exists($value['id'], $header_menu)){
					$header_menus = $this->requestAction(array('plugin' => false, 'controller' => 'pages', 'action' => 'find_category', $value['id']));
					
					echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 menu_full">';
					
					if(isset($value['children']) && !empty($value['children'])){
						// echo '<li class="">';
						
						if($show_image == 1){
							if(isset($header_menus['image']) && !empty($header_menus['image'])){
								echo $this->Html->link($this->Html->image('../uploads/photos/' . $header_menus['image'], array('class' => 'yamm_img')), array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']), array('escape' => false));
							}
						}
						
						// echo '<h4><a class="" aria-expanded="false" role="button" data-toggle="dropdown" href="#">'.$header_menus['title'].'</a></h4>';
						
						echo '<h4>';
						$target = ($header_menus['url_target'] == 1) ? 'target="_BLANK"' : '';
						if($header_menus['open_as'] == 'Page'){
							$page_slug = $this->requestAction(array('plugin' => false, 'controller' => 'pages', 'action' => 'find_page', $header_menus['page_id']));
							
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'articles', 'action' => 'index', $page_slug));
						}
						else if($header_menus['open_as'] == 'List'){
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']));
						}
						else{
							echo '<a '.$target.' href="'.$header_menus['url_action'].'">'.$header_menus['title'].'</a>';
						}
						echo '</h4>';
						
						// echo '<div class="dropdown-menu" role="menu">';
						echo '<ul class="yam_nav">';
						// echo '<li>dsf</li>';
						
						$s_i = 0;						
						echo $this->header_menu($header_menu, $value['children']);
						
						echo '</ul>';
						// echo '</div>';
						// echo '</li>';
					}
					else{
						// echo '<li>';
						$target = ($header_menus['url_target'] == 1) ? 'target="_BLANK"' : '';
						if($show_image == 1){
							if(isset($header_menus['image']) && !empty($header_menus['image'])){
								echo $this->Html->link($this->Html->image('../uploads/photos/' . $header_menus['image'], array('class' => 'yamm_img')), array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']), array('escape' => false));
							}
						}
						
						echo '<h4>';
						if($header_menus['open_as'] == 'Page'){
							$page_slug = $this->requestAction(array('plugin' => false, 'controller' => 'pages', 'action' => 'find_page', $header_menus['page_id']));
							
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'articles', 'action' => 'index', $page_slug));
						}
						else if($header_menus['open_as'] == 'List'){
							echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']));
						}
						else{
							echo '<a '.$target.' href="'.$header_menus['url_action'].'">'.$header_menus['title'].'</a>';
						}
						// echo $this->Html->link($header_menus['title'], array('plugin' => false, 'controller' => 'categories', 'action' => 'index', $header_menus['slug']));
						echo '</h4>';
						// echo '<a href="#">'.$header_menus['title'].'</a>';
						// echo '</li>';
					}
					
					echo '</div>';
						 
				}
			}
		}
	}
	
}
	

?>