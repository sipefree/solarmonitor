<?
	/*
	Function:
		write_jscript
	
	Purpose:
			writes the java script to the main php files.
	
	Parameters:		
		Input:
			date -- the date in YYYYMMDD format for which to display from
			this_page -- info on the current page displayed, for printing page specific scripts
		Output:
			none
	
	Author(s):
		Russ Hewett -- rhewettvt.edu
	
	History:
		2004/07/15 (RH) -- written
		2004/07/16 (RH) -- added slideshow
		2008/11/04 (P.Higgins) -- added OpenSoho
	*/
	function write_jscript($date, $this_page)
	{
		include("globals.php");
		
		//	get the yyyymm and year currently being displayed.  this is needed for the bbso activity report
		$yyyymm = date("Ym",strtotime($date));
		$yyyy = date("Y",strtotime($date));
		
		//	print the java script
		print("		function TermWindow()\n");
		print("		{\n");
		print("			open(\"http://www.bbso.njit.edu/Research/ActivityReport/brep${yyyymm}.html\",\"new_window\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=y,scrollbars=yes,width=500,height=600\");\n");
		print("		}\n");
		print("		function OpenGoes( url )\n");
		print("		{\n");
		print("			open( url,\"\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,scrollbars=yes,width=710,height=605\");\n");
		print("		}\n");
		print("		function OpenSoho( url )\n");
		print("		{\n");
		print("			open( url,\"\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,scrollbars=no,width=710,height=670\");\n");
		print("		}\n");
		print("		function OpenAce( url )\n");
		print("		{\n");
		print("			open( url,\"\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,scrollbars=no,width=710,height=670\");\n");
		print("		}\n");
		print("		function OpenMotD( url )\n");
		print("		{\n");
		print("			open( url,\"\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,scrollbars=yes,width=710,height=605\");\n");
		print("		}\n");
		/*print("		function OpenEvents(url)\n");
		print("		{\n");
		print("			open(url,\"new_window\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=y,scrollbars=yes\");\n");
		print("		}\n");*/
		print("		function OpenEvents()\n");
		print("		{\n");
		print("           open(\"${arm_data_path}/data/${date}/meta/noaa_events_raw_${date}.txt\",\"new_window\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=y,scrollbars=yes\");\n");
		//print("			open(\"http://www.sec.noaa.gov/ftpdir/indices/${yyyy}_events/${date}events.txt\",\"new_window\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=y,scrollbars=yes\");\n");
		print("		}\n");
		print("		function OpenLastEvents(url)\n");
		print("		{\n");
		print("			open(url,\"new_window\",\"toolbar=no,location=yes,directories=no,status=no,menubar=no,resizable=yes,scrollbars=yes,width=810,height=750,left=5,top=20\");\n");
		print("		}\n");	
		
		//	if it is the index page, write the scrolly thing.  this will read from a file at some point
		if ($this_page == "index.php")
		{
			print("		function scroll(n)\n");
			print("		{\n");
			print("			var spaces = \"                                                                                   \";\n");
			print("			var text = '... Max Millennium MOTD issued on 12-Jul-2004 14:01:11.000 UT ... MM#009 Default HESSI Target ...Dear RHESSI collaborators, The new region on the SE limb continues to produce numerous low- to  intermediate- level events, including an M1.7 on 12-July-2004 07:30 UT.  Further C-class events expected, with a good chance for another M-class  flare. The position of this region on 12-July-2004 14:00 UT is: S07E85, ( -934\", -120\") See <A HREF=http://beauty.nascom.nasa.gov/arm/latest/slideshow_fd.html http://beauty.nascom.nasa.gov/arm/latest/slideshow_fd.html  for images and http://solar.physics.montana.edu/max_millennium/ops/observing.shtml http://solar.physics.montana.edu/max_millennium/ops/observing.shtml  for a description of the current Max Millennium Observing Plan. ...';\n");
			print("			var scrolling_text = spaces + text;\n");
			print("			scrolling_text = scrolling_text.substring(n,scrolling_text.length);\n");
			print("			window.defaultStatus = scrolling_text;\n");
			print("			if(scrolling_text.length > 0) n ++;\n");
			print("			else n = 0\n");
			print("			s = n;\n");
			print("			n = setTimeout(\"scroll(s)\", 70);\n");
			print("		}\n");
		}
		
		//	if called from a full disk or regional display, write the code for the regional pop-ups
		if (($this_page == "full_disk.php")||($this_page == "region.php"))
		{
			print("		function RegionZoom( url )\n");
			print("		{\n");
			print("			open( url,\"new_window\",\"toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=y,scrollbars=yes,width=660,height=755\");\n");
			print("		}	\n");
		}        	
		
		if($this_page == "slideshow.php")
		{
			$dir = "${arm_data_path}data/$date/pngs";
			
		    print("		var speed = 10000\n");
		    print("		var Pic = new Array()\n");
		    
		    $i=0;
			foreach($fd_types as $type)
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
		}
	}
?>
