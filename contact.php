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

          <h3>Contact</h3>

        <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4">  

		<div>
			<div>
				<?php
				if(array_key_exists('errors', $_SESSION)): ?>

					<?php echo implode('<br>', $_SESSION['errors']);
				
					
				endif;?>
				<?php if(array_key_exists('sucess', $_SESSION)): ?>

					 Votre mail a bien été envoyé!
					
				<?php endif;
				?>

				<form action="contact_post.php" method="POST">
					<div class="col-md-1"></div>
					<div class="col-md-5">
						<p><label for="name">Votre nom :</label> </p>
						<p><label for="firstname">Votre prénom : </label> </p>
						<p><label for="mail">Votre e-mail : </label> </p>
						<p><label for="objet">Objet du message : </label> </p>
						<p><label for="message">Votre message :</label> </p>
					</div>
					<div class='col-md-5'>
					<p><input  type="text" name="name" SIZE="25" MAXLENGTH="40" required/></p>
					<p><input  type="text" name="firstname" SIZE="25" MAXLENGTH="40" required/></p>
					<p><input  type="mail" name="mail" SIZE="25" MAXLENGTH="40" required/></p>
					<p><input  type="text" name="objet" SIZE="25" MAXLENGTH="40" required/></p>
					 <p><textarea name="message" cols="27" SIZE="25" MAXLENGTH="255" required/></textarea></p>
					</div>
				
				
				<button type="submit" class="bouton">Valider</button>
				
				</form>
</div>
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


<?php
unset($_SESSION['errors']);
unset($_SESSION['sucess']);
unset($_SESSION['inputs']);
?>
