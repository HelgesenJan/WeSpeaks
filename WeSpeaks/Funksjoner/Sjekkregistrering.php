<?php
/*Denne siden er sist endret 31.05.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Ketil*/
   
//oppretter kobling mot db
include("dbkobling.php");
include("Krypter.php");
$db = new Kobling();

session_start();
$_SESSION['Tilbakemelding'] = "";
if(isset($_POST['Brukernavn']) && isset($_POST['Passord']) && isset($_POST['Epost'])){

    $sjekkEpost = substr($_POST["Epost"], -6);
    if($sjekkEpost == "usn.no"){
        $sql = "INSERT INTO bruker (Brukernavn, Passord, Epost, Brukertype)" ;
        $sql .= "VALUES (:bruker, :pass, :epost, :brukertype);";
        //Gjør klart sql statement og binder post variabler til parameterne
        $statement = $db->prepare($sql);
        $statement->bindParam('bruker', $brukernavn);
        $statement->bindParam('pass', $kryptPassord);
        $statement->bindParam('epost', $epost);
        $statement->bindParam('brukertype', $type);
        $brukernavn = $_POST['Brukernavn'];
        $passord = $_POST['Passord'];
        $passord2 = $_POST['Passord2'];
        $epost = $_POST['Epost'];


        if(isset($_POST['admin'])){
            $type = 1;
        }else{
            $type = 0;
        }


        $kryptPassord = Krypter($passord);

        //En sjekk på om de to passordene brukeren har oppgit er like
        if ($passord == $passord2){
            $sql = "SELECT Brukernavn, Epost FROM bruker";
            $sql .= " WHERE Brukernavn=:brukeren OR Epost=:eposten;";
            $resultat = $db->prepare($sql);
            $resultat->bindParam(':brukeren', $brukernavn);
            $resultat->bindParam(':eposten', $epost);
            $resultat->execute();
            $rad = $resultat->fetch(PDO::FETCH_ASSOC);
            if($resultat->rowCount() == 1){
                if($rad['Brukernavn'] == $brukernavn && $rad['Epost'] == $epost){
                    $_SESSION['Tilbakemelding'] = "Brukernavn og epost er allerede i bruk!";
                    if($type == 1){
                        $redirect = "../adminVerktøy.php";
                    }else{
                        $redirect = "../default.php";
                    }
                }else if($rad['Brukernavn'] != $brukernavn && $rad['Epost'] == $epost){
                    $_SESSION['Tilbakemelding'] = "Epost er allerede i bruk!";
                    if($type == 1){
                        $redirect = "../adminVerktøy.php";
                    }else{
                        $redirect = "../default.php";
                    }
                }else {
                    $_SESSION['Tilbakemelding'] = "Brukernavn er allerede i bruk!";
                    if($type == 1){
                        $redirect = "../adminVerktøy.php";
                    }else{
                        $redirect = "../default.php";
                    }
                }

            }else if($resultat->rowCount() == 2){
                $_SESSION['Tilbakemelding'] = "Brukernavn og epost er allerede i bruk!";
                if($type == 1){
                    $redirect = "../adminVerktøy.php";
                }else{
                    $redirect = "../default.php";
                }

            }else{
                $statement->execute();
                $_SESSION['Tilbakemelding'] = "Brukeren er registrert!\n Du kan nå logge deg inn på våre sider.";
                $_SESSION['Brukernavn'] = $brukernavn;
                $_SESSION['aktivitet'] = time();
                $_SESSION['Logg inn'] = "OK";
                if($type == 1){
                    $redirect = "../admin.php";
                }else{
                    $redirect = "../hjem.php";
                }
            }

        } else {
            $_SESSION['Tilbakemelding'] = "Du skrev inn to forskjellige passord, vennligst prøv igjen.";
            if($type == 1){
                $redirect = "../adminVerktøy.php";
            }else{
                $redirect = "../default.php";
            }
        }

    } else{
        $_SESSION['Tilbakemelding'] = "Eposten må tilhøre USN";
        if($type == 1){
            $redirect = "../adminVerktøy.php";
        }else{
            $redirect = "../default.php";
        }
    }
}else{
    $_SESSION['Tilbakemelding'] = "Det oppstod en uventet feil";
}

header("Location: $redirect");

?>
