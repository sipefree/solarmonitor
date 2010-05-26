<?
	include ("./include.php");
		
	$title = "Links to SolarMonitor";
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
									<br><b>Links to SolarMonitor:</b><br><br>
									<a href="http://solarcycle24.com/" target="_blank">http://solarcycle24.com</a> <br>
									"SolarCycle24.com will be your one stop source for everything Solar and Aurora as it relates to Cycle 24. You will find Real Time data, News, Charts, Images, Multimedia and much more. My goal is to put all important information from various sources into one spot. As soon as something important is happening on the sun, you will see it here first. "
									
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
