<?php
/*Denne siden er sist endret 17.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Hamta*/

include("dbkobling.php");
$db = new Kobling();



function opprettArrangement($navn, $sted, $tid, $beskrivelse){
    global $db;
    global $brukernavn;
    $query = "SELECT * FROM arrangementer WHERE navn = :navn";
    $stmt = $db->prepare($query);
    $stmt->bindParam("navn", $navn);
    $stmt->execute();

    if($stmt->rowCount() <= 0){
        if(!empty($navn) && !empty($sted) && !empty($tid) && !empty($beskrivelse)){
            $query = "INSERT INTO arrangementer VALUES(null, :navn,'$brukernavn',:sted, :tid, :beskrivelse);";
            $stmt = $db->prepare($query);
            $stmt->bindParam('navn', $navn);
            $stmt->bindParam('sted', $sted);
            $stmt->bindParam('tid', $tid);
            $stmt->bindParam('beskrivelse', $beskrivelse);
            $stmt->execute();
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }


}

function hentArrangementer(){
    global $db;
    $query = "SELECT * FROM arrangementer";
    $stmt = $db->prepare($query);
    $stmt->execute();
    echo "<div class='arrangementRamme'>";
    while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo '<form action="arrangement.php" method="POST">
                <table class="excl"><tr>
                    <td class="text">' . "Navn: " . $rad["navn"] . '</td>
                    <td class="text">' . "Arrangør: " . $rad["arrangor"] . '</td>
                    <td class="text">' . "Sted: " . $rad["sted"] . '</td>
                    <td class="text">' . "Tid: " . $rad["tid"] . '</td>
                    <td class="text">' . "Beskrivelse: " . $rad["beskrivelse"] . '</td>
                    <input type="hidden"  name="arrangement" value="' . $rad["arrangementID"] . '"/>
                    <td><div class="sentrering"><input name="paamelding" class="viddeKnappene" type="submit" value="Deltar" />
                    <input name="paamelding" class="viddeKnappene" type="submit" value="Deltar ikke" />
                    <input name="paamelding" class="viddeKnappene" type="submit" value="Kanskje" /></div></td>
                </tr></table>
            </form>';
    }
    echo "</div>";
}


function oppmelding($arrangement, $paamelding){
	global $db;
    global $brukernavn;

    if(!empty($brukernavn) && (!empty($paamelding) && (!empty($arrangement)))){
        $query = "SELECT * FROM paameldinger WHERE arrangementID='$arrangement' AND brukernavn='$brukernavn';";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $rad = $stmt->fetch(PDO::FETCH_ASSOC);

        if($rad==0){
            $query = "INSERT INTO paameldinger VALUES (:arrangement , '$brukernavn', :paameldt);";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':paameldt', $paamelding);
            $stmt->bindParam(':arrangement',$arrangement);
            $stmt->execute();
        }else{
            $query = "UPDATE paameldinger SET paameldt='$paamelding' WHERE arrangementID='$arrangement' AND brukernavn='$brukernavn'";
            $stmt = $db->prepare($query);
            $stmt->execute();
        }

        return true;
    }else{
        return false;
    }
}


?>


