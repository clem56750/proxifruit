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
        
        <h3>Fruits & Légumes</h3>

        <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
          <?php
          if(isset($_SESSION['pseudo'])) {
          $req = $bdd -> prepare("SELECT memberType FROM member WHERE pseudo=?");
          $req -> execute(array($_SESSION['pseudo']));
          while($donnees2 = $req -> fetch()) {
            if($donnees2['memberType'] == 2) {
            echo "<a href='ajouterUnFruit.php'><input type='submit' value='Ajouter un fruit ou un légume' class='bouton1'/></a>";
            }
          }
          $req -> closeCursor();
        }
        ?>
        <div class="col-md-4">

      <?php
           try {
              $bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e) {
              die("Erreur :".$e -> getMessage());
            }

            echo "<div class='col-md-2'></div><div class='col-md-5'><h4>Fruits</h4>";
            $reponse = $bdd -> prepare("SELECT idVariety, name FROM variety WHERE category=? ORDER BY name");
            $reponse -> execute(array('Fruit'));
            while($donnees = $reponse -> fetch()) {
              $i = $donnees['idVariety'];
              echo "<p><a href='ficheFruitLegume.php?variable=$i'>". htmlspecialchars($donnees['name']) ."</a></p>";

            }
            $reponse -> closeCursor();

            echo "</div><div class='col-md-1'></div><div class='col-md-5'><h4>Légumes</h4>";
            $reponse = $bdd -> prepare("SELECT idVariety, name FROM variety WHERE category=? ORDER BY name");
            $reponse -> execute(array('Légume'));
            while($donnees = $reponse -> fetch()) {
              $i = $donnees['idVariety'];
              echo "<p><a href='ficheFruitLegume.php?variable=$i'>". htmlspecialchars($donnees['name']) ."</a></p>";
            }
            $reponse -> closeCursor();

      ?>         


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