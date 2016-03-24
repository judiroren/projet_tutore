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
		
	} else if (!isset($_GET['id_employe'])) {
	
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {
	
	if(isset($_POST['modif'])){
		
		//Modification des informations de l'employé
		majEmploye($connexion, $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['mail'], $_POST['tel'], $_GET['id_employe']);
		
		if(isset($_POST['competence'])){
			ajouteComp($connexion, $_POST['competence'], $_GET['id_employe']);
		}else{
			ajouteComp($connexion, null, $_GET['id_employe']);
		}
		
		$LundiM = (isset($_POST['LunM']) )? 1 : 0;		$LundiA = (isset($_POST['LunA']) )? 1 : 0;
		$MardiM = (isset($_POST['MarM']) )? 1 : 0;		$MardiA = (isset($_POST['MarA']) )? 1 : 0;
		$MercrediM = (isset($_POST['MerM']) )? 1 : 0;	$MercrediA = (isset($_POST['MerA']) )? 1 : 0;
		$JeudiM = (isset($_POST['JeuM']) )? 1 : 0;		$JeudiA = (isset($_POST['JeuA']) )? 1 : 0;
		$VendrediM = (isset($_POST['VenM']) )? 1 : 0;	$VendrediA = (isset($_POST['VenA']) )? 1 : 0;
		$SamediM = (isset($_POST['SamM']) )? 1 : 0;		$SamediA = (isset($_POST['SamA']) )? 1 : 0;
		
		//Modification du planning de l'employé
		/** majPlanning($connexion, $LundiM, $LundiA, $MardiM, $MardiA, $MercrediM, $MercrediA, $JeudiM, $JeudiA, 
							$VendrediM, $VendrediA, $SamediM, $SamediA, $_GET['id_employe']); */
		
		$connexion->exec("UPDATE ".$nomE."_planning SET LundiM = ".$LundiM.", LundiA = ".$LundiA.", MardiM = ".$MardiM.", MardiA = ".$MardiA.", 
		MercrediM = ".$MercrediM.", MercrediA = ".$MercrediA.", JeudiM = ".$JeudiM.", JeudiA = ".$JeudiA.", VendrediM = ".$VendrediM.", 
		VendrediA = ".$VendrediA.", SamediM = ".$SamediM.", SamediA = ".$SamediA." WHERE code_employe = '".$_GET['id_employe']."'");
	}
	
	$presta = listePrestaNonComp($_GET['id_employe']);
	$comp = listeCompetence($_GET['id_employe']);
	
	$rqtEmp = InfosEmploye2($_GET['id_employe']);
	$valEmp = $rqtEmp->fetch(PDO::FETCH_OBJ);
	
	$rqtPlan = planningEmp($_GET['id_employe']);
	$valPlan = $rqtPlan->fetch(PDO::FETCH_OBJ);
	
	$i = infosEntreprise();
	
	}

?>

<html>
	<head>
		<title>Portail de réservation : BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />
		<SCRIPT LANGUAGE="JavaScript">
			function Deplacer( liste_depart, liste_arrivee ){
		    	for( i = 0; i < liste_depart.options.length; i++ ){
      				if( liste_depart.options[i].selected && liste_depart.options[i] != "" ){
        				o = new Option( liste_depart.options[i].text, liste_depart.options[i].value );
        				liste_arrivee.options[liste_arrivee.options.length] = o;
        				liste_depart.options[i] = null;
        				i = i - 1 ;
      				}else{
       					 // alert( "aucun element selectionne" );
      				}
    			}
  			}

			function Valider( liste_1, liste_2 ){
		    	for( i = 0; i < liste_1.options.length; i++ ){
      				liste_1.options[i].selected=true;
    			}
		    	for( i = 0; i < liste_2.options.length; i++ ){
      				liste_2.options[i].selected=true;
    			}
		    	document.getElementById("competence").disabled = true;
		    	document.getElementById("prestation").disabled = true;
  			}
			function Debloque(){
		    	document.getElementById("competence").disabled = false;
		    	document.getElementById("prestation").disabled = false;
  			}
		
		</SCRIPT>
	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
							} else if (!isset($_GET['id_employe'])) {
							
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
		
							} else if (!isset($_GET['id_employe'])) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme &id_employe=id.</p>";
							
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {
							
							if(isset($_POST['modif'])){
								echo "<p> Modification d'employé effectué </p>";
							}
							?>
							</br>
							<h2>Modification d'un employé</h2>
							<form method="post" action="">
								
								</br>
									Nom de l'employé : <div class="6u 12u$(mobile)">
									<input type="text" name="nom"  value="<?php echo $valEmp->nom_employe;?>"></div>			
									</br>
									Prénom de l'employé: <div class="6u 12u$(mobile)">
									<input type="text" name="prenom" value="<?php echo $valEmp->prenom_employe;?>"></div>				
									</br>
									Adresse postale :
									<div class="6u 12u$(mobile)">
									<input type="text" name="adresse" value="<?php echo $valEmp->adresse_emp;?>"></div>	
									</br>
									Adresse mail : </br>
									<font size=3>format du champs : email classique avec un seul '@' et un seul '.' après l'@ (ex : truc.machin@hotmail.com)</font>
									<div class="6u 12u$(mobile)">
									<input type="email" name="mail" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+$" value="<?php echo $valEmp->mail_emp;?>"></div>				
									</br>
									Numéro de téléphone : </br>
									<font size=3>format du champs : un "0" suivi d'un chiffre allant de "1 à 6" ou un "8" suivi de 7 chiffres (ex : 0607891254)</font>
									<div class="6u 12u$(mobile)">
									<input type="text" pattern="^0[1-68][0-9]{8}$" name="tel" value="<?php echo $valEmp->telephone_emp;?>"></div>				
									</br>
									Compétences déjà acquise : <div class="6u 12u$(mobile)"><select name="competence[]" id="competence" size=3 multiple>
										
									<?php 
									while($rqtComp=$comp->fetch(PDO::FETCH_OBJ)){
									?>
										<option value="<?php echo $rqtComp->prestation;?>" ><?php echo $rqtComp->descriptif_presta." ".$rqtComp->categorie;?></option>
									<?php 	
									
									}
									?>
									</select></div>
									</br><center>
									<INPUT type="button" value="\/" onClick="Deplacer(this.form.competence,this.form.prestation)">
									<INPUT type="button" value="/\" onClick="Deplacer(this.form.prestation,this.form.competence)">	
									<INPUT type="button" value="Verrouiller les compétences" onClick="Valider(this.form.prestation,this.form.competence)">
									</center>
									Prestations : <div class="6u 12u$(mobile)"><select name="prestation[]" id="prestation" size=3 multiple>
										
									<?php 
									$i=0;
									while($rqtPrest = $presta->fetch(PDO::FETCH_OBJ)){
									?>
										<option value="<?php echo $rqtPrest->id_presta;?>" ><?php echo $rqtPrest->descriptif_presta." ".$rqtPrest->categorie;?></option>
									<?php 	
									$i++;
									}
									?>
									</select></div></br>
								<table>
									<tr><td></td><td>Matin</td><td>Après-Midi</td></tr>
									<tr><td>Lundi</td><td><input type="checkbox" name="LunM" value=1 <?php if($valPlan->LundiM==1){echo "checked='checked'";}?>/></td><td><input type="checkbox" name="LunA" value=1 <?php if($valPlan->LundiA==1){echo "checked='checked'";}?>/></td></tr>
									<tr><td>Mardi</td><td><input type="checkbox" name="MarM" value=1 <?php if($valPlan->MardiM==1){echo "checked='checked'";}?>/></td><td><input type="checkbox" name="MarA" value=1 <?php if($valPlan->MardiA==1){echo "checked='checked'";}?>/></td></tr>
									<tr><td>Mercredi</td><td><input type="checkbox" name="MerM" value=1 <?php if($valPlan->MercrediM==1){echo "checked='checked'";}?>/></td><td><input type="checkbox" name="MerA" value=1 <?php if($valPlan->MercrediA==1){echo "checked='checked'";}?>/></td></tr>
									<tr><td>Jeudi</td><td><input type="checkbox" name="JeuM" value=1 <?php if($valPlan->JeudiM==1){echo "checked='checked'";}?>/></td><td><input type="checkbox" name="JeuA" value=1 <?php if($valPlan->JeudiA==1){echo "checked='checked'";}?>/></td></tr>
									<tr><td>Vendredi</td><td><input type="checkbox" name="VenM" value=1 <?php if($valPlan->VendrediM==1){echo "checked='checked'";}?>/></td><td><input type="checkbox" name="VenA" value=1 <?php if($valPlan->VendrediA==1){echo "checked='checked'";}?>/></td></tr>
									<tr><td>Samedi</td><td><input type="checkbox" name="SamM" value=1 <?php if($valPlan->SamediM==1){echo "checked='checked'";}?>/></td><td><input type="checkbox" name="SamA" value=1 <?php if($valPlan->SamediA==1){echo "checked='checked'";}?>/></td></tr>
								</table>
								</br>
								<input type="hidden" name="modif" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Modifier" onClick="Debloque()"/>
								</div>
							</form>
						</div>

						<?php
						
							}
						
						?>
			</div>

	</body>
</html>