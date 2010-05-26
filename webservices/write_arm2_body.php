<?
	function write_index_body($date)
	{
		include("globals.php");
		
		$links=array();
		for($i=0;$i<count($index_types);$i++)
		{
			$links[] = link_image("${arm_data_path}data/$date/pngs/thmb/$index_types[$i]_thumb.png", 220, false);
			
			list($instrument, $filter) = split('[_]', $index_types[$i],2);
			$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
			if($file == "No File Found")
			{
				$times[]="No Time Data Available";
			}
			else
			{
				list($inst, $filt, $fd, $fdate, $time, $ext) = split('[_.]',$file,6);
				$str = $index_types_strs[$index_types[$i]];
				$dt = $fdate . " " . substr($time,0,2) . ":" . substr($time,2,2);
				$str = $str . " " . date("d-M-Y H:i", strtotime($dt)) . " UT";
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
			print("			<a href=\"full_disk.php?date=$date&type=" . $index_types[$i] . "\">\n");
			print("				" . $links[$i] . "\n");
			print("			</a>\n");
			print("		</td>\n");
			
			if ($i == (count($index_types)-1))
				print("	</tr>\n");
		}

		print("	<tr>\n");
		print("		<td align=left valign=top colspan=3>\n");
		?>
					<font size=+2><i>W</i></font>elcome  to the 
					Active Region Monitor (ARM) at NASA Goddard Space Flight Center's
					<a class=mail href=http://umbra.nascom.nasa.gov>Solar Data Analysis Center (SDAC)</a>, 
					and now at the <a class=mail href=http://www.kao.re.kr/html/english/index.html>Korean Astronomy Observatory's</a> <a class=mail href=http://sun.kao.re.kr/arm/>mirror site</a>.
					These pages contain the most recent solar images from the
					<a class=mail href="http://www.bbso.njit.edu/Research/Halpha/">Global H-alpha
					Network</a>, together with continuum images and magnetograms from the
					<a class=mail href="http://soi.stanford.edu/">Michelson Doppler Imager (MDI)</a>
					and EUV images from the
					<a class=mail href="http://umbra.nascom.nasa.gov/eit/">Extreme-ultraviolet Imaging Telescope (EIT)</a> onboard the ESA/NASA
					<a class=mail href="http://sohowww.nascom.nasa.gov">Solar and Heliospheric Observatory (SOHO)</a>.
					Solar event movies and flare identifications are linked from the Lockheed Martin
					<a class=mail href=http://www.lmsal.com/solarsoft/last_events>Last Events</a> page.
					Full-disk <a class=mail href=http://www.gong.noao.edu>GONG+</a> magnetograms and magnetic gradient maps 
					are supplied courtesy of the US National Solar Observatory, while soft X-ray images are provided by the NOAA <a class=mail href=http://www.sec.noaa.gov/sxi/>Solar X-ray Imager (SXI)</a>.
					<p>ARM 2.0 is now live.  The new version is designed to maintain the same layout across 
					any page on ARM.  ARM 2.0 is the first program to run on the ARM Virtual Obsveratory data set.  Data
					currently exists in full from August 10, 2004 onward.  We are working on populating the rest of the 
					data set back to the beginning of the SOHO mission.  Please be patient while this is being completed.
					The old site is still accessable <a class=mail href=" <? print("http://www.solarmonitor.org?$date/") ?> here</a> but 
					this could be removed at any time, so please update your bookmarks to the this page.
					<p>A developmental version of the automated <a class=mail href="<? print("forecast.php?date=$date") ?>">
					Flare Prediction System (FPS)</a> is also
					available on these pages. The FPS algorithm calculates the probability of each region producing
					C-, M-, and X-class events based on almost eight years of data from the 
					<a class=mail href="http://www.sec.noaa.gov/">NOAA Space Environment Center</a>. 
					Check out our <a class=mail href="./news.php">news</a> pages for up-to-date
					changes to ARM.
					<p>ARM is an integral component of the <a class=mail href=http://solar.physics.montana.edu/max_millennium/index.shtml>Max Millennium Program of Solar Flare Research</a>.
		<?
		print("		</td>\n");
		print("	</tr>\n");
		print("</table>	\n");
	}
?>
