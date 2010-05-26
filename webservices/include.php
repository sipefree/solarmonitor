<?
	/*
	File:
		includes
	
	Purpose:
			Pretty much every major ARM php file needs these functions and variables
		to be set.  This does it all in one place to avoid repeating code.
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/12 (RH) -- written
		2004/07/15 (RH) -- updated
	*/

    //  this section of code determines the current file being loaded, this is useful for the title
	//  area because you want the previous and next navigation links to take you to the current
	//  page type (eit, mdi, etc, full disk, partial, etc), not the index page for that particular day
	$this_page_t = $_SERVER["PHP_SELF"];
	//list($temp1, $temp2, $this_page) = split('[/]', $this_page_t);
	//print("$this_page_t $temp1 $temp2 $this_page\n");
	$location = strrpos($this_page_t, "/");
	$this_page = substr($this_page_t, $location + 1);
									
	
	//	include all the fuctions
	include ("./write_ar_table.php");
	include ("./write_title.php");
	include ("./write_bottom.php");
	include ("./write_left.php");
	include ("./write_right.php");
	include ("./write_footer.php");
	include ("./write_header.php");
	include ("./write_jscript.php");
	include ("./write_statcounter.php");
	include ("./write_googleanalytics.php");

	//include the body stuff separately because of the ticker's javascript.  in reality they should all
	//be included separately but that would require a redesign.  this will come someday
	//if ($this_page == "index.php") include ("./write_index_body.php");
	//if ($this_page == "index2.php") include ("./write_index_body2.php");
	if ($this_page != "search.php") 
		if ($this_page != "region.php")
			include ("./write_index_body.php");
	include ("./write_events.php");
	include ("./write_image_map.php");
	include ("./write_region_body.php");
	
	//	include the generic functions and arrays that may be needed by anything
	include ("./globals.php");
	include ("./functions.php");
	include ("./bakeout.php");
	include ("./scrape_functions.php");
	
	//	if there is a current date set in GET (query string),
	//	set the date to that date, otherwise set it to the current UTC date 
	//	gmdate performs date operations with respect to UTC
	if (isset($_GET['date']))
		$date = $_GET['date'];
	if(!isset($_GET['date']) || $_GET['date'] == "default")
		$date = gmdate("Ymd");
		
	$current_date = gmdate("Ymd");
	
	if($date == $current_date)
	{
		if(gmdate("H:i") < "00:45")
			$date = $date - 1;
	}
	
	//	this section of code determines the current file being loaded, this is useful for the title
	//	area because you want the previous and next navigation links to take you to the current
	//	page type (eit, mdi, etc, full disk, partial, etc), not the index page for that particular day
	//$this_page_t = $_SERVER["PHP_SELF"];
	//list($temp1, $temp2, $this_page) = split('[/]', $this_page_t);
	//print("$this_page_t $temp1 $temp2 $this_page\n");
	//$location = strrpos($this_page_t, "/");
	//$this_page = substr($this_page_t, $location + 1);
	
	//	this looks for the file indicating when the ARM image generation code was most recently run
	//	if the file is there, it sets the time updated variable.  if it isnt, it is not updated
	$file = "${arm_data_path}data/" . $date . "/meta/arm_last_update_" . $date . ".txt";
	if(file_exists($file))
	{
		$times = file($file);
		$time_updated = $times[0];
	}
	else
	{
		$time_updated = "Not Updated";
	}
	
	//$eit_bakeout = true;//in_bakeout($date);
	
?>
