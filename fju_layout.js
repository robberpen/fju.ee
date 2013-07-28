function quick_hourly_show()
{
	//document.forms[0].action = "fju_quick_show.php";
	document.getElementsByName("peroid")[0].value = 1;
	document.getElementsByName("records")[0].value = 60;
	redraw();
}
function quick_daily_show()
{
	//document.forms[0].action = "fju_quick_show.php";
	document.getElementsByName("peroid")[0].value = 60;
	document.getElementsByName("records")[0].value = 24;
	redraw();
}
function quick_weekly_show()
{
	//document.forms[0].action = "fju_quick_show.php";
	document.getElementsByName("peroid")[0].value = 1440;
	document.getElementsByName("records")[0].value = 7;
	redraw();
}
function quick_monthly_show()
{
	//document.forms[0].action = "fju_quick_show.php";
	document.getElementsByName("peroid")[0].value = 1440;
	document.getElementsByName("records")[0].value = 31;
	redraw();
}
function show()
{
	alert("update: " +  $("form").serialize());
	document.forms[0].submit();
}
function redraw()
{
	if (document.getElementsByName("peroid")[0].value < 1)
		document.getElementsByName("peroid")[0].value = 1;
	var n = 0;
	$("input[name='draw[]']").each(function() {
		if ($(this).attr("checked")) {
			n += 1;
		}
	});
	if (n == 0) {
		alert("no data selected");
		return;
	}
	//alert($("form").serialize());
	$.ajax({
	url: "fju_mysql_adv.php",
	type: "POST",
	data:  $("form").serialize(),
	dataType: "json",
	success: function(data) {
		//alert("success");
		console.log("Totally " +  data.length + " places");
		var painter = "";
		for (var i = 0;i < data.length; i++) {
			painter += '<div class="demo-container">';
			painter += '<div id="xyz' + i + '" class="demo-placeholder"></div>';
			painter += '</div>';
		}
		document.getElementById('paint').innerHTML = painter;
			
		if (document.getElementsByName("peroid")[0].value >= 1440)
			tick = [1, "day"];
		else if (document.getElementsByName("peroid")[0].value >= 60)
			 tick = [2, "hour"];
		else 
			 tick = [10, "minute"];
		$.each( data, function(index, item ) {
			/* fmt: "2013-07-17 02:00" */
			var t0 = item.start.split(' ');
			var y0 = t0[0].split('-');
			var d0 = t0[1].split(':');
			datetime = new Date(y0[0], y0[1] - 1, y0[2], d0[0], d0[1], 0, 0);
			//datetime = new Date(2013, 0, 1, 0, 0, 0, 0);
			var ms = datetime.getTime();
			console.log("data size: " + item[0].length +  ",TreeID: " + 
				item.TreeID + ", LeafIF: " + item.LeafID + " ,start: " + item.start + " ,end: " + item.end + 
				",minute:" + item.minute + ", type:" + item.Type);
			//document.getElementById('debug2').innerHTML += "time [" + t0[0] + "]:[" +  t0[1] + "]"  + "Y: " + y0[0] + " M: " + y0[1] + " D: " + y0[2] +  " H: " + d0[0] + " M: " + d0[1] + " milliseconds: " + ms + "[" + new Date(ms).toString() + "] timezoe off: " + new Date(ms).getTimezoneOffset(); + "<br>";
			ms += 480 * 60000;
			var happy = new Array;
			var error = new Array;
			var ind = 0;
			for (var i in item[0]) {
				//document.getElementById('debug2').innerHTML += "[" + item[0][i]  + "}";
				//happy.push([ind, item[0][i]]);
				var item_data = 0;
				if (typeof item[0][i] == 'object') {
					//alert(typeof item[0][i] + ": " + item[0][i]['Data']);
					item_data = item[0][i]['Data'];
					error.push([ms, item_data]);
				} else {
					item_data = item[0][i];
				}
				happy.push([ms, item_data]);
				ms += item.minute * 60000;
				ind += 1;
			}
			//$.plot("#xyz" + index, [ {data: happy, label: item.TreeID + "-" + item.LeafID + " " + item.start, color:  "#033", points: { show: true },lines: { show: true },}], {
			//$.plot("#xyz" + index, [ {data: happy, label: item.TreeID + "-" + item.LeafID + " " + item.start, color:  "#033", points: { show: true },lines: { show: true }}, {data: half}], {
			//$.plot("#xyz" + index, [ {data: happy, label: item.TreeID + "-" + item.LeafID + " " + item.start, color:  "#033"}, {data: half}], {
			$.plot("#xyz" + index, [ {data: happy, label: item.TreeID + "-" + item.LeafID + " " + item.start, color:  "#033"},  {data: error, color: "#ff0000"}], {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center"
					}
				},
			
				xaxis: {
					//mode: "categories",
					mode: "time",
					//tickSize: [1, "day"],
					tickSize: tick,
					tickLength: 0,
				clickable:true,
				hoverable: true,
				},
				yaxis: {
			    //color: "black",
			    tickDecimals: 2,
			    //axisLabel: "Gold Price  in USD/oz",
			    axisLabelUseCanvas: true,
			    axisLabelFontSizePixels: 12,
			    axisLabelFontFamily: 'Verdana, Arial',
			    min:18,
			    max:42,
			    axisLabelPadding: 5
				},
				grid: { backgroundColor: { colors: ["#aaffff", "#ffffee"] } },
			});
			
		});
		/* output */
		//$("#tab").append(layout);
	},
	error: function(xhr, ajaxOptions, thrownError) {
	alert(xhr.status);
	alert(thrownError);
	}
	});
	//setInterval(redraw, document.getElementsByName("peroid")[0].value * 60000);
}
function fetch() {
//document.getElementsByName('start_hour')[0].value = 2;
//document.getElementsByName('end_hour')[0].value = 2;
$.ajax({
  url: "fju_mysql.php",
  type: "POST",
  dataType: "json",
  success: function(data) {
	layout= '<table border="1" align=center bgcolor=#eeeeee width=90%> ';
	console.log("size: " +  data.length);
	$.each( data, function( i, item ) {
		layout += "<tr board=1><td>" + item[0].TreeID + "</td><td>" + item[0].TreeDescription + "</td>";
		console.log("->size: " +  item.length + ",TreeID: " +  item[0].TreeID  + ", Desc: " + item[0].TreeDescription + ",len: " + item[1].length);
		$.each(item[1], function(i, val) {
			if (val.Type == 'temperature')
				icon = '<img src=images/icon_tempSensor_60px.png width=20% height=30% ></img>';
			else if (val.Type == 'watt')
				icon = "<img src=images/icon_powerModule_60px.png width=20% height=30%></img>";
			else if (val.Type == 'root')
				icon = "<img src=images/icon_computer_60px.png width=20% height=30% ></img>";
			else
				icon = val.Type;

			layout += "<td><input type=checkbox name=\"draw[]\" value=" + val.TreeID + "-" + val.LeafID  + "-" + val.Type + ">" + val.LeafID + " " + icon + ": " + val.LeafDescription +  ":<font color=green size=5px> " + val.Data + "</font></td>";
			//document.getElementById('debug').innerHTML += "->key: " +  i  + "|" + val.TreeID + "|LeafID: " + val.LeafID + "</br>";
		});
		layout += "</tr>";
	});
	/* output */
	$("#tab").append(layout);
    },
    error: function(xhr, ajaxOptions, thrownError) {
	alert(xhr.status);
	alert(thrownError);
	}
    });
	document.getElementById('tab').innerHTML += "</table>";
}
