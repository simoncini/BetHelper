<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/frameset.dtd">

<html>

<?php
    include('math.php');
    
    $time = date('d/m/Y H:i:s');
    
    $fp = fopen('log.html', 'a+');
    fwrite($fp, " $time | {$_SERVER['REMOTE_ADDR']} | {$_SERVER['HTTP_USER_AGENT']}\n ");
    fclose($fp);
    ?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>BetHelper 1.0</title>
<link type="text/css" rel="stylesheet" href="stili.css"></link>

<style type="text/css">

    </style>

</head>

<body lang="it" leftmargin=”0″ topmargin=”0″>

    <form action="get_data.php" target="_blank" method="GET">
        <p><input type="submit"></p>
    </form>

<center><form action="" method="GET"> SQUADRA CASA
    <p>Gol segnati in casa:<input type="text" name="gfc" value="" ></p>
    <p>Gol subiti in casa:<input type="text" name="gsc" value=""></p>
    <p>Partite giocate in casa:<input type="text" name="tot_casa" value=""></p>
    SQUADRA TRASFERTA
    <p>Gol segnati in trasferta:<input type="text" name="gft" value=""></p>
    <p>Gol subiti in trasferta:<input type="text" name="gst" value=""></p>
    <p>Partite giocate in trasferta:<input type="text" name="tot_trasf" value=""></p>
    <br>
    <input type="submit" value="Calcola" name="Calcola" >

    <?php
    
        $settate = ( isset($_GET['gfc']) && isset($_GET['gsc']) && isset($_GET['gft']) && isset($_GET['gst']) && isset($_GET['gst']) && isset($_GET['gst']) );
        $nonNULL = ( ($_GET['gfc'] != NULL ) && ($_GET['gsc']!= NULL) && ($_GET['gft'] != NULL) && ($_GET['gst'] != NULL ) && ($_GET['gst'] != NULL) && ($_GET['gst'] != NULL) );
        if( $settate && $nonNULL ){
            if ($settate){
                $gfc = $_GET['gfc'];
                $gsc = $_GET['gsc'];
                $gft = $_GET['gft'];
                $gst = $_GET['gst'];
                $p_tot_casa = $_GET['tot_casa'] ;
                $p_tot_trasf = $_GET['tot_trasf'] ;

            }
        }
        /*else if ( !$settate || !$nonNULL ) {
            echo "<font color=\"red\"><b> *Tutti i campi sono obbligatori </b></font>";
        }*/
        
    ?>
</form></center>

<?php
    
    if ( $settate && $nonNULL ) {
    
        $media_gol_fcasa = $gfc / $p_tot_casa;
        $media_gol_scasa= $gsc / $p_tot_casa;
        $media_gol_ftrasf= $gft / $p_tot_trasf;
        $media_gol_strasf= $gst / $p_tot_trasf;
    
        $P_GFC = array( round(poisson($media_gol_fcasa , 0) , 3) , round(poisson($media_gol_fcasa , 1),3) , round(poisson($media_gol_fcasa , 2) , 3) , round(poisson($media_gol_fcasa , 3) , 3) , round(poisson($media_gol_fcasa , 4) , 3) , round(poisson($media_gol_fcasa , 5) , 3));
        $P_GSC = array( round(poisson($media_gol_scasa , 0) , 3) , round(poisson($media_gol_scasa , 1),3) , round(poisson($media_gol_scasa , 2) ,3) , round(poisson($media_gol_scasa , 3) ,3) , round(poisson($media_gol_scasa , 4) ,3) , round(poisson($media_gol_scasa , 5) ,3));
        $P_GFT = array( round(poisson($media_gol_ftrasf , 0) ,3) , round(poisson($media_gol_ftrasf , 1),3) , round(poisson($media_gol_ftrasf , 2) ,3) , round(poisson($media_gol_ftrasf , 3) ,3) , round(poisson($media_gol_ftrasf , 4),3) , round(poisson($media_gol_ftrasf , 5) ,3));
        $P_GST = array( round(poisson($media_gol_strasf , 0),3) , round(poisson($media_gol_strasf , 1),3) , round(poisson($media_gol_strasf , 2),3) , round(poisson($media_gol_strasf , 3),3) , round(poisson($media_gol_strasf , 4),3) , round(poisson($media_gol_strasf , 5) ,3));
    
    
        $primo = array (); //contiene i valori dei prodotti delle due poissoniane gol fatti in casa - gol subiti in trasferta
        $secondo = array (); //contiene i valori dei prodotti delle due poissoniane gol subiti in casa - gol fatti in trasferta
        $sommaprimo=0;
        $sommasecondo=0;
    
        for ( $i=0 ; $i<6 ; $i++ ){
            for ( $j=0 ; $j<6 ; $j++){
                if ($i==$j){
                    $primo[$i]= ( $P_GFC[$i] ) * ( $P_GST[$i] );
                    $sommaprimo = $sommaprimo + $primo[$i];
                    $secondo[$i]= ( $P_GSC[$i] ) * ($P_GFT[$i] );
                    $sommasecondo= $sommasecondo + $secondo[$i];
                }
            }
        }
    
        for ( $i=0 ; $i<6 ; $i++ ){
            $primo[$i] = $primo[$i] / $sommaprimo;
            $secondo[$i] = $secondo[$i] / $sommasecondo;
        }
    
    
        $t=0;
    
        for ( $i=0 ; $i<6 ; $i++){
            for ( $j=0 ; $j<6 ; $j++){
                $matrix[$i][$j] = round( ($primo[$i] * $secondo[$j]) , 4 ) ;
                $t=$t+$matrix[$i][$j];
             }

        }
    }
    
    ?>

    <br><br><br><br>

    <center><b><h2>Tabella Risultato Esatto:<h2></b></center>
                    
    <center><table width="80%">
            <tr>
                <td></td>
                <td>Gol Squadra Ospite da 0 a 5</td>
            </tr>
            <tr>
                <td width="20%">Gol Squadra Casa da 0 a 5</td>
                <td>
                    
            <table width= "80%" border="2px">
