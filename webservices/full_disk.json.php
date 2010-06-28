<?php
include ("include.php");
include ("globals.php");

if (isset($_GET['type']))
	$type = $_GET['type'];
else
	$type = "smdi_maglc";

$index_types = array_merge($index_types, $index2_types);
$index_types_strs = array_merge($index_types_strs, $index2_types_strs);

//	Calculate the yyyymmdd date of the previous/next day, week, and rotation
$prev_day=date("Ymd",strtotime("-1 day", strtotime($date)));
$prev_week=date("Ymd",strtotime("-7 day", strtotime($date)));
$prev_rot=date("Ymd",strtotime("-27 day", strtotime($date)));

$next_day=date("Ymd",strtotime("+1 day", strtotime($date)));
$next_week=date("Ymd",strtotime("+7 day", strtotime($date)));
$next_rot=date("Ymd",strtotime("+27 day", strtotime($date)));


$instrument = substr($type,0,4);
$filter = substr($type,5,5);
$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');

$arm_data_path = "";

if($type == 'bake_00195')
{
	$thumb = "http://www.solarmonitor.org/common_files/NoData/thumb/bakeout.thumb.png";
	$fullRes = "http://www.solarmonitor.org/common_files/NoData/thumb/bakeout.thumb.png";
}
elseif($type == 'keyh_00195')
{
	$thumb = "http://www.solarmonitor.org/common_files/NoData/thumb/keyhole.thumb.png";
	$fullRes = "http://www.solarmonitor.org/common_files/NoData/thumb/bakeout.thumb.png";
}
elseif($type == 'default')
{
	$thumb = "http://www.solarmonitor.org/common_files/placeholder_220";
	$fullRes = "http://www.solarmonitor.org/common_files/placeholder_220";
	$time = "No Time Data Available";
}
else
{
	$thumb = "http://www.solarmonitor.org/${arm_data_path}data/$date/pngs/thmb/${type}_thumb.png";
	$fullRes = "http://solarmonitor.org/data/$date/pngs/$instrument/" . $file;
}

if($file == "No File Found" && $type != "default")
{
	$thumb = "http://www.solarmonitor.org/common_files/placeholder_220";
	$fullRes = "http://www.solarmonitor.org/common_files/placeholder_681";
	$time = "No Time Data Available";
}
elseif($file != "No File Found" && $type != "default") {
	list($inst, $filt, $fd, $fdate, $time, $ext) = split('[_.]',$file,6);
	$str = $index_types_strs[$type];
	$dt = $fdate . " " . substr($time,0,2) . ":" . substr($time,2,2);
	//$str = $str . " " . date("d-M-Y H:i", strtotime($dt)) . " UT";
	$str = $str . " " . $fdate . " " . date("H:i", strtotime($dt));
	$time = $str;
}


print("{ ");
print("\"date\": \"" . $date . "\", ");
print("\"type\": \"" . $type . "\", ");
print("\"time\": \"" . $time . "\", ");
print("\"image\": \"" . $thumb . "\", ");
print("\"fullRes\": \"" . $fullRes . "\", ");
print("\"prevDay\": \"" . $prev_day . "\", ");
print("\"prevWeek\": \"" . $prev_week . "\", ");
print("\"prevRot\": \"" . $prev_rot . "\", ");
print("\"nextDay\": \"" . $next_day . "\", ");
print("\"nextWeek\": \"" . $next_week . "\", ");
print("\"nextRot\": \"" . $next_rot . "\"");
print("}")

?>