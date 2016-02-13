<?php

//Permet d'ajouter un employé
function ajoutEmploye($connexion, $code, $nom, $prenom, $adresse, $mail, $tel, $presta) {
	
	$nomE = $_SESSION["nomSession"];

	$rqtAjoutEmp = $connexion->prepare("INSERT INTO ".$nomE."_employe(id_employe, nom_employe, prenom_employe, adresse_emp, 
						mail_emp, telephone_emp) 
						VALUES (:code, :nom, :prenom, :adresse, :mail, :tel)");
						
	$rqtAjoutEmp->execute(array("code" => $code, "nom" => $nom, "prenom" => $prenom, "adresse" => $adresse, 
								"mail" => $mail, "tel" => $tel));	
	
	$i = 0;
	foreach($presta as $val){
		if($val!=""){
			$rqtAjoutComp = $connexion->prepare("INSERT INTO ".$nomE."_competence(id_competence, employe, prestation) 
					VALUES (:id, :employe, :presta)");
			$rqtAjoutComp->execute(array("id" => $i, "employe" => $code, "presta" => $val));
			$i++;
		}
	}
								
}

//Permet de modifier un employé
function majEmploye($connexion, $nom, $prenom, $adresse, $mail, $tel, $presta1, $presta2, $presta3, $id_employe) {
	
	$nomE = $_SESSION["nomE"];
	$modifInfosEmp = $connexion->prepare("UPDATE ".$nomE."_employe SET nom_employe = :nom, 
								prenom_employe = :prenom, adresse_emp = :adresse, 
								mail_emp = :mail, telephone_emp = :tel, competenceA = :presta1,
								competenceB = :presta2, competenceC = :presta3 WHERE id_employe = :id_employe");
								
	$modifInfosEmp->execute(array('nom' => $nom, 'prenom' => $prenom, 'adresse' => $adresse, 'mail' => $mail, 'tel' => $tel, 'presta1' => $presta1,
									'presta2' => $presta2, 'presta3' => $presta3, 'id_employe' => $id_employe));	
	
}

//Permet d'ajouter le planning d'un employé
function ajoutPlanning($connexion, $code, $IDemp, $LundiM, $LundiA, $MardiM, $MardiA, $MercrediM, $MercrediA, $JeudiM, $JeudiA, $VendrediM, $VendrediA, $SamediM, $SamediA) {
	
	$nomE = $_SESSION["nomSession"];

	$rqtAjoutPlan = $connexion->prepare("INSERT INTO ".$nomE."_planning(id_agenda, code_employe, LundiM, LundiA, MardiM, 
													MardiA, MercrediM, MercrediA, JeudiM, JeudiA, VendrediM, VendrediA, SamediM, SamediA) 
													VALUES (:code, :IDemp, :LundiM, :LundiA, :MardiM, 
													:MardiA, :MercrediM, :$MercrediA, :JeudiM, :JeudiA, :VendrediM, 
													:VendrediA, :SamediM, :SamediA)");
													
	$rqtAjoutPlan->execute(array("code" => $code, "IDemp" => $IDemp, "LundiM" => $LundiM, "LundiA" => $LundiA, "MardiM" => $MardiM, "MardiA" => $MardiA,
								"MercrediM" => $MercrediM, "MercrediA" => $MercrediA, "JeudiM" => $JeudiM, "JeudiA" => $JeudiA, "VendrediM" => $VendrediM, 
								"VendrediA" => $VendrediA, "SamediM" => $SamediM, "SamediA" => $SamediA));
		
}

//Permet de modifer le planning d'un employé
function majPlanning($connexion, $LundiM, $LundiA, $MardiM, $MardiA, $MercrediM, $MercrediA, $JeudiM, $JeudiA, $VendrediM, $VendrediA, $SamediM, $SamediA, $id_employe) {
	
	$nomE = $_SESSION["nomE"];
	$modifPlan = $connexion->prepare("UPDATE LundiM = :LundiM, LundiA = :LundiA, 
								MardiM = :MardiM, MardiA = :MardiA, MercrediM = :MercrediM, MercrediA = :MercrediA,
								JeudiM = :JeudiM, JeudiA = :JeudiA, VendrediM = :VendrediM, VendrediA = :VendrediA,
								SamediM = :SamediM, SamediA = :SamediA WHERE id_employe = :id_employe");
								
	$modifPlan->execute(array("LundiM" => $LundiM, "LundiA" => $LundiA, "MardiM" => $MardiM, "MardiA" => $MardiA,
								"MercrediM" => $MercrediM, "MercrediA" => $MercrediA, "JeudiM" => $JeudiM, "JeudiA" => $JeudiA, "VendrediM" => $VendrediM, 
								"VendrediA" => $VendrediA, "SamediM" => $SamediM, "SamediA" => $SamediA, 'id_employe' => $id_employe));	
	
}

//Supprime un employé, dont son planning
function supprimerEmp($connexion, $IDemp) {
	
	$nomE = $_SESSION["nomSession"];
	
	$rqtSupEmp = $connexion->prepare("DELETE FROM ".$nomE."_planning WHERE code_employe='".$IDemp."'");
	$rqtSupEmp->execute();
	
}

//Supprime le planning d'un employé
function supprimerPlan($connexion, $IDemp) {
	
	$nomE = $_SESSION["nomSession"];
	
	$rqtSupPlan = $connexion->prepare("DELETE FROM ".$nomE."_employe WHERE id_employe='".$IDemp."'");
	$rqtSupPlan->execute();
}

//Permet de créer une entreprise
function creerEntreprise($connexion, $entreprise, $mail, $login, $mdpHash, $creneau) {
	
	$rqtCreerEnt = $connexion->prepare("INSERT INTO entreprise(nomEntreprise, mailEntreprise, loginAdmin, mdpAdmin, CreneauLibre) 
						VALUES (:entreprise, :mail, :login, :mdpHash, :CreneauLibre)");
						
	$rqtCreerEnt->execute(array("entreprise" => $entreprise, "mail" => $mail, "login" => $login, "mdpHash" => $mdpHash, "CreneauLibre" => $creneau));					
		   
}

//Permet d'ajouter toutes les informations d'une entreprise
function ajoutEntreprise($connexion, $temploye, $tprestation, $tclient, $treserv, $tplanning, $tabsence, $tcompetence) {
	
	$rqtAjout1 = $connexion->prepare("CREATE TABLE ".$temploye." ( id_employe CHAR(8) PRIMARY KEY, nom_employe VARCHAR(40), 
													prenom_employe VARCHAR(50), telephone_emp CHAR(10), adresse_emp VARCHAR(200),
													mail_emp VARCHAR(50))");
	$rqtAjout1->execute();												
													
	$rqtAjout2 = $connexion->prepare("CREATE TABLE ".$tprestation." ( id_presta CHAR(8) PRIMARY KEY, descriptif_presta TEXT, prix DECIMAL(5,2), 
														paypal BOOLEAN, duree INT)");
	$rqtAjout2->execute();													
														
	$rqtAjout3 = $connexion->prepare("CREATE TABLE ".$tclient." ( id_client CHAR(8) PRIMARY KEY, nom_client VARCHAR(40), prenom_client VARCHAR(50), 
													mail VARCHAR(50), login_client VARCHAR(30), mdp_client VARCHAR(30))");
	$rqtAjout3->execute();												
													
	$rqtAjout4 = $connexion->prepare("CREATE TABLE ".$treserv." ( id_reserv CHAR(8) PRIMARY KEY, client CHAR(8), employe CHAR(8), presta CHAR(8), 
													paye BOOLEAN, date DATE, heure TIME)");
	$rqtAjout4->execute();												
													
	$rqtAjout5 = $connexion->prepare("CREATE TABLE ".$tplanning." (
  					`id_agenda` char(8) PRIMARY KEY,
					`code_employe` char(8) NOT NULL,
 					`LundiM` BOOLEAN, `LundiA` BOOLEAN,
  					`MardiM` BOOLEAN, `MardiA` BOOLEAN,
  					`MercrediM` BOOLEAN, `MercrediA` BOOLEAN,
  					`JeudiM` BOOLEAN, `JeudiA` BOOLEAN,
  					`VendrediM` BOOLEAN, `VendrediA` BOOLEAN,
  					`SamediM` BOOLEAN, `SamediA` BOOLEAN)");
	$rqtAjout5->execute();				
					
	$rqtAjout6 = $connexion->prepare("CREATE TABLE ".$tabsence." (
  						`id_absence` char(8) PRIMARY KEY,
						`code_employe` char(8) NOT NULL,
 						`motif` varchar(100),
  						`dateDebut` date,
  						`dateFin` date,
  						`absenceFini` BOOLEAN)");
	$rqtAjout6->execute();		
	
	$rqtAjout7 = $connexion->prepare("CREATE TABLE ".$tcompetence." (
  						`id_competence` char(8) PRIMARY KEY,
						`employe` char(8) NOT NULL,
  						`prestation` CHAR(8) NOT NULL)");
	$rqtAjout7->execute();
}

//Permet de modifier toutes les informations d'une entreprise
function modifEntreprise($connexion, $mail, $tel, $adresse, $logo, $descrip, $login, $mdp) {
	
	$nomE = $_SESSION["nomE"];
	/* $modifInfosEnt = $connexion->prepare("UPDATE entreprise SET mailEntreprise = '".$mail."', telEntreprise = '".$tel."', 
								adresseEntreprise = '".$adresse."', logoEntreprise = '".$logo."', 
								descEntreprise = '".$descrip."', loginAdmin = '".$login."', mdpAdmin = '".$mdp."' 
								WHERE nomEntreprise = '".$nomE."'"); */
								
	$modifInfosEnt = $connexion->prepare("UPDATE entreprise SET mailEntreprise = :mail, telEntreprise = :tel, 
								adresseEntreprise = :adresse, logoEntreprise = :logo, 
								descEntreprise = :descrip, loginAdmin = :login, mdpAdmin = :mdp WHERE nomEntreprise = :nomE");						
								
	$modifInfosEnt->execute(array('mail' => $mail, 'tel' => $tel, 'adresse' => $adresse, 'logo' => $logo, 'descrip' => $descrip,
									'login' => $login, 'mdp' => $mdp, 'nomE' => $nomE));							
	
}

//Permet de modfier les informations d'une entreprise sauf le mot de passe
function modifEnt($connexion, $mail, $tel, $adresse, $logo, $descrip, $login) {
	
	$nomE = $_SESSION["nomE"];
	/** $modifInfosEnt2 = $connexion->prepare("UPDATE entreprise SET mailEntreprise = '".$mail."', telEntreprise = '".$tel."', 
						adresseEntreprise = '".$adresse."', logoEntreprise = '".$logo."', 
						descEntreprise = '".$descrip."', loginAdmin = '".$login."' WHERE nomEntreprise = '".$nomE."'"); */
						
	$modifInfosEnt2 = $connexion->prepare("UPDATE entreprise SET mailEntreprise = :mail, telEntreprise = :tel, 
								adresseEntreprise = :adresse, logoEntreprise = :logo, 
								descEntreprise = :descrip, loginAdmin = :login WHERE nomEntreprise = :nomE");						
						
	$modifInfosEnt2->execute(array('mail' => $mail, 'tel' => $tel, 'adresse' => $adresse, 'logo' => $logo, 'descrip' => $descrip,
									'login' => $login, 'nomE' => $nomE));					
	
}

//Permet d'ajouter une prestation
function ajoutPresta($connexion, $code, $descrip, $prix, $paypal, $duree, $employe) {
	
	$nomE = $_SESSION["nomE"];
	$rqtAjoutPresta = $connexion->prepare("INSERT INTO ".$nomE."_prestation(id_presta, descriptif_presta, prix, paypal, duree) 
										VALUES (:code, :descrip, :prix, :paypal, :duree)");
	$rqtAjoutPresta->execute(array('code' => $code, 'descrip' => $descrip, 'prix' => $prix, 'paypal' => $paypal, 'duree' => $duree));									
	
	$i = 0;
	foreach($employe as $val){
		if($val!=""){
			$rqtAjoutComp = $connexion->prepare("INSERT INTO ".$nomE."_competence(id_competence, employe, prestation)
					VALUES (:id, :employe, :presta)");
			$rqtAjoutComp->execute(array("id" => $i, "employe" => $val, "presta" => $code));
			$i++;
		}
	}
}

//Permet de modifier une prestation
function majPresta($connexion, $descrip, $prix, $paypal, $duree, $id_presta) {
	
	$nomE = $_SESSION["nomE"];
	$modifPresta = $connexion->prepare("UPDATE ".$nomE."_prestation SET descriptif_presta = :descrip, 
								prix = :prix, paypal = :paypal, duree = :duree WHERE id_presta = :id_presta");
								
	$modifPresta->execute(array('descrip' => $descrip, 'prix' => $prix, 'paypal' => $paypal, 'duree' => $duree, 'id_presta' => $id_presta));
	
}

//Permet de mettre à jour la compétence A d'un employé
function majCompA($connexion, $code, $employe) {
	
	$nomE = $_SESSION["nomE"];
	$rqtMajComA = $connexion->prepare("UPDATE ".$nomE."_employe SET competenceA = :code WHERE id_employe = :employe");
	$rqtMajComA->execute(array('code' => $code, 'employe' => $employe));
}

//Permet de mettre à jour la compétence B d'un employé
function majCompB($connexion, $code, $employe) {
	
	$nomE = $_SESSION["nomE"];
	$rqtMajComB = $connexion->prepare("UPDATE ".$nomE."_employe SET competenceB = :code WHERE id_employe = :employe");
	$rqtMajComB->execute(array('code' => $code, 'employe' => $employe));
}

//Permet de mettre à jour la compétence C d'un employé
function majCompC($connexion, $code, $employe) {
	
	$nomE = $_SESSION["nomE"];
	$rqtMajComC = $connexion->prepare("UPDATE ".$nomE."_employe SET competenceC = :code WHERE id_employe = :employe");
	$rqtMajComC->execute(array('code' => $code, 'employe' => $employe));
}

//Permet de supprimer une prestation
function supprimerPresta($connexion, $presta) {
	
	$nomE = $_SESSION["nomSession"];
	
	$rqtSupPresta = $connexion->prepare("DELETE FROM ".$nomE."_prestation WHERE id_presta='".$presta."'");
	$rqtSupPresta->execute();
	
}

//Permet d'ajouter une réservation
function ajoutReservation($connexion, $code, $employeAbsent, $motif, $debutReserv, $finReserv, $fin) {
	
	$nomE = $_SESSION["nomSession"];
	
	/**$connexion->exec("INSERT INTO ".$nomE."_absence(id_absence, code_employe, motif, dateDebut, dateFin, absenceFini) 
					VALUES ('".$code."', '".$_POST['employe_absent']."', '".$_POST['motif']."', '".$_POST['debut']."', '".$_POST['fin']."', '".$fin."')"); */
					
	$rqtAjoutReserv = $connexion->prepare("INSERT INTO ".$nomE."_absence(id_absence, code_employe, motif, dateDebut, dateFin, absenceFini) 
					VALUES (:code, :employeAbsent, :motif, :debutReserv, :finReserv, :fin)");

	$rqtAjoutReserv->execute(array('code' => $code, 'employeAbsent' => $employeAbsent, 'motif' => $motif, 'debutReserv' => $debutReserv, 
									'finReserv' => $finReserv, 'fin' => $fin));
		
}

//Modifie un client avec nouveau mot de passe
function modifClientMdp($connexion, $nom, $prenom, $mail, $login, $mdp){
	$nomE = $_SESSION["nomSession"];
	$id = $_SESSION["client"];
	$rqtMajClient = $connexion->prepare("UPDATE ".$nomE."_client SET nom_client = :nom_client, prenom_client = :prenom_client, mail = :mail, login_client = :login_client, mdp_client = :mdp_client WHERE id_client = :client");
	$rqtMajClient->execute(array('nom_client' => $nom, 'prenom_client' => $prenom, 'mail' => $mail, 'login_client' => $login, 'mdp_client' => $mdp, 'client' => $id));
}

//Modifie un client sans nouveau mot de passe
function modifClient($connexion, $nom, $prenom, $mail, $login){
	$nomE = $_SESSION["nomSession"];
	$id = $_SESSION["client"];
	$rqtMajClient = $connexion->prepare("UPDATE ".$nomE."_client SET nom_client = :nom_client, prenom_client = :prenom_client, mail = :mail, login_client = :login_client WHERE id_client = :client");
	$rqtMajClient->execute(array('nom_client' => $nom, 'prenom_client' => $prenom, 'mail' => $mail, 'login_client' => $login, 'client' => $id));
}
?>