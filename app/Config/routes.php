<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
 
 
 $url = $_SERVER['REQUEST_URI'];
$parsed = parse_url($url);
$path = $parsed['path'];
$path_parts = explode('/', $path);
$desired_output = $path_parts[1];
 
	$data = array('app','jumplyfe','admin','imageresize','accounts','blogs','checkouts','cron','elites','groups','host_jumpers','hotels','jump_hosts','jumps','messages','pages','registers','rest','searches','users','welcomes','login','pages','social_login','social_endpoint','profile','my','elite','feeds','timeline','jump_rentals','errors');
	
	Router::connect('/', array('controller' => 'welcomes', 'action' => 'index'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/social_login/*', array( 'controller' => 'users', 'action' => 'social_login'));
	Router::connect('/social_endpoint/*', array( 'controller' => 'users', 'action' => 'social_endpoint'));
	
	Router::connect('/my/bookings/jump-rentals', array('controller' => 'accounts', 'action' => 'book_jumps'));
	Router::connect('/my/jump/add', array('controller' => 'jumps', 'action' => 'add_my_jump'));
	Router::connect('/my/jumps', array('controller' => 'jumps', 'action' => 'my_jumps'));
	Router::connect('/my/jump/edit/*', array('controller' => 'jumps', 'action' => 'edit_my_jump'));
	Router::connect('/my/jump/gallery/photos/*', array('controller' => 'jumps', 'action' => 'photo_gallery'));
	Router::connect('/my/jump/gallery/videos/*', array('controller' => 'jumps', 'action' => 'video_gallery'));
	Router::connect('/my/jump-rentals', array('controller' => 'accounts', 'action' => 'my_jump_hosts'));
	Router::connect('/elite', array('controller' => 'users', 'action' => 'elite'));
	Router::connect('/elite', array('controller' => 'users', 'action' => 'elite'));
	Router::connect('/feeds/*', array('controller' => 'welcomes', 'action' => 'news_feed'));
	Router::connect('/timeline/*', array('controller' => 'welcomes', 'action' => 'timeline'));
	Router::connect('/jump_rentals', array('controller' => 'jump_hosts', 'action' => 'jump_hosts'));
	Router::connect('/jump_rentals/detail/*', array('controller' => 'jump_hosts', 'action' => 'detail'));
	Router::connect('/jump_rentals/add_my_jump_rental/*', array('controller' => 'accounts', 'action' => 'add_my_jump_host'));
	Router::connect('/jump_rentals/edit_my_jump_rental/*', array('controller' => 'accounts', 'action' => 'edit_my_jump_host'));
	Router::connect('/jump_rentals/bookings/*', array('controller' => 'jump_hosts', 'action' => 'booking_history'));
	Router::connect('/jump_rentals/gallery/*', array('controller' => 'accounts', 'action' => 'my_jump_gallery'));
	Router::connect('/jump_rentals/refund/*', array('controller' => 'jump_hosts', 'action' => 'refund_payment'));
	Router::connect('/jump_rentals/user/*', array('controller' => 'jump_hosts', 'action' => 'profile_user_jump_rental'));

	Router::connect('/reset_password', array('controller' => 'registers', 'action' => 'reset_password'));


	Router::connect('/api/login', array('controller' => 'backend', 'action' => 'login'));
	Router::connect('/api/login_facebook', array('controller' => 'backend', 'action' => 'login_facebook'));
	Router::connect('/api/login_twitter', array('controller' => 'backend', 'action' => 'login_twitter'));
	Router::connect('/api/login_instagram', array('controller' => 'backend', 'action' => 'login_instagram'));
	Router::connect('/api/signup', array('controller' => 'backend', 'action' => 'signup'));
	Router::connect('/api/newsfeed', array('controller' => 'backend', 'action' => 'newsfeed'));
	Router::connect('/api/timeline', array('controller' => 'backend', 'action' => 'timeline'));
	Router::connect('/api/comments', array('controller' => 'backend', 'action' => 'comments'));
	Router::connect('/api/profile', array('controller' => 'backend', 'action' => 'profile'));
	Router::connect('/api/edit_profile', array('controller' => 'backend', 'action' => 'edit_profile'));
	Router::connect('/api/chatlist', array('controller' => 'backend', 'action' => 'chatlist'));
	Router::connect('/api/jumplist', array('controller' => 'backend', 'action' => 'jumplist'));
	Router::connect('/api/jumpscreen', array('controller' => 'backend', 'action' => 'getJumpDetail'));
	Router::connect('/api/chat', array('controller' => 'backend', 'action' => 'chat'));
	Router::connect('/api/search_result', array('controller' => 'backend', 'action' => 'search_result'));
	Router::connect('/api/jump_host_detail', array('controller' => 'backend', 'action' => 'jump_host_detail'));
	Router::connect('/api/booking_detail', array('controller' => 'backend', 'action' => 'booking_detail'));
	Router::connect('/api/chatscreen', array('controller' => 'backend', 'action' => 'chatscreen'));
	Router::connect('/api/get_chat_message', array('controller' => 'backend', 'action' => 'get_chat_message'));
	Router::connect('/api/add_message', array('controller' => 'backend', 'action' => 'add_message'));

	Router::connect('/api/new_jump', array('controller' => 'backend', 'action' => 'new_jump'));
	Router::connect('/api/forgot_password', array('controller' => 'backend', 'action' => 'forgot_password'));
	Router::connect('/api/reset_password', array('controller' => 'backend', 'action' => 'reset_password'));
	
	if(!(!$desired_output || in_array($desired_output,$data))){
		Router::connect('/:slug', array('controller' => 'users', 'action' => 'profile'));
	}
	
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();
	
	
/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
	
