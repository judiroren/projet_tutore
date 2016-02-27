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
		echo "<p>Le nom de l'entreprise doit �tre renseign� dans l'url sous la forme ?nomEntreprise=nom.</p>";
	}
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donn�e</p>";
		
	} else {
		
	$_SESSION["nomE"] = $_GET['nomEntreprise'];	
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$nomE = str_replace(' ', '_', $nomE);

	//permet de r�cuperer les infos de connexion
	$i = infosEntreprise();

	//Le mot de passe doit �tre renseigner
	if(isset($_POST['mdp'])) {
		
		//$mdp = md5($_POST['mdp']);
		$mdp = $_POST['mdp'];
	} 
	
	//Les informations doivent �tre correcte
	if( isset($_POST['login']) && isset($_POST['mdp']) ) {
		//r�cup�ration des infos de connexion des clients
		$j = logClient($_POST['login'], $_POST['mdp']);
		if( $_POST['login'] == $j->login_client && $mdp == $j->mdp_client ) {
			$_SESSION["client"] = $j->id_client;
			$_SESSION["estConnecte"] = 1;
			$_SESSION["nomSession"] = $_GET['nomEntreprise'];
			
		}
	}

	if(isset($_POST['sanspaiement'])){
		if(isset($_SESSION['client'])){
			enregistreReserv($connexion, $_SESSION['prestListe'], $_SESSION['client'], $_SESSION['date'], $_SESSION['heure'], 0, $_SESSION['duree'], $_SESSION['prix']);
		}
	}
	
	if(isset($_POST['avecpaiement'])){
		if(isset($_SESSION['client'])){
			enregistreReserv($connexion, $_SESSION['prestListe'], $_SESSION['client'], $_SESSION['date'], $_SESSION['heure'], 1, $_SESSION['duree'], $_SESSION['prix']);
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
							
							if(isset($_SESSION["estConnecte"])) {
								
							?>
								<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="profil.php?nomEntreprise=<?php echo $nomE ?>"> Acc�der � son profil </a></br>
								<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> R�server </a></br></br>
								<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>
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
							
							<?php } ?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">
	
							<h1>R�sum� de la r�servation : </h1>
							<p>
								Jour de la r�servation : <?php echo $_SESSION['date'];?>
							</p>
							<p>
								Heure de la r�servation : <?php echo $_SESSION['heure'];?>
							</p>

							<p>
								Prestations choisies : </br>
								<?php 
								$prixtotal = 0;
								$dureetotale = 0;
								foreach ($_SESSION['prestListe'] as $val){
									$info = infosPrestation($val);
									$info = $info->fetch(PDO::FETCH_OBJ);
									echo $info->descriptif_presta." ( ".$info->duree." minutes, ".$info->prix." � ).</br>";
									$prixtotal = $prixtotal + $info->prix;
									$dureetotale = $dureetotale + $info->duree;
								}
								?>
							</p>
							<p> Dur�e de la r�servation : <?php echo $dureetotale; $_SESSION['duree']=$dureetotale;?> minutes</p>
							<p> Prix total : <?php echo $prixtotal; $_SESSION['prix']=$prixtotal;?> �</p>
							<form method="post" action="">
							<input type="submit" name="sanspaiement" value="Confirmation" />
							<input type="submit" name="avecpaiement" value="Confirmation" />
							</form>
							
							<?php } ?>
			</div>
		</div>
	</body>
</html>