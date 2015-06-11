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




          <h3>Modifier l'offre :</h3>

              
          <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4">

<?php
$i = htmlspecialchars($_GET['variable']);
                    echo "<form method='post' action='modifierOffre_post.php?variable=$i' enctype='multipart/form-data'>";
?>
                    <div class="col-md-5">
                        <p>
    <!-- On limite le fichier à 100Ko -->
  <input type="hidden" name="MAX_FILE_SIZE" value="100000">
     <label for="nvavatar">Ajoutez une photo (max 100Ko)</label><br />
     <input type="file" name="nvavatar"/><br />
    </p>
                      <p>Description :</p> <textarea name="nvdescription" rows="6" cols="35" MAXLENGTH="255"> </textarea>
            <p>Votre offre sera disponible jusqu'au : <input type="date" name="nvrdv"></p>
                  </div>

                      <div class="col-md-2"></div><div class="col-md-5">

                      <p>Variété : <select name="nvvariety">
                        <option value=" "> </option>
                      <?php
                        $reponse= $bdd->query("SELECT name FROM variety");
                        while ($donnees =  $reponse->fetch())  {
                      ?>
                      <option value="<?php echo $donnees['name'] ?>">
                      <?php 
                        echo $donnees['name']; 
                      ?>
                      </option>
                      <?php
                        }
                        $reponse -> closeCursor();
                      ?>
                    </select></p>

                      <p><label for="de saison">De saison </label> <input type="checkbox" name="nvdesaison" id="nvdesaison" value="de saison"/></p>
                      <p><label for="bio">Bio </label> <input type="checkbox" name="nvbio" id="nvbio" value="bio"/></p>
                      <p><label for="troc">Troc </label> <input type="checkbox" name="nvtroc" id="nvtroc" value="troc"/></p>
                      <p>Quantité : <input name="nvquantite" type="text" size="2">
                        <select name="nvunite"><option value=" "> </option><option value="kg">kg</option> <option value="pièce(s)">pièce(s)</option></select></p>
                      <p>Prix (€) : <input name="nvprix" type="text"></p>
                  </div>

                     <p><input class='bouton' type='submit' value='VALIDER'></p>
                 
  </form>





                 

                      
                      


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