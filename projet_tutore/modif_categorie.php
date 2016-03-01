<?php

	session_start();
	//$_SESSION["nomE"] = $_GET['nomEntreprise'];
	
	try {
		//$_SESSION["nomE"] = $_GET['nomEntreprise'];
		if($_GET['nomEntreprise'] != null) {
			$_SESSION["nomE"] = $_GET['nomEntreprise'];
		} else {
			throw new Exception("Notice: Undefined offset");
		}
	} catch(Exception $e){
		echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
	}
	
?>

<!DOCTYPE HTML>

<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	
	/* if( $_SESSION["nomE"] == null ) {
		
		echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
		
	} else  */
	if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
		
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
		supprimeCategorie($connexion, $_POST['categorie_suppr']);
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
							<?php } ?>

				</div>


			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">
						<h1>Gestion des catégorie des prestations</h1><br/>
						
						<?php 
							if(isset($_POST['ajout']) && $ok && !$vide){
								echo "<p> Ajout de la categorie effectuée </p>";
							}elseif(isset($vide) && $vide){
								echo "<p> Attention, Champ vide !<p>";
							}elseif(isset($ok) && !$ok){
								echo "<p> Attention, cette categorie existe déjà !<p>";
							}elseif(isset($_POST['suppr'])){
								echo "<p> Suppression de la categorie effectué </p>";	
							}
							?>
						
							Ajout d'une categorie :<br/>
							<form method="post" action="">
							<div class="6u 12u$(mobile)"><input type="text" name="categorie" /><input type="hidden" name="ajout" value="ok"></br><input type="submit" name ="ajout" value="Ajouter" /></div>
							</form>
								<?php 
									} 
								?>
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
			</div>
	</body>
</html>