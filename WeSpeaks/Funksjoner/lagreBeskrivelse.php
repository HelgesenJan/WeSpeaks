<?php
//Denne siden er utviklet av Ole, siste gang endret 09.03.2018
//oppretter kobling mot db
include("dbkobling.php");

$db = new Kobling();

session_start();

$brukernavn = $_SESSION["Brukernavn"];
$beskrivelsen = $_POST["beskrivelsen"];

$sql = "SELECT Brukernavn FROM profil WHERE Brukernavn =:brukernavnet";
$statement = $db->prepare($sql);
$statement->bindParam(':brukernavnet', $brukernavn);
$statement->execute();

if($statement->rowCount() > 0){
	$nySql = "UPDATE profil SET Beskrivelse =:beskrivelsen WHERE Brukernavn =:brukeren;";
	$nyStatement = $db->prepare($nySql);
	$nyStatement->bindParam(':beskrivelsen', $beskrivelsen);
	$nyStatement->bindParam(':brukeren', $brukernavn);
	$nyStatement->execute();
}else{
	$nySql = "INSERT INTO profil (Brukernavn, Beskrivelse) VALUES (:bruker, :beskrivelse);";
	$nyStatement = $db->prepare($nySql);
	$nyStatement->bindParam(':beskrivelse', $beskrivelsen);
	$nyStatement->bindParam(':bruker', $brukernavn);
	$nyStatement->execute();
}

header("Location: ../profilside.php");
?>