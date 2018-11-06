<?php
/*Denne siden er sist endret 31.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta */

include("Funksjoner/dbkobling.php");
$db = new Kobling();
$aktiv = "admin";
$aktivSide = "adminRapporter.php";
include 'Funksjoner/InnloggingsSjekk.php';
$stylesheets = array("CSS/rapporter.css", "CSS/General.css", "CSS/footerStyle.css");  // stylesheets
$sider = array("admin.php" => "Hjem", "adminRapporter.php" => "Rapporter", "adminNyheter.php" => "Nyheter", "adminVerktøy.php" => "Verktøy");
include 'Includes/adminHeader.php';
include 'Funksjoner/rapporter.php';
?>

<div id="container">
	<h1 id="overskriften">Rapporter</h1>
	<form action="adminRapporter.php" method="POST" id="velgRapport">
		<p class="tekst">Velg rapport:</p>
		<select id="valg" onchange="endreListe()" name="valget">
			<option value="Brukere">Brukere</option>
			<option value="Arrangementer">Arrangementer</option>
			<option value="Karantener">Karantener</option>
			<option value="Nyheter">Nyheter</option>
		</select>
		
		<p class="tekst">Sorter:</p>
		<select id="sorterBrukere" name="sorterBruk">
			<option value="Brukernavn">Brukernavn</option>
			<option value="Epost">Epost</option>
		</select>
		
		<select id="sorterArr" name="sorterArr">
			<option value="Arrangement">Arrangement</option>
			<option value="Arrangor">Arrangør</option>
		</select>
		
		<select id="sorterKarant" name="sorterKara">
			<option value="Niva">Nivå</option>
			<option value="Brukernavn">Brukernavn</option>
			<option value="Epost">Epost</option>
		</select>
		
		<select id="sorterNyhet" name="sorterNy">
			<option value="Overskrift">Overskrift</option>
			<option value="Dato">Dato</option>
		</select>
		
		<button id="knappen" type="submit">Hent rapport</button>
	</form>
	<?php hentTabell(); 
		if(!isset($_POST['valget'])){
			$_POST['valget'] = "Brukere";
			$_POST['sortere'] = "Brukernavn";
		}
	?>
</div>

<script type="text/javascript">
var valget = "<?php echo $_POST['valget']; ?>";
var sortert = "<?php echo $_POST['sortert']; ?>";
var selectValg = document.getElementById("valg");
var selectBruker = document.getElementById("sorterBrukere");
var selectArr = document.getElementById("sorterArr");
var selectKara = document.getElementById("sorterKarant");
var selectNy = document.getElementById("sorterNyhet");
if(valget == "Brukere"){
	selectValg.selectedIndex = 0;
	selectBruker.style.display = "inline-block";
	selectArr.style.display = "none";
	selectKara.style.display = "none";
	selectNy.style.display = "none";
	if(sortert == "Brukernavn"){
		selectBruker.selectedIndex = 0;
	}else{
		selectBruker.selectedIndex = 1;
	}
}else if(valget == "Arrangementer"){
	selectValg.selectedIndex = 1;
	selectBruker.style.display = "none";
	selectArr.style.display = "inline-block";
	selectKara.style.display = "none";
	selectNy.style.display = "none";
	if(sortert == "Arrangement"){
		selectArr.selectedIndex = 0;
	}else{
		selectArr.selectedIndex = 1;
	}
}else if(valget == "Karantener"){
	selectValg.selectedIndex = 2;
	selectBruker.style.display = "none";
	selectArr.style.display = "none";
	selectKara.style.display = "inline-block";
	selectNy.style.display = "none";
	if(sortert == "Niva"){
		selectKara.selectedIndex = 0;
	}else if(sortert == "Brukernavn"){
		selectKara.selectedIndex = 1;
	}else{
		selectKara.selectedIndex = 2;
	}
}else{
	selectValg.selectedIndex = 3;
	selectBruker.style.display = "none";
	selectArr.style.display = "none";
	selectKara.style.display = "none";
	selectNy.style.display = "inline-block";
	if(sortert == "Overskrift"){
		selectNy.selectedIndex = 0;
	}else{
		selectNy.selectedIndex = 1;
	}
}


function endreListe(){
	var valget = document.getElementById("valg");
    var valgtVerdi = valget.options[valget.selectedIndex].value;
    if(valgtVerdi == "Brukere"){
		document.getElementById("sorterBrukere").style.display = "inline-block";
		document.getElementById("sorterArr").style.display = "none";
		document.getElementById("sorterKarant").style.display = "none";
		document.getElementById("sorterNyhet").style.display = "none";
	}else if(valgtVerdi == "Arrangementer"){	
		document.getElementById("sorterBrukere").style.display = "none";
		document.getElementById("sorterArr").style.display = "inline-block";
		document.getElementById("sorterKarant").style.display = "none";
		document.getElementById("sorterNyhet").style.display = "none";
	}else if(valgtVerdi == "Karantener"){
		document.getElementById("sorterBrukere").style.display = "none";
		document.getElementById("sorterArr").style.display = "none";
		document.getElementById("sorterKarant").style.display = "inline-block";
		document.getElementById("sorterNyhet").style.display = "none";
	}else{
		document.getElementById("sorterBrukere").style.display = "none";
		document.getElementById("sorterArr").style.display = "none";
		document.getElementById("sorterKarant").style.display = "none";
		document.getElementById("sorterNyhet").style.display = "inline-block";
	}
}
</script>

<?php unset($_POST);?> 
</body>

<?php include ("Includes/adminFooter.php"); ?>

</html>