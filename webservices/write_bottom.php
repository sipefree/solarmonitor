<?
	/*
	Function:
		write_bottom
	
	Purpose:
			Displays bottom navigation links.
	
	Parameters:		
		Input:
			date -- the date in YYYYMMDD format for which to display from
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/13 (RH) -- written
	*/
	
	function write_bottom($date)
	{
		include ("./globals.php");
		print("<table background=common_files/brushed-metal.jpg width=780 border=0>\n");
//		print("	<tr>\n");
		
//		for ($i=0;$i<count($fd_types);$i++)
//		{
//			print("		<td align=center width=78>\n");
//			print("			<a class=mail href=\"full_disk.php?date=$date&type=$fd_types[$i]\">$fd_strs[$i]</a>\n");
//			print("		</td>\n");
//		}

			$lsz="3"; //size of menu links
		
			//Gong
			print("<TR><TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>GONG+</font><br><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[0]\"><font size=$lsz>$fd_strs3[0]</font></a><font color=#FFFFFF>&nbsp;/&nbsp;</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[13]\"><font size=$lsz>$fd_strs3[2]</font></a><font color=#FFFFFF>&nbsp;/&nbsp;</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[10]\"><font size=$lsz>$fd_strs3[9]</font></a>\n");
		    //MDI top row
		    print("<TH colspan='1' align=center width=86><font color=#FFFFFF size=$lsz>MDI</font>\n");
		    //GHN
		    print("<TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>GHN</font><br><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[3]\"><font size=$lsz>$fd_strs3[3]</font></a>\n");
		    //EIT top row
		    print("<TH colspan='1' align=center width=94><font size=$lsz color=#FFFFFF>EIT</font>\n");
		    //XRT
		    print("<TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>Hinode</font><br><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[8]\"><font size=$lsz>$fd_strs3[8]</font></a>\n");
			//STEREO
		    print("<TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>STEREO</font><br><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[12]\"><font size=$lsz>$fd_strs3[10]</font></a><font color=#FFFFFF>&nbsp;/&nbsp;</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[11]\"><font size=$lsz>$fd_strs3[11]</font></a>\n");
			//SWAP
			print("<TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>Proba2</font><br><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[14]\"><font size=$lsz>$fd_strs3[12]</font></a>\n");
			//Fulldisk slide show
			print("<th rowspan='2' align=center width=78><font size=$lsz><font size=$lsz color=#FFFFFF>Fulldisk</font><br><a class=mail href=\"slideshow.php?date=$date\">Slideshow</a></font>\n");
		    //proba place holder
		    //print("<TH rowspan='2' align=center width=78><font color=#FFFFFF>Proba2<BR>Swap</font>\n");
			//MDI cont & mag
			//print("<TR><TH align=right><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[1]\">$fd_strs3[1]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[2]\">$fd_strs3[2]</a>\n");
			print("<TR><TH align=center width=86><font size=$lsz><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[1]\">$fd_strs3[1]</a><font color=#FFFFFF>&nbsp;/&nbsp;</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[2]\">$fd_strs3[2]</a></font>\n");
			//EIT 171 & 195 & 284 & 304
			//print("<TH align=center><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[4]\">$fd_strs3[4]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[5]\">$fd_strs3[5]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[6]\">$fd_strs3[6]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[7]\">$fd_strs3[7]</a>\n");
			print("<TH align=center width=94><font size=$lsz><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[4]\">$fd_strs3[4]</a><font color=#FFFFFF>&nbsp;/&nbsp;</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[5]\">$fd_strs3[5]</a><font color=#FFFFFF>&nbsp;/&nbsp;</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[6]\">$fd_strs3[6]</a><font color=#FFFFFF>&nbsp;/&nbsp;</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[7]\">$fd_strs3[7]</a></font>\n");
		
	
		//	Should the slideshow only work for the current date?
//		print("		<td align=center width=78>\n");
//		print("			<a class=mail href=\"slideshow.php?date=$date\">Fulldisk<br>Slideshow</a>\n");
//		print("		</td>\n");
//		print("	</tr>\n");
		print("</table>\n");
	}
	
?>
