<?php

	session_start();
	
	/** try {
		$_SESSION["nomE"] = $_GET['nomEntreprise'];
		if(isset($_SESSION["nomE"])) {
			$_SESSION["nomE"] = $_GET['nomEntreprise'];
		} else {
			throw new Exception("Notice: Undefined offset");
		}
	} catch(Exception $e){
		echo "<p>Le nom de l'entreprise doit �tre renseign� dans l'url sous la forme ?nomEntreprise=nom.</p>";
	} */

?>

<!DOCTYPE HTML>

<?php

	require "fonctions.inc.php";
	require "ajout.inc.php";
	require "bd.inc.php";
	
	if( $_SESSION["nomE"] == null ) {
		
		echo "<p>Le nom de l'entreprise doit �tre renseign� dans l'url sous la forme ?nomEntreprise=nom.</p>";
		
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donn�e</p>";
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
		echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
		
	} else {
		
	$nomE = $_SESSION["nomSession"];
	$connexion = connect();
	
	$rqt = infosEmploye();
	
	$i = infosEntreprise();
	
	$listePresta1 = listePrestations();
	$listePresta2 = $listePresta1;
	$listePresta3 = $listePresta2;
	
	$listeEmpCpt = infosEmploye();
	
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
			$cpt = 0;
			$prefixe = 'EMPL';
			$ajoutE = "oui";
			while($val=$listeEmpCpt->fetch(PDO::FETCH_OBJ)){
				$cpt++;
			}
			$cpt++;
			if($cpt<9){
				$code = $prefixe.'000'.$cpt;
			}else if($cpt<99){
				$code = $prefixe.'00'.$cpt;
			}else if($cpt<999){
				$code = $prefixe.'0'.$cpt;
			}else if($cpt<9999){
				$code = $prefixe.$cpt;
			}else{
				$ajoutE = "non";
			}
			
			//Permet d'ajouter un employ�
			ajoutEmploye($connexion, $code, $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['mail'], $_POST['tel'], $_POST['presta_1'],
						$_POST['presta_2'], $_POST['presta_3']);
			/** $connexion->exec("INSERT INTO ".$nomE."_employe(id_employe, nom_employe, prenom_employe, adresse_emp, mail_emp, 
			telephone_emp, competenceA, competenceB, competenceC) VALUES ('".$code."', '".$_POST['nom']."', '".$_POST['prenom']."', 
			'".$_POST['adresse']."', '".$_POST['mail']."', '".$_POST['tel']."', '".$_POST['presta_1']."', '".$_POST['presta_2']."',
			'".$_POST['presta_3']."')"); */
			
			$LundiM = (isset($_POST['LunM']) )? 1 : 0;		$LundiA = (isset($_POST['LunA']) )? 1 : 0;
			$MardiM = (isset($_POST['MarM']) )? 1 : 0;		$MardiA = (isset($_POST['MarA']) )? 1 : 0;
			$MercrediM = (isset($_POST['MerM']) )? 1 : 0;	$MercrediA = (isset($_POST['MerA']) )? 1 : 0;
			$JeudiM = (isset($_POST['JeuM']) )? 1 : 0;		$JeudiA = (isset($_POST['JeuA']) )? 1 : 0;
			$VendrediM = (isset($_POST['VenM']) )? 1 : 0;	$VendrediA = (isset($_POST['VenA']) )? 1 : 0;
			$SamediM = (isset($_POST['SamM']) )? 1 : 0;		$SamediA = (isset($_POST['SamA']) )? 1 : 0;
			
			//Permet de selectionner un employ� pr�cis
			$rqt2 = IdentEmploye($_POST['nom']);
			//$rqt2 = $connexion->query("SELECT id_employe FROM ".$nomE."_employe WHERE nom_employe = '".$_POST['nom']."'");
			
			$idemp = $rqt2->fetch(PDO::FETCH_OBJ);
			
			$cpt = 0;
			$prefixe = 'PLAN';
			$ajoutP = "oui";
			while($val=$listePlan->fetch(PDO::FETCH_OBJ)){
				$cpt++;
			}
			$cpt++;
			if($cpt<9){
				$code = $prefixe.'000'.$cpt;
			}else if($cpt<99){
				$code = $prefixe.'00'.$cpt;
			}else if($cpt<999){
				$code = $prefixe.'0'.$cpt;
			}else if($cpt<9999){
				$code = $prefixe.$cpt;
			}else{
				$ajoutP = "non";
			}
			
			//Permet d'ajouter le planning d'un employ�
			/** ajoutPlanning($connexion, $code, $idemp, $LundiM, $LundiA, $MardiM, $MardiA, $MercrediM, $MercrediA, $JeudiM, $JeudiA, 
							$VendrediM, $VendrediA, $SamediM, $SamediA); */
			$connexion->exec("INSERT INTO ".$nomE."_planning(id_agenda, code_employe, LundiM, LundiA, MardiM, MardiA, MercrediM, 
							MercrediA, JeudiM, JeudiA, VendrediM, VendrediA, SamediM, SamediA) VALUES ('".$code."', '".$idemp->id_employe."', 
							".$LundiM.", ".$LundiA.", ".$MardiM.", ".$MardiA.", ".$MercrediM.", ".$MercrediA.", ".$JeudiM.", ".$JeudiA.", 
							".$VendrediM.", ".$VendrediA.", ".$SamediM.", ".$SamediA.")");
			
		}
		
	}	

	if (isset($_POST['supprime'])) {
		
		//Permet de selectionner toutes les r�servations de l'employ�
		//$rqt = reservationsEmp($connexion, $_POST['employe_modif']);
		//$rqt = reservationsEmp($connexion, $idemp);
		$rqt = $connexion->query('SELECT * FROM '.$nomE.'_reserv WHERE employe = "'.$_POST['employe_modif'].'"');
		
		if($rqt->rowCount()==0){
			
			//Permet de supprimer un employ�
			supprimerEmp($connexion, $_POST['employe_modif']);
			//$connexion->exec("DELETE FROM ".$nomE."_planning WHERE code_employe='".$_POST['employe_modif']."'");
			//Permet de supprimer le planning d'un employ�
			supprimerPlan($connexion, $_POST['employe_modif']);
			//$connexion->exec("DELETE FROM ".$nomE."_employe WHERE id_employe='".$_POST['employe_modif']."'");
			$supprimeOk = 1;
			
		}else{
			
			$supprimeOk = 0;
		}
	}
	if(isset($_POST['modifie'])){
		header('Location: modif_employe.php?nomEntreprise='.$nomE.'&id_employe='.$_POST['employe_modif']);
	}

