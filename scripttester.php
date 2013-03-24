<form action="" method="post" enctype="multipart/form-data" name="link">
Website Address<input name="web_address" type="text" value="" /></br>
<input name="Submit" type="Submit" />
</form>


<?php

$counter = 1;
//error_reporting(E_ERROR | E_PARSE);
//ini_set('display_errors', '0');
gc_enable();

if (isset($_POST['Submit']))
{	
	include ("functions/parser.php");
	include ("functions/memory_calculations.php");
	$link=$_POST["web_address"];
	echo "Currently testing: <strong>" . $link . "</strong></br>";
	echo get_all_css($link);
	global $csstextandtag;
	/*if (!isset($csstextandtag))
	{
		$csstextandtag = file_get_html($link);
		$sitetext = $csstextandtag;
		preg_match_all('[href="(.*?)"]', $sitetext, $links);
		foreach ($links[1] as &$value)
		{
			if(stristr($value, 'css'))
			{
				$text = file_get_html($value)->plaintext;
				$csstext .= $text;
			}
	
		}
	}
	echo $csstext;
}
	
	
	
	
	





function get_all_css2($link)
{
	global $csstextandtag;
	if (!isset($csstextandtag))
	{
		$csstextandtag = file_get_html($link);
		$sitetext = $csstextandtag;
		preg_match_all('[href="(.*?)"]', $sitetext, $links);
		foreach ($links[1] as &$value)
		{
			if(stristr($value, 'css'))
			{
				$text = file_get_html($value)->plaintext;
				$csstext .= $text;
			}
	
		}
	}
	return $csstext;
}


*/

}
?>