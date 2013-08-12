<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>智慧型節能空調監控系統</title>
	<link href="flot/examples/examples.css" rel="stylesheet" type="text/css">
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="flot/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="flot/jquery.flot.categories.js"></script>
	<script language="javascript" type="text/javascript" src="flot/jquery.flot.time.js"></script>
	<script language="javascript" type="text/javascript" src="flot/jquery.flot.errorbars.js"></script>
	<script type="text/javascript" src="flot/jquery.flot.symbol.js"></script>
	<script type="text/javascript" src="flot/jshashtable-2.1.js"></script>    
	<script type="text/javascript" src="flot/jquery.numberformatter-1.2.3.min.js"></script>
	<script type="text/javascript" src="flot/jquery.flot.axislabels.js"></script>
	<script language="javascript" type="text/javascript" src="fju_layout.js"></script>
	<script type="text/javascript">
	</script>
	<script>
	function ondraw_update(){
		$("#setup").hide();
		//$("#position").val("test ok");
		update_draw('<?php echo http_build_query($_POST); ?>');
	}
	</script>
</head>
<body onload=ondraw_update()>
<br><br>
<center>
<div id=paint>
</div>
<form method=POST action="fju_mysql_adv.php">
  <div id="tab"> </div>
<input type=text id="position">
<div id=setup>
<br><h4>快速繪圖:</h4>
<input type=button name=quick_hourly value="最近一小時" onclick="quick_hourly_show()">
<input type=button name=quick_daily value="最近一天" onclick="quick_daily_show()" >
<input type=button name=quick_weekly value="最近一週" onclick="quick_weekly_show()">
<input type=button name=quick_monthly value="最近一個月" onclick="quick_monthly_show()">
<br><br><hr color=#011; background-color=#f00; height= 5px><br>
<!-- Display Interval<select name="interval">
  <option>hourly</option>
  <option>daily</option>
  <option>weekly</option>
  <option>monthly</option>
</select> -->
<h4>進階自定繪圖:</h4><br>
開時日期: <input type="date" name=start_date>
開時時間(小時): <input type=text name=start_hour><br><br>
結束時日期: <input type="date" name=end_date>
結束時間(小時): <input type=text name=end_hour><br><br>
平圴每隔<input type=text name=peroid>分一筆<br><br>
共<input type=text name=records value=120>筆資料<br><br>
&nbsp;&nbsp;<input type="button" onclick="redraw()" value="繪圖" id="query">&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;<input type="button" onclick="show()" value="debug" id="devel_debug">&nbsp;&nbsp;&nbsp;&nbsp;
</div>
</form>
<?php
	//echo http_build_query($_POST);
	//var_dump($_POST);
?>
</center>
 
	<div id="footer">
		Copyright &copy; 2013 - 2013 fju.edu.tw
	</div>
</body>
</html>
