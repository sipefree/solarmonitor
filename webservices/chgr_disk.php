<?
	include ("include.php");
	
//	if (isset($_GET['type']))
//		$type = $_GET['type'];
//	else
		$type = "chgr_00195";
		
//	if (isset($_GET['indexnum']))
//		$indexnum = $_GET['indexnum'];
//	else
		$indexnum = "1";
	
//	if ($type == "trce_m0171")
//	{
//		$title = "TRACE 171 &Aring; Mosaic and NOAA Active Regions";	
//	}
//	else
//	{
//		$temp_index = $fd_types2num[$type];
//		$title = $fd_strs2[$temp_index] . " and NOAA Active Regions";	
//	}
$title = "CHGR Magnetic Structure Detections";
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<body>
		<center>
			<table background=common_files/brushed-metal.jpg width=830 cellpadding=0 cellspacing=0>
				<tr>
					<td background=common_files/brushed-top-big.jpg align=center colspan=3>
						<? write_title($date, $title, $this_page, $indexnum, $type); ?>
					</td>
				</tr>
				<tr>
					<td valign=top align=center>
						<? write_left($date,-1	); ?>
					</td>
					<td bgcolor=#FFFFFF valign=top>
						<table>
							<tr>
								<td align=center>
									<left><a class=mail2 href="chgr_info.php?date=<? print($date); ?>">chgr Info</a><left><br>
									<!-- <table cellspacing=0 cellpadding=0 border=0><tr><td><a href='#' class="mail2" onclick="zoomable=-1*zoomable;if (zoomable==1){writeText('<img src=common_files/zoom_small_grey.png width=25 border=0 title=&quot;Click to turn off zoom function. Drag UP and RIGHT to change zoom box.&quot;>');}else{writeText('<img src=common_files/zoom_small.png width=25 border=0 title=&quot;Click to turn on zoom function. Drag UP and RIGHT to change zoom box.&quot;>');}"><b id="zoomtoggle"><img src=common_files/zoom_small.png width=25 border=0 title='Click to turn ON zoom function. Drag UP and RIGHT to change zoom box.'></b></a></td><td> - Zoom Tool</tr></td></table> -->
									<?
										$instrument = substr($type,0,4);
										$filter = substr($type,5,5);
										$files=glob("./kristal/chgr_plots/chgr_".$date."_????.png")?glob("./kristal/chgr_plots/chgr_".$date."_????.png"):array();
										if (count($files) !== 0)
										{
											$files = array_reverse($files);
											$file = $files[0];
											print(link_image("$file", 681, true)."<br>");
											$fdatetime=substr($file,35,4);
											
											$tablefiles=glob("./kristal/chgr_logs/chgr_".$date."_????_gr.txt")?glob("./kristal/chgr_logs/chgr_".$date."_????_gr.txt"):array();
											if (count($tablefiles) !== 0)
											{
												$tablefiles = array_reverse($tablefiles);
												$tablefile = $tablefiles[0];
												include $tablefile;
												
											//PUT AR TABLE INCLUDE HERE.
											}
											
											$nlfiles=glob("./kristal/chgr_plots/chgr_".$date."_".$fdatetime."_gr_*.png")?glob("./kristal/chgr_plots/chgr_".$date."_".$fdatetime."_gr*.png"):array();
											echo "<br><br>";
											if (count($nlfiles) !== 0)
											{
												foreach ($nlfiles as $nlfilename) {
													print(link_image("$nlfilename", 200, true)."</center><br><br>");
												}
											}										
											
											
										}
										else
										{
											$file="./common_files/placeholder_630x485.png";
											print("<img src=".$file." width=681>");
										}
										
										//$nlfile1 = "./common_files/placeholder_630x485.png";
										//if (@fopen("./kristal/chgr_plots/chgr_nl_01_$date.png", "r")){$nlfile1 = "./kristal/chgr_plots/chgr_nl_01_$date.png";}
										//$nlfile2 = "./common_files/placeholder_630x485.png";
										//if (@fopen("./kristal/chgr_plots/chgr_nl_01_$date.png", "r")){$nlfile1 = "./kristal/chgr_plots/chgr_nl_01_$date.png";}
										//$nlfile3 = "./common_files/placeholder_630x485.png";
										//if (@fopen("./kristal/chgr_plots/chgr_nl_01_$date.png", "r")){$nlfile1 = "./kristal/chgr_plots/chgr_nl_01_$date.png";}
										//print("<img src=".$file." width=681>"); 
									?>
									<? //write_image_map($date, $type); ?>
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
			
			<? //write_ar_table($date) ?>
			
			<p>
			<? //write_events($date); ?>
			<p>
			<hr size=2>
			<p>
		</center>
	<? write_footer($time_updated); ?>
	</body>
</html>
