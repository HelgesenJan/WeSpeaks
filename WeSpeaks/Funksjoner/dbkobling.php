<?php
/*Denne siden er sist endret 13.01.2018 av Ole
Denne siden ble kontrollert 01.06.2018 av Ketil*/

class Kobling extends PDO{
	public function __construct(){
		$info = parse_ini_file('dbInfo.ini',TRUE);
		if (!$info) throw new exception('Åpning av ini-fil mislyktes.');
		$drv = $info['database']['driver'];
		$hst = $info['database']['host'];
		$db = $info['database']['schema'];
		$bruker = $info['database']['username'];
		$pass = $info['database']['password'];
		$dns = $drv.':host='.$hst.';dbname='.$db;
		parent::__construct($dns, $bruker, $pass);
	}
}
?>