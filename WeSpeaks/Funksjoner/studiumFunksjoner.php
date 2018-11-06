<?php
/*Denne siden er sist endret 20.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ketil*/

include ("dbkobling.php");
$db = new Kobling();

session_start();
$brukernavn = $_SESSION["Brukernavn"];
echo($_POST["studiumet"]);
if(isset($_POST["Lagre"])){
	$studium = $_POST["studiumet"];
	$graden = $_POST["graden"];
	$skolen = $_POST["skolen"];
	$arskull = $_POST["arskullet"];
	
	
	$sqlStudium = "INSERT INTO studier VALUES(:bruker, :studiumet, :graden, :skolen, :arskull);";
	$stmtStudium = $db->prepare($sqlStudium);
	$stmtStudium->bindParam('bruker', $brukernavn);
	$stmtStudium->bindParam('studiumet', $studium);
	$stmtStudium->bindParam('graden', $graden);
	$stmtStudium->bindParam('skolen', $skolen);
	$stmtStudium->bindParam('arskull', $arskull);
	$stmtStudium->execute();
	
	
	
} else if(isset($_POST["slett"])){
	$studiumet = str_replace('_', ' ', $_POST['studiumet']);
	$sql = "DELETE FROM studier WHERE brukernavn =:bruker AND studium=:studiumet;";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('bruker', $brukernavn);
	$stmt->bindParam('studiumet', $studiumet);
	$stmt->execute();
}

header("Location: ../profilside.php");
?>