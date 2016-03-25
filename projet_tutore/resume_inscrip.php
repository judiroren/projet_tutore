<!DOCTYPE HTML>
<?php
	session_start();
	require "fonctions.inc.php";
	require "ajout.inc.php";
	require "bd.inc.php";
	
	$connexion = connect();
			
			$entreprise = $_SESSION["entreprise"];
			$entreprise = str_replace(' ', '_', $entreprise);
			$mail = $_SESSION["mail"];
			$login = $_SESSION["login"];
			$creneau = $_SESSION["creneau"];
			
			creerEntreprise($connexion, $entreprise, $mail, $login, $_SESSION["mdp"], $creneau);
			
			$temploye = $entreprise."_employe";
			$tableEmp = str_replace(' ', '_', $temploye);
			$tprestation = $entreprise."_prestation";
			$tablePrest = str_replace(' ', '_', $tprestation);
			$tclient = $entreprise."_client";
			$tableClient = str_replace(' ', '_', $tclient);
			$treserv = $entreprise."_reserv";
			$tableReserv = str_replace(' ', '_', $treserv);
			$tplanning = $entreprise."_planning";
			$tablePlan = str_replace(' ', '_', $tplanning);
			$tabsence = $entreprise."_absence";
			$tableAbs = str_replace(' ', '_', $tabsence);
			$tcompetence = $entreprise."_competence";
			$tableComp = str_replace(' ', '_', $tcompetence);
			$tprestresv = $entreprise."_prestresv";
			$tablePresRes = str_replace(' ', '_', $tprestresv);
			$tcategorie = $entreprise."_categorie";
			$tableCat = str_replace(' ', '_', $tcategorie);
			
				ajoutEntreprise($connexion, $tableEmp, $tablePrest, $tableClient, $tableReserv, $tablePlan, $tableAbs, $tableComp, $tablePresRes, $tableCat);
				
				$nomE = str_replace(' ', '_', $entreprise);
			unset($_SESSION["entreprise"]);
			unset($_SESSION["mail"]);
			unset($_SESSION["creneau"]);
			unset($_SESSION["login"]);
			unset($_SESSION["mdp"]);

?>
<html>
	<head>
		<title>Portail de r�servation : Propri�taire</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							
							<h1> Portail de r�servation</h1>
							<p>Page propri�taire : r�sum� inscription</p>
						</div>

				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">
							<h1>Inscription d'une entreprise sur le portail : R�sum�</h1>
							<p>Ajout des informations de l'entreprise � la table 'entreprise'</p>
							<p>Tables de l'entreprise 
							<?php 
								echo $entreprise;
							?>
							cr��s : employ�s, client, absences, prestations, r�servations, planning, comp�tences, liens prestation-r�servation</p>
							<p>Login administrateur : 
							<?php 
								echo $login;
							?>
							</p>
							<p>Mot de passe administrateur : 
							<?php 
							echo $_SESSION["mdp"];
							?>
							</p>
							<p>Adresse mail de l'entreprise : 
							<?php 
							echo $mail;
							?>
							</p>
							<p>Type de cr�neau de r�servation : 
							<?php 
							echo $creneau=1?"Libre":"Fixe";
							?>
							</p>
							<p>Lien permettant l'acc�s � l'accueil c�t� entreprise :  </br>
							<a href="accueil_backoffice.php?nomEntreprise=
							<?php 
							
								echo $nomE; 
							?> 
							"> "accueil_backoffice.php?nomEntreprise=
							<?php 
								echo $entreprise; 
							?>
								" </a></p></br>
							<p>Lien permettant l'acc�s � l'accueil c�t� client :  </br>
							<a href="accueil_client.php?nomEntreprise=
							<?php 
								
								echo $nomE; 
							?>
							"> "accueil_client.php?nomEntreprise=
							<?php 
								echo $entreprise; 
							?>
							" </a></p></br>
						</div>
			</div>


	</body>
</html>	