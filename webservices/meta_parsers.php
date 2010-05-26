<?
	function parse_forecast($date)
	{
		include("globals.php");
		$file = "${arm_data_path}data/" . $date . "/meta/arm_forecast_" . $date . ".txt";
		
		if(file_exists($file))
		{
			$lines = file($file);
			$regions = array();
			
			foreach($lines as $line)
			{
				$region = array();
				$parts = explode(" ",$line);
				
				$region["number"] = $parts[0];
				$region["mc"] = $parts[1];
				$c = explode("(",$parts[2]);
				$m = explode("(",$parts[3]);
				$x = explode("(",$parts[4]);
				
				$region["c_ptg"] = $c[0];
				$region["c_noaa"] = substr($c[1],0,-1);
				$region["m_ptg"] = $m[0];
				$region["m_noaa"] = substr($m[1],0,-1);
				$region["x_ptg"] = $x[0];
				$region["x_noaa"] = substr($x[1],0,-1);	
				
				$region["date"]=$date;	
				
				$regions[] = $region;
			}
			
		}
		else
		{
			return(0);
		}
		
		return($regions);
		
	}
	
	function parse_ar_summary($date)
	{
		include("globals.php");
		$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_summary_" . $date . ".txt";
		
		if(file_exists($file))
		{
			$regions = array();
			
			//	Read the entire contents of the file in to the lines array
			$lines = file($file);
			foreach ($lines as $line)
			{
				$region=array();
				
				$region["date"] = $date;
				
				//	Extract all info from the line.  Events that get hyperlinks are all stored in $events and need to be split later.
				list($region["number"], $region["location1"], $region["location2"], $hale, $mcintosh, $area, $nspots, $events_str ) = split('[ ]', $line, 8);
				
				//	Split the Hale text in to individual characters.  For each part go through each character and 
				//	build a string with the image tags for each of the greek letters.
				list($region["hale_today"],$region["hale_yesterday"]) = split('[/]', $hale,2);
				list($region["mcintosh_today"],$region["mcintosh_yesterday"]) = split('[/]', $mcintosh,2);
				list($region["area_today"],$region["area_yesterday"]) = split('[/]', $area,2);
				list($region["nspots_today"],$region["nspots_yesterday"]) = split('[/]', $nspots,2);
				
				//	this section works similar to the write_events function.
				//	first, start with a blank events string, then split all the parts of the events up into an array.
				//	loop through the array.
				
				$events = array();
				
				if ($events_str[0] != "-")
				{
					$events_arr = split('[ ]', $events_str);
					for($i=0; $i<count($events_arr); $i++)
					{
						//	if there is a slash, add it to the string.  otherwise, get the url and the data that follows
						//	one array index behind.  incriment the array counter.  add the correct hyperlink to the string.
						if ($events_arr[$i] == "/")
						{
							$region["events_today"]=$events;
							$events = array();
						}
						else
						{
							$event = array();
							$event["url"] = $events_arr[$i];
							$data = $events_arr[$i+1];
							$i++;
							
							$event["class"] = substr($data,0,1);
							$event["strength"] = substr($data,1,strpos($data,"(")-1);
							$event["time"] = substr($data,strpos($data,":")-2,5);
							$event["hour"] = substr($event["time"],0,2);
							$event["minute"] = substr($event["time"],3,2);
							
							$events[]=$event;
						}
					}
					$region["events_yesterday"]=$events;
				}
				else
				{
					$region["events_today"]=$events;
					$region["events_yesterday"]=$events;
				}
				
				$regions[] = $region;
			}
			
		}
		else
		{
			return(false);
		}
		
		return($regions);
	}
	
	function parse_na_events($date)
	{
		include("globals.php");
		$file = "${arm_data_path}data/" . $date . "/meta/arm_na_events_" . $date . ".txt";
		
		if(file_exists($file))
		{	
			//	Read the entire contents of the file in to the lines array
			$lines = file($file);
					
			$events=array();
			$t_date = $date;
				
			if (trim($lines[0]) != "none")
			{		
				
				foreach ($lines as $line)
				{
					$events_arr = split('[ ]', $line);
				
					//	if there is a slash, add it to the string.  otherwise, get the url and the data that follows
					//	one array index behind.  incriment the array counter.  add the correct hyperlink to the string.
					if (trim($events_arr[0]) == "/")
					{
						$events_today=$events;
						$events = array();
						$t_date = date("Ymd",strtotime("-1 day", strtotime($date)));
					}
					else
					{
						$event = array();
						$data = $events_arr[1];
						$event["url"] = $events_arr[0];
						//$i++;
						
						$event["class"] = substr($data,0,1);
						$event["strength"] = substr($data,1,strpos($data,"(")-1);
						$event["time"] = substr($data,strpos($data,":")-2,5);
						$event["hour"] = substr($event["time"],0,2);
						$event["minute"] = substr($event["time"],3,2);
						$event["date"] = $t_date;
						
						$events[]=$event;
					}

				        $events_today=$events;	
					$events_yesterday=$events;
				}
			}
			else
			{
				$events_today=$events;
				$events_yesterday=$events;
			}
			
			$events = array();
			$events["events_today"] = $events_today;
			$events["events_yesterday"] = $events_yesterday;
			
		}
		else
		{
			return(false);
		}
		
		return($events);
	}
	
	function parse_mm_motd($date)
	{
		
		
		/*include("globals.php");
		$file = "${arm_data_path}data/" . $date . "/meta/arm_na_events_" . $date . ".txt";
		
		if(file_exists($file))
		{
				
		}*/
	}
		
?>
