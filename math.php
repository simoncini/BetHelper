<?php
    
    function factorial ($n){
        
        if ($n==0) return 1;
        
        else {
            return $n * factorial($n-1);
        }
    }
    
    function poisson($chance, $occurrence){
        
        $e = exp(1);
        
        $a = pow($e, (-1 * $chance));
        $b = pow($chance,$occurrence);
        $c = factorial($occurrence);
        
        return $a * $b / $c;
    }
    
    function stampa ($a){
        foreach ($a as $value){
            echo $value." - "." - "." - ";
        }
    }
    
?>

