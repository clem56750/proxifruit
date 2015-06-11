<?php
session_start();

echo "<meta charset='utf-8'>";

try {
	$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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