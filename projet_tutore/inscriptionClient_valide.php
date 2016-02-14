<!DOCTYPE HTML>
<?php
	session_start();
	require "bd.inc.php";
	require "frontOffice.inc.php";
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
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

				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">

							<h1>Inscription d'un client sur le portail de l'entreprise : Résumé</h1></br>
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
						</div>
			</div>

	</body>
</html>	