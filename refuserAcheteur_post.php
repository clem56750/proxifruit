<?php
session_start();

	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

	$reponse = $bdd -> prepare("SELECT o.numOffer numOffer, o.price price_offer, o.priceType priceType_offer, o.qty quantity_offer, o.qtyType quantityType_offer, DATEDIFF(o.limitDate, NOW()) AS disponibility_offer, v.name variete_offer, m.pseudo member_offer, DATE_FORMAT(mso.selectDate, '%d%/%m%/%Y à %Hh%i') AS selectDate FROM offer o INNER JOIN variety v ON v.idVariety = o.Variety_idVariety INNER JOIN member m ON m.idMember = o.Member_idMember INNER JOIN member_select_offer mso ON mso.offer_numOffer = o.numOffer WHERE o.numOffer = ?");
	$reponse -> execute(array($_GET['variable']));
	while($donnees = $reponse -> fetch()) {
$reponse1 = $bdd -> prepare("SELECT m.idMember id, m.mail mail FROM member m INNER JOIN member_select_offer mso ON mso.Member_idMember = m.idMember WHERE mso.offer_numOffer=?"); //mail de l'acheteur
		$reponse1 -> execute(array($_GET['variable']));
		while($donnees1 = $reponse1 -> fetch()) {

			$to = $donnees1['mail'];
			$subject = "Message de : "  . $donnees['member_offer'];
			$message = "Bonjour, le membre " . $donnees['member_offer'] . " a refusé votre mise en contact pour l'offre N°" . $donnees['numOffer'] . " sélectionnée le " . $donnees['selectDate'] . ".<br/><br/> Rappel de l'offre : <br/> Produit : " .$donnees['variete_offer'] . "<br/>Quantité : " . $donnees['quantity_offer'] . " " . $donnees['quantityType_offer'] . "<br/>Prix : " . $donnees['price_offer'] . " " . $donnees['priceType_offer'] . "<br/>Disponibilité : " . $donnees['disponibility_offer'] . " jour(s)";
			$headers = 'FROM: proxifruit@proxifruit.fr';
			 
			
			mail(utf8_decode($to), utf8_decode($subject), utf8_decode($message), utf8_decode($headers));


$req = $bdd -> prepare("DELETE FROM member_select_offer WHERE offer_numOffer=? AND Member_idMember=?");
$req -> execute(array($_GET['variable'], $donnees1['id']));

$req1 = $bdd -> prepare("DELETE FROM offer_has_panier WHERE offer_numOffer=? AND Member_idMember=?");
$req1 -> execute(array($_GET['variable'], $donnees1['id']));


		}
		$reponse1 -> closeCursor();
	}
	$reponse -> closeCursor();




    	


	echo '<body onLoad="alert(\'Transaction annulée !\')">';
    echo '<meta http-equiv="refresh" content="0;URL=mesTransactions.php">';
?>
