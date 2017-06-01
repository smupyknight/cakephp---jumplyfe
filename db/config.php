<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
error_reporting(0);
$con = mysql_connect("localhost","jumplyfe_new","123456a");
if($con)
{mysql_select_db("jumplyfe_jumplife", $con);

}
else
{echo("error");
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JumpLyfe</title>
</head>

<body>
</body>
</html>