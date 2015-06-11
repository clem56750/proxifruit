<?php
session_start();

echo "<meta charset='utf-8'>";

try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


$reponse = $bdd -> prepare("SELECT idMember FROM member WHERE pseudo=?");
$reponse -> execute(array($_SESSION['pseudo']));
while($donnees = $reponse -> fetch()) {

$req = $bdd -> prepare("DELETE FROM mailalert WHERE Member_idMember=?");
$req -> execute(array($donnees['idMember']));

$req = $bdd -> prepare("DELETE FROM comment WHERE Member_idMember=?");
$req -> execute(array($donnees['idMember']));

$req = $bdd -> prepare("DELETE FROM offer WHERE Member_idMember=?");
$req -> execute(array($donnees['idMember']));


$req = $bdd -> prepare("DELETE FROM member WHERE pseudo=?");
$req -> execute(array($_SESSION['pseudo']));

}
$reponse -> closeCursor();

session_destroy();



		echo '<body onLoad="alert(\'Votre compte est supprimé\')">';
		echo '<meta http-equiv="refresh" content="0;URL=accueil.php">';


?>