<HTML>
<BODY>
<?php
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';
$db_selected = mysql_select_db('test', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

for ($i=0; $i < 4096; $i++) {
$p=0;
$r=rand (0 , 50);
if ($p < $r)
	$r -= ($r - $p)/4;
else
	$r += ($p - $r)/4;
	
$q="INSERT INTO `test`.`temp` (`id`, `time`, `temp`) VALUES ('1', DATE_ADD(CURRENT_TIMESTAMP,INTERVAL $i MINUTE), $r)";
	//echo $q."<br>";
$result = mysql_query($q);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
}

echo $q;
$result = mysql_query('SELECT * FROM temp LIMIT 0 , 30');
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$rows = array();
while($r = mysql_fetch_assoc($result)) {
    $rows[] = $r;
}
//print json_encode($rows);
mysql_close($link);
?>
</BODY>
</HTML>
