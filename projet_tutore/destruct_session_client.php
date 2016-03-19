<?php

	session_start();
	unset($_SESSION['estConnecteClient']);
	//session_destroy();
	header('Location: accueil_client.php?nomEntreprise='.$_GET['nomEntreprise'].'');
?>
