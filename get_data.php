
<?php
    include 'stringhe.php';

    $file = fopen("data.php", "w") or die ("Non sono riuscito ad aprire il file");
    fwrite($file , "<?php\n" );
    $array1 = file ("casa.txt");
    $array2 = file ("trasferta.txt");
    
    for ( $k=0 ; $k<39 ; $k++ ){
        if( $k % 2 != 1 ) {
            $stringa_casa = str_replace("\t", "/" , $array1[$k] ) ;  // Si eliminano le Tabulazioni
            $stringa_trasferta = str_replace("\t", "/" , $array2[$k] ) ;
            
            $prova = estrai_token($stringa_casa);   // Si elimina la posizione attuale della squadra e si eliminano i primi spazi  
            $prova = estrai_token($stringa_trasferta);   
            
            //echo "La stringa dopo la rimozione posizione classifica è:".$stringa_casa;

            $sq_casa = estrai_token($stringa_casa);  // Estraggo il nome della squadra 
            $sq_casa.= "_C";
            $sq_trasferta = estrai_token($stringa_trasferta);
            $sq_trasferta.= "_T";
            
            //echo "La stringa dopo la rimozione nome squadra è:".$stringa_casa;
            //echo "SQ_CASA vale :".$sq_casa."\n";
            
            $n_partite_C = estrai_token($stringa_casa) ;  // Salvo quante partite sono state giocate in casa e in trasferta
            $n_partite_T=estrai_token($stringa_trasferta) ;
       
            //echo "La stringa dopo la rimozione partite giocate è:".$stringa_casa;
            
            estrai_token($stringa_casa) ;    // FIX ME: (Devo togliere le gli indicatori di partite V-P-S che però torneranno comodo in seguito, per adesso le elimino cosi)
            estrai_token($stringa_casa) ;
            estrai_token($stringa_casa) ;
            estrai_token($stringa_trasferta) ;
            estrai_token($stringa_trasferta) ;
            estrai_token($stringa_trasferta) ;
           
            //echo "La stringa dopo la rimozione partite VPS è:".$stringa_casa;
            
            $gol_casa = estrai_token($stringa_casa) ;
            $gol_trasferta = estrai_token($stringa_trasferta) ;
            
            echo "Token dei gol fatti in casa è:".$gol_casa."\n";
            
            $GFC=''; // Inizializzo le variabili
            $GSC='';
            $GFT='';
            $GST='';
            
            estrai_gol($gol_casa , $GFC , $GSC);
            estrai_gol($gol_trasferta , $GFT , $GST);
            
            ${$sq_casa}[0] = $n_partite_C ;   // Attribuisco ad ogni array che identifica la squadra la media gol fatti/subiti 
            ${$sq_casa}[1] = $GFC ;
            ${$sq_casa}[2] = $GSC ;
            ${$sq_trasferta}[0] = $n_partite_T ; 
            ${$sq_trasferta}[1] = $GFT ;
            ${$sq_trsferta}[2] = $GST ;
            
            echo "partite=".$n_partite_C." i gfc sono ".$GFC." e i gsc sono: ".$GSC."\n";
            
            $to_Insert = "\t$".$sq_casa."= array('".$n_partite_C."' , '".$GFC."' , '".$GSC."');\n";
            //echo $to_Insert;
            fwrite($file , $to_Insert );
            
            $to_Insert = "\t$".$sq_trasferta."= array('".$n_partite_T."' , '".$GFT."' , '".$GST."');\n";
            fwrite($file , $to_Insert );
        }
    }
    
    fclose($file);
    
    /*$primo_C[0] = 0;
    $primo_C[1] = 1;
    
    $primaprova = 'primo';
    $primaprova.="_C";
    
    echo ${$primaprova}[0];
    echo $prova;
    */
    
   