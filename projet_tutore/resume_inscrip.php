<!DOCTYPE HTML>
<?php
	
	require "fonctions.inc.php";
	require "ajout.inc.php";
	require "bd.inc.php";
	
	$connexion = connect();
			
			if( $_POST['entreprise'] == null || $_POST['mail'] == null || $_POST['login'] == null || $_POST['mdp'] == null ) {
				
				echo "<div class='alert alert-dismissable alert-danger'>
				<p>Tous les champs doivent être remplis. Vous allez être redirigé vers la page propriétaire.</p>
				<meta http-equiv='refresh' content='5; URL=page_proprietaire.php'>
				</div>";
				
			} else {
			
			$entreprise = $_POST['entreprise'];
			$entreprise = str_replace(' ', '_', $entreprise);
			$mail = $_POST['mail'];
			$login = $_POST['login'];
			$creneau = $_POST['creneau'];
			
			creerEntreprise($connexion, $entreprise, $mail, $login, $_POST['mdp'], $creneau);
			
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
			$tcompetence = $_POST['entreprise']."_competence";
			$tableComp = str_replace(' ', '_', $tcompetence);
			$tprestresv = $_POST['entreprise']."_prestresv";
			$tablePresRes = str_replace(' ', '_', $tprestresv);
			$tcategorie = $_POST['entreprise']."_categorie";
			$tableCat = str_replace(' ', '_', $tcategorie);
			
				ajoutEntreprise($connexion, $tableEmp, $tablePrest, $tableClient, $tableReserv, $tablePlan, $tableAbs, $tableComp, $tablePresRes, $tableCat);
				$nom = $_POST['entreprise'];
				$nomE = str_replace(' ', '_', $nom);
					
	

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
<?php echo $_SESSION['t'];?>
							<h1>Inscription d'une entreprise sur le portail : Résumé</h1>
							<p>Ajout des informations de l'entreprise à la table 'entreprise'</p>
							<p>Tables de l'entreprise 
							<?php 
								echo $_POST['entreprise'];
							?>
							créés : employés, client, absences, prestations, réservations, planning, compétences, liens prestation-réservation</p>
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
							<p>Type de créneau de réservation : 
							<?php 
							echo $_POST['creneau']=1?"Libre":"Fixe";
							?>
							</p>
							<p>Lien permettant l'accès à l'accueil côté entreprise :  </br>
							<a href="accueil_backoffice.php?nomEntreprise=
							<?php 
							
								echo $nomE; 
							?> 
							"> "accueil_backoffice.php?nomEntreprise=
							<?php 
								echo $_POST['entreprise']; 
							?>
								" </a></p></br>
							<p>Lien permettant l'accès à l'accueil côté client :  </br>
							<a href="accueil_client.php?nomEntreprise=
							<?php 
								
								echo $nomE; 
							?>
							"> "accueil_client.php?nomEntreprise=
							<?php 
								echo $_POST['entreprise']; 
							?>
							" </a></p></br>
						</div>
			</div>
			<?php
			}
			?>

	</body>
</html>	