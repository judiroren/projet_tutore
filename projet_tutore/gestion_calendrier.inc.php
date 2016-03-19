<?php

/* Determine un tableau d'employe disponible a la date $date le matin si $matin = 1 sinon l'apres midi */
function recup_employe_dispo($connexion, $idemployes, $jour, $matin) {
	$nomE = $_SESSION ["nomSession"];
	
	$employeDispo = array ();
	
	if ($matin == 1) {
		$jour .= "M";
	} else {
		$jour .= "A";
	}
	
	while ( ($emp = $idemployes->fetch ( PDO::FETCH_OBJ )) != null ) {
		$planning = planningEmp ( $emp->employe );
		$pl = $planning->fetch ( PDO::FETCH_OBJ );
		if ($pl->LundiM == 1) {
			array_push ( $employeDispo, $pl->code_employe );
		}
	}
	
	return $employeDispo;
}

// verifie si un employe est present a une certaine date renvoie true si present false sinon
function employePresent($idEmploye, $date) {
	$absence = abscencesEntEmploye ( $idEmploye );
	while ( ($empAbs = $absence->fetch ( PDO::FETCH_OBJ )) != null ) {
		$dateDebut = new DateTime ( $empAbs->dateDebut );
		$date = new DateTime ( $date );
		$dateFin = new DateTime ( $empAbs->dateFin );
		if ($dateDebut <= $date && $dateFin >= $date) {
			return false;
		}
	}
	return true;
}

// récupere les employe a partir d'un groupe, qui ne sont pas absent a une certaine date
function recup_employe_non_absent($connexion, $employe, $date) {
	$nomE = $_SESSION ["nomSession"];
	$employeNonAbsent = array ();
	foreach ( $employe as $emp ) {
		if (employePresent ( $emp, $date )) {
			array_push ( $employeNonAbsent, $emp );
		}
	}
	return $employeNonAbsent;
}

// renvoie un tableau des horaire ou l'employe est occupée sur une demi-journée
function creneauOccupeEmp($idEmp, $date, $matin) {
	$creneauOccupe = array ();
	$reserv = reservationsEmpDate ( $idEmp, $date, $matin );
	$i = 0;
	while ( ($res = $reserv->fetch ( PDO::FETCH_OBJ )) != null ) {
		$creneauOccupe [$i] [0] = timeToStr ( $res->heure );
		$creneauOccupe [$i] [1] = intToStr ( timeToInt ( $res->heure ) + $res->duree );
		$i ++;
	}
	return $creneauOccupe;
}
function timeToInt($time) {
	$date = new DateTime ( $time );
	$str = $date->format ( 'H' ) . "h" . $date->format ( "i" );
	return StrToInt ( $str );
}
function timeToStr($time) {
	return intToStr ( timeToInt ( $time ) );
}
function intToStr($int) {
	$minute = $int % 60;
	$int = $int - $minute;
	$heure = ( int ) $int / 60;
	if ($heure < 10) {
		$heure = "0" . $heure;
	}
	if ($minute < 10) {
		$minute = "0" . $minute;
	}
	return $heure . "h" . $minute;
}

// convertis une horaire de chaine de caractère en int
function StrToInt($horaire) {
	$heure = strstr ( $horaire, 'h', true );
	$minute = substr ( strstr ( $horaire, 'h' ), 1 );
	// echo $heure. " ". $minute;echo "<br/>";
	return $heure * 60 + $minute;
}

// Transforme un tableau des creneaux occupée en creaneau Libre sur une demi journée
function creneauLibre($creneauOccupe, $matin) {
	if ($matin == 1) {
		if ($creneauOccupe == null) {
			return $creneauLibre = array (
					array (
							"08h00",
							"12h00" 
					) 
			);
		}
		$i = 0;
		if (strcmp ( $creneauOccupe [0] [0], "08h00" ) != 0) {
			$creneauLibre [0] [0] = "08h00";
			$creneauLibre [0] [1] = $creneauOccupe [0] [0];
			$i = 1;
		}
		foreach ( $creneauOccupe as $creneau ) {
			if ($i != 0) {
				$creneauLibre [$i - 1] [1] = $creneau [0];
			}
			
			if (strcmp ( $creneau [1], "12h00" ) != 0) {
				$creneauLibre [$i] [0] = $creneau [1];
				$creneauLibre [$i] [1] = "12h00";
			}
			$i ++;
		}
	} else {
		if ($creneauOccupe == null) {
			return $creneauLibre = array (
					array (
							"13h00",
							"18h00" 
					) 
			);
		}
		$i = 0;
		if (strcmp ( $creneauOccupe [0] [0], "13h00" ) != 0) {
			$creneauLibre [0] [0] = "13h00";
			$creneauLibre [0] [1] = $creneauOccupe [0] [0];
			$i = 1;
		}
		foreach ( $creneauOccupe as $creneau ) {
			if ($i != 0) {
				$creneauLibre [$i - 1] [1] = $creneau [0];
			}
			if (strcmp ( $creneau [1], "18h00" ) != 0) {
				$creneauLibre [$i] [0] = $creneau [1];
				$creneauLibre [$i] [1] = "18h00";
			}
			$i ++;
		}
	}
	
	// supression des créneau de 0 min (ex: 9h45 - 9h45)
	for($i = 0; $i < count ( $creneauLibre ); $i ++) {
		if (strcmp ( $creneauLibre [$i] [0], $creneauLibre [$i] [1] ) == 0) {
			array_splice ( $creneauLibre, $i, 1 );
		}
	}
	return $creneauLibre;
}

