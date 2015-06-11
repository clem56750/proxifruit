<?php
session_start();

	echo '<meta charset="utf-8">';

	try {
	$bdd = new PDO("mysql:host=localhost; dbname=proxifruit; charset=utf8" , "root" , " ");
	}
	catch(Exception $e) {
		die("Erreur :".$e -> getMessage());
	}

if(isset($_POST['name']) AND isset($_POST['firstname']) AND isset($_POST['mail']) AND isset($_POST['objet']) AND isset($_POST['message'])) {

if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail'])) {

			$to = 'proxifruit@proxifruit.fr';
			$subject = "Message de : " . $_POST['firstname'] . " " . $_POST['name'] . " " . $_POST['objet'];
			$message = $_POST['message'];
			$headers = 'FROM : ' . $_POST['mail'];
			 
			
			mail(utf8_decode($to), utf8_decode($subject), utf8_decode($message), utf8_decode($headers));


	echo '<body onLoad="alert(\'Message envoyé !\')">';
    echo '<meta http-equiv="refresh" content="0;URL=accueil.php">';

}
else {
	echo '<body onLoad="alert(\'E-mail invalide !\')">';
    echo '<meta http-equiv="refresh" content="0;URL=contact.php">';
}

 }

?>

