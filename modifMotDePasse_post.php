<?php
	session_start();
	echo "<meta charset='utf-8'>";

	try {
	$bdd = new PDO("mysql:host=sql313.byethost31.com; dbname=b31_16315158_proxifruit; charset=utf8" , "b31_16315158" , "isep2015");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

$pass = sha1($_POST['nvpassword2']);

if($_POST['nvpassword'] == $_POST['nvpassword2']){
	$req = $bdd -> prepare("UPDATE member SET pass=:nvpass WHERE pseudo=:acPseudo");
	$req -> execute(array(
		'nvpass'=>$pass,
		'acPseudo'=>$_SESSION['pseudo']));

		echo '<body onLoad="alert(\'Mot de passe modifié\')">';
		echo '<meta http-equiv="refresh" content="0;URL=monProfil.php">';
}
else {
	echo '<body onLoad="alert(\'Les mots de passe entrés sont différents\')">';
	echo '<meta http-equiv="refresh" content="0;URL=monProfil.php">';
}


?>