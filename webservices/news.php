<?
	include ("./include.php");
		
	$title = "SolarMonitor News";
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
								<td>
									<table cellpadding=5 cellspacing=5>
									<?
										$file = "./common_files/news.txt";
										if (file_exists($file))
										{
											$lines=file($file);
											print("										<b>News:</b>\n");
											foreach($lines as $line)
											{
												list($news_date, $text) = split('[ ]', $line,2);
												print("										<tr>\n");
												print("											<td align=left width=20%>\n");
												print("												$news_date\n");
												print("											</td>\n");
												print("											<td align=left>\n");
												print("												$text\n");
												print("											</td>\n");
												print("										</tr>\n");
											}											
										}
										else
										{
											print("No News Found");								
										}
									?>
									</table>
								</td>
							</tr>
							<tr>
								<td align=left colspan=2>
									<br><b>ACKNOWLEDGEMENTS:</b><br><br>
									It would be appreciated if publications based on data downloaded from these
									pages would acknowledge 
									the Active Region Monitor (ARM) and the relevant
									initial data source listed below.<p>
									<a class=mail2 href=http://sohowww.nascom.nasa.gov>SOHO:</a>
									Data supplied courtesy of the SOHO/MDI and SOHO/EIT consortia.
									SOHO is a project of international cooperation between ESA and NASA.<p>
									<a class=mail2 href=http://www.gong.noao.edu>GONG:</a>
									This work utilizes data obtained by the Global Oscillation Network Group (GONG)
									project, managed by the National Solar Observatory, which is operated by AURA, Inc.
									under a cooperative agreement with the National Science Foundation.<p>
									<a class=mail2 href=http://www.sel.noaa.gov>NOAA:</a>
									Solar Region Summaries, Solar Event Lists, GOES 5-min X-rays, proton and electron data from 
									the Space Environment Center, National Oceanic and Atmospheric Administration 
									(NOAA), US Dept. of Commerce. Full-disk X-ray images are supplied courtesy of the 
									<a class=mail2 href=http://www.sec.noaa.gov/sxi/>Solar X-ray Imager (SXI)</a> team.<p>
								</td>
							</tr>
							<tr>
								<td align=left colspan=2>
									<br><b>PUBLICATIONS:</b><br><br>
									Further information on ARM can be found in <a class=mail2 href=http://www.wkap.nl/oasis.htm/5093369>Gallagher, P. T., Moon, Y.-J., Wang, H., Solar Physics, 209, 171, (2002).</a>
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
