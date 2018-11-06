<?php
/*Denne siden er sist endret 09.03.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan*/

//oppretter kobling mot db
include("dbkobling.php");

$db = new Kobling();

session_start();

$brukernavn = $_SESSION["Brukernavn"];

$sql = "SELECT Brukernavn FROM profil WHERE Brukernavn =:brukernavnet";
$statement = $db->prepare($sql);
$statement->bindParam(':brukernavnet', $brukernavn);
$statement->execute();

$fornavn = $_POST["Fornavn"];
$etternavn = $_POST["Etternavn"];
$campus = $_POST["Campus"];
$dato = $_POST["Fodselsdato"];
$land = $_POST["Land"];

if($fornavn == ""){
	$fornavn = null;
}
if($etternavn == ""){
	$etternavn = null;
}
if($campus == ""){
	$campus = null;
}
if($dato == ""){
	$dato = null;
}
if($land == ""){
	$land = null;
}

if($statement->rowCount() > 0){
	$nySql = "UPDATE profil SET Fornavn =:fornavnet, Etternavn =:etternavnet,";
	$nySql .= " Campus =:campusen, Fodselsdato =:datoen, Land =:landet WHERE Brukernavn =:brukeren;";
	$nyStatement = $db->prepare($nySql);
	$nyStatement->bindParam(':fornavnet', $fornavn);
	$nyStatement->bindParam(':etternavnet', $etternavn);
	$nyStatement->bindParam(':campusen', $campus);
	$nyStatement->bindParam(':datoen', $dato);
	$nyStatement->bindParam(':landet', $land);
	$nyStatement->bindParam(':brukeren', $brukernavn);
	$nyStatement->execute();
}else{
	$nySql = "INSERT INTO profil (Brukernavn, Fornavn, Etternavn, Campus, Fodselsdato, Land)";
	$nySql .= " VALUES (:brukeren, :fornavnet, :etternavnet, :campusen, :datoen, :landet);";
	$nyStatement = $db->prepare($nySql);
	$nyStatement->bindParam(':fornavnet', $fornavn);
	$nyStatement->bindParam(':etternavnet', $etternavn);
	$nyStatement->bindParam(':campusen', $campus);
	$nyStatement->bindParam(':datoen', $dato);
	$nyStatement->bindParam(':landet', $land);
	$nyStatement->bindParam(':brukeren', $brukernavn);
	$nyStatement->execute();
}
header("Location: ../profilside.php");

?>