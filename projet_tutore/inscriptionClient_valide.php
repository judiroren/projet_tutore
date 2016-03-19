<!DOCTYPE HTML>
<?php
	session_start();
	require "bd.inc.php";
	require "frontOffice.inc.php";
	
	if(!isset($_GET['nomEntreprise'])) {
		
	} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
		
	} else if(!isset($_POST['nomClient']) && !isset($_POST['prenomClient']) && !isset($_POST['mailClient']) 
					&& !isset($_POST['loginClient']) && !isset($_POST['mdpClient']) ){
						
	} else {					
	
		$connexion = connect();
		$nomE = $_GET['nomEntreprise'];
		$nomAffichage = str_replace(' ', '_', $nomE);
		$i = infosEntreprise();
		
		$listeCli = listeClient();
		
		$ajoutClient = "oui";
		
		$code = code($nomE."_client", 'id_client');
		
		$id = $code;	
		$nomClient = $_POST['nomClient'];
		$prenomClient = $_POST['prenomClient'];
		$mail = $_POST['mailClient'];
		$login = $_POST['loginClient'];
		//$mdpHash = md5($_POST['mdp']);
		$mdp = $_POST['mdpClient'];
				
		//faire fonction ajouter client
		ajoutClient($connexion, $id, $nomClient, $prenomClient, $mail, $login, $mdp, $nomE);		

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
	
	}
?>
<html>
	<head>
		<title>Portail de réservation : Inscription d'un client auprès d'une entreprise</title>
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
								
						} else if(isset($_SESSION["estConnecteClient"])) {
								
								if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								}	
								
						} else if(!isset($_POST['nomClient']) && !isset($_POST['prenomClient']) && !isset($_POST['mailClient']) 
										&& !isset($_POST['loginClient']) && !isset($_POST['mdpClient']) ){
						
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
							
						</div>
						<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
						<a href="inscription.php?nomEntreprise=<?php echo $nomE ?>"> S'inscrire </a></br>
						<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> Réserver </a></br></br>
						<form method="post" action="accueil_client.php?nomEntreprise=<?php echo $nomE;?>">
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
						?>

				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">

							<h1>Inscription d'un client sur le portail de l'entreprise : Résumé</h1></br>
							
							<?php
							
							if(!isset($_GET['nomEntreprise'])) {
						
								echo "<h2>Le nom de l'entreprise doit être rajouté dans l'url à la suite sous la forme : ?nomEntreprise=nom.</h2>";
				
							} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
								
								echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</h2>";
								
							} else if(isset($_SESSION["estConnecteClient"])) {
								
									if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
										
										echo "<h2>Vous devez d'abord vous connectez sur le coté client de cette entreprise </h2>";
								
									}	
								
							} else if(!isset($_POST['nomClient']) && !isset($_POST['prenomClient']) && !isset($_POST['mailClient']) 
										&& !isset($_POST['loginClient']) && !isset($_POST['mdpClient']) ){
											
										echo "<h2>Vous devez d'abord renseigner tous les champs !</h2>";
						
							} else {	
								
							?>	
							
							<p>Nom du client : 
							<?php 
								echo $_POST['nomClient'];
							?>
							</p>
							<p>Prénom du client : 
							<?php 
								echo $_POST['prenomClient'];
							?>
							</p>
							<p>Adresse mail du client : 
							<?php 
							echo $_POST['mailClient'];
							?>
							<p>Login du client : 
							<?php 
								echo $_POST['loginClient'];
							?>
							</p>
							<p>Mot de passe du client : 
							<?php 
							echo $_POST['mdpClient'];
							?>
							</p>
							
							</br>
							
							<?php } ?>
						</div>
			</div>

	</body>
</html>	