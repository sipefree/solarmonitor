<?
	/*
	File:
		globals
	
	Purpose:
			Variables that are required by nearly all php files.  Includes the paths for code and data as well as code.
		Will also include start and end dates for missions.
	
	Author(s):
		Russ Hewett -- rhewett@vt.edu
	
	History:
		2004/07/12 (RH) -- written
		2004/09/08 (RH) -- updated - added path vars
		2006/11/17 (RH) -- updated - changed SXI to EIT 171 -- we really need to rewrite this whole system..
	*/


	//	Path related globals
	//	All of these paths must be within the server document root.  eg, "/" is the server root path, 
	//	not the system root path.  Trailing '/' must be included.
	
		//	PHP Code Path
		//	The path in which the PHP lies
		//	$php_code_path = "/";
		
		//	Data Path
		//	This is the folder that the data/ folder lies in.
		$arm_data_path = "/Library/WebServer/Documents/solarmonitor/";

	//$eit_bakeout = true;
		$fd_types = array("gong_maglc", "smdi_maglc", "smdi_igram", "bbso_halph", "seit_00304", "seit_00171", "seit_00195", "seit_00284", "hxrt_flter", "slis_chrom", "gong_farsd", "strb_00195", "stra_00195", "gong_igram", "swap_00174" );
		$fd_strs = array("GONG+<br>Magnetogram", "MDI<br>Magnetogram", "MDI<br>Continuum", "GHN<br>H-alpha", "EIT<br>304 &Aring;",
		 "EIT<br>171 &Aring;", "EIT<br>195 &Aring;", "EIT<br>284 &Aring;", "Hinode<br>XRT", "SWAP<br>174");
		$fd_strs2 = array("GONG+ Magnetogram", "MDI Magnetogram", "MDI Continuum", "GHN H-alpha", "EIT 304 &Aring;",
		 "EIT 171 &Aring;", "EIT 195 &Aring;", "EIT 284 &Aring;", "Hinode XRT", "SOLIS Chromaspheric Magnetogram", "GONG Farside Magnetogram", "STEREO B", "STEREO A", "GONG+ Continuum", "SWAP 174 &Aring;");
		$fd_strs3 = array("Mag", "Mag", "Cont", "H&alpha;", "304",
		 "171", "195", "284", "XRT", "Far","A","B","174");
		$fd_types2num = array_flip($fd_types);


		$index_types = array("smdi_maglc", "smdi_igram", "bbso_halph", "swap_00174", "seit_00195", "hxrt_flter");  //"gsxi_flter");
	//	$index_types = array("gong_maglc", "smdi_igram", "bbso_halph", "seit_00171", "seit_00195", "hxrt_flter");  //"gsxi_flter");
		$index_types_strs = array("smdi_maglc" => "MDI Mag", "smdi_igram" => "MDI Cont", "bbso_halph" => "GHN H&alpha;", "seit_00171" => "EIT 171&Aring", "seit_00195" => "EIT 195&Aring", "hxrt_flter" => "XRT", "swap_00174" => "SWAP 174&Aring"); //"gsxi_flter" => "SXI X-rays");
	//	$index_types_strs = array("gong_maglc" => "GONG Mag", "smdi_igram" => "MDI Cont", "bbso_halph" => "GHN H&alpha;", "seit_00171" => "EIT 171&Aring", "seit_00195" => "EIT 195&Aring", "hxrt_flter" => "XRT"); //"gsxi_flter" => "SXI X-rays");
	//  SWAPPED BACK TO MDI AS GONG MAGS WERE NOT BEING FOUND
		$index2_types = array("smdi_maglc", "slis_chrom", "gong_farsd", "strb_00195", "seit_00195", "stra_00195");
	//	$index2_types = array("gong_maglc", "slis_chrom", "gong_farsd", "strb_00195", "seit_00195", "stra_00195");
		$index2_types_strs = array("smdi_maglc" => "MDI Mag", "slis_chrom" => "SOLIS Mag", "gong_farsd" => "GONG Farside", "strb_00195" => "STEREO B", "seit_00195" => "EIT 195&Aring", "stra_00195" => "STEREO A");
	//	$index2_types_strs = array("gong_maglc" => "GONG Mag", "slis_chrom" => "SOLIS Mag", "gong_farsd" => "GONG Farside", "strb_00195" => "STEREO B", "seit_00195" => "EIT 195&Aring", "stra_00195" => "STEREO A");
		$bakeout_index_types = array("smdi_maglc", "smdi_igram", "bbso_halph", "swap_00174", "bake_00195", "hxrt_flter"); //"gsxi_flter");
	//	$bakeout_index_types = array("gong_maglc", "smdi_igram", "bbso_halph", "trce_m0171", "bake_00195", "hxrt_flter"); //"gsxi_flter");
	    $bakeout_index_types_strs = array("smdi_maglc" => "MDI Mag", "smdi_igram" => "MDI Cont", "bbso_halph" => "GHN H&alpha;", "trce_m0171" => "TRC 171&Aring", "bake_00195" => "CCD BAKEOUT", "hxrt_flter" => "XRT", "swap_00174" => "SWAP 174&Aring"); //"gsxi_flter" => "SXI X-rays");
	//  $bakeout_index_types_strs = array("gong_maglc" => "GONG Mag", "smdi_igram" => "MDI Cont", "bbso_halph" => "GHN H&alpha;", "trce_m0171" => "TRC 171&Aring", "bake_00195" => "CCD BAKEOUT", "hxrt_flter" => "XRT"); //"gsxi_flter" => "SXI X-rays");
	//	$bakeout_index2_types = array("smdi_maglc", "slis_chrom", "gong_farsd", "strb_00195", "trce_m0171", "stra_00195"); //"gsxi_flter");
		$bakeout_index2_types = array("gong_maglc", "slis_chrom", "gong_farsd", "strb_00195", "trce_m0171", "stra_00195"); //"gsxi_flter");
	//  $bakeout_index2_types_strs = array("smdi_maglc" => "MDI Mag", "slis_chrom" => "SOLIS Mag", "gong_farsd" => "GONG Farside", "strb_00195" => "STEREO B", "trce_m0171" => "TRC 171&Aring", "stra_00195" => "STEREO A"); //"gsxi_flter" => "SXI X-rays");	
	    $bakeout_index2_types_strs = array("gong_maglc" => "GONG Mag", "slis_chrom" => "SOLIS Mag", "gong_farsd" => "GONG Farside", "strb_00195" => "STEREO B", "trce_m0171" => "TRC 171&Aring", "stra_00195" => "STEREO A"); //"gsxi_flter" => "SXI X-rays");	

		$keyhole_index_types = array("smdi_maglc", "smdi_igram", "bbso_halph", "swap_00174", "keyh_00195", "hxrt_flter");
	//	$keyhole_index_types = array("smdi_maglc", "smdi_igram", "bbso_halph", "trce_m0171", "keyh_00195", "hxrt_flter"); //"gsxi_flter");
	    $keyhole_index_types_strs = array("smdi_maglc" => "MDI Mag", "smdi_igram" => "MDI Cont", "bbso_halph" => "GHN H&alpha;", "trce_m0171" => "TRC 171&Aring", "keyh_00195" => "SOHO KEYHOLE", "hxrt_flter" => "XRT", "swap_00174" => "SWAP 174&Aring"); //"gsxi_flter" => "SXI X-rays");
		$keyhole_index2_types = array("gong_maglc", "slis_chrom", "gong_farsd", "strb_00195", "trce_m0171", "stra_00195"); //"gsxi_flter");
	    $keyhole_index2_types_strs = array("gong_maglc" => "GONG Mag", "slis_chrom" => "SOLIS Mag", "gong_farsd" => "GONG Farside", "strb_00195" => "STEREO B", "trce_m0171" => "TRC 171&Aring", "stra_00195" => "STEREO A"); //"gsxi_flter" => "SXI X-rays");	


		$region_types = array("smdi_igram", "smdi_maglc", "bbso_halph", "seit_00304", "seit_00171", "seit_00195", "seit_00284", "hxrt_flter", "gong_maglc", "gong_bgrad");
		$region_strs1 = array("smdi_igram" => "MDI Continuum", "smdi_maglc" => "MDI Magnetogram", "bbso_halph" => "BBSO H-Alpha", "seit_00304" => "EIT 304&Aring", 
		"seit_00171" => "EIT 171&Aring", "trce_m0171" => "Trace 171&Aring", "seit_00195" => "EIT 195&Aring", "seit_00284" => "EIT 284&Aring", "hxrt_flter" => "Hinode XRT", "gong_maglc" => "GONG+ Magnetogram", "gong_bgrad" => "Magnetic Gradient", 
		"slis_chrom" => "SOLIS Chromaspheric Mag", "gong_farsd" => "GONG Farside", "strb_00195" => "STEREO B 195&Aring", "stra_00195" => "STEREO A 195&Aring", "gong_igram" => "GONG+ Continuum", "swap_00174" => "SWAP 174&Aring");
		$region_strs2 = array("smdi_igram" => "Cont", "smdi_maglc" => "Mag", "bbso_halph" => "H&alpha;", 
		"seit_00304" => "304&Aring", "seit_00171" => "171&Aring", "seit_00195" => "195&Aring", "seit_00284" => "284&Aring", 
		"hxrt_flter" => "XRT", "gong_maglc" => "Mag", "gong_bgrad" => "Magnetic<br>Gradient");

	
?>