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
	require "ajout.inc.php";
	
	$connexion = connect();
	$nomE = $_SESSION["nomE"];
	
	if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
	} else if (!isset($_GET['id_absence'])) {
	
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {	
	
	if(isset($_POST['modif'])){
		
		modifierAbsence($connexion, $_GET['id_absence'], $_POST['motif'], $_POST['debut'], $_POST['fin'], 
								$_POST['demiDebut'], $_POST['demiFin']);
		
	}
	
	$i = infosEntreprise();
	
	$idAbsence = $_GET['id_absence'];
	
	$rqtAbs = $connexion->prepare("SELECT * FROM ".$nomE."_absence WHERE id_absence = :idAbsence");
	$rqtAbs->execute(array(':idAbsence' => $idAbsence));
	$valAbs = $rqtAbs->fetch(PDO::FETCH_OBJ);
	
	if (isset($_POST['supprime'])) {
		if(isset($_POST['absence_modif'])){
			//Permet de supprimer l'absence
			supprimerAbsence($connexion, $_POST['absence_modif']);
				
			$supprimeOk = 1;
		}
	}
	if(isset($_POST['modifie'])){
		if(isset($_POST['absence_modif'])){
			header('Location: modif_absence.php?nomEntreprise='.$nomE.'&id_absence='.$_POST['absence_modif']);
		}
	}
	
	if(isset($_POST['creer'])){
		header('Location: gestion_absence.php?nomEntreprise='.$nomE);
	}
	
	}

?>

<html>
	<head>
		<title>Portail de réservation : BackOffice</title>
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
		
							} else if (!isset($_GET['id_absence'])) {
							
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
							} else {
							
							if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
							
							?>
							<h1><?php echo $nomE?></h1>
							<p>Gestion des absences</p>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
							<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
							<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
							<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
							<a href="modif_categorie.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des catégories </a></br>
							<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
							<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>
							
							<?php
							}
							?>

						</div>
						
				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
				
						<div class="container">
							
							<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
		
							} else if (!isset($_GET['id_absence'])) {
								
								echo "<p>Le nom de l'employé doit être renseigné dans l'url sous la forme &id_employe=id.</p>";
							
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {
							
							
							?>
							<form method="post" action="" class="formulaire">
								<div class="6u 12u$(mobile)"><select name="absence_modif">
								<?php 
								$listeAbs = $connexion->query("SELECT id_absence, code_employe, motif, dateDebut, dateFin, demiJourDebut, demiJourFin, nom_employe, prenom_employe 
								FROM ".$nomE."_absence JOIN ".$nomE."_employe ON code_employe = id_employe");
								while($donnees=$listeAbs->fetch(PDO::FETCH_OBJ)){
									if( ($donnees->demiJourDebut) == 0 && ($donnees->demiJourFin) == 0) {
										$absences = "du ".$donnees->dateDebut." matin au ".$donnees->dateFin." matin : ".$donnees->nom_employe." ".$donnees->prenom_employe." : ".$donnees->motif;
									} else if( ($donnees->demiJourDebut) == 1 && ($donnees->demiJourFin) == 0) {
										$absences = "du ".$donnees->dateDebut." après-midi au ".$donnees->dateFin." matin : ".$donnees->nom_employe." ".$donnees->prenom_employe." : ".$donnees->motif;
									} else if(($donnees->demiJourDebut) == 1 && ($donnees->demiJourFin) == 1) {
										$absences = "du ".$donnees->dateDebut." après-midi au ".$donnees->dateFin." après-midi : ".$donnees->nom_employe." ".$donnees->prenom_employe." : ".$donnees->motif;
									} else if(($donnees->demiJourDebut) == 0 && ($donnees->demiJourFin) == 1){
										$absences = "du ".$donnees->dateDebut." matin au ".$donnees->dateFin." après-midi : ".$donnees->nom_employe." ".$donnees->prenom_employe." : ".$donnees->motif;
									}	
								?>
									<option value="<?php echo $donnees->id_absence ?>"><?php echo $absences; ?></option>   
								<?php
								}
								?>
								</select></div></br>
								<div align = "center" class="12u$">
									<input type="submit"  name="supprime" value="Supprimer" />
									<input type="submit"  name="modifie" value="Modifier" /></br></br>
									<input type="submit" name="creer" value="Enregistrer une nouvelle absence"/>
								</div>
							</form>
							</br>
							<h2>Modification d'une absence</h2>
							<?php 
							if(isset($_POST['modif'])){
								echo "<p> Modification de l'absence effectuée </p>";
							}
							?>
							<form method="post" action="">
								
									</br>
									Motif de l'absence : <div class="6u 12u$(mobile)"><input type="text" name="motif"  value="<?php echo $valAbs->motif;?>"></div>			
									</br>
									Début de l'absence : 
									<div class="6u 12u$(mobile)">
										<input type="date" name="debut" value="<?php echo $valAbs->dateDebut;?>"></br>
										<?php
											if($valAbs->demiJourDebut == 0) {
										?>
										Matin : <input type="radio" name="demiDebut" value="0" checked required/></br>
										Après-midi : <input type="radio" name="demiDebut" value="1" /></br>
										<?php
											} else {
										
										?>
										Matin : <input type="radio" name="demiDebut" value="0" required/></br>
										Après-midi : <input type="radio" name="demiDebut" value="1" checked /></br>
										<?php
											}
										?>
									</div>
									</br>
									Fin de l'absence : 
									<div class="6u 12u$(mobile)">
										<input type="date" name="fin" value="<?php echo $valAbs->dateFin;?>"></br>
										<?php
											if($valAbs->demiJourFin == 0) {
										?>
										Matin : <input type="radio" name="demiFin" value="0" checked required/></br>
										Après-midi : <input type="radio" name="demiFin" value="1" /></br>
										<?php
											} else {
										
										?>
										Matin : <input type="radio" name="demiFin" value="0" required/></br>
										Après-midi : <input type="radio" name="demiFin" value="1" checked /></br>
										<?php
											}
										?>
									</div>
									</div>
								
								<input type="hidden" name="modif" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Modifier" />
								</div></br>
							</form>
						</div>

						<?php
						
							}
						
						?>
			</div>

	</body>
</html>