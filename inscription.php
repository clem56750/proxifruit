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

    
        <h3>Inscrivez-vous</h3>
        <form  action="inscription_post.php" method="post" accept-charset="utf-8"> 
        <div class="row">
        <div class="col-md-2">
        </div>
        <section class="section">
        <div class="col-md-4">
          <div class="col-md-1">
          </div>
        <div class="col-md-5">
        <p><label for="pseudo">Pseudo :</label></p>
        <p><label for="pass">Mot de passe :</label></p>
        <p><label for="mail">E-mail :</label></p>
        <p><label for="mail2">Confirmation de l'e-mail :</label></p>
      </div>
      <div class="col-md-5">
        <p><input type="text" name="pseudo" SIZE="20" MAXLENGTH="45" required /></p>
        <p><input type="password" name="pass" SIZE="20" MAXLENGTH="45" required /></p>
        <p><input type="email" name="mail" SIZE="20" MAXLENGTH="45" required /></p>
        <p><input type="text" name="mail2" SIZE="20" MAXLENGTH="45" required /></p>
      </div>
              <input class="bouton" type="submit" value="M'inscrire"/>
              <br/><br/><br/><br/><br/><br/><br/><br/><br/><p>En cliquant sur M'inscrire, vous acceptez les <br/><a href='conditionsGenerales.php'>Conditions Générales d'utilisation.</p>
    </div> 
        </form>
        </section>


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