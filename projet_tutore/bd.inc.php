<?php

//Permet la connection à la base de données
function connect() {
	try {
		
		$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" );
		$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		
		echo 'Connexion échouée : ' . $e->getMessage();
	}
	return $connexion;
} 

//Permet de récupérer les identifiants d'un administrateur
function infosEntreprise() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqt = $connexion->prepare('SELECT * FROM entreprise WHERE nomEntreprise = "' .$nomE. '"');
	$rqt->execute();
	$rqt->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqt->fetch(); 
	
	return $i;
}

//Permet de récupérer le planning d'un employé
function planningEmp($id_employe) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON id_employe = "'.$id_employe.'"');
	
	$planning->execute();
	
	return $planning;	
	
}

//Permet de récupérer le planning d'une entreprise
function planningEnt() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	//$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning');
	$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON code_employe = id_employe');
	
	$planning->execute();
	
	return $planning;	
	
}

//Permet de récupérer les réservations
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

//Permet de récupérer les abscences des employés
function abscencesEnt() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$absences = $connexion->prepare('SELECT * FROM '.$nomE.'_absence 
									JOIN '.$nomE.'_employe ON code_employe = id_employe');
	$absences->execute();
	return $absences;	
}

//Permet de récupérer les abscences d'une entreprise
function listeAbscences() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];

	$absences = $connexion->prepare('SELECT id_absence FROM '.$nomE.'_absence');
	$absences->execute();
	
	return $absences;	
}

//Permet de récupérer les prestations d'une entreprise
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

//Permet d'obtenir les informations d'une prestation précise 
function infosPrestation($id) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$listePresta = $connexion->prepare("SELECT * FROM ".$nomE."_prestation WHERE id_presta = '".$id."'");
	$listePresta->execute();
	
	return $listePresta;
}

//Permet de récupérer les informations des employés d'une entreprise
function infosEmploye() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtInfosEmp = $connexion->prepare("SELECT * FROM ".$nomE."_employe");
	$rqtInfosEmp->execute();
	
	return $rqtInfosEmp;
}

//Permet d'obtenir les informations pour vérifier un employé
function verifEntreprise($nomE) {
	
	
	$connexion = connect();
	$rqtVerifEnt = $connexion->prepare('SELECT nomEntreprise FROM entreprise WHERE nomEntreprise = "' .$nomE. '"');
	$rqtVerifEnt->execute();
	
	$rqtVerifEnt->setFetchMode(PDO::FETCH_ASSOC);
	$tableau = null;
	$tableau = $rqtVerifEnt->fetch();
	return $tableau;
	
}

//Permet d'obtenir les informations pour vérifier les employés d'une entreprise
function verifEmploye() {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtVerifEmp = $connexion->prepare("SELECT nom_employe, prenom_employe FROM ".$nomE."_employe");
	$rqtVerifEmp->execute();
	
	return $rqtVerifEmp;
}

//Permet d'obtenir l'Id d'un employé
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

//Permet d'obtenir toutes les informations d'un employé
function InfosEmploye2($nomEmp) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtIdEmp = $connexion->prepare("SELECT * FROM ".$nomE."_employe WHERE id_employe = '".$nomEmp."'");
	$rqtIdEmp->execute();
	
	return $rqtIdEmp;
	
}

//Permet de séléctionner les réservations d'un employé
function reservationsEmp($idemp) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	//$rqt = $connexion->query('SELECT * FROM '.$nomE.'_reserv WHERE employe = "'.$_POST['employe_modif'].'"');
	$rqtReservEmp = $connexion->prepare('SELECT * FROM '.$nomE.'_reserv WHERE employe = ":idemp"');
	$rqtReservEmp->execute(array('idemp' => $idemp));
	
	return $rqtReservEmp;
	
}

//Permet de sélectionner la date d'une reservation précise
function dateReservation($employeAbsent, $debutReserv, $finReserv) {
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$reserv = $connexion->query('SELECT date FROM '.$nomE.'_reserv WHERE employe = "'.$employeAbsent.'" 
								AND date BETWEEN '.$debutReserv.' AND '.$finReserv);
	$reserv->execute();

	return $reserv;	
}

//Récupére les informations de login d'un client 
function logClient($log, $mdp){
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtLogClient = $connexion->prepare("SELECT login_client, mdp_client, id_client FROM ".$nomE."_client WHERE login_client = '".$log."' AND mdp_client = '".$mdp."'");
	$rqtLogClient->execute();
	$rqtLogClient->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqtLogClient->fetch();
	return $i;
}

//Récupére les informations de login d'un client
function infosClients(){
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$client = $_SESSION["client"];
	$rqtClient = $connexion->prepare("SELECT nom_client, prenom_client, mail, login_client FROM ".$nomE."_client WHERE id_client = '".$client."'");
	$rqtClient->execute();
	$rqtClient->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqtClient->fetch();
	return $i;
}

//Récupère les réservations d'un client
function reservClient(){
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$client = $_SESSION["client"];
	$rqtReservCli = $connexion->prepare("SELECT descriptif_presta, prix, nom_employe, prenom_employe, paye, date, heure FROM ".$nomE."_reserv JOIN ".$nomE."_employe ON id_employe = employe JOIN ".$nomE."_prestation ON id_presta = presta WHERE client = '".$client."' ORDER BY date ASC");
	$rqtReservCli->execute();
	
	return $rqtReservCli;
}

//Permet d'obtenir les informations sur les clients d'une entreprise
function listeClient() {

	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtClient = $connexion->prepare("SELECT * FROM ".$nomE."_client");
	$rqtClient->execute();

	return $rqtClient;

}

//Recupère la liste des compétences de l'employé
function listeCompetence($emp){
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtComp = $connexion->prepare("SELECT prestation, descriptif_presta FROM ".$nomE."_competence JOIN ".$nomE."_prestation ON prestation = id_presta WHERE employe = '".$emp."'");
	$rqtComp->execute();
	return $rqtComp;
}

//Liste des prestations qui ne font pas partie des competences de l'employe
function listePrestaNonComp($emp){
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	$rqtPrest = $connexion->prepare("SELECT id_presta, descriptif_presta FROM ".$nomE."_prestation LEFT OUTER JOIN ".$nomE."_competence ON id_presta = prestation WHERE prestation IS NULL");
	$rqtPrest->execute();
	
	return $rqtPrest;
}
?>