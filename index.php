<? include("header.php")?>

<?

$result = mysql_query("SELECT * FROM tags");

while($row = mysql_fetch_array($result))
{
$tag_ID= $row['tag_ID'];
$tagtext= $row['tagtext'];

$result2 = mysql_query("SELECT * FROM things_to_test where tag_ID = '". $tag_ID . "'");
$num_rows = 0;
$num_rows = mysql_num_rows($result2);
$total_rows = $total_rows + $num_rows;
echo "<strong>" . $num_rows . "</strong> testable for " .  $tagtext . "</br>";
}
echo "<strong>" . $total_rows . "</strong> functions in total";