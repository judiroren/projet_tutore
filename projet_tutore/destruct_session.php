<?php
session_start();
session_destroy();
header('Location: http://localhost/projet_tutore/projet_tutore/accueil_backoffice.php?nomEntreprise='.$_GET['nomEntreprise']);
?>
