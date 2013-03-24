<?php
//
function count_syllables($word) {
	global $split_array;
	$subsyl = array(
	'cial',
	'tia',
	'cius',
	'cious',
	'uiet',
	'gious',
	'geous',
	'priest',
	'giu',
	'dge',
	'ion',
	'iou',
	'sia$',
	'.che$',
	'.ched$',
	'.abe$',
	'.ace$',
	'.ade$',
	'.age$',
	'.aged$',
	'.ake$',
'.ale$',
'.aled$',
'.ales$',
'.ane$',
'.ame$',
'.ape$',
'.are$',
'.ase$',
'.ashed$',
'.asque$',
'.ate$',
'.ave$',
'.azed$',
'.awe$',
'.aze$',
'.aped$',
'.athe$',
'.athes$',
'.ece$',
'.ese$',
'.esque$',
'.esques$',
'.eze$',
'.gue$',
'.ibe$',
'.ice$',
'.ide$',
'.ife$',
'.ike$',
'.ile$',
'.ime$',
'.ine$',
'.ipe$',
'.iped$',
'.ire$',
'.ise$',
'.ished$',
'.ite$',
'.ive$',
'.ize$',
'.obe$',
'.ode$',
'.oke$',
'.ole$',
'.ome$',
'.one$',
'.ope$',
'.oque$',
'.ore$',
'.ose$',
'.osque$',
'.osques$',
'.ote$',
'.ove$',
'.pped$',
'.sse$',
'.ssed$',
'.ste$',
'.ube$',
'.uce$',
'.ude$',
'.uge$',
'.uke$',
'.ule$',
'.ules$',
'.uled$',
'.ume$',
'.une$',
'.upe$',
'.ure$',
'.use$',
'.ushed$',
'.ute$',
'.ved$',
'.we$',
'.wes$',
'.wed$',
'.yse$',
'.yze$',
'.rse$',
'.red$',
'.rce$',
'.rde$',
'.ily$',
//'.ne$',
'.ely$',
'.des$',
'.gged$',
'.kes$',
'.ced$',
'.ked$',
'.med$',
'.mes$',
'.ned$',
'.sed$',
'.nce$',
'.rles$',
'.nes$',
'.pes$',
'.tes$',
'.res$',
'.ves$',
'ere$'
// ORIGINALLY ONLY 'are' appeared below 
/*
'abe',
'ace',
'ade',
'age',
'ale',
'ate',
*/
//'are'
 );
 
$addsyl = array(
'ia',
'riet',
'dien',
'ien',
'iet',
'iu',
'iest',
'io',
'ii',
'ily',
'.oala$',
'.iara$',
'.ying$',
//'.reer$',
'.earest',
/*
'.aber',
'.acer',
'.ader',
'.ager',
'.aler',
'.arer',
'.ater',
*/
'.arer',
'.aress',
//
'.eate$',
'.eation$',
'[aeiouym]bl$',
'[aeiou]{3}',
'^mc','ism',
'^mc','asm',
'([^aeiouy])\1l$',
'[^l]lien',
'^coa[dglx].',
'[^gq]ua[^auieo]',
'dnt$'
   );
  // UBER EXCEPTIONS - WHOLE WORDS THAT SLIP THROUGH THE NET OR SOMEHOW THROW A WOBBLY
$exceptions_one = array(
"abe",
"ace",
"ade",
"age",
"ale",
"are",
"use",
"ate"
);
   // Based on Greg Fast's Perl module Lingua::EN::Syllables
   $word = preg_replace('/[^a-z]/is', '', strtolower($word));
   $word_parts = preg_split('/[^aeiouy]+/', $word);
   foreach ($word_parts as $key => $value)
   {
   		if ($value <> '')
   		{
   			$valid_word_parts[] = $value;
  		}
	}
    $syllables = 0;
    foreach ($subsyl as $syl)
    {
    	$syllables -= preg_match('~'.$syl.'~', $word);
    }
    foreach ($addsyl as $syl)
    {
   		$syllables += preg_match('~'.$syl.'~', $word);
  	}
 	if (strlen($word) == 1) {
  	//$syllables++;
  	}
  // UBER EXCEPTIONS - WORDS THAT SLIP THROUGH THE NET
  	if (in_array($word,$exceptions_one,true))
  	{
    	$syllables -= 1;
    }
    $syllables += count($valid_word_parts);
  	$syllables = ($syllables == 0) ? 1 : $syllables;
  	if ($syllables>1)
  	{
  	}
  	return $syllables;
}


function split_words($text)
{
	global $word_array;
	//$words = strlen(preg_replace('/[^ ]/', ' ', $text));
	$word_array = explode(" ",$text);
	return ($word_array);
}


?>