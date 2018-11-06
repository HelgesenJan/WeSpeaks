<?php
/*Denne siden er sist endret 17.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Hamta */

$stylesheets = array("CSS/brukersArrangementer.css", "CSS/General.css", "CSS/footerStyle.css"); // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
$aktivSide = "profilside.php";
include("Funksjoner/oppmeldteArrangementer.php"); // funksjoner
include 'Funksjoner/InnloggingsSjekk.php';
$brukernavn = $_SESSION['Brukernavn'];
include("Includes/header.php");

?>

<div id="innhold">
    <h1 class="overskrift">Arrangementer</h1>

    <div id="profilmeny">
        <a href="profilside.php"><button class="profilKnapper">Profil</button></a>
        <a href="personvern.php"><button class="profilKnapper">Personvern</button></a>
        <a href="passordBytte.php"><button class="profilKnapper">Bytt passord</button></a>
        <a href="brukersArrangementer.php"><button id="valgt" class="profilKnapper">Arrangementer</button></a>
    </div>
</div>
<fieldset class="Foresporsel">
    <article class="wrap">
        <h3 class="overskrift">Arrangementer du er oppmeldt på</h3><br>
        <?php
        $arrangementer = hentArrangement();
        echo $arrangementer;
        ?>
    </article>
    <article class="brukerWrap" id="sjekkNull">
        <h3 class="overskrift">Dine opprettede arrangementer med påmeldte brukere</h3><br>
        <?php
        $brukersArrangementer = hentBrukersArrangementer();
        echo $brukersArrangementer;
        ?>
    </article>
    </form>
</fieldset>


</body>

<?php include ("Includes/footer.php"); ?>



</html>
