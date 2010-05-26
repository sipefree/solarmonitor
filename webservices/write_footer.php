<?
	/*
	Function:
		write_footer
	
	Purpose:
			Displays footer information.
	
	Parameters:		
		Input:
			update_date -- the date of last update
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/13 (RH) -- written
	*/
	
	function write_footer($update_date)
	{
		print("<a href=\"http://www.tcd.ie/\"><img src=\"./common_files/tcd_crest.png\" align=right border=0 width=55></a>\n");
		print("<a href=\"http://www.esa.eu/\"><img src=\"./common_files/esa_logo_small_2.jpg\" align=right border=0 width=78></a>\n");
		print("<a href=\"http://www.nasa.gov/goddard\"><img src=\"./common_files/nasalogo.png\" align=right border=0></a>\n");
		print("<address><font size=\"-1\">\n");
		print("	<b>Web Curators:</b> Paul Higgins (TCD), Peter Gallagher (TCD), Shaun Bloomfield (TCD), James McAteer (TCD) <br>\n"); //- <a class=mail2 href=\"mailto:info@solarmonitor.org\">info@solarmonitor.org</a><br>\n");
		print("	<b>Contact:</b> <a class=mail2 href=\"mailto:info@solarmonitor.org\">info@solarmonitor.org</a><br><br>\n");
//		print("	<b>Responsible NASA official:</b> Joseph B. Gurman<br>\n");
//		print(" <a class=mail2 href=\"http://beauty.nascom.nasa.gov/nasa_warnings.html\">NASA security and privacy protection statement</a><br><br>\n");
		print("	These pages are automatically updated every 30 minutes.<br>\n");
		print("	Last updated: $update_date\n");
		print("</font></address>\n");
		
		print("<LINK REL=\"alternate\" TITLE=\"SolarMonitor.org RSS\" HREF=\"http://www.solarmonitor.org/rss.php\" TYPE=\"application/rss+xml\">");
		print("<LINK REL=\"alternate\" TITLE=\"SolarMonitor.org RSS Active Region Summary\" HREF=\"http://www.solarmonitor.org/rss2.php\" TYPE=\"application/rss+xml\">");
		write_statcounter();
		write_googleanalytics();
	}
?>
