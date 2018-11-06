<?php
/*Denne siden er sist endret 09.03.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Ketil*/

function brukerInfoTabell(){
	global $db;
	if(isset($_GET["id"])){
	    $brukernavn = $_GET["id"];
    }else{
        $brukernavn = $_SESSION["Brukernavn"];
    }
	$sql = "SELECT Fornavn, Etternavn, Campus, Fodselsdato, Land FROM profil WHERE brukernavn=:bruker";
	$stmt = $db->prepare($sql);
	$stmt->bindParam('bruker', $brukernavn);
	$stmt->execute();
	$rad = $stmt->fetch(PDO::FETCH_ASSOC);
	echo('<form method="POST" action="Funksjoner/endreBrukerinfo.php">');
	echo('<table id="brukerInfoTabell" class="user-info" cellspacing="0" cellpadding="0">');
		echo('<tbody>');
		echo('<tr>');
			echo('<th class="utseende"><i class="fa fa-user" aria-hidden="true"></i> Fornavn:</th>');
		echo('</tr><tr>');
			echo('<td class="brukerInfo utseende">');
				echo('<div class="hentetBrukerInfo">'.$rad["Fornavn"].'</div>');
				echo('<input name="Fornavn" id="fornavn" class="brukerInput" maxlength="50">');
			echo('</td>');
		echo('</tr><tr>');
			echo('<th class="utseende"><i class="fa fa-user" aria-hidden="true"></i> Etternavn:</th>');
		echo('</tr><tr>');
			echo('<td class="brukerInfo utseende">');
				echo('<div class="hentetBrukerInfo">'.$rad["Etternavn"].'</div>');
				echo('<input name="Etternavn" id="etternavn" class="brukerInput" maxlength="50">');
			echo('</td>');
		echo('</tr><tr>');
			echo('<th class="utseende"><i class="fa fa-building-o " aria-hidden="true"></i> Campus:</th>');
		echo('</tr><tr>');
			echo('<td class="brukerInfo utseende">');
				echo('<div class="hentetBrukerInfo">'.$rad["Campus"].'</div>');
				echo('<select name="Campus" id="campus" class="brukerInput">');
					if(!isset($rad["Campus"])){
						echo('<option value="" disable selected>Velg Campus</option>');
					}
					echo('<option value="Ringerike">Ringerike</option>');
					echo('<option value="Bø">Bø</option>');
					echo('<option value="Drammen">Drammen</option>');
					echo('<option value="Kongsberg">Kongsberg</option>');
					echo('<option value="Porsgrunn">Porsgrunn</option>');
					echo('<option value="Rauland">Rauland</option>');
					echo('<option value="Vestfold">Vestfold</option>');
				echo('</select>');
			echo('</td>');
		echo('</tr><tr>');
			echo('<th class="utseende"><i class="fa fa-calendar" aria-hidden="true"></i> Fødselsdato:</th>');
		echo('</tr><tr>');
			echo('<td class="brukerInfo utseende">');
				echo('<div id="uformatertDato">'.$rad["Fodselsdato"].'</div>');
				echo('<div class="hentetBrukerInfo" id="hentetFodselsdato">');
				if(!empty($rad["Fodselsdato"])){
					echo(date("d-m-Y", strtotime($rad["Fodselsdato"])));
				}
				echo('</div><input type="date" name="Fodselsdato" id="fodselsdato" class="brukerInput"></td>');        	
		echo('</tr><tr>');
			echo('<th class="utseende"><i class="fa fa-flag" aria-hidden="true"></i> Land:</th>');
		echo('</tr><tr>');
			echo('<td class="brukerInfo utseende">');
				echo('<div class="hentetBrukerInfo">'.$rad["Land"].'</div>');
				echo('<input name="Land" id="land" class="brukerInput" maxlength="30">');
			echo('</td>');        	
		echo('</tr>');
		echo('</tbody>');
	echo('</table>');
	if(!isset($_GET["id"])){
        echo('<button type="button" id="avbrytBrukerInfo" class="knapp" onclick="avbrytInfoEndringer()">Avbryt endringer</button>');
        echo('<button type="button" id="knappBrukerInfo" class="knapp" onclick="infoEndringer()">Endre brukerinformasjon</button>');
        echo('<button type="submit" id="lagreInfo" class="knapp">Lagre endringer</button>');
    }
	echo('</form>');
}

?>
