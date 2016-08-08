<?php 
class Utility { 
    /* 
    * @param array $ary the array we want to sort 
    * @param string $clause a string specifying how to sort the array similar to SQL ORDER BY clause 
    * @param bool $ascending that default sorts fall back to when no direction is specified 
    * @return null 
    */ 
    public static function orderBy(&$ary, $clause, $ascending = true) { 
        $clause = str_ireplace('order by', '', $clause); 
        $clause = preg_replace('/\s+/', ' ', $clause); 
        //echo " orderBy clause $clause";
        $keys = explode(',', $clause); 
        $dirMap = array('desc' => 1, 'asc' => -1); 
        $def = $ascending ? -1 : 1; 

        $keyAry = array(); 
        $dirAry = array(); 
        foreach($keys as $key) { 
            $key = explode(' ', trim($key));
            //echo " orderBy key $key"; 
            //echo " orderBy key[0] $key[0]"; 
            $keyAry[] = trim($key[0]); 
            if(isset($key[1])) { 
                $dir = strtolower(trim($key[1])); 
                $dirAry[] = $dirMap[$dir] ? $dirMap[$dir] : $def; 
            } else { 
                $dirAry[] = $def; 
            } 
        } 

        $fnBody = ''; 
        for($i = count($keyAry) - 1; $i >= 0; $i--) { 
            $k = $keyAry[$i]; 
            $t = $dirAry[$i]; 
            $f = -1 * $t;
            //tjs 160804 
            $aStr = '$a[\''.$k.'\']'; 
            $bStr = '$b[\''.$k.'\']'; 
            //$aStr = '$a->getValue(\''.$k.'\')'; 
            //$bStr = '$b->getValue(\''.$k.'\')'; 
            if(strpos($k, '(') !== false) { 
                $aStr = '$a->'.$k; 
                $bStr = '$b->'.$k; 
            } 

            if($fnBody == '') { 
                //$fnBody .= "if({$aStr} == {$bStr}) { return 0; }\n"; 
                $fnBody .= "if(strcasecmp({$aStr}, {$bStr}) == 0) { return 0; }\n"; 
                // tjs 160805
               // $fnBody .= "return ({$aStr} < {$bStr}) ? {$t} : {$f};\n";                
                //$fnBody .= "else { {$r} = strcasecmp({$aStr}, {$bStr}); return ({$r} < 0) ? {$t} : {$f};}\n";                
                //$fnBody .= "return (strcasecmp({$aStr}, {$bStr}) < 0 ? {$t} : {$f};)\n";                
                $fnBody .= "return strcasecmp({$aStr}, {$bStr}) < 0 ? {$t} : {$f};\n";                
            } else { 
                //$fnBody = "if({$aStr} == {$bStr}) {\n" . $fnBody; 
            	$fnBody = "if(strcasecmp({$aStr}, {$bStr}) == 0) {\n" . $fnBody; 
                $fnBody .= "}\n"; 
                //$fnBody .= "return ({$aStr} < {$bStr}) ? {$t} : {$f};\n"; 
                //$fnBody .= "else { {$r} = strcasecmp({$aStr}, {$bStr}); return ({$r} < 0) ? {$t} : {$f};}\n";                                
                //$fnBody .= "return (strcasecmp({$aStr}, {$bStr}) < 0 ? {$t} : {$f};)\n";                
                $fnBody .= "return strcasecmp({$aStr}, {$bStr}) < 0 ? {$t} : {$f};\n";                
            } 
        } 

        if($fnBody) { 
        	//echo " orderBy fnBody $fnBody";
        	// try this
            $sortFn = create_function('$a,$b', $fnBody); 
        	//echo " orderBy function created...";
            usort($ary, $sortFn); 
            /*       
            usort($ary, function($a,$b) {
            	echo " orderBy compare...";
            	$temp = $a['role'];
            	echo " orderBy temp $temp";
            	
            	if ($a['role'] == $b['role']) { 
            		return 0;
            	 }
    			return ($a['role'] < $b['role']) ? -1 : 1;
            }); 
            */ 
            // was OK before...
            /*
            usort($ary, function($a,$b) {
            	//echo " orderBy compare...";
            	$arole = $a->getValue('role');
            	$brole = $b->getValue('role');
            	//echo " orderBy arole $arole brole $brole";
            	//return strcmp($arole, $brole);
            	return strcasecmp($arole, $brole);

            }); */
        	
            //echo " orderBy usort done...";
        } 
    } 
} 
?>

