<?php

require "config.ini.php";

//Permet la connection � la base de donn�es
function connect() {
	$DBNAME = getDBNAME();
	$DBHOST = getDBHOST();
	$DBUSER = getDBUSER();
	$DBPASSWD = getDBPASSWD();
	try {
		
		$connexion = new PDO("mysql:dbname=".$DBNAME.";host=".$DBHOST."", "".$DBUSER."", "".$DBPASSWD."" );
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
	$nomE = $_GET['nomEntreprise'];
	$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON code_employe = id_employe where id_employe = "'.$id_employe.'"');
	
	$planning->execute();
	
	return $planning;	
	
}

//Permet de r�cup�rer le planning d'une entreprise
function planningEnt() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning');
	$planning = $connexion->prepare('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON code_employe = id_employe');
	
	$planning->execute();
	
	return $planning;	
	
}

//Permet de r�cup�rer les r�servations
function reservationsEnt() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$reserva = $connexion->prepare('SELECT * FROM '.$nomE.'_reserv 
									JOIN '.$nomE.'_employe ON employe = id_employe 
									JOIN '.$nomE.'_client ON client = id_client ');
	$reserva->execute();
	return $reserva;	
									
	
}

//Permet de r�cup�rer les abscences des employ�s
function abscencesEnt() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$absences = $connexion->prepare('SELECT * FROM '.$nomE.'_absence 
									JOIN '.$nomE.'_employe ON code_employe = id_employe');
	$absences->execute();
	return $absences;	
}

//Permet de r�cup�rer les abscences d'une entreprise
function listeAbscences() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];

	$absences = $connexion->prepare('SELECT id_absence FROM '.$nomE.'_absence');
	$absences->execute();
	
	return $absences;	
}

//Permet de r�cup�rer les prestations d'une entreprise
function listePrestations() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtPrestations = $connexion->prepare("SELECT id_presta, categorie, descriptif_presta FROM ".$nomE."_prestation");
	$rqtPrestations->execute();
	
	return $rqtPrestations;
}

//Permet d'obtenir les informations sur les planning d'une entreprise
function listePlanning() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtPlanning = $connexion->prepare("SELECT * FROM ".$nomE."_planning");
	$rqtPlanning->execute();
	
	return $rqtPlanning;
	
}

//Permet d'obtenir les informations d'une prestation pr�cise 
function infosPrestation($id) {
	
	$connexion = connect();
$nomE = $_GET['nomEntreprise'];
	$listePresta = $connexion->prepare("SELECT * FROM ".$nomE."_prestation WHERE id_presta = '".$id."'");
	$listePresta->execute();
	$listePresta->setFetchMode(PDO::FETCH_OBJ);
	$i = $listePresta->fetch();
	
	return $i;
}

//Permet de r�cup�rer les informations des employ�s d'une entreprise
function infosEmploye() {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
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
	$nomE = $_GET['nomEntreprise'];
	$rqtVerifEmp = $connexion->prepare("SELECT nom_employe, prenom_employe FROM ".$nomE."_employe");
	$rqtVerifEmp->execute();
	
	return $rqtVerifEmp;
}

//Permet d'obtenir l'Id d'un employ�
function IdentEmploye($nomEmp) {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
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
	$nomE = $_GET['nomEntreprise'];
	$rqtIdEmp = $connexion->prepare("SELECT * FROM ".$nomE."_employe WHERE id_employe = '".$nomEmp."'");
	$rqtIdEmp->execute();
	
	return $rqtIdEmp;
	
}

//Permet de s�l�ctionner les r�servations d'un employ�
function reservationsEmp($idemp) {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$rqt = $connexion->query('SELECT * FROM '.$nomE.'_reserv WHERE employe = "'.$_POST['employe_modif'].'"');
	$rqtReservEmp = $connexion->prepare('SELECT * FROM '.$nomE.'_reserv WHERE employe = ":idemp"');
	$rqtReservEmp->execute(array('idemp' => $idemp));
	
	return $rqtReservEmp;
	
}

