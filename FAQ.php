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

        <h3>FAQ</h3>

        <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4"> 


          <h2 class="titres">
            INSCRIPTION / AUTHENTIFICATION
          </h2>
            <p class="questions">
            1.  J’ai déjà un compte mais je n’arrive pas à m’authentifier sur le site, comment faire ?
            </p>
              <p class="reponses">
            Soit vous avez mal renseigné vos identifiants personnels, soit vous avez oublié votre mot de passe/pseudo (ou e-mail). Dans ces cas là, il sera nécessaire de :
<br/>-soit créer un nouveau compte avec les bons identifiants.
<br/>-soit envoyer un e-mail à un administrateur (cliquez sur <a href="contact.php">contact</a> en bas de la page) pour pouvoir changer vos identifiants.
              </p><br/>
            <p class="questions">
            2.  Je suis un simple visiteur et je ne peux accéder à certaines fonctionnalités du site.
            </p>
              <p class="reponses">
            Si vous voulez avoir accès au site dans sa globalité, il est nécessaire de s’inscrire en créant un nouveau compte (possible depuis toutes les pages du site).
              </p><br/>
          <h2 class="titres">
            RECHERCHE DE DENREES
          </h2>
            <p class="questions">
            3.  La carte de géolocalisation ne fonctionnant pas, je ne parviens pas à faire de recherche de fruits/légumes.
            </p>
              <p class="reponses">
            Il existe alors d’autres systèmes de recherche : recherche simple (par catégorie, variété, numéro d'offre et pseudo du vendeur). Vous pouvez également accéder à toutes les offres postées par les membres vendeurs dans l'onglet : <a href="voirLesOffres.php">Voir les offres</a>.
              </p><br/>
            <p class="questions">
            4.  Malgré tous mes efforts, je ne trouve pas d’offre en lien avec ma recherche.
            </p>
              <p class="reponses">
            Sur ce point-là, nous ne pouvons rien faire malheureusement, cela dépend uniquement de la disponibilité des offres et de leur diversité. Il n’y a donc qu’une chose à faire ; patienter ou si votre requête ne peut attendre, trouver un autre moyen (d’autres sites et distributeurs de fruits/légumes sont à votre disposition).
              </p><br/>
          <h2 class="titres">
          FAIRE UNE OFFRE
          </h2>
            <p class="questions">
            5.  Je souhaiterais faire une offre sur le site mais je n’y parviens pas.
            </p>
              <p class="reponses">
            Pour poster une offre, il faut être inscrit et avoir complété l'inscription avancée. Il est ensuite nécessaire de cliquer sur « <a href="faireUneOffre.php">faire une offre</a> » et de remplir tous les champs obligatoires (prix, quantité, disponibilité etc…). Une fois tous les champs remplis, il suffit de valider l’offre. Si le problème persiste, alors il faut contacter un administrateur (cliquez sur « <a href="contact.php">contact</a> » en bas de la page). Ensuite vous pourrez modifier ou supprimer cette offre à tout moment. Elle sera retirée dès que vous aurez accepté une transaction avec un membre acheteur ou que la date de disponibilité de l'offre sera dépassée.
              </p><br/>

          <h2 class="titres">
            TRANSACTION ENTRE UN MEMBRE VENDEUR ET UN MEMBRE ACHETEUR
          </h2>
            <p class="questions">
            6.  Comment se déroule la transaction ?
            </p>
              <p class="reponses">
            Une fois que le membre acheteur clique sur « Acheter », un e-mail avertit le membre vendeur. Si le membre vendeur accepte la transaction les deux membres recevront un e-mail contenant les informations de l'autre. Les membres devront se contacter pour convenir d'un rendez-vous.
              </p><br/>
          <h2 class="titres">
            ARNAQUES

          </h2>
            <p class="questions">
            7.  Je suis victime d’une escroquerie, comment puis-je me défendre ?
            </p>
              <p class="reponses">
            Lors d'un échange, pensez à vérifier la qualité des produits. Dans le cas d’un échange non équitable, le site « proxifruit.fr » n'est pas responsable. Vous pouvez cependant vous fier au système de notation des vendeurs (par le biais de commentaires et de notes sur les offres précédentes). Dans le cas d’un vol de produits (cela restant très rare pour ce genre de commerce) ou autre, nous avons accès aux coordonnées et informations personnelles de tous nos membres. Il vous faudra d’abord porter plainte au commissariat puis nous pourrons fournir les éléments nécessaire à la résolution de l’enquête.

              </p><br/>
          <h2 class="titres">
            RESERVER UNE OFFRE
          </h2>
            <p class="questions">
            8.  Je souhaite réserver une offre qui m’intéresse.
            </p>
              <p class="reponses">
            Il suffit de sélectionner l’offre que vous désirez en cliquant sur « sélectionner cette offre », ainsi l’offre sera automatiquement ajoutée à votre panier. Pour terminer votre commande vous devrez vous rendre dans votre « <a href='monPanier.php'>panier</a> » et cliquer sur « Acheter ».  
              </p><br/>
          <h2 class="titres">
            PAS DE PAIEMENT EN LIGNE
          </h2>
            <p class="questions">
            9. J’ai réservé une offre et je souhaite payer en ligne.
            </p>
              <p class="reponses">
            Le paiement en ligne n’est pas disponible sur « proxifruit.fr ». Son seul objectif est de mettre en relation ses membres pour favoriser le commerce de proximité. Les transactions ont donc lieu en dehors de la responsabilité du site, le vendeur et l’acheteur doivent prendre rendez-vous et réaliser la vente ou le troc à l’amiable. 
              </p><br/>
          <h2 class="titres">
            COMMENTAIRE NEGATIF
          </h2>
            <p class="questions">
            10. Je suis vendeur et mon commerce se voit affecté par des commentaires négatifs sur mes transactions. 
            </p>
              <p class="reponses">
            Malheureusement, nous ne pouvons rien faire pour vous. Si les utilisateurs peuvent poster des commentaires avec avis positif ou négatif, c’est justement pour différencier « les bons et les mauvais » vendeurs. Cependant si vous trouvez que certains commentaires sont insultants ou qu’ils n’ont pas lieu d’être alors vous pouvez vous plaindre à un administrateur en nous contactant (rubrique : « <a href="contact.php">contact</a> » en bas de la page).
              </p><br/>
          <h2 class="titres">
            DONNER SON AVIS SUR UN VENDEUR
          </h2>
            <p class="questions">
            11. Je souhaiterais donner mon avis sur une offre ou sur un membre mais je n’y parviens pas, quelle est la démarche à suivre ?
            </p>
              <p class="reponses">
            A la suite d'une transaction avec un autre membre vous pourrez noter et commenter celui-ci. Si vous êtes satisfait du comportement du membre ou du déroulement de la transaction, vous pouvez poster un avis positif sur le profil du membre concerné ou au contraire avis négatif si celui-ci vous a vendu des denrées de mauvaise qualité par exemple.
              </p><br/>
          <h2 class="titres">
         CONTACTER UN MEMBRE   
          </h2>
            <p class="questions">
            12. Je souhaiterais contacter un membre qui a réservé mon offre/possède une offre intéressante.
            </p>
              <p class="reponses">
            Si le membre acheteur a validé une offre et que le membre vendeur accepte la transaction alors les deux membres recevront un e-mail contenant les informations de l'autre. Néanmoins, si l’autre membre persiste à ne pas répondre alors cherchez une autre offre (pour le membre acheteur) ou remettez votre offre en ligne (pour le membre vendeur).
              </p><br/>
          <h2 class="titres">
            GERER MES OFFRES
          </h2>
            <p class="questions">
            13. Comment puis-je gérer l’inventaire de mes offres ?
            </p>
              <p class="reponses">
            La page « <a href="gererMesOffres.php">gérer mes offres</a> » concerne uniquement les vendeurs. La page contient toutes les offres publiées par le vendeur. Celle-ci classe les offres par ordre croissant selon 
            la date de publication et vous pouvez modifier les paramètres de chacune de vos offres autant de fois que vous le voulez.
              </p><br/><br/>
            <p class="reponses"><strong>Si vous n'avez pas trouvé de réponse à votre question alors contactez nous en nous envoyant un <a href="FAQ.php">mail</a> !</strong></p>    









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




</html>
