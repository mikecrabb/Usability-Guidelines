<!DOCTYPE html><!-- HTML 5 -->
<? include ("db_connect.php");?>
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	
		<link rel="stylesheet" href="sitestyle.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>

</head>

<header class="mainheader">
<h1>Usability Index</h1>
<h2>Governmental Guidelines</h2>
<ul id="nav">
<li><a href="index.php">Home</a></li>
<li><a href="newguideline.php">Insert Usability Information</a></li>
<li><a href="showguidelines.php">Show Guidelines</a></li>
<li><a href="testpage.php">Test Web Page</a></li>
<li><a href="newtestpage.php">.alpha tests</a></li>
</ul>
</header>



</br></br>
<form action="" method="post" enctype="multipart/form-data" name="link">
<p>Website Address: <input name="web_address" type="text" value="" /><input name="Submit" type="Submit" /></p>
</form>


<?php
error_reporting(E_ERROR | E_PARSE);
if (isset($_POST['Submit']))
{
	include ("functions/parser.php");
	include ("db_connect.php");

	$web_address=$_POST["web_address"];
	echo "<p>Currently testing: <strong>" . $web_address . "</strong></p>";
	kill_dom();
	?>
	
	<!-- Start Of Tabs -->
	<div id="tabs">
  <ul id="nav">
    <li><a href="#tabs-1">Older Adult</a></li>
    <li><a href="#tabs-2">Younger Adult</a></li>
    <li><a href="#tabs-3">High Internet Confidence</a></li>
    <li><a href="#tabs-4">Older Adult (legacy)</a></li>
    
  </ul>
  <div id="tabs-1">
  <?
  
  $olderadultarray = getArrayValues($web_address, 'Older Adult')
	?>
	<table id="participanttable">
	<!--<thead>
	<th>GuidelineID</th>
	<th>GuidelineText</th>
	<th>Charted Example</th>
	</thead> -->
	<?
	foreach ($olderadultarray as $a)
	{
	?>
	<tr>
	<td><? echo $a['guideline_ID']; ?></td>
	<td><? echo $a['guideline_text']; ?></td>
	<td><? echo $a['SVGChart']; ?></td>
	<td><? echo $a['passtype']; ?></td>
	</tr>
	<?
	}
			flush();
		ob_flush();
	?>
	</table>
  
  
  
  </div>
  <div id="tabs-2">
  
    <? $youngeradultarray = getArrayValues($web_address, 'Younger Adult')
	?>
	<table id="participanttable">
	<!--<thead>
	<th>GuidelineID</th>
	<th>GuidelineText</th>
	<th>Charted Example</th>
	</thead> -->
	<?
	foreach ($youngeradultarray as $a)
	{
	?>
	<tr>
	<td><? echo $a['guideline_ID']; ?></td>
	<td><? echo $a['guideline_text']; ?></td>
	<td><? echo $a['SVGChart']; ?></td>
	<td><? echo $a['passtype']; ?></td>
	</tr>
	<?
	}
			flush();
		ob_flush();
	?>
  </table>
  </div>

  <div id="tabs-3">
    <? $highICarray = getArrayValues($web_address, 'High Internet Confidence')
	?>
	<table id="participanttable">
	<!--<thead>
	<th>GuidelineID</th>
	<th>GuidelineText</th>
	<th>Charted Example</th>
	</thead> -->
	<?
	foreach ($highICarray as $a)
	{
	?>
	<tr>
	<td><? echo $a['guideline_ID']; ?></td>
	<td><? echo $a['guideline_text']; ?></td>
	<td><? echo $a['SVGChart']; ?></td>
	<td><? echo $a['passtype']; ?></td>
	</tr>
	<?
	}
			flush();
		ob_flush();
	?>
  </table>
  </div>
  
  <div id="tabs-4">
  <?
  
  $olderadultarray = getArrayValues($web_address, 'Older Adult')
	?>
	<table id="participanttable">
	<thead>
	<th>GuidelineID</th>
	<th>GuidelineText</th>
	<th>characteristicValue</th>
	<th>passValue</th>
	<th>failValue</th>
	<th>passorFail</th>
	</thead>
	<?
	foreach ($olderadultarray as $a)
	{
	?>
	<tr>
	<td><? echo $a['guideline_ID']; ?></td>
	<td><? echo $a['guideline_text']; ?></td>
	<td><? echo $a['characteristicValue']; ?></td>
	<td><? echo $a['passValue']; ?></td>
	<td><? echo $a['failValue']; ?></td>
	<td id=<? echo passorfail($a['passOrFail']) ?>><? echo passorfail($a['passOrFail']); ?></td>
	</tr>
	<?
	}
			flush();
		ob_flush();
	?>
	</table>
  
  
  
  </div>


</div>
<!-- End Of Tabs -->
	
	
	
	<?
	}	
	
	

?>
 
 
 
</body>
</html>