<?php 
/*Denne siden er sist endret 29.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan*/

include("dbkobling.php");
$db = new Kobling();
session_start();
if(isset($_POST['karantene'])){
	$bruker = $_POST['karantene'];
	$epost = $_POST['epost'];
	$sporring = "SELECT niva FROM karantener WHERE Brukernavn=:bruker;";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam('bruker', $bruker);
	$stmt->execute();
	$rad = $stmt->fetch(PDO::FETCH_ASSOC);
	$sql = "SELECT Epost FROM bruker WHERE Brukernavn=:bruker;";
	$statement = $db->prepare($sql);
	$statement->bindParam('bruker', $_SESSION['Brukernavn']);
	$statement->execute();
	$eposten = $statement->fetch(PDO::FETCH_ASSOC);
	$nivaet = $rad['niva'];
	if($nivaet == null){
		//Første karantene varer 1 dag
		$dager = date("Y-m-d H:i:s", time() + 86400);
		$nivaet = 1;
		$meldingen = "Din bruker er blitt satt i karantene. Dette er den første karantenen registrert på din bruker, og vil vare i 1 dag.
		Spørsmål angående denne avgjørelsen kan sendes på epost: ". $eposten['Epost'].".";
	}elseif($nivaet == 1){
		//Andre karantene varer 7 dager
		$dager = date("Y-m-d H:i:s", time() + 604800);
		$nivaet = 2;
		$meldingen = "Din bruker er blitt satt i karantene. Dette er den andre karantenen registrert på din bruker, og vil vare i 7 dager. 
		Spørsmål angående denne avgjørelsen kan sendes på epost: ". $eposten['Epost'].".";
	}else{
		//Alle andre karantener varer 14 dager
		$dager = date("Y-m-d H:i:s", time() + 1209600);
		$nivaet = 3;
		$meldingen = "Din bruker er blitt satt i karantene. Det er registrert flere enn 2 karantener på din bruker, og denne karantenen vil vare i 14 dager.
		Spørsmål angående denne avgjørelsen kan sendes på epost: ". $eposten['Epost'].".";
	}
	
	if($nivaet == 1){
		$sql = "INSERT INTO karantener VALUES(:bruker, :epost, :dato, :nivaet)";
	}else{	
		$sql = "UPDATE karantener SET brukernavn=:bruker, epost=:epost, dato=:dato, niva=:nivaet WHERE Brukernavn=:bruker";
	}
	$stmt = $db->prepare($sql);
	$stmt->bindParam('bruker', $bruker);
	$stmt->bindParam('epost', $epost);
	$stmt->bindParam('dato', $dager);
	$stmt->bindParam('nivaet', $nivaet);
	$stmt->execute();

	$melding = "Det er blitt registrert en karantene på bruker: ". $bruker ." av administrator: ". $_SESSION['Brukernavn'] . ".";
	$sporring = "INSERT INTO Systemmeldinger VALUES(DEFAULT ,'Karantene', NOW(), :melding)";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam('melding', $melding);
	$stmt->execute();

	$sql = "SELECT Epost FROM bruker WHERE Brukernavn=:bruker;";
	$statement = $db->prepare($sql);
	$statement->bindParam('bruker', $bruker);
	$statement->execute();
	$rad = $statement->fetch(PDO::FETCH_ASSOC);

	date_default_timezone_set("Europe/Oslo");
	$headers = "From: " . $eposten['Epost'] . "\r\n" .
				'X-Mailer: PHP/' . phpversion() . "\r\n" .
				"MIME-Version: 1.0\r\n" .
				"Content-Type: text; charset=utf-8\r\n" .
				"Content-Transfer-Encoding: 8bit\r\n\r\n";
	mail($rad['Epost'], 'Karantene', $meldingen, $headers); 

}elseif(isset($_POST['fjernKarant'])){
	$bruker = $_POST['fjernKarant'];
	$sporring = "UPDATE karantener SET dato = NULL WHERE Brukernavn=:bruker;";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam('bruker', $bruker);
	$stmt->execute();

	$melding = "Administrator: ". $_SESSION['Brukernavn']. " har fjernet karantenen på bruker: ". $bruker .".";
	$sporring = "INSERT INTO Systemmeldinger VALUES(DEFAULT ,'Karantene', NOW(), :melding)";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam('melding', $melding);
	$stmt->execute();
	echo($melding);


}elseif(isset($_POST['fjernNyhet'])){
	$nyhet = $_POST['fjernNyhet'];
	$sporring = "DELETE FROM nyheter WHERE nyhetID=:nyhet;";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam('nyhet', $nyhet);
	$stmt->execute();

	$melding = "En nyhet er blitt slettet av administrator: ". $_SESSION['Brukernavn']. ".";
	$sporring = "INSERT INTO Systemmeldinger VALUES(DEFAULT,'Nyhet fjernet', NOW(), :melding)";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam('melding', $melding);
	$stmt->execute();


}else{
	$arrangementet = $_POST['arrangementet'];
	$sporring = "DELETE FROM paameldinger WHERE arrangementID=:arr;";
	$statement = $db->prepare($sporring);
	$statement->bindParam('arr', $arrangementet);
	$statement->execute();
	$sql = "DELETE FROM arrangementer WHERE arrangementID=:arrangement;";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('arrangement', $arrangementet);
	$stmt->execute();

	$melding = "Et arrangement er slettet av administrator: ". $_SESSION['Brukernavn']. ".";
	$sporring = "INSERT INTO Systemmeldinger VALUES(DEFAULT ,'Arrangement fjernet', NOW(), :melding)";
	$stmt = $db->prepare($sporring);
	$stmt->bindParam('melding', $melding);
	$stmt->execute();

}
header("Location: ../adminRapporter.php");
?>