<?php

function estrai_token( &$stringa ){
    $i=0;
    
    if ($stringa[$i] == "/" ){
        $stringa = substr($stringa, strlen("/")) ;
        $i++;
    }
    
    while( $stringa[$i] != "/"  ){
        $token.=$stringa[$i];
        $i++;
    }
    
    $stringa = substr($stringa , strlen($token)+1 ) ;
    
    
    return $token;
}

function estrai_gol ( $gol , &$fatti , &$subiti ) {
    
    if ($stringa[$i] == "/" ){
        $stringa = substr($stringa, strlen("/")) ;
        $i++;
    }
    
    while ($gol[$i] != ":" ){
        $fatti.=$gol[$i];
        $i++;
    }

    $subiti = substr($gol, strlen($fatti)+1 ) ;

    return;
}
