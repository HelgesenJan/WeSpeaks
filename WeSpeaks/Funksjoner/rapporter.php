<?php  
/*Denne siden er sist endret 29.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta*/

function hentTabell(){
	date_default_timezone_set("Europe/Oslo");
	global $db;
	if(!isset($_POST['valget']) || $_POST['valget'] == "Brukere" && $_POST['sorterBruk'] == "Brukernavn"){
		$_POST['sortert'] = "Brukernavn";
		$sql = "SELECT Brukernavn, Epost FROM bruker ORDER BY Brukernavn";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$sporring = "SELECT Brukernavn FROM karantener WHERE dato != NULL or dato > NOW();";
		$statement = $db->prepare($sporring);
		$statement->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Brukernavn</th><th>Epost</th><th>Verktøy</th></tr></thead><tbody>');
		$karantener = array();
		while($element = $statement->fetch(PDO::FETCH_ASSOC)){
			array_push($karantener, $element);
		}
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
			$ingenting = false;
			$karaFinnes = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Brukernavn"><input type="hidden" name="karantene" value="'.$rad['Brukernavn'].'">'.$rad['Brukernavn'].'</td>');
			echo('<td data-label="Epost"><input type="hidden" name="epost" value="'.$rad['Epost'].'">'.$rad['Epost'].'</td><td data-label="Verktøy">');
			foreach($karantener as $bruker){
				if($bruker['Brukernavn'] == $rad['Brukernavn']){
					$karaFinnes = true;
				}
			}
			if(!$karaFinnes){
				echo('<button class="knapp">Karantene</button></td></tr></form>');
			}else{
				echo('</td></tr></form>');
			}
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen brukere</td></tr>');
		}
		echo('<tbody></table></div>');

	}else if($_POST['valget'] == "Brukere" && $_POST['sorterBruk'] == "Epost"){
		$_POST['sortert'] = "Epost";
		$sql = "SELECT Brukernavn, Epost FROM bruker ORDER BY Epost";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$sporring = "SELECT Brukernavn FROM karantener WHERE dato != NULL or dato > NOW();";
		$statement = $db->prepare($sporring);
		$statement->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Epost</th><th>Brukernavn</th><th>Verktøy</th></tr></thead><tbody>');
		$karantener = array();
		while($element = $statement->fetch(PDO::FETCH_ASSOC)){
			array_push($karantener, $element);
		}
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
			$karaFinnes = false;
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Epost"><input type="hidden" name="epost" value="'.$rad['Epost'].'">'.$rad['Epost'].'</td>');
			echo('<td data-label="Brukernavn"><input type="hidden" name="karantene" value="'.$rad['Brukernavn'].'">'.$rad['Brukernavn'].'</td><td data-label="Verktøy">');
			foreach($karantener as $bruker){
				if($bruker['Brukernavn'] == $rad['Brukernavn']){
					$karaFinnes = true;
				}
			}
			if(!$karaFinnes){
				echo('<button name="karantene" class="knapp">Karantene</button></td></tr></form>');
			}else{
				echo('</td></tr></form>');
			}
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen brukere</td></tr>');
		}
		echo('<tbody></table></div>');

	}else if($_POST['valget'] == "Arrangementer" && $_POST['sorterArr'] == "Arrangor"){
		$_POST['sortert'] = "Arrangor";
		$sql = "SELECT arrangementID, arrangor, navn FROM arrangementer ORDER BY Arrangor";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Arrangør</th><th>Arrangement</th><th>Verktøy</th></tr></thead><tbody>');
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){	
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Arrangør"><input type="hidden" name="arrangementet" value="'.$rad['arrangementID'].'">'.$rad['arrangor'].'</td>');
			echo('<td data-label="Arrangement">'.$rad['navn'].'</td>');
			echo('<td data-label="Verktøy"><button class="knapp">Slett</button></td></tr></form>');
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen arrangementer</td></tr>');
		}
		echo('<tbody></table></div>');

	}else if($_POST['valget'] == "Arrangementer" && $_POST['sorterArr'] == "Arrangement"){
		$_POST['sortert'] = "Arrangement";
		$sql = "SELECT arrangementID, arrangor, navn  FROM arrangementer ORDER BY navn";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Arrangement</th><th>Arrangør</th><th>Verktøy</th></tr></thead><tbody>');
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){	
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Arrangement"><input type="hidden" name="arrangementet" value="'.$rad['arrangementID'].'">'.$rad['navn'].'</td>');
			echo('<td data-label="Arrangør">'.$rad['arrangor'].'</td>');
			echo('<td data-label="Verktøy"><button class="knapp">Slett</button></td></tr></form>');
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen arrangementer</td></tr>');
		}
		echo('<tbody></table></div>');

	}else if($_POST['valget'] == "Karantener" && $_POST['sorterKara'] == "Brukernavn"){
		$_POST['sortert'] = "Brukernavn";
		$sql = "SELECT brukernavn, epost, dato, niva FROM karantener WHERE dato != null or dato > CURDATE() ORDER BY brukernavn";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Brukernavn</th><th>Epost</th><th>Dato</th><th>Nivå</th><th>Verktøy</th></tr></thead><tbody>');
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Brukernavn"><input type="hidden" name="fjernKarant" value="'.$rad['brukernavn'].'">'.$rad['brukernavn'].'</td>');
			echo('<td data-label="Epost">'.$rad['epost'].'</td>');
			echo('<td data-label="Dato">'.$rad['dato'].'</td>');
			echo('<td data-label="Nivå">'.$rad['niva'].'</td>');
			echo('<td data-label="Verktøy"><button class="knapp">Fjern</button></td></tr></form>');
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen karantener</td></tr>');
		}
		echo('<tbody></table></div>');

	}else if($_POST['valget'] == "Karantener" && $_POST['sorterKara'] == "Epost"){
		$_POST['sortert'] = "Epost";
		$sql = "SELECT brukernavn, epost, dato, niva FROM karantener WHERE dato !=  null or dato > CURDATE() ORDER BY epost";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Epost</th><th>Brukernavn</th><th>Dato</th><th>Nivå</th><th>Verktøy</th></tr></thead><tbody>');
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Epost">'.$rad['epost'].'</td>');
			echo('<td data-label="Brukernavn"><input type="hidden" name="fjernKarant" value="'.$rad['brukernavn'].'">'.$rad['brukernavn'].'</td>');
			echo('<td data-label="Dato">'.$rad['dato'].'</th>');
			echo('<td data-label="Nivå">'.$rad['niva'].'</td>');
			echo('<td data-label="Verktøy"><button class="knapp">Fjern</button></td></tr></form>');
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen karantener</td></tr>');
		}
		echo('<tbody></table></div>');

	}else if($_POST['valget'] == "Karantener" && $_POST['sorterKara'] == "Niva"){
		$_POST['sortert'] = "Niva";
		$sql = "SELECT brukernavn, epost, dato, niva  FROM karantener WHERE dato != NULL or dato > CURDATE() ORDER BY niva ASC";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Nivå</th><th>Brukernavn</th><th>Epost</th><th>dato</th><th>Verktøy</th></tr></thead><tbody>');
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){	
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Nivå">'.$rad['niva'].'</td>');
			echo('<td data-label="Brukernavn"><input type="hidden" name="fjernKarant" value="'.$rad['brukernavn'].'">'.$rad['brukernavn'].'</td>');
			echo('<td data-label="Epost">'.$rad['epost'].'</td>');
			echo('<td data-label="Dato">'.$rad['dato'].'</td>');
			echo('<td data-label="Verktøy"><button class="knapp">Fjern</button></td></tr></form>');
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen karantener</td></tr>');
		}
		echo('<tbody></table></div>');
	}else if($_POST['valget'] == "Nyheter" && $_POST['sorterNy'] == "Overskrift"){
		$_POST['sortert'] = "Overskrift";
		$sql = "SELECT nyhetID, overskrift, dato FROM nyheter ORDER BY overskrift";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Overskrift</th><th>Dato</th><th>Verktøy</th></tr></thead><tbody>');
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){	
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Overskrift"><input type="hidden" name="fjernNyhet" value="'.$rad['nyhetID'].'">'.$rad['overskrift'].'</td>');
			echo('<td data-label="Dato">'.$rad['dato'].'</td>');
			echo('<td data-label="Verktøy"><button class="knapp">Fjern</button></td></tr></form>');
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen nyheter</td></tr>');
		}
		echo('<tbody></table></div>');
	}else if($_POST['valget'] == "Nyheter" && $_POST['sorterNy'] == "Dato"){
		$_POST['sortert'] = "Dato";
		$sql = "SELECT nyhetID, overskrift, dato FROM nyheter ORDER BY dato";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$ingenting = true;
		echo('<div id="scroll"><table id="rapport"><thead>');
		echo('<tr><th>Dato</th><th>Overskrift</th><th>Verktøy</th></tr></thead><tbody>');
		while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){	
			$ingenting = false;
			echo('<form method="POST" action="Funksjoner/rapportFunksjoner.php">');
			echo('<tr><td data-label="Dato">'.$rad['dato'].'</td>');
			echo('<td data-label="Overskrift"><input type="hidden" name="fjernNyhet" value="'.$rad['nyhetID'].'">'.$rad['overskrift'].'</td>');
			echo('<td data-label="Verktøy"><button class="knapp">Fjern</button></td></tr></form>');
		}
		if($ingenting == true){
			echo('<tr><td colspan="5">Fant ingen nyheter</td></tr>');
		}
		echo('<tbody></table></div>');
	}else{
		echo('<div id="scroll"><table id="rapport"><tbody>');
		echo('<tr>En feil oppstod</tr>');
		echo('<tbody></table></div>');
	}
}


?>