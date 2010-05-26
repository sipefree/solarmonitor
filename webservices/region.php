<?
	include ("include.php");
	
	$indexnum = "1";
	
	if (isset($_GET['region']))
		$region = $_GET['region'];
	else
		header("Location: ./index.php?date=$date");
	
	$file = "${arm_data_path}data/" . $date . "/meta/arm_ar_titles_" . $date . ".txt";
	if (file_exists($file))
	{
		$lines=file($file);
		$title = "No Region $region Found";
		foreach($lines as $line)
		{
			list($number, $temp_title) = split('[ ]', $line, 2);
			if ($number == $region)
			{
				$title = $temp_title;
				break;
			}
		}	
	}
	else
	{
		$title = "No Title Found";
	}
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<body>
		<center>
			<table background=common_files/brushed-metal.jpg width=830 cellpadding=0 cellspacing=0>
				<tr>
					<td background=common_files/brushed-top-big.jpg align=center colspan=3>
						<? write_title($date, $title, $this_page, NULL, $indexnum, 780, $region); ?>
					</td>
				</tr>
				<tr>
					<td valign=top align=center>
						<? write_left($date, $region); ?>
					</td>
					<td bgcolor=white valign=top align=center>
						<? write_region_body($date, $region); ?>
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