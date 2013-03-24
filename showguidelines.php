<? include("header.php")?>
<div class="main_content">
<?
$result = mysql_query("SELECT * FROM tags");
while($row = mysql_fetch_array($result))
{
$tagtext = $row['tagtext'];
$tag_ID = $row['tag_ID'];
?>
<li id="tag">
<ul id="tag"><a href = "showguidelines.php?id=<? echo $tag_ID; ?>"><? echo $tagtext; ?></a></ul>
<? } ?>
<ul id="tag"><a href = "showguidelines.php">RESET</a></ul>
</li>


<table id="participanttable">
<thead>
<th width = 10% ></th>
<th width = 40% >Guideline Text</th>
<th width = 15% >Country</th>
<th>Tags</th>
<th width = 3% >Testable</th>
</thead>

<? 
$x = 1;
$id = $_GET["id"];
if (isset($_GET["id"]))
{
	$result = mysql_query("SELECT * FROM mega_view where tag_ID= '". $id . "'");
	while($row = mysql_fetch_array($result))
  		{
		?>
		<tr>
		<td><? echo $x . " (" . $row['guideline_ID'] . ")"; $guideline_ID = $row['guideline_ID'];?></td>
  		<? $x++; ?>
  		<td><? echo $row['guidelineText']; ?></td>
  		<td><? echo $row['countryName']; ?></td>
  		<td><div id="tag"><? echo $row['tagtext']; ?></div></td>
  		<td>
 		<?
 		$testcheck = 0;
 		
 		$tester2 = mysql_query("SELECT * FROM untestable WHERE guideline_ID= '". $guideline_ID . "'");
 		while($row7 = mysql_fetch_array($tester2))
 		{
 		$testcheck = 2;
 		}
 		
 		$tester = mysql_query("SELECT * FROM testable_functions WHERE guideline_ID= '". $guideline_ID . "'");
 		while($row6 = mysql_fetch_array($tester))
		{
		?><img src = "images/tick.png"><?
		$testcheck = 1;
		}
		if ($testcheck==0)
		{
		?><img src = "images/notdone.png"><?
		}
		if ($testcheck==2)
		{
		?><img src = "images/cross.png"><?
		}
		?></td><?
		}
}
else
{
	?>
	<?

	$result = mysql_query("SELECT * FROM guidelines order by guideline_ID asc");
	while($row = mysql_fetch_array($result))
  	{
  		?>
  		<tr>
		<td><? echo $x . " (" . $row['guideline_ID'] . ")"; ?></td>
 		<? $x++; ?>
  		<td><? echo $row['guidelineText']; ?></td>
  		<td><?
    	$guideline_ID = $row['guideline_ID'];
  
  		$resultz = mysql_query("SELECT * FROM mega_view where guideline_ID= '". $guideline_ID . "'");
		while($rowz = mysql_fetch_array($resultz))
		{
  			echo $rowz['countryName'];
  			break;
  		}
 		?></td>
  		<td><?

  		$result2 = mysql_query("SELECT * FROM mega_view where guideline_ID= '". $guideline_ID . "'");
  
		while($row2 = mysql_fetch_array($result2))
		{
			?> <span id="tag"> <?
			echo $row2['tagtext'];
			?> </span> <?
		}
 		?>
 		<td>
 		<?
 		$testcheck = 0;
 		$tester2 = mysql_query("SELECT * FROM untestable WHERE guideline_ID= '". $guideline_ID . "'");
 		while($row7 = mysql_fetch_array($tester2))
 		{
 		$testcheck = 2;
 		}
 		
 		$tester = mysql_query("SELECT * FROM testable_functions WHERE guideline_ID= '". $guideline_ID . "'");
 		while($row6 = mysql_fetch_array($tester))
		{
		?><img src = "images/tick.png"><?
		$testcheck = 1;
		}
		if ($testcheck==0)
		{
		?><img src = "images/notdone.png"><?
		}
		if ($testcheck==2)
		{
		?><img src = "images/cross.png"><?
		}
		?></td><?
		 		?> </tr> <?
  	}
}
?>


</table>
</div>