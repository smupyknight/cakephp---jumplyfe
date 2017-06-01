<?php
		$base = $_REQUEST['image'];
	    $filename = time() . ".JPG";
	    
	    $binary = base64_decode($base);
	    header('Content-Type: bitmap; charset=utf-8');
	    $file = fopen("photos/" . $filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);
	    echo $filename;
?>