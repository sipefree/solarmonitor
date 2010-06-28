<?php
include("include.php");
include("globals.php");

if (isset($_GET['region']))
	$region = $_GET['region'];
else
	die("{list:[]}");

if($region == 'default') {
	die("{\"list\":[{\"type\":\"none\",\"region\":\"default\",\"thumbnail\":\"none\"}]}");
}

$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_titles_" . $date . ".txt";
if (file_exists($file))
{
	$lines=file($file);
	$title = "No Region $region Found";
	foreach($lines as $line)
	{
		list($number, $temp_title) = split('[ ]', $line, 2);
		if ($number == $region)
		{
			$title = $temp_title;
			break;
		}
	}	
}
else
{
	$title = "No Title Found";
}

$arm_data_path = "http://solarmonitor.org/";

$links=array();
for($i=0;$i<count($region_types);$i++)
{
	$type = $region_types[$i];
	$instrument = substr($type,0,4);
	$filter = substr($type,5,5);
	$file = find_latest_file($date, $instrument, $filter, 'png', 'ar', $region);
	if($file == "No File Found")
		$links[] = "${arm_data_path}common_files/placeholder_220";
	else
		$links[] = "${arm_data_path}data/$date/pngs/$instrument/$file";
}

print("{ \"list\": [ ");

for ($i=0;$i<count($region_types);$i++)
{
		
	print("{ ");
	print("	\"type\": \"" . $region_types[$i] . "\", ");
	print(" \"region\": \"" . $region . "\", ");
	print(" \"thumbnail\": \"" . $links[$i] . "\"");
	print("}");
	if ($i != (count($region_types)-1))
		print(",");
}

print("]}");
?>