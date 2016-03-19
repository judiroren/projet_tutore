<?php
session_start ();

$_SESSION ["nomE"] = "truc";

require "fonctions.inc.php";
require "bd.inc.php";
require "ajout.inc.php";
require 'gestion_calendrier.inc.php';

$connexion = connect ();
$matin = 0;
$idemployes = listeEmpCapable ( 'PRES1' ); // recup employé presta
//$idemployes = $_SESSION["employeRes"];
$idemployes = recup_employe_dispo ( $connexion, $idemployes, 'Lundi', 0 ); // recup employe travaillant sur la demi journé

$idemployes = recup_employe_non_absent ( $connexion, $idemployes, "2016-03-21" );

$creneauLibres = array ();
foreach ( $idemployes as $emp ) {
	
	$creneauOccupe = creneauOccupeEmp ( $emp, "2016-03-21", $matin );
	
	$creneauLibre = creneauLibre ( $creneauOccupe, $matin );
	
	array_push ( $creneauLibres, $creneauLibre );
}
$libre = creneauLibrePourTous ( $creneauLibres );

$libre = fusion ( $libre );
print_r($libre);

?>