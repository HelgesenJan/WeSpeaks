<?php
/*Denne siden er sist endret 18.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan*/

session_start();
if(!isset($_SESSION['Logg inn'])){
	if(!isset($default)){
		header("Location: default.php");
	}
}else{
	$brukernavn = $_SESSION['Brukernavn'];
	$sql = "SELECT Brukertype FROM bruker";
	$sql .= " WHERE Brukernavn=:brukeren;";
	$resultat = $db->prepare($sql);
	$resultat->bindParam('brukeren', $brukernavn);
	$resultat->execute();
	$rad = $resultat->fetch(PDO::FETCH_ASSOC);
	
	if($rad['Brukertype'] == 0 || $rad['Brukertype'] == 1){
		if(isset($_SESSION['Logg inn']) && $_SESSION['Logg inn']=="OK"){
			if(!isset($_SESSION['aktivitet']) || (time() - $_SESSION['aktivitet']) < 2000){
				if($rad['Brukertype'] == 0){
					if(!isset($aktivSide)){
						header("Location: hjem.php");
					}elseif(isset($aktiv) && $aktiv == "admin"){
						$melding = "Brukernavn: " . $brukernavn . " har forsøkt å logge seg inn på administrator sine sider.";
						$sql = "INSERT INTO systemmeldinger VALUES(DEFAULT, 'Forsøk på innlogging', NOW(), :meldingen)";
						$stmt = $db->prepare($sql);
						$stmt->bindParam('meldingen', $melding);
						$stmt->execute();
						session_unset();
						$_SESSION['Tilbakemelding'] = "Du er blitt logget ut.";
						header("Location: default.php");
					}
				}elseif($rad['Brukertype'] == 1){
					if(!isset($aktivSide)){
						header("Location: admin.php");
					}elseif(!isset($aktiv)){
						session_unset();
						$_SESSION['Tilbakemelding'] = "Du er blitt logget ut.";
						header("Location: default.php");
					}
				}else{
					session_unset();
					$_SESSION['Tilbakemelding'] = "En uventet feil oppstod.";
					header("Location: default.php");
				}
				$_SESSION['aktivitet'] = time();
			}else{
				session_unset();
				$_SESSION['Tilbakemelding'] = "Inaktiv periode har overstiget 30 minutter. Brukeren din ble automatisk avlogget.";
				header("Location: default.php");	
			}
		}else{
			if(!isset($default)){
				header("Location: default.php");
			}
		}
	}else{
		session_unset();
		session_destroy();
		if(!isset($default)){
			header("Location: default.php");
		}
	}
}
?>