<?
	include ("./include.php");
	
	$title = "SEC Events";
?>
<html>
	<head>
		<meta http-equiv="Pragma" content="no-cache">
		<title><? print($title); ?></title>
		<link rel=stylesheet href="./common_files/arm-style.css" type="text/css">
	</head>
	<body>
		<table width="670" height="575" align=center valign=middle border=0>
			<tr>
				<td bgcolor=gray align=center>
					<? write_title($date, $title, $this_page, NULL, $width="100%"); ?>
				</td>
			</tr>
			<tr>
				<td align=left valign=top height=100%>
					<br>
					<?
						$yyyy = substr($date,0,4);
						//@readfile("http://www.solarmonitor.org/data/${date}/meta/noaa_events_raw_${date}.txt");
						@readfile("http://www.sec.noaa.gov/ftpdir/indices/${yyyy}_events/${date}events.txt");
						//$lines = file_get_contents("http://www.sec.noaa.gov/ftpdir/indices/${yyyy}_events/${date}events.txt");
						//print_r($lines);
						//foreach($lines as $line)
						//{
						//	print("$line<br>\n");
						//}
					?>
				</td>
			</tr>
		</table>
	</body>
</html>
