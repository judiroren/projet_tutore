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
		
	} else if (!isset($_SESSION["nomSession"])) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {
		
	$nomE = $_SESSION["nomSession"];
	$connexion = connect();
	
	$rqt = infosEmploye();
	
	$i = infosEntreprise();
	
	$listePresta = listePrestations();
	
	$listeEmpVerif = verifEmploye();
	
	$listePlan = listePlanning();
	

	if(isset($_POST['ajout'])){
		$ajoutOk = 1;
		while($val=$listeEmpVerif->fetch(PDO::FETCH_OBJ)){
			if($val->nom_employe==$_POST['nom'] && $val->prenom_employe==$_POST['prenom']){
				$ajoutOk = 0;
			}
		}
		if($ajoutOk == 1){
			$code = code($nomE."_employe", 'id_employe');
			
			//Vérification des champs
			if($_POST['nom'] == null || $_POST['prenom'] == null || $_POST['adresse'] == null || $_POST['mail'] == null || $_POST['tel'] == null ) {
				$erreur1 = 1;
			} else {
				
					$LundiM = (isset($_POST['LunM']) )? 1 : 0;		$LundiA = (isset($_POST['LunA']) )? 1 : 0;
					$MardiM = (isset($_POST['MarM']) )? 1 : 0;		$MardiA = (isset($_POST['MarA']) )? 1 : 0;
					$MercrediM = (isset($_POST['MerM']) )? 1 : 0;	$MercrediA = (isset($_POST['MerA']) )? 1 : 0;
					$JeudiM = (isset($_POST['JeuM']) )? 1 : 0;		$JeudiA = (isset($_POST['JeuA']) )? 1 : 0;
					$VendrediM = (isset($_POST['VenM']) )? 1 : 0;	$VendrediA = (isset($_POST['VenA']) )? 1 : 0;
					$SamediM = (isset($_POST['SamM']) )? 1 : 0;		$SamediA = (isset($_POST['SamA']) )? 1 : 0;
					
				if($LundiM == 0 && $LundiA == 0 && $MardiM == 0 && $MardiA == 0 && $MercrediM == 0 && $MercrediA == 0 && 
						$JeudiM == 0 && $JeudiA == 0 && $VendrediM == 0 && $VendrediA == 0 && $SamediM == 0 && $SamediA == 0) {
					$erreur2 = 1;
				} else {
					//Permet d'ajouter un employé
					ajoutEmploye($connexion, $code, $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['mail'], $_POST['tel'], $_POST['presta']);
					$ajoutE = "oui";
					
					//Permet de selectionner un employé précis
					$rqt2 = IdentEmploye($_POST['nom']);
					
					$idemp = $rqt2->fetch(PDO::FETCH_OBJ);
					$IDemp = $idemp->id_employe;
					
					$ajoutP = "oui";
					$code = code($nomE."_planning", 'id_agenda');
				}
				
			}
			
			//Permet d'ajouter le planning d'un employé
			if($_POST['nom'] == null || $_POST['prenom'] == null || $_POST['adresse'] == null || $_POST['mail'] == null || $_POST['tel'] == null ) {
				$erreur1 = 1;
			} else {
				
					$LundiM = (isset($_POST['LunM']) )? 1 : 0;		$LundiA = (isset($_POST['LunA']) )? 1 : 0;
					$MardiM = (isset($_POST['MarM']) )? 1 : 0;		$MardiA = (isset($_POST['MarA']) )? 1 : 0;
					$MercrediM = (isset($_POST['MerM']) )? 1 : 0;	$MercrediA = (isset($_POST['MerA']) )? 1 : 0;
					$JeudiM = (isset($_POST['JeuM']) )? 1 : 0;		$JeudiA = (isset($_POST['JeuA']) )? 1 : 0;
					$VendrediM = (isset($_POST['VenM']) )? 1 : 0;	$VendrediA = (isset($_POST['VenA']) )? 1 : 0;
					$SamediM = (isset($_POST['SamM']) )? 1 : 0;		$SamediA = (isset($_POST['SamA']) )? 1 : 0;
				
				if($LundiM == 0 && $LundiA == 0 && $MardiM == 0 && $MardiA == 0 && $MercrediM == 0 && $MercrediA == 0 && 
						$JeudiM == 0 && $JeudiA == 0 && $VendrediM == 0 && $VendrediA == 0 && $SamediM == 0 && $SamediA == 0) {
					$erreur2 = 1;
				} else {
					ajoutPlanning($connexion, $code, $IDemp, $LundiM, $LundiA, $MardiM, $MardiA, $MercrediM, $MercrediA, $JeudiM, $JeudiA, 
							$VendrediM, $VendrediA, $SamediM, $SamediA);
				}
				
			}
			
			
		}
		
	}	

	if (isset($_POST['supprime'])) {
		if(isset($_POST['employe_modif'])){
		//Permet de selectionner toutes les réservations de l'employé
		$employe_modif = $_POST['employe_modif'];
		$rqt = reservationsEmp($employe_modif);
		
		if($rqt->rowCount()==0){
			
			//Permet de supprimer un employé
			supprimerEmp($connexion, $_POST['employe_modif']);
			
			//Permet de supprimer le planning d'un employé
			supprimerPlan($connexion, $_POST['employe_modif']);
			
			$supprimeOk = 1;
			
		}else{
			
			$supprimeOk = 0;
		}
		}
	}
	if(isset($_POST['modifie'])){
		if(isset($_POST['employe_modif'])){
			header('Location: modif_employe.php?nomEntreprise='.$nomE.'&id_employe='.$_POST['employe_modif']);
		}
	}
	
	}

