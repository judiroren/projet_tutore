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
	
	if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
	} else if (!isset($_GET['id_presta'])) {
	
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {
	
		$connexion = connect();
		$nomE = $_SESSION["nomSession"];
		
		$id = $_GET['id_presta'];
		
		if (isset($_POST['modif'])) {
			
			$paypal = (isset($_POST['paypal']) )? 1 : 0;
			
			//Permet de modifier une prestation
			majPresta($connexion, $_POST['descrip'], $_POST['cout'], $_POST['duree'], $_POST['categorie'], $paypal, $id);
			if(!empty($_POST['dejaCap'])){
				supprimeComp2($connexion, $_POST['dejaCap'], $id);
			}
			if(!empty($_POST['nonCap'])){
				ajouteComp2($connexion, $_POST['nonCap'], $id);
			}
		
		}
		
		$i = infosEntreprise();
		
		$listePresta = infosPrestation($id);
		$presta = $listePresta->fetch(PDO::FETCH_OBJ);

		$empComp = listeEmpCapable($id);
		$empNonComp = listeEmpNonCapable($id);
	
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
		
							} else if (!isset($_GET['id_presta'])) {
							
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
							} else {
							
							if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
							
							?>
							<h1><?php echo $nomE?></h1>
							<p>Gestion des prestations</p>
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
							<h1>Gestion des prestations de l'entreprise</h1>
							
							<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
		
							} else if (!isset($_GET['id_presta'])) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme &id_employe=id.</p>";
							
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {
							
							if(isset($_POST['modif'])){
								echo "<p> Modification de prestation effectué </p>";
							}
							?>
							
							
							</br>
							<h2>Ajout d'une prestation</h2>
							<form method="post" action="">
								
								</br>
									Descriptif de la prestation : </br>
									<div class="6u 12u$(mobile)"><textarea name="descrip" ><?php echo $presta->descriptif_presta; ?></textarea></div>			
									</br>
									Prix de la prestation (en €): <div class="6u 12u$(mobile)"><input type="text" name="cout" value="<?php echo $presta->cout;?>"></div>				
									</br>
									Durée de la prestation (en minutes) : <div class="6u 12u$(mobile)"><input type="text" name="duree" value="<?php echo $presta->duree;?>"></div>	
									</br>
									Paiement PayPal : <input type="checkbox" name="paypal" value="1" <?php if($presta->paypal==1){echo "checked='checked'";}?>/>
								
								</br>
								Employés pouvant faire la prestation : <div class="6u 12u$(mobile)"><select name="dejaCap[]" multiple>
									<option value=""></option>
									<?php 
									while($rqt=$empComp->fetch(PDO::FETCH_OBJ)){
										$identite = $rqt->nom_employe." ".$rqt->prenom_employe;
									?>
										<option value="<?php echo $rqt->employe;?>"><?php echo $identite;?></option>
									<?php 	
									
									}
									?>
								</select>
								</div>
								</br>
								Autres employés : <div class="6u 12u$(mobile)"><select name="nonCap[]" multiple>
									<option value=""></option>
									<?php 
									while($rqt=$empNonComp->fetch(PDO::FETCH_OBJ)){
										$identite = $rqt->nom_employe." ".$rqt->prenom_employe;
									?>
										<option value="<?php echo $rqt->id_employe;?>"><?php echo $identite;?></option>
									<?php 	
									
									}
									?>
								</select>
								</div>
								</br>
								Categorie:
								<div class="6u 12u$(mobile)">
								<select name="categorie">
								<option value=""></option>
								<?php 
								$listecat = $connexion->query("SELECT * FROM ".$nomE."_categorie");
								while($donnees=$listecat->fetch(PDO::FETCH_OBJ)){
									$option = $donnees->categorie;
								?>
									<option value="<?php echo $donnees->categorie ?>" <?php if($presta->categorie == $option){ echo "selected='selected'";} ?>><?php echo $option; ?></option>   
								<?php
								}
								?>
								</select>
								</br>
								<input type="hidden" name="modif" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Modifier" />
								</div>
							</form>
						</div>
						
						<?php
						
							}
						
						?>
						
			</div>

	</body>
</html>