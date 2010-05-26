<?
// modified
// 2008-11-04 (P. Higgins): written	

	include ("./include.php");
	
		if(isset($_GET['type']))
		$type = $_GET['type'];
	else
		$type = "eit195";
		
	if ($type == "lascoc2")
	{
		$title = "SOHO LASCO C2 ";
	}
	elseif ($type == "lascoc3") 
	{
		$title = "SOHO LASCO C3 ";
	}
	elseif ($type == "stra") 
	{
		$title = "STEREO Ahead ";
	}
	elseif ($type == "strb") 
	{
		$title = "STEREO Behind ";
	}
	elseif ($type == "eit171")
	{
		$title = "SOHO EIT 171 ";
	}
	elseif ($type == "eit304")
	{
		$title = "SOHO EIT 304 ";
	}
	elseif ($type == "eit284")
	{
		$title = "SOHO EIT 284 ";
	}
	elseif ($type == "mdimag")
	{
		$title = "SOHO MDI Magnetogram ";
	}
	elseif ($type == "mdicon")
	{
		$title = "SOHO MDI Continuum ";
	}
	elseif ($type == "eit195")
	{
		$title = "SOHO EIT 195 ";
	}
	else
	{
		$title = "Hinode XRT ";
	}
	
	$year = substr($date,0,4);
	$yy = substr($date,2,2);
	$month = substr($date,4,2);
	$day = substr($date,6,2);
	
	$curr_date = gmdate("Ymd");
	
	if ($type == "lascoc2")
	{
		if ($date != $curr_date)
		{
			$url = "./common_files/placeholder_630x485.png";
			if (@fopen("http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_d2.mpg", "r")){$url = "http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_d2.mpg";}
			if (@fopen("http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_c2.mpg", "r")){$url = "http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_c2.mpg";}
		}
		else
		{
			$url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_c2.mpg";
//			$url = "http://www.sec.noaa.gov/ftpdir/plots/xray/${date}_xray.gif";
		}
	}
	elseif ($type == "lascoc3")
	{
		if ($date != $curr_date)
		{
			$url = "./common_files/placeholder_630x485.png";
			if (@fopen("http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_d3.mpg", "r")){$url = "http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_d3.mpg";}
			if (@fopen("http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_c3.mpg", "r")){$url = "http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_c3.mpg";}
		}
		else
		{
			$url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_c3.mpg";
//			$url = "http://www.sec.noaa.gov/ftpdir/plots/xray/${date}_xray.gif";
		}
	}
	elseif ($type == "strb")
	{
		if ($date != $curr_date)
			$url = "http://stereo-ssc.nascom.nasa.gov/browse/${year}/${month}/${day}/behind_${year}${month}${day}_euvi_195_512.mpg";
		else
            $url = "http://stereo-ssc.nascom.nasa.gov/browse/${year}/${month}/${day}/behind_${year}${month}${day}_euvi_195_512.mpg";
	}
	elseif ($type == "stra")
	{
		if ($date != $curr_date)
			$url = "http://stereo-ssc.nascom.nasa.gov/browse/${year}/${month}/${day}/ahead_${year}${month}${day}_euvi_195_512.mpg";
		else
            $url = "http://stereo-ssc.nascom.nasa.gov/browse/${year}/${month}/${day}/ahead_${year}${month}${day}_euvi_195_512.mpg";
	}
	elseif ($type == "eit171")
	{
		if ($date != $curr_date)
			$url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_eit_171.mpg";
		else
//                        $url = "http://www.sec.noaa.gov/ftpdir/plots/electron/${date}_electron.gif";
            $url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_eit_171.mpg";
	}
	elseif ($type == "eit304")
	{
		if ($date != $curr_date)
			$url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_eit_304.mpg";
		else
//                        $url = "http://www.sec.noaa.gov/ftpdir/plots/electron/${date}_electron.gif";
            $url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_eit_304.mpg";
	}
	elseif ($type == "eit284")
	{
		if ($date != $curr_date)
			$url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_eit_284.mpg";
		else
//                        $url = "http://www.sec.noaa.gov/ftpdir/plots/electron/${date}_electron.gif";
            $url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_eit_284.mpg";
	}
	elseif ($type == "mdimag")
	{
		if ($date != $curr_date)
			$url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_mdi_mag.mpg";
		else
//                        $url = "http://www.sec.noaa.gov/ftpdir/plots/electron/${date}_electron.gif";
            $url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_mdi_mag.mpg";
	}
	elseif ($type == "mdicon")
	{
		if ($date != $curr_date)
			$url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_mdi_igr.mpg";
		else
//                        $url = "http://www.sec.noaa.gov/ftpdir/plots/electron/${date}_electron.gif";
            $url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_mdi_igr.mpg";
	}
	elseif ($type == "eit195")
	{
		if ($date != $curr_date)
		{
			$url = "./common_files/placeholder_630x485.png";
			if (@fopen("http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_d2.mpg", "r")){$url = "http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_dit_195.mpg";}
			if (@fopen("http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_c2.mpg", "r")){$url = "http://lasco-www.nrl.navy.mil/daily_mpg/${year}_${month}/${yy}${month}${day}_eit_195.mpg";}
		}
		else
		{
//            $url = "http://www.sec.noaa.gov/ftpdir/plots/electron/${date}_electron.gif";
            $url = "http://sohowww.nascom.nasa.gov/data/LATEST/current_eit_195.mpg";
        }
	}	
	else
	{
		$xrtdir='http://solar-b.nao.ac.jp/QLmovies/xrt_mov/'.$year.'_'.$month.'/'.$day.'/';

//debug:
$testfile="http://solar-b.nao.ac.jp/QLmovies/xrt_mov/2008_11/01/xrt_tipo_pfiL200811010542-0542.mpg";
//echo "<br>".$xrtdir."<br>";
//echo is_dir($xrtdir)."<br>";
//echo file_exists($testfile)."<br>";
//

		if (file_exists($testfile)) {		
			$xrtlist = array();
	
			preg_match_all("/(a href\=\")([^\?\"]*)(\")/i", get_text($xrtdir), $xrtlist);
			
			$nfile = count($xrtlist);
			$movielist=array();
			$nchar=array();
	
			if ($nfile > 3)
			{
	
	//			$pattern = '/$\.mpg/';
	//			foreach ($xrtlist as &$ii) {
	//				preg_match_all($pattern, $xrtlist[$ii], $movie);			
	//				$movielist[$ii]=$movie;
	//				$nchar[$ii]=count_chars($string);
	//			}
		
	//			$movielist = array_reverse($movielist);
	
	//			$xrtfile=$movielist[0];
	
				$xrtlist = array_reverse($xrtlist);
				$xrtfile=$xrtlist[0];
	
				if ($date != $curr_date)
					$url = $xrtdir.$xrtfile;
				else
	//            $url = "http://solar-b.nao.ac.jp/QLmovies/xrt_mov/2008_11/01/xrt_tipo_pfiL200811010542-0542.mpg";
					$url = $xrtdir.$xrtfile;
			}
			else
			{
				$url = $testfile;
//				$url = "./common_files/placeholder_630x485.png";
			}
		}
		else
		{
		    $url = $testfile;
//			$url = "./common_files/placeholder_630x485.png";
		}
	}	
	
	if ($date > $curr_date)
		$url = "./common_files/placeholder_630x485.png";

