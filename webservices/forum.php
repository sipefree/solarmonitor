<?
	include ("./include.php");
		
	$title = "SolarMonitor Forum";
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
									<iframe src="forum_jump.html"
									width="100%" height="600" align="left" frameborder="0" scrolling="no">
									<p>The <a href="forum_jump.html">SolarMonitor Message Board</a> should load in this space. If not, your browser does not allow "iframes".</p>
									</iframe>
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