?>

<html>
	<head>
		<title>Portail de r�servation : BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<?php if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} ?>
							<h1><?php echo $nomE?></h1>
							<p>Gestion des employ�s</p>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
							<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
							<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employ�s </a></br>
							<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
							<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
							<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>

						</div>
						
				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
						<div class="container">
							<h1>Gestion des employ�s de l'entreprise</h1>
							<?php 
							if(isset($_POST['ajout'])){
								if($ajoutOk==0){
									echo "<p> Cet employ� existe d�j� !</p>";
								}else{
									if($ajoutE=="oui"){
										echo "<p> Ajout d'employ� effectu�. </p>";
									}else{
										echo "<p> Nombre maximum d'employ� atteint. </p>";
									}
									if($ajoutP=="oui"){
										echo "<p> Ajout de planning effectu�. </p>";
									}else{
										echo "<p> Nombre maximum de planning atteint. </p>";
									}
								}
							}
							if(isset($_POST['supprime'])){
								if($supprimeOk==1){
									echo "<p> Suppression d'employ� effectu�. </p>";
								}else{
									echo "<p> Suppression d'employe impossible : cet employ� � encore des rendez-vous de pr�vu. </p>";	
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
							<h2>Ajout d'un employ�</h2>
							<form method="post" action="" class="formulaire">
								
								</br>
									Nom de l'employ� : <div class="6u 12u$(mobile)"><input type="text" name="nom"  /></div>	
									</br>
									Pr�nom de l'employ�: <div class="6u 12u$(mobile)"><input type="text" name="prenom" /></div>				
									</br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" /></div>		
									</br>
									Adresse mail : <div class="6u 12u$(mobile)"><input type="email" name="mail" /></div>			
									</br>
									Num�ro de t�l�phone : <div class="6u 12u$(mobile)"><input type="text" name="tel" /></div>					
									</br>
									Comp�tence 1 : <div class="6u 12u$(mobile)"><select name="presta_1">
										<option value=""  selected="selected"></option>
									<?php 
									while($rqtPresta1=$listePresta1->fetch(PDO::FETCH_OBJ)){
										?>
										<option value="<?php echo $rqtPresta1->id_presta;?>"><?php echo $rqtPresta1->descriptif_presta;?></option>
									<?php 
									}
									?>
									</select></div>	
									</br>
									Comp�tence 2 : <div class="6u 12u$(mobile)"><select name="presta_2">
										<option value=""  selected="selected"></option>
									<?php 
									while($rqtPresta2=$listePresta2->fetch(PDO::FETCH_OBJ)){
										?>
										<option value="<?php echo $rqtPresta2->id_presta;?>"><?php echo $rqtPresta2->descriptif_presta;?></option>
									<?php 
									}
									?>
									</select></div>
									</br>
									Comp�tence 3 :<div class="6u 12u$(mobile)"><select name="presta_3">
										<option value=""  selected="selected"></option>
									<?php 
									while($rqtPresta3=$listePresta3->fetch(PDO::FETCH_OBJ)){
										?>
										<option value="<?php echo $rqtPresta3->id_presta;?>"><?php echo $rqtPresta3->descriptif_presta;?></option>
									<?php 
									}
									?>
									</select></div>	
									
								
								</br>
									<h3>Planning de l'employ� : </h3>
								<table>
									<tr><td></td><td>Matin</td><td>Apr�s-Midi</td></tr>
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