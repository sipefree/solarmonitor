<?php

class SMImage
{
	public $type;
	public $instrument;
	public $filter;
	public $regionNumber = 0;
	public $date;
	private $files = -1;
	private $path = "http://solarmonitor.org/";
	private $realpath = "/Library/WebServer/Documents/solarmonitor";
	
	/**
	* Contructor for SMImage
	* Arguments:
	* 	String $type: The type of image that will be looked for, i.e. swap_00171
	*	String $date: The datestring for the image, i.e. 20100501
	*	int $region: The region number to look for, if 0, then a full definition image will be displayed.
	*/
	public function __construct($type, $date, $region=0)
	{
		$this->type = $type;
		$this->date = $date;
		list($instrument, $filter) = split('[_]', $this->type, 2);
		$this->instrument = $instrument;
		$this->filter = $filter;
		$this->regionNumber = $region;
		$this->name = SMImage::getNameForType($this->type);
	}
	
	/**
	* Array getFiles()
	* No arguments
	* Returns: a hash-map of all files for this image type and this date
	*	The keys of this hash map are timestamps and the values are full file paths
	*/
	public function getFiles() {
		if($this->files == -1) {
			$files = array();
			$dir = "{$this->realpath}/data/{$this->date}/pngs/{$this->instrument}";
			$http_dir = "{$this->path}/data/{$this->date}/pngs/{$this->instrument}";
			if(is_dir($dir)) {
				if($dir_handle = opendir($dir))
				{
					while(false !== ($file = readdir($dir_handle)))
					{
						if($file{0} == ".") continue;
						list($file_instrument, $file_filter, $fd_ar_type, $rest) = split('[_.]', $file, 4);
						if($this->regionNumber == 0 && $fd_ar_type == "ar")
							continue;
						elseif($this->regionNumber == 0 && $fd_ar_type == "fd")
							list($file_date, $file_time, $rest) = split('[_.]', $rest, 3);
						elseif($this->regionNumber != 0 && $fd_ar_type == "fd")
							continue;
						elseif($this->regionNumber != 0 && $fd_ar_type == "ar")
							list($file_region, $file_date, $file_time, $rest) = split('[_.]', $rest, 4);
						if($this->regionNumber != 0 && $file_region != $this->regionNumber)
							continue;
						if($this->instrument != $file_instrument || $this->filter != $file_filter)
							continue;

						$hh = substr($file_time,0,2);
						$mm = substr($file_time,2,2);
						$ss = substr($file_time,4,2);

						$files["$file_date $hh:$mm:$ss"] = $http_dir . "/" . $file;
					}
					closedir($dir_handle);
				}
			}
			$this->files = $files;
		}
		return $this->files;
	}
	
	/**
	* String getLatestFilename()
	* Arguments: none
	* Returns: the latest file available for that image type and date
	*/
	public function getLatestFilename() {
		$files = $this->getFiles();
		$latest_file = "";
		$latest_time = strtotime("19800101 00:00:00");
		foreach($files as $date => $file) {
			if($latest_time <= strtotime($date)) {
				$latest_time = strtotime($date);
				$latest_file = $file;
			}
		}
		return $latest_file;
	}
	
	/**
	* String getThumbnail()
	* Arguments:
	*	none
	* Returns:
	*	The file path to the thumbnail for this image
	*/
	public function getThumbnail() {
		if($this->type == "bake_00195")
			return "{$this->path}/common_files/NoData/thumb/bakeout.thumb.png";
		elseif($this->type == "keyh_00195")
			return "{$this->path}/common_files/NoData/thumb/keyhole.thumb.png";
		else
			return "{$this->path}/data/{$this->date}/pngs/thmb/{$this->type}_thumb.png";
	}
	
	/**
	* boolean requiresSubstitute()
	* Arguments: none
	* Returns:	true if there is no image found for this date and type
	* 			false if an image exists
	*/
	public function requiresSubstitute() {
		return count($this->getFiles()) == 0;
	}
	
	/**
	* SMImage | boolean getSubstitute()
	* Arguments: none
	* Returns:	an instance of SMImage containing the substitute for this image type
	*			false if such a substitute cannot be found
	*/
	public function getSubstitute() {
		if(SMImage::inBakeout($this->date))
			$swap_sub = "trce_m0171";
		else
			$swap_sub = "seit_00171";
		$map = array(
			"bake_00195" => false,
			"smdi_maglc" => "gong_maglc",
			"smdi_igram" => "gong_igram",
			"swap_00171" => $swap_sub,
		);
		if(array_key_exists($this->type, $map)) {
			if($map[$this->type] == false)
				return false;
			$sub = new SMImage($map[$this->type], $this->date, $this->regionNumber);
			if($sub->requiresSubstitute())
				return false;
			return $sub;
		}
		else {
			return false;
		}
	}
	
