<?php
session_start();

	echo '<meta charset="utf-8">';

	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

	$reponse = $bdd -> prepare("SELECT o.numOffer numOffer, o.price price_offer, o.priceType priceType_offer, o.qty quantity_offer, o.qtyType quantityType_offer, DATEDIFF(o.limitDate, NOW()) AS disponibility_offer, DATE_FORMAT(o.offerDate, '%d%/%m%/%Y à %Hh%i') AS offerDate, v.name variete_offer, m.pseudo member_offer, m.name name, m.firstName firstname, m.phone phone, m.address address, m.cityPin cityPin, m.city city, m.mail mail, DATE_FORMAT(mso.selectDate, '%d%/%m%/%Y à %Hh%i') AS selectDate FROM offer o INNER JOIN variety v ON v.idVariety = o.Variety_idVariety INNER JOIN member m ON m.idMember = o.Member_idMember INNER JOIN member_select_offer mso ON mso.offer_numOffer = o.numOffer WHERE o.numOffer = ?");  // Vendeur
	$reponse -> execute(array(htmlspecialchars($_GET['variable'])));
	while($donnees = $reponse -> fetch()) {
		$reponse1 = $bdd -> prepare("SELECT m.pseudo pseudo, m.name name, m.firstName firstName, m.phone phone, m.mail mail FROM member m INNER JOIN member_select_offer mso ON mso.Member_idMember = m.idMember WHERE mso.offer_numOffer=?");  // Acheteur
		$reponse1 -> execute(array(htmlspecialchars($_GET['variable'])));
		while($donnees1 = $reponse1 -> fetch()) {

			$to = $donnees['mail']; //Pour le vendeur 
			$subject = "Message de : " . $donnees1['firstName'] . " " . $donnees1['name'] . " alias " . $donnees1['pseudo'];
			$message = "Bonjour " . $donnees['member_offer'] . ", vous avez accepté de vous mettre en contact avec le membre " . $donnees1['firstName'] . " " . $donnees1['name'] . " alias " . $donnees1['pseudo'] . " pour l'offre N°" . $donnees['numOffer'] . ".<br/><br/> Rappel de l'offre : <br/> Produit : " .$donnees['variete_offer'] . "<br/>Quantité : " . $donnees['quantity_offer'] . " " . $donnees['quantityType_offer'] . "<br/>Prix : " . $donnees['price_offer'] . " " . $donnees['priceType_offer'] . "<br/>Disponibilité : " . $donnees['disponibility_offer'] . " jour(s)<br/><br/>Informations du membre : <br/>Nom : " . $donnees1['name'] . "<br/>Prénom : " . $donnees1['firstName'] . "<br/>Téléphone : 0" . $donnees1['phone'];
			$headers = 'FROM: proxifruit@proxifruit.fr';

			$to1 = $donnees1['mail']; //Pour l'acheteur
			$subject1 = "Message de : " . $donnees['firstname'] . " " . $donnees['name'] . " alias " . $donnees['member_offer'];
			$message1 = "Bonjour " . $donnees1['pseudo'] . ", le membre " . $donnees['firstname'] . " " . $donnees['name'] . " alias " . $donnees['member_offer'] . " a accepté votre mise en contact pour l'offre N°" . $donnees['numOffer'] . " sélectionnée le " . $donnees['selectDate'] . ".<br/><br/> Rappel de l'offre : <br/> Produit : " .$donnees['variete_offer'] . "<br/>Quantité : " . $donnees['quantity_offer'] . " " . $donnees['quantityType_offer'] . "<br/>Prix : " . $donnees['price_offer'] . " " . $donnees['priceType_offer'] . "<br/>Disponibilité : " . $donnees['disponibility_offer'] . " jour(s)<br/><br/>Informations du membre : <br/>Nom : " . $donnees['name'] . "<br/>Prénom : " . $donnees['firstname'] . "<br/>Adresse : " . $donnees['address'] . " " . $donnees['cityPin'] . " " . $donnees['city'] . "<br/>Téléphone : 0" . $donnees['phone'];
			$headers1 = 'FROM: proxifruit@proxifruit.fr';
			 
			
			mail(utf8_decode($to), utf8_decode($subject), utf8_decode($message), utf8_decode($headers));
			mail(utf8_decode($to1), utf8_decode($subject1), utf8_decode($message1), utf8_decode($headers1));
		}
		$reponse1 -> closeCursor();
	}
	$reponse -> closeCursor();


	echo '<body onLoad="alert(\'Mise en relation en cours !\')">';
    echo '<meta http-equiv="refresh" content="0;URL=mesTransactions.php">';
?>