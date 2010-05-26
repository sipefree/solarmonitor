<?
	include ("./include.php");
		
	$title = "SolarMonitor Slideshow";	
	$indexnum = "1";
	
	$dir = "${arm_data_path}data/$date/pngs";
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<body onload="runSlideShow()">
		<center>
			<table background=common_files/brushed-metal.jpg width=830 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td background=common_files/brushed-top-big.jpg align=center colspan=3>
						<? write_title($date, $title, $this_page, $indexnum); ?>
					</td>
				</tr>
				<tr>
					<td valign=top align=center>
						<? write_left($date, -1); ?>
					</td>
    				<td>
						<table>
						<tr>
						<td align=center>
						<img src="./common_files/placeholder_681s.png" name="SlideShow" width="681" height="681">
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
