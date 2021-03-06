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

<h3>Noter et commenter un vendeur</h3>
    <div class="row">
        <div class="col-md-2">
        </div>
          <div class="section">
        <div class="col-md-4">

	<h2>Notation</h2>

<?php
if(isset($_GET['stars'])) {
	echo "<form  action='noterCommenterOffre_post.php?variable=" . htmlspecialchars($_GET['variable']) . "&amp;stars=" . htmlspecialchars($_GET['stars']) . "' method='post' accept-charset='utf-8'> ";
}
else {
	echo "<form  action='noterCommenterOffre_post.php?variable=" . htmlspecialchars($_GET['variable']) . "&amp;stars=0' method='post' accept-charset='utf-8'> ";
}

	?>
	<div class="rating rating2"><!--
		--><a href="?variable=<?php echo htmlspecialchars($_GET['variable']) ?>&amp;stars=5" title="Très bon">★</a><!--
		--><a href="?variable=<?php echo htmlspecialchars($_GET['variable']) ?>&amp;stars=4" title="Bon">★</a><!--
		--><a href="?variable=<?php echo htmlspecialchars($_GET['variable']) ?>&amp;stars=3" title="Moyen">★</a><!--
		--><a href="?variable=<?php echo htmlspecialchars($_GET['variable']) ?>&amp;stars=2" title="Mauvais">★</a><!--
		--><a href="?variable=<?php echo htmlspecialchars($_GET['variable']) ?>&amp;stars=1" title="Nul">★</a>
	</div><br/>




	<h2>Commentaire</h2>
	<textarea name="commentaire" rows="6" cols="95" MAXLENGTH="255" required> </textarea>

	<p><input class="bouton" type="submit" value="OK"/></p>

</form>

	


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