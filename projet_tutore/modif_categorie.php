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

	
?>

<!DOCTYPE HTML>

<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	
	if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
	/*} else if (!isset($_GET['id_presta'])) {*/
	
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {
		
		$_SESSION["nomE"] = $_GET['nomEntreprise'];	
		
		$connexion = connect();
		$nomE = $_GET['nomEntreprise'];
		$nomE = str_replace(' ', '_', $nomE);

		//permet de récuperer les infos de connexion
		$i = infosEntreprise();

		//Les informations doivent être correcte
		if( isset($_POST['login']) && isset($_POST['mdp']) ) {
			
			if( $_POST['login'] == $i->loginAdmin && $_POST['mdp'] == $i->mdpAdmin ) {
				
				$_SESSION["estConnecte"] = 1;
				$_SESSION["nomSession"] = $_GET['nomEntreprise'];
				
			}
		}

		$planning = planningEnt();
										
		$reserva = reservationsEnt();
										
		$absences = abscencesEnt();
		
		$categorie = listeCategorie();
		
		if(isset($_POST['ajout'])){
			$vide = false;
			if($_POST['categorie'] == ''){
				$vide = true;
			}
			$ok = true;
			while ($uneCat = $categorie->fetch(PDO::FETCH_OBJ)){
				if ($_POST['categorie'] == $uneCat->categorie){
					$ok = false;
				}
			}
			
			if($ok && !$vide){
				ajoutCategorie($connexion, $_POST['categorie']);
			}
			
		}
		if(isset($_POST['suppr'])){
			if(isset($_POST['categorie_suppr']) && $_POST['categorie_suppr']!=""){
				supprimeCategorie($connexion, $_POST['categorie_suppr']);
				$suppr = 1;
			}
		}
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
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
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
							<p>Gestion des catégories</p>
							
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
						<h1>Gestion des catégorie des prestations</h1><br/>
						
						<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
		
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {
						
							if(isset($_POST['ajout']) && $ok && !$vide){
								echo "<p> Ajout de la categorie effectuée </p>";
							}elseif(isset($vide) && $vide){
								echo "<p> Attention, Champ vide !<p>";
							}elseif(isset($ok) && !$ok){
								echo "<p> Attention, cette categorie existe déjà !<p>";
							}elseif(isset($suppr) && $suppr==1){
								echo "<p> Suppression de la categorie effectué </p>";	
							}
							?>
						
							Ajout d'une categorie :<br/>
							<form method="post" action="">
							<div class="6u 12u$(mobile)"><input type="text" name="categorie" /><input type="hidden" name="ajout" value="ok"></br><input type="submit" name ="ajout" value="Ajouter" /></div>
							</form>
								<form method="post" action="">
								<br/>
								Suppression d'une categorie :<br/>
							<div class="6u 12u$(mobile)">
								<select name="categorie_suppr">
								<?php 
								$listecat = $connexion->query("SELECT * FROM ".$nomE."_categorie");
								while($donnees=$listecat->fetch(PDO::FETCH_OBJ)){
									$option = $donnees->categorie;
								?>
									<option value="<?php echo $donnees->categorie ?>"><?php echo $option; ?></option>   
								<?php
								}
								?>
								</select>
								<input type="hidden" name="suppr" value="ok"></br><input type="submit" name ="suppr" value="supprimer" /></div>
						</div>	
						
						<?php
						
							}
						
						?>	
			</div>
	</body>
</html>