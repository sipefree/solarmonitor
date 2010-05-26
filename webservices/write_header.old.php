<?
	/*
	Function:
		write_header
	
	Purpose:
			Displays header information.
	
	Parameters:		
		Input:
			date -- the date for display
			title -- the title info to be displayed
			this_page -- for write_jscript
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/13 (RH) -- written
	*/
	
	function write_header($date, $title, $this_page)
	{
		print("<head>\n");
                print(" <link rel=\"icon\" href=\".common_files/favicon.ico\" type=\"image/x-icon\">\n");
		print("	<link rel=\"shortcut icon\" href=\"./common_files/favicon.ico\" type=\"image/x-icon\">\n");
		print("	<meta http-equiv=\"Pragma\" content=\"no-cache\">\n");
		print("	<meta http-equiv=\"refresh\" content=\"900\">\n");
		print("	<title>$title</title>\n");
		print("	<link rel=stylesheet href=\"./common_files/arm-style.css\" type=\"text/css\">\n");
		print("	<meta name=\"orgcode\" content=\"682\">\n");
		print("	<meta name=\"rno\" content=\"Joseph.B.Gurman.1\">\n");
		print("	<meta name=\"content-owner\" content=\"Peter.T.Gallagher.1\">\n");
		print("	<meta name=\"webmaster\" content=\"Amy.E.Skowronek.1\">\n");
		print("	<script language=JavaScript1.2>\n");
			write_jscript($date, $this_page);
		print("	</script>\n");
		print("</head>\n");
	}
?>
