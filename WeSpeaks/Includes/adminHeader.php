<?php
/*Denne siden er sist endret 19.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta*/
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
<!--Kommentar ole: Tenker å legge inn slik at menybaren blir fixed etter at menybaren treffer toppen av webbrowseren-->
<nav class="topbar">
   <form class='topbar-form' method="POST" action="Funksjoner/LoggUt.php">
        <a href="admin.php"><img src="Bilder/adminLogo.png" class="bildet" alt="Bilde av administrator-logo"></a>
		<div class='action-buttons-container'>
			<a href="admin.php"><p id="mineSider">Bruker innlogget: <?php echo($_SESSION["Brukernavn"]); ?></p></a>
			<button name="LoggUt" value="LoggUt" class='action-buttons button button--primary'>Logg ut</button>
		</div>
    </form>

</nav>

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