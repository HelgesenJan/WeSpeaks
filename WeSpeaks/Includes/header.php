<?php
/*Denne siden er sist endret 31.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ketil*/
?>
<!DOCTYPE html>
<html>

<head>
    <title>WeSpeaks</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale 1.0">

    <!-- Løsning som håndterer bruk av stylesheet -->
    <?php foreach($stylesheets as $stylesheet): ?>
        <link rel="stylesheet" type="text/css" href="<?= $stylesheet ?>" />
    <?php endforeach; ?>



</head>

<body>
<header class="topbar">
    <form class='topbar-form' method="POST" action="Funksjoner/LoggUt.php">
        <a href="hjem.php"><img src="Bilder/logo.png" class="bildet" alt="Bilde av logo"></a>
        <div class='action-buttons-container'>
				<?php if(!isset($brukernavn)){
					if(file_exists('opplastedeBilder/Profilbilde'.$_SESSION["Brukernavn"])){
					echo('<img src="opplastedeBilder/Profilbilde'.$_SESSION["Brukernavn"]. '" alt="Bilde av'. $_SESSION["Brukernavn"].'" class="profilbilde"></a>');
					}
				}else{
					if(file_exists('opplastedeBilder/Profilbilde'.$brukernavn)){
					echo('<img src="opplastedeBilder/Profilbilde'.$brukernavn. '" alt="Bilde av'. $brukernavn.'" class="profilbilde"></a>');
					}else{
						echo("<p>".$brukernavn." har ikke lastet opp et profilbilde.</p>");
					}
				}?>
            <button name="LoggUt" value="LoggUt" class='action-buttons button button--primary'>Logg ut</button>
        </div>
    </form>
</header>

<div id="menyElement">
    <label for="toggle"><img src="Bilder/hamburgermeny.png" id="hamburgeren" alt="Hamburgermeny"></label>
    <!--"Hamburgerknapp løsning for mobile enheter ved bruk av checkbox typen -->
    <!--Laget av Jan-->
    <!--Kontrollert av Ole-->
    <input type="checkbox" id="responsivMeny"/>
    <label for="responsivMeny"></label>
    <nav class="meny">
        <!--lag en liste over menyvalgene-->
        <?php include("Includes/nav.php")?>
    </nav>
</div>
