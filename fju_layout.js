function next_page()
{
	document.forms[0].action = "fju_layout.php";
	document.forms[0].submit();

}
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
	//show();
}
function show()
{
	alert("update: " +  $("form").serialize());
	document.forms[0].submit();
}
function __redraw(__data)
{
	$.ajax({
	url: "fju_mysql_adv.php",
	type: "POST",
	data:  __data,
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
					item_data = item[0][i]?item[0][i]['Data']:null;
					if (item[0][i]['Status'] != 'regular')
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
			$.plot("#xyz" + index, [ {data: happy, label: item.TreeID + "-" + item.LeafID + " " + item.start, color:  "#033",  points: { show: true },},  {data: error, color: "#ff0000"}], {
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
				axisLabelUseCanvas: true,
				axisLabelFontSizePixels: 20,
				axisLabelFontFamily: 'Verdana, Arial',
				axisLabel: "時間",
				},
				yaxis: {
			    //color: "black",
			    tickDecimals: 2,
			    axisLabel: "溫度",
			    axisLabelUseCanvas: true,
			    axisLabelFontSizePixels: 20,
			    axisLabelFontFamily: 'Verdana, Arial',
			    min:18,
			    max:42,
			    axisLabelPadding: 5
				},
				grid: { backgroundColor: { colors: ["#aaffff", "#ffffee"] },  hoverable: true, axisMargin: 20 },
			});
			$("#xyz" + index).UseTooltip();
			
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
	__redraw($("form").serialize());
}

function update_draw(__data)
{
	__redraw(__data);
}
function fetch() {
//document.getElementsByName('start_hour')[0].value = 2;
//document.getElementsByName('end_hour')[0].value = 2;
$.ajax({
  url: "fju_mysql.php",
  type: "POST",
  dataType: "json",
  success: function(data) {
	layout= '<table border="2" align=center frame=box bgcolor=#eeeeee width=90%> ';
	console.log("size: " +  data.length);
	$.each( data, function( i, item ) {
		layout += "<tr board=1><td>" + item[0].TreeID + "</td><td>" + item[0].TreeDescription + "</td>";
		console.log("->size: " +  item.length + ",TreeID: " +  item[0].TreeID  + ", Desc: " + item[0].TreeDescription + ",len: " + item[1].length);
		$.each(item[1], function(i, val) {
			if (val.Type == 'temperature')
				icon = '<img src=images/icon_tempSensor_60px.png width=30px height=30px></img>';
			else if (val.Type == 'watt')
				icon = "<img src=images/icon_powerModule_60px.png width=30px height=30px></img>";
			else if (val.Type == 'root')
				icon = "<img src=images/icon_computer_60px.png width=30px height=30px ></img>";
			else
				icon = val.Type;

			if (val.Status == 'regular')
				st_icon = "<img src=images/120px-Green_Light_Icon.svg.png width=30px height=30px ></img>";
			else
				st_icon = "<img src=images/120px-Red_Light_Icon.svg.png width=30px height=30px ></img>";

			layout += "<td><input type=checkbox name=\"draw[]\" value=" + val.TreeID + "-" + val.LeafID  + "-" + val.Type + ">" + val.LeafID + " " + icon + ": " + val.LeafDescription +  ":<font color=green size=5px> " + val.Data + "</font><br><center>" + st_icon + "</center></td>";
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
var previousPoint = null, previousLabel = null;
$.fn.UseTooltip = function () {
    $(this).bind("plothover", function (event, pos, item) {
	//console.log("itm: " + "xxx" + ", index: " + item.dataIndex );
	/* http://people.iola.dk/olau/flot/API.txt
	 * https://github.com/flot/flot/blob/master/API.md
	 */
	//console.log("itm: " + event + " pos.x " + pos.x +  "pos.y" + pos.y + " item " + item);
        if (item) {
	console.log("itm: " + event + " pos.x " + pos.x +  "pos.y" + pos.y + " item " + item);
	    //$("#position").val("test PTM");
            if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                previousPoint = item.dataIndex;
                previousLabel = item.series.label;
                $("#tooltip").remove();
                
                var x = item.datapoint[0];
                var y = item.datapoint[1];
                var date = new Date(x);
                var color = item.series.color;

                showTooltip(item.pageX, item.pageY, color,
                            "<strong>" + item.series.label + "</strong><br>"  +
                            (date.getMonth() + 1) + "/" + date.getDate() + " " + date.getHours() + ":" + date.getUTCMinutes() + 
                            " : <strong>" + y + "</strong>");
            }
        } else {
		//alert("222test");
            $("#tooltip").remove();
            previousPoint = null;
        }
    });
};

function showTooltip(x, y, color, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 120,
        border: '2px solid ' + color,
        padding: '3px',
        'font-size': '9px',
        'border-radius': '5px',
        'background-color': '#fff',
        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity: 0.9
    }).appendTo("body").fadeIn(200);
}
