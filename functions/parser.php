<?php
gc_enable(); // Enable Garbage Collector
include ("simple_html_dom.php"); // Acknowledge: Jose Solorzano (https://sourceforge.net/projects/php-html/)
include ("syllable_counter.php"); // Acknowledge: http://www.russellmcveigh.info/maintenance.php

function tagcounter($link, $tagtype, $identifier)
    {   
    	global $dom;
    	if (!isset($dom))
    	{
        $ret = array(); // returns an array
        $dom = new domDocument; // sets up a new dom object
        @$dom->loadHTML(file_get_contents($link)); // gets the html of the page while supressing any errors
        $dom->preserveWhiteSpace = false; // does not preserve whitespaces in the html
        }
        $links = $dom->getElementsByTagName($tagtype); // polls the links in the page and stores them as "$links"
        // Loop for walking through each "a" tag and looking for href to make sure it's a link
        foreach ($links as $tag)
        {   
            $ret[$tag->getAttribute($identifier)] = $tag->childNodes->item(0)->nodeValue;
        }
		$ret = count($ret);
        return $ret;
    }
    function simple_tag_counter($link, $tagtype)
    {   
    	global $dom;
    	if (!isset($dom))
    	{
    	$count = 0;
        $dom = new domDocument; // sets up a new dom object
        @$dom->loadHTML(file_get_contents($link)); // gets the html of the page while supressing any errors
        $dom->preserveWhiteSpace = false; // does not preserve whitespaces in the html
        }
        $links = $dom->getElementsByTagName($tagtype); // polls the links in the page and stores them as "$links"
        // Loop for walking through each "a" tag and looking for href to make sure it's a link
        foreach ($links as $tag)
        {   
            $count++;
        }
		$ret = $count;
        return $ret;
    }
    
function linkcounter2($link)
    {   
		$result = strip_everything_keep_tags($url);
		echo $result;
        $finder='/\>(.*)<\/a>/';
        preg_match_all($finder,$result,$parts);
        $links=$parts[1];
        foreach($links as $link){
            array_push($urlArray, $link);
        }

        foreach($urlArray as $value)
        {
        	$count++;
        	//echo " " . $count;
            $textytext .= " " . $value;
        }
        		//echo $textytext;
        		$wordcount2=str_word_count($textytext);
        		//echo " " . $count . " ";
        		//echo $wordcount2 . " ";
        		return round($wordcount2/$count, 2);
    }
    
     function linkcounter($url){
/*
        $urlArray = array();
		$count = 0;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); */
		//echo $result;
		$result = strip_everything_keep_tags_curl($url);
        $regex='/\>(.*)<\/a>/';
        preg_match_all($regex,$result,$parts);
        $links=$parts[1];
        foreach($links as $link){
            array_push($urlArray, $link);
        }
        curl_close($ch);

        foreach($urlArray as $value)
        {
        	$count++;
        	//echo " " . $count;
            $textytext .= " " . $value;
        }
        		//echo $textytext;
        		$wordcount2=str_word_count($textytext);
        		//echo " " . $count . " ";
        		//echo $wordcount2 . " ";
        		return round($wordcount2/$count, 2);
    } 
    
        function average_header_length($url){
/*
        $urlArray = array();
		$count = 0;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); */
		//echo $result;
		$result = strip_everything_keep_tags_curl($url);

        $regex='/<h[0-6]\>(.*)<\/h/';
        preg_match_all($regex,$result,$parts);
        $links=$parts[1];
        foreach($links as $link){
            array_push($urlArray, $link);
        }
        curl_close($ch);

        foreach($urlArray as $value)
        {
        	$count++;
        	//echo $value . "</br>";
            $textytext .= " " . $value;
        }
        		$wordcount2=str_word_count($textytext);
        		//echo " " . $count . " ";
        		//echo $wordcount2 . " ";
        		return round($wordcount2/$count, 2);
    } 
    		    

function kill_dom()
{
//Whatever did Dom do to you!?
unset($GLOBALS['dom']);
unset($GLOBALS['text']);
unset($GLOBALS['textandtag']);
unset($GLOBALS['csstext']);
}
		
