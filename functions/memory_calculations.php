<?

function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }
 
 function get_memory() {
	$memory_last_line = exec('free',$memory);
	$memory[1] = str_replace("     ", "-",$memory[1]);
	$parts = explode(" ",$memory[1]);
	$parts2 = explode("-",$parts[3]);
	$mem_percent = $parts2[1] / $parts2[0] * 100;
	$mem_percent = round($mem_percent);
	
	return $mem_percent;
	}


?>