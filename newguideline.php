<? include("header.php")?>
<div class="main_content">
<?
$id= $_GET["id"];

if ($id ==1 )
{
?>
<div class="success">New guideline added successfully.</div>
<?
}
?>
<form name="input" action="insertguideline.php" method="post">

<h2 id="title" >Usability Guideline</h2>
<input type="text" size="75"  name="guideline" required />
<h2 id="title" >Country</h2>

<select name = "country" required>
<?
$result = mysql_query("SELECT * FROM countries");

while($row = mysql_fetch_array($result))
{
$country_ID = $row['country_ID'];
$countryName = $row['countryName'];
?>
<option value="<? echo $country_ID; ?>"><? echo $countryName ?></option>
<?
}
?>
</select>

<h2 id="title" >Tags</h2>
<?
$result = mysql_query("SELECT * FROM tags");

while($row = mysql_fetch_array($result))
{
$tag_ID = $row['tag_ID'];
$tagtext = $row['tagtext'];
?>
<input type="checkbox" name="<? echo $tag_ID; ?>" id="<? echo $tag_ID; ?>" value="1" /><label for="<? echo $tag_ID; ?>"><? echo $tagtext; ?></label></br>
<?
}
?>



<script type="text/javascript">
function open_win()
{
window.open("addtag.php",'','width=275,height=30,resizable=0,menubar=0')
}
</script>

<input type="button" class="submitbutton2" value="Add Tag" onclick="open_win()" />

</br><input class="submitbutton2" type="submit" value="Submit" />

</form>
</div>