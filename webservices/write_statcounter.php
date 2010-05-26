<?
	/*
	Function:
		write_statcounter
	
	Purpose:
			adds statcounter.com code to the site
	
	Parameters:		
		Input:
			none
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2006/05/22 (RH) -- written
	*/
	
	function write_statcounter()
	{
		print("<!-- Start of StatCounter Code -->\n");
		print("<script type=\"text/javascript\" language=\"javascript\">\n");
		print("<!--\n"); 
		print("var sc_project=1583330;\n"); 
		print("var sc_invisible=1;\n"); 
		print("var sc_partition=14;\n"); 
		print("var sc_security=\"3bc361e8\";\n"); 
		print("//-->\n");
		print("</script>\n");

		print("<script type=\"text/javascript\" language=\"javascript\" src=\"http://www.statcounter.com/counter/counter.js\"></script><noscript><a href=\"http://www.statcounter.com/\" target=\"_blank\"><img  src=\"http://c15.statcounter.com/counter.php?sc_project=1583330&java=0&security=3bc361e8&invisible=1\" alt=\"free web tracker\" border=\"0\"></a> </noscript>\n");
		print("<!-- End of StatCounter Code -->\n");
	}
?>
