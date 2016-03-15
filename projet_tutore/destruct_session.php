<?php
	session_start();
	unset($_SESSION['estConnecteAdmin']);
	//session_destroy();
	header('Location: accueil_backoffice.php?nomEntreprise='.$_GET['nomEntreprise'].'');
?>
