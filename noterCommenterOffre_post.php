<?php
	session_start();

	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
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