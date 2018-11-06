<?php
/*Denne siden er sist endret 30.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Hamta*/

function fyllStudieSelect(){
    global $db;
    $query = "SELECT DISTINCT studium FROM studier;";
    $stmt = $db->prepare($query);
    $stmt->execute();

    echo "<option>Velg studie</option>";
    while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<option>" . $rad["studium"] . "</option>";
    }
}

function fyllInteresseSelect(){
    global $db;
    $query = "SELECT DISTINCT interesse FROM interesser;";
    $stmt = $db->prepare($query);
    $stmt->execute();

    echo "<option>Velg interesse</option>";
    while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<option>" . $rad["interesse"] . "</option>";
    }
}

function hentResultat(){
    global $db;
    $paaloggetBruker = $_SESSION["Brukernavn"];
    if(isset($_POST["studieSubmit"])){
        $select = $_POST["selectBoks"];
        $query = "SELECT brukernavn FROM studier WHERE studium = '$select'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        if($select != null && $select != "Velg studie"){
			$personvernStudium = "SELECT brukernavn FROM personvern WHERE skjulStudium=1;";
            $statement = $db->prepare($personvernStudium);
            $statement->execute();
            $sjekkRad = $statement->fetch(PDO::FETCH_ASSOC);
			$funnetResultat = false;
			
            $teller = 0;
            echo "<div class='resultatRamme'><ul>";
            echo "<h2 class='sokHeader'>Brukere innen studiet - $select: </h2>";
            echo "<table><tr>";
            while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
                if($teller == 5){
                    $teller = 0;
                    echo "</tr><tr>";
                }
                $bruker = $rad["brukernavn"];
                if($bruker != $paaloggetBruker){
                    if($rad["brukernavn"] != $sjekkRad["brukernavn"]){
						$funnetResultat = true;
                        echo "<td id='max'>" . $bruker . " -<a href='profilsideVisning.php?id=$bruker'> Profil</a></td>";
                    }
                }
                $teller ++;
            }
			if(!$funnetResultat){
				echo "<td>Brukerne med denne interessen har valgt å ikke vises i søk.</td>";
			}
            echo "</tr></table>";
            echo "</div>";

        }else{
            echo "<div class='resultatRamme'><h2 class='sokHeader'>Velg et studium </h2></div><br>";
        }
    }
    if(isset($_POST["interesseSubmit"])){
        $select = $_POST["selectBoks"];
        $query = "SELECT brukernavn FROM brukersInteresser WHERE interesse = '$select'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        if($select != null && $select != "Velg interesse"){
			$personvernInteresse = "SELECT brukernavn FROM personvern WHERE skjulInteresse=1;";
            $statement = $db->prepare($personvernInteresse);
            $statement->execute();
            $sjekkRad = $statement->fetch(PDO::FETCH_ASSOC);
			$funnetResultat = false;
		
            $teller = 0;
            echo "<div class='resultatRamme'><ul>";
            echo "<h2 class='sokHeader'>Brukere med interessen - $select: </h2>";
            echo "<table><tr>";
            while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
                if($teller == 5){
                    $teller = 0;
                    echo "</tr><tr>";
                }
                $bruker = $rad["brukernavn"];
                if($bruker != $paaloggetBruker){
                    if($rad["brukernavn"] != $sjekkRad["brukernavn"]){
						$funnetResultat = true;
                        echo "<td>" . $bruker . " -<a href='profilsideVisning.php?id=$bruker'> Profil</a></td>";
                    }
                }
                $teller ++;
            }
			if(!$funnetResultat){
				echo "<td>Brukerne med denne interessen har valgt å ikke vises i søk.</td>";
			}
            echo "</tr></table>";
            echo "</div>";
        }else{
            echo "<div class='resultatRamme'><h2 class='sokHeader'>Velg en interesse </h2></div><br>";
        }
    }
}





