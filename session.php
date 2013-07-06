<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if($_SESSION['username'] != "admin") {
	echo '<center>Try login first</center>';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
} else {
	echo '<center>OK</center>';
}
?>
