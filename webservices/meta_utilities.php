<?
	function count_flares($region_summary)
	{
		$x=0;
		$m=0;
		$c=0;
		
		if(count($region_summary["events_today"]) > 0)
		{
			foreach($region_summary["events_today"] as $event)
			{
				if ($event["class"] == "X")	$x++;
				if ($event["class"] == "M")	$m++;
				if ($event["class"] == "C")	$c++;
			}
		}

		if(count($region_summary["events_yesterday"]) > 0)
		{
			foreach($region_summary["events_yesterday"] as $event)
			{
				if ($event["class"] == "X")	$x++;
				if ($event["class"] == "M")	$m++;
				if ($event["class"] == "C")	$c++;
			}
		}
		
		return(array("x"=>$x, "m"=>$m, "c"=>$c));
		
	}
	
	function calc_flare_index($region_summary)
	{
		$flare_index = 0;
				
		if(count($region_summary["events_today"]) > 0)
		{
			foreach($region_summary["events_today"] as $event)
			{
				if ($event["class"] == "X")	$flare_index += (100*$event["strength"]);
				if ($event["class"] == "M")	$flare_index += (10*$event["strength"]);
				if ($event["class"] == "C")	$flare_index += (1*$event["strength"]);
			}
		}
			
		if(count($region_summary["events_yesterday"]) > 0)
		{
			foreach($region_summary["events_yesterday"] as $event)
			{
				if ($event["class"] == "X")	$flare_index += (100*$event["strength"]);
				if ($event["class"] == "M")	$flare_index += (10*$event["strength"]);
				if ($event["class"] == "C")	$flare_index += (1*$event["strength"]);
			}
		}
		
		return($flare_index);	
	}
	
		
	function most_recent_flare($region_summary)
	{
		$most_recent = array();
		
		$most_recent_hour = "00";
		$most_recent_min = "00";
		$most_recent_date = "00000000";

		if(count($region_summary["events_today"]) > 0)
		{
			foreach($region_summary["events_today"] as $event)
			{
				if ( ($event["hour"] > $most_recent_hour) || (($event["hour"] == $most_recent_hour)&&($event["minute"] > $most_recent_min) ) )
				{
					$most_recent["number"] = $region_summary["number"];
					$most_recent["date"] = $region_summary["date"];
					$most_recent["event"] = $event;
					$most_recent_hour = $event["hour"];
					$most_recent_min = $event["minute"];
					$most_recent_date = $region_summary["date"];
				}
			}
		}
			
		if((count($region_summary["events_yesterday"]) > 0) && ($most_recent_date == "00000000"))
		{
			foreach($region_summary["events_yesterday"] as $event)
			{
				if ( ($event["hour"] > $most_recent_hour) || (($event["hour"] == $most_recent_hour)&&($event["minute"] > $most_recent_min) ) )
				{
					$most_recent["number"] = $region_summary["number"];
					$most_recent["date"] = $region_summary["date"]-1;
					$most_recent["event"] = $event;
					$most_recent_hour = $event["hour"];
					$most_recent_min = $event["minute"];
					$most_recent_date = $region_summary["date"];
				}
			}
		}

		return($most_recent);	
	}

?>
