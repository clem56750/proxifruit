<?php
	session_start();

	try {
		$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


	$reponse = $bdd -> prepare("SELECT idMember, idPanier FROM member WHERE pseudo=?");
	$reponse -> execute(array($_SESSION['pseudo']));
		while($donnees = $reponse -> fetch()) {
				$req = $bdd -> prepare("INSERT INTO offer_has_panier(offer_numOffer, panier_idPanier, Member_idMember) VALUES (?, ?, ?)");
				$req -> execute(array($_GET['variable'], $donnees['idPanier'], $donnees['idMember']));
		}
		$reponse -> closeCursor();

header("Location: monPanier.php");





	?>