function get_text($filename)
{
	$fp_load = fopen("$filename", "rb");
	
	if ( $fp_load )
	{
		while ( !feof($fp_load) )
		{
			$content .= fgets($fp_load, 8192);
		}
	
		fclose($fp_load);
		return $content;
	}
}

//print($url." ");
//print($date." ");
//print($curr_date);

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
					<embed src="<? print $url ?>" autostart="true" width="512" height="530" /></a>
				</td>
			</tr>
			<tr>
				<td background=common_files/brushed-metal.jpg align=center>
					<table width=100% border=0>
						<tr>
<!--						
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=mdimag">MDI Mag</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=mdicon">MDI Cont</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=eit304">EIT 304</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=eit171">EIT 171</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=eit195">EIT 195</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=eit284">EIT 284</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=lascoc2">LASCO C2</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=lascoc3">LASCO C3</a>
							</font></td>
							<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								<a href="./soho_pop.php?date=<? print $date ?>&type=xrt">XRT</a> 
							</font></td>	
-->
							<td background=common_files/brushed-metal.jpg valign=middle align=center><b><font color=white>
								MDI <br>
								<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=mdimag">Mag</a>&nbsp;/&nbsp;<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=mdicon">Cont</a>
							</font></b></td>
							<td background=common_files/brushed-metal.jpg valign=middle align=center><b><font color=white>
								EIT <br>
								<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=eit304">304</a>&nbsp;/&nbsp;<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=eit171">171</a>&nbsp;/&nbsp;<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=eit195">195</a>&nbsp;/&nbsp;<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=eit284">284</a>
							</font></b></td>
							<td background=common_files/brushed-metal.jpg valign=middle align=center><b><font color=white>
								LASCO <br>
								<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=lascoc2">C2</a>&nbsp;/&nbsp;<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=lascoc3">C3</a>
							</font></b></td>
							<td background=common_files/brushed-metal.jpg valign=middle align=center><b><font color=white>
								STEREO <br>
								<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=stra">Ahead</a>&nbsp;/&nbsp;<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=strb">Behind</a>
							</font></b></td>
							<!--<td bgcolor=gray valign=middle align=center><font size=+1 color=white>
								Hinode <br>
								<a class=mail href="./soho_pop.php?date=<? print $date ?>&type=xrt">XRT</a> 
							</font></td> -->
							
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
