<?
	/*
	Function:
		write_ar_table
	
	Purpose:
			Displays the 'Today's NOAA Active Regions' table for ARM.  If 
		./data/DATE/meta/ar_table.txt does not exist, that is noted on the page.
	
	Parameters:		
		Input:
			date -- the date in YYYYMMDD format for which to display from
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/12 (RH) -- written
		2004/07/15 (RH) -- added events linking
	*/
	
	function write_ar_table($date)
	{
		include ("./globals.php");
		
		//	Contruct the file name
		$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_summary_" . $date . ".txt";
		
		//	Print the start of the table and the column headers.  These always display.
		print("<table rules=rows width=700 align=center cellpadding=0 cellspacing=0>\n");
		print("	<tr align=center><td colspan=7 align=\"center\" background=common_files/brushed-metal.jpg>\n");
		print("<table width=100% height=100% border=0 align=center cellspacing=0 cellpadding=0>\n");
		print("<tr><td colspan=7 align=center><font color=\"white\"><b>Today's NOAA Active Regions</b></font></td></tr>\n");

		print("<tr align=center>\n");
		print("  <td width=100 align=\"center\" background=common_files/brushed-metal.jpg><font color=\"white\">\n");
		print("    <i>Number</i>\n");
		print("  </font></td>\n");
		print("  <td width=100 align=\"center\" background=common_files/brushed-metal.jpg><font color=\"white\">\n");
		print("    <i>Location</i>\n");
		print("  </font></td>\n");
		print("  <td width=100 align=\"center\" background=common_files/brushed-metal.jpg><font color=\"white\">\n");
		print("    <i>Hale</i>\n");
		print("  </font></td>\n");
		print("  <td width=100 align=\"center\" background=common_files/brushed-metal.jpg><font color=\"white\">\n");
		print("    <i>McIntosh</i>\n");
		print("  </font></td>\n");
		print("  <td width=100 align=\"center\" background=common_files/brushed-metal.jpg><font color=\"white\">\n");
		print("    <i>Area</i>\n");
		print("  </font></td>\n");
		print("  <td width=100 align=\"center\" background=common_files/brushed-metal.jpg><font color=\"white\">\n");
		print("    <i>NSpots</i>\n");
		print("  </font></td>\n");
		print("  <td width=100 align=\"center\" background=common_files/brushed-metal.jpg><font color=\"white\">\n");
		print("    <i>Events</i>\n");
		print("  </font></td>\n");
		print("</tr>\n");

		print("</tr></table>");
		
		print("	</td></tr>\n");
	

		
			
		if (file_exists($file))
		{
			//	Read the entire contents of the file in to the lines array
			$lines = file($file);
			foreach ($lines as $line)
			{
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
							$hale1_str = $hale1_str . "&alpha;";
							break;
						case 'b':
							//$hale1_str = $hale1_str . "<img src=\"./common_files/beta.jpg\">";
							$hale1_str = $hale1_str . "&beta;";
							break;
						case 'g':
							//$hale1_str = $hale1_str . "<img src=\"./common_files/gamma.jpg\">";
							$hale1_str = $hale1_str . "&gamma;";
							break;
						case 'd':
							//$hale1_str = $hale1_str . "<img src=\"./common_files/delta.jpg\">";
							$hale1_str = $hale1_str . "&delta;";
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
							$hale2_str = $hale2_str . "&alpha;";
							break;
						case 'b':
							//$hale2_str = $hale2_str . "<img src=\"./common_files/beta.jpg\">";
							$hale2_str = $hale2_str . "&beta;";
							break;
						case 'g':
							//$hale2_str = $hale2_str . "<img src=\"./common_files/gamma.jpg\">";
							$hale2_str = $hale2_str . "&gamma;";
							break;
						case 'd':
							//$hale2_str = $hale2_str . "<img src=\"./common_files/delta.jpg\">";
							$hale2_str = $hale2_str . "&delta;";
							break;
						case '-':
							$hale2_str = $hale2_str . "-";
							break;	
					}
				}
				
				//	this section works similar to the write_events function.
				//	first, start with a blank events string, then split all the parts of the events up into an array.
				//	loop through the array.
				$events_str="";
				if ($events[0] != "-")
				{
					$events_arr = split('[ ]', $events);
					for($i=0; $i<count($events_arr); $i++)
					{
						//	if there is a slash, add it to the string.  otherwise, get the url and the data that follows
						//	one array index behind.  incriment the array counter.  add the correct hyperlink to the string.
						if ($events_arr[$i] == "/")
						{
							$events_str = $events_str . "/";
						}
						else
						{
							$url = $events_arr[$i];
							$data = $events_arr[$i+1];
							$i++;
							$events_str = $events_str . "<a class=mail2 href=javascript:OpenLastEvents(\"$url\")>$data</a><br>";
						}
					}
				}
				else
				{
					$events_str = "-";
				}
				
				//	Finally print all of the columns.  $events still needs to be parsed and implemented.
				print("<tr align=center>\n");
				print("  <td valign=\"top\" align=\"center\" width=100 bgcolor=#f0f0f0><font size=\"-1\">\n");
				print("    <a class=mail2 href=\"region.php?date=$date&region=$number\">$number</a>\n");
				print("  </font></td>\n");
				print("  <td valign=\"top\" align=\"center\" width=100 bgcolor=#f0f0f0><font size=\"-1\">\n");
				print("    $location1<br>$location2\n");
				print("  </td></font>\n");
				print("  <td valign=\"top\" align=\"center\" width=100 bgcolor=#f0f0f0><font size=\"-1\">\n");
				print("    $hale1_str/$hale2_str\n");
				print("  </td></font>\n");
				print("  <td valign=\"top\" align=\"center\" width=100 bgcolor=#f0f0f0><font size=\"-1\">\n");
				print("    $mcintosh\n");
				print("  </td></font>\n");
				print("  <td valign=\"top\" align=\"center\" width=100 bgcolor=#f0f0f0><font size=\"-1\">\n");
				print("    $area\n");
				print("  </td></font>\n");
				print("  <td valign=\"top\" align=\"center\" width=100 bgcolor=#f0f0f0><font size=\"-1\">\n");
				print("    $nspots\n");
				print("  </td></font>\n");
				print("  <td valign=\"top\" align=\"center\" width=100 bgcolor=#f0f0f0><font size=\"-1\">\n");
				print("    $events_str\n");
				print("  </td></font>\n");
				print("</tr>\n");	
				//print("<tr><td colspan=7 ><p class=hrstyle>_________________________________________________ </p></td></tr>\n");
			}
		}
		else
		{
			//	If there is no data file, display a warning message
			print("	<tr align=center>\n");
			print("		<td colspan=7 align=\"center\" bgcolor=\"#f0f0f0\"><font color=\"#000000\">\n");
			print("			<i>No Data Available For This Day</i>\n");
			print("		</td></font>\n");
			print("	</tr>\n");
		}	
		
		//	Close off the table
		print("</table>\n");
	}
?>