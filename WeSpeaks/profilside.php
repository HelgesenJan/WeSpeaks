<?php
/*Denne siden er sist endret 29.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Jan */


include("Funksjoner/dbkobling.php");
//oppretter kobling mot db
$db = new Kobling();
$aktivSide = "profilside.php";    // profilside ligger på "Mine sider" og skal derfor ikke ha en aktiv knapp
include("Funksjoner/InnloggingsSjekk.php");
include("Funksjoner/listInteresser.php");
include("Funksjoner/brukerInfo.php");
//Siste css-en (linken) er BARE brukt til ikoner i brukerinfo-tabellen
$stylesheets = array("CSS/profilsideStyle.css", "CSS/General.css", "CSS/footerStyle.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");   // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
include("Includes/header.php");
?>
    <script type="text/javascript" src="Javascript/profilsideJS.js">
    </script>


<div id="innhold">
    <h1 class="overskrift">Din profil</h1>
	
	<div id="profilmeny">
		<a href="profilside.php"><button id="valgt" class="profilKnapper">Profil</button></a>
		<a href="personvern.php"><button class="profilKnapper">Personvern</button></a>
		<a href="passordBytte.php"><button class="profilKnapper">Bytt passord</button></a>
		<a href="brukersArrangementer.php"><button class="profilKnapper">Arrangementer</button></a>
	</div>

    <fieldset id="profilRamme">
		<article id="overste">
			<!-- Profilbilde -->
			<section id="profilbilde" class="container">
				<div class="ytre-profilbilde-container">
					<div id="brukernavn"><?php echo($_SESSION["Brukernavn"]); ?>'s profilbilde</div>
						<?php if(file_exists('opplastedeBilder/Profilbilde'.$_SESSION["Brukernavn"])){
						echo("<div class='profilbilde-container'>
							<img class='profilbildevisning bildeViser' src='opplastedeBilder/Profilbilde" . $_SESSION["Brukernavn"] . "?" .  
							filemtime('opplastedeBilder/Profilbilde'. $_SESSION["Brukernavn"]) . " alt='Bilde av'" . $_SESSION["Brukernavn"] . "</div>"); 
						}else{
							echo("<p>Du har ikke lastet opp et profilbilde enda. Husk at det er valgfritt å bruke profilbilde.</p>");
						}
						?>
						<button type="submit" class="knapp" id="byttProfilbilde" onclick="visLastOppForm()">Last opp profilbilde</button>
				</div>
				<div id="lastOppContainer">
					<div id="lastOppFormContainer">
						<p id="lastOppTekst">Last opp profilbilde</p>
						<form method="POST" action="Funksjoner/lastOppBilde.php" enctype="multipart/form-data" id="lastOppForm">
							<input type="submit" class="knapper" id="lagreKnapp" value="Lagre profilbilde">
							<input type="file" accept="image/*" name="lastOppInput" id="velgFil" onchange="hentFil(event)">
							<div id="visningsRamme">
								<img id="visning" class="bildeViser"/>
							</div>
						</form>
						<button class="knapp" onclick="skjulLastOppForm()" id="lukkLastOppForm">Lukk</button>
					</div>
				</div>
			</section>
			<!-- Profilbilde slutt -->
			
			<!-- Beskrivelse -->
			<section id="beskrivelse" class="container">
				<div id="beskrivelsen">
					<div id="brukernavn">Beskrivelse av <?php echo($_SESSION["Brukernavn"]); ?></div>
					<form method="POST" action="Funksjoner/lagreBeskrivelse.php">
						<textarea name="beskrivelsen" id="brukerBeskrivelse" maxlength="500" rows="4" cols="50" readonly><?php hentBeskrivelse(); ?>
						</textarea>
						<button type="button" class="knapp" id="avbrytBeskrivelse" onclick="avbrytBeskrivelsen()">Avbryt</button>
						<input type="submit" id="lagreBeskrivelse" class="knapper" value="Lagre endringer" name="Lagre">
					</form>
					<button id="beskrivelseKnapp" class="knapp" onclick="endreBeskrivelsen()">Endre beskrivelse</button>
				</div>
			</section>
			<!-- Beskrivelse slutt -->
			
			<!-- Brukerinfo-tabell -->
			<section id="brukerinfo" class="container">
				<div class="tabell-container">
					<div id="brukernavn">Informasjon om <?php echo($_SESSION["Brukernavn"] . "</div>");
					brukerInfoTabell();
					?>
				</div>
			</section>
			<!-- Brukerinfo-tabell slutt -->
        </article>
		
		<article id="nedre">
			<!-- Studium -->
			<section id="studium" class="container">
				<div id="studiumContainer">
					<div id="brukernavn"><?php echo($_SESSION["Brukernavn"] . "'s studium</div><p id='tilbakemelding'>");
					lagTabellStudium();
					?></p>
					<form method="POST" action="Funksjoner/studiumFunksjoner.php" class="studieOgInteresseForm" id="studiumForm">
						<div class='input-felt'>
							<div id="studiumInput">
								<label>Studium</label>
								<input type="text" name="studiumet" id="studiumTekst" maxlength="50" required><br>
							</div>
							<div id="gradInput">
								<label>Grad</label>
								<input type="text" name="graden" maxlength="40" required><br>
							</div>
							<div id="skoleInput">
								<label>Skole</label>
								<input type="text" name="skolen" maxlength="50" required><br>
							</div>
							<div id="arskullInput">
								<label>Årskull</label>
								<input type="text" name="arskullet" maxlength="50" required><br>
							</div>
						</div>
						<button type="button" class="knapp" id="avbrytStudium" onclick="avbrytStudiumForm()">Avbryt</button>
						<input type="submit" name="Lagre" id="lagreStudium" value="Lagre studium" class="knapper" required><br>
					</form>
					<button class="knapp" id="flereStudium" onclick="visStudiumForm()">Legg til studium</button>
				</div>
			</section>
			<!-- Studium slutt -->
			
			<!-- Interesser -->
			<section id="interesser" class="container">
				<div id="interesseContainer">
					<div id="brukernavn"><?php echo($_SESSION["Brukernavn"] . "'s interesser</div><p id='tilbakemelding'>");
					lagTabellInteresse();
					echo('</p>');
					hentInteresseValg();
					?>
					<!--<form method="POST" action="Funksjoner/interesseFunksjoner.php" class="studieOgInteresseForm" id="interesseForm">
						<p>Bruk komma som skilletegn for å legge til mer enn 1 interesse om gangen.</p>
						<div class='input-felt'>
							<textarea id="bryter" name="Interesse" maxlength="50"></textarea><br>
						</div>
						<button type="button" class="knapp" id="avbrytInteresse" onclick="avbrytInteresseForm()">Avbryt</button>
						<input type="submit" name="Lagre" id="lagreInteresse" value="Lagre" class="knapper" required><br>
					</form>-->
					<button class="knapp" id="flereInteresser" onclick="visInteresseForm()">Legg til interesser</button>
				</div>
			</section>
			<!-- Interesser slutt -->
		</article>
    </fieldset>
</div>

</body>

<?php include ("Includes/footer.php"); ?>

</html>
