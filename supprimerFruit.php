<?php
session_start();

	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


$req = $bdd -> prepare("DELETE FROM offer WHERE Variety_idVariety=?");
$req -> execute(array($_GET['variable']));

$req = $bdd -> prepare("DELETE FROM variety WHERE idVariety=?");
$req -> execute(array($_GET['variable']));

	echo '<body onLoad="alert(\'Fruit/Légume supprimé !\')">';
    echo '<meta http-equiv="refresh" content="0;URL=fruitsLegumes.php">';
?>