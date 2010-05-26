<?
	/*
	Function:
		write_right
	
	Purpose:
			Displays right navigation links.
	
	Parameters:		
		Input:
			date -- the date in YYYYMMDD format for which to display from
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewettvt.edu
	
	History:
		2004/07/13 (RH) -- written
		2008/11/04 (P.Higgins) -- added soho movies, removed "bbso report" and "solarmonitor" heading
	*/
	
	function write_right($date)
	{
		print("<table width=50 height=680 border=0>\n");
		print("	<tr>\n");
		print("		<td align=center valign=top>\n");
//		print("                       <br><font color=white><b>Solar<br>Monitor</b></font><br>\n");
        print("			<br><b><a class=mail4 href=\"./index.php\">Home</a></b><br>\n");
		print("			<a class=mail href=\"./forecast.php?date=$date\">Forecast</a><br>\n");
		print("			<a class=mail href=\"./search.php?date=$date\">Search</a><br>\n");
		print("         <a class=mail href=\"./news.php\">News</a><br>\n");
		print("         <a class=mail href=\"./credits.php\">Credits</a><br><br>\n");
		print("			<font color=white><b>GOES</b></font><br>\n");
		print("			<a class=mail href=JavaScript:OpenGoes(\"./goes_pop.php?date=$date&type=xray\")>X-rays</a><br>\n");
		print("			<a class=mail href=JavaScript:OpenGoes(\"./goes_pop.php?date=$date&type=proton\")>Protons</a><br>\n");
		print("			<a class=mail href=JavaScript:OpenGoes(\"./goes_pop.php?date=$date&type=electron\")>Electrons</a><br><br>\n");
		print("			<font color=white><b>ACE</b></font><br>\n");
		print("			<a class=mail href=JavaScript:OpenAce(\"./ace_pop.php?date=$date&type=aceplasma\")>Plasma</a><br>\n");
		print("			<a class=mail href=JavaScript:OpenAce(\"./ace_pop.php?date=$date&type=acemag\")>B Field</a><br><br>\n");
//		print("			<font color=white><b>SOHO</b></font><br>\n");
//		print("			<a class=mail href=JavaScript:OpenSoho(\"./soho_pop.php?date=$date&type=eit195\")>Movies</a><br><br>\n");
/*		print("			<font color=white><b>RHESSI</b></font><br>\n");
		print("			<a href=JavaScript:OpenGoes(\"./goes_pop.php?date=$date&type=rhessi\")>Times</a><br><br>\n");
*/
		print("			<font color=white><b>Events</b></font><br>\n");
		print("			<a class=mail href=JavaScript:OpenLastEvents(\"http://www.lmsal.com/solarsoft/last_events/\")>SolarSoft</a><br>\n");
		print("			<a class=mail href=JavaScript:OpenEvents()>SWPC</a><br><br>\n");
		print("			<font color=white><b>MM</b></font><br>\n");
		print("			<a class=mail href=JavaScript:OpenMotD(\"./motd_pop.php?date=$date\")>MotD</a><br><br>\n");
//		print("			<br><font color=white><b>BBSO</b></font><br>\n");
//		print("			<a href=JavaScript:TermWindow()>Activity<br>Report</a><br>\n");
		print("			<font color=white><b>IDL</b></font><br>\n");
		print("         <a class=mail target=_blank href=\"./objects/solmon/\">SOLMON Object</a><br><br>\n");
		print("		</td>\n");
		print("	</tr>\n");
		print("</table>\n");
		/*print("		</td>\n");
		print("	</tr>\n");
		print("	<tr>\n");
		print("		<td align=center valign=top>\n");*/		
		
		/*print("	<tr>\n");
		print("		<td align=center valign=top>\n");
		print("			<a href=\"./search.php?date=$date\">Search Archive</a><br><br><hr>\n");
		print("			<a href=JavaScript:TermWindow()>BBSO<br>Activity<br>Report<br><br></a>\n");
		print("		</td>\n");
		print("	</tr>\n");*/
		//print("			<font color=white><b>GOES</b></font><br>\n");
	}
	
?>
