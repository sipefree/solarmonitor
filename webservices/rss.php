<? header('Content-Type: text/xml; charset=ISO-8859-1');//text/xml'); ?>


<?
		include ("./globals.php");
		$date = gmdate("Ymd");
	
		//	Contruct the file name
		$file = "./data/" . $date . "/meta/arm_ar_summary_" . $date . ".txt";
		$items = array();	
			
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
							$hale1_str = $hale1_str . 'a';// . "<img src=\"./common_files/alpha.jpg\">";
							break;
						case 'b':
							$hale1_str = $hale1_str . 'b';//. "<img src=\"./common_files/beta.jpg\">";
							break;
						case 'g':
							$hale1_str = $hale1_str . 'g';//. "<img src=\"./common_files/gamma.jpg\">";
							break;
						case 'd':
							$hale1_str = $hale1_str  . 'd';//. "<img src=\"./common_files/delta.jpg\">";
							break;
						case '-':
							$hale1_str = $hale1_str ;//. "-";
							break;	
					}
				}
				
				foreach($hale2_arr as $elem)
				{
					switch($elem)
					{
						case 'a':
							$hale2_str = $hale2_str ;//. "<img src=\"./common_files/alpha.jpg\">";
							break;
						case 'b':
							$hale2_str = $hale2_str ;//. "<img src=\"./common_files/beta.jpg\">";
							break;
						case 'g':
							$hale2_str = $hale2_str ;//. "<img src=\"./common_files/gamma.jpg\">";
							break;
						case 'd':
							$hale2_str = $hale2_str ;//. "<img src=\"./common_files/delta.jpg\">";
							break;
						case '-':
							$hale2_str = $hale2_str ;//. "-";
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
							$events_str = $events_str ;//. "<a class=mail href=javascript:OpenLastEvents(\"$url\")>$data</a><br>";
						}
					}
				}
				else
				{
					$events_str = "-";
				}
				
				//	Finally print all of the columns.  $events still needs to be parsed and implemented.
				
				$title = "Active Region NOAA $number";
				
				$description = "Number: NOAA $number &lt;br&gt; Mount Wilson Class: $hale1_str";
				
				$link = "http://www.solarmonitor.org/region.php?date=$date&amp;region=$number";
				
				$items[] = array("title"=>$title, "description"=>$description, "link"=>$link);
				
				/*print("    <a class=mail href=\"region.php?date=$date&region=$number\">$number</a>\n");
				
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
				print("</tr>\n");	*/
			}
		}
		else
		{
			//	If there is no data file, display a warning message
			/*print("	<tr align=center>\n");
			print("		<td colspan=7 align=\"center\" bgcolor=\"gray\"><font color=\"white\">\n");
			print("			<i>No Data Available For This Day</i>\n");
			print("		</td></font>\n");
			print("	</tr>\n");*/
		}	
		
		//	Close off the table
		//print("</table>\n");
	
?>

<rss version="2.0">
	<channel>
		<title>www.SolarMonitor.org</title>
		<description> Welcome to SolarMonitor.org at NASA Goddard Space Flight Center's Solar Data Analysis Center (SDAC).  This feed contains the most recent information information extracted from the NOAA/USAF Active Region Summary. </description>
		<link>http://www.solarmonitor.org</link>
		<? foreach($items as $item)
		{
		?>
		<item>
			<title><?=$item["title"];?></title>
			<description><?=$item["description"];?></description>
			<link><?=$item["link"];?></link>
		</item>
		<?
		}
		?>
	</channel>
</rss>
