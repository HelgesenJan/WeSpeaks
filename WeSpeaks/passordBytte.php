<?php
/*Denne siden er sist endret 16.01.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta */

include("Funksjoner/dbkobling.php");
$db = new Kobling();
$aktivSide = "profilside.php";    // passordBytte ligger på "Mine sider" og skal derfor ikke ha en aktiv knapp
include 'Funksjoner/InnloggingsSjekk.php';
$stylesheets = array("CSS/passordBytte.css", "CSS/General.css", "CSS/footerStyle.css");  // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
include("Includes/header.php");
?>
	<div id="innhold">
		<h1 class="overskrift">Bytt passord</h1>
		<div id="profilmeny">
			<a href="profilside.php"><button class="profilKnapper">Profil</button></a>
			<a href="personvern.php"><button class="profilKnapper">Personvern</button></a>
			<a href="passordBytte.php"><button id="valgt" class="profilKnapper">Bytt passord</button></a>
			<a href="brukersArrangementer.php"><button class="profilKnapper">Arrangementer</button></a>
		</div>
    </div>
		
	<fieldset class="Foresporsel">
		<article class="wrap">
		<form method="POST" action="Funksjoner/EndrePassord.php">
			<label class="byttLabel">Gammelt passord</label>
			<input type="password" autofocus="autofocus" name="Gammeltpassord" class="tekst" required><br>
			<label class="byttLabel">Nytt passord: </label>
			<input type="password" name="Nyttpassord" class="tekst" required><br>
			<label class="byttLabel">Gjenta nytt passord: </label>
			<input type="password" name="Nyttpassord2" class="tekst" required><br>
			<input type='submit' name='sendt' value='Bytt passord' id="byttKnapp" class='knapp'>
		</article>
		</form>
	</fieldset>
	
	<!-- Dersom det er en tilbakemelding i session variabelen med det navnet... -->
	<!-- så skal den skrives ut, og klarere alle session variabler etter på. -->
	<?php
		if(isset($_SESSION['Tilbakemelding']) && $_SESSION['Tilbakemelding'] != "Passordet er endret"){
			echo("<fieldset class='Foresporsel'>");
			echo("<legend>Tilbakemelding</legend>");
			echo($_SESSION['Tilbakemelding']);
			echo("</fieldset>");
			unset($_SESSION['Tilbakemelding']);
		}else{
		}
	?>
</body>

<?php include ("Includes/footer.php"); ?>

</html>
