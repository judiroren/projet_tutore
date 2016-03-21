<?php

	session_start();
	//$_SESSION["nomE"] = $_GET['nomEntreprise'];
	
	try {
		//$_SESSION["nomE"] = $_GET['nomEntreprise'];
		if($_GET['nomEntreprise'] != null) {
			$_SESSION["nomE"] = $_GET['nomEntreprise'];
		} else {
			throw new Exception("Notice: Undefined offset");
		}
	} catch(Exception $e){
		echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
	}
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	
	if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
		
	} else {
		
	$_SESSION["nomE"] = $_GET['nomEntreprise'];	
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$nomE = str_replace(' ', '_', $nomE);

	//permet de récuperer les infos de connexion
	$i = infosEntreprise();
	
	//récupère la liste des prestations de l'entreprise
	$prest = listePrestations();

	//Le mot de passe doit être renseigner
	if(isset($_POST['mdp'])) {
		
		//$mdp = md5($_POST['mdp']);
		$mdp = $_POST['mdp'];
	} 
	
	//Les informations doivent être correcte
	if( !empty($_POST['login']) && !empty($_POST['mdp']) ) {
		//récupération des infos de connexion des clients
		$j = logClient($_POST['login'], $_POST['mdp']);
		if($j!=null){
			if( $_POST['login'] == $j->login_client && $mdp == $j->mdp_client ) {
				$_SESSION["client"] = $j->id_client;
				$_SESSION["estConnecte"] = 1;
				$_SESSION["nomSession"] = $_GET['nomEntreprise'];
				
			}
		}
	}
	$erreur = 0;
	if(isset($_POST['continue'])){
			if(!empty($_POST['daterdv']) && !empty($_POST['heurerdv'])){
				$days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
				$jn = $days[date('w', strtotime($_POST['daterdv']))];
			if($jn!='Dimanche'){
					$dureeRes = 0;
					foreach ($_SESSION['prestListe'] as $val){
						$info = infosPrestation($val);
						$dureeRes = $dureeRes + $info->duree;
					}
					$emp = employeOk($_SESSION['prestListe']);
					$employe = employeReserv($_POST['daterdv'], $jn, $_POST['heurerdv'], $emp, $dureeRes);
					$valeurFaux = array(1,2,3,4);
					if(!in_array($employe,$valeurFaux)){
						$_SESSION["date"] = $_POST['daterdv'];
						$_SESSION["heure"] = $_POST['heurerdv'];
						$_SESSION["employeRes"] = $employe;
						header('Location: resume_reserv.php?nomEntreprise='.$nomE);
					}
				}else{
					$erreur = 3;
				}
			}else{
				$erreur = 2;
			}
					
		}else{
			$erreur = 1;
		}
	
	if(isset($_POST['annule'])){
		header('Location: accueil_client.php?nomEntreprise='.$nomE);
		unset($_SESSION['prestListe']);
		unset($_SESSION['date']);
		unset($_SESSION['heure']);
		unset($_SESSION['duree']);
		unset($_SESSION['prix']);
	}
	
?>

<html>
	<head>
		<title>Portail de réservation : Accueil BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />
		<script type="text/javascript" src="jquery-1.12.1.min.js"></script>
		<script type="text/javascript">
			jQuery(function($){ 
			var date = new Date(); 
			var current = date.getMonth()+1; 
			$('.month').hide(); 
			$('#month'+current).show(); 
			$('.months a#linkMonth'+current).addClass('active'); 
			$('.months a').click(function(){ 
			var month = $(this).attr('id').replace('linkMonth',''); 
			if(month != current){ 
			$('#month'+current).slideUp(); 
			$('#month'+month).slideDown(); 
			$('.months a').removeClass('active'); 
			$('.months a#linkMonth'+month).addClass('active'); 
			current = month; 
			} 
			return false; 
			}); 
			});
		</script>
	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
						
						<?php 
						
							if($i->logoEntreprise !="") {
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
						?>
							<h1>
							<?php 
							
								echo $nomE;
							?>
							</h1>
							<p>Page de gestion de l'entreprise</p>
							
							<?php 
							
							if(isset($_SESSION["estConnecteClient"])) {
								
							?>
								<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="profil.php?nomEntreprise=<?php echo $nomE ?>"> Accéder à son profil </a></br>
								<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> Réserver </a></br></br>
								<a href="destruct_session_client.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>
							</div>
							
							<?php
							
								} else {
							
							?>
						</div>
						<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
						<a href="inscription.php?nomEntreprise=<?php echo $nomE ?>"> S'inscrire </a></br>
						<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> Réserver </a></br></br>
						<form method="post" action="">
								<div class="row">
									<div class="6u 12u$(mobile)"><input type="text" name="login" placeholder="Login" /></div>
									</br></br></br>
									<div class="6u 12u$(mobile)"><input type="password" name="mdp" placeholder="Mot de passe" /></div>				
								</div>
								</br>
								<div align = "center" class="12u$">
									<input type="submit" name ="connecte" value="Connection" />
								</div>
							</form>
							
							<?php } ?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">
			<h1>Réservation : choix de la date et de l'heure</h1>
					<?php
					if(!isset($_GET['nomEntreprise'])) {
					
						echo "<h2>Le nom de l'entreprise doit être rajouté dans l'url à la suite sous la forme : ?nomEntreprise=nom.</h2>";
					
					} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
					
						echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</h2>";
					
					} else {
							
						//if(isset($_SESSION["estConnecteClient"])) {
					
						if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
					
							echo "<h2>Vous devez d'abord vous connectez sur le coté client de cette entreprise </h2>";
					
						} else {
							$valeurFaux = array(1,2,3,4);
								if(isset($employe) && in_array($employe,$valeurFaux)){
									switch($employe){
										case 1 : 
										case 2 : 
										case 3 : echo "Aucun employe ne sera disponible à ce moment là ! "	;
										break;
										case 4 : echo "L'entreprise n'ouvre qu'entre 8h et 12h le matin et 13h et 18h l'après-midi";
									}
								}
			require('date.php');
			$date = new Date();
			$year = date('Y')+1;
			$dates = $date->getAll($year);
		?>
		<div class="periods">
			<div class="year"><a href="dateReserv.php?nomEntreprise=<?php echo $nomE;?>"><?php echo $year-1; ?></a></div>
			<div class="year"><a href=""><?php echo $year; ?></a> </div>
			</br>
			<div class="months">
				<ul>
					<?php foreach ($date->months as $id=>$m): ?>
						<li><a href="" id="linkMonth<?php echo $id+1; ?>"><?php echo substr($m,0,3); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="clear"></div>
			<?php $dates = current($dates); ?>
			<?php foreach ($dates as $m => $days):?>
			<?php if($m < 10): $m = substr($m,1,1); endif;?>
				<div class="month relative" id="month<?php echo $m; ?>">
				<table class="cal">
					<thead>
						<tr>
							<?php foreach ($date->days as $d): ?>
								<th><?php echo substr($d,0,3); ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<tr>
						<?php $end = end($days); foreach ($days as $d=>$w):?>
							<?php if($d == 1 && $d != $w): ?>
								<td colspan="<?php echo $w-1; ?>" class="padding"></td>
							<?php endif; ?>
							<td>
								<div class="relative">
									<div class="day"><?php echo $d; ?></div>
								</div>
								<div class="daytitle">
									<?php echo $date->days[$w-1]." "; ?><?php echo $d." ";?><?php echo $date->months[$m-1]; ?>
								</div>
								<!-- Evenement : affiché sur le coté -->
								<ul class="events">
									<li>
										<?php 
										if($date->days[$w-1]!='Dimanche'){
											if($m < 10){	$mF = '0'.$m;	}else{	$mF = $m;	}
											if($d < 10){	$dF = '0'.$d;	}else{	$dF = $d;	}
											$dateF = $year.'-'.$mF.'-'.$dF;
											$emp2 = employeOk($_SESSION['prestListe']);
											$i = 0;
											echo "Créneau occupé par employé : </br>";
											while($i < sizeof($emp2)){
												$num = $i+1;
												echo "Employe ".$num. " : ";
												$jm = $date->days[$w-1].'M';
												$ja = $date->days[$w-1].'A';
												$rqtPlan = $connexion->prepare("SELECT ".$jm.", ".$ja." FROM ".$nomE."_planning WHERE code_employe = '".$emp2[$i]."'");
												$rqtPlan->execute();
												$donnees=$rqtPlan->fetch(PDO::FETCH_OBJ);
												if($donnees->$jm == 0 && $donnees->$ja==0){
													echo "Absent";
												}else{
													$rqtAbs = $connexion->prepare("SELECT dateDebut, dateFin, demiJourDebut, demiJourFin FROM ".$nomE."_absence WHERE '".$dateF."' BETWEEN dateDebut AND dateFin AND code_employe = '".$emp2[$i]."' ORDER BY dateDebut ASC");
													$rqtAbs->execute();
													if($rqtAbs->rowCount()!=0){
														$donnees2 = $rqtAbs->fetch(PDO::FETCH_OBJ);
														if($donnees2->dateDebut == $dateF){
															if($donnees2->demiJourDebut==0){
																echo "Absent";
															}else{
																if($donnees->$jm==0){
																	echo "Absent";	
																}else{
																	$rqtReserv = $connexion->prepare("SELECT heure, duree FROM ".$nomE."_reserv WHERE date = '".$dateF."' AND employe = '".$emp2[$i]."' ORDER BY heure ASC");
																	$rqtReserv->execute();
																	$j = 0;
																	if($donnees->$jm==0){
																		echo "Absent le matin "	;
																	}
																	while($donnees3=$rqtReserv->fetch(PDO::FETCH_OBJ)){
																		$resDebut = new DateTime($donnees3->heure);
																		$resDebut2 = new DateTime($donnees3->heure);
																		$b = new DateInterval('PT'.$donnees3->duree.'M');
																		$resFin = $resDebut->add($b);
																		$deb =  $resDebut2->format('H:i:s');
																		$fin =  $resFin->format('H:i:s');
																		if(!isset($tab)){
																			$tab[0][0] = $deb;
																			$tab[0][1] = $fin;
																		}else{
																			for($k = 0 ; $k < sizeof($tab) ; $k++){
																				$tab[$k++][0]=$deb;
																				$tab[$k++][1]=$fin;
																			}
																		}
																		$j++;
																			
																		for($k = 0 ; $k < sizeof($tab) ; $k++){
																			echo $tab[$k][0]."-".$tab[$k][1]." / ";
																			$k++;
																		}
																		unset($tab);
																	}
																	echo " Absent l'après-midi"	;
																}
															}
														}else if($donnees2->dateFin == $dateF){
															if($donnees2->demiJourFin==1){
																echo "Absent";
															}else{
																if($donnees->$ja==0){
																	echo "Absent";
																}else{
																	$rqtReserv = $connexion->prepare("SELECT heure, duree FROM ".$nomE."_reserv WHERE date = '".$dateF."' AND employe = '".$emp2[$i]."' ORDER BY heure ASC");
																	$rqtReserv->execute();
																	$j = 0;
																	echo "Absent le matin "	;
																	while($donnees3=$rqtReserv->fetch(PDO::FETCH_OBJ)){
																		$resDebut = new DateTime($donnees3->heure);
																		$resDebut2 = new DateTime($donnees3->heure);
																		$b = new DateInterval('PT'.$donnees3->duree.'M');
																		$resFin = $resDebut->add($b);
																		$deb =  $resDebut2->format('H:i:s');
																		$fin =  $resFin->format('H:i:s');
																		if(!isset($tab)){
																			$tab[0][0] = $deb;
																			$tab[0][1] = $fin;
																		}else{
																			for($k = 0 ; $k < sizeof($tab) ; $k++){
																				$tab[$k++][0]=$deb;
																				$tab[$k++][1]=$fin;
																			}
																		}
																		$j++;
																		for($k = 0 ; $k < sizeof($tab) ; $k++){
																			echo $tab[$k][0]."-".$tab[$k][1]." / ";
																			$k++;
																		}
																	unset($tab);
																	}
																	if($donnees->$ja==0){
																		echo " Absent l'après-midi"	;
																	}
																}
															}
														}else{
															echo "Absent";
														}
													}else{
														$rqtReserv = $connexion->prepare("SELECT heure, duree FROM ".$nomE."_reserv WHERE date = '".$dateF."' AND employe = '".$emp2[$i]."' ORDER BY heure ASC");
														$rqtReserv->execute();
														$j = 0;
														if($donnees->$jm==0){
															echo "Absent le matin"	;
														}
														while($donnees3=$rqtReserv->fetch(PDO::FETCH_OBJ)){
															$resDebut = new DateTime($donnees3->heure);
															$resDebut2 = new DateTime($donnees3->heure);
															$b = new DateInterval('PT'.$donnees3->duree.'M');
															$resFin = $resDebut->add($b);
															$deb =  $resDebut2->format('H:i:s');
															$fin =  $resFin->format('H:i:s');
															if(!isset($tab)){
																$tab[0][0] = $deb;
																$tab[0][1] = $fin;
															}else{
																for($k = 0 ; $k < sizeof($tab) ; $k++){
																	$tab[$k++][0]=$deb;
																	$tab[$k++][1]=$fin;
																}
															}
															$j++;
															for($k = 0 ; $k < sizeof($tab) ; $k++){
																echo $tab[$k][0]."-".$tab[$k][1]." / ";
																$k++;
															}
														unset($tab);
														}
														if($donnees->$ja==0){
															echo "Absent l'après-midi"	;
														}
													}
												}
											echo "</br>";
											$i++;
											}
									}else{
										echo "Fermé";
									}?>
									</li>
								</ul>
							</td>
							<?php if($w == 7):?>
								<tr></tr>
							<?php endif;?>
						<?php endforeach; ?>
						<?php if($end != 7): ?>
							<td colspan="<?php echo 7-$end; ?>" class="padding"></td>
						<?php endif; ?>
						</tr>
					</tbody>
				</table>
				</div>
			<?php endforeach; ?>
		</div>
		<form method="post" action="">
			Jour de la réservation : </br>
				<input type="date" name="daterdv" />
			</br></br>
			Heure de la réservation : </br>
				<input type="time" name="heurerdv" />
			</br></br>	
			<div align = "center" class="12u$">
			<input type="submit" name="continue" value="Réserver" />
			<input type="submit" name="annule" value="Annuler" />
			</div>
		</form>
							<?php } } } ?>
			</div>
		</div>
	</body>
</html>