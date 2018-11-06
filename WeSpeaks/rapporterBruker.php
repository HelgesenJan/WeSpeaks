<?php
/*Denne siden er sist endret 31.05.2018 av Ketil og Hamta
Denne siden ble kontrollert 01.06.2018 av Ole */

//oppretter kobling mot db
include("Funksjoner/dbkobling.php");
$db = new Kobling();
$aktivSide = "rapporterBruker.php";    // profilside ligger på "Mine sider" og skal derfor ikke ha en aktiv knapp
include("Funksjoner/InnloggingsSjekk.php");
//Siste css-en (linken) er BARE brukt til ikoner i brukerinfo-tabellen
$stylesheets = array("CSS/rapporterBruker.css", "CSS/General.css", "CSS/footerStyle.css");   // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
include("Includes/header.php");
?>

<div id="container">
	<h1>Rapporter en bruker</h1>
	<form method="POST" action="Funksjoner/rapporterBrukerFunksjoner.php">
		<label id="bruker">Brukernavn:</label>
		<input name="brukeren" type="text" id="navnet" required /><br>
		<p>Hvorfor rapporterer du denne brukeren?</p>
		<textarea id="teksten" name="meldingen" required></textarea>
		<button type="submit" class="knapp">Send rapport</button>
	</form>
	
	<?php
	if(isset($_SESSION['Tilbakemelding'])){
		echo('<p>'.$_SESSION['Tilbakemelding'].'</p>');
		unset($_SESSION['Tilbakemelding']);
	}
echo('</div>');
include("Includes/footer.php");
?>