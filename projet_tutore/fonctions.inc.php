<?php

//Permet d'obtenir le tableau des absences
function absence($nomE, $id_employe, $connexion){
	
	$tab = tableauDate();
	
	$rqtDonnees = $connexion->prepare('SELECT * FROM '.$nomE.'_planning 
										WHERE code_employe = "'.$id_employe.'"');
	$rqtDonnees->execute();
	$donnees=$rqtDonnees->fetch(PDO::FETCH_OBJ);
	
	$rqtabs = $connexion->prepare('SELECT * FROM '.$nomE.'_absence 
									WHERE code_employe = "'.$id_employe.'" 
									AND dateDebut <= CURDATE() 
									AND dateFin >= CURDATE()');
	
	$rqtabs->execute();
									
	$val = array(array());
	
	if($rqtabs->rowCount()==0) {
		
		return null;
		
	} else { 
		
		$cpt=0;
		$i = 0;
		$nb=0;
		
		while($valeur=$rqtabs->fetch(PDO::FETCH_OBJ)) {
			
			for($nb=0;$nb<count($tab);$nb++) {
				
				if($tab[$cpt][0]<=$valeur->dateFin && $tab[$cpt][0]>=$valeur->dateDebut) {
					
					$val[$i][0]=$tab[$cpt][1];
					$val[$i][1]='A';
					$i++;
				}
				$cpt++;
			}
		}
		
		$absence = array(array());
		$absence[0][0] = ($donnees->LundiM==1?'X':" "); $absence[0][1] = ($donnees->LundiA==1?'X':" ");
		$absence[1][0] = ($donnees->MardiM==1?'X':" "); $absence[1][1] = ($donnees->MardiA==1?'X':" ");
		$absence[2][0] = ($donnees->MercrediM==1?'X':" "); $absence[2][1] = ($donnees->MercrediA==1?'X':" ");
		$absence[3][0] = ($donnees->JeudiM==1?'X':" "); $absence[3][1] = ($donnees->JeudiA==1?'X':" ");
		$absence[4][0] = ($donnees->VendrediM==1?'X':" "); $absence[4][1] = ($donnees->VendrediA==1?'X':" ");
		$absence[5][0] = ($donnees->SamediM==1?'X':" "); $absence[5][1] = ($donnees->SamediA==1?'X':" ");
		
		for($nb = 0 ; $nb < count($val) ; $nb++) {
			
			switch($val[$nb][0]){
				
				case 'lundi': $absence[0][0]='A';
				$absence[0][1]='A';
				break;
				case 'mardi': $absence[1][0]='A';
				$absence[1][1]='A';
				break;
				case 'mercredi': $absence[2][0]='A';
				$absence[2][1]='A';
				break;
				case 'jeudi': $absence[3][0]='A';
				$absence[3][1]='A';
				break;
				case 'vendredi': $absence[4][0]='A';
				$absence[4][1]='A';
				break;
				case 'samedi': $absence[5][0]='A';
				$absence[5][1]='A';
				break;
			}
		}
	}
	return $absence;
}

//Permet de récuperer la liste des jours de la semaine dans un tableau
function tableauDate(){
	
	setlocale(LC_TIME, 'fr_FR', 'french', 'fre', 'fra');
	$auj = date("Y-m-d");
	$t_auj = strtotime($auj);
	$p_auj = date('N', $t_auj);
	
	if($p_auj == 1){
		
		$deb = $t_auj;
		$fin = strtotime($auj.' + 6 day');
	}
	else if($p_auj == 7){
		
		$deb = strtotime($auj.' - 6 day');
		$fin = $t_auj;
	}
	else{
		
		$deb = strtotime($auj.' - '.(6-(7-$p_auj)).' day');
		$fin = strtotime($auj.' + '.(7-$p_auj).' day');
	}
	$cpt = 0;
	
	while($deb <= $fin){
		
		$tab[$cpt][0] = strftime('%Y-%m-%d', $deb);
		$tab[$cpt][1] = strftime('%A',$deb);
	
		$deb += 86400;
		$cpt++;
	}
	return $tab;
}

?>