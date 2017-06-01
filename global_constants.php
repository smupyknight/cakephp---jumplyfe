<?php
define('SUBDIR','');
define('DBHOST',"localhost");
define('DBUSERNAME',"jumplyfe_xtreem");
define('DBPASSWORD',"X@123456");
define('DB',"jumplyfe_jumplyfe");


define('MAIL_PORT', 465);
define('MAIL_HOST', 'ssl://mail.jumplyfe.com');
define('MAIL_USERNAME', 'info@jumplyfe.com');
define('MAIL_PASSWORD', 'X@123456');
define('MAIL_CLIENT', 'jumplyfe.com');
define('MAIL_FROM', 'info@jumplyfe.com');

define('WEBSITE_URL','http://'.$_SERVER['HTTP_HOST'].'/'.SUBDIR);
define('WEBSITE_JS_URL',WEBSITE_URL.'js/');
define('WEBSITE_CSS_URL',WEBSITE_URL.'css/');
define('WEBSITE_IMAGE_URL',WEBSITE_URL.'img/');
define('WEBSITE_IMG_URL',WEBSITE_URL.'img/');
define('WEBSITE_IMAGES_URL',WEBSITE_URL.'images/');

define('WEBSITE_APP_WEBROOT_ROOT_PATH',dirname(__FILE__).'/app/webroot/');
define('WEBSITE_APP_WEBROOT_IMG_ROOT_PATH',dirname(__FILE__).'/app/webroot/img/');

define('IMAGE_STORE_PATH',WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/profile_pic/');
/****************************************** Include all settings ******************************************/
require_once('settings.php');
define('PAYPAL_CURRENCY_CODE',	'USD');

/* Admin Configuration */
if(!defined('ADMIN_FOLDER')) {
	define("ADMIN_FOLDER", "admin");	
}
if (!defined('WEBSITE_ADMIN_URL')) {
	define("WEBSITE_ADMIN_URL", WEBSITE_URL.ADMIN_FOLDER.'/');
}
if (!defined('WEBSITE_ADMIN_IMG_URL')) {
	define("WEBSITE_ADMIN_IMG_URL", WEBSITE_ADMIN_URL.'img/');
}
if (!defined('APP_WEBROOT_ROOT_PATH')) {
	define("APP_WEBROOT_ROOT_PATH", $_SERVER['DOCUMENT_ROOT'].SUBDIR.'/app/webroot/');
}
if (!defined('APP_UPLOADS_ROOT_PATH')) {
	define("APP_UPLOADS_ROOT_PATH", APP_WEBROOT_ROOT_PATH.'uploads/');
}


define('ALBUM_UPLOAD_IMAGE_HTTP_PATH',	WEBSITE_URL .'Album/img/');

define('MEMORY_TO_ALLOCATE',	'100M');
define('DEFAULT_QUALITY',		90);
define('CACHE_DIR_NAME',		'/imagecache/');
define('CACHE_DIR',				WEBSITE_APP_WEBROOT_ROOT_PATH .'imagecache' . DS);
$config['pagingViews'] 	= 	array(10=>'10',20=>'20',50=>'50');
$config['defaultPaginationLimit'] 	= 	10;
$config['valid_mime_types'] 	= 	array('image/jpeg', 'image/png', 'image/gif','image/pjpeg');
$config['file_valid_mime_types']= 	array('text/plain', 'text/plain', 'text/plain','text/plain');
$config['valid_image_types']	= 	array('jpg', 'jpeg', 'png', 'gif','pjpeg');

$config['global_ids']	=	array(
								'email_template'=>
									array(
										'registration_successfull'					=>	1,
										'verification_email'						=>	2,
										'forgot_password'							=>	3,
										'user_password_changed_successfully'		=>	4
										
										),
					'admin_default_image'=>
						array(
						'setting_default_image'=>72)
					);
if (!defined('APP_CACHE_PATH')) {
	define("APP_CACHE_PATH", ROOT.'/app/tmp/cache');
}
if (!defined('SETTING_FILE_PATH')) {
	define("SETTING_FILE_PATH", ROOT.'/settings.php');
}

define('CURRENCY_SYMBOL', '$');
/************************Project constants***********************/
define('ALBUM_UPLOAD_IMAGE_PATH', WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/photos/');
define('ALBUM_UPLOAD_HOTEL_IMAGE_PATH', WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/hotel_image/');
define('ALBUM_UPLOAD_ROOM_IMAGE_PATH', WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/room_image/');
define('ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH', WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/jump_host_image/');
define('ALBUM_UPLOAD_JUMP_IMAGE_PATH', WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/jump/');
define('ALBUM_UPLOAD_FEED_IMAGE_PATH', WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/feeds/');
define('ALBUM_UPLOAD_GROUP_IMAGE_PATH', WEBSITE_APP_WEBROOT_ROOT_PATH.'uploads/group_image/');
define('IMAGE_PATH', WEBSITE_URL.'uploads/photos/');
define('WEBSITE_IMAGE_PATH', WEBSITE_URL.'img/');
define('HOTEL_IMAGE_PATH', WEBSITE_URL.'uploads/hotel_image/');
define('ROOM_IMAGE_PATH', WEBSITE_URL.'uploads/room_image/');
define('JUMP_HOST_IMAGE_PATH', WEBSITE_URL.'uploads/jump_host_image/');
define('JUMP_IMAGE_PATH', WEBSITE_URL.'uploads/jump/');
define('FEED_IMAGE_PATH', WEBSITE_URL.'uploads/feeds/');
define('Group_IMAGE_PATH', WEBSITE_URL.'uploads/group_image/');
define('ADMIN_USD_AMOUNT','USD');
define('PAYPAL_USERNAME','xtreem.naveen_api1.gmail.com');
define('PAYPAL_MODE','test');
define('PAYPAL_PASSWORD','CY67KMKFP64USSYH');
define('PAYPAL_SIGNATURE','AFc');	
