<?php
/*Denne siden er sist endret 25.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan*/

function skrivRegler($tekst){
    if(!empty($tekst)) {
        global $db;
        $query = "SELECT * FROM regler";
        $stmt = $db->prepare($query);
        $stmt->execute();
		$rad = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rad == null) {
            $query = "INSERT INTO regler VALUES (null, :tekst);";
            $stmt = $db->prepare($query);
            $stmt->bindParam('tekst', $tekst);
            $stmt->execute();
        }else{
			$regelID = $rad['regelID'];
			$query = "UPDATE regler SET tekst=:teksten WHERE regelID =:regel;";
			$stmt = $db->prepare($query);
			$stmt->bindParam('teksten', $tekst);
			$stmt->bindParam('regel', $regelID);
			$stmt->execute();
        }
		// Skriver til filen
		$header = file_get_contents("Includes/reglerHeader.html");
		$footer = file_get_contents("Includes/reglerFooter.html");
		$handle = fopen("Html/regler.html",'w');
		fwrite($handle, $header);
		fwrite($handle,"<div id='reglene'><h1 id='reglerWS'>Regler for bruk av WeSpeaks</h1><pre>".$tekst."</pre></div></body>");
		fwrite($handle, $footer);
		fwrite($handle, "</html>");
		fclose($handle);
		
		$meldingen = "Reglene for nettstedet er blitt endret av administrator: " . $_SESSION['Brukernavn'] . ".";
		$sql = "INSERT INTO systemmeldinger VALUES(DEFAULT, 'Regler endret', NOW(), :melding)";
		$statement = $db->prepare($sql);
		$statement->bindParam('melding', $meldingen);
		$statement->execute();
    }
}

function hentRegler(){
    global $db;
    $query = "SELECT * FROM regler";
    $stmt = $db->prepare($query);
    $stmt->execute();

    while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo $rad["tekst"] . "\n";
    }
}

?>


