<!-- Denne siden er utviklet av Ole, siste gang endret 23.02.2018 -->

<?php
if(isset($_GET["id"])){
    $brukernavn = $_GET["id"];
}else{
    $brukernavn = $_SESSION["Brukernavn"];
}

function lagTabellInteresse(){
	unset($_SESSION['Tilbakemelding']);
	global $db;
	if(isset($_GET["id"])){
        $brukernavn = $_GET["id"];
    }else{
        $brukernavn = $_SESSION["Brukernavn"];
    }
		$sporring = "SELECT interesse FROM brukersInteresser WHERE brukernavn='$brukernavn';";
		echo("<table class='brukerInfo'>");
		$testdata = "";
		$teller = 0;
		
		foreach ($db->query($sporring) as $row) {
			if($teller == 0){
				echo("<tr>");
			}
			echo("<form method='POST' action='Funksjoner/interesseFunksjoner.php'>");
			$verdien = str_replace(' ', '_', $row['interesse']);
			echo("<td><input style='display: none' name='interessen' value=".$verdien.">");
			echo("<input style='display: none' name='interessen' value=".$verdien.">");
			$utdata = $row['interesse'];
			if(!isset($_GET["id"])){
                echo($utdata) . "<button class='knapp' name='slett'>Slett</button>";
            }else{
                echo($utdata);
            }

			$testdata .= $row['interesse'];
			echo("</td>");
			echo("</form>");
			if($teller == 1){
				echo("</tr>");
				$teller = 0;
			} else{
				$teller = 1;
			}
		}
		if($testdata == ""){
			echo("Du har enda ikke registrert dine interesser!");
		}
		echo("</table>");
}

function lagTabellStudium(){
	global $db;
	if(isset($_GET["id"])){
        $brukernavn = $_GET["id"];
    }else{
        $brukernavn = $_SESSION["Brukernavn"];
    }
		$sporring = "SELECT studium, grad, skole, arskull FROM studier WHERE brukernavn='$brukernavn';";
		echo("<table class='brukerInfo'>");
		$testdata = array();
		
		foreach ($db->query($sporring) as $row) {
			echo("<tr>");
			echo("<form method='POST' action='Funksjoner/studiumFunksjoner.php'>");
			$verdien = str_replace(' ', '_', $row['studium']);
			echo("<td><input style='display: none' name='studiumet' value=".$verdien.">");
			$utdata = $row;
			echo("Studium: " . $utdata['studium'] .  ", grad: " . $utdata['grad'] . ", skole: " . $utdata['skole'] . ", årskull: " . $utdata['arskull']);
			if(!isset($_GET["id"])){
			    echo("<button class='knapp' name='slett'>Slett</button>");
            }
			array_push($testdata, $row);
			echo("</td>");
			echo("</form>");
		}
		if(empty($testdata)){
		    if(!isset($_GET["id"])){
                echo("Du har enda ikke registrert dine studium!");
            }else{
		        echo($brukernavn) . " har ikke registrert studium";
            }
		}
		echo("</table>");
}

function hentBeskrivelse(){
	global $db;
	if(isset($_GET["id"])){
        $brukernavn = $_GET["id"];
    }else{
        $brukernavn = $_SESSION["Brukernavn"];
    }
		$sql = "SELECT Beskrivelse FROM profil WHERE Brukernavn='$brukernavn';";
		foreach ($db->query($sql) as $row) {
			if(empty($row["Beskrivelse"])){
			    if(isset($_GET["id"])){
			        echo($brukernavn . " har ikke laget en beskrivelse av seg selv");
                }else{
                    echo("Du har ikke laget en beskrivelse av deg selv!");
                }
			}else{
				echo($row["Beskrivelse"]);
			}
		}
}

function hentInteresseValg(){
	echo('<form method="POST" action="Funksjoner/interesseFunksjoner.php" class="studieOgInteresseForm" id="interesseForm">');
	global $db;
	$sql = "SELECT interesse FROM interesser WHERE interesse NOT IN(SELECT interesse FROM brukersInteresser WHERE brukernavn=:bruker)";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('bruker', $_SESSION['Brukernavn']);
	$stmt->execute();
	echo('<p>Hold nede ctrl for å velge flere interesser.</p>');
	echo('<select id="velgInteresser" name="interesser[]" multiple size=15>');
	while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo('<option value="'.$rad['interesse'].'">'.$rad['interesse'].'</option>');
	}
	echo('</select>');
	echo('<button type="button" class="knapp" id="avbrytInteresse" onclick="avbrytInteresseForm()">Avbryt</button>
	<input type="submit" name="Lagre" id="lagreInteresse" value="Lagre" class="knapper" required><br></form>');
	
	echo('<div id="manglerInteresser"><p>Mangler listen dine interesser? Legg til flere: </p>');
	echo('<input type="text" id="nyInteresse"><button type="button" class="knapp" onclick="leggTilListen()">Legg til listen</button></div>');
}
?>
