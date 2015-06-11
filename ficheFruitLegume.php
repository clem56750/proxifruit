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
          
        
          

      <?php

                    function paint($donnees, $month) {
                if($donnees[$month] == 'oui') {
                  echo "<td style='background-color: #33FF00'>" . $month . "</td>";
                }
                else {
                  echo "<td>" . $month . "</td>";
                }
              }


           try {
              $bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e) {
              die("Erreur :".$e -> getMessage());
            }

            $reponse = $bdd -> prepare("SELECT name, category, averageWeight, description, picture, Janvier, Février, Mars, Avril, Mai, Juin, Juillet, Août, Septembre, Octobre, Novembre, Décembre FROM variety WHERE idVariety=?");
            $reponse -> execute(array(htmlspecialchars($_GET['variable'])));

            while($donnees = $reponse -> fetch()) {

            echo "<h3>" . $donnees["name"] . "</h3>
                  <div class='row'><div class='col-md-2'></div><div class='section'><div class='col-md-4'><div class='col-md-5'><p><img class='picture' src='" .$donnees["picture"]. "'/></p></div>
                  <div class='col-md-7'><br/><p>Catégorie : " .$donnees["category"] . "</p>
                  <p>Poids moyen : " . $donnees["averageWeight"] . " g</p>


                  
                  <p>Saison :<table border='1px'><tbody><tr>";

                  paint($donnees, "Janvier");
                  paint($donnees, "Février");
                  paint($donnees, "Mars");
                  paint($donnees, "Avril");
                  echo "</tr><tr>";
                  paint($donnees, "Mai");
                  paint($donnees, "Juin");
                  paint($donnees, "Juillet");
                  paint($donnees, "Août");
                  echo "</tr><tr>";
                  paint($donnees, "Septembre");
                  paint($donnees, "Octobre");
                  paint($donnees, "Novembre");
                  paint($donnees, "Décembre");

                  
                    echo "</tbody></table></p>";
                    echo "</div>
                  <div class='col-md-12'><p><strong>Description : </strong><br/>" .$donnees['description'] . "</p></div>";

                  if(isset($_SESSION['pseudo'])) {
                    $reponse1 = $bdd -> prepare("SELECT memberType FROM member WHERE pseudo=?");
                    $reponse1 -> execute(array($_SESSION['pseudo']));
                    while($donnees1 = $reponse1 -> fetch()) {
                      if($donnees1['memberType'] == 2) {
                        $j = htmlspecialchars($_GET['variable']);
                        echo "<a href='supprimerFruit.php?variable=$j'><input type='submit' value='Supprimer ce fruit/légume' class='bouton1'/></a>";
                      }
                    }
                    $reponse1 -> closeCursor();
                  }

                  echo "</div></div></div>";
            }
            $reponse -> closeCursor();

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