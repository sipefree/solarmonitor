<?
	include ("./include.php");
		
	$title = "SolarMonitor";	
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<? /*<body onLoad = scroll(0) onUnload = window.defaultStatus = ''> */ ?>
	<body>
		<center>
			<table width=780 border=0>
				<tr>
					<td bgcolor=gray align=center colspan=3>
						<? write_title($date, $title, $this_page); ?>
					</td>
				</tr>
				<tr>
					<td bgcolor=gray valign=top align=center>
						<? write_left($date, -1); ?>
					</td>
					<td valign=top align=center>
						<? write_index_body($date); ?>
					</td>
					<td bgcolor=gray valign=top align=center>
						<? write_right($date); ?>
					</td>
				</tr>
				<tr>
					<td bgcolor=gray align=center colspan=3>
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
