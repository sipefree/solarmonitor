<?
	include ("./include.php");
	
	$arm_data_path = "http://solarmonitor.org/";
	
	$indexnum = "1";
	
	if(isset($_GET['type']))
		$type = $_GET['type'];
	else
		$type = "smdi_igram";	
	
	if (isset($_GET['region']))
		$region = $_GET['region'];
	else
		$region = "00000";

	if (isset($_GET['indexnum']))
		$indexnum = $_GET['indexnum'];
	else
		$indexnum = "1";

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
	
	//if ($indexnum == "1")
		$sub_title = $region_strs1[$type];
	//else 
	//	$sub_title = $region2_strs1[$type];
	
	$year = substr($date,0,4);
	$month = substr($date,4,2);
	
	$instrument = substr($type,0,4);
	$filter = substr($type,5,5);
	$file = find_latest_file($date, $instrument, $filter, 'png', 'ar', $region); 
	
	
	$url = "${arm_data_path}data/$date/pngs/$instrument/$file";
	
	if($file == "No File Found")
		$url = "http://www.solarmonitor.org/common_files/placeholder_681";
		
	$curr_date = gmdate("Ymd");
	
	if ($date > $curr_date)
		$url = "./common_files/placeholder_604.png";
	
	print("{\"region\": \"$region\", \"type\": \"$type\", \"image\":\"$url\"}");
?>