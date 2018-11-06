<?php
/*Denne siden er sist endret 20.11.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Hamta*/
	session_start();
	session_unset();
	session_destroy();
	header("Location: ../default.php");
?>