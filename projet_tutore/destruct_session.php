<?php

	session_start();
	session_destroy();
	header('Location: accueil_backoffice.php?nomEntreprise='.$_GET['nomEntreprise'].'');
?>
