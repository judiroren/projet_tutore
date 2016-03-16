<?php

	session_start();
	unset($_SESSION['estConnecte']);
	//session_destroy();
	header('Location: accueil_client.php?nomEntreprise='.$_GET['nomEntreprise'].'');
?>
