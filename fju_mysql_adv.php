<?php

include 'config.php';
include 'fju_connect.php';

class param{
	public $peroid, $records;
	public $start_time, $end_time;

	private function init_end_time()
	{
		$date = $_REQUEST["end_date"];	// fmt: YYYY-MM-DD
		$hour = $_REQUEST["end_hour"];
		//$min  = $_REQUEST["end_minute"];
		if ($date == "")
			$date = date("Y-m-d");
		if ($hour == "")
			$hour = date("H");
		$min = date("i");
		$this->end_time = DateTime::createFromFormat('Y-m-d H:i:s', "$date $hour:$min:00");
	}
	private function init_start_time()
	{
		$date = $_REQUEST["start_date"]; // fmt: YYYY-MM-DD
		$hour = $_REQUEST["start_hour"]; // fmt: HH
		//$min  = $_REQUEST["start_minute"];
		//global $max_record;
		$min = date("i");

		if ($hour == "")
			$hour = date("H");
		if ($date == "") {
			$date = date("Y-m-d");
			$this->start_time = DateTime::createFromFormat('Y-m-d H:i:s', "$date $hour:$min:00");
			$this->start_time->sub(new DateInterval('PT' . $this->peroid * $this->records . 'M'));
		} else
			$this->start_time = DateTime::createFromFormat('Y-m-d H:i:s', "$date $hour:$min:00");
	}
	public function __construct()
	{
		global $max_record;
		$this->peroid = $_REQUEST["peroid"];
		/* by default: per 30 minutes from 24 hr to current time */
		if ($this->peroid == "")
			$this->peroid = 1;

		$this->records = $_POST['records'];
		if ($this->records == "" || $this->records >= $max_record)
			$this->records = $max_record;

		$date = $_REQUEST["end_date"];
		$hour = $_REQUEST["end_hour"];
		$this->init_end_time();
		$this->init_start_time();

	}
	public function dump($msg)
	{
		echo "$msg<br>";
		echo "peroid: " . $this->peroid ."<br>\n";
		echo "start_time: " . $this->start_time->format('Y-m-d H:i:s') ."<br>\n";
		echo "end_time: " . $this->end_time->format('Y-m-d H:i:s') ."<br><br>\n";
	}
};

function get_data_irregular($where)
{
	$q = 'SELECT Status FROM Data ' . $where . " AND Status != 'regular'";
	//echo $q. "<br>";
	$result = mysql_query($q);
	//$result = mysql_query('SELECT * FROM temp ORDER BY time DESC LIMIT 0 , 60');
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	//$num_rows = mysql_num_rows($result);
	//echo "num: ". $num_rows . "<br>\n";
	if (mysql_num_rows($result) > 0)
		return mysql_fetch_assoc($result);
	return array('Status' => 'regular');
	//$row = array();
	//while($r = mysql_fetch_assoc($result)) {
	//    $rows[] = $r['data'];
	//}

}
function data_irregular($where)
{
	$q = 'SELECT Status FROM Data ' . $where . " AND Status != 'regular'";
	//echo $q. "<br>";
	$result = mysql_query($q);
	//$result = mysql_query('SELECT * FROM temp ORDER BY time DESC LIMIT 0 , 60');
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	//$num_rows = mysql_num_rows($result);
	//echo "num: ". $num_rows . "<br>\n";
	return !mysql_num_rows($result);
	//$row = array();
	//while($r = mysql_fetch_assoc($result)) {
	//    $rows[] = $r['data'];
	//}

}
function draw_data($param, $tree, $leaf)
{
	//echo "draw### " . $draw . "as: " . $leaf . " and " . $tree . "</br>\n";
	//$param->dump("Tree $tree " . "Leaf: $leaf<br>");
	global $max_record;
	$limit = $_POST['records'];
	if ($limit > $max_record)
		$limit = $max_record;
	$rows = array();
	//$rows = array("TreeID" =>$tree, "LeafID" => $leaf);
	//$rows[] = ["LeafID" => $leaf ];
	$test = 0;
	for ($i  = 0;  $param->start_time < $param->end_time; $i += $param->peroid)
	{
		if (!$limit--)
			break;
		$t1 = $param->start_time->format('Y-m-d H:i:s');
		$param->start_time->add(new DateInterval('PT' . $param->peroid . 'M'));
		$t2 = $param->start_time->format('Y-m-d H:i:s');
		

		$where = "WHERE Data.DateTime > '$t1' AND Data.DateTime <= '$t2' AND LeafID=$leaf AND TreeID=$tree";
		data_irregular($where);

		//$q = 'SELECT ROUND(AVG(data), 3) AS data FROM Data ' . $where . " AND LeafID=$leaf AND TreeID=$tree";
		$q = 'SELECT ROUND(AVG(data), 3) AS data FROM Data ' . $where ;
		/* abnormal .. */
		//$abnormal = $q . " AND Status != 'regular'";// Status   | enum('regular','irregular','nodata')
		//echo $abnormal. "<br>";

		//SELECT AVG(temp) FROM temp WHERE temp.time >= '2013-07-07 20:00:00' AND temp.time < '2013-07-07 20:30:00' ORDER BY time DESC LIMIT 0 , 60
		//echo "<br> $q <br>\n";
		//$result = mysql_query('SELECT * FROM temp ' . $range . ' ORDER BY time DESC LIMIT 0 , 60');
		$result = mysql_query($q);
		//$result = mysql_query('SELECT * FROM temp ORDER BY time DESC LIMIT 0 , 60');
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		//$row = array();
		while($r = mysql_fetch_assoc($result)) {
			$rows[] = array_merge(array('Data' =>$r['data']), get_data_irregular($where));
		 //   if ($test++ == 3) {
			//$rows[] = array('Status' => 'abnormal', 'Data'=>$r['data']);
		//	$rows[] = $r['data'];
		   // } else
		//	$rows[] = $r['data'];
		}
		//$rows[] = $row;
		//print json_encode($rows);
	}
	return $rows;
}
date_default_timezone_set('Asia/Taipei');
if (!empty($_POST['draw'])) {
	//print_r($_POST);
	$rows = array();
	foreach($_POST['draw'] as $draw) {
		$param = new param();
		$d = explode("-", $draw);
		//echo "$draw | $d[0] | $d[1] | $d[2] |<br>\n";
		$tree = $d[0];
		$leaf = $d[1];
		$rows[] = array("TreeID" => $tree, "LeafID" => $leaf, "Type" => $d[2], 
			"start" => $param->start_time->format('Y-m-d H:i'),
			"end" => $param->end_time->format('Y-m-d H:i'),
			"minute" => $param->peroid,
			draw_data($param, $tree, $leaf));
		//$rows[] = draw_data($tree, $leaf);
	}
	print json_encode($rows);
}
