<?php
class Date{
	
	var $days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
	var $months = array('Janvier', 'F�vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao�t', 'Septembre', 'Octobre', 'Novembre', 'D�cembre');
	
	function getAll($year){
		$r = array();
		/*$date = strtotime($year.'-01-01');
		while(date('Y', $date) <= $year){
			$y = date('Y',$date);
			$m = date('m',$date);
			$d = date('d',$date);
			$w = str_replace('0','7',date('w',$date));
			$r[$y][$m][$d] = $w;
			$date = strtotime(date('Y-m-d',$date).' +1 DAY');
		}*/
		$date = new DateTime($year.'-01-01');
		while($date->format('Y') <= $year){
			$y = $date->format('Y');
			$m = $date->format('m');
			$d = $date->format('j');
			$w = str_replace('0','7',$date->format('w'));
			$r[$y][$m][$d] = $w;
			$date->add(new DateInterval('P1D'));
		}
		return $r;
	}
}
?>