// creneau libre regroupant tous les creneau libre des employés
function creneauLibrePourTous($creneauLibres) {
	foreach ( $creneauLibres as $creneau ) {
		if (empty ( $creneauLibreFinal )) {
			$creneauLibreFinal = $creneau;
			continue;
		}
		
		foreach ( $creneau as $horaire ) {
			$horaireDebut = StrToInt ( $creneauLibreFinal [0] [0] );
			$horaireFin = StrToInt ( $creneauLibreFinal [0] [1] );
			$newHoraireDebut = StrToInt ( $horaire [0] );
			$newHoraireFin = StrToInt ( $horaire [1] );
			if ($newHoraireDebut < $horaireDebut) {
				if ($newHoraireFin < $horaireDebut) {
					array_unshift ( $creneauLibreFinal, $horaire );
				} elseif ($newHoraireFin < $horaireFin) {
					$creneauLibreFinal [0] [0] = $horaire [0];
				} elseif ($newHoraireFin > $horaireFin) {
					$creneauLibreFinal [0] [0] = $horaire [0];
					$creneauLibreFinal [0] [1] = $horaire [1];
				}
			} elseif ($newHoraireDebut > $horaireFin) {
				array_push ( $creneauLibreFinal, $horaire );
			} elseif ($newHoraireDebut < $horaireFin) {
				if ($newHoraireFin > $horaireFin) {
					$creneauLibreFinal [0] [1] = $horaire [1];
				}
			}
		}
	}
	return $creneauLibreFinal;
}

// fusionne les créneaux (ex: 8h30-9h15,9h00-9h45 => 8h30-9h45)
function fusion($creneauLibre) {
	
	// retrie le tableau par horaire de debut
	asort ( $creneauLibre );
	$creneauLibres = array ();
	foreach ( $creneauLibre as $creneau ) {
		array_push ( $creneauLibres, $creneau );
	}
	$creneauLibre = $creneauLibres;
	
	$i = 0;
	while ( $i < (count ( $creneauLibre )) - 1 ) {
		
		if (StrToInt ( $creneauLibre [$i] [1] ) >= StrToInt ( $creneauLibre [$i + 1] [1] )) {
			array_splice ( $creneauLibre, $i + 1, 1 );
			continue;
		}
		if (StrToInt ( $creneauLibre [$i] [1] ) < StrToInt ( $creneauLibre [$i + 1] [1] )) {
			if (StrToInt ( $creneauLibre [$i] [1] ) >= StrToInt ( $creneauLibre [$i + 1] [0] )) {
				$creneauLibre [$i] [1] = $creneauLibre [$i + 1] [1];
				array_splice ( $creneauLibre, $i + 1, 1 );
				continue;
			}
			if (StrToInt ( $creneauLibre [$i] [1] ) < StrToInt ( $creneauLibre [$i + 1] [0] )) {
				$i ++;
			}
		}
	}
	return $creneauLibre;
}

// utilisation:
//   - $presta = 'PRES1'
//   - $jourSemaine = 'Lundi'
//   - $matin = 1 pour le matin, 0 pour l'apres midi
//   - $jour = '2016-03-11'
function horaireCreneauLibre($presta, $connexion, $jourSemaine, $matin, $jour) {
	$idemployes = listeEmpCapable ( $presta ); // recup employé presta
	
	$idemployes = recup_employe_dispo ( $connexion, $idemployes, $jourSemaine, $matin ); // recup employe travaillant sur la demi journé
	
	$idemployes = recup_employe_non_absent ( $connexion, $tab, $jour );
	
	$creneauLibres = array ();
	foreach ( $idemployes as $emp ) {
		
		$creneauOccupe = creneauOccupeEmp ( $emp, $jour, $matin );
		
		$creneauLibre = creneauLibre ( $creneauOccupe, $matin );
		
		array_push ( $creneauLibres, $creneauLibre );
	}
	$libre = creneauLibrePourTous ( $creneauLibres );
	
	$libre = fusion ( $libre );
	print_r($libre);
	return $libre;
}
?>