<?php
//set_include_path("/Users/solmon/Sites/");
include("globals.php");
include("include.php");
$eit_bakeout = in_bakeout($date);
$eit_keyhole = in_keyhole($date);

//header('Cache-Control: no-cache, must-revalidate');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/json');

$index_types = array_merge($index_types, $index2_types);
$index_types_strs = array_merge($index_types_strs, $index2_types_strs);
if ($eit_keyhole == "1")
{
	$keyhole_index_types = array_merge($keyhole_index_types + $keyhole_index2_types);
	$index_types = $keyhole_index_types;
	$keyhole_index_types_strs = array_merge($keyhole_index_types_strs, $keyhole_index2_types_strs);
	$index_types_strs = $keyhole_index_types_strs;
}
if ($eit_bakeout)
{
	$bakeout_index_types = array_merge($bakeout_index_types, $bakeout_index2_types);
	$index_types = $bakeout_index_types;
	$index_types_strs = $bakeout_index_types_strs +  + $bakeout_index2_types_strs;
}

$arm_data_path = "./";

$links=array();
$fullRes = array();
for($i=0;$i<count($index_types);$i++)
{
	list($instrument, $filter) = split('[_]', $index_types[$i],2);
	$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
	
	if($index_types[$i] == 'bake_00195')
	{
		$links[] = "http://www.solarmonitor.org/common_files/NoData/thumb/bakeout.thumb.png";
		$fullRes[] = "http://www.solarmonitor.org/common_files/NoData/thumb/bakeout.thumb.png";
	}
	elseif($index_types[$i] == 'keyh_00195')
	{
		$links[] = "http://www.solarmonitor.org/common_files/NoData/thumb/keyhole.thumb.png";
		$fullRes[] = "http://www.solarmonitor.org/common_files/NoData/thumb/bakeout.thumb.png";
	}
	else
	{
		$links[] = "http://www.solarmonitor.org/${arm_data_path}data/$date/pngs/thmb/$index_types[$i]_thumb.png";
		$fullRes[] = "http://solarmonitor.org/data/$date/pngs/$instrument/" . $file;
	}

	if($file == "No File Found")
	{
		if($index_types[$i] == 'bake_00195')
		{
			$times[]="EIT CCD BAKEOUT";
		}
		elseif($index_types[$i] == 'smdi_maglc')
		{
			$gongfile="${arm_data_path}data/$date/pngs/thmb/gong_maglc_thumb.png";
			if (@fopen($gongfile, "r"))
			{
				$links[$i] = link_image($gongfile, 220, false);
				$index_types[$i] = 'gong_maglc';
				list($instrument, $filter) = split('[_]', $index_types[$i],2);
				$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
				if($file !== "No File Found"){
					$times[]="GONG Mag ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
				} 
				else { 
					$times[]="GONG Mag ".$date." ";
				}
			}
			else {
				$times[]="No Time Data Available";
			}
		}	
		elseif($index_types[$i] == 'smdi_igram')
		{
			$gongintfile="${arm_data_path}data/$date/pngs/thmb/gong_igram_thumb.png";
			if (@fopen($gongintfile, "r"))
			{
				$links[$i] = link_image($gongintfile, 220, false);
				$index_types[$i] = 'gong_igram';
				list($instrument, $filter) = split('[_]', $index_types[$i],2);
				$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
				if($file !== "No File Found"){
					$times[]="GONG Cont ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
				}
				else { 
					$times[]="GONG Cont ".$date." ";
				}

			}
			else {
				$times[]="No Time Data Available";
			}
		}
		elseif($index_types[$i] == 'swap_00171') {
			if ($eit_bakeout) {
				$trace171file="${arm_data_path}data/$date/pngs/thmb/trce_m0171_thumb.png";
				if (@fopen($trace171file, "r")) {
					$links[$i] = link_image($trace171file, 220, false);
					$index_types[$i] = 'trce_m0171';
					list($instrument, $filter) = split('[_]', $index_types[$i],2);
					$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
					if($file !== "No File Found") {
						$times[]="TRACE 171&Aring; ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
					}
					else { 
						$times[]="TRACE 171&Aring; ".$date." ";
					}
				}
				else {
					$times[]="No Time Data Available";
				}
			}
			else {
				$eit171file="${arm_data_path}data/$date/pngs/thmb/seit_00171_thumb.png";
				if (@fopen($eit171file, "r")) {
					$links[$i] = link_image($eit171file, 220, false);
					$index_types[$i] = 'seit_00171';
					list($instrument, $filter) = split('[_]', $index_types[$i],2);
					$file = find_latest_file($date, $instrument, $filter, 'png', 'fd');
					if($file !== "No File Found") {
						$times[]="EIT 171&Aring; ".$date." ".substr($file,23,2) . ":" . substr($file,25,2);
					}
					else { 
						$times[]="EIT 171&Aring; ".$date." ";
					}
				}
				else {
					$times[]="No Time Data Available";
				}
			}
		}
		else {
			$times[]="No Time Data Available";
		}
	}
	else {
		list($inst, $filt, $fd, $fdate, $time, $ext) = split('[_.]',$file,6);
		$str = $index_types_strs[$index_types[$i]];
		$dt = $fdate . " " . substr($time,0,2) . ":" . substr($time,2,2);
		//$str = $str . " " . date("d-M-Y H:i", strtotime($dt)) . " UT";
		$str = $str . " " . $fdate . " " . date("H:i", strtotime($dt));
		$times[]=$str;
	}
}

$index_types = array_slice($index_types, 0, 1);

print("{ thumbnails: [ ");
for ($i=0;$i<count($index_types);$i++)
{
	print("{ ");
	print("time: \"" . html_entity_decode(str_replace("\n", "", $times[$i])) . "\", ");

	print("type: \"" . $index_types[$i] . "\", ");
	print("image: \"" . $links[$i] . "\", ");
	print("fullRes: \"" . $fullRes[$i] . "\" ");
	print("}");
	if($i != count($index_types)-1) print(",");
}
print("]}")

?>