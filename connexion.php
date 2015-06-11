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



  
 
<h3>Connectez-vous</h3>

  <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4">

        <form name="login" action="connexion_post.php" method="post" accept-charset="utf-8">  
          <div class='col-md-2'></div>
        <div class="col-md-3">
        <p><label for="usermail">Pseudo ou Email :</label> </p>
        <p><label for="password">Mot de passe :</label></p>
      </div>
      <div class='col-md-1'></div>
      <div class="col-md-3">
        <p><input type="text" name="usermail" required/></p>
        <p><input type="password" name="password" required/></p>
      </div>
      <div class='col-md-12'>
              <input class="bouton" type="submit" value="Me connecter"/>
      </div>   


        </form>

        </div>
        <div class='col-md-12'>
        Pas encore inscrit ? Inscrivez-vous <a href='inscription.php'>ici</a><br/><br/><br/><br/>
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




