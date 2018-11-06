<?php
/*Denne siden er sist endret 22.05.2018 av Ketil og Hamta
Denne siden ble kontrollert 01.06.2018 av Jan */

include("Funksjoner/dbkobling.php");
$db = new Kobling();

$aktivSide = "profilside.php";
include 'Funksjoner/InnloggingsSjekk.php';
include 'Funksjoner/hentPersonvern.php';
$stylesheets = array("CSS/passordbytte.css", "CSS/personvernStyle.css", "CSS/General.css", "CSS/footerStyle.css");   // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
include("Includes/header.php");

?>

    <script LANGUAGE="javascript">
        var interessen = "<?php echo $nyrad['skjulInteresse']?>";
        var studien = "<?php echo $nyrad['skjulStudium']?>";

        window.onload = function(){
            if(interessen == "1"){document.getElementById('interesse').checked = true;
            }else{document.getElementById('interesse').checked = false;
            }
            if(studien == "1"){document.getElementById('studie').checked = true;
            }else{document.getElementById('studie').checked = false;
            }
        }

    </script>

<div id="innhold">
    <h1 class="overskrift">Personverns Instillinger</h1>

    <div id="profilmeny">
        <a href="profilside.php"><button class="profilKnapper">Profil</button></a>
        <a href="personvern.php"><button id="valgt" class="profilKnapper">Personvern</button></a>
        <a href="passordBytte.php"><button class="profilKnapper">Bytt passord</button></a>
        <a href="brukersArrangementer.php"><button class="profilKnapper">Arrangementer</button></a>
    </div>

    <form method="POST" action="Funksjoner/personvernEndring.php">
        <fieldset id="profilRamme">
            <fieldset id="box1">
                <legend>Finne meg via interesser?</legend>
                <label class="switch">
                    <input type="checkbox" name="interessePost" id="interesse" value="interessen">
                    <span class="slider round"></span>
                </label>
                <p>Når dette er aktivert kan ikke andre finne deg via søk på interesser</p>
            </fieldset>

            <fieldset id="box2">
                <legend>Finne meg via studium?</legend>
                <label class="switch">
                    <input type="checkbox" name="studiePost" id="studie" value="studien">
                    <span class="slider round"></span>
                </label>
                <p>Når dette er aktivert kan ikke andre finne deg via søk på studium</p>
            </fieldset>

            <fieldset id="box3">
                <legend>Slett bruker: </legend><br>
                <p>Trykk for å slette din bruker</p>
                    <input type="submit" name="slettBekreft" value="Slett Bruker"  method="POST" onclick="return confirm('Er du sikker? Bruker og all lagret informasjon vil bli slettet for godt')"class='slettKonto'>
            </fieldset>
        </fieldset>
        <input type="submit" name="Bekreft" value="Bekreft endringer"  method="POST" class='bekreftKnapp'>
    </form>
</div>


</body>


<?php include ("Includes/footer.php"); ?>

</html>
