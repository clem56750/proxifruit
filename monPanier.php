  <?php
  session_start ();
  ?>

  <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="main2.css">
      <title>ProxiFruit</title>
    <link rel="icon" href="upload/icone.PNG" />
  <title>ProxiFruit</title>

  <script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>

<script>
function maPosition(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  
  document.getElementById("lat").value = latitude;
  document.getElementById("lng").value = longitude;

}

if(navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(maPosition);
}


</script>



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
              $bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
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
 







<h3>Mon panier</h3>
                     <?php 
                    if(!isset($_SESSION['pseudo'])) {
                        echo "<div class='section'><p><a href='connexion.php'>Pour accéder à votre panier vous devez vous connecter</a></p></div><br/><br/><br/><br/>";
                    }
                   else{

                   ?>

<form action="distancePanier.php" method="post" accept-charset="utf-8"> 
<input type="hidden" name="lat" id="lat" value=""/> 
<input type="hidden" name="lng" id="lng" value""/>
<input type='submit' class='bouton' value='Trier les offres par distance'>
</form><br/>


  <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4">


<?php
  try {
    $bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e) {
    die("Erreur :".$e -> getMessage());
  }

  $reponse3 = $bdd ->prepare("SELECT idMember FROM member WHERE pseudo=? ");
  $reponse3 -> execute(array($_SESSION['pseudo']));
  while($donnees3 = $reponse3 -> fetch()) {

$reponse2 = $bdd -> prepare("SELECT DISTINCT offer_numOffer FROM offer_has_panier WHERE Member_idMember=?");
$reponse2 -> execute(array($donnees3['idMember']));
 if ($reponse2 -> RowCount() == 0){
     echo "<a href='voirLesOffres.php'>Votre panier est vide !</a>";
  }
  else {
  while($donnees2 = $reponse2 -> fetch()) {

$reponse4 = $bdd -> prepare("SELECT offer_numOffer FROM member_select_offer WHERE offer_numOffer=?");
$reponse4 -> execute(array($donnees2['offer_numOffer']));
if($reponse4 -> RowCount() == 0) {




  $reponse = $bdd -> query("SELECT o.picture picture_offer, o.price price_offer, o.priceType priceType_offer, o.qty quantity_offer, o.qtyType quantityType_offer, o.description description_offer, DATEDIFF(o.limitDate, NOW()) AS disponibility_offer, DATE_FORMAT(o.offerDate, '%d%/%m%/%Y à %Hh%i') AS offerDate, o.bio bio_offer,o.troc troc_offer, o.season saison_offer,  o.Member_idMember id_vendeur, v.name variete_offer, v.category category_fruit, m.idMember id_acheteur, m.pseudo acheteur, ohp.offer_numOffer numOffer FROM offer o INNER JOIN variety v ON v.idVariety = o.Variety_idVariety INNER JOIN offer_has_panier ohp ON ohp.offer_numOffer = o.numOffer INNER JOIN member m ON m.idMember = ohp.Member_idMember");

    while($donnees = $reponse -> fetch()) {


      $reponse1 = $bdd ->prepare("SELECT pseudo FROM member WHERE idMember=?");
      $reponse1 -> execute(array($donnees['id_vendeur']));
      while($donnees1 = $reponse1 -> fetch()) {

      if(isset($_SESSION['pseudo']) AND $_SESSION['pseudo'] == $donnees['acheteur']) {
        if($donnees['disponibility_offer']>0) {


echo "<div class='offre'>
            <div class='col-md-1'>
            </div>
            <div class='col-md-5'>
                <p>N°OFFRE : " . $donnees['numOffer'] ."</p>
                <p><img class='picture' src='" .$donnees["picture_offer"]. "'/></p>
                <p>Soumis le : " .$donnees["offerDate"] . "</p>
            </div>
            <div class='col-md-5'>
                <p><strong>Vendeur : " . $donnees1['pseudo'] . "</strong></p>
                <p>Catégorie : " . $donnees["category_fruit"] . "</p>
                <p>Nom : " . $donnees["variete_offer"] . "</p>
                <p>Quantité : " .$donnees["quantity_offer"] . " " .$donnees["quantityType_offer"] . "</p>
                <p>Prix : " .$donnees["price_offer"] . " " .$donnees["priceType_offer"] . "</p>";
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
          echo "<p>Disponibilité : " .$donnees["disponibility_offer"] . " jours</p>
          </div>
          <div class='col-md-1'>
          </div>";
          if(isset($donnees['description_offer']) AND $donnees['description_offer'] != " ") {
              echo "<div class='col-md-12'>Description : <br/>" .$donnees["description_offer"];
              
          }



          $i = htmlspecialchars($donnees['numOffer']);
          echo "<p><form name='supprimerOffrePanier' action='supprimerOffrePanier_post.php?variable=$i' method='post' accept-charset='utf-8'> 
          <input type='submit' value='Supprimer' class='bouton'/></form>
          <form name='validerOffrePanier' action='validerOffrePanier_post.php?variable=$i' method='post' accept-charset='utf-8'>
          <input type='submit' value='Acheter' class='bouton'/></form>
          </p></div></div><br/><br/>";
      
      


    }
  }
}
$reponse1 -> closeCursor();
}

$reponse -> closeCursor();
}
}

$reponse2 -> closeCursor();
}
}
$reponse3 -> closeCursor();


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