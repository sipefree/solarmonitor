<?
	include ("./include.php");
	$indexnum = "1";
	
	if(isset($_GET['type']))
		$type = $_GET['type'];
	else
		$type = "smdi_igram";	
	
	if (isset($_GET['region']))
		$region = $_GET['region'];
	else
		$region = "00000";

	if (isset($_GET['indexnum']))
		$indexnum = $_GET['indexnum'];
	else
		$indexnum = "1";

	$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_titles_" . $date . ".txt";
	if (file_exists($file))
	{
		$lines=file($file);
		$title = "No Region $region Found";
		foreach($lines as $line)
		{
			list($number, $temp_title) = split('[ ]', $line, 2);
			if ($number == $region)
			{
				$title = $temp_title;
				break;
			}
		}	
	}
	else
	{
		$title = "No Title Found";
	}
	
	//if ($indexnum == "1")
		$sub_title = $region_strs1[$type];
	//else 
	//	$sub_title = $region2_strs1[$type];
	
	$year = substr($date,0,4);
	$month = substr($date,4,2);
	
	$instrument = substr($type,0,4);
	$filter = substr($type,5,5);
	$file = find_latest_file($date, $instrument, $filter, 'png', 'ar', $region); 
	
	$url = "${arm_data_path}data/$date/pngs/$instrument/$file";
		
	$curr_date = gmdate("Ymd");
	
	if ($date > $curr_date)
		$url = "./common_files/placeholder_604.png";
?>
<html>
	<head>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="refresh" content="900">
		<title><? print($title); ?></title>
		<link rel=stylesheet href="./common_files/arm-style.css" type="text/css">
	</head>
	<body>
		<table background=common_files/brushed-metal.jpg width="620" height="710" align=center valign=middle border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td align=center>
					<? write_title($date, $sub_title, $this_page, $indexnum, $type, $width="95%", $region); ?>
				</td>
			</tr>
			<tr>
				<td bgcolor=#FFFFFF align=center>
					<? print link_image($url, 604, false); ?>
				</td>
			</tr>
			<tr>
				<td bgcolor=#FFFFFF align=center>
					<table width=100% border=0 cellpadding=0 cellspacing=0>
						<tr>
							<?
//								for($i=0;$i<count($region_types);$i++)
//								{
//									print("<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=-1 color=white>\n");
//									$temp_type = $region_types[$i];
//									$string = $region_strs2[$temp_type];
//									print("	<b><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[$i]&region=$region\">$string</a></b>\n");
//									print("</font></td>\n");								
//								}

//									$temp_type = $region_types[$i];
//									$string = $region_strs2[$temp_type];
									$region0=$region_types[0];
									$region1=$region_types[1];
									print("<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=-1 color=white>\n");
									print("	<b>MDI<br><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[0]&region=$region\">$region_strs2[$region0]</a>&nbsp;/&nbsp;<a class=mail href=\"./region_pop.php?date=$date&type=$region_types[1]&region=$region\">$region_strs2[$region1]</a></b>\n");
									print("</font></td>\n");	

									$region2=$region_types[2];
									print("<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=-1 color=white>\n");
									print("	<b>BBSO<br><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[2]&region=$region\">$region_strs2[$region2]</a></b>\n");
									print("</font></td>\n");	

									$region3=$region_types[3];
									$region4=$region_types[4];
									$region5=$region_types[5];
									$region6=$region_types[6];
									print("<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=-1 color=white>\n");
									print("	<b>EIT<br><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[3]&region=$region\">$region_strs2[$region3]</a>&nbsp;/&nbsp;<a class=mail href=\"./region_pop.php?date=$date&type=$region_types[4]&region=$region\">$region_strs2[$region4]</a>&nbsp;/&nbsp;<a class=mail href=\"./region_pop.php?date=$date&type=$region_types[5]&region=$region\">$region_strs2[$region5]</a>&nbsp;/&nbsp;<a class=mail href=\"./region_pop.php?date=$date&type=$region_types[6]&region=$region\">$region_strs2[$region6]</a></b>\n");
									print("</font></td>\n");									

									$region7=$region_types[7];
									print("<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=-1 color=white>\n");
									print("	<b>Hinode<br><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[7]&region=$region\">$region_strs2[$region7]</a></b>\n");
									print("</font></td>\n");	
									
									$region8=$region_types[8];
									print("<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=-1 color=white>\n");
									print("	<b>GONG+<br><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[8]&region=$region\">$region_strs2[$region8]</a></b>\n");
									print("</font></td>\n");	
									
									$region9=$region_types[9];
									print("<td background=common_files/brushed-metal.jpg valign=middle align=center><font size=-1 color=white>\n");
									print("	<b><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[9]&region=$region\">$region_strs2[$region9]</a></b>\n");
									print("</font></td>\n");	

