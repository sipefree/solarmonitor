<?
// modified
// 2005-07-01 (R. Hewett): switched from sec to local archive for goes images

	include ("./include.php");
	
	if(isset($_GET['type']))
		$type = $_GET['type'];
	else
		$type = "xray";
		
	if ($type == "xray")
	{
		$title = "GOES X-rays ";
	}
	elseif ($type == "proton") 
	{
		$title = "GOES Protons ";
	}
	elseif ($type == "electron")
	{
		$title = "GOES Electrons ";
	}
	else
	{
		$title = "RHESSI Observing Times ";
	}
	
	$year = substr($date,0,4);
	$month = substr($date,4,2);
	
	$curr_date = gmdate("Ymd");
	
	if ($type == "xray")
	{
		if ($date != $curr_date)
			$url = "${arm_data_path}data/${date}/pngs/goes/goes_xrays_${date}.png";
		else
//			$url = "http://www.sec.noaa.gov/ftpdir/plots/${year}_plots/xray/${date}_xray.gif";
			$url = "http://www.sec.noaa.gov/ftpdir/plots/xray/${date}_xray.gif";
	}
	elseif ($type == "proton")
	{
		if ($date != $curr_date)
			$url = "${arm_data_path}data/${date}/pngs/goes/goes_prtns_${date}.png";
		else
//			$url = "http://www.sec.noaa.gov/ftpdir/plots/${year}_plots/proton/${date}_proton.gif";
            $url = "http://www.sec.noaa.gov/ftpdir/plots/proton/${date}_proton.gif";
	}
	elseif ($type == "electron")
	{
		if ($date != $curr_date)
			$url = "${arm_data_path}data/${date}/pngs/goes/goes_elect_${date}.png";
		else
//			$url = "http://www.sec.noaa.gov/ftpdir/plots/${year}_plots/electron/${date}_electron.gif";
                        $url = "http://www.sec.noaa.gov/ftpdir/plots/electron/${date}_electron.gif";
	}
	else
	{
		$url = "${arm_data_path}data/${date}/pngs/gxrs/gxrs_rhessi_${date}.png";
		//	$url = "http://www.solarmonitor.org/${arm_data_path}data/${date}/pngs/gxrs/gxrs_rhessi_${date}.png";
	}	
	
	
	if ($date > $curr_date)
		$url = "./common_files/placeholder_630x485.png";
	
?>
<html>
	<head>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="refresh" content="300">
		<title><? print($title); ?>( Updates dynamically every 5-mins) </title>
		<link rel=stylesheet href="./common_files/arm-style.css" type="text/css">
	</head>
	<body>
		<table width="674" height="575" align=center valign=middle border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td background=common_files/brushed-metal.jpg align=center>
					<? write_title($date, $title, $this_page, $indexnum="1", $type, $width="95%"); ?>
				</td>
			</tr>
			<tr>
				<td align=center>
					<img align=center valign=center src="<? print $url ?>" width="630" height="485" ></a>
				</td>
			</tr>
			<tr>
				<td background=common_files/brushed-metal.jpg align=center>
					<table width=100% border=0>
						<tr>
							<td background=common_files/brushed-metal.jpg valign=middle align=center><font color=white>
								<a class=mail href="./goes_pop.php?date=<? print $date ?>&type=xray"><b>X-rays</b></a>
							</font></td>
							<td background=common_files/brushed-metal.jpg valign=middle align=center><font color=white>
								<a class=mail href="./goes_pop.php?date=<? print $date ?>&type=proton"><b>Protons</b></a>
							</font></td>
							<td background=common_files/brushed-metal.jpg valign=middle align=center><font color=white>
								<a class=mail href="./goes_pop.php?date=<? print $date ?>&type=electron"><b>Electrons</b></a>
							</font></td>
							<!--<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a class=mail href="./goes_pop.php?date=<? print $date ?>&type=rhessi">RHESSI Times</a>
							</font></td>-->
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
