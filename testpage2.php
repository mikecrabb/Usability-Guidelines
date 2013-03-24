<? include("header.php")?>
</br></br>
<form action="" method="post" enctype="multipart/form-data" name="link">
<p>Website Address: <input name="web_address" type="text" value="" /><input name="Submit" type="Submit" /></p>
</form>


<?php
function passorfail($value)
{
	if ($value == 1)
	{
		return "pass";
	}
	if ($value == 2)
	{
		return "concern";
	}
	if ($value == 3)
	{
		return "fail";
	}
}

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
	
	?><table id="participanttable">
	<thead>
	<th width = 10%>Guideline ID</th>
	<th>Guideline Text</th>
	<th width = 10%>Value</th>
	<th width = 10%>Pass Value</th>
	<th width = 10%>Fail Value</th>
	</thead><?
			$totalPass = 0;
			$totalFail = 0;
	$result = mysql_query("SELECT * FROM guidelines_with_limits ORDER BY guideline_ID ASC");
	while($row = mysql_fetch_array($result))
	{
		//GET PASS VALUE
		$passValue = $row['yChar'] + ($row['xChar']*3);
		//GET FAIL VALUE
		$failValue = $row['yChar'] + ($row['xChar']*2);
	
		$result2 = mysql_query("SELECT * FROM testable_functions WHERE guideline_ID = '" . $row['guideline_ID'] . "'");
		while($row2 = mysql_fetch_array($result2))
		{
			$characteristicID = $row2['testable_function_ID'];
			$characteristicName = $row2['testableFunction'];
			$characteristicValue = get_website_data($web_address, $characteristicID);
			$guideline_ID = $row2['guideline_ID'];
			$result3 = mysql_query("SELECT * FROM guidelines WHERE guideline_ID =  '" . $guideline_ID . "'");
			while($row = mysql_fetch_array($result3))
			{
				$guidelineText = $row['guidelineText'];
			}
			flush();
			ob_flush();
			$passorfail = 2;
			$ascOrDec = 0;
			if ($passValue > $failValue)
			{
			$ascOrDec = 1;
			}
			
			if ($ascOrDec == 1)
			{
			if ($characteristicValue >= $passValue)
			{
			$passorfail = 1;
			$totalPass++;
			}
			if ($characteristicValue < $failValue)
			{
			$passorfail = 3;
			$totalFail++;
			}
			}
			
			if ($ascOrDec == 0)
			{
			if ($characteristicValue <= $passValue)
			{
			$passorfail = 1;
			$totalPass++;
			}
			if ($characteristicValue > $failValue)
			{
			$passorfail = 3;
			$totalFail++;
			}
			}
			
			
			
			
			?><tr><td><? echo $guideline_ID; ?></td>
			<td><? echo $guidelineText; ?></td>
			<td id = "<? echo passorfail($passorfail); ?>"><? echo $characteristicValue; ?></td>
			<td id = "<? echo passorfail($passorfail); ?>"><? echo $passValue ?></td>
			<td id = "<? echo passorfail($passorfail); ?>"><? echo $failValue; ?></td>
			<?
		}


}
	kill_dom();
	gc_collect_cycles();
}
$endtimer = time();
$totaltime = $endtimer - $starttimer;
?>
</table>
<p>Total Passes: <? echo $totalPass; ?></p>
<p>Total Fails: <? echo $totalFail; ?></p>