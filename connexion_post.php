
	<?php
	session_start();

	try {
		$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

if(isset($_POST['usermail']) AND isset($_POST['password'])) {
	$_POST['usermail'] = htmlspecialchars($_POST['usermail']);
	$pass = sha1($_POST['password']);

	$reponse = $bdd -> query("SELECT pseudo, pass, mail FROM member");
	while($donnees = $reponse -> fetch()) {
		if((isset($_POST["usermail"]) AND ($_POST["usermail"] == $donnees["mail"] OR $_POST["usermail"] == $donnees["pseudo"])) AND (isset($_POST["password"]) AND $pass == $donnees["pass"])) {

			$_SESSION['usermail'] = $_POST['usermail'];
			$_SESSION['password'] = $pass;
			$_SESSION['pseudo'] = $donnees['pseudo'];
			
			header("Location: accueil.php");
		}
		else {
		echo '<meta http-equiv="refresh" content="0;URL=connexion.php">';
		echo '<body onLoad="alert(\'Membre non reconnu...\')">';
		
		}
	}
$reponse -> closeCursor();
}

?>





