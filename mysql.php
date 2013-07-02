<?php

$intval=$_REQUEST["interval"];
$date=$_REQUEST["date"];
$hour=$_REQUEST["hour"];

if ($date == "") {
	$date = date("Y-m-d");
	//echo "from now $date <br>\n";
}
if ($hour == "")
	$hour = 0;
$end_time = "$date $hour:00:00";
//echo $end_time."<br>";
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';
$db_selected = mysql_select_db('test', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
//echo "intval $intval";
//echo "date $date";
//echo "hour $hour";
//$result = mysql_query('SELECT * FROM temp LIMIT 0 , 30');
//$result = mysql_query('SELECT * FROM temp ORDER BY time DESC LIMIT 0 , 60');
$range = "WHERE temp.time > DATE_SUB('$end_time', INTERVAL 60 MINUTE)  AND temp.time <= '$end_time'";
//echo $range. "<br>";
//echo 'SELECT * FROM temp ' . $range . ' ORDER BY time DESC LIMIT 0 , 60';
$result = mysql_query('SELECT * FROM temp ' . $range . ' ORDER BY time DESC LIMIT 0 , 60');
//$result = mysql_query('SELECT * FROM temp ORDER BY time DESC LIMIT 0 , 60');
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
//echo $intval."<br>";
//echo $date."<br>";
//echo $hour."<br>";
$rows = array();
while($r = mysql_fetch_assoc($result)) {
    $rows[] = $r;
}
print json_encode($rows);
mysql_close($link);
?>
