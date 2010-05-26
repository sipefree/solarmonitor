<?
	
	include_once("./meta_parsers.php");
	include_once("./meta_utilities.php");


	//--------------------------------------------------------------------------------------
	//------------TICKER SCRAPE FUNCTIONS
	//--------------------------------------------------------------------------------------	
	function scrape_ticker_most_likely_to_flare($date)
	{
		$regions = parse_forecast($date);
		
		$most_likely = array();
		
		if((count($regions) > 0) && ($regions))
		{
			foreach($regions as $region)
			{
				if(count($most_likely) == 0)
				{
					if(($region["x_ptg"] != 0) || ($region["m_ptg"] != 0) || ($region["c_ptg"] != 0))
					{
						$most_likely = $region;
					}
				}
				else
				{
					// greatest x
					// if x = 0 or x equal, greatest m
					// if m = 0, greatest c
					
					
					if($region["x_ptg"] > $most_likely["x_ptg"])
					{
						$most_likely = $region;
					}
					elseif((($region["x_ptg"] == 0)||($region["x_ptg"] == $most_likely["x_ptg"]))&&($region["m_ptg"] > $most_likely["m_ptg"]))
					{
						$most_likely = $region;
					}
					elseif((($region["m_ptg"] == 0)||($region["m_ptg"] == $most_likely["m_ptg"]))&&($region["c_ptg"] > $most_likely["c_ptg"]))
					{
						$most_likely = $region;
					}
				}
			}
		}
		
		$item = array();
		if (count($most_likely)==0)
		{
			$item["text"] = "none";
			$item["link"] = "none";
		}
		else
		{
			$item["text"] = "Region most likely to flare: NOAA " . $most_likely["number"] . " -- Probabilities: X(" . $most_likely["x_ptg"] . "%) M(" . $most_likely["m_ptg"] . "%) C(" . $most_likely["c_ptg"] . "%)";
			$item["link"] = "http://www.solarmonitor.org/region.php?date=" . $date . "&region=" . $most_likely["number"];
		}
		
		return($item);
	}
	
	function scrape_ticker_most_active_region($date)
	{
		$regions = parse_ar_summary($date);
		
		$most_active = array();
		
		$fi_most = 0;
		
		foreach($regions as $region)
		{
			$fi = calc_flare_index($region);
			if ($fi > $fi_most)
			{
				$fi_most = $fi;
				$most_active = $region;
			}
		}	

		if ($fi_most == 0)
		{
			$item["text"] = "none";
			$item["link"] = "none";
		}
		else
		{
			$flare_string = "";
			$x_string="";
			$m_string="";
			$c_string="";
			$x_plurals="";
			$m_plurals="";
			$c_plurals="";
			$counts = count_flares($most_active);
			if ($counts["x"] > 0) $x_string = $counts["x"] . " X-class";
			if ($counts["m"] > 0) $m_string = $counts["m"] . " M-class";
			if ($counts["c"] > 0) $c_string = $counts["c"] . " C-class";
			
			if ($counts["x"] > 1) $x_plurals = "s";
			if ($counts["m"] > 1) $m_plurals = "s";
			if ($counts["c"] > 1) $c_plurals = "s";
			
			if( ($x_string == "") && ($m_string != "") && ($c_string != "") ) $flare_string = $m_string . " and " . $c_string . " flare" . $c_plurals;
			elseif( ($x_string != "") && ($m_string == "") && ($c_string != "") ) $flare_string = $x_string . " and " . $c_string . " flare" . $c_plurals;
			elseif( ($x_string != "") && ($m_string != "") && ($c_string == "") ) $flare_string = $x_string . " and " . $m_string . " flare" . $m_plurals;
			elseif( ($x_string != "") && ($m_string != "") && ($c_string != "") ) $flare_string = $x_string . ", " . $m_string . ", and " . $c_string . " flare" . $c_plurals;
			elseif( ($x_string != "") && ($m_string == "") && ($c_string == "") ) $flare_string = $x_string . " flare" . $x_plurals;
			elseif( ($x_string == "") && ($m_string != "") && ($c_string == "") ) $flare_string = $m_string . " flare" . $m_plurals;
			elseif( ($x_string == "") && ($m_string == "") && ($c_string != "") ) $flare_string = $c_string . " flare" . $c_plurals;
			
			
			$item["text"] = "Most Active Region -- NOAA " . $most_active["number"] . " -- " . $flare_string;
			$item["link"] = "http://www.solarmonitor.org/region.php?date=" . $date . "&region=" . $most_active["number"];			
		}
		
		return($item);		
	}
	
	function scrape_ticker_mm_motd($date)
	{
		$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_summary_" . $date . ".txt";
	}
	
	function scrape_ticker_most_recent_flare($date)
	{
		//most_recent_flare
		$regions = parse_ar_summary($date);
		$na_events = parse_na_events($date);
	
		$most_recent = array();
		
		$most_recent_hour = "00";
		$most_recent_min = "00";
		$most_recent_date = "00000000";
		$from_na = 0;
		
		foreach($regions as $region)
		{
			$region_time = most_recent_flare($region);

			if ( (($region_time["event"]["hour"] > $most_recent_hour) && ($region_time["date"] >= $most_recent_date))|| 
				(($region_time["event"]["hour"] == $most_recent_hour)&&($region_time["event"]["minute"] > $most_recent_min) && ($region_time["date"] >= $most_recent_date)) &&
				(count($region_time) != 0))
			{
				$most_recent = $region_time;
				$most_recent_hour = $region_time["event"]["hour"];
				$most_recent_min = $region_time["event"]["minute"];
				$most_recent_date = $region_time["event"]["date"];
			}
		}		
		
		$region_time = most_recent_flare($na_events);


		if ( (($region_time["event"]["hour"] > $most_recent_hour) && ($region_time["date"] >= $most_recent_date))|| 
			(($region_time["event"]["hour"] == $most_recent_hour)&&($region_time["event"]["minute"] > $most_recent_min) && ($region_time["date"] >= $most_recent_date)) &&
			(count($region_time) != 0))
		{
			$most_recent = $region_time;
			$most_recent_hour = $region_time["event"]["hour"];
			$most_recent_min = $region_time["event"]["minute"];
			$most_recent_date = $region_time["event"]["date"];
			$from_na = 1;
		}	
		
		if (count($most_recent) == 0)
		{
			$item["text"] = "none";
			$item["link"] = "none";
		}
		else
		{
			if($from_na) $from_text = " from Off of the Solar Disk";
			else $from_text = " from NOAA " . $most_recent["number"];
			$item["text"]= "Most Recent Flare -- " . $most_recent["event"]["class"] . $most_recent["event"]["strength"] . 
								" at " . $most_recent["event"]["time"] . " UT" . $from_text;
			$item["link"] = "javascript:OpenLastEvents(\\\"" . $most_recent["event"]["url"] . "\\\")";
		}
		
		return($item);
	}
	
	function scrape_ticker_activity_level($date)
	{
		$regions = parse_ar_summary($date);
		$na_events = parse_na_events($date);
		
		$most_active = array();
		
		$fi_total = 0;
		
		$x_count =0;
		$m_count =0;
		$c_count =0;
		
		foreach($regions as $region)
		{
			$fi = calc_flare_index($region);
			$fi_total += $fi;
			$counts = count_flares($region);
			
			$x_count += $counts["x"];
			$m_count += $counts["m"];
			$c_count += $counts["c"];
		}	
		
		$fi_na = calc_flare_index($na_events);
		$fi_total += $fi_na;
		
		$na_counts = count_flares($na_events);
		$x_count += $na_counts["x"];
		$m_count += $na_counts["m"];
		$c_count += $na_counts["c"];
		
		
		$x_string="";
		$m_string="";
		$c_string="";
		$x_plurals="";
		$m_plurals="";
		$c_plurals="";
		if ($x_count > 0) $x_string = $x_count . " X-";
		if ($m_count > 0) $m_string = $m_count . " M-";
		if ($c_count > 0) $c_string = $c_count . " C-";
		
		if ($x_count > 1) $x_plurals = "s";
		if ($m_count > 1) $m_plurals = "s";
		if ($c_count > 1) $c_plurals = "s";
		
		if( ($x_string == "") && ($m_string != "") && ($c_string != "") ) $flare_string = $m_string . " and " . $c_string . "class flare" . $c_plurals;
		elseif( ($x_string != "") && ($m_string == "") && ($c_string != "") ) $flare_string = $x_string . " and " . $c_string . "class flare" . $c_plurals;
		elseif( ($x_string != "") && ($m_string != "") && ($c_string == "") ) $flare_string = $x_string . " and " . $m_string . "class flare" . $m_plurals;
		elseif( ($x_string != "") && ($m_string != "") && ($c_string != "") ) $flare_string = $x_string . ", " . $m_string . ", and " . $c_string . "class flare" . $c_plurals;
		elseif( ($x_string != "") && ($m_string == "") && ($c_string == "") ) $flare_string = $x_string . "class flare" . $x_plurals;
		elseif( ($x_string == "") && ($m_string != "") && ($c_string == "") ) $flare_string = $m_string . "class flare" . $m_plurals;
		elseif( ($x_string == "") && ($m_string == "") && ($c_string != "") ) $flare_string = $c_string . "class flare" . $c_plurals;
		else $flare_string = "no flares";

		if ($fi_total == 0)
		{
			$item["text"] = "Activity Level -- VERY LOW -- " . $flare_string . " in past two days";
			$item["link"] = "javascript:OpenGoes(\\\"./goes_pop.php?date=$date&type=xray\\\")";
		}
		elseif ($fi_total < 10)
		{			
			$item["text"] = "Activity Level -- LOW -- " . $flare_string . " in past two days";
			$item["link"] = "javascript:OpenGoes(\\\"./goes_pop.php?date=$date&type=xray\\\")";
		}
		elseif ($fi_total < 100)
		{
			$item["text"] = "Activity Level -- MEDIUM -- " . $flare_string . " in past two days";
			$item["link"] = "javascript:OpenGoes(\\\"./goes_pop.php?date=$date&type=xray\\\")";
		}			
		elseif ($fi_total < 1000)
		{			
			$item["text"] = "Activity Level -- HIGH -- " . $flare_string . " in past two days";
			$item["link"] = "javascript:OpenGoes(\\\"./goes_pop.php?date=$date&type=xray\\\")";
		}
		elseif ($fi_total >= 1000)
		{			
			$item["text"] = "Activity Level -- VERY HIGH -- " . $flare_string . " in past two days";
			$item["link"] = "javascript:OpenGoes(\\\"./goes_pop.php?date=$date&type=xray\\\")";		
		}
		
		return($item);	
	}

	//--------------------------------------------------------------------------------------
	//------------RSS SCRAPE FUNCTIONS
	//--------------------------------------------------------------------------------------	
	function scrape_rss_most_likely_to_flare($date)
	{
		$regions = parse_forecast($date);
		
		$most_likely = array();
		
		if((count($regions) > 0) && ($regions))
		{
			foreach($regions as $region)
			{
				if(count($most_likely) == 0)
				{
					if(($region["x_ptg"] != 0) || ($region["m_ptg"] != 0) || ($region["c_ptg"] != 0))
					{
						$most_likely = $region;
					}
				}
				else
				{
					// greatest x
					// if x = 0 or x equal, greatest m
					// if m = 0, greatest c
					
					
					if($region["x_ptg"] > $most_likely["x_ptg"])
					{
						$most_likely = $region;
					}
					elseif((($region["x_ptg"] == 0)||($region["x_ptg"] == $most_likely["x_ptg"]))&&($region["m_ptg"] > $most_likely["m_ptg"]))
					{
						$most_likely = $region;
					}
					elseif((($region["m_ptg"] == 0)||($region["m_ptg"] == $most_likely["m_ptg"]))&&($region["c_ptg"] > $most_likely["c_ptg"]))
					{
						$most_likely = $region;
					}
				}
			}
		}
		
		$item = array();
		if (count($most_likely)==0)
		{
			$item["text"] = "none";
			$item["link"] = "none";
		}
		else
		{
			$item["text"] = "Region most likely to flare: NOAA " . $most_likely["number"] . " -- Probabilities: X(" . $most_likely["x_ptg"] . "%) M(" . $most_likely["m_ptg"] . "%) C(" . $most_likely["c_ptg"] . "%)";
			$item["link"] = "http://www.solarmonitor.org/region.php?date=" . $date . "&region=" . $most_likely["number"];
		}
		
		return($item);
	}
	
	function scrape_rss_most_active_region($date)
	{
		$regions = parse_ar_summary($date);
		
		$most_active = array();
		
		$fi_most = 0;
		
		foreach($regions as $region)
		{
			$fi = calc_flare_index($region);
			if ($fi > $fi_most)
			{
				$fi_most = $fi;
				$most_active = $region;
			}
		}	

		if ($fi_most == 0)
		{
			$item = array();
		}
		else
		{
			$fi = calc_flare_index($most_active);
			$counts = count_flares($most_active);
			
			$item["title"] = "Most Active Region: NOAA " . $most_active["number"];
			$item["number"] = $most_active["number"];
			$item["hale_today"] = $most_active["hale_today"];
			$item["mcintosh_today"] = $most_active["mcintosh_today"];
			$item["area_today"] = $most_active["area_today"];
			$item["nspots_today"] = $most_active["nspots_today"];
			$item["hale_yesterday"] = $most_active["hale_yesterday"];
			$item["mcintosh_yesterday"] = $most_active["mcintosh_yesterday"];
			$item["area_yesterday"] = $most_active["area_yesterday"];
			$item["nspots_yesterday"] = $most_active["nspots_yesterday"];
			$item["x_count"] = $counts["x"];
			$item["m_count"] = $counts["m"];
			$item["c_count"] = $counts["c"];
			$item["flare_index"] = $fi;
			$item["events_today"] = $most_active["events_today"];
			$item["events_yesterday"] = $most_active["events_yesterday"];
			$item["link"] = "http://www.solarmonitor.org/region.php?date=" . $date . "&amp;region=" . $most_active["number"];			
		}
		
		return($item);		
	}
	
	function scrape_rss_mm_motd($date)
	{
		$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_summary_" . $date . ".txt";
	}
	
	function scrape_rss_most_recent_flare($date)
	{
		//most_recent_flare
		$regions = parse_ar_summary($date);
		$na_events = parse_na_events($date);
		
		$most_recent = array();
		
		$most_recent_hour = "00";
		$most_recent_min = "00";
		$most_recent_date = "00000000";
		$from_na = 0;
		
		foreach($regions as $region)
		{
			$region_time = most_recent_flare($region);


			if ( (($region_time["event"]["hour"] > $most_recent_hour) && ($region_time["date"] >= $most_recent_date))|| 
				(($region_time["event"]["hour"] == $most_recent_hour)&&($region_time["event"]["minute"] > $most_recent_min) && ($region_time["date"] >= $most_recent_date)) &&
				(count($region_time) != 0))
			{
				$most_recent = $region_time;
				$most_recent_hour = $region_time["event"]["hour"];
				$most_recent_min = $region_time["event"]["minute"];
				$most_recent_date = $region_time["event"]["date"];
			}
		}		
		
		
		$region_time = most_recent_flare($na_events);


		if ( (($region_time["event"]["hour"] > $most_recent_hour) && ($region_time["date"] >= $most_recent_date))|| 
			(($region_time["event"]["hour"] == $most_recent_hour)&&($region_time["event"]["minute"] > $most_recent_min) && ($region_time["date"] >= $most_recent_date)) &&
			(count($region_time) != 0))
		{
			$most_recent = $region_time;
			$most_recent_hour = $region_time["event"]["hour"];
			$most_recent_min = $region_time["event"]["minute"];
			$most_recent_date = $region_time["event"]["date"];
			$from_na = 1;
		}	
		
		if (count($most_recent) == 0)
		{
			$item["text"] = "none";
			$item["link"] = "none";
		}
		else
		{
			if($from_na) $from_text = " from Off of the Solar Disk";
			else $from_text = " from NOAA " . $most_recent["number"];
			$item["text"]= "Most Recent Flare -- " . $most_recent["event"]["class"] . $most_recent["event"]["strength"] . 
								" at " . $most_recent["event"]["time"] . " UT" . $from_text;
			$item["link"] = "javascript:OpenLastEvents(\\\"" . $most_recent["event"]["url"] . "\\\")";
		}
		
		return($item);
	}
	
	function scrape_rss_activity_level($date)
	{
		$regions = parse_ar_summary($date);
		$na_events = parse_na_events($date);
		
		$most_active = array();
		
		$fi_total = 0;
		
		$x_count =0;
		$m_count =0;
		$c_count =0;
		
		if ($regions == false)
		{
			$item["level"] = "No region summary available...";
			$item["title"] = "Solar Activity Level: " . $item["level"];
			$item["x_count"]="?";
			$item["m_count"]="?";
			$item["c_count"]="?";
			$item["flare_index"] = "?";
			$item["link"] = "http://www.solarmonitor.org/goes_pop.php?date=$date&amp;type=xray";
			return($item);	
		}
		
		foreach($regions as $region)
		{
			$fi = calc_flare_index($region);
			$fi_total += $fi;
			$counts = count_flares($region);
			
			$x_count += $counts["x"];
			$m_count += $counts["m"];
			$c_count += $counts["c"];
		}	
		
		$fi_na = calc_flare_index($na_events);
		$fi_total += $fi_na;
		
		$na_counts = count_flares($na_events);
		$x_count += $na_counts["x"];
		$m_count += $na_counts["m"];
		$c_count += $na_counts["c"];



		if ($fi_total == 0)
		{
			$item["level"] = "VERY LOW";
		}
		elseif ($fi_total < 10)
		{			
			$item["level"] = "LOW";
		}
		elseif ($fi_total < 100)
		{
			$item["level"] = "MEDIUM";
		}			
		elseif ($fi_total < 1000)
		{			
			$item["level"] = "HIGH";
		}
		elseif ($fi_total >= 1000)
		{			
			$item["level"] = "VERY HIGH";
		}
		
		$item["title"] = "Solar Activity Level: " . $item["level"];
		
		$item["x_count"]=$x_count;
		$item["m_count"]=$m_count;
		$item["c_count"]=$c_count;
		
		$item["flare_index"] = $fi_total;
		
		$item["link"] = "http://www.solarmonitor.org/goes_pop.php?date=$date&amp;type=xray";
		
		
		return($item);	
	}

?>