	public function getName() {
		return SMImage::getNameForType($this->type);
	}
	
	/**
	* String getTimestampForFilename($file)
	* Arguments:
	* 	String $file: the filepath that will be used to determine the timestamp
	* Return:
	*	A string containing the timestamp
	*/
	public function getTimestampForFilename($file) {
		$parts = split("/", $file);
		$filename = $parts[count($parts)-1];
		return $this->date . " " . substr($filename,23,2) . ":" . substr($filename,25,2);
	}
	
	/**
	* static Array getAvailableImageTypes($date)
	* Arguments:
	*	String $date: the date string that will be used to determine available image types
	* Return:
	*	An array of image types that can be used
	*/
	public static function getAvailableImageTypes($date) {
		$types = array("smdi_maglc", "smdi_igram", "swap_00174", "seit_00195", "hxrt_flter", "smdi_maglc", "slis_chrom", "gong_farsd", "strb_00195", "seit_00195", "stra_00195");
		if(SMImage::inBakeout($date)) {
			$types = array("smdi_maglc", "smdi_igram", "bbso_halph", "swap_00174", "bake_00195", "hxrt_flter", "gong_maglc", "slis_chrom", "gong_farsd", "strb_00195", "trce_m0171", "stra_00195");
		}
		if(SMImage::inKeyhole($date)) {
			$types = array("smdi_maglc", "smdi_igram", "bbso_halph", "swap_00174", "keyh_00195", "hxrt_flter", "gong_maglc", "slis_chrom", "gong_farsd", "strb_00195", "trce_m0171", "stra_00195");
		}
		return $types;
	}
	
	/**
	* static String getNameForType($type)
	* Arguments:
	*	String $type: the type that you want a description for
	* Return:
	*	A string containing the description of this type
	*/
	public static function getNameForType($type) {
		$map = array(
			"gong_maglc" => "GONG Magnetogram",
			"gong_igram" => "GONG Continuum",
			"smdi_maglc" => "SOHO MDI Magnetogram",
			"smdi_igram" => "SOHO MDI Continuum",
			"bbso_halph" => "BBSO GHN Hydrogen-Alpha",
			"seit_00171" => "SOHO Ultraviolet (17.1nm)",
			"seit_00195" => "SOHO Ultraviolet (19.5nm)",
			"hxrt_flter" => "Solar-B X-ray Telescope",
			"swap_00174" => "Sun Watcher APS (17.4nm)",
			"slis_chrom" => "SOLIS Magnetogram",
			"gong_farsd" => "GONG Farside",
			"strb_00195" => "STEREO B (19.5nm)",
			"stra_00195" => "STEREO A (19.5nm)",
			"trce_m0171" => "TRC (17.1nm)",
			"bake_00195" => "CCD BAKEOUT",
			"keyh_00195" => "SOHO KEYHOLE"
			);
		if(!array_key_exists($type, $map))
			return "Unknown";
		else
			return $map[$type];
	}
	
	/**
	* static boolean inBakeout()
	* Arguments:
	*	String $test_date: the date for finding out if bakeout is on
	* Return:
	*  A bool stating whether bakeout is on
	*/
	public static function inBakeout($test_date) {
		if(file_exists("./common_files/bakeout_dates.txt"))
		{
			$lines = file("./common_files/bakeout_dates.txt");
			foreach($lines as $line)
			{
				$start = substr($line, 0, 8);
				$end = substr($line, -9, 8);
				if (($test_date >= $start) && ($test_date <= $end))
				{
					return true;
				}
			}
			return false;
		}
		else
		{
			return false;
		}
		return SMImage::inKeyhole($test_date);
	}
	
	/**
	* static boolean inKeyhole()
	* Arguments:
	*	String $test_date: the date for finding out if keyhole is on
	* Return:
	*  A bool stating whether keyhole is on
	*/
	public static function inKeyhole($test_date) {
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
						return true;
					}
				}
			}
		}
		return false;
	}
}

$date = "20100705";
$types = SMImage::getAvailableImageTypes($date);
$imgs = array();
foreach($types as $type) {
	$obj = new SMImage($type, $date);
	if($obj->requiresSubstitute()) {
		$obj = $obj->getSubstitute();
		if($obj == false)
			continue;
	}
	$file = $obj->getLatestFilename();
	$imgs[] = array(
		"type" => $obj->type,
		"name" => $obj->getName(),
		"timestamp" => $obj->getTimestampForFilename($file),
		"thumbnail" => $obj->getThumbnail(),
		"fullRes" => $file,
	);
}
print json_encode(array("imageSources" => $imgs));

?>