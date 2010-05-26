<?
	function write_index_body($date, $indexnum)
	{
		include("globals.php");
		$eit_bakeout = in_bakeout($date);
		$eit_keyhole = in_keyhole($date);
		
		if ($indexnum == "2")
		{	
			$index_types = $index2_types;
			$index_types_strs = $index2_types_strs;
			if ($eit_keyhole == "1")
			{
				$index_types = $keyhole_index2_types;
				$index_types_strs = $keyhole_index2_types_strs;
			}
			if ($eit_bakeout)
			{
				$index_types = $bakeout_index2_types;
				$index_types_strs = $bakeout_index2_types_strs;
			}
		}
		else
		{
			if ($eit_keyhole == "1")
			{
				$index_types = $keyhole_index_types;
				$index_types_strs = $keyhole_index_types_strs;
			}
			if ($eit_bakeout)
			{
				$index_types = $bakeout_index_types;
				$index_types_strs = $bakeout_index_types_strs;
			}
		}
		
		$links=array();
		for($i=0;$i<count($index_types);$i++)
		{
			if($index_types[$i] == 'bake_00195')
			{
				$links[] = "<img src=\"./common_files/NoData/thumb/bakeout.thumb.png\" width=220 height=220 border=0>";
			}
			elseif($index_types[$i] == 'keyh_00195')
			{
				$links[] = "<img src=\"./common_files/NoData/thumb/keyhole.thumb.png\" width=220 height=220 border=0>";
			}
			else
			{
				$links[] = link_image("${arm_data_path}data/$date/pngs/thmb/$index_types[$i]_thumb.png", 220, false);
			}
			
			list($instrument, $filter) = split('[_]', $index_types[$i],2);
			$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
			if($file == "No File Found")
			{
				if($index_types[$i] == 'bake_00195')
				{
					$times[]="EIT CCD BAKEOUT";
				}
				elseif($index_types[$i] == 'smdi_maglc')
				{
					$gongfile="${arm_data_path}data/$date/pngs/thmb/gong_maglc_thumb.png";
					if (@fopen($gongfile, "r"))
					{
						$links[$i] = link_image($gongfile, 220, false);
						$index_types[$i] = 'gong_maglc';
						list($instrument, $filter) = split('[_]', $index_types[$i],2);
						$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
						if($file !== "No File Found"){
							$times[]="GONG Mag ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
						}else{$times[]="GONG Mag ".$date." ";}
					}
					else
					{
						$times[]="No Time Data Available";
					}
				}
				elseif($index_types[$i] == 'smdi_igram')
				{
					$gongintfile="${arm_data_path}data/$date/pngs/thmb/gong_igram_thumb.png";
					if (@fopen($gongintfile, "r"))
					{
						$links[$i] = link_image($gongintfile, 220, false);
						$index_types[$i] = 'gong_igram';
						list($instrument, $filter) = split('[_]', $index_types[$i],2);
						$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
						if($file !== "No File Found"){
							$times[]="GONG Cont ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
						}else{$times[]="GONG Cont ".$date." ";}

					}
					else
					{
						$times[]="No Time Data Available";
					}
				}
				elseif($index_types[$i] == 'swap_00171')
				{
					if ($eit_bakeout)
					{
						$trace171file="${arm_data_path}data/$date/pngs/thmb/trce_m0171_thumb.png";
						if (@fopen($trace171file, "r"))
						{
							$links[$i] = link_image($trace171file, 220, false);
							$index_types[$i] = 'trce_m0171';
							list($instrument, $filter) = split('[_]', $index_types[$i],2);
							$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
							if($file !== "No File Found"){
								$times[]="TRACE 171&Aring; ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
							}else{$times[]="TRACE 171&Aring; ".$date." ";}

						}
						else
						{
							$times[]="No Time Data Available";
						}
					}
					else
					{
						$eit171file="${arm_data_path}data/$date/pngs/thmb/seit_00171_thumb.png";
						if (@fopen($eit171file, "r"))
						{
							$links[$i] = link_image($eit171file, 220, false);
							$index_types[$i] = 'seit_00171';
							list($instrument, $filter) = split('[_]', $index_types[$i],2);
							$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
							if($file !== "No File Found"){
								$times[]="EIT 171&Aring; ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
							}else{$times[]="EIT 171&Aring; ".$date." ";}

						}
						else
						{
							$times[]="No Time Data Available";
						}
					}
				}
				else
				{
					$times[]="No Time Data Available";
				}
			}
			else
			{
				list($inst, $filt, $fd, $fdate, $time, $ext) = split('[_.]',$file,6);
				$str = $index_types_strs[$index_types[$i]];
				$dt = $fdate . " " . substr($time,0,2) . ":" . substr($time,2,2);
				//$str = $str . " " . date("d-M-Y H:i", strtotime($dt)) . " UT";
				$str = $str . " " . $fdate . " " . date("H:i", strtotime($dt));
				$times[]=$str;
			}
		}

		
		
		print("<table>\n");
		for ($i=0;$i<count($index_types);$i++)
		{
			if ($i == 0)
				print("	<tr>\n");
			elseif (($i % 3) == 0)
				print("	<tr>\n	<tr>\n");
				
			print("		<td align=center valign=center>\n");
			print("			<small><i>" . $times[$i] . "</i></small>\n");
			
			if($index_types[$i] == 'bake_00195' || $index_types[$i] == 'keyh_00195')
			{
				print("         <a href=\"http://sohowww.nascom.nasa.gov/hotshots/2004_01_04/\">\n");
			}
			else
			{
				print("			<a href=\"full_disk.php?date=$date&type=" . $index_types[$i] . "&indexnum=$indexnum\">\n");
			}
			print("				" . $links[$i] . "\n");
			print("			</a>\n");
			print("		</td>\n");
			
			if ($i == (count($index_types)-1))
				print("	</tr>\n");
		}

		print("	<tr>\n");
		print("		<td align=left valign=top colspan=3>\n");
		
		//Write the link to the INDEX2.php page with STEREO and Farside.
		if ($indexnum == "2")
		{
		print("<table vspace=0 align=center width=10px height=25px border=0 cellpadding=0 cellspacing=0 background=common_files/brushed-metal.jpg><tr><td align=center><a class=mail href=index.php?date=$date>&nbsp;&lArr;&nbsp;Back&nbsp;</a></td></tr></table>\n");
		}
		else
		{
		print("<table vspace=0 align=center width=10px height=25px border=0 cellpadding=0 cellspacing=0 background=common_files/brushed-metal.jpg><tr><td align=center><a class=mail href=index2.php?date=$date>&nbsp;More&nbsp;Instruments&nbsp;&rArr;&nbsp;</a></td></tr></table>\n");
		}
		?>
		
		<hr>
		<div class="arm_ticker">
			<a href="#" id="arm_ticker_link" style="text-decoration:none;color:black;" onmouseover="this.style.color='blue'" onmouseout="this.style.color='black'"></a>
		</div>
		
		<script language="JavaScript" type="text/javascript">
			<!--
				function ticker()
				{
					item_num = 0;
					curr_disp_item_length = 0;
					
					if (document.getElementById) 
					{	
						ticker_anchor = document.getElementById("ticker_anchor");
						ticker_helper();   	
					}
					else 
					{
						document.write("<style>.ticker{display:none;}.ticko{border:0px; padding:0px;}</style>");
						return true;
					}
				}
				
				function ticker_helper()
				{
					var wait_time;
					var disp_str="";
					
					if (curr_disp_item_length == 0)
					{
						//items[item_num]=items[item_num] + "...";
						//curr_disp_item_length++;
						item_num = item_num % n_items;
						arm_ticker_link.href = item_links[item_num];
					}
					
					//if ((curr_disp_item_length % 3) == 0) cursor="<span style=\"background-color:gray\">&nbsp;&nbsp;</span>";
					//else cursor="";
					//arm_ticker_link.innerHTML = disp_str + cursor;
					
					
					disp_str = "<i><b>Summary:</b></i> " + items[item_num].substring(0, curr_disp_item_length);
					
					if(curr_disp_item_length <= items[item_num].length)
					{
						curr_disp_item_length++;
						wait_time = item_time;
											
						if (((total_time/item_time)%5) == 0) cursor="";//"<span style=\"background-color:gray\">&nbsp;&nbsp;</span>";
						else cursor="";
					}
					else
					{
						
						wait_time=pause_time
						//wait_time = item_time;
						//if (total_pause_time > pause_time)
						//{
							item_num++;
							curr_disp_item_length = 0;
							total_time=0;
							total_pause_time=0;
							cursor="";
						//}
						//else
						//{
						//	total_pause_time += wait_time;
						//}						
					}
					
					total_time += wait_time;

					
					arm_ticker_link.innerHTML = disp_str + cursor;
					setTimeout("ticker_helper()", wait_time);			
				}

			
				var item_time = 75;
				var pause_time = 3000;
				var total_time = 0;
				var total_pause_time = 0;
			
				var items = new Array();
				var item_links = new Array();
				
				
				<?
					$items = array();
					
					$items[] = scrape_ticker_activity_level($date);
					$items[] = scrape_ticker_most_active_region($date);
					//$items[] = scrape_ticker_most_recent_flare($date);
					$items[] = scrape_ticker_most_likely_to_flare($date);
					
					if($eit_bakeout) 
					{
						$item=array();
						$item["text"] = "SOHO EIT is in Bakeout";
						$item["link"] = "http://sohowww.nascom.nasa.gov/hotshots/2004_01_04/";
						$items[] = $item;
					}
					
					$total = count($items);
					$missing=0;
					
					for($i=0;$i < count($items);$i++)
					{
						if($items[$i]["text"] == "none") {$total--; $missing++; continue;}
				?>
				
				items[<?=$i-$missing; ?>] = "<? print($items[$i]["text"]); ?>";
				item_links[<?=$i-$missing; ?>] = "<?=$items[$i]["link"]; ?>";
			
			    <?
			    	}
			    ?>
			
				var n_items = <?=$total; ?>;
				
				ticker();
			--> 
		</script>
		
		
		
		
	<hr>	
					<font size=+2><i>W</i></font>elcome  to  
					<a class=mail2 href=index.php>SolarMonitor</a>, hosted at the <a class=mail2 href=http://grian.phy.tcd.ie/index.php>Solar Physics Group, Trinity College Dublin</a> and at NASA Goddard Space Flight Center's
	       <a class=mail2 href=http://umbra.nascom.nasa.gov>Solar Data Analysis Center (SDAC)</a>. These pages 
					contain near-realtime and archived information on active regions and solar activity.<!--, using data from
					the from the <a class=mail2 href="http://www.bbso.njit.edu/Research/Halpha/">Global H-alpha
					Network</a>, the ESA/NASA's <a class=mail2 href=http://sohowww.nascom.nasa.gov> Solar and Heliospheric Observatory (SOHO)</a>, <a class=mail2 href=http://www.gong.noao.edu>GONG+</a>, and the <a class=mail2 href=http://www.sec.noaa.gov/>National Oceanic and Atmospheric Administration (NOAA)</a>.-->
For information on our new SolarMonitor IDL Data Object (SOLMON), check out the <a class=mail2 href="objects/solmon/" target="_blank">SOLMON Tutorial</a>. Check out <a class=mail2 href=news.php>News</a> for other updates. 
<!-- <br><br>After a recent server switch-over <a class=mail2 href=index.php>SolarMonitor</a> does not currently host a complete back-dated archive. However, data and images older than 8-Oct-2008 are available from <a class=mail2 href=http://beauty.nascom.nasa.gov/arm/data>here</a> during this period of repopulation. -->		

		<?
		print("		</td>\n");
		print("	</tr>\n");
		print("</table>	\n");
	}
?>