function strip_everything($link)
{
		global $text;
	if (!isset($text))
	{
		$text = file_get_html($link)->plaintext;
		//echo "strip everything called </br>";
	}
	return $text;
}

function strip_everything_keep_tags($link)
{
		global $textandtag;
	if (!isset($textandtag))
	{
		$textandtag = file_get_html($link);
		
	}
	return $textandtag;
}

function strip_everything_keep_tags_curl($url)
{
		global $textandtagcurl;
	if (!isset($textandtagcurl))
	{
		//echo "strip everything keep tags CURL called </br>";
		$urlArray = array();
		$count = 0;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $textandtagcurl = curl_exec($ch);
		
		
		
	}
	return $textandtagcurl;
}

function get_all_css($link)
{
	global $csstext;
	if (!isset($csstext))
	{
		//echo "css called </br>";
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



function words_on_page($link)
	{
		$wordcount=count(str_word_count(strip_everything($link), 1));
		return $wordcount;
	}	
		
function sentences_on_page($link)
	{
		$str = strip_everything($link);
		return preg_match_all('/[^\s](\.|\!|\?)(?!\w)/',$str,$match);
	}
	
function linkdensity($link)
	{
		 $words = words_on_page($link);
		 $urls = tagcounter($link, 'a', 'href');
		 $density = $words / $urls;
		 $density = round($density, 3);
		 return $density;
	}

function total_syllables($link)
		{
			$input = strip_everything($link);
			$input = trim($input);
			$output = ereg_replace("\n", " ", $input);
			$output = preg_replace('/\s\s+/', ' ', $output);
			$word_array = split_words($output);
			$total_syllables = 0;

		if (count($word_array)>0 && !empty($input))
		{
			foreach($word_array as $key=>$value)
			{
				$total_syllables += count_syllables($value);
			}
		}
	return $total_syllables;
}

function flesh_reading_ease($link)
{
	$readingease= 206.835 - 1.015*(words_per_sentence($link)) - 84*(syllables_per_word($link));
	$readingease = abs(round($readingease , 2));
	return $readingease;	
}

function words_per_sentence($link)
{
	return round((words_on_page($link)/sentences_on_page($link)), 2);
}

function syllables_per_word($link)
{
	return round(total_syllables($link)/words_on_page($link), 2);
}

function paragraphs_on_page($link)
{
	return simple_tag_counter($link, 'p');
}

function sentences_per_paragraph($link)
{
	$SOP = sentences_on_page($link);
	$POP = paragraphs_on_page($link);
	//echo "SOP = " . $SOP . ", POP = " . $POP . "</br>";
 	return round($SOP/$POP, 2);
}

function sitemap_present($link)
{
	if (preg_match("/map/", strip_everything($link)))
	{
    	return 1;
    }
    	else
    {
    	return 0;
	}
}

function searchbox_present($link)
{
	if (preg_match("/search/", strip_everything($link)))
	{
    	return 1;
    }
    	else
    {
    	return 0;
	}
}

function accessibility_mention($link)
{
	if (preg_match("/accessibility/", strip_everything($link)))
	{
    	return 1;
    }
    	else
    {
    	return 0;
	}
}

function check_valid($link)
{
$link = "http://validator.w3.org/check?uri=". $link;

if (preg_match("/Passed/", strip_everything($link)))
	{
    	return 1;
    }
    	else
    {
    	return 0;
	}
}
function get_website_data($tableID, $function_ID)
{
	$webaddress = $tableID;
	$resultt = mysql_query("SELECT * FROM testable_functions WHERE testable_function_ID = '" . $function_ID . "'");

	while($row = mysql_fetch_array($resultt))
  	{
  		$codetorun = $row['testableFunction'];
  		$charicteristicName = $row['characteristicName'];
  		eval("\$myanswer = $codetorun".";"); 
  		return $myanswer;
  	}  

}



function dead_end_page($link)
{
if (tagcounter($link, "a", "href") == 0)
return 0;
else
return 1;
}

function all_caps_check($link)
{
$str = strip_everything($link);
if (strtoupper($str) == $str)
	{
	return 0;
	}
else
	{
	return 1;
	}
}

function find_CSS_word($link,$word)
{
$link = get_all_css($link);
	if (strpos($link,$word))
	{
	    return 1;
	}
	else
	{
		return 0;
	}
}

function find_html_word($link,$word)
{
$link = strip_everything_keep_tags($link);
	if (strpos($link,$word))
	{
	    return 1;
	}
	else
	{
		return 0;
	}
}

function common_fonts($link)
{
$link = get_all_css($link);
//echo "<h1>TEST</h1>";
//echo $link;
	if (strpos($link,"Arial") || strpos($link,"Veranda") || strpos($link,"Helvetica") || strpos($link,"San Serif"))
	{
	    return 1;
	}
	else
	{
		return 0;
	}
}

function swedish_fonts($link)
{
$link = get_all_css($link);
//echo "<h1>TEST</h1>";
//echo $link;
	if (strpos($link,"Arial") || strpos($link,"Veranda"))
	{
	    return 1;
	}
	else
	{
		return 0;
	}
}

function word_occurance_html($link, $word)
{
	$link = strip_everything_keep_tags($link);
	return substr_count($link, $word);
}

function word_occurance_css($link, $word)
{
	$link = get_all_css($link);
	return substr_count($link, $word);
}


     function headercounter($url){


		$result = strip_everything_keep_tags_curl($url);
        $regex='/\>(.*)<\/h[1-6]/';
        preg_match_all($regex,$result,$parts);
        $links=$parts[1];
        foreach($links as $link){
            array_push($urlArray, $link);
        }
        curl_close($ch);

        foreach($urlArray as $value)
        {
        	$count++;
			echo $value;
            $textytext .= " " . $value;
        }

        		$wordcount2=str_word_count($textytext);

        		return round($wordcount2/$count, 2);
    } 
    
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

	function getArrayValues($web_address, $orderType)
	{
		//SET INITIAL VARIABLES
		$arrayCounter = 0;
		$totalPass = 0;
		$totalFail = 0;
		$passorfail = 2;
		$ascOrDec = 0;
		
		$result = mysql_query("SELECT * FROM guidelines_with_limits WHERE criteria_name = '" . $orderType . "' ORDER BY guideline_ID ASC");
		while($row = mysql_fetch_array($result))
		{
			$passValue = $row['yChar'] + ($row['xChar']*3);
			$failValue = $row['yChar'] + ($row['xChar']*2);
			$xchar = $row['xChar'];
			$ychar = $row['yChar'];
	
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
			//CHECK WHAT WAY IS UP	
			$ascOrDec = 0;
			$passorfail = 2;
			if ($passValue > $failValue)
				{
					$ascOrDec = 1;
				}
			// UP IS UP
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
			// DOWN IS UP
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
			
			$passnumberr = ($characteristicValue - $ychar)/$xchar;
			if ($passnumberr >= 4 && $passnumberr <= 5)
			{
			$passtype = "Fail";
			}
			if ($passnumberr >= 3 && $passnumberr <= 4)
			{
			$passtype = "Low Fail";
			}
			if ($passnumberr >= 2 && $passnumberr <= 3)
			{
			$passtype = "Questionable";
			}
			if ($passnumberr >= 1 && $passnumberr <= 2)
			{
			$passtype = "Low Pass";
			}
			if ($passnumberr >= 0 && $passnumberr <= 1)
			{
			$passtype = "Pass";
			}
			if ($passnumberr >= 5)
			{
			$passtype = "High Fail";
			}
			if ($passnumberr <= 0)
			{
			$passtype = "High Pass";
			}
			

			// POPULATE ARRAY
			$guidelineArray[$arrayCounter]['guideline_ID']=$guideline_ID;
			$guidelineArray[$arrayCounter]['guideline_text']=$guidelineText;
			$guidelineArray[$arrayCounter]['characteristicValue']=$characteristicValue;
			$guidelineArray[$arrayCounter]['passValue']=$passValue;
			$guidelineArray[$arrayCounter]['failValue']=$failValue;
			$guidelineArray[$arrayCounter]['passOrFail']=$passorfail;
			$guidelineArray[$arrayCounter]['ascordec']=$ascOrDec;
			$guidelineArray[$arrayCounter]['SVGChart']= createSVGBar($xchar, $ychar, $characteristicValue,$ascOrDec);
			$guidelineArray[$arrayCounter]['passtype']= $passtype;
			$arrayCounter++;
		}
	}
	return $guidelineArray;
}    

function createSVGBar($xchar, $ychar, $value, $ascordec)
{
$lineposition = ($value - $ychar)/$xchar;


$lineposition = $lineposition * 46;

if ($lineposition > 240)
{
$lineposition = 240;
}
if ($lineposition < 10)
{
$lineposition = 10;
}
$lineposition = -$lineposition + 250;
$miniline1 = $lineposition - 3;
$miniline2 = $lineposition + 3;
$SVG = "<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" height=\"15\" width=\"250\">
      <defs>
      <linearGradient id=\"myLinearGradient1\"
                      x1=\"0%\" y1=\"0%\"
                      x2=\"100%\" y2=\"0%\"
                      spreadMethod=\"pad\">
        <stop offset=\"15%\" stop-color=\"#FF0500\" stop-opacity=\"1\"/>
        <stop offset=\"50%\" stop-color=\"#FFF600\" stop-opacity=\"1\"/>

        <stop offset=\"85%\" stop-color=\"#4DE300\" stop-opacity=\"1\"/>

      </linearGradient>

    </defs>

    <rect x=\"0\" y=\"10\" width=\"250\" height=\"7\"
       style=\"fill:url(#myLinearGradient1);
              stroke-width: 1;\" />
	<line x1=\"10\" y1=\"5\" x2=\"10\" y2=\"22\" style=\"stroke:rgb(56,56,56);stroke-width:1.5\"/>
	<line x1=\"33\" y1=\"7\" x2=\"33\" y2=\"19\" style=\"stroke:rgb(56,56,56);stroke-width:1\"/>
	<line x1=\"56\" y1=\"5\" x2=\"56\" y2=\"22\" style=\"stroke:rgb(56,56,56);stroke-width:1.5\"/>
	<line x1=\"79\" y1=\"7\" x2=\"79\" y2=\"19\" style=\"stroke:rgb(56,56,56);stroke-width:1\"/>
	<line x1=\"102\" y1=\"5\" x2=\"102\" y2=\"22\" style=\"stroke:rgb(56,56,56);stroke-width:1.5\"/>
	<line x1=\"125\" y1=\"7\" x2=\"125\" y2=\"19\" style=\"stroke:rgb(56,56,56);stroke-width:1\"/>
	<line x1=\"148\" y1=\"5\" x2=\"148\" y2=\"22\" style=\"stroke:rgb(56,56,56);stroke-width:1.5\"/>
	<line x1=\"171\" y1=\"7\" x2=\"171\" y2=\"19\" style=\"stroke:rgb(56,56,56);stroke-width:1\"/>
	<line x1=\"194\" y1=\"5\" x2=\"194\" y2=\"22\" style=\"stroke:rgb(56,56,56);stroke-width:1.5\"/>
	<line x1=\"217\" y1=\"7\" x2=\"217\" y2=\"19\" style=\"stroke:rgb(56,56,56);stroke-width:1\"/>
	<line x1=\"240\" y1=\"5\" x2=\"240\" y2=\"22\" style=\"stroke:rgb(56,56,56);stroke-width:1.5\"/>
	
	<line x1=\"" . $lineposition . "\" y1=\"0\" x2=\"" . $lineposition . "\" y2=\"25\" style=\"stroke:rgb(0,0,0);stroke-width:3\"/>
	<!--<line x1=\"" . $miniline1 . "\" y1=\"0\" x2=\"" . $miniline2 . "\" y2=\"0\" style=\"stroke:rgb(0,0,0);stroke-width:1\"/>-->
	<line x1=\"" . $miniline1 . "\" y1=\"25\" x2=\"" . $miniline2 . "\" y2=\"25\" style=\"stroke:rgb(0,0,0);stroke-width:1\"/>
  
</svg>";

return $SVG;
}
?>