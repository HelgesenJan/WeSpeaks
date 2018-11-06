<?php
/*Denne siden er sist endret 27.05.2018 av Hamta og Ketil
Denne siden ble kontrollert 01.06.2018 av Ole */

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
	<p class="Introduksjon">En epost vil bli sendt til den oppgitte e-postadressen.</p>	
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
			<legend>Glemt passord</legend>
			<form method="POST" action="Funksjoner/sendGlemtPassord.php">
				<label>Eksisterende e-postadresse: </label>
				<input type="text" name="epost" autofocus="autofocus" class="tekst" required>
				<button type="submit" name="Logg inn" value="Logg inn" id="loggInnKnapp" class="knapp">Få tilsendt nytt passord.</button>
			</form>
			<form action="default.php">
			<button href="default.php" class="knapp">Tilbake</button>
			</form>
		</fieldset>
		
	</div>
	
	
</body>

</html>