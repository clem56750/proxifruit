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


             <h3>Membres</h3> 

           <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4"> 




<?php

            function note($note) {
              echo "<span style='font-size: 27px'>";
                if($note > 0 AND $note <= 1) {
                  echo "<span style='color: red'>★</span><span style='color: #C0C0C0'>★★★★</span>";
                }
                elseif($note > 1 AND $note <= 2) {
                  echo "<span style='color: red'>★★</span><span style='color: #C0C0C0'>★★★</span>";
                }
                elseif($note > 2 AND $note <= 3) {
                  echo "<span style='color: red'>★★★</span><span style='color: #C0C0C0'>★★</span>";
                }
                elseif($note > 3 AND $note <= 4) {
                 echo "<span style='color: red'>★★★★</span><span style='color: #C0C0C0'>★</span>";
                }
                elseif($note > 4 AND $note <= 5) {
                  echo "<span style='color: red'>★★★★★</span>";
                }
                else {
                  echo "<span style='color: #C0C0C0'>★★★★★</span>";
                }
                echo "</span>";
              }


          try {
              $bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e) {
              die("Erreur :".$e -> getMessage());
            }

		$reponse = $bdd -> query("SELECT pseudo, picture, description, idMember, memberType FROM member");
		while($donnees = $reponse -> fetch()) {
      if((isset($_SESSION['pseudo']) AND $donnees['pseudo'] != $_SESSION['pseudo']) OR !isset($_SESSION['pseudo'])) {
			echo "<br/><div class='membre'>
					<div class='col-md-3'>
						<br/><img class='picture' src='" . htmlspecialchars($donnees["picture"]) . "'/>
					</div> 
					<div class='col-md-2'>
					</div>
					<div class='col-md-7'>
						<p><strong>Pseudo : " . htmlspecialchars($donnees['pseudo']) . "</strong></p>";

            if($donnees['description'] != NULL) {
             echo "<p>Description : " . htmlspecialchars($donnees['description']) . "</p>";
           }


            $req = $bdd -> prepare("SELECT AVG(c.commentMark) AS commentMark FROM comment c INNER JOIN offer o ON c.offer_numOffer = o.numOffer INNER JOIN member m ON o.Member_idMember = m.idMember WHERE pseudo=?");
            $req -> execute(array($donnees['pseudo']));
            while($donnees1 = $req -> fetch()) {
              if(isset($donnees1['commentMark'])) {
                echo note($donnees1['commentMark']) . "<br/>";
              }
            }
            $req -> closeCursor();


            $req = $bdd -> prepare("SELECT Member_idMember FROM offer WHERE Member_idMember=? LIMIT 0,1");
            $req -> execute(array($donnees['idMember']));
            while($donnees1 = $req -> fetch()) {
              if(isset($donnees1['Member_idMember'])){
                $j = $donnees1['Member_idMember'];
            echo "<a href='voirOffreMembre.php?variable=$j'><input type='submit' value='Voir les offres de ce membre' class='bouton'/></a>";
          }
            }
          $req -> closeCursor();

          if(isset($_SESSION['pseudo'])) {
          $req = $bdd -> prepare("SELECT memberType FROM member WHERE pseudo=?");
          $req -> execute(array($_SESSION['pseudo']));
          while($donnees2 = $req -> fetch()) {
            if($donnees2['memberType'] == 2) {
              if($donnees['memberType'] != 2) {
            echo "<a href='supprimerMembre.php?variable=$j'><input type='submit' value='Supprimer ce membre' class='bouton1'/></a>";
            }
          }
        }
          $req -> closeCursor();
        }

					echo "</div>
				</div>";
      }
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
</html>