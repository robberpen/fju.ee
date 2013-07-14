<?php

include 'config.php';
include 'fju_connect.php';

class param{
	public $peroid, $unit;
	public $start_time, $end_time;

	private function init_end_time()
	{
		$date = $_REQUEST["end_date"];	// fmt: YYYY-MM-DD
		$hour = $_REQUEST["end_hour"];
		if ($date == "")
			$date = date("Y-m-d");
		if ($hour == "")
			$hour = date("H");
		$this->end_time = DateTime::createFromFormat('Y-m-d H:i:s', "$date $hour:00:00");
	}
	private function init_start_time()
	{
		$date = $_REQUEST["start_date"]; // fmt: YYYY-MM-DD
		$hour = $_REQUEST["start_hour"]; // fmt: HH

		if ($date == "") {
			$date = date("Y-m-d");
		}
		if ($hour == "")
			$hour = date("H");
		
		$this->start_time = DateTime::createFromFormat('Y-m-d H:i:s', "$date $hour:00:00");
		$this->start_time->sub(new DateInterval('PT24H'));
		
	}
	private function check()
	{
		/* by default: per 30 minutes from 24 hr to current time */
		if ($this->peroid == "")
			$this->peroid = 30;
		if ($this->unit == "")
			$this->unit = "H";	//"i": minutes interval
	}
	public function __construct()
	{
		$this->peroid = $_REQUEST["peroid"];
		$this->unit = $_REQUEST["unit"];

		$date = $_REQUEST["end_date"];
		$hour = $_REQUEST["end_hour"];
		$this->init_end_time();
		$this->init_start_time();

	}
	public function dump($msg)
	{
		echo "$msg<br>";
		echo "peroid: " . $this->peroid ."<br>\n";
		echo "unit: " . $this->init ."<br>\n";
		echo "start_time: " . $this->start_time->format('Y-m-d H:i:s') ."<br>\n";
		echo "end_time: " . $this->end_time->format('Y-m-d H:i:s') ."<br><br>\n";
	}
};

function draw_data($tree, $leaf)
{
	echo "draw### " . $draw . "as: " . $leaf . " and " . $tree . "</br>\n";
	$param = new param();
	$param->dump("Tree $tree " . "Leaf: $leaf<br>");
	global $max_record;
	$limit = $max_record;
	$rows = array();
	//$rows = array("TreeID" =>$tree, "LeafID" => $leaf);
	//$rows[] = ["LeafID" => $leaf ];
	for ($i  = 0;  $param->start_time < $param->end_time;$i += $peroid)
	{
		if (!$limit--)
			break;
		$t1 = $param->start_time->format('Y-m-d H:i:s');
		$param->start_time->add(new DateInterval('PT120M'));
		$t2 = $param->start_time->format('Y-m-d H:i:s');
		
		$range = "WHERE Data.DateTime > '$t1' AND Data.DateTime <= '$t2'";
		$q = 'SELECT ROUND(AVG(data), 3) AS data FROM Data ' . $range;
		//SELECT AVG(temp) FROM temp WHERE temp.time >= '2013-07-07 20:00:00' AND temp.time < '2013-07-07 20:30:00' ORDER BY time DESC LIMIT 0 , 60
		echo "<br> $q <br>\n";
		//$result = mysql_query('SELECT * FROM temp ' . $range . ' ORDER BY time DESC LIMIT 0 , 60');
		$result = mysql_query($q);
		//$result = mysql_query('SELECT * FROM temp ORDER BY time DESC LIMIT 0 , 60');
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		//$row = array();
		while($r = mysql_fetch_assoc($result)) {
		    $rows[] = $r['data'];
		}
		//$rows[] = $row;
		//print json_encode($rows);
	}
	return $rows;
}

if(!empty($_POST['draw'])) {
	//print_r($_POST);
	$rows = array();
	foreach($_POST['draw'] as $draw) {
		$d = explode("-", $draw);
		$tree = $d[0];
		$leaf = $d[1];
		$rows[] = array("TreeID" => $tree, "LeafID" => $leaf,  draw_data($tree, $leaf));
		//$rows[] = draw_data($tree, $leaf);
	}
	print json_encode($rows);
}
exit(0);
/* init parameters */
$peroid = $_REQUEST["peroid"];
$unit = $_REQUEST["unit"];
$unit = "S";
$peroid = 30;

/* start datetime */
$intval=$_REQUEST["interval"];
$date=$_REQUEST["end_date"];
$hour=$_REQUEST["end_hour"];

if ($date == "") {
	$date = date("Y-m-d");
	//echo "from now $date <br>\n";
}
if ($hour == "")
	$hour = date("H");
$end_time = "$date $hour:00:00";



/* start datetime */
$date=$_REQUEST["start_date"];
$hour=$_REQUEST["start_hour"];

if ($date == "") {
	$date = date("Y-m-d");
}
if ($hour == "")
	$hour = date("H");
$start_time = "$date $hour:00:00";
$param = new param();
$param->dump();
//if ($mode == "daily")
$end = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);
$start = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);
$start->sub(new DateInterval('PT24H'));

echo "end_time :" . $end_time . "<br>\n";
echo "start time: " . $start->format('Y-m-d H:i:s') . "<br>\n";

echo "peroid: " . $peroid . "<br>\n";
echo "unit: " . $unit . "<br>\n";
if ($start > $end)
	echo "start > end <br>\n";
else
	echo "start < end <br>\n";

/*
//for ($i  = 0; $i <= 120 ;$i += $peroid)
for ($i  = 0; $start < $end ;$i += $peroid)
{
	$t1 = $start->format('Y-m-d H:i:s');
	$start->add(new DateInterval('PT120M'));
	$t2 = $start->format('Y-m-d H:i:s');
	//echo "start time : "  . $i . " from " . $start->format('Y-m-d H:i:s') . "<br>\n";
	//echo "start time : "  . $i . " from " . $t1 . " to :" . $t2 ."<br>\n";
	echo "type start: : " . gettype($start) . "<br>\n";
	echo "type end: : " . gettype($end) . "<br>\n";
	echo "type start_time: " . gettype($start_time) . "<br>\n";
	$range = "WHERE temp.time > '$t1' AND temp.time <= '$t2'";
	$q = 'SELECT AVG(temp) as temp FROM temp ' . $range . ' ORDER BY time DESC LIMIT 0 , 60';
	//SELECT AVG(temp) FROM temp WHERE temp.time >= '2013-07-07 20:00:00' AND temp.time < '2013-07-07 20:30:00' ORDER BY time DESC LIMIT 0 , 60
	echo "<br> $q <br>\n";
	//$result = mysql_query('SELECT * FROM temp ' . $range . ' ORDER BY time DESC LIMIT 0 , 60');
	$result = mysql_query($q);
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
}
*/
mysql_close($link);
?>
