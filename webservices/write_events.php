<?
	/*
	Function:
		write_events
	
	Purpose:
			Displays non-active region associated events.  This reads input from a file in the
		data folder called na_events.txt.  if there are no events, this file should have the word, none.
		otherwise, the format of the file should be (space delimited):
			URL CLASS_TIME_STRING
			URL CLASS_TIME_STRING
			...
			/
			...
			URL CLASS_TIME_STRING
			URL CLASS_TIME_STRING
		where the ... represents any number of events.  the / representing the previous days data is not
		required, neither is the previos days data.
	
	Parameters:		
		Input:
			date -- the date in YYYYMMDD format for which to display from
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/15 (RH) -- written
	*/
	
	function write_events($date)
	{
		include ("./globals.php");
		
		//	start the display
		print("<table width=780>\n");
		print("	<tr>\n");
		print("		<td align=\"left\"><font size=\"-1\">\n");
		
		//	check and see if the required data file exists.  if it doesnt, display a friendly message
		$file = "${arm_data_path}data/" . $date . "/meta/arm_na_events_" . $date . ".txt";
		if (file_exists($file))
		{
			//	read in all the lines of the file.  if the first line is "none", there is no out put.  
			//	display a message as such.  otherwise, loop through each line of the file.
			$lines=file($file);
			$line=$lines[0];
			if ($line[0] == "n")
			{
				print("		<p><b><i>Events not associated with currently named NOAA regions: None</b></i> \n");
			}
			else
			{
				print("		<p><b><i>Events not associated with currently named NOAA regions:</b></i> \n");
				foreach($lines as $line)
				{
					//	if a / is encounted, print the /.  otherwise, print a hyperlink to the event url
					if ($line[0] == "/")
					{
						print("/");
					}
					else
					{
						list($url, $data) = split('[ ]', $line, 2);
						print("<a class=mail2 href=javascript:OpenLastEvents(\"$url\")>$data</a>");
					}	
				}
			}
		}
		else
		{
			print("		<p><b><i>Events not associated with currently named NOAA regions: No Data Available</b></i> \n");
		}

		//	close up the formatting of the events portion of the table
		print("			</font></td>\n");
		print("			</tr>\n");
		print("			<tr>\n");
		print("				<td align=\"left\"><font size=\"-1\">\n");
		
		//	if the update times file exists, print the footer of the table with the sentence from the old arm site.
		//	otherwise, print it without times available.
		$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_summary_issue_time_" . $date . ".txt";	
		
		if (file_exists($file))
		{
			$times = file($file);
			$time1 = $times[0];
			$time2 = $times[1];
		}
		else
		{	
			$time1 = "some time";
			$time2 = "some time";
		}
		print("				<p><i><b>Note:</b></i> The tabulated data are based on the most recent NOAA/USAF Active Region Summary issued on $time1, the values to the right of the forward slashes representing yesterdays values or events. Regions with no data in above property fields have decayed and exhibit no spots.	The region positions are valid on $time2.\n");
		print("				</font></td>\n");
		print("			</tr>\n");
		print("		</table>\n");
	}
?>
