<?
	/*
	Function:
		write_title
	
	Purpose:
			Displays the title bar and the previous and next navigation links.
	
	Parameters:		
		Input:
			date -- the date in YYYYMMDD format for which to display from
			title -- the string to display in the title
			this_page -- the php file currently being displayed
			type -- optional paramter, this allows the nav links to point to the same type of page (eit_fd, region_###, etc)
			width -- allows the width to be changed, optional.  this is used in the pop up window php files
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewettvt.edu
	
	History:
		2004/07/12 (RH) -- written
		2004/07/15 (RH) -- added width and type
	*/
	
	function write_title($date, $title, $this_page, $indexnum, $type=NULL, $width=780, $region=NULL)
	{
		//	send the INDEXNUM so it goes back to the correct 6 image panel
		if (isset($indexnum))
			$indexnum_str="&indexnum=$indexnum";
		else
			$indexnum_str="";

		//	if a type is needed, add that to the query string, otherwise, it should be empty
		if (isset($type))
			$type_str="&type=$type";
		else
			$type_str="";
			
		//	if a region is needed, add that to the query string, otherwise, it should be empty
		if (isset($region))
			$region_str="&region=$region";
		else
			$region_str="";
			
		$pop_up = strpos($this_page, "pop");
		
		//Make a table for the rounded corner bg which the other table will be in the center cell.
		print("<table width=100% height=100% cellpadding=0 cellspacing=0 border=0><tr><td valign=top align=left><img src='common_files/topleftcorner.png'></td><td align=center width=100%>\n");
		
		// Print title first
		print("<img src='common_files/smtitlesmall.png'>");
		
		//	Open the table up		
		print("<table width=$width border=0 cellpadding=0 cellspacing=0>\n");
		print("	<tr>                                             \n");
		print("		<td bgcolor=gray valign=middle colspan=3 align=center><font size=+1 color=white><b>\n");
		
		//	Calculate the yyyymmdd date of the previous/next day, week, and rotation
		$prev_day=date("Ymd",strtotime("-1 day", strtotime($date)));
		$prev_week=date("Ymd",strtotime("-7 day", strtotime($date)));
		$prev_rot=date("Ymd",strtotime("-27 day", strtotime($date)));
		
		$next_day=date("Ymd",strtotime("+1 day", strtotime($date)));
		$next_week=date("Ymd",strtotime("+7 day", strtotime($date)));
		$next_rot=date("Ymd",strtotime("+27 day", strtotime($date)));
		
		$human_readable_date = date("Ymd", strtotime($date));		
		if ($pop_up !== false)
			//$human_readable_date_line = "<font size=-1><i>$human_readable_date</i></font>";
			$human_readable_date_line = "$human_readable_date";
		else
			//$human_readable_date_line = "<a class=mail3 href=\"./index.php?date=$date\"><font size=-1><i>$human_readable_date</i></font></a>";
			if ($indexnum == "2")
				$human_readable_date_line = "<a class=mail4 href=\"./index2.php?date=$date\">$human_readable_date</a>";
			else
				$human_readable_date_line = "<a class=mail4 href=\"./index.php?date=$date\">$human_readable_date</a>";

			//$human_readable_date_line = "$human_readable_date";
		//	Write out and close the rest of the table
		
		
		
		//print("			$title\n");
		print("		</font></td>\n	");
		print("	</tr>                                             \n");
		print("	<tr>                                             \n");
		print("		<td background=common_files/brushed-metal.jpg valign=middle align=left><font size=2 color=#FFFFFF><b>\n");
		//print("		<td bgcolor=gray valign=middle align=left><font color=#FFFFFF>\n");
		print("			<font size=2>&lArr;</font><a class=mail3 href =\"./$this_page?date=${prev_day}${type_str}${region_str}${indexnum_str}\"><i>$prev_day</i></a>\n");
		print("			<font size=2>&lArr;</font><a class=mail3 href =\"./$this_page?date=${prev_week}${type_str}${region_str}${indexnum_str}\"><i>Week</i></a>\n");
		print("			<font size=2>&lArr;</font><a class=mail3 href =\"./$this_page?date=${prev_rot}${type_str}${region_str}${indexnum_str}\"><i>Rotation</i></a>\n");
		print("		</b></font></td>\n");
		//print("		</td>\n");
		print("		<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=2 color=white><b>\n");
		//print("		<td bgcolor=gray valign=middle align=center><font color=white>\n");
		print("			<font size=3>$human_readable_date_line</font>\n");
		print("		</b></font></td>\n");
		//print("		</td>\n");
		print("		<td background=common_files/brushed-metal.jpg valign=middle align=right><font size=2 color=#FFFFFF><b>\n");
		//print("		<td bgcolor=gray valign=middle align=right><font color=#FFFFFF>\n");
		print("			<a class=mail3 href =\"./$this_page?date=${next_rot}${type_str}${region_str}${indexnum_str}\"><i>Rotation</i></a><font size=2>&rArr;</font>\n");
		print("			<a class=mail3 href =\"./$this_page?date=${next_week}${type_str}${region_str}${indexnum_str}\"><i>Week</i></a><font size=2>&rArr;</font>\n");    
		print("			<a class=mail3 href =\"./$this_page?date=${next_day}${type_str}${region_str}${indexnum_str}\"><i>$next_day</i></a><font size=2>&rArr;</font>\n");  
		print("		</b></font></td>\n");
		//print("		</td>\n");
		print("	</tr>\n");
		print("</table>\n");
		
		//Close the rounded corner table.
		print("</td><td align=right valign=top><img src='common_files/toprightcorner.png'></td></tr></table>\n");
	}
?>