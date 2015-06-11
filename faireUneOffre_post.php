<?php
	session_start();

echo "<meta charset='utf-8'>";


	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}
//ici
	if(isset($_FILES['avatar']) AND $_FILES['avatar']['error']==0 AND isset($_POST['prix']) AND isset($_POST['quantite']) AND isset($_POST['description']) AND isset($_POST['rdv']) AND isset($_POST['variety'])) {
$_POST['prix'] = htmlspecialchars($_POST['prix']);
$_POST['quantite'] = htmlspecialchars($_POST['quantite']);
$_POST['unite'] = htmlspecialchars($_POST['unite']);
$_POST['description'] = htmlspecialchars($_POST['description']);
$_POST['rdv'] = htmlspecialchars($_POST['rdv']);
$_POST['variety'] = htmlspecialchars($_POST['variety']);

$date = date("Y-m-d H:i:s");


	if($_FILES['avatar']['size'] <= 100000) { //ici
		$infosfichier = pathinfo($_FILES['avatar']['name']); //ici
		$extension_upload = $infosfichier['extension']; //ici
		$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');//ici
		if(in_array($extension_upload, $extensions_autorisees)) { //ici
     		move_uploaded_file($_FILES['avatar']['tmp_name'], "upload/".basename($_FILES['avatar']['name']));//ici
     		$_SESSION['url'] = "upload/".basename($_FILES['avatar']['name']);//ici
							if($_POST['rdv'] > $date) {
								if(preg_match("#^[1-9][0-9]*$#", $_POST['quantite'])) {
									if(preg_match("#^[0-9]+[.]?[0-9]*$#", $_POST['prix'])) {	

										$reponse = $bdd -> query("SELECT name, idVariety FROM variety");
										while($donnees = $reponse -> fetch()) {
											$reponse1 = $bdd -> query("SELECT idMember, pseudo FROM member");
											while($donnees1 = $reponse1 -> fetch()) {
												if($donnees['name'] == $_POST['variety'] AND $donnees1['pseudo'] == $_SESSION['pseudo']) {
													$req = $bdd -> prepare("INSERT INTO offer(picture, price, priceType, qty, qtyType, description, limitDate, offerDate, bio, troc, season, Variety_idVariety, Member_idMember) VALUES (:picture, :price, :priceType, :qty, :qtyType, :description, :limitDate, NOW(), :bio, :troc, :season, :Variety_idVariety, :Member_idMember)");
													$req->execute(array(
													'picture'=>$_SESSION['url'],
													'price'=>$_POST['prix'],
													'priceType'=>"EUR",				
													'qty'=>$_POST['quantite'],
													'qtyType'=>$_POST['unite'],
													'description'=>$_POST['description'],
													'limitDate'=>$_POST['rdv'],
													'bio'=>$_POST['bio'],
													'troc'=>$_POST['troc'],
													'season'=>$_POST['desaison'],
													'Variety_idVariety'=>$donnees['idVariety'],
													'Member_idMember'=>$donnees1['idMember']));
												}
											}
											$reponse1 -> closeCursor();
										}
										$reponse -> closeCursor();	

       									header("Location: gererMesOffres.php");

									}
									else {
										echo '<body onLoad="alert(\'Prix invalide\')">';
       									echo '<meta http-equiv="refresh" content="0;URL=faireUneOffre.php">';
									}
								}
								else {
									echo '<body onLoad="alert(\'Quantité invalide\')">';
    								echo '<meta http-equiv="refresh" content="0;URL=faireUneOffre.php">';
								}
							}
							else{
								echo '<body onLoad="alert(\'Date invalide\')">';
    							echo '<meta http-equiv="refresh" content="0;URL=faireUneOffre.php">';
							}
					}
		
		else{
			echo '<body onLoad="alert(\'Vous devez uploader un fichier de type png, gif, jpg, jpeg\')">'; //ici
    		echo '<meta http-equiv="refresh" content="0;URL=faireUneOffre.php">';;
		}
	}
else {
	echo '<body onLoad="alert(\'Le fichier est trop gros...\')">'; //ici
    echo '<meta http-equiv="refresh" content="0;URL=faireUneOffre.php">';
}

}
else {
	echo '<body onLoad="alert(\'Veuillez remplir tous les champs\')">';
    echo '<meta http-equiv="refresh" content="0;URL=faireUneOffre.php">';
}





?>