//Permet de s�lectionner la date d'une reservation pr�cise
function dateReservation($employeAbsent, $debutReserv, $finReserv) {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$reserv = $connexion->query('SELECT date FROM '.$nomE.'_reserv WHERE employe = "'.$employeAbsent.'" 
								AND date BETWEEN '.$debutReserv.' AND '.$finReserv);
	$reserv->execute();

	return $reserv;	
}

//R�cup�re les informations de login d'un client 
function logClient($log, $mdp){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtLogClient = $connexion->prepare("SELECT login_client, mdp_client, id_client FROM ".$nomE."_client WHERE login_client = '".$log."' AND mdp_client = '".$mdp."'");
	$rqtLogClient->execute();
	$rqtLogClient->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqtLogClient->fetch();
	return $i;
}

//R�cup�re les informations de login d'un client
function infosClients(){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$client = $_SESSION["client"];
	$rqtClient = $connexion->prepare("SELECT nom_client, prenom_client, mail, login_client FROM ".$nomE."_client WHERE id_client = '".$client."'");
	$rqtClient->execute();
	$rqtClient->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqtClient->fetch();
	return $i;
}

//R�cup�re les r�servations d'un client
function reservClient(){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$client = $_SESSION["client"];
	$rqtReservCli = $connexion->prepare("SELECT id_reserv, prix, duree, nom_employe, prenom_employe, paye, date, heure FROM ".$nomE."_reserv JOIN ".$nomE."_employe ON id_employe = employe WHERE client = '".$client."' ORDER BY date ASC");
	$rqtReservCli->execute();
	
	return $rqtReservCli;
}

//Permet d'obtenir les informations sur les clients d'une entreprise
function listeClient() {

	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtClient = $connexion->prepare("SELECT * FROM ".$nomE."_client");
	$rqtClient->execute();

	return $rqtClient;

}

//Recup�re la liste des comp�tences de l'employ�
function listeCompetence($emp){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtComp = $connexion->prepare("SELECT prestation, descriptif_presta, categorie FROM ".$nomE."_competence JOIN ".$nomE."_prestation ON prestation = id_presta WHERE employe = '".$emp."'");
	$rqtComp->execute();
	return $rqtComp;
}

//Liste des prestations qui ne font pas partie des competences de l'employe
function listePrestaNonComp($emp){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtPrest = $connexion->prepare("SELECT id_presta, descriptif_presta, categorie FROM ".$nomE."_prestation LEFT OUTER JOIN ".$nomE."_competence ON id_presta = prestation WHERE prestation IS NULL");
	$rqtPrest->execute();
	
	return $rqtPrest;
}

//Liste des employ�s qui peuvent faire la prestation
function listeEmpCapable($presta){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtListe = $connexion->prepare("SELECT employe, nom_employe, prenom_employe FROM ".$nomE."_competence JOIN ".$nomE."_employe ON employe = id_employe WHERE prestation = '".$presta."'");
	$rqtListe->execute();
	return $rqtListe;
}
//Liste des employ�s qui ne peuvent pas faire la prestation
function listeEmpNonCapable($presta){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$rqtListe = $connexion->prepare("SELECT id_employe, nom_employe, prenom_employe FROM ".$nomE."_employe LEFT OUTER JOIN ".$nomE."_competence ON id_employe = employe WHERE employe IS NULL");
	$rqtListe = $connexion->prepare("SELECT id_employe, nom_employe, prenom_employe FROM ".$nomE."_employe WHERE id_employe NOT IN (SELECT employe FROM ".$nomE."_competence WHERE prestation = '".$presta."')");
	$rqtListe->execute();
	
	return $rqtListe;
}

//Cr�er l'identifiant en rapport avec le contexte
function code($table, $id){
	$nomE = $_GET['nomEntreprise'];
	$connexion = connect();

		switch($table){
			case($nomE."_employe") : $prefixe = 'EMPL'; break;
			case($nomE."_prestation") : $prefixe = 'PRES'; break;
			case($nomE."_reserv") : $prefixe = 'RESV'; break;
			case($nomE."_planning") : $prefixe = 'PLAN'; break;
			case($nomE."_competence") : $prefixe = 'COMP'; break;
			case($nomE."_absence") : $prefixe = 'ABSC'; break;
			case($nomE."_client") : $prefixe = 'CLIE'; break;
			case($nomE."_prestresv") : $prefixe = 'PREV'; break;
		}

	$rqt = $connexion->prepare('SELECT MAX(SUBSTR('.$id.',5,4)+1) AS val FROM '.$table);
	$rqt->execute();
	$rqt->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqt->fetch();
	if($i->val == null){
		$valmax = 1;
	}else{
		$valmax = $i->val;
	}
	return $prefixe.$valmax;
}

//R�cup�re les employ�s pouvant faire les prestations voulues
function employeOk($tab){
	$nomE = $_GET['nomEntreprise'];
	$connexion = connect();
	$rqt = "";
	$i = 0;
	foreach($tab as $value){
		$rqt = $rqt.'SELECT DISTINCT employe FROM '.$nomE.'_competence WHERE prestation = "'.$value.'"';
		if($i == count($tab)-1){
			for($j = 0 ; $j < count($tab)-1 ; $j++){
				$rqt = $rqt.')';
			}
		}else{
			$rqt = $rqt.' AND employe IN (';
		}
		$i++;
	}
	$rqtListe = $connexion->prepare($rqt);
	$rqtListe->execute();
	$res = array();
	while($donnees = $rqtListe->fetch(PDO::FETCH_OBJ)){
		array_push($res, $donnees->employe);
	}
	return $res;
}

//R�cup�re les prestations d'une r�servation
function prestaReserv($idRes){
	$nomE = $_GET['nomEntreprise'];
	$connexion = connect();
	$rqt = $connexion->prepare("SELECT DISTINCT descriptif_presta, prix FROM ".$nomE."_prestation JOIN ".$nomE."_prestresv ON prestation = id_presta JOIN ".$nomE."_reserv ON id_reserv = reservation WHERE reservation = '".$idRes."'");
	$rqt->execute();
	
	return $rqt;
}

//Recup�re la liste des categories
function listeCategorie(){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqtcategorie = $connexion->prepare("SELECT * FROM ".$nomE."_categorie");
	$rqtcategorie->execute();
	return $rqtcategorie;
}

//R�cup�re la cat�gorie d'une prestation
function getCategorie($presta){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$rqt = $connexion->prepare("SELECT categorie FROM ".$nomE."_prestation WHERE id_presta = '".$presta."'");
	$rqt->execute();
	$rqt->setFetchMode(PDO::FETCH_OBJ);
	$i = $rqt->fetch();
	return $i;
}

//s�lectionne l'employ� qui fera une r�servation
function employeReserv($date, $jourSem, $heure, $listeEmp, $duree){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$h = intval(substr($heure,0,2));
	if(8 <= $h && $h <12){
		$attribut = $jourSem.'M';
		$liste = empPlanningOk($listeEmp, $attribut, $date);
		if($liste == null){
			return 1;	//pas d'employe travaillant ce jour
		}else{
			$liste = empAbsenceOk($liste, $date, 'M');
			if(sizeof($liste) == 0){
				return 2;	//personne de disponible
			}else{
				$liste = empHoraireOk($liste, $date, $heure, $duree, 'M');
				if(sizeof($liste) == 0){
					return 3;	//aucun horaire de dispo
				}else{
					return $liste;	//on a au moins quelqu'un
				}
			}
		}
	}else if(13 <= $h && $h < 18){
		$attribut = $jourSem.'A';
		$liste = empPlanningOk($listeEmp, $attribut, $date);
		if($liste == null){
			return 1;	//pas d'employe travaillant ce jour
		}else{
			$liste = empAbsenceOk($liste, $date, 'A');
			if(sizeof($liste) == 0){
				return 2;	//personne de disponible
			}else{
				$liste = empHoraireOk($liste, $date, $heure, $duree, 'A');
				if(sizeof($liste) == 0){
					return 3;	//aucun horaire de dispo
				}else{
					return $liste;	//on a au moins quelqu'un
				}
			}
		}
	}else{
		return 4;	//erreur : heure incorrecte
	}
}

//Renvoi la liste des employ�s travaillant sur la demi-journ� demand�e
function empPlanningOk($listeEmp, $attribut, $date){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$newListe = array();
	foreach($listeEmp as $val){
		$rqt = $connexion->prepare("SELECT * FROM ".$nomE."_planning WHERE code_employe = '".$val."'");
		$rqt->execute();
		$donnees = $rqt->fetch(PDO::FETCH_OBJ);
		switch($attribut){
			case 'LundiA' : if($donnees->LundiA==1){
								array_push($newListe, $val);	}	break;	
			case 'LundiM' : if($donnees->LundiM==1){
								array_push($newListe, $val);	}	break;
			case 'MardiA' : if($donnees->MardiA==1){
								array_push($newListe, $val);	}	break;			
			case 'MardiM' : if($donnees->MardiM==1){
								array_push($newListe, $val);	}	break;			
			case 'MercrediA' : if($donnees->MercrediA==1){
								array_push($newListe, $val);	}	break;	
			case 'MercrediM' : if($donnees->MercrediM==1){
								array_push($newListe, $val);	}	break;
			case 'JeudiA' : if($donnees->JeudiA==1){
								array_push($newListe, $val);	}	break;
			case 'JeudiM' : if($donnees->JeudiM==1){
								array_push($newListe, $val);	}	break;
			case 'VendrediA' : if($donnees->VendrediA==1){
								array_push($newListe, $val);	}	break;
			case 'VendrediM' : if($donnees->VendrediM==1){
								array_push($newListe, $val);	}	break;
			case 'SamediA' : if($donnees->SamediA==1){
								array_push($newListe, $val);	}	break;
			case 'SamediM' : if($donnees->SamediM==1){
								array_push($newListe, $val);	}	break;
		}
		
	}
	if(empty($newListe)){
		return null;
	}else{
		return $newListe;
	}
	
}

//Renvoi la liste des employ�s sans absence � ce moment 
function empAbsenceOk($listeEmp, $date, $moment){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$newListe = array();
	foreach($listeEmp as $val){
		$rqt = $connexion->prepare("SELECT dateDebut, dateFin, demiJourDebut, demiJourFin FROM ".$nomE."_absence WHERE code_employe = '".$val."' AND '".$date."' BETWEEN dateDebut AND dateFin");
		$rqt->execute();
		if($rqt->rowCount()==0){
			array_push($newListe, $val);
		}else{
			while($donnees = $rqt->fetch(PDO::FETCH_OBJ)){
				if($date == $donnees->dateDebut && $moment=='M' && $donnees->demiJourDebut==1){
					array_push($newListe, $val);
				}else if ($date == $donnees->dateFin && $moment=='A' && $donnees->demiJourFin==0){
					array_push($newListe, $val);
				}
			}
		}
	}
	return $newListe;
}

//Renvoi la liste des employ�s pouvant faire la r�servation
function empHoraireOk($listeEmp, $date, $heure, $duree, $moment){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$newListe = array();
	$heuredebut = new DateTime($heure);
	$a = new DateInterval('PT'.$duree.'M');
	$heurefin = $heuredebut->add($a);
	$heurefin = new DateTime($heurefin->format('H:i:s'));
	foreach($listeEmp as $val){
		$rqt = $connexion->prepare("SELECT heure, duree FROM ".$nomE."_reserv WHERE employe = '".$val."' AND '".$date."' = date");
		$rqt->execute();
		if($rqt->rowCount()==0){
			array_push($newListe,$val);
		}else{
			while($donnees=$rqt->fetch(PDO::FETCH_OBJ)){
				$resDebut = new DateTime($donnees->heure);
				$b = new DateInterval('PT'.$donnees->duree.'M');
				$resFin = $resDebut->add($b);
				$resFin = new DateTime($resFin->format('H:i:s'));
				if((var_dump($heuredebut < $resDebut)=='bool(true)' && var_dump($heurefin <= $resDebut)=='bool(true)')
						|| var_dump(($heuredebut >= $resFin)=='bool(true)' && var_dump($heurefin > $resFin)=='bool(true)')){
					array_push($newListe,$val);
				}
			}
		}
	}
	return $newListe;
}

//Permet de s�l�ctionner les r�servations d'un employ� a une certaine date
function reservationsEmpDate($idemp,$date,$matin) {

	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];

	if($matin == 1){
		$heureDebut = "08:00:00";
		$heureFin = "12:00:00";
	}else{
		$heureDebut = "13:00:00";
		$heureFin = "18:00:00";
	}
	//$rqt = $connexion->query('SELECT * FROM '.$nomE.'_reserv WHERE employe = "'.$_POST['employe_modif'].'"');
	$rqtReservEmp = $connexion->prepare('SELECT * FROM '.$nomE.'_reserv WHERE employe = "'.$idemp.'" AND date = '.$date.' AND heure BETWEEN "'.$heureDebut.'" AND "'.$heureFin.'" Order By heure');
	$rqtReservEmp->execute();

	return $rqtReservEmp;

}

