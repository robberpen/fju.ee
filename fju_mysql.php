<?php
include 'config.php';
include 'fju_connect.php';
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
			$range = "WHERE Data.DateTime > DATE_SUB(NOW(), INTERVAL 3 MINUTE)  AND Data.DateTime <= NOW()";
			$q = 'SELECT ROUND(AVG(data), 1) AS Data FROM Data ' . $range . " AND LeafID=$leaf[LeafID] AND TreeID=$leaf[TreeID]";
			$data = mysql_query($q);
			$row2[] = array_merge($leaf, mysql_fetch_assoc($data));
		}
		$output[] = array($tree, $row2);

	}
	print json_encode($output);
	//print json_encode($rows);
}
show_tree();
?>