<?php
session_start();

	echo '<meta charset="utf-8">';

	try {
	$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


	$reponse = $bdd -> prepare("SELECT idMember FROM member WHERE pseudo=?");
	$reponse -> execute(array($_SESSION['pseudo']));
		while($donnees = $reponse -> fetch()) {
			$req = $bdd -> prepare("INSERT INTO member_select_offer(offer_numOffer, selectDate, Member_idMember) VALUES (?, NOW(), ?)");
			$req -> execute(array($_GET['variable'], $donnees['idMember']));
		}
		$reponse -> closeCursor();

	$reponse = $bdd -> prepare("SELECT o.numOffer numOffer, o.price price_offer, o.priceType priceType_offer, o.qty quantity_offer, o.qtyType quantityType_offer, DATEDIFF(o.limitDate, NOW()) AS disponibility_offer, DATE_FORMAT(o.offerDate, '%d%/%m%/%Y à %Hh%i') AS offerDate, v.name variete_offer, m.pseudo member_offer, m.name name, m.firstName firstname, m.mail mail FROM offer o INNER JOIN variety v ON v.idVariety = o.Variety_idVariety INNER JOIN member m ON m.idMember = o.Member_idMember WHERE o.numOffer = ?");
	$reponse -> execute(array($_GET['variable']));
	while($donnees = $reponse -> fetch()) {
		$reponse1 = $bdd -> prepare("SELECT name, firstName FROM member WHERE pseudo=?"); //nom et prénom de l'acheteur
		$reponse1 -> execute(array($_SESSION['pseudo']));
		while($donnees1 = $reponse1 -> fetch()) {

			$to = $donnees['mail'];
			$subject = "Message de : " . $donnees1['firstName'] . " " . $donnees1['name'] . " alias " . $_SESSION['pseudo'];
			$message = "Bonjour " . $donnees['member_offer'] . ", le membre " . $donnees1['firstName'] . " " . $donnees1['name'] . " alias " . $_SESSION['pseudo'] . " est intéressé par votre offre N°" . $donnees['numOffer'] . " soumise le " . $donnees['offerDate'] . ".<br/><br/> Rappel de l'offre : <br/> Produit : " .$donnees['variete_offer'] . "<br/>Quantité : " . $donnees['quantity_offer'] . " " . $donnees['quantityType_offer'] . "<br/>Prix : " . $donnees['price_offer'] . " " . $donnees['priceType_offer'] . "<br/>Disponibilité : " . $donnees['disponibility_offer'] . " jour(s)<br/><br/>Pour accepter ou refuser la mise en contact veuillez vous connecter sur http://localhost/ProxiFruit1/connexion.php et rendez-vous dans vos transactions dans l'onglet Mon profil.";
			$headers = 'FROM: proxifruit@proxifruit.fr';
			 
			
			mail(utf8_decode($to), utf8_decode($subject), utf8_decode($message), utf8_decode($headers));
		}
		$reponse1 -> closeCursor();
	}
	$reponse -> closeCursor();


	echo '<body onLoad="alert(\'Transaction en cours !\')">';
    echo '<meta http-equiv="refresh" content="0;URL=mesTransactions.php">';
?>