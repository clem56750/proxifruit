<?php
	session_start();

echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


if(isset($_POST['nom']) AND isset($_POST['prenom']) AND isset($_POST['telephone']) AND isset($_POST['adresse']) AND isset($_POST['codepostal'])AND isset($_POST['ville'])) {
$_POST['nom'] = htmlspecialchars($_POST['nom']);
$_POST['prenom'] = htmlspecialchars($_POST['prenom']);
$_POST['telephone'] = htmlspecialchars($_POST['telephone']);
$_POST['adresse'] = htmlspecialchars($_POST['adresse']);
$_POST['codepostal'] = htmlspecialchars($_POST['codepostal']);
$_POST['ville'] = htmlspecialchars($_POST['ville']);

if(preg_match("#^[a-zA-ZàâçéèêëÁÀÂÄÇÉÈÊË\s-]{2,}$#", $_POST['nom'])) {
	if(preg_match("#^[a-zA-ZàâçéèêëÁÀÂÄÇÉÈÊË\s-]{2,}$#", $_POST['prenom'])) {
		if(preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $_POST['telephone'])) {
			if(preg_match("#^[1-9][0-9]*[a-zA-ZàâçéèêëÁÀÂÄÇÉÈÊË'\s-]{7,}$#", $_POST['adresse'])) { 
				if(preg_match("#^[0-9]{4,5}$#", $_POST['codepostal'])) {
					if(preg_match("#^[a-zA-ZàâçéèêëÁÀÂÄÇÉÈÊË\s-]{2,}$#", $_POST['ville'])) {
						$req = $bdd -> prepare("UPDATE member SET name=:nvname, firstName=:nvfirstName, phone=:nvphone, address=:nvaddress, cityPin=:nvcityPin, city=:nvcity WHERE pseudo=:acPseudo");
						$req -> execute(array(
						'nvname'=>$_POST['nom'],
						'nvfirstName'=>$_POST['prenom'],
						'nvphone'=>$_POST['telephone'],
						'nvaddress'=>$_POST['adresse'],
						'nvcityPin'=>$_POST['codepostal'],
						'nvcity'=>$_POST['ville'],
						'acPseudo'=>$_SESSION['pseudo']));

						$_SESSION['adresse'] = $_POST['adresse'];

						echo '<body onLoad="alert(\'Inscription avancée validée\')">';
        				echo '<meta http-equiv="refresh" content="0;URL=faireUneOffre.php">';

					}
					else {
						echo '<body onLoad="alert(\'Ville invalide\')">';
        				echo '<meta http-equiv="refresh" content="0;URL=inscription_avancee.php">';
					}
				}
				else {
					echo '<body onLoad="alert(\'Code postal invalide\')">';
        			echo '<meta http-equiv="refresh" content="0;URL=inscription_avancee.php">';
				}
			}
			else {
				echo '<body onLoad="alert(\'Adresse invalide\')">';
        		echo '<meta http-equiv="refresh" content="0;URL=inscription_avancee.php">';
        	}
        }
        else {
        	echo '<body onLoad="alert(\'Telephone invalide\')">';
        	echo '<meta http-equiv="refresh" content="0;URL=inscription_avancee.php">';
        }
    }
    else {
    	echo '<body onLoad="alert(\'Prénom invalide\')">';
        echo '<meta http-equiv="refresh" content="0;URL=inscription_avancee.php">';
    }
}
else {
	echo '<body onLoad="alert(\'Nom invalide\')">';
    echo '<meta http-equiv="refresh" content="0;URL=inscription_avancee.php">';
}




}




?>
