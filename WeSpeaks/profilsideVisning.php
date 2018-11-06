<?php
/*Denne siden er sist endret 30.05.2018 av Jan
Denne siden ble kontrollert 01.06.2018 av Ole */

include("Funksjoner/dbkobling.php");
//oppretter kobling mot db
$db = new Kobling();
$aktivSide = "";    // profilside ligger på "Mine sider" og skal derfor ikke ha en aktiv knapp
include("Funksjoner/InnloggingsSjekk.php");
include("Funksjoner/listInteresser.php");
include("Funksjoner/brukerInfo.php");
//Siste css-en (linken) er BARE brukt til ikoner i brukerinfo-tabellen
$stylesheets = array("CSS/profilsideStyle.css", "CSS/General.css", "CSS/footerStyle.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");   // stylesheets
$sider = array("hjem.php" => "Hjem", "arrangement.php" => "Arrangement", "Sosialt.php" => "Sosialt", "profilside.php" => "Mine sider");
$brukernavn = $_GET["id"];
include("Includes/header.php");

?>
<script type="text/javascript" src="Javascript/profilsideJS.js">
</script>


<div id="innhold">
    <h1 class="overskrift"><?php echo($brukernavn); ?> sin profil</h1>

    <fieldset id="profilRamme">
        <article id="overste">
            <!-- Profilbilde -->
            <section id="profilbilde" class="container">
                <div class="ytre-profilbilde-container">
                    <div id="brukernavn"><?php echo($brukernavn); ?>'s profilbilde</div>
                    <?php if(file_exists('opplastedeBilder/Profilbilde'.$brukernavn)){
						echo("<div class='profilbilde-container'>
							<img class='profilbildevisning bildeViser' src='opplastedeBilder/Profilbilde" . $brukernavn . "?" .  
							filemtime('opplastedeBilder/Profilbilde'. $brukernavn) . " alt='Bilde av'" . $brukernavn . "</div>"); 
						}else{
							echo("<p>".$brukernavn." har ikke lastet opp et profilbilde.</p>");
						}
					?>
                </div>
            </section>
            <!-- Profilbilde slutt -->

            <!-- Beskrivelse -->
            <section id="beskrivelse" class="container">
                <div id="beskrivelsen">
                    <div id="brukernavn">Beskrivelse av <?php echo($brukernavn); ?></div>
                    <form method="POST" action="Funksjoner/lagreBeskrivelse.php">
						<textarea name="beskrivelsen" id="brukerBeskrivelse" maxlength="500" rows="4" cols="50" readonly><?php hentBeskrivelse(); ?>
						</textarea>
                    </form>
                </div>
            </section>
            <!-- Beskrivelse slutt -->

            <!-- Brukerinfo-tabell -->
            <section id="brukerinfo" class="container">
                <div class="tabell-container">
                    <div id="brukernavn">Informasjon om <?php echo($brukernavn . "</div>");
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
                    <div id="brukernavn"><?php echo($brukernavn . "'s studium</div><p id='tilbakemelding'>");
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
                        </form>
                    </div>
            </section>
            <!-- Studium slutt -->

            <!-- Interesser -->
            <section id="interesser" class="container">
                <div id="interesseContainer">
                    <div id="brukernavn"><?php echo($brukernavn . "'s interesser</div><p id='tilbakemelding'>");
                        lagTabellInteresse();
                        ?></p>
                        <form method="POST" action="Funksjoner/interesseFunksjoner.php" class="studieOgInteresseForm" id="interesseForm">
                            <p>Bruk komma som skilletegn for å legge til mer enn 1 interesse om gangen.</p>
                            <div class='input-felt'>
                                <textarea id="bryter" name="Interesse" maxlength="50"></textarea><br>
                            </div>
                        </form>
                    </div>
            </section>
            <button id="tilbakeKnapp" value="Tilbake"><a href="Sosialt.php">Tilbake</a></button>
            <!-- Interesser slutt -->
        </article>
    </fieldset>
</div>

</body>

<?php include ("Includes/footer.php"); ?>

</html>