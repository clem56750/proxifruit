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

        <h3>Conditions générales</h3>

        <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4"> 


          <h2 class="titres">
            ARTICLE 1 - OBJET
          </h2>
              <p class="reponses">
Les conditions générales de ventes décrites ci-dessous détaillent les droits et obligations de l'entreprise
propriétaire de l'enseigne "ProxiFruit" et de ses clients dans le cadre de la mise en contact de membres et de potentielles transactions.<br/> Toute prestation accomplie par la société ProxiFruit implique l'adhésion sans réserve de l'acheteur aux présentes conditions générales de vente.
              </p>


          <h2 class="titres">
        ARTICLE 2 - SUPPRESSION DE COMPTE
          </h2>
              <p class="reponses">
Si l'administrateur reçoit de trop nombreuses plaintes vis-à-vis d'un membre, son compte sera supprimée. 
              </p><br/>


          <h2 class="titres">
        ARTICLE 3 - PRESENTATION DES PRODUITS
          </h2>
              <p class="reponses">
Les caractéristiques des produits proposés à la vente sont présentées dans la rubrique " <a href="FruitsLegumes.php">Fruits&Légumes</a> de notre site. Les photographies n'entrent pas dans le champ contractuel. La responsabilité de la société
ProxiFruit ne peut être engagée si des erreurs s'y sont introduites. Tous les textes et images
présentés sur le site proxifruit.fr sont réservés, pour le monde entier, au titre des droits d'auteur et de
propriété intellectuelle; leur reproduction, même partielle, est strictement interdite.
              </p><br/>

          <h2 class="titres">
          ARTICLE 4 - DUREE DE LA VALIDITE DES OFFRES DE VENTE
          </h2>
              <p class="reponses">
Dès qu'une offre dépasse sa date de validité, elle sera automatiquement enlevée des offres.
              </p><br/>

          <h2 class="titres">
            ARTICLE 5 - PRIX DES PRODUITS
          </h2>
              <p class="reponses">
Le prix des produits varie selon les utilisateurs (selon la variété et la qualité de la denrée) avec toute
fois une limite pour ne pas excéder un certain seuil de prix. La TVA n'affecte pas les transactions
puisqu'elles sont effectuées entre particuliers à l'amiable lors d'échanges et ventes hors du site (à but
non lucratif). De plus, il n'y a donc pas de frais de port vu que les ventes n'apparaissent point sur le
site « proxifruit.fr ».
Le paiement en ligne n'est pas disponible sur notre site.

              </p><br/>
          <h2 class="titres">
            ARTICLE 6 - COMMANDE
          </h2>
              <p class="reponses">
Le membre achteur valide sa commande lorsqu'il active le lien " Acheter " dans l'onglet " Mon panier ". Avant cette
validation, le client se doit de vérifier chacun des éléments de sa commande. La société ProxiFruit confirme la réservation des produits par courrier électronique. Les données enregistrées par la société ProxiFruit constituent la preuve de la nature, du contenu et de la date de la commande. Celles-ci sont archivée par notre société.

              </p><br/>
          <h2 class="titres">
            ARTICLE 7 - MODALITES DE PAIEMENT
          </h2>
              <p class="reponses">
Le règlement des commandes s'effectue en dehors du site « proxifruit.fr » et les transactions sont
réalisées lorsque les deux individus concernés prennent contact et se donnent rendez-vous.
              </p><br/><br/><br/>
         

      </div>
    </div>
  </div>


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
