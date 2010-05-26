<?
	/*
	Function:
		write_googleanalytics
	
	Purpose:
			adds google analytics code to the site
	
	Parameters:		
		Input:
			none
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett2@uiuc.edu
	
	History:
		2006/05/62 (RH) -- written
	*/
	
	function write_googleanalytics()
	{
		print("<!-- Start of Google Analytics Code -->\n");
		print("<script src=\"http://www.google-analytics.com/urchin.js\" type=\"text/javascript\">\n");
		print("</script>\n"); 
		print("<script type=\"text/javascript\">\n"); 
		print("_uacct = \"UA-341043-2\";\n"); 
		print("urchinTracker();\n"); 
		print("</script>\n");
		print("<!-- End of Google Analytics Code -->\n");
	}
?>
