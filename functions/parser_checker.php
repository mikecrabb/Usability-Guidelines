<form action="" method="post" enctype="multipart/form-data" name="link">
Website Address<input name="web_address" type="text" value="" /></br>
Timeout<input name="timeout" type="text" value="" /></br>
<input name="Submit" type="Submit" />
</form>


<?php
$counter = 1;
error_reporting(E_ERROR | E_PARSE);
//ini_set('display_errors', '0');
gc_enable();

if (isset($_POST['Submit']))
{

	include ("parser.php");
	include ("../db_connect.php");
	include ("memory_calculations.php");

	$timeout=$_POST["timeout"];
	$web_address=$_POST["web_address"];
	echo "Currently testing: <strong>" . $web_address . "</strong></br>";
	$result = mysql_query("SELECT * FROM testable_functions");
	while($row = mysql_fetch_array($result))
	{
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
		echo "<i>" .$guidelineText . "</i></br>";
		echo $characteristicName . " = " . $characteristicValue . "</br></br>";
		$counter++;
	}
	$rowsdone++;
	//echo "<h4>" .$rowsdone. "/" . $numberofrows . " - Memory at ".get_memory()."%</h4>";
	kill_dom();
	gc_collect_cycles();
}

?>
