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

        <h3>Modification du profil</h3>
        <form  action="modifProfil_post.php" method="post" accept-charset="utf-8" enctype="multipart/form-data"> 
        <div class="row">
        <div class="col-md-2">
        </div>
        <section class="section">
        <div class="col-md-4">
          <div class="col-md-2">
          </div>
        <div class="col-md-3">

        <p><input type="hidden" name="MAX_FILE_SIZE" value="100000"><label for="nvphoto"> Photo (max. 100 Ko)</label><br/><br/>
        <label for="nvnom">Nom :</label><br/><br/>
        <label for="nvprenom">Prénom :</label><br/><br/>
        <label for="nvmail">E-mail :</label><br/><br/>
        <label for="nvadresse">Adresse :</label><br/><br/>
        <label for="nvcodepostal">Code postal :</label><br/><br/>
        <label for="nvville">Ville :</label><br/><br/>
        <label for="nvtelephone">Téléphone :</label><br/><br/><br/>
        <label for="nvdescription">Description :</label></p>
      </div>
      <div class='col-md-1'></div>
      <div class="col-md-5">
        <p><input type="file" name="nvphoto" id="nvphoto"/></p>
        <p><input type="text" name="nvnom" SIZE="20" MAXLENGTH="45"/></p>
        <p><input type="text" name="nvprenom" SIZE="20" MAXLENGTH="45"/></p>
        <p><input type="text" name="nvmail" SIZE="20" MAXLENGTH="45"/></p>
        <p><input type="text" name="nvadresse" SIZE="20" MAXLENGTH="45"/></p>
        <p><input type="text" name="nvcodepostal" SIZE="20" MAXLENGTH="45"/></p>
        <p><input type="text" name="nvville" SIZE="20" MAXLENGTH="45"/></p>
        <p><input type="text" name="nvtelephone" SIZE="20" MAXLENGTH="45"/></p>
        <p><textarea name="nvdescription" rows="6" cols="35" MAXLENGTH="255"> </textarea></p>
      </div>
      <div class='col-md-1'></div>
              <br/><p><input class="bouton" type="submit" value="Valider"/></p>
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
</html>
