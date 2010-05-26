<?
	include ("include.php");

	$title = "Flare Prediction System";	
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
						<? write_left($date,-1	); ?>
					</td>
					<td bgcolor=#FFFFFF>
						<table background=common_files/brushed-metal.jpg width=100% height=673 cellpadding=0 cellspacing=0>
							<tr>
								<td bgcolor=#FFFFFF align=left valign=top colspan=1 height=10%>
									<table cellspacing=0 cellpadding=20 border=0 width=100% height=100%><tr><td>
									Welcome to the Flare Prediction System. This page 
									gives the active regions on the Sun today together with each regions probability
									for producing C-, M-, or X-class events. The flare probabilities were calculated using
									<a class=mail2 href="http://www.sec.noaa.gov/">NOAA Space Environment Center</a> data from nearly
									eight years of data starting November 1988 and ending June 1996. The percentage 
									probabilities are based on the number of flares produced by regions classified using
									the McIntosh classification scheme (McIntosh, P., 1990, <i>Solar Physics</i>, <b>125</b>, 251) during cycle 22.
									For example, between November 1988 and June 1996 there were 302 regions 
									classified Eai. As this class produced 62 M-class events,
									the mean M-class flare rate is
									~62/302 or ~0.21 flares per day. Assuming the number of flares per
									unit time is governed by Poisson statistics, we can estimate a flaring probability
									for the following 24-hours using P( one or more flares ) = 1 - exp( -mean ), i.e.,
									P = 1 - exp( -0.21 ) ~ 0.19, or 19% for an Eai class region to produce one or more M-class
									flares in the next 24-hours. See Wheatland, M. S., 2001, <i>Solar Physics</i>, <b>203</b>, 
									87 and Moon <i>et al.</i>, 2001, <i>Journal of Geophysical Research-Space Physics</i>, 
									<b>106(A12)</b> 29951 for further details.
									<p>Click <a class=mail2 href=http://sidc.oma.be/educational/classification.php>here</a> for a description of the various active region classifications from the Royal Observatory of Belgium.<br>
									</td></tr></table>
								</td>
							</tr>
							<tr valign=top>
								<td background=common_files/brushed-metal.jpg align=center valign=middle colspan=5><font color=white>
									<b>Region Flare Probabilities (%)</b>
								</font></td>
							</tr>
							<tr>
								<td colspan=1 valign=middle height=1%><table cellpadding=5 cellspacing=0 border=0 width=100% height=1%><tr>
									<td align=center background=common_files/brushed-metal.jpg><font color=white size=-1>
										<i><b>Number</b></i>
									</font></td>
									<td align=center background=common_files/brushed-metal.jpg><font color=white size=-1>
										<i><b>McIntosh</b></i>
									</font></td>
									<td align=center background=common_files/brushed-metal.jpg><font color=white size=-1>
										<i><b>C-class</b></i>
									</font></td>
									<td align=center background=common_files/brushed-metal.jpg><font color=white size=-1>
										<i><b>M-class</b></i>
									</font></td>
									<td align=center background=common_files/brushed-metal.jpg><font color=white size=-1>
										<i><b>X-class</b></i>
									</font></td>
								</tr></table>
							</tr>
								<tr><td colspan=1 valign=bottom height=1%><table width=100% cellspacing=0 cellpadding=5 border=0 rules=rows>
							<?
								$file = "${arm_data_path}data/$date/meta/arm_forecast_" . $date . ".txt";
								
								if (file_exists($file))
								{
									$lines=file($file);
									$nline=count($lines);
									if ($nline < 2)
									{
										$line=$lines;
									}
									else
									{
										$line=$lines[0];
									}
						//temporary->
						//echo 'Use this file: '.$file;
						//echo '<br>Line[0] is: '.$lines[0];
						//endtemporary
									
									if ($line == "N" || $line == "")
									{
										print("							<tr>\n");
										print("								<td align=center valign=middle  bgcolor=#f0f0f0 colspan=5><font color=white>\n");
										print("									<b>No Prediction Found</b>");
										print("								</font></td>");
										print("							</tr>\n");										
									}
									else
									{
										foreach($lines as $line)
										{
											list($region, $mcintosh, $c, $m, $x) = split('[ ]', $line, 5);
											
											print("							<tr>                      \n");
											print("								<td align=center valign=top bgcolor=#f0f0f0><font size=-1>\n");
											print("									<a class=mail2 href=\"region.php?date=$date&region=$region\">$region</a>\n");
											print("								</td>\n");
											print("								<td align=center valign=top bgcolor=#f0f0f0><font size=-1>\n");
											print("									$mcintosh\n");
											print("								</td>\n");
											print("								<td align=center valign=top bgcolor=#f0f0f0><font size=-1>\n");
											print("									$c\n");
											print("								</td>\n");
											print("								<td align=center valign=top bgcolor=#f0f0f0><font size=-1>\n");
											print("									$m\n");
											print("								</td>\n");
											print("								<td align=center valign=top bgcolor=#f0f0f0><font size=-1>\n");
											print("									$x\n");
											print("								</td>\n");
											print("							</tr>\n");
										}
									}
								}
								else
								{
									print("							<tr>\n");
									print("								<td align=center valign=middle background=common_files/brushed-metal.jpg colspan=5><font color=white>\n");
									print("									<b>No Prediction Found</b>");
									print("								</font></td>");
									print("							</tr>\n");
								}
							?>
							</table></td></tr>
							<tr>
								<td bgcolor=#FFFFFF align=left valign=top colspan=1>
									<table width=100% height=100% cellpadding=20 cellspacing=0 border=0><tr><td valign=top><p><i><b>NOTE:</b></i>The probabilities in brackets give  
									the NOAA/SEC probability forecast for the occurrence of one 
									or more C-, M-, or X-class flares for the current date. 
									The most recent data can also be found at NOAA's
									<a class=mail2 href=http://www.sec.noaa.gov/ftpdir/latest/daypre.txt>
									3-day Space Weather Predictions</a> page.
									<p>Please contact <a class=mail2 href="mailto:peter.t.gallagher@gsfc.nasa.gov">Peter Gallagher</a> if you 
									have any comments or questions regarding this research.<br></font></td></tr></table>
								</td>
							</tr>
						</table>
					</td>
					<td background=common_files/brushed-metal.jpg valign=top align=center>
						<? write_right($date); ?>
    				</td>
  				</tr>
				<tr>
					<td background=common_files/brushed-metal.jpg align=center colspan=3>
						<? write_bottom($date); ?>
					</td>
				</tr>
			</table>
			<p>
			
			<? write_ar_table($date) ?>
			
			<p>
			<? write_events($date); ?>
			<p>
			<hr size=2>
			<p>
		</center>
	<? write_footer($time_updated); ?>
	</body>
</html>
