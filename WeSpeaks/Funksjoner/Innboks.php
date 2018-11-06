<?php
/*Denne siden er sist endret 27.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta*/

include("SystemMeldinger.php");
//oppretter kobling mot db
include("dbkobling.php");
$db = new Kobling();
echo "<html>";
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='../CSS/innboks.css'>";
echo "</head>";

echo "<body>";
if(isset($_POST['meldingen'])){
	$meldingen = $_POST['meldingen'];
	hentMelding($meldingen);
}else{
	echo("<div id='ramme'><p id='tilbakemelding'>Velg en melding fra listen til venstre.</p></div>");
}

echo "</body>";
echo "</html>";
?>