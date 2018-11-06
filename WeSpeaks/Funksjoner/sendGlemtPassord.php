<?php
/*Denne siden er sist endret 30.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta*/

//oppretter kobling mot db
include("dbkobling.php");
include("Krypter.php");
$db = new Kobling();

session_start();
if(isset($_POST['epost'])){
	$passord = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
	$passord .= chr(rand(65, 90)) .chr(rand(65, 90)) . chr(rand(65, 90));
	$meldingen = "Du har fått et nytt passord for innlogging på WeSpeaks. Ditt nye passord er: " . $passord;
	$krypterpassord = Krypter($passord);
	$sql = "UPDATE bruker SET Passord=:passordet WHERE Epost=:eposten;";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('passordet', $krypterpassord);
	$stmt->bindParam('eposten', $_POST['epost']);
	$stmt->execute();
	date_default_timezone_set("Europe/Oslo");
	$headers = "From: " . "admin@wespeaks.no" . "\r\n" .
				'X-Mailer: PHP/' . phpversion() . "\r\n" .
				"MIME-Version: 1.0\r\n" .
				"Content-Type: text; charset=utf-8\r\n" .
				"Content-Transfer-Encoding: 8bit\r\n\r\n";
	
	if(mail($_POST['epost'], 'Glemt Passord', $meldingen, $headers)){
		$_SESSION['Tilbakemelding'] = "En epost med passordet er sendt til ". $_POST['epost'] .".";
	}else{
		$_SESSION['Tilbakemelding'] = "Eposten kunne ikke sendes. Sjekk epostadressen: " . $_POST['epost'] . ".";
	}
	
	
}else{
	$_SESSION['Tilbakemelding'] = "En uventet feil oppstod.";
}
header("Location: ../glemtPassord.php");
?>