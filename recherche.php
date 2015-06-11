  <?php
  session_start ();

    function getXmlCoordsFromAdress($address) {
      $coords=array();
      $base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
      // ajouter &region=FR si ambiguité (lieu de la requete pris par défaut)
      $request_url = $base_url . "address=" . urlencode($address).'&sensor=false';
      $xml = simplexml_load_file($request_url) or die("url not loading");
      //print_r($xml);
      $coords['lat']=$coords['lon']='';
      $coords['status'] = $xml->status ;
      if($coords['status']=='OK') {
        $coords['lat'] = $xml->result->geometry->location->lat ;
        $coords['lon'] = $xml->result->geometry->location->lng ;
      }
      return $coords;
    }


  try {
    $bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e) {
    die("Erreur :".$e -> getMessage());
  }


  $reponse = $bdd -> query("SELECT address, cityPin, city FROM member");

  $listeDesPoints='';

  while($donnees = $reponse -> fetch()) {


  $coords=getXmlCoordsFromAdress($donnees['address'].", ".$donnees['cityPin']." ".$donnees['city']);
  
        if($listeDesPoints!='') $listeDesPoints.=','; //ajoute la virgule de séparation des points
          $listeDesPoints.='['.$coords['lat'].', '.$coords['lon'].']';
  }

$reponse -> closeCursor();
?>




<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="main2.css">
        <title>ProxiFruit</title>
    <link rel="icon" href="upload/icone.PNG" />

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&language=fr">
</script>
  <script type="text/javascript">
var geocoder;
var map;
// initialisation de la carte Google Map de départ
function initialiserCarte() {
  geocoder = new google.maps.Geocoder();
  // Ici j'ai mis la latitude et longitude du vieux Port de Marseille pour centrer la carte de départ
  var latlng = new google.maps.LatLng(48.853,2.35);
  var mapOptions = {
    zoom      : 11,
    center    : latlng,
    mapTypeId : google.maps.MapTypeId.ROADMAP
  }
  // map-canvas est le conteneur HTML de la carte Google Map
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

 
 var liste_des_points = [<?php echo $listeDesPoints;?>];

imageMarqueur = new google.maps.MarkerImage('http://www.google.fr/url?source=imglanding&ct=img&q=http://publicdomainvectors.org/photos/squat-marker-green.png&sa=X&ei=tU9bVfiJFMz1UM_PgbgM&ved=0CAkQ8wc4Og&usg=AFQjCNHJsPakILmnjwcm49BYKj4n7lLMIA', new google.maps.Size(71, 71), new google.maps.Point(0,0), new google.maps.Point(17, 34), new google.maps.Size(25,25));
 
var i=0,li=liste_des_points.length;
while(i<li){
  new google.maps.Marker({
          position: new google.maps.LatLng(liste_des_points[i][0], liste_des_points[i][1]),
          map: map,
          title: "Marqueur-"+i
     });
  i++;
}

}
 
function TrouverAdresse() {
  // Récupération de l'adresse tapée dans le formulaire
  var adresse = document.getElementById('adresse').value;
  geocoder.geocode( { 'address': adresse}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      // Création du marqueur du lieu (épingle)
      var marker = new google.maps.Marker({
          map: map,
          icon: imageMarqueur,
          position: results[0].geometry.location
       });
    } else {
      alert('Adresse introuvable: ' + status);
    }
  });
}
// Lancement de la construction de la carte google map
google.maps.event.addDomListener(window, 'load', initialiserCarte);
</script>
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

            <h3>Recherche</h3>
      

        <div class="row">
        <div class="col-md-2">
        </div>
        <div class="section">
        <div class="col-md-4">
              <h3>Recherche par rubrique :</h3>
                <div class="col-md-5">
                  <div class="thumbnail">
                    <form method="post" action="rechercheCategory.php">
                      Catégorie :
                      <select name="category">
                        <?php
                          try {
                            $bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                          }
                          catch(Exception $e) {
                            die("Erreur :".$e -> getMessage());
                          }
                          $reponse = $bdd->query("SELECT categoryName FROM category");
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
                      </select>
                    <input type="submit" value="Rechercher" class="bouton"/>
                  </form>
                  </div>
                </div><div class="col-md-2"></div>
                <div class="col-md-5">
                  <div class="thumbnail">
                    <form method="post" action="rechercheVariete.php">
                    Variété :
                    <select name="variety">
                      <?php
                        $reponse = $bdd->query("SELECT name FROM variety");
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
                    </select>
                    <input type="submit" value="Rechercher" class="bouton"/>
                  </form>
                  </div>
                </div><br/><br/><br/><br/><br/><br/>
                <div class="col-md-5">
                  <div class="thumbnail">
                    <form method="post" action="recherchePseudo.php">
                    <label for="pseudoVendeur">Pseudo vendeur : </label><input type="text" name="pseudoVendeur">
                    <input type="submit" value="Rechercher" class="bouton"/>
                  </form>
                  </div>
                </div><div class="col-md-2"></div>
                <div class="col-md-5">
                  <div class="thumbnail">
                    <form method="post" action="rechercheNumOffre.php">
                    <label for="numeroOffre">Numéro offre : </label><input type="text" name="numeroOffre"> </span>
                    <input type="submit" value="Rechercher" class="bouton"/>
                  </form>
                  </div>
                </div><br/><br/><br/><br/><br/><br/><br/><br/><br/>



            <h3>Recherche par carte :</h3>
            <div class="col-md-1">
            </div>
            <div class="col-md-10">
            <form>
              <p><input type="text" id="adresse"/> <input type="button"  value="OK" onclick="TrouverAdresse();" class="bouton" /></p>
            </form>
            <span id="text_latlng"></span>
            <div id="map-canvas"></div>
          </div>


          </div>
        </div>
      </div>



      

    <p id="rechercheavancee"><a href="#">Faire une Recherche avancée</a></p>





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












