<?php
/*Denne siden er sist endret 14.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Hamta*/

/* Løsning som håndterer hvilken side som er aktiv */
echo'<ul class="pc">';
    foreach($sider as $url=>$tittel) {
        echo '<li><a';
        if ($url === $aktivSide) {
            echo ' id="valgt"';
        }
        echo " href='" . $url . "'>";
        echo $tittel;
        echo '</a></li>';
    }
echo "</ul>";
?>









