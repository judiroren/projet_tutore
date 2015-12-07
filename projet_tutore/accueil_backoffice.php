<!DOCTYPE HTML>
<?php
try {
	$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" );
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}

$nomE=$_GET['nomEntreprise'];
$rqt = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$i = $rqt->fetch(PDO::FETCH_OBJ);
$planning = $connexion->query('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON code_employe = id_employe');
$reserva = $connexion->query('SELECT * FROM '.$nomE.'_reserv JOIN '.$nomE.'_employe ON employe = id_employe JOIN '.$nomE.'_client ON client = id_client JOIN '.$nomE.'_prestation ON presta = id_presta');



?>

<html>
	<head>
		<title>Portail de réservation : Accueil BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
						<?php if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
						} ?>
							<h1><?php echo $nomE?></h1>
							<p>Page de gestion de l'entreprise</p>
							<?php 
							if(!empty($_POST['login']) && !empty($_POST['mdp']) && $_POST['login']==$i->loginAdmin && $_POST['mdp']==$i->mdpAdmin ){
							?>
							
								<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
								<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
								<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
								<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
								<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>
							</div>
							<?php
							}else{
							
							?>
						</div>
						<form method="post" action="">
								<div class="row">
									<div class="6u 12u$(mobile)"><input type="text" name="login" placeholder="Login" /></div>
									</br></br></br>
									<div class="6u 12u$(mobile)"><input type="text" name="mdp" placeholder="Mot de passe" /></div>				
								</div>
								</br>
								<div align = "center" class="12u$">
									<input type="submit" value="Connection" />
								</div>
							</form>
							<?php } ?>

				</div>


			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">
							<h1>Page d'accueil back-office <br> Entreprise <?php echo $nomE;?></h1>
							<table>
									<tr><td rowspan="2"></td><td colspan="2">Lundi</td><td colspan="2">Mardi</td><td colspan="2">Mercredi</td><td colspan="2">Jeudi</td><td colspan="2">Vendredi</td><td colspan="2">Samedi</td></tr>
									<tr>
										<?php 
											$cpt = 0;
											while($cpt != 6){
												echo "<td>Matin</td><td>Après-Midi</td>";
												$cpt = $cpt + 1;
											}
										?>
									</tr>
									<?php 
										while($valeur = $planning->fetch(PDO::FETCH_OBJ)){
											$identite = $valeur->nom_employe ." ". $valeur->prenom_employe;
									?>
										<tr><td><?php echo $identite?></td><td><?php if($valeur->LundiM==1){echo "X";}?></td><td><?php if($valeur->LundiA==1){echo "X";}?></td><td><?php if($valeur->MardiM==1){echo "X";}?></td><td><?php if($valeur->MardiA==1){echo "X";}?></td><td><?php if($valeur->MercrediM==1){echo "X";}?></td><td><?php if($valeur->MercrediA==1){echo "X";}?></td><td><?php if($valeur->JeudiM==1){echo "X";}?></td><td><?php if($valeur->JeudiA==1){echo "X";}?></td><td><?php if($valeur->VendrediM==1){echo "X";}?></td><td><?php if($valeur->VendrediA==1){echo "X";}?></td><td><?php if($valeur->SamediM==1){echo "X";}?></td><td><?php if($valeur->SamediA==1){echo "X";}?></td></tr>
									<?php 
										}
									?>
								</table>
								
								<h1>Liste des réservations</h1>
								<table>
								<tr><td>Date </br>(année:mois:jour)</td><td>Heure</td><td>Employé</td><td>Client</td><td>Prestation</td><td>Déjà payé ?</td></tr>
								<?php 
									while($valeur2 = $reserva->fetch(PDO::FETCH_OBJ)){
										$idClient = $valeur2->nom_client ." ". $valeur2->prenom_client;
										$idEmploye = $valeur2->nom_employe ." ". $valeur2->prenom_employe;
								?>
									<tr><td><?php echo $valeur2->date;?></td><td><?php echo $valeur2->heure;?></td><td><?php echo $idEmploye?></td><td><?php echo $idClient;?></td><td><?php echo $valeur2->descriptif_presta;?></td><td><?php if($valeur2->paye==1){echo "oui";}else{echo "non";}?></td></tr>
								<?php 
									}
								?>
								</table>
						</div>

						
			</div>

	</body>
</html>