<?php
/*Denne siden er sist endret 17.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ketil*/

include("dbkobling.php");
$db = new Kobling();

// Henter arrangementer
function hentArrangement(){
    global $db;
    global $brukernavn;
    $query = "SELECT * FROM arrangementer AS a INNER JOIN paameldinger AS p ON (a.arrangementID = p.arrangementID) WHERE p.brukernavn='$brukernavn';";
    $stmt = $db->prepare($query);
    $stmt->execute();

    while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
        if(($rad["paameldt"] != "Deltar ikke") && ($rad["brukernavn"] == $brukernavn)) {
            echo "<div class='meldingsRamme'>" ."Arrangementnavn: " .  $rad["navn"] . "<br><br>" . "Arrangør: " . $rad["arrangor"] . "<br><br>" . "Sted: " . $rad["sted"] . "<br><br>" . "Tid: " . $rad["tid"] . "<br><br>" . "Beskrivelse: " . $rad["beskrivelse"] . "</div><br>";
        }
    }
}

// Henter opprettede arrangementer
function hentBrukersArrangementer(){
    global $db;
    global $brukernavn;
    $query = "SELECT * FROM arrangementer WHERE arrangor='$brukernavn';";
    $stmt = $db->prepare($query);
    $stmt->execute();

    while($rad = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $teller = 0;
		$kanskje = true;
        $nyvar = $rad["arrangementID"];
        $sql = "SELECT paameldt, brukernavn FROM paameldinger WHERE arrangementID='$nyvar' AND paameldt!='Deltar ikke' ORDER BY paameldt ASC;";
        $sporring = $db->prepare($sql);
        $sporring->execute();
        echo "<div class='brukersArrangementer'>" .
            "<p class='pTekst'>Arrangementnavn: ". $rad["navn"] . "</p><br>
                 <p class='pTekst'>Arrangør: " . $rad["arrangor"] . "</p><br>
                 <p class='pTekst'>Sted: " . $rad["sted"] . "</p><br>
                 <p class='pTekst'>Tid: " . $rad["tid"] . "</p><br>
                 <p class='pTekst'>Beskrivelse: " . $rad["beskrivelse"] . "</p><br>";

        while($nyrad = $sporring->fetch(PDO::FETCH_ASSOC)){
            if($nyrad["paameldt"] == "Kanskje"){
				if($kanskje){
					echo "<br><p class='pTekst'>Kanskje: </p>";
					$kanskje = false;
				}
                $teller = 0;
				
            }else if($teller==0 && $nyrad["paameldt"] == "Deltar"){
                echo "<p class='pTekst'>Deltar: </p>";
                $teller = 1;
            }
            echo  "<p class='pTekst'>" . $nyrad['brukernavn'] . "</p>";
        }
        echo "</div>";
    }
}






