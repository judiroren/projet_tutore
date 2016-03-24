<?php

	session_start();
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	if(!isset($_GET['nomEntreprise'])) {
		
	} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
								
	} else {
								
	if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
						
	} else {
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$nomAffichage = str_replace(' ', '_', $nomE);

	//permet de r�cuperer les infos de connexion
	$i = infosEntreprise();

	//Les informations doivent �tre correcte
	if( !empty($_POST['login']) && !empty($_POST['mdp']) ) {
		//r�cup�ration des infos de connexion des clients
		$j = logClient($_POST['login'], $_POST['mdp']);
		if($j!=null){
			if( $_POST['login'] == $j->login_client && $_POST['mdp'] == $j->mdp_client ) {
				$_SESSION["client"] = $j->id_client;
				$_SESSION["estConnecteClient"] = 1;
				$_SESSION["nomSession"] = $_GET['nomEntreprise'];
				
			}
		}
	}
	$ok = 0;
	if(isset($_POST['sanspaiement'])){
		if(isset($_SESSION['client'])){
			enregistreReserv($connexion, $_SESSION['prestListe'], $_SESSION['client'], $_SESSION['date'], $_SESSION['heure'], 0, $_SESSION['duree'], $_SESSION['prix'], $_SESSION["employeRes"]);
			$ok = 1;
		}
	}
	
	if(isset($_POST['avecpaiement'])){
		if(isset($_SESSION['client'])){
			enregistreReserv($connexion, $_SESSION['prestListe'], $_SESSION['client'], $_SESSION['date'], $_SESSION['heure'], 1, $_SESSION['duree'], $_SESSION['prix'], $_SESSION["employeRes"]);
			$ok = 2;
		}
	}
	if(isset($_POST['annule'])){
		header('Location: accueil_client.php?nomEntreprise='.$nomE);
		unset($_SESSION['prestListe']);
		unset($_SESSION['date']);
		unset($_SESSION['heure']);
		unset($_SESSION['duree']);
		unset($_SESSION['prix']);
	}
	if(isset($_POST['retour'])){
		header('Location: accueil_client.php?nomEntreprise='.$nomE);
	}
	if(isset($_POST['reserv'])){
		header('Location: reservation.php?nomEntreprise='.$nomE);
	}
	}
}
?>

<html>
	<head>
		<title>Portail de r�servation : Accueil BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
						
						<?php 
						if(!isset($_GET['nomEntreprise'])) {
		
						} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
													
						} else {
													
						//	if(isset($_SESSION["estConnecteClient"])) {
											
								if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
											
								} else {
						
							if($i->logoEntreprise !="") {
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
						?>
							<h1>
							<?php 
							
								echo $nomAffichage;
							?>
							</h1>
							<p>Page de gestion de l'entreprise</p>
							
							<?php 
							
							if(isset($_SESSION["estConnecteClient"])) {
								
							?>
								<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="profil.php?nomEntreprise=<?php echo $nomE ?>"> Acc�der � son profil </a></br>
								<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> R�server </a></br></br>
								<a href="destruct_session_client.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>
							</div>
							
							<?php
							
								} else {
							
							?>
						</div>
						<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
						<a href="inscription.php?nomEntreprise=<?php echo $nomE ?>"> S'inscrire </a></br>
						<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> R�server </a></br></br>
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
							
						<?php 
							} 
						} } //}
						?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">
							</br>
							<table>	
							<tr><td><h1>R�sum� de la r�servation : </h1></td></tr>
							<?php 
						//echo	$_SESSION["rst"];
							if(!isset($_GET['nomEntreprise'])) {
						
								echo "<h2>Le nom de l'entreprise doit �tre rajout� dans l'url � la suite sous la forme : ?nomEntreprise=nom.</h2>";
				
							} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
								
								echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donn�e</h2>";	
								
							} else {			
							
								//if(isset($_SESSION["estConnecteClient"])) {
								
									if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
										
										echo "<h2>Vous devez d'abord vous connectez sur le cot� client de cette entreprise </h2>";
								
									} else {
										
								if(isset($ok)){
									if($ok == 1){
										echo "Reservation sans paiement effectu�e";
									}
									if($ok == 2){
										echo "Reservation avec paiement effectu�e";
									}
								}
															
									$days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
									$months = array('Janvier', 'F�vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao�t', 'Septembre', 'Octobre', 'Novembre', 'D�cembre');
									$j = date('d', strtotime($_SESSION['date']));
									  $jn = $days[date('w', strtotime($_SESSION['date']))];
									  $m = $months[date('n', strtotime($_SESSION['date']))-1];
									  $a = date('Y', strtotime($_SESSION['date']));?>
							
							<tr><td>Jour de la r�servation : <?php echo $jn." ".$j." ".$m." ".$a." ";?></td></tr>
							
							<tr><td>	Heure de la r�servation : <?php echo $_SESSION['heure']."</br>";?></td></tr>
							
								<tr><td>Prestations choisies : </br>
								<?php 
								$prixtotal = 0;
								$dureetotale = 0;
								foreach ($_SESSION['prestListe'] as $val){
									$info = infosPrestation($val);
									echo $info->descriptif_presta." ( ".$info->duree." minutes, ".$info->cout." � ).</br>";
									$prixtotal = $prixtotal + $info->cout;
									$dureetotale = $dureetotale + $info->duree;
								}
								?></td></tr>
							<tr><td> Dur�e de la r�servation : <?php echo $dureetotale; $_SESSION['duree']=$dureetotale;?> minutes</td></tr>
							<tr><td> Prix total : <?php echo $prixtotal; $_SESSION['prix']=$prixtotal;?> � </td></tr>
							</table>
							<form method="post" action="">
							<?php
							if(isset($_SESSION["estConnecteClient"])) {
								if($ok==0){
								?>
								<input type="submit" name="sanspaiement" value="Confirmation" />
								<input type="submit" name="avecpaiement" value="Paiement" />
								<?php
								}else{
								?>
								<input type="submit" name="retour" value="Retour � l'accueil" />
								<input type="submit" name="reserv" value="Nouvelle r�servation" />
								<?php
								}
							} else {
								?>
								
								<A href="javascript:ouvre_popup('popupConnection.php?nomEntreprise=<?php echo $nomE ?>')">Attention : Veuillez vous connecter pour confirmer ou payer ! </A><br/>
								<SCRIPT language="javascript">
								function ouvre_popup(page) {
								window.open(page,"nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=600, height=400");
								}
								</SCRIPT></br>
								<p>Pas encore inscrit ?</p>
								<A href="javascript:ouvre_popup('popupInscription.php?nomEntreprise=<?php echo $nomE ?>')">Cliquer pour vous enregistrer.</A><br/>
								<SCRIPT language="javascript">
								function ouvre_popup(page) {
									window.open(page,"nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=600, height=400");
								}
								<?php
							}
							if($ok == 0){
							?>
							<input type="submit" name="annule" value="Annulation" />
							<?php }?>
							</form>
							
							<?php } } //} ?>
			</div>
		</div>
	</body>
</html>