<?php
    
    for ( $i=0 ; $i<6 ; $i++ ){
        
        echo "<tr >";
        
        for ( $j=0 ; $j<6 ; $j++ ){
            echo "<td height=\"20px\">". $matrix[$i][$j]*100 ."%</td>";
        }
        
        echo "</tr>";
    }
    
    $CASA=0;
    $OSPITE=0;
    $PAREGGIO=0;
    $U_1=0;
    $U_2=0;
    $U_3=0;
    $O_1=0;
    $O_2=0;
    $O_3=0;
    $GOAL=0;
    $NO_GOAL=0;
    
    for ($i=0 ; $i<6 ; $i++ ){
        for ($j=0 ; $j<6 ; $j++ ){
            if ( $i>$j ) $CASA=$CASA+$matrix[$i][$j];
            if ( $i<$j ) $OSPITE=$OSPITE+$matrix[$i][$j];
            if ( $i==$j ) $PAREGGIO=$PAREGGIO+$matrix[$i][$j];
            if ($i+$j < 2) $U_1=$U_1+$matrix[$i][$j];
            if ($i+$j < 3) $U_2=$U_2+$matrix[$i][$j];
            if ($i+$j < 4) $U_3=$U_3+$matrix[$i][$j];
            if ($i+$j >= 2) $O_1=$O_1+$matrix[$i][$j];
            if ($i+$j >= 3) $O_2=$O_2+$matrix[$i][$j];
            if ($i+$j >= 4) $O_3=$O_3+$matrix[$i][$j];
            if (( $i != 0 ) && ( $j != 0) ) $GOAL=$GOAL+$matrix[$i][$j];
            if (( $i == 0 ) || ( $j == 0) ) $NO_GOAL=$NO_GOAL+$matrix[$i][$j];
        }
    }
    
    ?>
                
    </table>
        </td></tr></table></center>

    <br><br><br>

    <center><b><h2><font color="red">Risultato Fisso:</font><h2></b></center>

    <center><h3>CASA: <?php echo (round($CASA , 2)*100)."%" ?> PAREGGIO : <?php echo (round($PAREGGIO,2)*100)."%" ?> OSPITE : <?php echo (round($OSPITE,2)*100)."%" ?></h3></center>

    <br><br><br>

    <center><b><h2><font color="red">Under-Over:</font><h2></b></center>

    <center><h3>UNDER 1.5 : <?php echo (round($U_1,2)*100)."%" ?> OVER 1.5 : <?php echo (round($O_1,2)*100)."%" ?></h3></center>
    <center><h3>UNDER 2.5 : <?php echo (round($U_2,2)*100)."%" ?> OVER 2.5 : <?php echo (round($O_2,2)*100)."%" ?></h3></center>
    <center><h3>UNDER 3.5 : <?php echo (round($U_3,2)*100)."%" ?> OVER 3.5 : <?php echo (round($O_3,2)*100)."%" ?></h3></center>

    <br><br><br>

    <center><b><h2><font color="red">GOAL-NO GOAL:</font><h2></b></center>

    <center><h3>GOAL : <?php echo (round($U_1,2)*100)."%" ?> NO GOAL : <?php echo (round($O_1,2)*100)."%" ?></h3></center>

    <br><br><br>

</body>

</html>
