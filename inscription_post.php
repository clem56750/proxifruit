<?php
	session_start();

	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}


if(isset($_POST['pseudo']) AND isset($_POST['mail']) AND isset($_POST['pass'])) {
$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
$_POST['mail'] = htmlspecialchars($_POST['mail']);
$pass = sha1($_POST['pass']);

	if(preg_match("#^[a-zA-Z0-9àâçéèêëÁÀÂÄÇÉÈÊË\s-]{2,}$#", $_POST['pseudo'])) {
		if(preg_match("#^[a-zA-Z0-9àâçéèêëÁÀÂÄÇÉÈÊË._\s\!\?-]{5,}$#", $pass)) {
			if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail']) AND $_POST['mail']==$_POST['mail2']) {

				$reponse = $bdd -> query("SELECT idPanier FROM  member");
				while($donnees = $reponse -> fetch()) {
					$req = $bdd -> prepare("INSERT INTO member(pseudo, name, firstName, picture, phone, pass, address, cityPin, city, mail, description, memberType, idPanier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$req -> execute(array($_POST['pseudo'], NULL, NULL, './upload/Profil_poire.JPG	', NULL, $pass, NULL, NULL, NULL, $_POST['mail'], NULL, 1, $donnees['idPanier']+1));
				}
			}
			else {
				echo '<body onLoad="alert(\'Adresse mail invalide !\')">';
        		echo '<meta http-equiv="refresh" content="0;URL=inscription.php">';
   			}
   		}
   		else{
   			echo '<body onLoad="alert(\'Le mot de passe doit contenir au moins 5 caractères !\')">';
        	echo '<meta http-equiv="refresh" content="0;URL=inscription.php">';
   		}
   	}
   	else {
		echo '<body onLoad="alert(\'Votre pseudo doit contenir au moins 2 caractères !\')">';
        echo '<meta http-equiv="refresh" content="0;URL=inscription.php">';
   	}

	$req = $bdd -> prepare("SELECT pass FROM member WHERE pseudo=?");
	$req -> execute(array(
	$_POST['pseudo']));
	while($donnees = $req -> fetch()) {
		if($donnees['pass']==$pass) {
			echo '<body onLoad="alert(\'Vous êtes inscrits !\')">';
       		echo '<meta http-equiv="refresh" content="0;URL=accueil.php">';
       	}
       	else {
       		echo '<body onLoad="alert(\'Ce pseudo est déjà utilisé !\')">';
       		echo '<meta http-equiv="refresh" content="0;URL=inscription.php">';	
       	}
    }
   	$req -> closeCursor();

   	$req = $bdd -> prepare("SELECT pass FROM member WHERE mail=?");
	$req -> execute(array(
	$_POST['mail']));
	while($donnees = $req -> fetch()) {
		if($donnees['pass']==$pass) {
			echo '<body onLoad="alert(\'Vous êtes inscrits !\')">';
       		echo '<meta http-equiv="refresh" content="0;URL=accueil.php">';
       	}
       	else {
       		echo '<body onLoad="alert(\'Cet e-mail est déjà utilisé !\')">';
       		echo '<meta http-equiv="refresh" content="0;URL=inscription.php">';	
       	}
    }
   $req -> closeCursor();
}
          

?>
