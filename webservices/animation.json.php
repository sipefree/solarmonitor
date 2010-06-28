<?php
include ("include.php");
include ("globals.php");

$eit_bakeout = in_bakeout($date);
$eit_keyhole = in_keyhole($date);

$index_types = array_merge($index_types, $index2_types);
$index_types_strs = array_merge($index_types_strs, $index2_types_strs);
if ($eit_keyhole == "1")
{
	$keyhole_index_types = array_merge($keyhole_index_types + $keyhole_index2_types);
	$index_types = $keyhole_index_types;
	$keyhole_index_types_strs = array_merge($keyhole_index_types_strs, $keyhole_index2_types_strs);
	$index_types_strs = $keyhole_index_types_strs;
}
if ($eit_bakeout)
{
	$bakeout_index_types = array_merge($bakeout_index_types, $bakeout_index2_types);
	$index_types = $bakeout_index_types;
	$index_types_strs = $bakeout_index_types_strs +  + $bakeout_index2_types_strs;
}

if (isset($_GET['type']) && $_GET['type'] != '')
	$type = $_GET['type'];
else
	$type = "bbso_halph";

if(isset($_GET['startdate']) && $_GET['startdate'] != '')
	$startdate = $_GET['startdate'];
else
	$startdate = date("Ymd",strtotime("-27 day", strtotime($date)));

if(isset($_GET['enddate']) && $_GET['enddate'] != '')
	$enddate = $_GET['enddate'];
else
	$enddate = $date;


$instrument = substr($type,0,4);
$filter = substr($type,5,5);

$curdate = $startdate;

$imgs = array();
$times = array();

//$prefix = "/Library/WebServer/Documents/solarmonitor/";
$prefix = "http://solarmonitor.org/";


do {
	$file = find_latest_file($curdate, $instrument, $filter, 'png', 'fd');
	if($file == "No File Found" && $type != "default")
	{
		$imgs[] = $prefix . "common_files/placeholder_220";
		$times[] = "No Time Data Available";
	}
	elseif($file != "No File Found" && $type != "default") {
		list($inst, $filt, $fd, $fdate, $time, $ext) = split('[_.]',$file,6);
		$str = $index_types_strs[$type];
		$dt = $fdate . " " . substr($time,0,2) . ":" . substr($time,2,2);
		//$str = $str . " " . date("d-M-Y H:i", strtotime($dt)) . " UT";
		$str = $str . " " . $fdate . " " . date("H:i", strtotime($dt));
		$imgs[] = $prefix . "data/$curdate/pngs/thmb/${type}_thumb.png";
		$times[] = $str;
	}
	$curdate = date("Ymd", strtotime("+1 day", strtotime($curdate)));
} while($curdate != $enddate);

echo "{ \"images\": [";
for($i=0; $i < count($imgs); $i++) {
	echo "\"" . $imgs[$i] . "\"";
	if($i != count($imgs)-1) echo ",";
}
echo "]}";

?>