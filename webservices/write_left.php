<?
	/*
	Function:
		write_left
	
	Purpose:
			Displays left navigation links.
	
	Parameters:		
		Input:
			date -- the date in YYYYMMDD format for which to display from
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewettvt.edu
	
	History:
		2004/07/13 (RH) -- written
	*/
	
	function write_left($date, $current_region_number)
	{
		include ("./globals.php");
		
		$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_summary_" . $date. ".txt";
		
		print("<table width=50 height=680>\n");
		print("	<tr>\n");
		print("		<td align=center valign=top>\n");
		print("			<br><font color=white><b>SOHO</b></font><br>\n");
		print("			<a class=mail href=JavaScript:OpenSoho(\"./soho_pop.php?date=$date&type=eit195\")>Movies</a><br>\n");
		print("			<b><font color=\"white\"><br>Active<br>Regions</font></b>\n");
		if ($current_region_number == -1) 
			print("			<br><br>\n");
		else
			print("			<br><br>\n");
		
		if (file_exists($file))
		{
			//	Read the entire contents of the file in to the lines array
			$lines = file($file);
			foreach ($lines as $line)
			{
				//	Extract all info from the line.  Events that get hyperlinks are all stored in $events and need to be split later.
				list($number, $location1, $location2, $hale, $mcintosh, $area, $nspots, $events ) = split('[ ]', $line, 8);
				if ($current_region_number == $number)
					print("			<b><a class=mail href=\"./region.php?date=$date&region=$number\">$number</a></b>\n");//<a href=\"./region.php?date=$date&region=$number\">$number</a></b></font>\n");
				else
					print("			<a class=mail href=\"./region.php?date=$date&region=$number\">$number</a>\n");				
			}
		}
		else
		{
			//	If there is no data file, display a warning message
			print("				<font color=\"white\">No Data</font>\n");
		}
		
		//if ($current_region_number == -1) 
			print("			\n");

		print("		</td>\n");
		print("	</tr>\n");
		/*print("	<tr>\n");
		print("		<td align=center valign=bottom>\n");
		print("			<a href=JavaScript:TermWindow()>BBSO<br>Activity<br>Report<br><br></a>\n");
		print("		</td>\n");
		print("	</tr>\n");*/
		print("</table>\n");
	}
	
?>
