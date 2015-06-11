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
	if(isset($_FILES['avatar']) AND $_FILES['avatar']['error']==0 AND isset($_POST['variety']) AND isset($_POST['poids']) AND isset($_POST['description'])) {
$_POST['variety'] = htmlspecialchars($_POST['variety']);
$_POST['category'] = htmlspecialchars($_POST['category']);
$_POST['poids'] = htmlspecialchars($_POST['poids']);
$_POST['description'] = htmlspecialchars($_POST['description']);


	if($_FILES['avatar']['size'] <= 100000) { 
		$infosfichier = pathinfo($_FILES['avatar']['name']);
		$extension_upload = $infosfichier['extension']; 
		$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
		if(in_array($extension_upload, $extensions_autorisees)) { 
     		move_uploaded_file($_FILES['avatar']['tmp_name'], "upload/".basename($_FILES['avatar']['name']));
     		$_SESSION['url'] = "upload/".basename($_FILES['avatar']['name']);

						if(preg_match("#^[a-zA-ZàâçéèêëÁÀÂÄÇÉÈÊË]{2,}$#", $_POST['variety'])) {
							if(preg_match("#^[0-9]+$#", $_POST['poids'])) {
								if(preg_match("#^[a-zA-Z0-9àâçéèêëÁÀÂÄÇÉÈÊË\s_\.\!\?-]{2,}$#", $_POST['description'])) {
										
										if(isset($_SESSION['pseudo'])) {

										$reponse = $bdd -> prepare("SELECT memberType FROM member WHERE pseudo=?");
										$reponse -> execute(array($_SESSION['pseudo']));
										while($donnees = $reponse -> fetch()) {
												if($donnees['memberType'] == 2) {
													$req = $bdd -> prepare("INSERT INTO variety(name, category, averageWeight, description, picture, Janvier, Février, Mars, Avril, Mai, Juin, Juillet, Août, Septembre, Octobre, Novembre, Décembre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
													$req->execute(array($_POST['variety'], $_POST['category'], $_POST['poids'], $_POST['description'], $_SESSION['url'], $_POST['janvier'], $_POST['fevrier'], $_POST['mars'], $_POST['avril'], $_POST['mai'], $_POST['juin'], $_POST['juillet'], $_POST['aout'], $_POST['septembre'], $_POST['octobre'], $_POST['novembre'], $_POST['decembre']));

												echo '<meta http-equiv="refresh" content="0;URL=fruitsLegumes.php">';

												}
												else {
													echo '<body onLoad="alert(\'Vous ne pouvez pas accéder à cette rubrique !\')">';
       												echo '<meta http-equiv="refresh" content="0;URL=fuitsLegumes.php">';
												}
										}
										$reponse -> closeCursor();

									}
									else {
										echo '<body onLoad="alert(\'Vous ne pouvez pas accéder à cette rubrique\')">';
       									echo '<meta http-equiv="refresh" content="0;URL=fruitsLegumes.php">';
									}
								}
								else {
									echo '<body onLoad="alert(\'Description invalide\')">';
    								echo '<meta http-equiv="refresh" content="0;URL=ajouterUnFruit.php">';
								}
							}
							else{
								echo '<body onLoad="alert(\'Poids invalide\')">';
    							echo '<meta http-equiv="refresh" content="0;URL=ajouterUnFruit.php">';
							}
						}
						else{
							echo '<body onLoad="alert(\'Variété invalide\')">';
    						echo '<meta http-equiv="refresh" content="0;URL=ajouterUnFruit.php">';
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