<?
	include ("./include.php");
		
	$title = "Search ARM Archive";	
	$indexnum = "1";
	
	$error = 0;
	
	//	this checks the condition of the submission button.  if the button was clicked, search will
	//	be set.  both if statements are required to prevent crash.  if the button was clicked, assemble
	//	a date in the yyyymmdd format.  the header function redirects to the index page for that date.
	if(isset($_POST['search']))
	{
		if($_POST['search'] == "Search")
		{
			$region = $_POST['region_number'];
			$yyyymmdd_date = $_POST['yyyymmdd_date'];
			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$yyyymmdd = $year . $month . $day;
			
			if ($region != "")
			{
				$date_use = fast_find_region($region);//find_region($region);
			
				if ($date_use == "00000000")
				{
					$error = 1;
					$error_msg = "Region $region Not Found";
				}
				else
				{
					$yyyymmdd = date("Ymd",strtotime($date_use));
					header("Location: ./region.php?date=$yyyymmdd&region=$region");	
				}
			}
			elseif ($yyyymmdd_date != "")
			{
				if ($yyyymmdd_date > $current_date)
				{
					$error = 1;
					$error_msg = "Date requested ($yyyymmdd_date) is beyond <br>present date ($current_date)";
				}
				else
				{
					//	this line is critical.  without it, the system would look for days like 2004/02/31 if they
					//	were requested.  the strtotime function would, for instance, in a non leap year, correct that
					//	date to 2004/03/03 and prevent major confusion
					$yyyymmdd = date("Ymd",strtotime($yyyymmdd_date));
					header("Location: ./index.php?date=$yyyymmdd");	
				}
			}
			else
			{
				if ($yyyymmdd > $current_date)
				{
					$error = 1;
					$error_msg = "Date requested ($yyyymmdd) is beyond <br>present date ($current_date)";
				}
				else
				{
					//	this line is critical.  without it, the system would look for days like 2004/02/31 if they
					//	were requested.  the strtotime function would, for instance, in a non leap year, correct that
					//	date to 2004/03/03 and prevent major confusion
					$yyyymmdd = date("Ymd",strtotime($yyyymmdd));
					header("Location: ./index.php?date=$yyyymmdd");	
				}
			}
		}
	}
		
	//	get the year, month, and day to set the default select box values
	$year = substr($date, 0,4); 
	$month = substr($date, 4,2); 
	$day = substr($date, 6,2); 
	
	$num2fmon = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
	$strnum = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
?>

<html>
	<? write_header($date, $title, $this_page); ?>
	<body>
		<center>
		<table background=common_files/brushed-metal.jpg width=815 cellpadding=0 cellspacing=0 border=0>
			<tr>
				<td background=common_files/brushed-metal.jpg align=center colspan=3><font size=+1 color=white>
					<? write_title($date, $title, $this_page, $indexnum); ?>	
				</font></td>
			</tr>
			<tr>
				<td valign=top align=center>
					<? write_left($date, -1); ?>
				</td>
				<td bgcolor=#FFFFFF valign=top align=center>
					<table>
						<tr>
							<td align=left valign=top>
								The ARM archive, which contains data from 26-Jun-2001, can be searched using the 
								pull-down menu given below. If data exists for the date requested, you will be 
								automatically transferred. Please report problems to 
								<a class=mail2 href="mailto:info@solarmonitor.org">info@solarmonitor.org</a>.<br>
							</td>
						</tr>
					</table>
       
					<form method="post" action="./search.php?date=<? print $date ?>">
						<table width=400 border=0>
							<tr>
								<td colspan=100>
									Select a Date ...	
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="white">
									<select name="year">
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
									<select name="month">
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
									<select name="day">
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
									<input type="submit" value="Search" name="search">
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
