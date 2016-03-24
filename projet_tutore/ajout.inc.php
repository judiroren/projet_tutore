<?php

//Permet d'ajouter un employé
function ajoutEmploye($connexion, $code, $nom, $prenom, $adresse, $mail, $tel, $presta) {
	
	$nomE = $_SESSION["nomSession"];

	$rqtAjoutEmp = $connexion->prepare("INSERT INTO ".$nomE."_employe(id_employe, nom_employe, prenom_employe, adresse_emp, 
						mail_emp, telephone_emp) 
						VALUES (:code, :nom, :prenom, :adresse, :mail, :tel)");
						
	$rqtAjoutEmp->execute(array("code" => $code, "nom" => $nom, "prenom" => $prenom, "adresse" => $adresse, 
								"mail" => $mail, "tel" => $tel));	
	
	foreach($presta as $val){
		if($val!=""){
			$nomTable = $nomE."_competence";
			$i = code($nomTable,'id_competence');
			$rqtAjoutComp = $connexion->prepare("INSERT INTO ".$nomE."_competence(id_competence, employe, prestation) 
					VALUES (:id, :employe, :presta)");
			$rqtAjoutComp->execute(array("id" => $i, "employe" => $code, "presta" => $val));
		}
	}
								
}

//Permet de modifier un employé
function majEmploye($connexion, $nom, $prenom, $adresse, $mail, $tel, $id_employe) {
	
	$nomE = $_SESSION["nomE"];
	$modifInfosEmp = $connexion->prepare("UPDATE ".$nomE."_employe SET nom_employe = :nom, 
								prenom_employe = :prenom, adresse_emp = :adresse, 
								mail_emp = :mail, telephone_emp = :tel WHERE id_employe = :id_employe");
								
	$modifInfosEmp->execute(array('nom' => $nom, 'prenom' => $prenom, 'adresse' => $adresse, 'mail' => $mail, 'tel' => $tel, 'id_employe' => $id_employe));	
	
}

//Permet d'ajouter le planning d'un employé
function ajoutPlanning($connexion, $code, $IDemp, $LundiM, $LundiA, $MardiM, $MardiA, $MercrediM, $MercrediA, $JeudiM, $JeudiA, $VendrediM, $VendrediA, $SamediM, $SamediA) {
	
	$nomE = $_SESSION["nomSession"];

	$rqtAjoutPlan = $connexion->prepare("INSERT INTO ".$nomE."_planning(id_agenda, code_employe, LundiM, LundiA, MardiM, 
													MardiA, MercrediM, MercrediA, JeudiM, JeudiA, VendrediM, VendrediA, SamediM, SamediA) 
													VALUES (:code, :IDemp, :LundiM, :LundiA, :MardiM, 
													:MardiA, :MercrediM, :MercrediA, :JeudiM, :JeudiA, :VendrediM, 
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
	
	$rqtSupComp = $connexion->prepare("DELETE FROM ".$nomE."_competence WHERE employe='".$IDemp."'");
	$rqtSupComp->execute();
	
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
function ajoutEntreprise($connexion, $temploye, $tprestation, $tclient, $treserv, $tplanning, $tabsence, $tcompetence, $tprestresv, $tcategorie) {
	
	$rqtAjout1 = $connexion->prepare("CREATE TABLE ".$temploye." ( id_employe CHAR(8) PRIMARY KEY, 
																	nom_employe VARCHAR(40), 
																	prenom_employe VARCHAR(50), 
																	telephone_emp CHAR(10), 
																	adresse_emp VARCHAR(200),
																	mail_emp VARCHAR(50))");
	$rqtAjout1->execute();												
													
	$rqtAjout2 = $connexion->prepare("CREATE TABLE ".$tprestation." ( id_presta CHAR(8) PRIMARY KEY, descriptif_presta TEXT, cout DECIMAL(5,2), 
														paypal BOOLEAN, duree INT, categorie VARCHAR(20))");
	$rqtAjout2->execute();													
														
	$rqtAjout3 = $connexion->prepare("CREATE TABLE ".$tclient." ( id_client CHAR(8) PRIMARY KEY, nom_client VARCHAR(40), prenom_client VARCHAR(50), 
													mail VARCHAR(50), login_client VARCHAR(30), mdp_client VARCHAR(30))");
	$rqtAjout3->execute();												
													
	$rqtAjout4 = $connexion->prepare("CREATE TABLE ".$treserv." ( id_reserv CHAR(8) PRIMARY KEY, client CHAR(8), employe CHAR(8), 
													paye BOOLEAN, date DATE, heure TIME, prix DECIMAL(5,2), duree INT)");
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
						`demiJourDebut` BOOLEAN,
						`demiJourFin` BOOLEAN,
  						`absenceFini` BOOLEAN)");
	$rqtAjout6->execute();		
	
	$rqtAjout7 = $connexion->prepare("CREATE TABLE ".$tcompetence." (
  						`id_competence` char(8) PRIMARY KEY,
						`employe` char(8) NOT NULL,
  						`prestation` CHAR(8) NOT NULL)");
	$rqtAjout7->execute();
	
	$rqtAjout8 = $connexion->prepare("CREATE TABLE ".$tprestresv." (
  						`id_prestresv` char(8) PRIMARY KEY,
						`reservation` char(8) NOT NULL,
  						`prestation` CHAR(8) NOT NULL)");
	$rqtAjout8->execute();
	
	$rqtAjout9 = $connexion->prepare("CREATE TABLE ".$tcategorie." (
						`categorie` varchar(20) PRIMARY KEY)");
	$rqtAjout9->execute();
}

//Permet de modifier toutes les informations d'une entreprise
function modifEntreprise($connexion, $mail, $tel, $adresse, $logo, $descrip, $login, $mdp) {
	
	$nomE = $_SESSION["nomE"];
								
	$modifInfosEnt = $connexion->prepare("UPDATE entreprise SET mailEntreprise = :mail, telEntreprise = :tel, 
								adresseEntreprise = :adresse, logoEntreprise = :logo, 
								descEntreprise = :descrip, loginAdmin = :login, mdpAdmin = :mdp WHERE nomEntreprise = :nomE");						
								
	$modifInfosEnt->execute(array('mail' => $mail, 'tel' => $tel, 'adresse' => $adresse, 'logo' => $logo, 'descrip' => $descrip,
									'login' => $login, 'mdp' => $mdp, 'nomE' => $nomE));							
	
}

//Permet de modfier les informations d'une entreprise sauf le mot de passe
function modifEnt($connexion, $mail, $tel, $adresse, $logo, $descrip, $login) {
	
	$nomE = $_SESSION["nomE"];
							
	$modifInfosEnt2 = $connexion->prepare("UPDATE entreprise SET mailEntreprise = :mail, telEntreprise = :tel, 
								adresseEntreprise = :adresse, logoEntreprise = :logo, 
								descEntreprise = :descrip, loginAdmin = :login WHERE nomEntreprise = :nomE");						
						
	$modifInfosEnt2->execute(array('mail' => $mail, 'tel' => $tel, 'adresse' => $adresse, 'logo' => $logo, 'descrip' => $descrip,
									'login' => $login, 'nomE' => $nomE));					
	
}

//Permet d'ajouter une prestation
function ajoutPresta($connexion, $code, $descrip, $cout, $paypal, $duree, $employe, $categorie) {
	
	$nomE = $_SESSION["nomE"];
	
	$rqtAjoutPresta = $connexion->prepare("INSERT INTO ".$nomE."_prestation(id_presta, descriptif_presta, cout, paypal, duree, categorie) 
										VALUES (:code, :descrip, :cout, :paypal, :duree, :categorie)");
	$rqtAjoutPresta->execute(array('code' => $code, 'descrip' => $descrip, 'cout' => $cout, 'paypal' => $paypal, 'duree' => $duree, 'categorie' => $categorie));									
	
	if($employe != null){
		foreach($employe as $val){
			if($val!=""){
				$nomTable = $nomE."_competence";
				$i = code($nomTable,'id_competence');
				$rqtAjoutComp = $connexion->prepare("INSERT INTO ".$nomE."_competence(id_competence, employe, prestation)
						VALUES (:id, :employe, :presta)");
				$rqtAjoutComp->execute(array("id" => $i, "employe" => $val, "presta" => $code));
				$i++;
			}
		}
	}
}

//Permet d'ajouter une prestation sans les compétences
function ajoutPrestaSansEmp($connexion, $code, $descrip, $cout, $paypal, $duree, $categorie) {

	$nomE = $_SESSION["nomE"];

	$rqtAjoutPresta = $connexion->prepare("INSERT INTO ".$nomE."_prestation(id_presta, descriptif_presta, cout, paypal, duree, categorie)
										VALUES (:code, :descrip, :cout, :paypal, :duree, :categorie)");
	$rqtAjoutPresta->execute(array('code' => $code, 'descrip' => $descrip, 'cout' => $cout, 'paypal' => $paypal, 'duree' => $duree, 'categorie' => $categorie));

}

//Permet de modifier une prestation
function majPresta($connexion, $descrip, $cout, $duree, $categorie, $paypal, $id_presta) {
	
	$nomE = $_SESSION["nomE"];
	$modifPresta = $connexion->prepare("UPDATE ".$nomE."_prestation SET descriptif_presta = :descrip, 
								cout = :cout, paypal = :paypal, duree = :duree, categorie = :categorie WHERE id_presta = :id_presta");
								
	$modifPresta->execute(array('descrip' => $descrip, 'cout' => $cout, 'paypal' => $paypal, 'duree' => $duree, 'categorie' => $categorie, 'id_presta' => $id_presta));
	
}

//Permet de supprimer une prestation
function supprimerPresta($connexion, $presta) {
	
	$nomE = $_SESSION["nomSession"];
	
	$rqtSupPresta = $connexion->prepare("DELETE FROM ".$nomE."_prestation WHERE id_presta='".$presta."'");
	$rqtSupPresta->execute();
	
	$rqtSupComp = $connexion->prepare("DELETE FROM ".$nomE."_competence WHERE prestation='".$presta."'");
	$rqtSupComp->execute();
}

//Permet d'ajouter une absence
function ajoutAbscence($connexion, $code, $employeAbsent, $motif, $debutReserv, $finReserv, $demiDebut, $demiFin, $fin) {
	
	$nomE = $_SESSION["nomSession"];
	
	$rqtAjoutAbs = $connexion->prepare("INSERT INTO ".$nomE."_absence(id_absence, code_employe, motif, dateDebut, dateFin, demiJourDebut, demiJourFin, absenceFini) 
					VALUES (:code, :employeAbsent, :motif, :debutReserv, :finReserv, :demiDebut, :demiFin, :fin)");

	$rqtAjoutAbs->execute(array('code' => $code, 'employeAbsent' => $employeAbsent, 'motif' => $motif, 'debutReserv' => $debutReserv, 
									'finReserv' => $finReserv, 'demiDebut' => $demiDebut, 'demiFin' => $demiFin, 'fin' => $fin));
		
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



//Ajoute des nouvelles compétences
function ajouteComp($connexion, $tabPrest, $emp){
	$nomE = $_SESSION["nomE"];
	
	$rqtDeleteComp = $connexion->prepare("DELETE FROM ".$nomE."_competence WHERE employe = '".$emp."'");
	$rqtDeleteComp->execute();
	$id = code($nomE."_competence", 'id_competence');
	if($tabPrest!=null){	
		foreach ($tabPrest as $val){
			
			$rqtAjoutComp = $connexion->prepare("INSERT INTO ".$nomE."_competence(id_competence, employe, prestation) 
						VALUES (:id, :emp, :prest)");
	
			$rqtAjoutComp->execute(array('id' => $id, 'emp' => $emp, 'prest' => $val));
			$id++;
		}
	}
}

//Ajoute des nouvelles compétences
function ajouteComp2($connexion, $tabNouveauEmp, $presta){
	$nomE = $_SESSION["nomE"];
	$rqtSuppr = $connexion->prepare("DELETE FROM ".$nomE."_competence WHERE prestation = '".$presta."'");
	$rqtSuppr->execute();
	$id = code($nomE."_competence", 'id_competence');
	if($tabNouveauEmp!=null){	
		foreach ($tabNouveauEmp as $val){
			$rqtAjoutComp = $connexion->prepare("INSERT INTO ".$nomE."_competence(id_competence, employe, prestation)
						VALUES (:id, :emp, :prest)");
			$rqtAjoutComp->execute(array('id' => $id, 'emp' => $val, 'prest' => $presta));
			$id++;
		}
	}
}

//Ajout d'une réservation et des liens avec prestations
function enregistreReserv($connexion, $listePrest, $client, $date, $heure, $paye, $duree, $prix, $emp){
	$nomE = $_SESSION["nomE"];
	$info = infosEntreprise();
	if($info->CreneauLibre==0){
		$minute = intval(substr($heure,3,4));
		$limite = array(0,15,30,45);
		while(!in_array($minute,$limite)){
			$minute--;
		}
		$heure = intval(substr($heure,0,2));
		$heure = new DateTime($heure.':'.$minute.':00');
		$heure = $heure->format('H:i:s');
		while($duree%15!=0){
			$duree++;
		}
	
	}
	$emp = $emp[0];
	$id = code($nomE."_reserv", 'id_reserv');
	$rqtAjoutRes = $connexion->prepare("INSERT INTO ".$nomE."_reserv(id_reserv, client, employe, paye, date, heure, prix, duree)
					VALUES (:id, :cli, :emp, :payer, :d, :h, :p, :du)");
	$rqtAjoutRes->execute(array('id' => $id, 'cli' =>$client, 'emp' => $emp, 'payer' => $paye, 'd' => $date, 'h' => $heure, 'p' => $prix, 'du' => $duree));
	$id2 = code($nomE."_prestresv", 'id_prestresv');
	foreach ($listePrest as $val){
	
		$rqtAjoutPresRes = $connexion->prepare("INSERT INTO ".$nomE."_prestresv(id_prestresv, reservation, prestation)
					VALUES (:id, :res, :prest)");
	
		$rqtAjoutPresRes->execute(array('id' => $id2, 'res' => $id, 'prest' => $val));
		$id2++;
	}
}

//Ajoute une catégorie
function ajoutCategorie($connexion, $categorie){

	$nomE = $_SESSION["nomSession"];

	$rqtAjoutCat = $connexion->prepare("INSERT INTO ".$nomE."_categorie(categorie) VALUES (:categorie)");

	$rqtAjoutCat->execute(array('categorie' => $categorie));
}

//Supprime une catégorie
function supprimeCategorie($connexion, $categorie){
	$nomE = $_SESSION["nomSession"];
	$rqtSupprCat = $connexion->prepare("DELETE FROM ".$nomE."_categorie Where categorie = '".$categorie."'");
	$rqtSupprCat->execute();

	$rqtModifPrest = $connexion->prepare("UPDATE ".$nomE."_prestation SET categorie = '' WHERE categorie = '".$categorie."'");
	$rqtModifPrest->execute();
}

//Permet de modifier une absence
function modifierAbsence($connexion, $code, $motif, $debutReserv, $finReserv, $demiDebut, $demiFin) {

	$nomE = $_SESSION["nomSession"];
 
	$rqtMajAbs = $connexion->prepare("UPDATE ".$nomE."_absence SET motif = :motif, dateDebut = :debutReserv, dateFin = :finReserv,
            demiJourDebut = :demiDebut, demiJourFin = :demiFin WHERE id_absence = :code");

	$rqtMajAbs->execute(array('motif' => $motif, 'debutReserv' => $debutReserv,
			'finReserv' => $finReserv, 'demiDebut' => $demiDebut, 'demiFin' => $demiFin, 'code' => $code));

}

//Permet de supprimer une absence
function supprimerAbsence($connexion, $code) {

	$nomE = $_SESSION["nomSession"];
	 
	$rqtSupAbs = $connexion->prepare("DELETE FROM ".$nomE."_absence WHERE id_absence='".$code."'");
	$rqtSupAbs->execute();

}
?>