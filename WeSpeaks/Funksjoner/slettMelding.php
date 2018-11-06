<?php
/*Denne siden er sist endret 14.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta*/

if(isset($_POST['slett'])){
	$sql = "INSERT INTO lestmelding VALUES(:melding, :bruker)";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('melding', $_POST['slett']);
	$stmt->bindParam('bruker', $_SESSION['Brukernavn']);
	$stmt->execute();
}

header("Innboks.php");

?>
