<?
	include ("./include.php");
		
	$title = "SolarMonitor Acknowledgments";
	$indexnum = "1";
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<body>
		<center>
			<table background=common_files/brushed-metal.jpg width=815 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td background=common_files/brushed-metal.jpg align=center colspan=3>
						<? write_title($date, $title, $this_page, $indexnum); ?>
					</td>
				</tr>
				<tr>
					<td valign=top align=center>
						<? write_left($date, -1); ?>
					</td>
					<td bgcolor=#FFFFFF valign=top align=center>
						<table width=640>
							<tr>
								<td align=left colspan=2>
									<br><b>PUBLICATIONS:</b><br><br>
									Further information on SolarMonitor.org can be found in <a class=mail2 href=http://www.springerlink.com/content/h02309110582457j/ target=_blank>Gallagher, P. T., Moon, Y.-J., Wang, H., Solar Physics, 209, 171, (2002)</a>.

									<br><br><b>ACKNOWLEDGEMENTS:</b><br><br>
									It would be appreciated if publications based on data downloaded from these
									pages would acknowledge SolarMonitor.org and the relevant
									initial data source listed below.
									Suggested acknowledgement: "Data supplied courtesy of SolarMonitor.org"
									
									<br><br><b>DATA SOURCES:</b><br><br>
									<a class=mail2 href=http://sohowww.nascom.nasa.gov target=_blank>SOHO</a>:
									Data supplied courtesy of the SOHO/MDI and SOHO/EIT consortia.
									SOHO is a project of international cooperation between ESA and NASA.<p>
									<a class=mail2 href=http://www.gong.noao.edu target=_blank>GONG</a>:
									This work utilizes magnetogram, intensity, and farside data obtained by the Global Oscillation Network Group (GONG)
									project, managed by the National Solar Observatory, which is operated by AURA, Inc.
									under a cooperative agreement with the National Science Foundation.<p>
									<a class=mail2 href=http://www.sec.noaa.gov/sxi/ target=_blank>SXI</a>: Full-disk X-ray images are supplied courtesy of the 
									Solar X-ray Imager (SXI) team.<p>
									<a class=mail2 href=http://xrt.cfa.harvard.edu/index.php target=_blank>XRT</a>: Full-disk X-ray images are supplied courtesy of the Hinode 
									X-Ray Telescope (XRT) team.<p>
									<a class=mail2 href=http://swrl.njit.edu/ghn_web/latestimg/latestimg.php target=_blank>GHN</a>: Full-disk H-alpha images are supplied courtesy of the 
									Global High Resolution H-alpha Network (GHN) team.<p>
									<a class=mail2 href=http://secchi.nrl.navy.mil/ target=_blank>STEREO</a>: Full-disk EUVI images are supplied courtesy of the STEREO 
									Sun Earth Connection Coronal and Heliospheric Investigation (SECCHI) team.<p>
									<a class=mail2 href=http://solis.nso.edu/ target=_blank>SOLIS</a>: Full-disk chromaspheric magnetograms are supplied courtesy of the Synoptic Optical Long-term Investigations of the Sun (SOLIS) 
									team.<p>
									
									<a class=mail2 href=http://www.swpc.noaa.gov target=_blank>NOAA:</a>
									Solar Region Summaries, Solar Event Lists, GOES 5-min X-rays, proton and electron data from 
									the Space Environment Center, National Oceanic and Atmospheric Administration 
									(NOAA), US Dept. of Commerce.
									<br><br><b>OTHER:</b><br><br>
									The zoom function on pages with full-disk images was adapted from <a class=mail2 href="http://valid.tjp.hu/tjpzoom/" target=_blank>TJPzoom</a> by Janos Pal Toth.
									<br><br>
								</td>
							</tr>
						</table>
					</td>
					<td valign=top align=center>
						<? write_right($date); ?>
					</td>
				</tr>
				<tr>
					<td align=center colspan=3>
						<? write_bottom($date); ?>
					</td>
				</tr>
			</table>
			<p>
			<? write_ar_table($date); ?>
			<p>
			<? write_events($date); ?>
			<p>
			<hr size=2>
			<p>
		</center>
		<? write_footer($time_updated); ?>
	</body>
</html>
