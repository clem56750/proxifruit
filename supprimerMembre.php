<?php
session_start();

echo "<meta charset='utf-8'>";

try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


$req = $bdd -> prepare("DELETE FROM mailalert WHERE Member_idMember=?");
$req -> execute(array($_GET['variable']));

$req = $bdd -> prepare("DELETE FROM member_select_offer WHERE Member_idMember=?");
$req -> execute(array($_GET['variable']));

$req = $bdd -> prepare("DELETE FROM comment WHERE Member_idMember=?");
$req -> execute(array($_GET['variable']));

$req = $bdd -> prepare("DELETE FROM offer WHERE Member_idMember=?");
$req -> execute(array($_GET['variable']));

$req = $bdd -> prepare("DELETE FROM offer_has_panier WHERE Member_idMember=?");
$req -> execute(array($_GET['variable']));

$req = $bdd -> prepare("DELETE FROM member WHERE idMember=?");
$req -> execute(array($_GET['variable']));


header("Location: membres.php");

?>