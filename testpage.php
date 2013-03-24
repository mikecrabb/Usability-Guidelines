<? include("header.php")?>
</br></br>
<form action="" method="post" enctype="multipart/form-data" name="link">
<p>Website Address: <input name="web_address" type="text" value="" /><input name="Submit" type="Submit" /></p>
</form>


<?php
$starttimer = time();
$counter = 0;
error_reporting(E_ERROR | E_PARSE);
//ini_set('display_errors', '0');
gc_enable();

if (isset($_POST['Submit']))
{
	include ("functions/parser.php");
	include ("db_connect.php");
	include ("functions/memory_calculations.php");

	$web_address=$_POST["web_address"];
	echo "<p>Currently testing: <strong>" . $web_address . "</strong></p>";
	
	$starttime = microtime(true);
	kill_dom();
	$endtime = microtime(true);
	$totstime = $endtime - $starttime;
	echo "<p>killdom: " . $totstime . "  </br>";
	
	
	$starttime = microtime(true);
	strip_everything($web_address);
	$endtime = microtime(true);
		$totstime = $endtime - $starttime;
	echo "strip everything: ". $totstime . "  </br>";
	
	$starttime = microtime(true);
	strip_everything_keep_tags($web_address);
	$endtime = microtime(true);
		$totstime = $endtime - $starttime;
	echo "strip everything keep tags: ". $totstime . "</br>";
	
	$starttime = microtime(true);
	strip_everything_keep_tags_curl($web_address);
	$endtime = microtime(true);
		$totstime = $endtime - $starttime;
	echo "strip everything keep tags curl: ". $totstime . "</p>";
	
	
	
	?><table id="participanttable">
	<thead>
	<th width = 10%>Guideline ID</th>
	<th>Guideline Text</th>
	<th width = 10%>Value</th>
	<th width = 10%>Server Memory</th>
	<th width = 10%>Server Time</th>
	</thead><?
	$result = mysql_query("SELECT * FROM testable_functions  ORDER BY guideline_ID ASC");
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
		?><tr><td><? echo $guideline_ID; ?></td>
		<td><? echo $guidelineText; ?></td>
		<td><? echo $characteristicValue; ?></td>
		<td><? echo get_memory(); ?></td>
		<td><? echo round($endtime-$starttime, 3); ?></td>
		<?

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