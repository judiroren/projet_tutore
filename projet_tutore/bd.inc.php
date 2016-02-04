<?php

//Permet la connection � la base de donn�es
function connect() {
	try {
		
		$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "geo_admin", "Admin%7" );
		$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		
		echo 'Connexion �chou�e : ' . $e->getMessage();
	}
	return $connexion;
} 

//Permet de r�cup�rer les identifiants d'un administrateur
function infosEntreprise() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqt = $connexion->prepare('SELECT * FROM entreprise WHERE nomEntreprise = "' .$nomE. '"');
	$rqt->execute();
	$rqt->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqt->fetch(); 
	
	return $i;
}

//Permet de r�cup�rer le planning d'un employ�
function planningEmp($id_employe) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON id_employe = "'.$id_employe.'"');
	
	$planning->execute();
	
	return $planning;	
	
}

//Permet de r�cup�rer le planning d'une entreprise
function planningEnt() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	//$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning');
	$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON code_employe = id_employe');
	
	$planning->execute();
	
	return $planning;	
	
}

//Permet de r�cup�rer les r�servations
function reservationsEnt() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$reserva = $connexion->prepare('SELECT * FROM '.$nomE.'_reserv 
									JOIN '.$nomE.'_employe ON employe = id_employe 
									JOIN '.$nomE.'_client ON client = id_client 
									JOIN '.$nomE.'_prestation ON presta = id_presta');
	$reserva->execute();
	return $reserva;	
									
	
}

//Permet de r�cup�rer les abscences des employ�s
function abscencesEnt() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$absences = $connexion->prepare('SELECT * FROM '.$nomE.'_absence 
									JOIN '.$nomE.'_employe ON code_employe = id_employe');
	$absences->execute();
	return $absences;	
}

//Permet de r�cup�rer les abscences d'une entreprise
function listeAbscences() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];

	$absences = $connexion->prepare('SELECT id_absence FROM '.$nomE.'_absence');
	$absences->execute();
	
	return $absences;	
}

//Permet de r�cup�rer les prestations d'une entreprise
function listePrestations() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtPrestations = $connexion->prepare("SELECT id_presta, descriptif_presta FROM ".$nomE."_prestation");
	$rqtPrestations->execute();
	
	return $rqtPrestations;
}

//Permet d'obtenir les informations sur les planning d'une entreprise
function listePlanning() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtPlanning = $connexion->prepare("SELECT * FROM ".$nomE."_planning");
	$rqtPlanning->execute();
	
	return $rqtPlanning;
	
}

//Permet d'obtenir les informations d'une prestation pr�cise 
function infosPrestation($id) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$listePresta = $connexion->prepare("SELECT * FROM ".$nomE."_prestation WHERE id_presta = '".$id."'");
	$listePresta->execute();
	
	return $listePresta;
}

//Permet de r�cup�rer les informations des employ�s d'une entreprise
function infosEmploye() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtInfosEmp = $connexion->prepare("SELECT * FROM ".$nomE."_employe");
	$rqtInfosEmp->execute();
	
	return $rqtInfosEmp;
}

//Permet d'obtenir les informations pour v�rifier un employ�
function verifEntreprise($nomE) {
	
	
	$connexion = connect();
	$rqtVerifEnt = $connexion->prepare('SELECT nomEntreprise FROM entreprise WHERE nomEntreprise = "' .$nomE. '"');
	$rqtVerifEnt->execute();
	
	$rqtVerifEnt->setFetchMode(PDO::FETCH_ASSOC);
	$tableau = null;
	$tableau = $rqtVerifEnt->fetch();
	return $tableau;
	
}

//Permet d'obtenir les informations pour v�rifier les employ�s d'une entreprise
function verifEmploye() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtVerifEmp = $connexion->prepare("SELECT nom_employe, prenom_employe FROM ".$nomE."_employe");
	$rqtVerifEmp->execute();
	
	return $rqtVerifEmp;
}

//Permet d'obtenir l'Id d'un employ�
function IdentEmploye($nomEmp) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	//$rqtIdEmp = $connexion->prepare("SELECT id_employe FROM ".$nomE."_employe WHERE nom_employe = '".$nomEmp."'");
	$rqtIdEmp = $connexion->prepare("SELECT id_employe FROM ".$nomE."_employe WHERE nom_employe = '".$nomEmp."'");
	$rqtIdEmp->execute();
	
	//$rqtIdEmp->fetch(PDO::FETCH_OBJ);
	//$i = $rqtIdEmp->fetch();
	
	return $rqtIdEmp;
} 

//Permet d'obtenir toutes les informations d'un employ�
function InfosEmploye2($nomEmp) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtIdEmp = $connexion->prepare("SELECT * FROM ".$nomE."_employe WHERE id_employe = '".$nomEmp."'");
	$rqtIdEmp->execute();
	
	return $rqtIdEmp;
	
}

//Permet de s�l�ctionner les r�servations d'un employ�
function reservationsEmp($idemp) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	//$rqt = $connexion->query('SELECT * FROM '.$nomE.'_reserv WHERE employe = "'.$_POST['employe_modif'].'"');
	$rqtReservEmp = $connexion->prepare('SELECT * FROM '.$nomE.'_reserv WHERE employe = ":idemp"');
	$rqtReservEmp->execute(array('idemp' => $idemp));
	
	return $rqtReservEmp;
	
}

//Permet de s�lectionner la date d'une reservation pr�cise
function dateReservation($employeAbsent, $debutReserv, $finReserv) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$reserv = $connexion->query('SELECT date FROM '.$nomE.'_reserv WHERE employe = "'.$employeAbsent.'" 
								AND date BETWEEN '.$debutReserv.' AND '.$finReserv);
	$reserv->execute();

	return $reserv;	
}

?>