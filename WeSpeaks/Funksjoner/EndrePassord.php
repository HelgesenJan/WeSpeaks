<?php
/*Denne siden er sist endret 23.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Ketil*/

//oppretter kobling mot db
include("dbkobling.php");
include("Krypter.php");
$db = new Kobling();

session_start();
$_SESSION['Tilbakemelding'] = '';
if(isset($_POST['Gammeltpassord']) && isset($_POST['Nyttpassord'])){
	//variabler
	$brukernavn = $_SESSION['Brukernavn'];
	$gammeltpassord = $_POST['Gammeltpassord'];
	$nyttpassord = $_POST['Nyttpassord'];
	$nyttpassord2 = $_POST['Nyttpassord2'];
	$passordbytte = false;
	
	//Henter brukertype
	$sporring = "SELECT Brukertype FROM bruker WHERE Brukernavn=:brukeren";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam(':brukeren', $brukernavn);
	$stmt->execute();
	$brukertypen = $stmt->fetch(PDO::FETCH_ASSOC);
	
	//Krypterer gammelt og nytt passord
	$kryptertpassord = Krypter($gammeltpassord);
	$nykryptertpassord = Krypter($nyttpassord);
	
	
	//funksjon for endring av passord
	if($nyttpassord == $nyttpassord2){
		$sql = "SELECT Brukernavn, Passord FROM bruker";
		$sql .= " WHERE Brukernavn=:brukeren";
		//Gjør klart sql statement og binder post variabler til parameterne
		$statement = $db->prepare($sql);
		$statement->bindParam(':brukeren', $brukernavn);
		$statement->execute();
		$rad = $statement->fetch(PDO::FETCH_ASSOC);
		if($kryptertpassord == $rad['Passord']){
			$passordbytte = true;
		}else{
			$passordbytte = false;
		}
			
		if($passordbytte){
			$sql = "UPDATE bruker SET Passord='$nykryptertpassord'";
			$sql .= "WHERE Brukernavn =:brukeren";
			$resultat = $db->prepare($sql);
			$resultat->bindParam('brukeren', $brukernavn);
			$resultat->execute();
			$_SESSION['Tilbakemelding'] = "Passordet er endret!";
		}else{
			$_SESSION['Tilbakemelding'] = "Oppgitt passord er ikke riktig.";
		}	
	}else{
		$_SESSION['Tilbakemelding'] = "De to passordene oppgitt er ikke like.";
	}
	if($brukertypen['Brukertype'] == 1){
		header("Location: ../adminVerktøy.php");
	}else{
		header("Location: ../passordBytte.php");
	}
}

?>