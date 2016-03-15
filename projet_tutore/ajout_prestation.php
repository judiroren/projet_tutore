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
		
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {
		
	$nomE = $_SESSION["nomSession"];
	$connexion = connect();
	
	$i = infosEntreprise();
	
	$listePresta = listePrestations();
	
	$emp = infosEmploye();

	if(isset($_POST['ajout'])){
		
		$ajout = "oui";
		
		$code = code($nomE."_prestation", 'id_presta');
		
		$paypal = (isset($_POST['paypal']) )? 1 : 0;
		
		//Permet d'ajouter une prestation
		if($_POST['descrip'] == null || $_POST['cout'] == 0 || $_POST['duree'] == 0 ) {
				$ajout = "non";
		} else {
			if(isset($_POST['employe'])){
				ajoutPresta($connexion, $code, $_POST['descrip'], $_POST['cout'], $paypal, $_POST['duree'], $_POST['employe'],$_POST['categorie_ajout']);
				
			}else{
				ajoutPrestaSansEmp($connexion, $code, $_POST['descrip'], $_POST['cout'], $paypal, $_POST['duree'], $_POST['categorie_ajout']);
			}
			$i = infosEntreprise();
		}
		
		
	}

	if(isset($_POST['supprime'])){
		
		supprimerPresta($connexion, $_POST['presta_modif']);
		
	}
	if(isset($_POST['modifie'])){
		
		header('Location: modif_prestation.php?nomEntreprise='.$nomE.'&id_presta='.$_POST['presta_modif']);
		
	}
	
	}
	$i = infosEntreprise();
	
	$listePresta = listePrestations();
	
	$emp = infosEmploye();

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
								
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {
							
							if(isset($_POST['ajout'])){
								if($ajout=="non"){
									echo "Veuillez remplir tous les champs et associer un employé à la prestation";
								}else{
									echo "<p> Ajout de prestation effectué </p>";
								}
							}
							if(isset($_POST['supprime'])){
								echo "<p> Suppression de prestation effectué </p>";
							}
							?>
							<form method="post" action="">
								<div class="6u 12u$(mobile)"><select name="presta_modif">
								<?php 
								while($donnees=$listePresta->fetch(PDO::FETCH_OBJ)){
								?>
									<option value="<?php echo $donnees->id_presta ?>"><?php echo $donnees->descriptif_presta; ?></option>   
								<?php
								}
								?>
								</select></div></br>
								<div align = "center" class="12u$">
									<input type="submit"  name="supprime" value="Supprimer" />
									<input type="submit"  name="modifie" value="Modifier" />
								</div>
							</form>
							
							</br>
							<h3>Ajout d'une prestation</h3>
							<form method="post" action="">
								</br>
									Descriptif de la prestation : </br>
									<div class="6u 12u$(mobile)"><textarea name="descrip" required></textarea></div>			
									</br>
									Prix de la prestation (en €): <div class="6u 12u$(mobile)"><input type="text" name="cout" required/></div>				
									</br>
									Durée de la prestation (en minutes) : <div class="6u 12u$(mobile)"><input type="text" name="duree" required/></div>	
									</br>
									Paiement PayPal : <input type="checkbox" name="paypal" value=1 />
								
								</br></br>
								<h3>Associer un ou plusieurs employés à la nouvelle prestation</h3>
								<div class="6u 12u$(mobile)"><select name="employe[]" multiple>
									<?php 
									while($valeur=$emp->fetch(PDO::FETCH_OBJ)){
										//if($valeur->competenceA == "" || $valeur->competenceB == "" || $valeur->competenceC == "" ){
										$identite = $valeur->nom_employe." ".$valeur->prenom_employe;
									?>
										<option value="<?php echo $valeur->id_employe ?>"><?php echo $identite; ?></option>   
									<?php 
										//}
									}
									?>
								</select></div>
								</br>
								<h3>Categorie de la prestation</h3>
								<div class="6u 12u$(mobile)"><select name="categorie_ajout">
								<option value=""></option>   
								<?php 
								$listecat = $connexion->query("SELECT * FROM ".$nomE."_categorie");
								while($donnees=$listecat->fetch(PDO::FETCH_OBJ)){
									$option = $donnees->categorie;
								?>
									<option value="<?php echo $donnees->categorie ?>"><?php echo $option; ?></option>   
								<?php
								}
								?>
								</select></div>
								</br>
								<input type="hidden" name="ajout" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Ajouter" />
								</div>
							</form>
						</div>

						<?php
						
							}
						
						?>
						
			</div>

	</body>
</html>