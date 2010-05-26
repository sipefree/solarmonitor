<?
	function in_bakeout($test_date)
	{
		if(file_exists("./common_files/bakeout_dates.txt"))
		{
			$lines = file("./common_files/bakeout_dates.txt");
			foreach($lines as $line)
			{
				$start = substr($line, 0, 8);
				$end = substr($line, -9, 8);
				if (($test_date >= $start) && ($test_date <= $end))
				{
					return 1;
				}
			}
			return 0;
		}
		else
		{
			return 0;
		}
		return in_keyhole($test_date);
	}

	function in_keyhole($test_date)
	{
		if(file_exists("./common_files/soho_keyhole.txt"))
		{
			$lines=file("./common_files/soho_keyhole.txt");
		}
		else
		{
			$lines=file("http://sohowww.nascom.nasa.gov/soc/keyholes.txt");
		}
		
		$first_dash=false;
		foreach($lines as $line)
		{
			if(($first_dash==false) && ($line[0] != "-"))
			{
				continue;
			}
			elseif(($first_dash==false) && ($line[0]=="-"))
			{
				$first_dash=true;
				continue;
			}
			elseif($line[0]=="-")
			{
				continue;
			}
			else
			{
				$dates=preg_split("/[\s\t\n]+/",$line);
				if(count($dates)==6)
				{
					$start=date("Ymd",strtotime($dates[2]));
					$end=date("Ymd",strtotime($dates[3]));
					if (($test_date >= $start) && ($test_date <= $end))
					{
						return 1;
					}
				}
			}
		}
		return 0;
	}
?>
