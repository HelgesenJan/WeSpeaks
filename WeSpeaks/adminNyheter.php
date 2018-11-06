<?php
/*Denne siden er sist endret 24.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Ketil */

include ("Funksjoner/nyhetsFunksjoner.php");
$aktiv = "admin";
$aktivSide = "adminNyheter.php";
include ("Funksjoner/InnloggingsSjekk.php");
$stylesheets = array("CSS/adminNyheter.css", "CSS/General.css", "CSS/footerStyle.css");   // stylesheets
$sider = array("admin.php" => "Hjem", "adminRapporter.php" => "Rapporter", "adminNyheter.php" => "Nyheter", "adminVerktøy.php" => "Verktøy");
include ("Includes/adminHeader.php");
?>
	
<div id="innhold">
	<h1 id="overskrift">Nyheter</h1>
	<div id="opprettNyhet">
		<article class="wrap">
			<form action="adminNyheter.php" method="post">
				<label class="byttLabel">Overskrift</label><br>
				<input class="tekst" id="overskriften" autofocus="autofocus" type="text" name="overskrift" required><br>
				<label class="byttLabel">Informasjon</label>
				<textarea id="nyheten" class="tekst" name="informasjon" required></textarea><br>
				<input class="tekst" type="submit" name="opprett" value="Publiser" id="knapp"><br>
			</form>
		</article>
		<?php
		if(isset($_POST["opprett"])){
			echo('<fieldset id="Foresporsel">');
			if(opprettNyhet($_POST["overskrift"], $_POST["informasjon"]) == false){
				echo "Antall nyheter er overskridet.";
			}else{
				echo "Nyheten er opprettet.";
			}
			echo('</fieldset>');
		}
		?>
	</div>
</div>

</body>

<?php include ("Includes/adminFooter.php"); ?>

</html>