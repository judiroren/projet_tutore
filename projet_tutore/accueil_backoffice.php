<!DOCTYPE HTML>
<?php

	session_start();
	
	try {
		
		if(isset($_GET['nomEntreprise'])) {
			$_SESSION["nomE"] = $_GET['nomEntreprise'];
		} else {
			$_SESSION["nomE"] = "Nom de l'entreprise non spécifiée";
		}
	} catch(Exception $e){
		
	}

	require "fonctions.inc.php";
	require "bd.inc.php";
	
	
	if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else {
		
		$_SESSION["nomE"] = $_GET['nomEntreprise'];	
		
		$connexion = connect();
		$nomE = $_GET['nomEntreprise'];
		//$nomE = str_replace(' ', '_', $nomE);

		//permet de récuperer les infos de connexion
		$i = infosEntreprise();

		//Le mot de passe doit être renseigner
		if(isset($_POST['mdp'])) {
			
			//$mdp = md5($_POST['mdp']);
			$mdp = $_POST['mdp'];
		} 
		
		//Les informations doivent être correcte
		if( isset($_POST['login']) && isset($_POST['mdp']) ) {
			
			if( $_POST['login'] == $i->loginAdmin && $mdp == $i->mdpAdmin ) {
				
				$_SESSION["estConnecte"] = 1;
				$_SESSION["nomSession"] = $_GET['nomEntreprise'];
				
			}
		}

		$planning = planningEnt();
										
		$reserva = reservationsEnt();
										
		$absences = abscencesEnt();
		
	}

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
						
						<?php 
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
								} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
								} else {
									
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
							
								<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
								<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
								<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
								<a href="modif_categorie.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des catégories </a></br>
								<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
								<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>
							</div>
							
							<?php
							
								} else {
							
							?>
						</div>
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
								}
							?>

				</div>


			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">
							<h1>Page d'accueil back-office <br> Entreprise 
							<?php 
								
								
								if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
									
									echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
								
								} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
									echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
		
								} else {
									
									echo $nomE;
								}	
									
							?></h1>
							
							<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
								
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		
							} else {
							
								if(isset($_SESSION["estConnecte"])) {
								
							?>
							
							<h3>Planning : </h3>
							
							<?php
							
								if($planning->rowCount()==0) { 
									echo "Pas de planning à afficher.";
								} else { 
							?>
							
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
											$id_employe = $valeur->code_employe;
											$identite = $valeur->nom_employe ." ". $valeur->prenom_employe;
											$tab = absence($nomE, $id_employe, $connexion);
											if($tab==null){
												?>
												<tr><td>
												<?php 
													echo $identite
												?>
												</td><td>
												<?php 
													if($valeur->LundiM==1) {
															echo "X";
													}
													?>
													</td><td>
													<?php 
														if($valeur->LundiA==1)	{
															echo "X";
														}
													?>
													</td><td>
													<?php 
														if($valeur->MardiM==1) { 
															echo "X";
														}
													?>
													</td><td>
													<?php 
														if($valeur->MardiA==1) {
															echo "X";
													}
													?>
													</td><td>
													<?php 
														if($valeur->MercrediM==1) {
															echo "X";
															}
													?>
													</td><td>
													<?php 
														if($valeur->MercrediA==1) {
															echo "X";
														}
													?>
													</td><td>
													<?php 
														if($valeur->JeudiM==1) {
															echo "X";
														}
													?>
													</td><td>
													<?php 
														if($valeur->JeudiA==1) {
															echo "X";
														}
													?>
													</td><td>
													<?php 
														if($valeur->VendrediM==1) {
															echo "X";
														}
													?>
													</td><td>
													<?php 
													if($valeur->VendrediA==1) {
														echo "X";
														}
													?>
													</td><td>
													<?php 
														if($valeur->SamediM==1) {
															echo "X";
														}
													?>
													</td><td>
													<?php 
														if($valeur->SamediA==1) {
															echo "X";
														}
													?>
													</td></tr>
												<?php
											}else{
												?>
												<tr><td>
												<?php 
													echo $identite
												?>
												</td><td>
												<?php 
													echo $tab[0][0];
												?>
												</td><td>
												<?php 
													echo $tab[0][1];
												?>
													</td><td>
												<?php 
													echo $tab[1][0];
												?>
												</td><td>
												<?php 
													echo $tab[1][1];
												?>
													</td><td>
												<?php 
													echo $tab[2][0];
												?>
												</td><td>
												<?php 
													echo $tab[2][1];
												?>
												</td><td>
												<?php 
													echo $tab[3][0];
												?>
												</td><td>
												<?php 
													echo $tab[3][1];
												?>
												</td><td>
												<?php 
													echo $tab[4][0];
												?>
												</td><td>
												<?php 
													echo $tab[4][1];
												?>
												</td><td>
												<?php 
													echo $tab[5][0];
												?>
												</td><td>
												<?php 
													echo $tab[5][1];?></td></tr>
												<?php 											
											}
									
										}
								}
									?>
								</table>
								
								<h3>Liste des réservations : </h3>
								<?php if($reserva->rowCount()==0){ echo "Pas de réservation en attente."; } else { ?>
								<table>
								<tr><td>Date </br>(année:mois:jour)</td><td>Heure</td><td>Employé</td><td>Client</td><td>Déjà payé ?</td></tr>
								<?php 
									while($valeur2 = $reserva->fetch(PDO::FETCH_OBJ)){
										$idClient = $valeur2->nom_client ." ". $valeur2->prenom_client;
										$idEmploye = $valeur2->nom_employe ." ". $valeur2->prenom_employe;
								?>
									<tr><td>
									<?php 
										echo $valeur2->date;
									?>
										</td><td>
									<?php 
										echo $valeur2->heure;
									?>
										</td><td>
									<?php 
										echo $idEmploye
									?>
									</td><td>
									<?php 
										echo $idClient;
									?>
									</td><td>
									<?php 
									if($valeur2->paye==1) {
										echo "oui";
									} else {
										echo "non";
									}
									?>
								</td></tr>
								<?php 
									}
								?>
								</table>
								<?php } ?>
								
								<h3>Liste des absences : </h3>
								<?php 
									if($absences->rowCount()==0) { 
										echo "Pas d'absences d'enregistrée.";
									} else { 
								?>
								<table>
								<tr><td> Employé </td><td>Date de début du congé</td><td>Date de fin du congé</td><td> Motif </td></tr>
								<?php 
									while($valeur3 = $absences->fetch(PDO::FETCH_OBJ)) {
										$idEmploye = $valeur3->nom_employe ." ". $valeur3->prenom_employe;
								?>
									<tr><td> 
									<?php 
										echo $idEmploye;
									?> 
									</td><td>
									<?php 
										if($valeur3->demiJourDebut==0) {
											echo $valeur3->dateDebut ." : matin";
										} else {
											echo $valeur3->dateDebut ." : après-midi";
										}
									?>
									</td><td>
									<?php 
										if($valeur3->demiJourFin==0) {
											echo $valeur3->dateFin ." : matin";
										} else {
											echo $valeur3->dateFin ." : après-midi";
										}
									?>
									</td><td>
									<?php 
										echo $valeur3->motif;
									?>
									</td></tr>
								<?php 
									}
								?>
								</table>
								<?php 
									} 
									}
								}
									
								?>
								
								
						</div>	
			</div>
	</body>
</html>