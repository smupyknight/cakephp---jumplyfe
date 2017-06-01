<?php 
class FckHelper extends AppHelper { 
    var $helpers = Array('Html', 'Javascript'); 
    function load($id) { 
        $did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v); 
        }  

        $code = "CKEDITOR.replace( '".$did."',{height: '350px',
						width: '750px',
						toolbar :
						[
						[ 'Source','Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','Indent','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ]
						]} )"; 
        return $this->Javascript->codeBlock($code);  
    } 
	function loadSmall($id) { 
        $did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v); 
        }  

        $code = "CKEDITOR.replace( '".$did."',{height: '250px',
						width: '550px',
						toolbar :
						[
						[ 'Source','Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','Indent','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ]
						]} )"; 
        return $this->Javascript->codeBlock($code);  
    } 
} 
?>