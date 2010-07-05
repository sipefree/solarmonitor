<?php
include ("./include.php");
$date_str = date("D F d, Y",strtotime($date));

$json = array();
$file = "${arm_data_path}data/$date/meta/arm_mmmotd_${date}.txt";
$json["mmmotd"] = array();
$json["mmmotd"]["name"] = "Max Millennium MotD";
$json["mmmotd"]["date"] = $date_str;
$json["mmmotd"]["image"] = "mmmotd.png"; // located in the app's resources
if(file_exists($file))
{
	$lines = file_get_contents($file);
	$lines = strip_tags($lines);
	//$lines = str_replace("\n", " ", $lines);
	$pos = strpos($lines, "Dear");
	if($pos != -1) {
		$lines = substr($lines, $pos);
	}
	$json["mmmotd"]["text"] = $lines;
}
else
{
	$json["mmmotd"]["text"] = "Sorry, there is no forecast for today.";
}
print(json_encode($json));
?>