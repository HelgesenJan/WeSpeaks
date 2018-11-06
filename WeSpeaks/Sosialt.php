<?php
/*Denne siden er sist endret 28.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ketil */

include("Funksjoner/dbkobling.php");
$db = new Kobling();
$aktivSide = "Sosialt.php";
include 'Funksjoner/InnloggingsSjekk.php';
$stylesheets = array("CSS/SosialtStyle.css", "CSS/General.css", "CSS/footerStyle.css");  // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
include("Includes/header.php");
include("Funksjoner/sosialtFunksjoner.php");
?>

<h1 class="overskrift">Finn nye venner i studietiden</h1>

<div id="hovedramme">

    <div id="tekstramme">
        <h2 class="sokHovedHeader"> Søk etter andre studenter!</h2><br>
        <p class="sokTekst">Har du hatt uflaks med vennesøket i studiestarten? Frykt ikke!</p>
        <p class="sokTekstInfo">Her finner du søkefunksjoner som lar deg finne andre studenter ved å søke på et studie eller interessene dems</p>
    </div>

    <div id="funksjonsRamme">
        <div id="sokStudie">
            <h3 id="vw"> Søk via studie!</h3>
            <form  method='POST' action='Sosialt.php'>
                <div class='custom-select' name='studier'>
                    <select name='selectBoks'>
                        <?php
                            fyllStudieSelect();
                        ?>
                    </select>
                    <input class='studieSubmit' type='submit' name='studieSubmit' value='Søk'>
                </div>
            </form>
        </div>
        <div id="sokInteresse">
            <h3 id="vw"> Søk via interesse!</h3>
            <form  method="POST" action="Sosialt.php">
                <div class="custom-select">
                    <select name="selectBoks">
                        <?php
                            fyllInteresseSelect();
                        ?>
                    </select>
                    <input class="interesseSubmit" type='submit' name='interesseSubmit' value='Søk'>
                </div>
            </form>
        </div>
    </div>

</div>

<?php
    $hentRes = hentResultat();
    echo $hentRes;
?>

<?php include ("Includes/footer.php"); ?>
</body>
</html>
