<? header('Content-Type: text/xml; charset=ISO-8859-1');//text/xml'); ?>


<?
		include("scrape_functions.php");
		
		$date = gmdate("Ymd");
	
		//	Contruct the file name
		$items = array();	
		$item = array();
		
		//Do Solar Activity Level
		$scrape_result = scrape_rss_activity_level($date);

		$item["title"] = $scrape_result["title"];
		$item["description"] = 	"Solar Activitly level is " . $scrape_result["level"] . ".&lt;br&gt;
								&lt;br&gt;2-day Flare Index (entire sun): " . $scrape_result["flare_index"] . "&lt;br&gt;
								X-Class Flares: " . $scrape_result["x_count"] . "&lt;br&gt;
								M-Class Flares: " . $scrape_result["m_count"] . "&lt;br&gt;
								C-Class Flares: " . $scrape_result["c_count"];
		$item["link"] = $scrape_result["link"];
		
		$items[] = $item;
	
		//Do Most Active Region
		$scrape_result = scrape_rss_most_active_region($date);

		if (count($scrape_result) > 0) 
		{
			$events_today = "";
			foreach($scrape_result["events_today"] as $flare)
			{
				$events_today .= "&lt;a href=\"" . $flare["url"] . "\" &gt; " . $flare["class"] . $flare["strength"] . " (" . $flare["time"] . ") &lt;/a&gt; ";
			}
			$events_yesterday = "";
			foreach($scrape_result["events_yesterday"] as $flare)
			{
				$events_yesterday .= "&lt;a href=\"" . $flare["url"] . "\" &gt; " . $flare["class"] . $flare["strength"] . " (" . $flare["time"] . ") &lt;/a&gt; ";
			}
	
			$item["title"] = $scrape_result["title"];
			$item["description"] = 	"The Most Active Region is NOAA " . $scrape_result["number"] . ".&lt;br&gt;
									&lt;br&gt;2-day Flare Index: " . $scrape_result["flare_index"] . "&lt;br&gt;
									X-Class Flares: " . $scrape_result["x_count"] . "&lt;br&gt;
									M-Class Flares: " . $scrape_result["m_count"] . "&lt;br&gt;
									C-Class Flares: " . $scrape_result["c_count"] . "&lt;br&gt;
									&lt;br&gt;&lt;u&gt;Region Statistics for Today&lt;/u&gt; &lt;br&gt;
									Mount Wilson Class: " . $scrape_result["hale_today"] . "&lt;br&gt;
									Area: " . $scrape_result["area_today"] . "&lt;br&gt;
									Nummber of Spots: " . $scrape_result["nspots_today"] . "&lt;br&gt;
									Flares: " . $events_today . "&lt;br&gt;
									&lt;br&gt;&lt;u&gt;Region Statistics for Yesterday&lt;/u&gt; &lt;br&gt;
									Mount Wilson Class: " . $scrape_result["hale_yesterday"] . "&lt;br&gt;
									Area: " . $scrape_result["area_yesterday"] . "&lt;br&gt;
									Nummber of Spots: " . $scrape_result["nspots_yesterday"] . "&lt;br&gt;
									Flares: " . $events_yesterday . "&lt;br&gt;
									";
			$item["link"] = $scrape_result["link"];
			
			$items[] = $item;
		}
	
	
?>

<rss version="2.0">
	<channel>
		<title>www.SolarMonitor.org</title>
		<description> Welcome to the SolarMonitor at NASA Goddard Space Flight Center's Solar Data Analysis Center (SDAC).  This feed contains the most recent SolarMonitor Active Region Summary. </description>
		<link>http://www.solarmonitor.org</link>
		<? foreach($items as $item)
		{
		?>
		<item>
			<title><?=$item["title"];?></title>
			<description><?=$item["description"];?></description>
			<link><?=$item["link"];?></link>
		</item>
		<?
		}
		?>
	</channel>
</rss>
