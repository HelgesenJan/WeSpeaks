<?php
/*Denne siden er sist endret 23.02.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ketil */

    include("Funksjoner/chatFunksjoner.php");

    if(isset($_POST["submit"])) {
        sendMelding($_POST["melding"]);
    }


echo"<head>";
echo "<link rel='stylesheet' type='text/css' href='CSS/chatStyle.css'>";
echo"</head>";
echo "<div class='holder'>";
echo "<article><h3 class=\"chatTekst\">Chat med andre!</h3></article>";
echo "<iframe id='iframes' src='Funksjoner/chatIframeKobling.php'>";
echo "</iframe>";
echo "<form action=\"#submit\" method=\"post\">";
echo "<textarea type='text' name='melding' placeholder='Skriv melding: ' id = 'melding'></textarea>";
echo "<input id='submit' type='submit' name='submit' value='Send'>";
echo "</form>";


echo "</div>";
?>








