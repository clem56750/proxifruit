<?php
session_start();

	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

$req = $bdd -> prepare("DELETE FROM offer WHERE numOffer=:num_Offer");
$req -> execute(array(
	'num_Offer'=>$_GET['variable']));

	echo '<body onLoad="alert(\'Offre supprimée !\')">';
    echo '<meta http-equiv="refresh" content="0;URL=gererMesOffres.php">';
?>