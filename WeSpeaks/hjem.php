<?php
/*Denne siden er sist endret 20.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Hamta */

$stylesheets = array("CSS/hjemStyle.css", "CSS/General.css", "CSS/footerStyle.css", "CSS/chatStyle.css"); // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
$aktivSide = "hjem.php";
include("Funksjoner/nyhetsFunksjoner.php");
include 'Funksjoner/InnloggingsSjekk.php';
$brukernavn = $_SESSION['Brukernavn'];
include("Includes/header.php");






?>

<article id="overskrifter">
    <p class="info">Siste nytt - USN</p>
</article>




<?php
$nyheter= hentNyheter();
echo $nyheter;
?>

<div class="wrapper">
<div class="venstre">
    <article>
        <h3 class="finnfrem">Snarveier:</h3>
    </article>
    <div class="link-knapp">
        <p><a target="_blank" class="link" href="https://usn.instructure.com/login/saml">Canvas ></a></p>
        <p><a target="_blank" class="link" href="http://bibliotek.usn.no/">Biblioteket ></a></p>
        <p><a target="_blank" class="link" href="https://outlook.office.com/">E-post ></a></p>
    </div>
    <div class="bilde">
        <img class="bildeStørrelse" src="Bilder/bibliotek.jpg" alt="kontakt">
    </div>
</div>


<?php include("chat.php");?>

</div>

<?php include ("Includes/footer.php"); ?>



<script language="javascript">
    window.setInterval("reloadIFrame();", 5000);

    function reloadIFrame() {
        document.getElementById('iframes').contentWindow.location.reload();

    }
</script>

</html>
