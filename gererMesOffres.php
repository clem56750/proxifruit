<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="main2.css">
        <title>ProxiFruit</title>
    <link rel="icon" href="upload/icone.PNG" />
  </head>

   <body>


    <div class="fonddepage">
      <nav> <!-- liens de navigation du haut de la page -->
          <ul class="navhautbanniere"> <!-- liens de navigation au dessus de la banniere -->
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="fruitsLegumes.php">Fruits & Légumes</a></li>
            <li><a href="membres.php">Membres</a></li>
            <li><a href="recettes.php">Recettes</a></li>
            <li><a href="faireUneOffre.php">Faire une offre</a></li>
            <li><a href="voirLesOffres.php">Voir les offres</a></li>
        
            <?php
        if(isset($_SESSION['usermail']) AND isset($_SESSION['password'])) {
          echo "<li><a href='monPanier.php'>Mon panier</a></li>";
          try {
              $bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
          }
          catch(Exception $e) {
              die("Erreur :".$e -> getMessage());
          }
            $req = $bdd -> prepare("SELECT picture FROM member WHERE pseudo=?");
            $req -> execute(array(
            $_SESSION['pseudo']));
            while($donnees = $req -> fetch()) {
                echo "<li><a href='monProfil.php'><img src='" .$donnees["picture"]. "' height='35'/>Mon profil</a></li>";
            }
            $req -> closeCursor();
          echo "<li><a href='deconnexion.php'>Déconnexion</a></li>";
        }

            else {
            echo "<li class='inscriptionconnexion'><a href='inscription.php'>S'inscrire</a></li>";
            echo "<li class='inscriptionconnexion'><a href='connexion.php'>Se connecter</a></li>";
            }
            ?>
        
            <li><a href="FAQ.php">FAQ</a></li>
          </ul>
      </nav>
    <header class="banniere">
      <img class="logoaccueil" src="http://img11.hostingpics.net/pics/774803logo.png" alt="Logo du site" /> 
      <h4 class="sloganaccueil">Vous n'avez jamais été aussi proche de vos fruits et légumes</h4>
    </header> 


               <h3>Gérer mes offres</h3> 


                    <?php 
                    if(!isset($_SESSION['pseudo'])) {
                        echo "<div class='section'><p><a href='connexion.php'>Pour gérer vos offres vous devez vous connecter</a></p></div><br/><br/><br/><br/>";
                    }
                   else{

                   ?>

               
           <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4"><br/>
          <div class="col-md-3"><a href="monProfil.php">Mon compte</a></div>
          <div class="col-md-3"><a href="gererMesOffres.php">Gérer mes offres</a></div>
          <div class="col-md-3"><a href="mesTransactions.php">Mes transaction</a></div>
          <div class="col-md-3"><a href="mesFavoris.php">Mes favoris</a></div>
          





<?php

		$reponse = $bdd -> query("SELECT o.numOffer numOffer, o.picture picture_offer, o.price price_offer, o.priceType priceType_offer, o.qty quantity_offer, o.qtyType quantityType_offer, 
      o.description description_offer, DATEDIFF(o.limitDate, NOW()) AS disponibility_offer, DATE_FORMAT(o.OfferDate, '%d%/%m%/%Y à %Hh%i') AS offerDate, o.bio bio_offer, o.troc troc_offer, 
      o.season saison_offer, v.name variete_offer, v.category category_fruit, m.pseudo member_offer FROM offer o INNER JOIN variety v ON v.idVariety = o.Variety_idVariety INNER JOIN member m 
      ON o.Member_idMember = m.idMember ORDER BY o.numOffer DESC");


		while($donnees = $reponse -> fetch()) {

      if($donnees['disponibility_offer'] > 0) {
			if(isset($_SESSION['pseudo']) AND $_SESSION['pseudo'] !== "") {
				if($donnees['member_offer'] === $_SESSION['pseudo']) {

echo "<br/><br/><br/><div class='offre1'>";
echo "<div class='col-md-1'></div><div class='col-md-5'><p>N°OFFRE : " . $donnees["numOffer"] . "</p>";
echo "<p><img class='picture' src='" .$donnees["picture_offer"]. "'/></p><p>Soumis le : " .$donnees["offerDate"] . "</p></div><div class='col-md-1'></div><div class='col-md-5'>
<p>Catégorie : " . $donnees["category_fruit"] . "</p>";
echo "<p>Nom : <strong>" . $donnees["variete_offer"] . "</strong></p>";
echo "<p>Quantité : " .$donnees["quantity_offer"] . " " .$donnees["quantityType_offer"] . "</p>";
echo "<p>Prix : " .$donnees["price_offer"] . " " .$donnees["priceType_offer"] . "</p>";
if($donnees["saison_offer"] != NULL) {
	echo "<p>Saison : oui</p>";
}
else {
	echo "<p>Saison : non";
}
if($donnees["bio_offer"] != NULL) {
	echo "<p>Bio : oui</p>";
}
else {
	echo "<p>Bio : non";
}
if($donnees["troc_offer"] != NULL) {
	echo "<p>Possibilité de troc : oui</p>";
}
else {
	echo "<p>Possibilité de troc : non";
}

echo "<p>Disponibilité : " .$donnees["disponibility_offer"] . " jours</p>";
echo "</div><div class='col-md-1'></div>";
if(isset($donnees['description_offer']) AND $donnees['description_offer'] != " ") {
echo "<div class='col-md-12'>Description : " .$donnees["description_offer"] . "</div>";
}


$i = $donnees['numOffer'];

echo " <form name='supprimerOffre' action='supprimerOffre_post.php?variable=$i' method='post' accept-charset='utf-8'> <input type='submit' value='Supprimer' class='bouton'/> </form><a href='modifierOffre.php?variable=$i'><input type='submit' value='Modifier' class='bouton'/></a></div><br/><br/>";


}

}
}

}

$reponse -> closeCursor();
?>
</div>

</div>
</div>


<?php
}

?>



  </body>

    <footer>
        <ul>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="planDuSite.php">Plan du site</a></li>
          <li><a href="aProposDeProxifruit.php">A propos de ProxiFruit</a></li>
        </ul>
    </footer>
    </div>

  </body>


</html>