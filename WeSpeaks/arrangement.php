<?php
/*Denne siden er sist endret 17.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ole */


$stylesheets = array("CSS/arrangementStyle.css", "CSS/General.css", "CSS/footerStyle.css");  // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
$aktivSide = "arrangement.php";
include("Funksjoner/arrangementFunksjoner.php");
include 'Funksjoner/InnloggingsSjekk.php';
$brukernavn = $_SESSION['Brukernavn'];
include("Includes/header.php");

if(isset($_POST["submit"])){
        opprettArrangement($_POST["navn"], $_POST['sted'], $_POST['tid'], $_POST['beskrivelse']);
}
?>

<div class="arrangementHolder">
    <div class="arrangementBakgrunn">
    <h2>Opprett arrangement: </h2>
    <form action="arrangement.php" method="post">
        <div class="arrStedTid">
            <textarea class="arrangementFelt" type='text' name='navn' placeholder='Arrangementnavn: '></textarea><br>
            <textarea class="arrangementFelt" type='text' name='sted' placeholder='Sted: '></textarea><br>
            <input id="datoEndring" class="arrangementFelt" type='datetime-local' name='tid'>
        </div>
        <div class="beskOpp">
            <textarea class="arrangementBeskrivelse"type='text' name='beskrivelse' placeholder='Beskrivelse: '></textarea><br>
            <input class="arrangementSubmit" type='submit' name='submit' value='Opprett arrangement'>
        </div>
    </form>
    </div>
</div>

<div class="arrangementListe">
<article>
    <h2 class="arrangementOverskrift">Arrangementer: </h2>
</article>

<?php
$arrangementer = hentArrangementer();
echo $arrangementer;

if(isset($_POST["arrangement"])){
    oppmelding($_POST["arrangement"], $_POST["paamelding"]);
}
?>
</div>
<?php include ("Includes/footer.php"); ?>
</html>
