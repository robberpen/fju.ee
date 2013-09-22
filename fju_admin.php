<?php
include 'config.php';
include 'fju_connect.php';

$id = $_POST['id'];
$pw = $_POST['pw'];

function login_session($id, $pw)
{
	$q = 'SELECT name,password,`index` FROM admin';
	//echo $q. "<br>";
	$result = mysql_query($q);
	echo 'ttttttttt<br>';
	while ($account = mysql_fetch_assoc($result)) {
		//print_r($account);
		echo "$account[name], $account[index] <br>";
		if ($id == $account[name] && $pw == $account[passowrd])
			return true;
	}
	return false;
}
?>
