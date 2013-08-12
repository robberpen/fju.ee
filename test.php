<?php
	echo date_default_timezone_get() . "<br>";
	echo gmdate("Y-m-d H") . "<br>";
	echo date("Y-m-d H") . "<br>";

	date_default_timezone_set('Asia/Taipei');
	echo date_default_timezone_get() . "<br>";
	echo gmdate("Y-m-d H") . "<br>";
	echo date("Y-m-d H") . "<br>";

	date_default_timezone_set('Europe/Berlin');
	echo date_default_timezone_get() . "<br>";
	echo gmdate("Y-m-d H") . "<br>";
	echo date("Y-m-d H") . "<br>";
?>
