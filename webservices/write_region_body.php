<?
	function write_region_body($date, $region)
	{
		include("globals.php");
		
		$links=array();
		for($i=0;$i<count($region_types);$i++)
		{
			$type = $region_types[$i];
			$instrument = substr($type,0,4);
			$filter = substr($type,5,5);
			$file = find_latest_file($date, $instrument, $filter, 'png', 'ar', $region); 
			$links[] = link_image("${arm_data_path}data/$date/pngs/$instrument/$file", 335, false);
		}
		
		print("<table>\n");
		
		$ncols = 2;
		
		for ($i=0;$i<count($region_types);$i++)
		{
			if ($i == 0)
				print("	<tr>\n");
			elseif (($i % $ncols) == 0)
				print("	<tr>\n	<tr>\n");
				
			print("		<td align=center valign=center>\n");
			print("			<a href=JavaScript:RegionZoom(\"./region_pop.php?date=$date&type=" . $region_types[$i] . "&region=$region\")>\n");
			print("				" . $links[$i] . "\n");
			print("			</a>\n");
			print("		</td>\n");
			
			if ($i == (count($region_types)-1))
				print("	</tr>\n");
		}

		print("</table>\n");
	}
?>