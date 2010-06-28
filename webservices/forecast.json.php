<?php
include ("./include.php");

print("{");

$file = "${arm_data_path}data/$date/meta/arm_mmmotd_${date}.txt";
if(file_exists($file))
{
	//print("<pre>\n");
	print("\n");
	$lines = file_get_contents($file);
	print("\"mmmotd\": \"" . str_replace("\n", "\\n", addslashes(strip_tags(html_entity_decode($lines)))) . "\"");										
}
else
{
	$date_str = date("D F d, Y",strtotime($date));
	print("\"mmmotd\": \"No Message of the Day for $date_str\"");
}
print("}");
?>