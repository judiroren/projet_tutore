<!DOCTYPE HTML>
<?php
	try {
			$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" ); 	
			$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}
		
			$temploye = $_POST['entreprise']."_employe";
			$tprestation = $_POST['entreprise']."_prestation";
			$tclient = $_POST['entreprise']."_client";
			$treserv = $_POST['entreprise']."_reserv";
			$tplanning = $_POST['entreprise']."_planning";
	
			$connexion->exec("INSERT INTO entreprise(nomEntreprise, mailEntreprise, loginAdmin, mdpAdmin) VALUES ('".$_POST['entreprise']."', '".$_POST['mail']."', '".$_POST['login']."', '".$_POST['mdp']."')");
		   try{
				$connexion->exec("CREATE TABLE ".$temploye." ( id_employe CHAR(8) PRIMARY KEY, nom_employe VARCHAR(40), prenom_employe VARCHAR(50), competenceA CHAR(8), competenceB CHAR(8), competenceC CHAR(8), absent BOOLEAN)");
				$connexion->exec("CREATE TABLE ".$tprestation." ( id_presta CHAR(8) PRIMARY KEY, descriptif_presta TEXT, prix DECIMAL(5,2), paypal BOOLEAN, duree INT)");
				$connexion->exec("CREATE TABLE ".$tclient." ( id_client CHAR(8) PRIMARY KEY, nom_client VARCHAR(40), prenom_client VARCHAR(50), mail VARCHAR(50), login_client VARCHAR(30), mdp_client VARCHAR(30))");
				$connexion->exec("CREATE TABLE ".$treserv." ( id_reserv CHAR(8) PRIMARY KEY, client CHAR(8), employe CHAR(8), presta CHAR(8), paye BOOLEAN, date DATE, heure TIME)");
				$connexion->exec("CREATE TABLE ".$tplanning." (
  									`code_employe` char(8) NOT NULL,
  									`id_planning` varchar(10) NOT NULL,
 									`LundiM` BOOLEAN, `LundiA` BOOLEAN,
  									`MardiM` BOOLEAN, `MardiA` BOOLEAN,
  									`MercrediM` BOOLEAN, `MercrediA` BOOLEAN,
  									`JeudiM` BOOLEAN, `JeudiA` BOOLEAN,
  									`VendrediM` BOOLEAN, `VendrediA` BOOLEAN,
  									`SamediM` BOOLEAN, `SamediA` BOOLEAN)");
				$connexion->exec("CREATE TABLE IF NOT EXISTS `absence` (
  									'id_absence' char(8) NOT NULL,
									`code_employe` char(8) NOT NULL,
 									`motif` varchar(100) NOT NULL,
  									`dateDébut` date NOT NULL,
  									`dateFin` date NOT NULL,
  									`absenceFini` tinyint(1) NOT NULL,
  									PRIMARY KEY (`id_absence`)");
	
		   } catch (Exception $e) {
			echo $e->getMessage();
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

							<p> Tables de l'entreprise <?php echo $_POST['entreprise'];?> créé </p>
								
						</div>

						
			</div>

	</body>
</html>	