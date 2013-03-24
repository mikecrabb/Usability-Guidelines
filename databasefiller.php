<!DOCTYPE html><!-- HTML 5 -->
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="sitestyle.css" />
</head>

<header class="mainheader">
<h1>Usability Index</h1>
<h2>Governmental Guidelines</h2>
<ul id="nav">
<li><a href="index.php">Home</a></li>
<li><a href="newguideline.php">Insert Usability Information</a></li>
<li><a href="showguidelines.php">Show Guidelines</a></li>
<li><a href="testpage.php">Test Web Page</a></li>
</ul>
</header>
<?php
			flush();
		ob_flush();
$starttimer = time();
$counter = 0;
error_reporting(E_ERROR | E_PARSE);
//ini_set('display_errors', '0');
gc_enable();

	include ("functions/parser.php");
	include ("functions/memory_calculations.php");
$dbhost = 'localhost';
$dbusername = 'uoash';
$dbpassword = 'T4JxUSzwxXMTR5Qu';
$dbname = 'uoash';
$conn=mysql_connect($dbhost, $dbusername, $dbpassword);
if(!$conn) :
   die('Could not connect: ' . mysql_error());
endif;
$db=mysql_select_db($dbname, $conn);
if(!$db) :
   die ('Cant connect to database : ' . mysql_error());
endif;

$result123 = mysql_query("SELECT * FROM urls where tableid > 1547");
mysql_close($conn);
	include ("db_connect.php");
/*while($row123 = mysql_fetch_array($result123))
	{	
	echo "</br>";
	echo $row123["url"];
	$web_address=$row123["url"];
	}
*/

while($row123 = mysql_fetch_array($result123))
	{
	$web_address=$row123["url"];
	$url_ID=$row123["tableid"];
	echo "<p><strong>" . $web_address . "</strong> " . $url_ID . "</p>";
	
	$starttime = microtime(true);
	kill_dom();
	$endtime = microtime(true);
	$totstime = $endtime - $starttime;
	//echo "<p>killdom: " . $totstime . "  </br>";
	
	$starttime = microtime(true);
	strip_everything($web_address);
	$endtime = microtime(true);
		$totstime = $endtime - $starttime;
	//echo "strip everything: ". $totstime . "  </br>";
	
	$starttime = microtime(true);
	strip_everything_keep_tags($web_address);
	$endtime = microtime(true);
		$totstime = $endtime - $starttime;
	//echo "strip everything keep tags: ". $totstime . "</br>";
	
	$starttime = microtime(true);
	strip_everything_keep_tags_curl($web_address);
	$endtime = microtime(true);
		$totstime = $endtime - $starttime;
	//echo "strip everything keep tags curl: ". $totstime . "</p>";
	
	$result = mysql_query("SELECT * FROM testable_functions ORDER BY guideline_ID ASC");
	while($row = mysql_fetch_array($result))
	{
		$starttime = microtime(true);
		$characteristicID = $row['testable_function_ID'];
		$characteristicName = $row['testableFunction'];
		$characteristicValue = get_website_data($web_address, $characteristicID);
		$guideline_ID = $row['guideline_ID'];
		$result2 = mysql_query("SELECT * FROM guidelines WHERE guideline_ID =  '" . $guideline_ID . "'");
		while($row = mysql_fetch_array($result2))
		{
			$guidelineText = $row['guidelineText'];
		}
		flush();
		ob_flush();
		$endtime = microtime(true);
		echo $guideline_ID . "-" . get_memory()."% ";
		
		/*
		?><tr><td><? echo $guideline_ID; ?></td>
		<td><? echo $guidelineText; ?></td>
		<td><? echo $characteristicValue; ?></td>
		<td><? echo get_memory(); ?></td>
		<td><? echo round($endtime-$starttime, 3); ?></td>
		<? */
		//mysql_query("INSERT INTO page_characteristics ( characteristicID, characteristicValue, urlID) VALUES ('" . $guideline_ID . "', '" . $characteristicValue . "', '" . $url_ID . "')") ;
		$counter++;
	}
	$rowsdone++;
	kill_dom();
	gc_collect_cycles();
}
$endtimer = time();
$totaltime = $endtimer - $starttimer;
?>
</table>
<p><? echo $counter; ?>/130 Guidelines tested.</p>
<p><? echo $totaltime; ?> seconds taken.</p>
<?

?>