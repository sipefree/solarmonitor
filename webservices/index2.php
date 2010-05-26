<?
	include ("./include.php");
		
	$title = "www.SolarMonitor.org";
	$indexnum = "2";
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<? /*<body onLoad = scroll(0) onUnload = window.defaultStatus = ''> */ ?>
	<body>
		<center>
			<table bgcolor=#787878 width=815 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td background=common_files/brushed-metal.jpg align=center colspan=3>
						<!--<font size=1><br> </font>-->
						<? write_title($date, $title, $this_page, $indexnum); ?>
						<!--<font size=1><br> </font>-->
					</td>
				</tr>
				<tr>
					<td background=common_files/brushed-metal.jpg valign=top align=center>
						<? write_left($date, -1); ?>
					</td>
					<td bgcolor=#FFFFFF valign=top align=center>
						<? write_index_body($date, $indexnum); ?>
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
 			<? write_ar_table($date); ?>
			<? write_events($date); ?>
			<p>
			<hr size=2>
			<p>
		</center>
		<? write_footer($time_updated); ?>
	</body>
</html>
