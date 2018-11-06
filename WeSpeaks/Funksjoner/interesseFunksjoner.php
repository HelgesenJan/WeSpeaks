<?php
/*Denne siden er sist endret 18.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Hamta*/

include ("dbkobling.php");
$db = new Kobling();

session_start();
$brukernavn = $_SESSION["Brukernavn"];

if(isset($_POST["interesser"])){
	$interesser = $_POST["interesser"];
	foreach($interesser as $interesse){
		$sporring = "SELECT interesse FROM interesser WHERE interesse=:interessen";
		$statement = $db->prepare($sporring);
		$statement->bindParam('interessen', $interesse);
		$statement->execute();
		$rad = $statement->fetch(PDO::FETCH_ASSOC);
		if($rad['interesse'] == null){
			$sql = "INSERT INTO interesser VALUES(:interessen)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam('interessen', $interesse);
			$stmt->execute();
		}
		$sql = "INSERT INTO brukersInteresser VALUES(:interessen, :bruker);";
		$stmt = $db->prepare($sql);
		$stmt->bindParam('bruker', $brukernavn);
		$stmt->bindParam('interessen', $interesse);
		$stmt->execute();
	}
	$_SESSION["Tilbakemelding"] = "La til interessen på brukeren";

} else if(isset($_POST["slett"])){
	$interessen = str_replace('_', ' ', $_POST['interessen']);
	$sql = "DELETE FROM brukersInteresser WHERE brukernavn =:bruker AND interesse=:interessen;";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('bruker', $brukernavn);
	$stmt->bindParam('interessen', $interessen);
	$stmt->execute();
}

header("Location: ../profilside.php");
?>
