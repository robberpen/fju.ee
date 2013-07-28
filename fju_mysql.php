<?php
include 'config.php';
include 'fju_connect.php';

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
function show_tree()
{
	$q = 'select * from Tree ORDER BY TreeID DESC';
	
	$result = mysql_query($q);
	//$result = mysql_query('SELECT * FROM temp ORDER BY time DESC LIMIT 0 , 60');
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	//echo $intval."<br>";
	//echo $date."<br>";
	//echo $hour."<br>";
	//$result = mysql_query($q);
	$rows = array();
	$output = array();
	$rows2 = array();
	while ($tree = mysql_fetch_assoc($result)) {
		$rows[] = $tree;
		$q = 'SELECT * FROM LeafID WHERE TreeID=' . $tree['TreeID'];
		//echo $q . "<br>\n";
	
		$leaf_res = mysql_query($q);
		unset($row2);
		if ( mysql_num_rows($leaf_res) <= 0) {
			$output[] = array($tree, "");
			continue;
		}
		while ($leaf = mysql_fetch_assoc($leaf_res)) {
			$where = "WHERE Data.DateTime > DATE_SUB(NOW(), INTERVAL 3 MINUTE)  AND Data.DateTime <= NOW() AND LeafID=$leaf[LeafID] AND TreeID=$leaf[TreeID]";
			$q = 'SELECT ROUND(AVG(data), 1) AS Data FROM Data ' . $where;
			//get_data_irregular($where));

			$data = mysql_query($q);
			$row2[] = array_merge($leaf, array_merge(mysql_fetch_assoc($data), get_data_irregular($where)));
		}
		$output[] = array($tree, $row2);
	}
	print json_encode($output);
	//print json_encode($rows);
}
show_tree();
?>
