<?php
/*Denne siden er sist endret 28.05.2018 av Hamta og Ketil
Denne siden ble kontrollert 01.06.2018 av Jan */

	$default = "check";
	//oppretter kobling mot db
	include("Funksjoner/dbkobling.php");
	$db = new Kobling();
	include 'Funksjoner/InnloggingsSjekk.php';
?>
<!DOCTYPE html>


<html>

<head>
<title>WeSpeaks</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial scale 1.0">
<link rel="stylesheet" type="text/css" href="CSS/General.css">
<link rel="stylesheet" type="text/css" href="CSS/LoggInn.css">
</head>

<body>
	<img src="Bilder/logo.png" id="logoen" class="bildet" alt="Bilde av logo">
	<p class="Introduksjon">Velkommen til WeSpeaks!</p>
	<p class="Introduksjon">WeSpeaks er et nettsted hvor studenter ved USN</p>
	<p class="Introduksjon">kan møtes for å snakke, finne nye venner og holde seg</p>
	<p class="Introduksjon">oppdatert på hva som skjer rundt på campus.</p>
	<p class="Introduksjon">Husk å semester registrere deg først!</p>
	
	<div class="innhold">
	
		<?php
		if(isset($_SESSION['Tilbakemelding'])){
			echo("<fieldset id='tilbakemelding'>");
			echo("<legend>Tilbakemelding</legend>");
			echo($_SESSION['Tilbakemelding']);
			session_unset();
			echo("</fieldset>");
		} else {
		}
		?>
		
		<fieldset class="loggInnField">
			<legend>Logg inn</legend>
			<form method="POST" action="Funksjoner/logginn.php">
				<label>Brukernavn: </label>
				<input type="text" name="Brukernavn" autofocus="autofocus" class="tekst" required>
				<label>Passord: </label>
				<input type="password" name="Passord" class="tekst" required>
				<div>
				<button type="submit" name="Logg inn" value="Logg inn" id="loggInnKnapp" class="knapp">Logg inn</button>
				</div>
			</form>
			<form action="glemtPassord.php">
			<button href="glemtPassord.php" class="knapp">Glemt Passord?</button>
			</form>
		</fieldset>
		
		<fieldset class="Foresporsel" id="regForesporsel">
			<legend>Registrer bruker</legend>
			<form method="POST" action="Funksjoner/Sjekkregistrering.php">
				<label>Epost-adresse: </label>
				<input type="email" name="Epost" class="tekst" required>
				<label>Brukernavn: </label>
				<input type="text" name="Brukernavn" class="tekst" required>
				<label>Passord: </label>
				<input type="password" name="Passord" class="tekst" required>
				<label>Gjenta passord: </label>
				<input type="password" name="Passord2" class="tekst" required>
				<div>
				<button type='submit' name='sendt' value='Registrer bruker' id="regKnapp" class='knapp'>Registrer bruker</button>
				</div>
			</form>
		</fieldset>
		
	</div>
	
	
</body>

</html>