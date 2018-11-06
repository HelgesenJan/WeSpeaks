<?php
/*Denne siden er sist endret 26.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan */


$stylesheets = array("CSS/adminHjem.css", "CSS/General.css", "CSS/footerStyle.css");  // stylesheets
$sider = array("admin.php" => "Hjem", "adminRapporter.php" => "Rapporter", "adminNyheter.php" => "Nyheter", "adminVerktøy.php" => "Verktøy");
$aktiv = "admin";
$aktivSide = "admin.php";
//oppretter kobling mot db
include("Funksjoner/dbkobling.php");
$db = new Kobling();
include("Funksjoner/SystemMeldinger.php");
include ("Funksjoner/InnloggingsSjekk.php");
include ("Includes/adminHeader.php");
include("Funksjoner/slettMelding.php");

?>
<script type="text/javascript">
function visMelding(melding){
	document.getElementById(melding).submit();
}
</script>
<div id="container">
	<div id="innhold">
		<div id="venstreInnhold">
			<div id="overskrift">
				<h1 id="innboks">Innboks</h1>
			</div>
			<div id="tabell">
				<table id="tabellen">
					<?php hentTabellen();?>
				</table>
			</div>
			<div id="responsivTabell">
				<table id="responsivTabellen">
					<?php hentResponsiv();?>
				</table>
			</div>
		</div>
		<div id="hoyreInnhold">
			<iframe id="meldingsVisning" name="meldingsVisning" src="Funksjoner/Innboks.php"></iframe>
		</div>
	</div>
</div>
<?php include ("Includes/adminFooter.php"); ?>


</html>

