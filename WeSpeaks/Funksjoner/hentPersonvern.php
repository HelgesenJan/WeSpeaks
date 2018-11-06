<?php
/*Denne siden er sist endret 14.05.2018 av Hamta og Ketil
Denne siden ble kontrollert 01.06.2018 av Jan*/

$sql = "SELECT brukernavn, skjulInteresse, skjulStudium FROM personvern WHERE brukernavn=:bruker";
$stmt = $db->prepare($sql);
$stmt->bindParam('bruker', $_SESSION["Brukernavn"]);
$stmt->execute();
$nyrad = $stmt->fetch(PDO::FETCH_ASSOC);
?>


