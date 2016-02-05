<?php

	session_start();
	session_destroy();
	header('Location: accueil_client.php?nomEntreprise='.$_GET['nomEntreprise'].'');
?>
