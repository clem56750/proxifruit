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
    $bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
    <title>
      Proxifruit
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="main2.css">
    <title>ProxiFruit</title>
    <link rel="icon" href="upload/icone.PNG" />
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


  <script type="text/javascript">


   if(navigator.geolocation) {



function initialize(position){
     var centreCarte = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        
     var optionsCarte = {
          zoom: 12,
          center: centreCarte,
        mapTypeId: google.maps.MapTypeId.ROADMAP                                     
     },
 
  carteGoogle = document.getElementById("carteGoogle"),
    Carte = new google.maps.Map(carteGoogle, optionsCarte),

     imageMarqueur = new google.maps.MarkerImage('http://www.google.fr/url?source=imglanding&ct=img&q=http://publicdomainvectors.org/photos/squat-marker-green.png&sa=X&ei=tU9bVfiJFMz1UM_PgbgM&ved=0CAkQ8wc4Og&usg=AFQjCNHJsPakILmnjwcm49BYKj4n7lLMIA', new google.maps.Size(71, 71), new google.maps.Point(0,0), new google.maps.Point(17, 34), new google.maps.Size(25,25));
 
 var liste_des_points = [<?php echo $listeDesPoints;?>];




var marqueur1 = new google.maps.Marker({
          position: centreCarte,
          map: Carte,
          title: "Vous êtes ici",
          icon: imageMarqueur
     });

 
var i=0,li=liste_des_points.length;
while(i<li){
  new google.maps.Marker({
          position: new google.maps.LatLng(liste_des_points[i][0], liste_des_points[i][1]),
          map: Carte,
          title: "Marqueur-"+i
     });
  i++;
}

}

    navigator.geolocation.getCurrentPosition(initialize);
      
}




$(document).ready(function(){
var $carrousel = $('#carrousel'), // on cible le bloc du carrousel
    $img = $('#carrousel ul li .elementC'), // on cible les images contenues dans le carrousel
    indexImg = $img.length - 1, // on définit l'index du dernier élément
    i = 0, // on initialise un compteur
    $currentImg = $img.eq(i); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)

$img.css('display', 'none'); // on cache les images
$currentImg.css('display', 'block'); // on affiche seulement l'image courante

$('.next').click(function(){ // image suivante
    
    i++; // on incrémente le compteur
    
    if( i <= indexImg ){
        
        $img.css('display', 'none'); // on cache les images
        $currentImg = $img.eq(i); // on définit la nouvelle image
        $currentImg.css('display', 'block'); // puis on l'affiche
        
    }
    else{
        i = indexImg;
    }
    
});

$('.prev').click(function(){ // image précédente

    i--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"

    if( i >= 0 ){
        $img.css('display', 'none');
        $currentImg = $img.eq(i);
        $currentImg.css('display', 'block');
    }
    else{
        i = 0;
    }

});

function slideImg(){
    setTimeout(function(){ // on utilise une fonction anonyme
                        
        if(i < indexImg){ // si le compteur est inférieur au dernier index
        i++; // on l'incrémente
    }
    else{ // sinon, on le remet à 0 (première image)
        i = 0;
    }

    $img.css('display', 'none');

    $currentImg = $img.eq(i);
    $currentImg.css('display', 'block');

    slideImg(); // on oublie pas de relancer la fonction à la fin

    }, 5000); // on définit l'intervalle à 2000 millisecondes (2s)
}

slideImg(); // enfin, on lance la fonction une première fois

});
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
        if(isset($_SESSION['usermail']) AND isset($_SESSION['password'])) {
          echo "<h4> Bonjour ".$_SESSION['pseudo']." !</h4><br/>";
        }
        ?>

        <section> 
                <div class="menugauche">
                            <h4>Envie d'un fruit frais près de chez vous ?</h4>
                            <p class="framboises menu">Choisissez</p>
                            <p class="chou menu">Contactez</p>
                            <p class="cerises menu">Dégustez</p>
                            <a href="voirLesOffres.php"><span class="voiroffre">Voir les Offres</span></a>

                </div>
                
        </section>



        <section> 
                 <div class="menudroite">
                            <h4>Envie d'écouler vos stocks rapidement ?</h4>
                            <p class="carambole menu">Proposez</p>
                            <p class="poivron menu">Validez</p>
                            <p class="raisin menu">Vendez</p>
                            <a href="faireUneOffre.php"><span class="voiroffre">Faire une Offre</span></a>
                 </div>
                  
        </section>



       <h3>Géolocalisation</h3><br/>

          
        <section class="proxifruit">
                        <div id="carteGoogle"></div>
        </section>


        
            
                
                
    
        <div  class="espace1"><!-- on met un espace entre la géolocalisation et le carrousel -->
        </div>             
    
        
     <div id="carrousel">
        
        <div class='prev'><img src='http://www.microsoft.com/france/accessibilite/template/my-theme/images/fleche_g_carrousel.png'/></div><ul>




        <?php
            try {
              $bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e) {
              die("Erreur :".$e -> getMessage());
            }

        $reponse = $bdd -> query("SELECT o.picture picture_offer, o.price price_offer, o.priceType priceType_offer, o.qty quantity_offer, o.qtyType quantityType_offer, 
      o.description description_offer, DATEDIFF(o.limitDate, NOW()) AS disponibility_offer, DATE_FORMAT(o.offerDate, '%d%/%m%/%Y à %Hh%i') AS offerDate, o.bio bio_offer,
      o.troc troc_offer, o.season saison_offer,  v.name variete_offer, v.category category_fruit, m.pseudo member_offer FROM offer o INNER JOIN variety v ON 
      v.idVariety = o.Variety_idVariety INNER JOIN member m ON m.idMember = o.Member_idMember");

        while($donnees = $reponse -> fetch()) {

          if($donnees['disponibility_offer'] > 0) {

echo "<li><div class='offre1 elementC'><div class='premier'>";
echo "<h4>" . $donnees["variete_offer"] . "</h4>";
echo "</div><div class='deuxieme' style='background-image: url(" . $donnees['picture_offer'] . ")'><div class='fondnoirtransparent'>";
echo "<p><strong>Vendeur : " . $donnees["member_offer"] . "</strong></p>";
echo "<p>Quantité : " .$donnees["quantity_offer"] . " " .$donnees["quantityType_offer"] . "</p>";
echo "<p>Prix : " .$donnees["price_offer"] . " " .$donnees["priceType_offer"] . "</p>";
echo "<p>Disponibilité : " .$donnees["disponibility_offer"] . " jours</p>";
if($donnees["troc_offer"] != NULL) {
    echo "<p>Troc : oui</p>";
}
else {
    echo "<p>Troc : non</p>";
}


}

}
$reponse -> closeCursor();



?>
        
    
    </ul><div class='next'><img src='http://www.microsoft.com/france/accessibilite/template/my-theme/images/fleche_d_carrousel.png'/></div>

</div>
    
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