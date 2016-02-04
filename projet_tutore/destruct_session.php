<?php

	session_start();
	session_destroy();
	header('Location: http://localhost/projet_tutore/projet_tutore/accueil_client.php?nomEntreprise='.$_GET['nomEntreprise'].'');
	//header('Location: http://127.0.0.1/projects/projet_tutore/accueil_backoffice.php?nomEntreprise='.$_GET['nomEntreprise'].'');
?>
