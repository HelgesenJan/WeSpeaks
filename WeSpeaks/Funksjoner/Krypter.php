<?php

function Krypter($pass){
	$salt = 'IT2_2018';
	
	//Krypterer passord
	$saltetPassord = $salt . $pass;
	$kryptPassord = sha1($saltetPassord);
	return $kryptPassord;
}


?>