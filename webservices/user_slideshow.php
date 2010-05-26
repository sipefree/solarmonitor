<?
	include ("./include.php");
		
	$title = "ARM User Slideshow";	
	
	$dir = "${arm_data_path}data/$date/pngs";
			
    print("		var speed = 10000\n");
    print("		var Pic = new Array()\n");
    
    $i=0;
	/*foreach($fd_types as $type)
	{
		$instrument = substr($type,0,4);
		$filter = substr($type,5,5);
		$file = find_latest_file($date, $instrument, $filter, 'png', 'fd'); 
		if(file_exists("${arm_data_path}data/$date/pngs/$instrument/$file"))
		{
			print("		Pic[$i] = '${arm_data_path}data/$date/pngs/$instrument/$file'\n");
			$i++;	
		}
	}
	
    print("		var t\n");
    print("		var j = 0\n");
    print("		var p = Pic.length\n");
    print("		var preLoad = new Array()\n");
    print("		for (i = 0; i < p; i++)\n");
    print("		{\n");
    print("			preLoad[i] = new Image()\n");
    print("			preLoad[i].src = Pic[i]\n");
    print("		}\n");
    print("		\n");
    print("		function runSlideShow()\n");
    print("		{\n");
    print("			document.images.SlideShow.src = preLoad[j].src\n");
    print("			j = j + 1\n");
    print("			if (j > (p-1)) j=0\n");
    print("			t = setTimeout('runSlideShow()', speed)\n");
    print("		}\n");
	print("	<script language=JavaScript1.2>\n");
	print("	</script>\n");
    */
	
?>

<html>
	<? write_header($date, $title, $this_page) ?>
	<script language=JavaScript1.2>
	</script>
	<body onload="runSlideShow()">
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
    				<td>
						<form method="post" action="./user_slideshow_disp.php?date=<? print $date ?>">
							<table width=400 border=0>
								<tr>
									<td colspan=100>
										Select a Date ...	
									</td>
								</tr>
								<tr>
									<td align="center" bgcolor="white">
										<select name="start_year">
											<?
												//	add as many years as desired to the list box
												//	set the current year (as in one currently being viewed)
												//	as the selected year
												for($i=1996;$i<=2010;$i++)
												{
													if($i == $year)
														print("		<option selected>$i\n");
													else
														print("		<option>$i\n");
												}
											?>
										</select> 
										<select name="start_month">
											<?
												//	add all 12 months to the list box
												//	set the current month (as in one currently being viewed)
												//	as the selected month
												for($i=1;$i<=12;$i++)
												{
													if($i == $month)
													{
														$temp = $strnum[$i-1];
														print("		<option value=\"$temp\" selected> $num2fmon[$temp]\n");
													}
													else
													{
														$temp = $strnum[$i-1];
														print("		<option value=\"$temp\" > $num2fmon[$temp]\n");
													}
												}
											?>
										</select>
										<select name="start_day">
											<?
												//	add all 31 days to the list box
												//	set the current day (as in one currently being viewed)
												//	as the selected day
												for($i=1;$i<=31;$i++)
												{
													$pad="";
													if ($i < 10) $pad="0";
													if($i == $day)
														print("		<option selected>$pad$i\n");
													else
														print("		<option>$pad$i\n");
												}
											?>
										</select>
									</td>    
								</tr>
								<tr>
									<td colspan=100>
										... or Enter a 5 Digit Region Number ...
									</td>
								</tr>
								<tr>
									<td align="center" colspan=3>
										<input type="text" value="" name="region_number" size=5 maxlength=5>									
									</td>  
								</tr>
								<tr>
									<td colspan=100>
										... or Enter a yyyymmdd Date ...
									</td>
								</tr>
								<tr>
									<td align="center" colspan=3>
										<input type="text" value="" name="yyyymmdd_date" size=8 maxlength=8>									
									</td>  
								</tr>
								<tr>  
									<td align="right" bgcolor="white" colspan=100>
										<input type="submit" value="Display" name="display">
									</td>  
								</tr>
								<tr>
									<td colspan=100 align=center>
								<? 
									//	error printing section. needs to be prettified
									if ($error)
										print "									<hr><font color=red>$error_msg</font>\n";	
									else
										print "									<hr>\n";	
								?>
									</td>
								</tr>
							</table>
						</form>
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