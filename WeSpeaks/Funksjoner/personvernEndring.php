<?php 
/*Denne siden er sist endret 31.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ole*/

include("dbkobling.php");
$db = new Kobling();

session_start();

// Bekreft knapp for gjennomgang av php
	if(isset($_POST['Bekreft'])){

		if(isset($_POST["studiePost"])){
            $studie = $_POST["studiePost"];
		    if($studie == true){
		        $studie = 1;
            }else{
		        $studie = 0;
            }
        }
        if(isset($_POST["interessePost"])){
		    $interesse = $_POST["interessePost"];
		    if($interesse == true){
		        $interesse = 1;
            }else{
		        $interesse = 0;
            }
        }

		$query = "SELECT brukernavn FROM personvern WHERE brukernavn=:bruker";
		$statement = $db->prepare($query);
		$statement->bindParam('bruker', $_SESSION['Brukernavn']);
		$statement->execute();

		if ($statement->rowCount() == 0){
			$stmt = $db->prepare("INSERT INTO personvern (brukernavn, skjulInteresse, skjulStudium) VALUES (:bruker, :interesse, :studium)");
			$stmt->bindParam('bruker', $_SESSION['Brukernavn']);
			$stmt->bindParam('interesse', $interesse);
            $stmt->bindParam('studium', $studie);
			$stmt->execute();
		} else {
			$stmt = $db->prepare("UPDATE personvern SET skjulInteresse=:interessen, skjulStudium=:studiumet WHERE brukernavn=:bruker");
			$stmt->bindParam('bruker', $_SESSION['Brukernavn']);
			$stmt->bindParam('interessen', $interesse);
			$stmt->bindParam('studiumet', $studie);
			$stmt->execute();
		}
	}

	if(isset($_POST["slettBekreft"])){
            // Sletter bruker sine påmeldinger
            $slettPaameldinger = "DELETE FROM paameldinger WHERE brukernavn=:paameldingBruker";
            $paameldingerStmt = $db->prepare($slettPaameldinger);
            $paameldingerStmt->bindParam('paameldingBruker',$_SESSION["Brukernavn"]);
            $paameldingerStmt->execute();

            // Fjerner brukere som er påmeldt bruker sine arrangementer
            $slettBrukersPaameldte = "DELETE FROM paameldinger WHERE arrangementID IN(SELECT arrangementID FROM arrangementer WHERE arrangor=:arrangorBruker)";
            $brukersPaameldteStmt = $db->prepare($slettBrukersPaameldte);
            $brukersPaameldteStmt->bindParam('arrangorBruker', $_SESSION["Brukernavn"]);
            $brukersPaameldteStmt->execute();

            // Sletter bruker sine arrangementer
            $slettArrangementer = "DELETE FROM arrangementer WHERE arrangor=:arrangementBruker";
            $brukersArrangementerStmt = $db->prepare($slettArrangementer);
            $brukersArrangementerStmt->bindParam('arrangementBruker', $_SESSION["Brukernavn"]);
            $brukersArrangementerStmt->execute();

            // Sletter bruker sine interesser
            $slettInteresser = "DELETE FROM brukersinteresser WHERE brukernavn=:interesseBruker";
            $interesseStmt = $db->prepare($slettInteresser);
            $interesseStmt->bindParam('interesseBruker',$_SESSION["Brukernavn"]);
            $interesseStmt->execute();

            // Sletter bruker sine studier
            $slettStudier = "DELETE FROM studier WHERE brukernavn=:studierBruker";
            $studierStmt = $db->prepare($slettStudier);
            $studierStmt->bindParam('studierBruker', $_SESSION["Brukernavn"]);
            $studierStmt->execute();

            // Sletter bruker sine personverninnstillinger
            $slettPersonvern = "DELETE FROM personvern WHERE brukernavn=:personvernBruker";
            $personvernStmt = $db->prepare($slettPersonvern);
            $personvernStmt->bindParam('personvernBruker', $_SESSION["Brukernavn"]);
            $personvernStmt->execute();

            // Sletter bruker sin profil
            $slettProfil= "DELETE FROM profil WHERE Brukernavn=:profilBruker;";
            $profilStmt = $db->prepare($slettProfil);
            $profilStmt->bindParam('profilBruker', $_SESSION["Brukernavn"]);
            $profilStmt->execute();

            // Sletter bruker sine meldinger i chat
            $slettChat = "DELETE FROM chat WHERE brukernavn=:brukerChat";
            $chatStmt = $db->prepare($slettChat);
            $chatStmt->bindParam('brukerChat', $_SESSION["Brukernavn"]);
            $chatStmt->execute();

            // Sletter bruker sine lagrede innloggingsforsøk
            $slettIP = "DELETE FROM ipoversikt WHERE Brukernavn=:brukerIP";
            $ipStmt = $db->prepare($slettIP);
            $ipStmt->bindParam('brukerIP', $_SESSION["Brukernavn"]);
            $ipStmt->execute();
			
			// Sletter bruker fra karantener
			$slettKarantene = "DELETE FROM karantener WHERE brukernavn=:brukerKara";
			$karaStmt = $db->prepare($slettKarantene);
			$karaStmt->bindParam('brukerKara', $_SESSION['Brukernavn']);
			$karaStmt->execute();

            // Logger brukeren av
            $bruker = $_SESSION["Brukernavn"];
            session_unset();
            session_destroy();
            // Sletter brukeren
            $slettBruker = "DELETE FROM bruker WHERE Brukernavn=:bruker";
            $brukerStmt = $db->prepare($slettBruker);
            $brukerStmt->bindParam('bruker', $bruker);
            $brukerStmt->execute();
			session_start();
			$_SESSION['Tilbakemelding'] = "Din bruker ble slettet.";
            header("Location: ../default.php");

    }
header("Location: ../personvern.php");
?>
