<?php
include("globals.php");
include("include.php");
include("image.class.php");

$json = array("imageSources" => array());

$types = SMImage::getAvailableImageTypes($date);
for ($i=0;$i<count($types);$i++)
{
	$obj = new SMImage($types[$i], $date);
	if($obj->requiresSubstitute()) {
		$obj = $obj->getSubstitute();
		if($obj == false)
			continue;
	}
	$file = $obj->getLatestFilename();
	$json["imageSources"][] = array(
		"time" => $obj->getTimestampForFilename($file),
		"type" => $obj->type,
		"name" => $obj->getName(),
		"image" => $obj->getThumbnail(),
		"fullRes" => $file
		
	);
}
print json_encode($json)

?>