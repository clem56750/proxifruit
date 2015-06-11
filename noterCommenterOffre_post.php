<?php
	session_start();

	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

	$reponse = $bdd -> prepare("SELECT idMember FROM member WHERE pseudo=?");
	$reponse -> execute(array($_SESSION['pseudo']));
		while($donnees = $reponse -> fetch()) {
			$req = $bdd -> prepare("INSERT INTO comment(comment, commentMark, offer_numOffer, Member_idMember) VALUES (?, ?, ?, ?)");
			$req -> execute(array($_POST['commentaire'], $_GET['stars'], $_GET['variable'], $donnees['idMember']));
		}
		$reponse -> closeCursor();

		header("Location: accueil.php");
?>