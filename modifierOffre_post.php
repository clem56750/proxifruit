<?php
	session_start();

echo "<meta charset='utf-8'>";

$date = date("Y-m-d H:i:s");



	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

	if(isset($_POST['nvvariety']) AND $_POST['nvvariety'] != " ") {
		$reponse = $bdd -> query("SELECT name, idVariety FROM variety");
		while($donnees = $reponse -> fetch()) {
			if($donnees['name'] == $_POST['nvvariety']) {
				$req = $bdd -> prepare("UPDATE offer SET Variety_idVariety=:nvvariety WHERE numOffer=:num_Offer");
				$req -> execute(array(
				'nvvariety'=>$donnees['idVariety'],
				'num_Offer'=>$_GET['variable']));
			}
		}
	}


	if(isset($_POST['nvprix']) AND $_POST['nvprix'] !== "") {
		$req = $bdd -> prepare("UPDATE offer SET price=:nvprice WHERE numOffer=:num_Offer");
		$req -> execute(array(
		'nvprice'=>$_POST['nvprix'],
		'num_Offer'=>$_GET['variable']));
	}

	if(isset($_POST['nvquantite']) AND $_POST['nvquantite'] !== "") {
		$req = $bdd -> prepare("UPDATE offer SET qty=:nvqty WHERE numOffer=:num_Offer");
		$req -> execute(array(
		'nvqty'=>$_POST['nvquantite'],
		'num_Offer'=>$_GET['variable']));
	}

	if(isset($_POST['nvunite']) AND $_POST['nvunite'] !== " ") {
		$req = $bdd -> prepare("UPDATE offer SET qtyType=:nvqtyType WHERE numOffer=:num_Offer");
		$req -> execute(array(
		'nvqtyType'=>$_POST['nvunite'],
		'num_Offer'=>$_GET['variable']));
	}

	if(isset($_POST['nvdescription']) AND $_POST['nvdescription'] !== " ") {
		$req = $bdd -> prepare("UPDATE offer SET description=:nvdescription WHERE numOffer=:num_Offer");
		$req -> execute(array(
		'nvdescription'=>$_POST['nvdescription'],
		'num_Offer'=>$_GET['variable']));
	}

	if(isset($_POST['nvrdv']) AND $_POST['nvrdv'] > $date) {
		$req = $bdd -> prepare("UPDATE offer SET limitDate=:nvlimitDate WHERE numOffer=:num_Offer");
		$req -> execute(array(
		'nvlimitDate'=>$_POST['nvrdv'],
		'num_Offer'=>$_GET['variable']));
	}

if(isset($_FILES['nvavatar']) AND $_FILES['nvavatar']['error']==0) {
	if($_FILES['nvavatar']['size'] <= 100000) { 
		$infosfichier = pathinfo($_FILES['nvavatar']['name']); 
		$extension_upload = $infosfichier['extension']; 
		$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
		if(in_array($extension_upload, $extensions_autorisees)) { 
     		move_uploaded_file($_FILES['nvavatar']['tmp_name'], "upload/".basename($_FILES['nvavatar']['name']));
     		$_SESSION['url2'] = "upload/".basename($_FILES['nvavatar']['name']);
			$req = $bdd -> prepare("UPDATE offer SET picture=:nvpicture WHERE numOffer=:num_Offer");
			$req -> execute(array(
			'nvpicture'=>$_SESSION['url2'],
			'num_Offer'=>$_GET['variable']));
		}
		else{
			echo '<body onLoad="alert(\'Vous devez uploader un fichier de type png, gif, jpg, jpeg\')">';
    		echo '<meta http-equiv="refresh" content="0;URL=modifierOffre.php">';;
		}
	}
	else {
		echo '<body onLoad="alert(\'Le fichier est trop gros...\')">';
   		echo '<meta http-equiv="refresh" content="0;URL=modifierOffre.php">';
	}
}

$reponse = $bdd -> query("SELECT bio, troc, season FROM offer");
while($donnees = $reponse -> fetch()) {

	if(isset($_POST['nvbio'])) {
		$req = $bdd -> prepare("UPDATE offer SET bio=:nvbio WHERE numOffer=:num_Offer");
			if($donnees['bio'] !== NULL) {
				$req -> execute(array(
				'nvbio'=>NULL,
				'num_Offer'=>$_GET['variable']));
			}
			else {
				$req -> execute(array(
				'nvbio'=>$_POST['nvbio'],
				'num_Offer'=>$_GET['variable']));
			}
	}

	if(isset($_POST['nvtroc'])) {
		$req = $bdd -> prepare("UPDATE offer SET troc=:nvtroc WHERE numOffer=:num_Offer");
			if($donnees['troc'] !== NULL) {
				$req -> execute(array(
				'nvtroc'=>NULL,
				'num_Offer'=>$_GET['variable']));
			}
			else {
				$req -> execute(array(
				'nvtroc'=>$_POST['nvtroc'],
				'num_Offer'=>$_GET['variable']));
			}
	}

	if(isset($_POST['nvdesaison'])) {
		$req = $bdd -> prepare("UPDATE offer SET season=:nvdeSaison WHERE numOffer=:num_Offer");
			if($donnees['season'] !== NULL) {	
				$req -> execute(array(
				'nvdeSaison'=>NULL,
				'num_Offer'=>$_GET['variable']));
			}
			else {
				$req -> execute(array(
				'nvdeSaison'=>$_POST['nvdesaison'],
				'num_Offer'=>$_GET['variable']));
			}
	}
}

$reponse -> closeCursor();

			echo '<body onLoad="alert(\'Offre modifiée\')">';
		echo '<meta http-equiv="refresh" content="0;URL=gererMesOffres.php">';

?>