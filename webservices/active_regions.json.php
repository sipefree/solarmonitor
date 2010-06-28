<?php

include ("globals.php");
include ("include.php");

//	Contruct the file name
$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_summary_" . $date . ".txt";
//	Print the start of the table and the column headers.  These always display.

print("{ \"regions\": [ ");
	
if (file_exists($file))
{
	//	Read the entire contents of the file in to the lines array
	$lines = file($file);
	for ($i = 0; $i < count($lines); $i++)
	{
		$line = str_replace("\n", "", $lines[$i]);
		//	Extract all info from the line.  Events that get hyperlinks are all stored in $events and need to be split later.
		list($number, $location1, $location2, $hale, $mcintosh, $area, $nspots, $events ) = split('[ ]', $line, 8);
		
		//	Split the Hale text in to individual characters.  For each part go through each character and 
		//	build a string with the image tags for each of the greek letters.
		list($hale1,$hale2) = split('[/]', $hale,2);
		$hale1_arr = preg_split('//', $hale1, -1, PREG_SPLIT_NO_EMPTY);
		$hale2_arr = preg_split('//', $hale2, -1, PREG_SPLIT_NO_EMPTY);
		
		$hale1_str = "";
		$hale2_str = "";
		
		foreach($hale1_arr as $elem)
		{
			switch($elem)
			{
				case 'a':
					//$hale1_str = $hale1_str . "<img src=\"./common_files/alpha.jpg\">";
					$hale1_str = $hale1_str . "ɑ";
					break;
				case 'b':
					//$hale1_str = $hale1_str . "<img src=\"./common_files/beta.jpg\">";
					$hale1_str = $hale1_str . "β";
					break;
				case 'g':
					//$hale1_str = $hale1_str . "<img src=\"./common_files/gamma.jpg\">";
					$hale1_str = $hale1_str . "ɣ";
					break;
				case 'd':
					//$hale1_str = $hale1_str . "<img src=\"./common_files/delta.jpg\">";
					$hale1_str = $hale1_str . "δ";
					break;
				case '-':
					$hale1_str = $hale1_str . "-";
					break;	
			}
		}
		
		foreach($hale2_arr as $elem)
		{
			switch($elem)
			{
				case 'a':
					//$hale2_str = $hale2_str . "<img src=\"./common_files/alpha.jpg\">";
					$hale2_str = $hale2_str . "ɑ";
					break;
				case 'b':
					//$hale2_str = $hale2_str . "<img src=\"./common_files/beta.jpg\">";
					$hale2_str = $hale2_str . "β";
					break;
				case 'g':
					//$hale2_str = $hale2_str . "<img src=\"./common_files/gamma.jpg\">";
					$hale2_str = $hale2_str . "ɣ";
					break;
				case 'd':
					//$hale2_str = $hale2_str . "<img src=\"./common_files/delta.jpg\">";
					$hale2_str = $hale2_str . "δ";
					break;
				case '-':
					$hale2_str = $hale2_str . "-";
					break;	
			}
		}
		
		$events_str="";
		if ($events[0] != "-")
		{
			$events_arr = split('[ ]', $events);
			for($j=0; $j<count($events_arr); $j++)
			{
				//	if there is a slash, add it to the string.  otherwise, get the url and the data that follows
				//	one array index behind.  incriment the array counter.  add the correct hyperlink to the string.
				if ($events_arr[$j] == "/")
				{
					$events_str = $events_str . "/";
				}
				else
				{
					$url = $events_arr[$j];
					$data = $events_arr[$j+1];
					$j++;
					$events_str = $events_str . "$data ";
				}
			}
		}
		else
		{
			$events_str = "-";
		}
		
		print("{ ");
		print("\"number\": " . addslashes($number) . ", ");
		print("\"location1\": \"" . addslashes($location1) . "\", ");
		print("\"location2\": \"" . addslashes($location2) . "\", ");
		print("\"hale1\": \"" . addslashes($hale1_str) . "/" . addslashes($hale2_str) . "\", ");
		print("\"mcintosh\": \"" . addslashes($hale2_str) . "\", ");
		print("\"area\": \"" . addslashes($area) . "\", ");
		print("\"nspots\": \"" . addslashes($nspots) . "\", ");
		print("\"events\": \"" . addslashes($events_str) . "\"");
		print("}");
		if($i != count($lines)-1)
			print(",");
		
	}
}

print("]}");

?>