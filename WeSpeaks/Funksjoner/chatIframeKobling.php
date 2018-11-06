<?php
/*Denne siden er sist endret 23.02.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Hamta*/

include("chatFunksjoner.php");
include("dbkobling.php");
$db = new Kobling();


echo"<head>";
echo "<link rel='stylesheet' type='text/css' href='../CSS/chatStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../CSS/General.css'>";
echo"</head>";
echo "<fieldset id='scroll'>";
$meldinger = hentMelding();
echo $meldinger;
echo "</fieldset>";

?>



<script type="text/javascript">
    // Funksjon som starter scrollen på bunnen under reload
    window.onload=function () {
        var iframe = document.getElementById("scroll");
        iframe.scrollTop = iframe.scrollHeight;
    }
</script>

