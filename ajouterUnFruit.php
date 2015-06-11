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



              <h3>Ajouter un fruit ou un légume</h3>

                    <?php 

                    if(!isset($_SESSION['pseudo'])) {
                      echo "<div class='section'><p><a href='connexion.php'>Pour ajouter un fruit ou un légume vous devez être un administrateur</a></p></div><br/><br/><br/><br/>";
                    }

                    elseif (isset($_SESSION['pseudo'])) {
                      $reponse = $bdd -> prepare("SELECT memberType FROM member WHERE pseudo=?");
                      $reponse -> execute(array($_SESSION['pseudo']));
                      while($donnees = $reponse -> fetch()) {
                        if($donnees['memberType'] != 2) {
                            echo "<div class='section'><p><a href='connexion.php'>Pour ajouter un fruit ou un légume vous devez être un administrateur</a></p></div><br/><br/><br/><br/>";
                        }
                        else {

                        ?>

              
        <div class="row">
        <div class="col-md-2">
        </div>
          <div class="section">
        <div class="col-md-4">
                    <form method="post" action="ajouterUnFruit_post.php" enctype="multipart/form-data">

                      
                    <div class="col-md-5">

    <!-- On limite le fichier à 100Ko -->
  <p><input type="hidden" name="MAX_FILE_SIZE" value="100000">
     <label for="avatar"> Ajoutez une photo (max 100Ko)</label><br />
     <input type="file" name="avatar" required/><br /></p>

         <p>Catégorie : <select name="category">
                      <?php
                        $reponse= $bdd->query("SELECT categoryName FROM category");
                        while ($donnees =  $reponse->fetch())  {
                      ?>
                      <option value="<?php echo $donnees['categoryName'] ?>">
                      <?php 
                        echo $donnees['categoryName']; 
                      ?>
                      </option>
                      <?php
                        }
                        $reponse -> closeCursor();
                      ?>
                    </select></p>

      <p>Variété : <input name="variety" type="text" required></p>

      <p>Poids : <input name="poids" type="text" SIZE="5" required> grammes</p>

    <p>Description : <textarea name="description" rows="4" cols="38" MAXLENGTH="1000" required> </textarea></p>
                  </div>
                      <div class="col-md-1"></div>

                      <p>Période de saison du fruit ou du légume :</p>
                      <div class="col-md-1"></div>

                      <div class="col-md-3">
                      <p><label for="janvier">Janvier</label> <input type="checkbox" name="janvier" value="oui"/></p>
                      <p><label for="fevrier">Février</label> <input type="checkbox" name="fevrier" value="oui"/></p>
                      <p><label for="mars">Mars</label> <input type="checkbox" name="mars"  value="oui"/></p>
                      <p><label for="avril">Avril</label> <input type="checkbox" name="avril"  value="oui"/></p>
                      <p><label for="mai">Mai</label> <input type="checkbox" name="mai"  value="oui"/></p>
                      <p><label for="juin">Juin</label> <input type="checkbox" name="juin"  value="oui"/></p>
                      </div>


                      <div class="col-md-3">
                      <p><label for="juillet">Juillet</label> <input type="checkbox" name="juillet"  value="oui"/></p>
                      <p><label for="aout">Août</label> <input type="checkbox" name="aout"  value="janvier"/></p>
                      <p><label for="septembre">Septembre</label> <input type="checkbox" name="septembre"  value="oui"/></p>
                      <p><label for="octobre">Octobre</label> <input type="checkbox" name="octobre"  value="oui"/></p>
                      <p><label for="novembre">Novembre</label> <input type="checkbox" name="novembre"  value="oui"/></p>
                      <p><label for="decembre">Décembre</label> <input type="checkbox" name="decembre"  value="oui"/></p>
                      </div>
                      


                      <input class='bouton1' type='submit' value='VALIDER'>




  </form>



      </div>
  </div>
</div>
                    <?php
                       }
                      }
                      $reponse -> closeCursor();
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