<?php
session_start();
try {
    // Beskytter mot Udefinert, flere filer opplastet samtidig, i tillegg til $_FILES misbruk
    if (
        !isset($_FILES['lastOppInput']['error']) ||
        is_array($_FILES['lastOppInput']['error'])
    ) {
        throw new RuntimeException('Ugyldige parametere.');
    }

    // Sjekker error parameter i FILES
    switch ($_FILES['lastOppInput']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('Ingen fil sendt.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Bildet overstiger maks størrelse.');
        default:
            throw new RuntimeException('Ukjent feil.');
    }

	//Sjekker størrelse på bildet
    if ($_FILES['lastOppInput']['size'] > 2000000) {
        throw new RuntimeException('Bildet overstiger maks størrelse.');
    }

    // Sjekker MIME verdi, og dermed om filformatet er gyldig
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['lastOppInput']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Ugyldig filformat.');
    }

    //Plasserer filen i opplastedeBilder mappa
	$filnavn = sprintf('../opplastedeBilder/Profilbilde'.$_SESSION["Brukernavn"]);
    if (!move_uploaded_file(
        $_FILES['lastOppInput']['tmp_name'],
        $filnavn
    )) {
        throw new RuntimeException('Det gikk noe galt med flytting av filen.');
    }

    echo 'Filopplastingen var vellykket.';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}

header("Location: ../profilside.php");
?>