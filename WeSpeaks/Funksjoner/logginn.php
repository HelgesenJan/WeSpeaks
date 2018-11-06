<?php
/*Denne siden er sist endret 22.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Ketil*/

//oppretter kobling mot db
include("dbkobling.php");
include("Krypter.php");
$db = new Kobling();

session_start();

$brukernavn = $_POST["Brukernavn"];
$passord = $_POST["Passord"];
$kryptPassord = Krypter($passord);

$brukersql = "SELECT Brukernavn, Passord, Brukertype FROM bruker WHERE Brukernavn=:bruker;";
$brukerstmt = $db->prepare($brukersql);
$brukerstmt->bindParam('bruker', $brukernavn);
$brukerstmt->execute();

$brukerRad = $brukerstmt->fetch(PDO::FETCH_ASSOC);

$ipsql = "SELECT Brukernavn, feilLoginnSiste, feilLoginnTeller, feilIP FROM ipOversikt WHERE Brukernavn=:bruker;";
$ipstmt = $db->prepare($ipsql);
$ipstmt->bindParam('bruker', $brukernavn);
$ipstmt->execute();

$sporring = "SELECT dato FROM karantener WHERE brukernavn=:bruker";
$stmt = $db->prepare($sporring);
$stmt->bindparam('bruker', $brukernavn);
$stmt->execute();
$raden = $stmt->fetch(PDO::FETCH_ASSOC);

$ipRad = $ipstmt->fetch(PDO::FETCH_ASSOC);
$tid = $ipRad['feilLoginnSiste'];
$teller = $ipRad['feilLoginnTeller'];
$naatid = time();
$reset = $naatid - strtotime($tid);
$sjekkIP = $ipRad['feilIP'];
$brukerIP = $_SERVER['REMOTE_ADDR'];


if($reset > 900 && $tid != null && $brukerIP == $sjekkIP){
    $stmt = $db->prepare("UPDATE ipOversikt SET feilLoginnTeller = 0 WHERE Brukernavn=:bruker");
    $stmt->bindParam('bruker', $brukernavn);
    $stmt->execute();
    $teller = 0;
}


if($teller < 5 || ($teller > 4 && $brukerIP != $sjekkIP) ){
    if ($brukerstmt->rowCount() == 1) {
        if ($kryptPassord == $brukerRad['Passord'] and $brukerRad['Brukertype'] == 0) {
			if($raden['dato'] == null || ($raden['dato'] < date("Y-m-d h:i:s", time()))){
				$_SESSION["Logg inn"] = "OK";
				$_SESSION["Brukernavn"] = $brukerRad['Brukernavn'];
				$redirect = "../hjem.php";
			}else{
				$no = new DateTime(date("Y-m-d h:i:s", time()));
				$datoen = new DateTime($raden['dato']);
				$ventetid = $no->diff($datoen);
				$ventetiden = $ventetid->format("%H:%I:%S");
				$_SESSION["Tilbakemelding"] = "Din konto er satt i karantene. Tid som gjenstår av din karantene: ". $ventetiden.".";
				$redirect = "../default.php";
			}
        } else if ($kryptPassord == $brukerRad['Passord'] and $brukerRad['Brukertype'] == 1) {
            $_SESSION["Logg inn"] = "OK";
            $_SESSION["Brukernavn"] = $brukerRad['Brukernavn'];
            $redirect = "../admin.php";
        } else {
            $_SESSION["Tilbakemelding"] = "Brukernavn eller passord er feil.";
            $naatid = date("Y-m-d H:i:s");
            if($ipstmt->rowCount() > 0){
                $statement = $db->prepare("UPDATE ipOversikt SET feilLoginnTeller = feilLoginnTeller+1, feilLoginnSiste =:naatid, feilIP =:ipadresse WHERE Brukernavn=:bruker ");
                $statement->bindParam('bruker', $brukernavn);
                $statement->bindParam('naatid', $naatid);
                $statement->bindParam('ipadresse', $brukerIP);
                $statement->execute();
            } else {
                $telleren = 1;
                $statement = $db->prepare("INSERT INTO ipOversikt(feilLoginnTeller, feilLoginnSiste, feilIP, Brukernavn) VALUES (:teller,:naatid,:ipadresse,:bruker)");
                $statement->bindParam('teller', $telleren);
                $statement->bindParam('bruker', $brukernavn);
                $statement->bindParam('naatid', $naatid);
                $statement->bindParam('ipadresse', $brukerIP);
                $statement->execute();
            }
			$redirect = "../default.php";
        }
    } else {
        $_SESSION["Tilbakemelding"] = "Brukernavn eller passord er feil.";
        $redirect = "../default.php";
    }
} else {
    $_SESSION["Tilbakemelding"] = "Du har overskridet maks antall innloggingsforsøk, prøv igjen om noen minutter.";
    $redirect = "../default.php";
}

header("Location: $redirect");
?>