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

               <h3>Mon compte</h3> 

                     <?php 
                    if(!isset($_SESSION['pseudo'])) {
                        echo "<div class='section'><p><a href='connexion.php'>Pour accéder à votre compte vous devez vous connecter</a></p></div><br/><br/><br/><br/>";
                    }
                   else{

                   ?>

             
            <div class="section">   
           <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-4"><br/>
          <div class="col-md-3"><a href="monProfil.php">Mon compte</a></div>
          <div class="col-md-3"><a href="gererMesOffres.php">Gérer mes offres</a></div>
          <div class="col-md-3"><a href="mesTransactions.php">Mes transaction</a></div>
          <div class="col-md-3"><a href="mesFavoris.php">Mes favoris</a></div>

<br/><br/><br/><div class='profil'>

  <h4>Mon profil</h4>


<?php

    $reponse = $bdd -> query("SELECT pseudo, name, firstName, picture, phone, address, cityPin, city, mail, description FROM member");
    while($donnees = $reponse -> fetch()) {

      if(isset($_SESSION['pseudo'])) {
        if($donnees['pseudo'] == $_SESSION['pseudo']) {

echo "<div class='col-md-5'>
          <p><img class='picture' src='" .$donnees["picture"]. "'/></p>
      </div>

     

      <div class='col-md-7'>
          <p>Pseudo : " . $donnees["pseudo"] . "</p>";
          if(isset($donnees['name'])) {
              echo "<p>Nom : " .$donnees["name"] . "</p>";
          }
          if(isset($donnees['firstName'])) {
              echo"<p>Prénom : " . $donnees['firstName'] . "</p>";
          }
          echo "<p><p>E-mail : " . $donnees['mail'] . "</p>";
          if(isset($donnees['address'])) {
              echo "<p><p>Adresse : " . $donnees['address'] . "</p>";
          }
          if(isset($donnees['cityPin'])) {
              echo "<p>Code postal : " . $donnees['cityPin'] . "</p>";
          }
          if(isset($donnees['city'])) {
              echo "<p>Ville : " . $donnees['city'] . "</p>";
          }
          if(isset($donnees['phone'])) {
              echo "<p>Téléphone : 0" . $donnees['phone'] . "</p>";
          }
          echo "</div><div class='col-md-12'>";
          if(isset($donnees['description'])) {
              echo "Description : " . $donnees['description'];
          }
        }
      }
    }
    $reponse -> closeCursor();

?>

			

<a href="modifProfil.php"><input class="bouton" type="submit" value="Modifier mon profil"/></a></div></div><br/>


<div class="pass">
		<h4>Modifier mon mot de passe</h4>
		<form name="modifMotDePasse" action="modifMotDePasse_post.php" method="post" accept-charset="utf-8">
		<div class="col-md-1"></div><div class="col-md-10"><p>Entrer un nouveau mot de passe : <input type="password" name="nvpassword" required></p>
		<p>Confirmer le nouveau mot de passe : <input type="password" name="nvpassword2" required></div></p><br/><br/><br/>
		<p><input type="submit" class="bouton" value="OK"/></p></form>
</div><br/>


<div class="eval">
    <h4>Mes évaluations</h4>

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

$reponse = $bdd -> prepare("SELECT c.comment comment, c.commentMark commentMark, c.idComment id FROM comment c INNER JOIN offer o ON c.offer_numOffer = o.numOffer INNER JOIN member m ON o.Member_idMember = m.idMember WHERE m.pseudo=?");
            $reponse -> execute(array($_SESSION['pseudo']));
            while($donnees = $reponse -> fetch()) {
              $req = $bdd -> prepare("SELECT m.pseudo pseudo, m.picture picture FROM member m INNER JOIN comment c ON c.Member_idMember = m.idMember WHERE idComment=?");
              $req -> execute(array($donnees['id']));
              while($donnees1 = $req -> fetch()) {
                echo "<div class='pass'>";
                echo "<p><div class='col-md-3'><img class='pictureEval' src='" .$donnees1["picture"]. "'/></div></p>";
                echo "<div class='col-md-9'>";
                echo note($donnees['commentMark']) . " de " . $donnees1['pseudo'] . "<br/>";
                echo  "<p>" . $donnees['comment'] . "</p>";
                echo "</div></div>";
                
              }
              $req -> closeCursor();
            }
            $reponse -> closeCursor();
?>


</div>
            


<br/><p><a href="supprimerCompte.php">Supprimer le compte</a></p>
   </div>
    </div>
  </div>


<?php
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




</html>
