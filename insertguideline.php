<?php

include ("db_connect.php");

$guideline= $_POST["guideline"];
$country= $_POST["country"];

mysql_query("INSERT INTO guidelines (guidelineText) VALUES ('" . $guideline . "')");

	$result = mysql_query("SELECT * FROM guidelines WHERE guidelineText = '". $guideline . "'");
	while($row = mysql_fetch_array($result))
  {
	$guideline_ID= $row['guideline_ID'];
  }

mysql_query("INSERT INTO country_guidelines ( guideline_ID, country_ID) VALUES ('" . $guideline_ID . "', '" . $country . "')") ;



$result = mysql_query("SELECT * FROM tags");
while($row = mysql_fetch_array($result))
{
$tag_ID = $row['tag_ID'];

if ($_POST["{$tag_ID}"] == 1)
{
mysql_query("INSERT INTO guideline_tags ( tag_ID, guideline_ID) VALUES ('" . $tag_ID . "', '" . $guideline_ID . "')") ;
}

}

$URL="newguideline.php?id=1";

header ("Location: $URL");
?>
