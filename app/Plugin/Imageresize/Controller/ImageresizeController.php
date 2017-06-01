<?php 
/**
 * Copyright 2012, PromoSoft.in (http://www.promosoft.in)
 *
 * @copyright Copyright 2010, PromoSoft.in (http://www.promosoft.in)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * PHP version 5
 * CakePHP version 1.3
 
*/

/**
 * Categories Users Controller
 *
 * @package Categories
 * @subpackage users.controllers
 */

class ImageresizeController extends ImageresizeAppController {

/**
 * Controller name
 *
 * @var string
 */
	var $name = 'Imageresize';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers 	=	array('Html', 'Form', 'Session', 'Time', 'Text', 'Utils.Gravatar');

/**
 * Components
 *
 * @var array
 */
	public $components 	= 	array('Auth', 'Session', 'Email', 'Cookie','RequestHandler');
	
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('model', $this->modelClass);
		$this->Auth->allow(array('get_image'));
	}
	
	function get_image($getWidth = '160', $getHeight = '120', $imagerootpath, $file_name = null) {
		
		$this->layout 	=	false;
		
		//$imagename 		=	$this->params['pass'][3].'.'.$this->params['ext'];
		$imagename 		=	$this->params['pass'][3];
		if($imagename==''){
			pr('Image not valid');
			exit();
		}
		
		$imagerootpath 	= 	base64_decode($imagerootpath);
		
		
		if($this->params['ext'] == 'bmp'){
			
			$img 				=	imagecreatefrombmp($imagerootpath . $imagename);
			$image_namearray	=	explode(".",$imagename);
			array_pop($image_namearray);
			$imagename				=	implode(".",$image_namearray).".jpg";
			imagejpeg($img,$imagerootpath . $imagename);
		}
		
		if (!file_exists($imagerootpath . $imagename) || $this->params['ext']=="avi")
		{
			$imagerootpath	=	WWW_ROOT;
			$imagename		=	"no-image.jpg";
		}
		$getImage		=	'/'.$imagename;
		
		if(!function_exists('imageconvolution')){
			function imageconvolution($src, $filter, $filter_div, $offset){
				if ($src == NULL) {
					return false;
				}
				$pxl	 =	array(0,0);
				$sx		 =	imagesx($src);
				$sy 	 =	imagesy($src);
				$srcback =	ImageCreateTrueColor ($sx, $sy);
				ImageCopy($srcback, $src,0, 0, 0, 0, $sx, $sy);
			 
				if($srcback == NULL) {
					return 0;
				}
		 
				for ($y=0; $y < $sy; ++$y){
				for($x=0; $x < $sx; ++$x){
					$new_r = $new_g = $new_b = 0;
					$alpha = imagecolorat($srcback, $pxl[0], $pxl[1]);
					$new_a = $alpha >> 24;
		 
					for ($j=0; $j<3; ++$j) {
						$yv = min(max($y - 1 + $j, 0), $sy - 1);
						for ($i=0; $i<3; ++$i) {
								$pxl = array(min(max($x - 1 + $i, 0), $sx - 1), $yv);
							$rgb = imagecolorat($srcback, $pxl[0], $pxl[1]);
							$new_r += (($rgb >> 16) & 0xFF) * $filter[$j][$i];
							$new_g += (($rgb >> 8) & 0xFF) * $filter[$j][$i];
							$new_b += ($rgb & 0xFF) * $filter[$j][$i];
						}
					}
		 
					$new_r = ($new_r/$filter_div)+$offset;
					$new_g = ($new_g/$filter_div)+$offset;
					$new_b = ($new_b/$filter_div)+$offset;
		 
					$new_r = ($new_r > 255)? 255 : (($new_r < 0)? 0:$new_r);
					$new_g = ($new_g > 255)? 255 : (($new_g < 0)? 0:$new_g);
					$new_b = ($new_b > 255)? 255 : (($new_b < 0)? 0:$new_b);
		 
					$new_pxl = ImageColorAllocateAlpha($src, (int)$new_r, (int)$new_g, (int)$new_b, $new_a);
					if ($new_pxl == -1) {
						$new_pxl = ImageColorClosestAlpha($src, (int)$new_r, (int)$new_g, (int)$new_b, $new_a);
					}
					if (($y >= 0) && ($y < $sy)) {
						imagesetpixel($src, $x, $y, $new_pxl);
					}
				}
				}
				imagedestroy($srcback);
				return true;
			}
		}
		
		if (!isset($getImage))
		{
			header('HTTP/1.1 400 Bad Request');
			pr( 'Error: no image was specified');
			exit();
		}
		
		// Images must be local files, so for convenience we strip the domain if it's there
		$image			= preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $getImage);
		
		// For security, directories cannot contain ':', images cannot contain '..' or '<', and
		// images must start with '/'
		if ($image{0} != '/' || strpos(dirname($image), ':') || preg_match('/(\.\.|<|>)/', $image))
		{
			header('HTTP/1.1 400 Bad Request');
			echo 'Error: malformed image path. Image paths must begin with \'/\'';
			exit();
		}
		
		// If the image doesn't exist, or we haven't been told what it is, there's nothing
		// that we can do
		if (!$image)
		{
			ob_get_clean ();
			header('HTTP/1.1 400 Bad Request');
			echo $this->render('/elements/noimage');
			exit();
		}
		
		// Strip the possible trailing slash off the document root
		//$imagerootpath	= preg_replace('/\/$/', '', DOCUMENT_ROOT .'');
		//echo $imagerootpath . str_replace("/","",$image);die;
		if (!file_exists($imagerootpath . str_replace("/","",$image)))
		{
			ob_get_clean();
			header('Content-Type: image/jpeg');
			readfile('no-image.jpg');
			//echo $this->render('/elements/noimage');
			exit();
		}
		// Get the size and MIME type of the requested image
		$size	= GetImageSize($imagerootpath . $image);
		$mime	= $size['mime'];

		// Make sure that the requested file is actually an image
		if (substr($mime, 0, 6) != 'image/')
		{
			ob_get_clean ();
			//header('HTTP/1.1 400 Bad Request');
			header('Content-Type: image/jpeg');
			readfile('no-image.jpg');
			pr( 'Error: requested file is not an accepted type: ' .  $image);
			exit();
		}
		
		
		$width			= $size[0];
		$height			= $size[1];

		$maxWidth		= (isset($getWidth)) ? (int) $getWidth : 0;
		$maxHeight		= (isset($getHeight)) ? (int) $getHeight : 0;

		if (isset($_GET['color']))
			$color		= preg_replace('/[^0-9a-fA-F]/', '', (string) $_GET['color']);
		else
			$color		= FALSE;

		// If either a max width or max height are not specified, we default to something
		// large so the unspecified dimension isn't a constraint on our resized image.
		// If neither are specified but the color is, we aren't going to be resizing at
		// all, just coloring.
		if (!$maxWidth && $maxHeight)
		{
			$maxWidth	= 99999999999999;
		}
		elseif ($maxWidth && !$maxHeight)
		{
			$maxHeight	= 99999999999999;
		}
		elseif ($color && !$maxWidth && !$maxHeight)
		{
			$maxWidth	= $width;
			$maxHeight	= $height;
		}
		
		// If we don't have a max width or max height, OR the image is smaller than both
		// we do not want to resize it, so we simply output the original image and exit
		if ((!$maxWidth && !$maxHeight) || (!$color && $maxWidth >= $width && $maxHeight >= $height))
		{
			
			$data	= file_get_contents($imagerootpath . '/' . $image);
			
			$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($imagerootpath . '/' . $image)) . ' GMT';
			$etag				= md5($data);
			//ob_get_clean ();
			$this->__doConditionalGet($etag, $lastModifiedString);
			header("Content-type: $mime");
			header('Content-Length: ' . strlen($data));
			echo $data;
			exit();
		}
		
		// Ratio cropping
		$offsetX	= 0;
		$offsetY	= 0;

		if (isset($_GET['cropratio']))
		{
			$cropRatio		= explode(':', (string) $_GET['cropratio']);
			if (count($cropRatio) == 2)
			{
				$ratioComputed		= $width / $height;
				$cropRatioComputed	= (float) $cropRatio[0] / (float) $cropRatio[1];
				
				if ($ratioComputed < $cropRatioComputed)
				{ // Image is too tall so we will crop the top and bottom
					$origHeight	= $height;
					$height		= $width / $cropRatioComputed;
					$offsetY	= ($origHeight - $height) / 2;
				}
				else if ($ratioComputed > $cropRatioComputed)
				{ // Image is too wide so we will crop off the left and right sides
					$origWidth	= $width;
					$width		= $height * $cropRatioComputed;
					$offsetX	= ($origWidth - $width) / 2;
				}
			}
		}
		
		// Setting up the ratios needed for resizing. We will compare these below to determine how to
		// resize the image (based on height or based on width)
		$xRatio		= $maxWidth / $width;
		$yRatio		= $maxHeight / $height;

		if ($xRatio * $height < $maxHeight)
		{ // Resize the image based on width
			$tnHeight	= ceil($xRatio * $height);
			$tnWidth	= $maxWidth;
		}
		else // Resize the image based on height
		{
			$tnWidth	= ceil($yRatio * $width);
			$tnHeight	= $maxHeight;
		}

		// Determine the quality of the output image
		$quality	= (isset($_GET['quality'])) ? (int) $_GET['quality'] : DEFAULT_QUALITY;
		
		// Before we actually do any crazy resizing of the image, we want to make sure that we
		// haven't already done this one at these dimensions. To the cache!
		// Note, cache must be world-readable
		
		// We store our cached image filenames as a hash of the dimensions and the original filename
		$resizedImageSource		= $tnWidth . 'x' . $tnHeight . 'x' . $quality;
		if ($color)
			$resizedImageSource	.= 'x' . $color;
		if (isset($_GET['cropratio']))
			$resizedImageSource	.= 'x' . (string) $_GET['cropratio'];
		$resizedImageSource		.= '-' . $image;
		
		$resizedImage	= md5($resizedImageSource);
			
		$resized		= CACHE_DIR . $resizedImage;
		
		// Check the modified times of the cached file and the original file.
		// If the original file is older than the cached file, then we simply serve up the cached file
		
		if (!isset($_GET['nocache']) && file_exists($resized))
		{
			$imageModified	= filemtime($imagerootpath . $image);
			$thumbModified	= filemtime($resized);
			//ob_get_clean ();
			if($imageModified < $thumbModified) {
				$data	= file_get_contents($resized);
				
				$lastModifiedString	= gmdate('D, d M Y H:i:s', $thumbModified) . ' GMT';
				$etag				= md5($data);
				$this->__doConditionalGet($etag, $lastModifiedString);
				header("Content-type: $mime");
				header('Content-Length: ' . strlen($data));
				echo $data;
				exit();
			}
		}
		
		// We don't want to run out of memory
		ini_set('memory_limit', MEMORY_TO_ALLOCATE);
		//ini_set('memory_limit', '-1');
		// Set up a blank canvas for our resized image (destination)
		$dst	= imagecreatetruecolor($tnWidth, $tnHeight);

		// Set up the appropriate image handling functions based on the original image's mime type
		
		switch ($size['mime'])
		{
			case 'image/gif':
				// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
				// This is maybe not the ideal solution, but IE6 can suck it
				$creationFunction	= 'ImageCreateFromGif';
				$outputFunction		= 'ImagePng';
				$mime				= 'image/png'; // We need to convert GIFs to PNGs
				$doSharpen			= FALSE;
				$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
			break;
			
			case 'image/x-png':
			case 'image/png':
				$creationFunction	= 'ImageCreateFromPng';
				$outputFunction		= 'ImagePng';
				$doSharpen			= FALSE;
				$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
			break;
			case 'image/x-ms-bmp':
			case 'image/bmp':
				$creationFunction	= 'ImageCreateFromJpeg';
				$outputFunction		= 'ImageJpeg';
				$doSharpen			= FALSE;
				$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
			break;
			
			default:
				$creationFunction	= 'ImageCreateFromJpeg';
				$outputFunction	 	= 'ImageJpeg';
				$doSharpen			= TRUE;
			break;
		}
		
		// Read in the original image
		$src	=	$creationFunction($imagerootpath . $image); 
		
		if (in_array($size['mime'], array('image/gif', 'image/png')))
		{
			if (!$color)
			{
				// If this is a GIF or a PNG, we need to set up transparency
				imagealphablending($dst, false);
				imagesavealpha($dst, true);
			}
			else
			{
				// Fill the background with the specified color for matting purposes
				if ($color[0] == '#')
					$color = substr($color, 1);
				
				$background	= FALSE;
				
				if (strlen($color) == 6)
					$background	= imagecolorallocate($dst, hexdec($color[0].$color[1]), hexdec($color[2].$color[3]), hexdec($color[4].$color[5]));
				else if (strlen($color) == 3)
					$background	= imagecolorallocate($dst, hexdec($color[0].$color[0]), hexdec($color[1].$color[1]), hexdec($color[2].$color[2]));
				if ($background)
					imagefill($dst, 0, 0, $background);
			}
		}
		
		// Resample the original image into the resized canvas we set up earlier
		ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);

		if ($doSharpen)
		{
			// Sharpen the image based on two things:
			//	(1) the difference between the original size and the final size
			//	(2) the final size
			$sharpness	= $this->__findSharp($width, $tnWidth);
			
			$sharpenMatrix	= array(
				array(-1, -2, -1),
				array(-2, $sharpness + 12, -2),
				array(-1, -2, -1)
			);
			$divisor		= $sharpness;
			$offset			= 0;
			imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
		}
		
		// Make sure the cache exists. If it doesn't, then create it
		if (!file_exists(CACHE_DIR))
		mkdir(CACHE_DIR, 0755);

		// Make sure we can read and write the cache directory
		if (!is_readable(CACHE_DIR))
		{
			ob_get_clean ();
			header('HTTP/1.1 500 Internal Server Error');
			echo 'Error: the cache directory is not readable';
			exit();
		}
		else if (!is_writable(CACHE_DIR))
		{
			ob_get_clean ();
			header('HTTP/1.1 500 Internal Server Error');
			echo 'Error: the cache directory is not writable';
			exit();
		}
		
		// Write the resized image to the cache
		$outputFunction($dst, $resized, $quality);
		
		// Put the data of the resized image into a variable
		ob_start();
		$outputFunction($dst, null, $quality);
		$data	= ob_get_contents();
		//ob_end_clean();
		
		// Clean up the memory
		ImageDestroy($src);
		ImageDestroy($dst);
			
		ob_get_clean();
		
		// See if the browser already has the image
		$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($resized)) . ' GMT';
		$etag				= md5($data);
		
		$this->__doConditionalGet($etag, $lastModifiedString);
		// Send the image to the browser with some delicious headers
		header("Content-type: $mime");
		header('Content-Length: ' . strlen($data));
		echo $data;

		 //include( WEBSITE_URL.'uploads/images/'.$file_name);
		exit;
	}
	
	function __findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
	{
		$final	= $final * (750.0 / $orig);
		$a		= 52;
		$b		= -0.27810650887573124;
		$c		= .00047337278106508946;
		
		$result = $a + $b * $final + $c * $final * $final;
		
		return max(round($result), 0);
	} // findSharp()

	function __doConditionalGet($etag, $lastModified)
	{
		$ExpireString	= gmdate('D, d M Y H:i:s', strtotime('+1month')) . ' GMT';
		header("Last-Modified: $lastModified");
		header("Cache-Control: max-age=2592000");
		header("Expires: $ExpireString");
		header("ETag: \"{$etag}\"");
			
		$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
			stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
			false;
		
		$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
			stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
			false;
		
		if (!$if_modified_since && !$if_none_match)
			return;
		
		if ($if_none_match && $if_none_match != $etag && $if_none_match != '"' . $etag . '"')
			return; // etag is there but doesn't match
		
		if ($if_modified_since && $if_modified_since != $lastModified)
			return; // if-modified-since is there but doesn't match
		
		// Nothing has changed since their last request - serve a 304 and exit
		header('HTTP/1.1 304 Not Modified');
		exit();
	}
	
	function download_image($file_name= null) {
	 	$this->layout = false;
		$parent_id				 =	 $this->requestAction('/users/users/getParentId');
		 $validImage = $this->Image->findByName($file_name);
	 	if(!empty($validImage) && $validImage['Image']['user_id']==$parent_id ){
			Configure::write( 'debug', 0 );
			$this->downloadFile($validImage['Image']['name'], CAR_IMAGE_DIR);
		}
		exit;
	}
	
	function cut_image() {
		exec("ffmpeg -i robot.avi -vcodec png -vframes 1 -an -f rawvideo -s 320×240 testda1.jpg");
	}
}

	function ConvertBMP2GD($src, $dest = false) { 
		if(!($src_f = fopen($src, "rb"))) { 
			return false; 
		} 
		if(!($dest_f = fopen($dest, "wb"))) { 
			return false; 
		} 
		$header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f,14)); 
		$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant",fread($src_f, 40)); 

		extract($info); 
		extract($header); 

		if($type != 0x4D42) { // signature "BM" 
			return false; 
		} 

		$palette_size = $offset - 54; 
		$ncolor = $palette_size / 4; 
		$gd_header = ""; 
		// true-color vs. palette 
		$gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF"; 
		$gd_header .= pack("n2", $width, $height); 
		$gd_header .= ($palette_size == 0) ? "\x01" : "\x00"; 
		if($palette_size) { 
			$gd_header .= pack("n", $ncolor); 
		} 
	// no transparency 
		$gd_header .= "\xFF\xFF\xFF\xFF"; 

		fwrite($dest_f, $gd_header); 

		if($palette_size) { 
			$palette = fread($src_f, $palette_size); 
			$gd_palette = ""; 
			$j = 0; 
			while($j < $palette_size) { 
				$b = $palette{$j++}; 
				$g = $palette{$j++}; 
				$r = $palette{$j++}; 
				$a = $palette{$j++}; 
				$gd_palette .= "$r$g$b$a"; 
			} 
			$gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor); 
			fwrite($dest_f, $gd_palette); 
		} 

		$scan_line_size = (($bits * $width) + 7) >> 3; 
		$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 
		0x03) : 0; 

	for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) { 
		// BMP stores scan lines starting from bottom 
		fseek($src_f, $offset + (($scan_line_size + $scan_line_align) * 
		$l)); 
		$scan_line = fread($src_f, $scan_line_size); 
		if($bits == 24) { 
			$gd_scan_line = ""; 
			$j = 0; 
			while($j < $scan_line_size) { 
				$b = $scan_line{$j++}; 
				$g = $scan_line{$j++}; 
				$r = $scan_line{$j++}; 
				$gd_scan_line .= "\x00$r$g$b"; 
			} 
		} 
		else if($bits == 8) { 
			$gd_scan_line = $scan_line; 
		} 
		else if($bits == 4) { 
			$gd_scan_line = ""; 
			$j = 0; 
			while($j < $scan_line_size) { 
				$byte = ord($scan_line{$j++}); 
				$p1 = chr($byte >> 4); 
				$p2 = chr($byte & 0x0F); 
				$gd_scan_line .= "$p1$p2"; 
			} $gd_scan_line = substr($gd_scan_line, 0, $width); 
		} 
		else if($bits == 1) { 
			$gd_scan_line = ""; 
			$j = 0; 
			while($j < $scan_line_size) { 
				$byte = ord($scan_line{$j++}); 
				$p1 = chr((int) (($byte & 0x80) != 0)); 
				$p2 = chr((int) (($byte & 0x40) != 0)); 
				$p3 = chr((int) (($byte & 0x20) != 0)); 
				$p4 = chr((int) (($byte & 0x10) != 0)); 
				$p5 = chr((int) (($byte & 0x08) != 0)); 
				$p6 = chr((int) (($byte & 0x04) != 0)); 
				$p7 = chr((int) (($byte & 0x02) != 0)); 
				$p8 = chr((int) (($byte & 0x01) != 0)); 
				$gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8"; 
			} $gd_scan_line = substr($gd_scan_line, 0, $width); 
		} 

		fwrite($dest_f, $gd_scan_line); 
	} 
		fclose($src_f); 
		fclose($dest_f); 
		return true; 
	} 

	function imagecreatefrombmp($filename) { 
		$tmp_name = tempnam("/tmp", "GD"); 
		if(ConvertBMP2GD($filename, $tmp_name)) { 
			$img = imagecreatefromgd($tmp_name); 
			unlink($tmp_name); 
			return $img; 
		} return false; 
	}