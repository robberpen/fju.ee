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
	while ($account = mysql_fetch_assoc($result)) {
		//print_r($account);
		echo "$account[name], $account[index] <br>";
		if ($id == $account[name] && $pw == $account[passowrd])
			return true;
	}
	return false;
}
function admin_get()
{
	$q = 'SELECT * FROM admin';
	$result = mysql_query($q);
	$rows = array();
	while ($account = mysql_fetch_assoc($result)) {
		//print_r($account);
		$rows[] = $account;
	}
	print json_encode($rows);
}

function admin_update()
{
	echo "new_acc: " . $_REQUEST['new_account'];
	echo "email: " . $_REQUEST['email'];
	$ph =  array();
	$ph  =  $_REQUEST['phone'];
	echo "ph1: " . $ph[0];
	echo "ph2: " . $ph[1];
	echo "ph3: " . $ph[2];
	echo "phone: " . $_REQUEST['phone'];
	foreach ($_POST['phone'] as $phon) {
		echo "phone xx: " . $phon;
	}
	echo "success<br>";
}
if ($_REQUEST["new_account"] != "") {
	admin_update();
} else
	admin_get();
?>
