<?php
/*Denne siden er sist endret 28.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Ketil*/

//oppretter kobling mot db
include("dbkobling.php");
$db = new Kobling();
session_start();
if($_POST['meldingen']){
	$sporring = "SELECT Brukernavn FROM bruker WHERE Brukertype != 1 and Brukernavn=:bruker";
	$statement = $db->prepare($sporring);
	$brukeren = $_POST['brukeren'];
	$meldingen = "Avsender: " . $_SESSION['Brukernavn']." <br>" . "Rapporterer brukeren: " . $brukeren . "<br><br>Grunnlag:<br>" . $_POST['meldingen'];
	$statement->bindParam('bruker', $_POST['brukeren']);
	$statement->execute();
	$rad = $statement->fetch(PDO::FETCH_ASSOC);
	if($rad['Brukernavn'] != null){
		$sql = "INSERT INTO SystemMeldinger VALUES(DEFAULT, 'Rapportering', NOW(), :teksten)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam('teksten', $meldingen);
		$stmt->execute();
		$_SESSION['Tilbakemelding'] = "Rapporten er sendt.";
	}else{
		$_SESSION['Tilbakemelding'] = "Brukernavnet eksisterer ikke.";
	}
	
}else{
	$_SESSION['Tilbakemelding'] = "Det oppstod en uventet feil.";
}
header('Location: ../rapporterBruker.php');
?>