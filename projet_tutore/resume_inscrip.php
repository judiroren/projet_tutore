<!DOCTYPE HTML>
<?php
	session_start();
	
	require "fonctions.inc.php";
	require "ajout.inc.php";
	require "bd.inc.php";
	
	$connexion = connect();
		
			/** $temploye = $_POST['entreprise']."_employe";
			$tprestation = $_POST['entreprise']."_prestation";
			$tclient = $_POST['entreprise']."_client";
			$treserv = $_POST['entreprise']."_reserv";
			$tplanning = $_POST['entreprise']."_planning";
			$tabsence = $_POST['entreprise']."_absence"; */
			
			$entreprise = $_POST['entreprise'];
			$entreprise = str_replace(' ', '_', $entreprise);
			$mail = $_POST['mail'];
			$login = $_POST['login'];
			//$mdpHash = md5($_POST['mdp']);
			$mdpHash = $_POST['mdp'];
			
			creerEntreprise($connexion, $entreprise, $mail, $login, $mdpHash);
			
			$temploye = $_POST['entreprise']."_employe";
			$tableEmp = str_replace(' ', '_', $temploye);
			$tprestation = $_POST['entreprise']."_prestation";
			$tablePrest = str_replace(' ', '_', $tprestation);
			$tclient = $_POST['entreprise']."_client";
			$tableClient = str_replace(' ', '_', $tclient);
			$treserv = $_POST['entreprise']."_reserv";
			$tableReserv = str_replace(' ', '_', $treserv);
			$tplanning = $_POST['entreprise']."_planning";
			$tablePlan = str_replace(' ', '_', $tplanning);
			$tabsence = $_POST['entreprise']."_absence";
			$tableAbs = str_replace(' ', '_', $tabsence);
			
			//try{
			   
				//ajoutEntreprise($connexion, $temploye, $tprestation, $tclient, $treserv, $tplanning, $tabsence);
				ajoutEntreprise($connexion, $tableEmp, $tablePrest, $tableClient, $tableReserv, $tablePlan, $tableAbs);
	
		  // } catch (Exception $e) {
			   
			//echo $e->getMessage();
		  // }

?>
<html>
	<head>
		<title>Portail de réservation : Propriétaire</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							
							<h1> Portail de réservation</h1>
							<p>Page propriétaire : résumé inscription</p>
						</div>

				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">

							<h1>Inscription d'une entreprise sur le portail : Résumé</h1>
							<p>Ajout des informations de l'entreprise à la table 'entreprise'</p>
							<p>Tables de l'entreprise 
							<?php 
								echo $_POST['entreprise'];
							?>
							créés : employés, client, absences, prestations, réservations et planning</p>
							<p>Login administrateur : 
							<?php 
								echo $_POST['login'];
							?>
							</p>
							<p>Mot de passe administrateur : 
							<?php 
							echo $_POST['mdp'];
							?>
							</p>
							<p>Adresse mail de l'entreprise : 
							<?php 
							echo $_POST['mail'];
							?>
							</p>
							<p>Lien permettant l'accès à l'accueil côté entreprise :  </br>
							<a href="accueil_backoffice.php?nomEntreprise=
							<?php 
								echo $_POST['entreprise']; 
							?> 
							"> "http://localhost/projet_tutore/projet_tutore/accueil_backoffice.php?nomEntreprise=
							<?php 
								echo $_POST['entreprise']; 
							?>
								" </a></p></br>
							<p>Lien permettant l'accès à l'accueil côté client :  </br>
							<a href="accueil_client.php?nomEntreprise=
							<?php 
								echo $_POST['entreprise']; 
							?>
							"> "http://localhost/projet_tutore/projet_tutore/accueil_client.php?nomEntreprise=
							<?php 
								echo $_POST['entreprise']; 
							?>
							" </a></p></br>
						</div>
			</div>

	</body>
</html>	