<?php
session_start();

	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
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