//renvoie les absence d'un employ�
function abscencesEntEmploye($idEmp) {

	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$absences = $connexion->prepare('SELECT * FROM '.$nomE.'_absence
									JOIN '.$nomE.'_employe ON code_employe = id_employe WHERE id_employe = "'.$idEmp.'"' );
	$absences->execute();
	return $absences;
}

//R�cup�re les cr�neaux de libres par employ�s
function creneauLibreParEmp($listeEmp,$date){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$i = 1;
	$tabFinal = array(array());
	
	foreach($listeEmp as $val){
		
		$rqt = $connexion->prepare('SELECT heure, duree FROM '.$nomE.'_reserv WHERE employe = "'.$val.'" AND date = "'.$date.'" ORDER BY heure' );
		$rqt->execute();
		if($rqt->rowCount()!=0){
			${'tab'.$i} = array(array()); 
			$j=0;
			while($donnee = $rqt->fetch(PDO::FETCH_OBJ)){
				${'tab'.$i}[$j][0] = new DateTime($donnee->heure);
				$b = new DateInterval('PT'.$donnees->duree.'M');
				${'tab'.$i}[$j][1] = ${'tab'.$i}[$j][0]->add($b);
				$j++;
			}
			${'tab'.$i} = inverseCreneau(${'tab'.$i});
			//$tabFinal = assemblageCren($tabFinal, ${'tab'.$i});
			foreach(${'tab'.$i} as list($val, $val2)){
				$chaine.= $val."-".$val2." / ";
			}
			$chaine.="\n";
			$i++;
		}
	}
	return $chaine;
}

//Fait paseer un tableau de cr�neau occup� � un de cr�neau libre
function inverseCreneau($tab){
	$tab2 = array(array());
	if($tab[0][0]!= '08:00:00'){
		$tab2[0][0]='08:00:00';
		$tab2[0][1]=$tab[0][0];
	}
	$i=0;
	while($i < sizeof($tab)){
		$tab2[$i++][0]=$tab[$i][1];
		$tab2[$i++][1]=$tab[$i++][0];
		if($i++==sizeof($tab)-1){
			if($tab[$i][1]=='12:00:00'){
				$tab2[$i++][0] = $tab[$i][0];
				$tab2[$i++][1] = '12:00:00';
			}
		}
		$i++;
	}
	return $tab2;
}

//Assemble les cr�neaux des tableaux
function assemblageCren($tabFinal, $tab){
	if(sizeof($tabFinal)==0){
		$tabFinal = $tab;
		return $tabFinal;
	}else{
		$i = 0;
		foreach($tab as list($a, $b)){
			if($a<$tabFinal[$i][0]){
				if($b>=$tabFinal[$i][0] && $b<=$tabFinal[$i][1]){
					$tabFinal[$i][0] = $a;
				}
			}
		}
	}
}

//V�rifie l'existance d'un login pour un client
function existeLoginClient($log){
	$connexion = connect();
	$nomE = $_GET['nomEntreprise']; 
	$rqt = $connexion->prepare('SELECT * FROM '.$nomE.'_client WHERE login_client = "'.$log.'"');
	$rqt->execute();
	if($rqt->rowCount()==0){
		return 0;
	}else{
		return 1;
	}
}

//V�rifie l'existance d'un login pour une entreprise
function existeLoginEntreprise($log){
	$connexion = connect();
	$_SESSION['t'] = "SELECT * FROM entreprise WHERE loginAdmin = '".$log."'";
	$rqt = $connexion->prepare("SELECT * FROM entreprise WHERE loginAdmin = '".$log."'");
	$rqt->execute();
	if($rqt->rowCount()==0){
		return 0;
	}else{
		return 1;
	}
}
?>