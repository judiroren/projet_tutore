<?php
session_start();
session_destroy();
$tabconfig = parse_ini_file("config.ini");
$chemin = $tabconfig["chemin"];
header('Location: http://'.$chemin.'/accueil_backoffice.php?nomEntreprise='.$_GET['nomEntreprise']);
?>
