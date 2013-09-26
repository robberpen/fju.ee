<?php
include 'config.php';
include 'fju_connect.php';

/* format eg: @item=7-2-test */
$d = explode("-", $_POST["item"]);
$tree_id = $d[0];
$leaf_id = $d[1];
$cmd = $d[2];

//UPDATE  `LeafID` SET  `TreeID` =  '3', `action` =  'test' WHERE  `LeafID`.`LeafID` =2 AND  `LeafID`.`TreeID` =3 LIMIT 1
$q="UPDATE LeafID SET action='$cmd' WHERE  `LeafID`.`LeafID` = $leaf_id  AND  `LeafID`.`TreeID` = $tree_id LIMIT 1";
if (! mysql_query($q)) {
    die('Invalid query: ' . mysql_error());
}

$msg = $cmd == "test"? "測試":"重設";
$msg = $msg . " 點 $tree_id-$leaf_id 已成功";
echo $msg;
?>
