<?
	include ("include.php");
	
	if (isset($_GET['type']))
		$type = $_GET['type'];
	else
		$type = "smdi_maglc";
		
	if (isset($_GET['indexnum']))
		$indexnum = $_GET['indexnum'];
	else
		$indexnum = "1";
	
	if ($type == "trce_m0171")
	{
		$title = "TRACE 171 &Aring; Mosaic and NOAA Active Regions";	
	}
	else
	{
		$temp_index = $fd_types2num[$type];
		$title = $fd_strs2[$temp_index] . " and NOAA Active Regions";	
	}
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<body>
		<center>
			<table background=common_files/brushed-metal.jpg width=825 cellpadding=0 cellspacing=0>
				<tr>
					<td background=common_files/brushed-top-big.jpg align=center colspan=3>
						<? write_title($date, $title, $this_page, $indexnum, $type); ?>
					</td>
				</tr>
				<tr>
					<td valign=top align=center>
						<? write_left($date,-1	); ?>
					</td>
					<td bgcolor=#FFFFFF>
						<table cellspacing=0 cellpadding=0>
							<tr><td align=left valign=middle height=30 background="./common_files/sm_toolbar_bg_black.png">
								<a href='#' class="mail2" onclick="zoomable=-1*zoomable;if (zoomable==1){writeText('<img src=common_files/zoom_small_grey.png width=25 border=0 title=&quot;Click to turn off zoom function. Drag UP and RIGHT to change zoom box.&quot;>');}else{writeText('<img src=common_files/zoom_small.png width=25 border=0 title=&quot;Click to turn on zoom function. Drag UP and RIGHT to change zoom box.&quot;>');}"><b id="zoomtoggle"><img src=common_files/zoom_small.png width=25 border=0 title='Click to turn ON zoom function. Drag UP and RIGHT to change zoom box.'></b></a><!-- &nbsp;<? include("share_include.txt"); ?> -->
							</td>
							</tr>
							<tr>
								<td align=left width=681>
									<?
										$instrument = substr($type,0,4);
										$filter = substr($type,5,5);
										$file = find_latest_file($date, $instrument, $filter, 'png', 'fd'); 
										print(link_image("${arm_data_path}data/$date/pngs/$instrument/$file", 681, true)); 
									?>
									<? write_image_map($date, $type); ?>
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
