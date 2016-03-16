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
	require "ajout.inc.php";
	require "bd.inc.php";

	if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {
		
		$nomE = $_SESSION["nomSession"];
		$connexion = connect();	
		
		$i = infosEntreprise();

		if( isset($_POST['verif']) ) {
		
			if( !empty($_POST['mdp']) && !empty($_POST['mdp2'])) {
			
				//$mdp = md5($_POST['mdp']);
				if($_POST['mdp']==$_POST['mdp2']){
					$mdp = $_POST['mdp'];
					modifEntreprise($connexion, $_POST['mail'], $_POST['tel'], $_POST['adresse'], $_POST['logo'], $_POST['descrip'], $_POST['login'], $mdp);
					$i = infosEntreprise();
				}else{
					$erreur=2;
				}
				
			
			} else if((empty($_POST['mdp']) && !empty($_POST['mdp2']))||(!empty($_POST['mdp']) && empty($_POST['mdp2']))){
				$erreur = 1;
			} else {
				modifEnt($connexion, $_POST['mail'], $_POST['tel'], $_POST['adresse'], $_POST['logo'], $_POST['descrip'], $_POST['login']);		
				$i = infosEntreprise();
			}
		
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
		
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
							} else {
							
							if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
							
							?>
							<h1><?php echo $nomE?></h1>
							<p>Modification des informations de l'entreprise</p>
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
						
							<h1>Modification des informations de l'entreprise</h1>
							
							<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
								
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {
							if(isset($_POST['verif'])){
								if(isset($erreur) && $erreur==1 ){
								echo "<p>Pour changer de mot de passe, il faut remplir les 2 champs prévu à cet effet</p>";
								} else if(isset($erreur) && $erreur==2 ){
								echo "<p>Pour changer de mot de passe, il faut renseigner 2 fois le nouveau mot de passe</p>";
								}else{
								echo "<p> Changement effectué </p>";
								//header('Location: accueil_backoffice.php?nomEntreprise='.$nomE.'');
								}
							}
				
							?>
							<form method="post" action="">
								</br>
									<h3>Compte administrateur :	</h3></br>
									Login : <div class="6u 12u$(mobile)"><input type="text" name="login" value="<?php echo $i->loginAdmin?>"/></div>				
									</br>
									Mot de passe : <div class="6u 12u$(mobile)"><input type="text" name="mdp" /></div>								
									</br>
									Confirmer le mot de passe : <div class="6u 12u$(mobile)"><input type="text" name="mdp2" /></div>								
									</br>
									<h3>Informations générale : </h3></br>
									E-mail : <div class="6u 12u$(mobile)"><input type="email" name="mail" value="<?php echo $i->mailEntreprise?>" /></div>			
									</br>
									Téléphone : <div class="6u 12u$(mobile)"><input type="text" pattern="^0[1-9][0-9]{8}" name="tel" value="<?php echo $i->telEntreprise?>"/></div>				
									</br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" value="<?php echo $i->adresseEntreprise?>"/></div>	
									</br>
									URL du logo : <div class="6u 12u$(mobile)"><input type="text" name="logo" value="<?php echo $i->logoEntreprise?>"/></div>				
									</br>
									Description de l'entreprise : <div class="6u 12u$(mobile)"><textarea name="descrip" ><?php echo $i->descEntreprise?></textarea></div>				
								
								
									<input type="hidden" name="verif" value="ok"> 
								
								</br>
								<div align = "center" class="12u$">
									<input type="submit" value="Valider" />
								</div>
							</form>
						</div>

						<?php
						
							}
						
						?>
						
			</div>

	</body>
</html>