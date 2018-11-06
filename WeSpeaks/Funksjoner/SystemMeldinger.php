<?php
/*Denne siden er sist endret 24.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan*/

function hentTabellen(){
	global $db;
	$sql = "SELECT meldingsID, tittel, dato FROM SystemMeldinger WHERE meldingsID NOT IN(SELECT meldingsID FROM lestmelding WHERE brukernavn=:bruker) ORDER BY dato DESC;";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('bruker', $_SESSION['Brukernavn']);
	$stmt->execute();
	$teller = 0;
	if($stmt->rowCount() > 0){
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo('<form method="POST" id="'. $teller .'" action="Funksjoner/Innboks.php" target="meldingsVisning">');
			echo('<tr class="Data" onclick="visMelding('. $teller .')"><td class="tabellPadding">');
			echo('<input type="hidden" id="melding" name="meldingen" value="'.$row['meldingsID'].'"/>');
			echo($row['tittel'] . '<br>' . $row['dato']);
			echo('</td></tr></form>');
			$teller = $teller + 1;
		}
	}else{
		echo('<p id="Tilbakemelding">Ingen meldinger å vise.</p>');
	}
}
function hentResponsiv(){
	global $db;
	$sql = "SELECT meldingsID, tittel, dato FROM SystemMeldinger WHERE meldingsID NOT IN(SELECT meldingsID FROM lestmelding WHERE brukernavn=:bruker) ORDER BY dato DESC;";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('bruker', $_SESSION['Brukernavn']);
	$stmt->execute();
	$teller = 0;
	if($stmt->rowCount() > 0){
		echo('<tr class="Data">');
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo('<form method="POST" id="'. $teller .'" action="Funksjoner/Innboks.php" target="meldingsVisning">');
			echo('<td class="tabellPadding" onclick="visMelding('. $teller .')">');
			echo('<input type="hidden" id="melding" name="meldingen" value="'.$row['meldingsID'].'"/>');
			echo($row['tittel'] . '<br>' . $row['dato']);
			echo('</td></form>');
			$teller = $teller + 1;
		}
		echo('</tr>');
	}else{
		echo('<p id="Tilbakemelding">Ingen meldinger å vise.</p>');
	}
}


function hentMelding($meldingen){
	global $db;
	$sql = "SELECT meldingsID, tittel, dato, tekst FROM SystemMeldinger WHERE meldingsID=:melding;";
	$statement = $db->prepare($sql);
	$statement->bindParam(':melding', $meldingen);
	$statement->execute();
	$rad = $statement->fetch(PDO::FETCH_ASSOC);
	if($statement->rowCount() > 0){
		echo("<div id='ramme'><p id='tittel'>Tittel: ".$rad['tittel']."</p>");
		echo("<p id='dato'>Dato: ".$rad['dato']."</p></div>");
		echo("<p id='teksten'>".$rad['tekst']."</p>");
		echo("<form method='POST' target='_parent' action='../admin.php'><button id='knappen' name='slett' value='". $rad['meldingsID'] ."'>Fjern melding</button></form>");
	}else{ 
		echo("Error: Finner ikke meldingen.");
	}
}
?>