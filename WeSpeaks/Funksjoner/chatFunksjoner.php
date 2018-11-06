<?php
/*Denne siden er sist endret 23.02.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ole*/

// Henter meldingen
function hentMelding(){
    global $db;
    $query = "SELECT * FROM chat";
    $stmt = $db->prepare($query);
    $stmt->execute();


    while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<div id='meldingsRamme'>" . '<small>' . $rad["dato"] . '</small>'. '<br>' . '<strong>' . $rad["brukernavn"] . '</strong>' . ": " . $rad["melding"] . "</div>";
    }
}


// Sender meldingen
function sendMelding($melding){
    global $db;
    global $brukernavn;
    if (!empty($brukernavn) && !empty($melding)) {
        $query = "INSERT INTO chat VALUES (null, CURRENT_TIMESTAMP(), :meldinger, '$brukernavn');";
        $stmt = $db->prepare($query);
        $stmt->bindParam('meldinger', $melding);
        $stmt->execute();
        return true;
    }else{
        return false;
    }
}
?>












