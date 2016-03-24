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
			
				if($_POST['mdp']==$_POST['mdp2']){
					modifEntreprise($connexion, $_POST['mail'], $_POST['tel'], $_POST['adresse'], $_POST['logo'], $_POST['descrip'], $_POST['login'], $_POST['mdp']);
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
		<title>Portail entreprise : informations</title>
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
							<p>gestion informations</p>
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
									E-mail : </br>
									<font size=3>format du champs : email classique avec un seul '@' et un seul '.' après l'@ (ex : truc.machin@hotmail.com)</font>
									<div class="6u 12u$(mobile)"><input type="email" name="mail" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+$" value="<?php echo $i->mailEntreprise?>" /></div>			
									</br>
									Téléphone : </br>
									<font size=3>format du champs : un "0" suivi d'un chiffre allant de "1 à 6" ou un "8" suivi de 7 chiffres( ex : 0607891254)</font>
									<div class="6u 12u$(mobile)"><input type="text" pattern="^0[1-68][0-9]{8}$" name="tel" value="<?php echo $i->telEntreprise?>"/></div>				
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