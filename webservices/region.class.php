<?php

/**
* 
*/
class SMEvent
{
	public $url;
	public $data;
	function __construct($url, $data)
	{
		$this->url = $url;
		$this->data = $data;
	}
}


/**
* 
*/
class SMRegion
{
	public $number;
	public $date;
	public $location1;
	public $location2;
	public $hale1;
	public $hale2;
	public $mcintosh;
	public $area;
	public $nspots;
	public $events;
	
	const PATH = "/Library/WebServer/Documents/solarmonitor/data";
	
	function __construct($number, $date, $location1, $location2, $hale1, $hale2, $mcintosh, $area, $nspots, $events)
	{
		$this->number = $number;
		$this->date = $date;
		$this->location1 = $location1;
		$this->location2 = $location2;
		$this->hale1 = $hale1;
		$this->hale2 = $hale2;
		$this->mcintosh = $mcintosh;
		$this->area = $area;
		$this->nspots = $nspots;
		$this->events = $events;
	}
	
	public static function FindRegionsByDate($date) {
		$file = SMRegion::PATH . "/{$date}/meta/arm_ar_summary_{$date}.txt";
		$regions = array();
		if(file_exists($file)) {
			$lines = file($file);
			foreach($lines as $line) {
				// extract columns from the file
				list($number, $location1, $location2, $hale, $mcintosh, $area, $nspots, $events) = split('[ ]', $line, 8);
				
				// split hale values
				list($hale1, $hale2) = split('[/]', $hale, 2);
				
				$events_list = array();
				if($events{0} != "-") {
					$events = split('[ ]', $events);
					for($i=0; i<count($events); $i+=2) {
						if($events[$i] == "/")
							continue;
						$event = new SMEvent($events[$i], $events[$i+1]);
						$events_list[] = $event;
					}
				}
				
				$region = new SMRegion($number, $date, $location1, $location2, $hale1, $hale2, $mcintosh, $area, $nspots, $events_list);
				$regions[] = $region;
				
			}
		}
		return $regions;
	}
	
	public static function FindRegionByNumber($number) {
		$found_date = 0; // starting value
		if(is_dir(SMRegion::PATH)) {
			// list the directory
			$dirs = scandir(SMRegion::PATH);
			
			// remove . and ..
			unset($dirs[0], $dirs[1]);
			
			// sort the list for binary search
			sort($dirs);
			
			// fixes a possible bug where the current date
			// has no regions and as such the comparison date
			// is 1000000 leading the binary search to go the
			// wrong way and bring back a false negative result
			$dirs = array_filter($dirs, "SMRegion::DateHasRegions");
			
			$num_elements = count($dirs);
			
			$l_bound = 0;
			$r_bound = $num_elements-1;
			$cur = floor($n_elements/2);
			
			while(true) {
				$test_date = $dirs[$cur];
				$day_regions = SMRegion::FindRegionsByDate($test_date);
				foreach($day_regions as $r) {
					if($r->number == $number) {
						return $test_date;
					}
				}
				if($l_bound == $r_bound) {
					return false;
				}
				$min_r = $day_regions[0]->number;
				if($number < $min_r) {
					$r_bound = $cur;
					$cur = floor(($cur + $l_bound)/2);
				}
			}
		}
	}
}

$regions = SMRegion::FindRegionsByDate("20100708");
echo var_dump($regions);

?>