<?php
/*Denne siden er sist endret 01.06.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ole*/

include("dbkobling.php");
$db = new Kobling();


// Henter nyheter.
function hentNyheter(){
    global $db;
    $antallNyheterPerSide = 2;


    // Kalkulerer rader i nyheter
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM nyheter";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    // Henter ut antall rader i nyheter.
    $query = "SELECT FOUND_ROWS()";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $antallRader = $stmt->fetchColumn() / 2;    // Deler på 2 fordi 1 rad har 2 nyheter i tabellen.

    // Lager en sjekk på om radene er et oddetall. Om det er det legges det til en rad.
    // Jeg ganger med 2 slik at beregningen ikke blir feil etter delinga som ble gjort tidligere.
    if(($antallRader * 2) % 2 != 0){
        $antallRader +=1;
    }else{
        $antallRader = $antallRader;
    }

    
    // Finner hvilken side bruker er på
    if(!isset($_GET["page"])){
        $side = 1;
    }else{
        $side = $_GET["page"];
    }


	
    // PC/TABLET VERSJON
    // Lager et startpunkt for hver side
    $startpunkt = ($side-1) * $antallNyheterPerSide;

    // Henter data og setter et startpunkt for hver side.
    $query = "SELECT * FROM nyheter LIMIT " . $startpunkt . ", " . $antallNyheterPerSide;
    $stmt = $db->prepare($query);
    $stmt->execute();

    $th = $kol = "";
    while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
        $th .= "<th><p class='h1p'>" . $rad["overskrift"] . '<p class="dato"><small>' . $rad["dato"] . '</small></p>'. "</p></th>";
        $kol .= "<th class='th'>" . $rad["informasjon"] . "</th>";
    }
    echo "<table id='pcTablet'><tr>" . $th . "</tr><tr>" . $kol . "</tr></table>";



    // Henter sidene og setter link til dem.
    echo '<div id="pagineringHolder">';
    if($side != 1 && $side > 1){
        echo '<a href="hjem.php?page=' . ($side-1) . '"><button class="paginering"> << </button></a>';
    }else{
        echo '<a href="hjem.php?page=' . ($side) . '"><button class="paginering"> << </button></a>';
    }

    for($side = 1; $side <= $antallRader; $side++){
        echo '<a href="hjem.php?page=' . $side . '"><button class="paginering">' . $side . '</button></a>';
    }

    // re-initialiserer $side
    if(!isset($_GET["page"])){
        $side = 1;
    }else{
        $side = $_GET["page"];
    }

    // sjekker om antall rader i nyheter er en integer
    if($side < is_int($antallRader)){
        echo '<a href="hjem.php?page=' . ($side+1) . '"><button class="paginering"> >> </button></a>';
    }else if($side < $antallRader - 0.5){
        echo '<a href="hjem.php?page=' . ($side+1) . '"><button class="paginering"> >> </button></a>';
    }else{
        echo '<a href="hjem.php?page=' . ($side) . '"><button class="paginering"> >> </button></a>';
    }

    echo '</div>';


    // MOBILVERSJON
	
    // Henter data og setter et startpunkt for hver side.
    $query = "SELECT * FROM nyheter";
    $stmt = $db->prepare($query);
    $stmt->execute();
	
	echo "<div id='skall'><div id='responsivMobil'><table id='mobil'><tr>";
	while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo "<th class='h1p'><p class='overskrift'>" . $rad["overskrift"] . '<p class="dato"><small>' . $rad["dato"] . '</small></p><p class="informasjonen">' . $rad["informasjon"] . "</p></th>";
	}
	echo "</tr></table></div></div>";

}



// Oppretter nyhet
function opprettNyhet($overskrift, $informasjon){
    global $db;

    // Kalkulerer rader i nyheter
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM nyheter";
    $stmt = $db->prepare($query);
    $stmt->execute();

    // Henter ut antall rader i nyheter.
    $query = "SELECT FOUND_ROWS()";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $antallRader = $stmt->fetchColumn();

    if (!empty($overskrift) && !empty($informasjon) && $antallRader <= 5) { // Setter en grense for maks antall nyheter på 6.
        $query = "INSERT INTO nyheter VALUES (null, CURRENT_TIMESTAMP(), :overskrift, :informasjon);";
        $stmt = $db->prepare($query);
        $stmt->bindParam('overskrift', $overskrift);
        $stmt->bindParam('informasjon', $informasjon);
        $stmt->execute();
        return true;
    }else{
        return false;
    }
}

// Sletter nyhet
function slettNyhet($nyhetID){
    global $db;
    $query = "SELECT nyhetID FROM nyheter WHERE nyhetID = :nyhetID";
    $stmt = $db->prepare($query);
    $stmt->bindParam('nyhetID', $nyhetID);
    $stmt->execute();
    if($antallRader = $stmt->fetch(PDO::FETCH_ASSOC) != null){
        if (!empty($nyhetID)) {
            $query = "DELETE FROM nyheter WHERE nyhetID = :nyhetID";
            $stmt = $db->prepare($query);
            $stmt->bindParam('nyhetID', $nyhetID);
            $stmt->execute();
        }
        return true;
    }else{
        return false;
    }
}

?>













