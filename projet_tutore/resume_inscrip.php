<!DOCTYPE HTML>
<?php
require "fonctions.inc.php";
$connexion = connect();

$tabconfig = parse_ini_file("config.ini");
$chemin = $tabconfig["chemin"];

			$temploye = $_POST['entreprise']."_employe";
			$tprestation = $_POST['entreprise']."_prestation";
			$tclient = $_POST['entreprise']."_client";
			$treserv = $_POST['entreprise']."_reserv";
			$tplanning = $_POST['entreprise']."_planning";
			$tabsence = $_POST['entreprise']."_absence";
			if(!empty($_POST['entreprise']) && !empty($_POST['mdp']) && !empty($_POST['mail']) && !empty($_POST['login']) && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
				$mdpHash = md5($_POST['mdp']);
				$connexion->exec("INSERT INTO entreprise(nomEntreprise, mailEntreprise, loginAdmin, mdpAdmin) VALUES ('".$_POST['entreprise']."', '".$_POST['mail']."', '".$_POST['login']."', '".$mdpHash."')");
			   try{
					$connexion->exec("CREATE TABLE ".$temploye." ( id_employe CHAR(8) PRIMARY KEY, nom_employe VARCHAR(40), prenom_employe VARCHAR(50), competenceA CHAR(8), competenceB CHAR(8), competenceC CHAR(8), telephone_emp CHAR(10), adresse_emp VARCHAR(200), mail_emp VARCHAR(50))");
					$connexion->exec("CREATE TABLE ".$tprestation." ( id_presta CHAR(8) PRIMARY KEY, descriptif_presta TEXT, prix DECIMAL(5,2), paypal BOOLEAN, duree INT)");
					$connexion->exec("CREATE TABLE ".$tclient." ( id_client CHAR(8) PRIMARY KEY, nom_client VARCHAR(40), prenom_client VARCHAR(50), mail VARCHAR(50), login_client VARCHAR(30), mdp_client VARCHAR(30))");
					$connexion->exec("CREATE TABLE ".$treserv." ( id_reserv CHAR(8) PRIMARY KEY, client CHAR(8), employe CHAR(8), presta CHAR(8), paye BOOLEAN, date DATE, heure TIME)");
					$connexion->exec("CREATE TABLE ".$tplanning." (
	  									`id_agenda` char(8) PRIMARY KEY,
										`code_employe` char(8) NOT NULL,
	 									`LundiM` BOOLEAN, `LundiA` BOOLEAN,
	  									`MardiM` BOOLEAN, `MardiA` BOOLEAN,
	  									`MercrediM` BOOLEAN, `MercrediA` BOOLEAN,
	  									`JeudiM` BOOLEAN, `JeudiA` BOOLEAN,
	  									`VendrediM` BOOLEAN, `VendrediA` BOOLEAN,
	  									`SamediM` BOOLEAN, `SamediA` BOOLEAN)");
					$connexion->exec("CREATE TABLE ".$tabsence." (
	  									`id_absence` char(8) PRIMARY KEY,
										`code_employe` char(8) NOT NULL,
	 									`motif` varchar(100),
	  									`dateDebut` date,
	  									`dateFin` date,
	  									`absenceFini` BOOLEAN)");
		
			   } catch (Exception $e) {
				echo $e->getMessage();
			   }
			}

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
							<?php 
							if(empty($_POST['entreprise']) || empty($_POST['mdp']) || empty($_POST['mail']) || empty($_POST['login'])){
								echo "<p> Création impossible : Veuillez remplir tout les champs du formulaire ! ";
								echo "</br><a href='page_proprietaire.php'>Retour </a></p>";
							}else if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
								echo "<p> Création impossible : l'adresse email n'est pas valide ! ";
								echo "</br><a href='page_proprietaire.php'>Retour </a></p>";
							}else{
							?>
							
							<p>Ajout des informations de l'entreprise à la table 'entreprise'</p>
							<p>Tables de l'entreprise <?php echo $_POST['entreprise']?>créés : employés, client, absences, prestations, réservations et planning</p>
							<p>Login administrateur : <?php echo $_POST['login']?></p>
							<p>Mot de passe administrateur : <?php echo $_POST['mdp']?></p>
							<p>Adresse mail de l'entreprise : <?php echo $_POST['mail']?></p>
							<p>Lien permettant l'accès à l'accueil côté entreprise :  </br>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $_POST['entreprise'] ?>"> "http://<?php echo $chemin?>/accueil_backoffice.php?nomEntreprise=<?php echo $_POST['entreprise'] ?>" </a></p></br>
							<p>Lien permettant l'accès à l'accueil côté client :  </br>
							<a href="accueil_client.php?nomEntreprise=<?php echo $_POST['entreprise'] ?>"> "http://<?php echo $chemin?>/accueil_client.php?nomEntreprise=<?php echo $_POST['entreprise'] ?>" </a></p></br>
							<?php
							} 
							?>
						</div>

						
			</div>

	</body>
</html>	