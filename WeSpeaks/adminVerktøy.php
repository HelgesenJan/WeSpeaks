<?php
/*Denne siden er sist endret 29.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan */

include("Funksjoner/dbkobling.php");
$db = new Kobling();
$aktiv = "admin";
$aktivSide = "adminVerktøy.php";
include ("Funksjoner/InnloggingsSjekk.php");
$stylesheets = array("CSS/passordBytte.css", "CSS/verktøy.css", "CSS/General.css", "CSS/footerStyle.css");    // stylesheets
$sider = array("admin.php" => "Hjem", "adminRapporter.php" => "Rapporter", "adminNyheter.php" => "Nyheter", "adminVerktøy.php" => "Verktøy");
include ("Includes/adminHeader.php");
include 'Funksjoner/skrivReglerFunk.php';

if(isset($_POST["regelen"])){
skrivRegler($_POST["tekst"]);
}
?>
<div class="rammer" id="rammen">
	<fieldset class="Foresporsel container">
	<h1 class="overskriften">Passordbytte</h1>
		<form method="POST" action="Funksjoner/EndrePassord.php" id="endrePassord">
			<label class="byttLabel">Gammelt passord</label>
			<input type="password" autofocus="autofocus" name="Gammeltpassord" class="tekst" required><br>
			<label class="byttLabel">Nytt passord: </label>
			<input type="password" name="Nyttpassord" class="tekst" required><br>
			<label class="byttLabel">Gjenta nytt passord: </label>
			<input type="password" name="Nyttpassord2" class="tekst" required><br>
			<input type='submit' name='sendt' value='Bytt passord' id="byttKnapp" class='knapp'>
		</form>
	</fieldset>

	<div id="vindu" class="container">
		<h2 class="overskriften">Regler for nettstedet</h2>
		<form action="adminVerktøy.php" method="post">
			<textarea class="tekstfelt" id="regler" name="tekst" placeholder='Skriv regler:' readonly ><?php hentRegler();?></textarea>
			<input id="lagreRegel" name="regelen" type="submit" value="Lagre">
		</form>
		<button id="avbrytRegel" onclick="avbrytRegler()">Avbryt</button>
		<button id="endreRegel" onclick="endreRegler()">Endre regler</button>
	</div>
</div>

<div class="rammer container" id="NyAdmin">
	<h3 class="overskriften">Registrer ny administrator</h3>
	<form method="POST" action="Funksjoner/Sjekkregistrering.php" id="regAdmin">
		<label class="regLabel">Epost-adresse: </label>
		<input type="email" name="Epost" class="regInput tekst" required><br>
		<label class="regLabel">Brukernavn: </label>
		<input type="text" name="Brukernavn" class="regInput tekst" required><br>
		<label class="regLabel">Passord: </label>
		<input type="password" name="Passord" class="regInput tekst" required><br>
		<label class="regLabel">Gjenta passord: </label>
		<input type="password" name="Passord2" class="regInput tekst" required><br>
		<input type="hidden" name="admin">
		<div>
			<button type='submit' name='sendt' value='Registrer bruker' id="regKnapp" class='knapp'>Registrer bruker</button>
		</div>
	</form>
</div>

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

    <script>
        function endreRegler(){
            var regel = document.getElementById("regler");
            regel.readOnly = false;
            regel.focus();
			document.getElementById('avbrytRegel').style.display = "block";
            document.getElementById('lagreRegel').style.display = "block";
            document.getElementById('endreRegel').style.display = "none";
        }

        function avbrytRegler(){
            var regel = document.getElementById("avbrytRegel");
            regel.readOnly = true;
            document.getElementById('lagreRegel').style.display = "none";
            document.getElementById('endreRegel').style.display = "block";
            document.getElementById('avbrytRegel').style.display = "none";
        }
    </script>



</body>

<?php include ("Includes/adminFooter.php"); ?>

</html>