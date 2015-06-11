<?php
	session_start();

echo "<meta charset='utf-8'>";


	try {
	$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


	if(isset($_POST['nvnom']) AND $_POST['nvnom'] !== "") {
		$req = $bdd -> prepare("UPDATE member SET name=:nvname WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvname'=>$_POST['nvnom'],
		'acPseudo'=>$_SESSION['pseudo']));
	}

	if(isset($_POST['nvprenom']) AND $_POST['nvprenom'] !== "") {
		$req = $bdd -> prepare("UPDATE member SET firstName=:nvFirstName WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvFirstName'=>$_POST['nvprenom'],
		'acPseudo'=>$_SESSION['pseudo']));
	}


	if(isset($_FILES['nvphoto']) AND $_FILES['nvphoto']['error']==0) {
		if($_FILES['nvphoto']['size'] <= 100000) { 
			$infosfichier = pathinfo($_FILES['nvphoto']['name']); 
			$extension_upload = $infosfichier['extension']; 
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
			if(in_array($extension_upload, $extensions_autorisees)) { 
     			move_uploaded_file($_FILES['nvphoto']['tmp_name'], "upload/".basename($_FILES['nvphoto']['name']));
     			$_SESSION['url1'] = "upload/".basename($_FILES['nvphoto']['name']);
				$req = $bdd -> prepare("UPDATE member SET picture=:nvpicture WHERE pseudo=:acPseudo");
				$req -> execute(array(
				'nvpicture'=>$_SESSION['url1'],
				'acPseudo'=>$_SESSION['pseudo']));
			}
			else{
				echo '<body onLoad="alert(\'Vous devez uploader un fichier de type png, gif, jpg, jpeg\')">';
    			echo '<meta http-equiv="refresh" content="0;URL=modifProfil.php">';;
			}
		}
		else {
			echo '<body onLoad="alert(\'Le fichier est trop gros...\')">';
    		echo '<meta http-equiv="refresh" content="0;URL=modifProfil.php">';
		}
	}


	if(isset($_POST['nvtelephone']) AND $_POST['nvtelephone'] != "") {
		$req = $bdd -> prepare("UPDATE member SET phone=:nvphone WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvphone'=>$_POST['nvtelephone'],
		'acPseudo'=>$_SESSION['pseudo']));
	}

	if(isset($_POST['nvmail']) AND $_POST['nvmail'] != "") {
		$req = $bdd -> prepare("UPDATE member SET mail=:nvmail WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvmail'=>$_POST['nvmail'],
		'acPseudo'=>$_SESSION['pseudo']));
	}

	if(isset($_POST['nvadresse']) AND $_POST['nvadresse'] != "") {
		$req = $bdd -> prepare("UPDATE member SET address=:nvaddress WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvaddress'=>$_POST['nvadresse'],
		'acPseudo'=>$_SESSION['pseudo']));
	}

	if(isset($_POST['nvcodepostal']) AND $_POST['nvcodepostal'] != "") {
		$req = $bdd -> prepare("UPDATE member SET cityPin=:nvcityPin WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvcityPin'=>$_POST['nvcodepostal'],
		'acPseudo'=>$_SESSION['pseudo']));
	}

	if(isset($_POST['nvville']) AND $_POST['nvville'] != "") {
		$req = $bdd -> prepare("UPDATE member SET city=:nvcity WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvcity'=>$_POST['nvville'],
		'acPseudo'=>$_SESSION['pseudo']));
	}

	if(isset($_POST['nvdescription']) AND $_POST['nvville'] != " ") {
		$req = $bdd -> prepare("UPDATE member SET description=:nvdescription WHERE pseudo=:acPseudo");
		$req -> execute(array(
		'nvdescription'=>$_POST['nvdescription'],
		'acPseudo'=>$_SESSION['pseudo']));
	}




	
	header("Location: monProfil.php");




?>