//			$lsz="2"; //size of menu links
//			$str0=$region_types[0];
//			$str1=$region_types[1];
//			$str2=$region_types[2];
//			$str3=$region_types[3];
//			$str4=$region_types[4];
//			$str5=$region_types[5];
//			$str6=$region_types[6];
//			$str7=$region_types[7];
//			$str8=$region_types[8];
	
//		print("$region_strs2[$str0]\n");
//		print("$region_types[0]\n");
//		print("$region\n");
		
			//Gong
//			print("<TR><TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>GONG+</font><br><a class=mail href=\"./region_pop.php?date=$date&type=$region_types[0]&region=$region\"><font size=$lsz>$region_strs2[$str0]</font></a>\n");
		    //MDI top row
//		    print("<TH colspan='1' align=center width=86><font color=#FFFFFF size=$lsz>MDI</font>\n");
		    //GHN
//		    print("<TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>GHN</font><br><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[3]\"><font size=$lsz>$fd_strs3[3]</font></a>\n");
		    //EIT top row
//		    print("<TH colspan='1' align=center width=94><font size=$lsz color=#FFFFFF>EIT</font>\n");
		    //XRT
//		    print("<TH rowspan='2' align=center width=70><font size=$lsz color=#FFFFFF>Hinode</font><br><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[8]\"><font size=$lsz>$fd_strs3[8]</font></a>\n");
			//Fulldisk slide show
//			print("<th rowspan='2' align=center width=78><font size=$lsz><font size=$lsz color=#FFFFFF>Fulldisk</font><br><a class=mail href=\"slideshow.php?date=$date\">Slideshow</a></font>\n");
		    //proba place holder
		    //print("<TH rowspan='2' align=center width=78><font color=#FFFFFF>Proba2<BR>Swap</font>\n");
			//MDI cont & mag
			//print("<TR><TH align=right><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[1]\">$fd_strs3[1]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[2]\">$fd_strs3[2]</a>\n");
//			print("<TR><TH align=center width=86><font size=$lsz><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[1]\">$fd_strs3[1]</a><font color=#FFFFFF>/</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[2]\">$fd_strs3[2]</a></font>\n");
			//EIT 171 & 195 & 284 & 304
			//print("<TH align=center><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[4]\">$fd_strs3[4]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[5]\">$fd_strs3[5]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[6]\">$fd_strs3[6]</a><font color=#FFFFFF> /</font><TH align=left><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[7]\">$fd_strs3[7]</a>\n");
//			print("<TH align=center width=94><font size=$lsz><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[4]\">$fd_strs3[4]</a><font color=#FFFFFF>/</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[5]\">$fd_strs3[5]</a><font color=#FFFFFF>/</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[6]\">$fd_strs3[6]</a><font color=#FFFFFF>/</font><a class=mail href=\"full_disk.php?date=$date&type=$fd_types[7]\">$fd_strs3[7]</a></font>\n");

								
								
								
								
							?>

						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<center><? include ("./share_include.txt"); ?></center>
		
	</body>
</html>