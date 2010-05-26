<?
	/*
	Function:
		write_image_map
	
	Purpose:
			Writes the html code for the full disk imagemaps.  This relies on a file
		existing called map_coords_fd_type.txt where fd_type is the type of image (eit195, gsxi, ect).
		if such a file does not exists, it will not write the map.  the files format should be:
			COORD1 COORD2 REGION_NUMBER
			COORD1 COORD2 REGION_NUMBER
			...
			COORD1 COORD2 REGION_NUMBER
		
	
	Parameters:		
		Input:
			date -- the date for display
			fd_type -- the type of full disk image being displayed
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/15 (RH) -- written
	*/
	
	function write_image_map($date, $type)
	{
		include ("./globals.php");
		
		//	start the map out
		print("			<map name=\"fulldiskmap\">\n");
		
		//	check for the existence of the file, if it is not there, do nothing
		$instrument = substr($type,0,4);
		$filter = substr($type,5,5);
		//$file = "map_coords_${instrument}_$filter.txt";  //find_latest_file($date, $instrument, $filter, 'txt', 'fd'); 
		$file = "${arm_data_path}data/" . $date . "/meta/${instrument}_${filter}_imagemap_${date}.txt";
		if (file_exists($file))
		{
			//	read all the lines of the file in and loop through them
			$lines=file($file);
			foreach($lines as $line)
			{
				//	this gets all the variables from the line.
				list($coor1, $coor2, $region) = split('[ ]', $line);
				//	a possible newline character at the end of the region variable screws up the javascript
				//	so all whitespace must be trimmed
				$region=trim($region);
				print("				<area shape=\"circle\" coords=\"$coor1,$coor2,35\" href=JavaScript:RegionZoom(\"./region_pop.php?date=$date&type=$type&region=$region\")>\n");
			}
		}
		
		//	close the map
		print("			</map>\n");	
	}
?>