?>

<html>
	<head>
		<title>Portail entreprise : gestion employé</title>
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
							<p>Gestion des employés</p>
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
							<h1>Gestion des employés de l'entreprise</h1>
							<?php 
		
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
								
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {	
							
							if(isset($_POST['ajout'])){
								if($ajoutOk==0){
									echo "<p> Cet employé existe déjà !</p>";
								}else{
									if(isset($ajoutE)) {
										if($ajoutE=="oui"){
											echo "<p> Ajout d'employé effectué. </p>";
										}
									}
									if(isset($ajoutP)) {
										if($ajoutP=="oui"){
											echo "<p> Ajout de planning effectué. </p>";
										}
									}
								}
							}
							if(isset($erreur1)) {
								if($erreur1 == 1) {
									echo "Tous les champs doivent être remplis. </br>";
								}
							}
							if(isset($erreur2)) {
								if($erreur2 == 1) {
									echo "Un employé doit travailler au moins une demie-journée.";
								}
							}
							if(isset($_POST['supprime'])){
								if(isset($supprimeOk) && $supprimeOk==1){
									echo "<p> Suppression de l'employé effectuée. </p>";
								}else{
									echo "<p> Suppression de l'employé impossible.</p>";	
								}
							}
							?>
							<form method="post" action="" class="formulaire">
								<div class="6u 12u$(mobile)"><select name="employe_modif">
								<?php 
								$listeEmp = $connexion->query("SELECT id_employe, nom_employe, prenom_employe FROM ".$nomE."_employe");
								while($donnees=$listeEmp->fetch(PDO::FETCH_OBJ)){
									$identite = $donnees->nom_employe." ".$donnees->prenom_employe;
								?>
									<option value="<?php echo $donnees->id_employe ?>"><?php echo $identite; ?></option>   
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
							<h2>Ajout d'un employé</h2>
							<form method="post" action="" class="formulaire">
								
								</br>
									Nom de l'employé :
									<?php
										if ( isset($_POST["nom"]) ) {
									?>
									<div class="6u 12u$(mobile)"><input type="text" name="nom" value="<?php echo $_POST['nom'];?>" required/></div>	
									<?php
										} else { 
									?>
									<div class="6u 12u$(mobile)"><input type="text" name="nom" required/></div>
									<?php
										}
									?>	
									</br>
									Prénom de l'employé: 
									<?php
										if ( isset($_POST["prenom"]) ) {
									?>
									<div class="6u 12u$(mobile)"><input type="text" name="prenom" value="<?php echo $_POST['prenom'];?>" required/></div>	
									<?php
										} else { 
									?>		
									<div class="6u 12u$(mobile)"><input type="text" name="prenom" required/></div>
									<?php
										}
									?>
									</br>
									Adresse postale :
									<?php
										if ( isset($_POST["adresse"]) ) {
									?>		
									<div class="6u 12u$(mobile)"><input type="text" name="adresse" value="<?php echo $_POST['adresse'];?>" required/></div>	
									<?php
										} else { 
									?>	
									<div class="6u 12u$(mobile)"><input type="text" name="adresse" required/></div>	
									<?php
										}
									?>
									</br>
									Adresse mail :</br>
									<font size=3>format du champs : email classique avec un seul '@' et un seul '.' après l'@ (ex : truc.machin@hotmail.com)</font>
									<?php
										if ( isset($_POST["mail"]) ) {
									?>	
									<div class="6u 12u$(mobile)"><input type="email" name="mail" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+$" value="<?php echo $_POST['mail'];?>" required/></div>
									<?php
										} else { 
									?>	
									<div class="6u 12u$(mobile)"><input type="email" name="mail" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+$" required/></div>
									<?php
										}
									?>
									</br>
									Numéro de téléphone :</br>
									<font size=3>format du champs : un "0" suivi d'un chiffre allant de "1 à 6" ou un "8" suivi de 7 chiffres (ex : 0607891254)</font>
									<?php
										if ( isset($_POST["tel"]) ) {
									?>	
									<div class="6u 12u$(mobile)"><input type="text" pattern="^0[1-68][0-9]{8}$" name="tel" value="<?php echo $_POST['tel'];?>" required/></div>
									<?php
										} else { 
									?>	
									<div class="6u 12u$(mobile)"><input type="text" pattern="^0[1-68][0-9]{8}$" name="tel" required/></div>
									<?php
										}
									?>		
									</br>
									Compétence : 
									<div class="6u 12u$(mobile)"><select name="presta[]" multiple>
										<option value=""  selected="selected"></option>
									<?php 
									while($rqtPresta=$listePresta->fetch(PDO::FETCH_OBJ)){
										?>
										<option value="<?php echo $rqtPresta->id_presta;?>"><?php echo $rqtPresta->descriptif_presta." ".$rqtPresta->categorie;?></option>
									<?php 
									}
									?>
									</select></div>	
									</br>
									
								</br>
									<h3>Planning de l'employé : </h3>
								<table>
									<tr><td></td><td>Matin</td><td>Après-Midi</td></tr>
									<tr><td>Lundi</td><td><input type="checkbox" name="LunM" value=1 /></td><td><input type="checkbox" name="LunA" value=1 /></td></tr>
									<tr><td>Mardi</td><td><input type="checkbox" name="MarM" value=1 /></td><td><input type="checkbox" name="MarA" value=1 /></td></tr>
									<tr><td>Mercredi</td><td><input type="checkbox" name="MerM" value=1 /></td><td><input type="checkbox" name="MerA" value=1 /></td></tr>
									<tr><td>Jeudi</td><td><input type="checkbox" name="JeuM" value=1 /></td><td><input type="checkbox" name="JeuA" value=1 /></td></tr>
									<tr><td>Vendredi</td><td><input type="checkbox" name="VenM" value=1 /></td><td><input type="checkbox" name="VenA" value=1 /></td></tr>
									<tr><td>Samedi</td><td><input type="checkbox" name="SamM" value=1 /></td><td><input type="checkbox" name="SamA" value=1/></td></tr>
								</table>
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