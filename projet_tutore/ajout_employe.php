<?php
session_start();
?>
<!DOCTYPE HTML>
<?php
require "fonctions.inc.php";
$connexion = connect();

$nomE=$_GET['nomEntreprise'];
$rqt = $connexion->query("SELECT * FROM ".$nomE."_employe");
$infoE = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$listePresta1 = $connexion->query("SELECT id_presta, descriptif_presta FROM ".$nomE."_prestation");
$listePresta2 = $connexion->query("SELECT id_presta, descriptif_presta FROM ".$nomE."_prestation");
$listePresta3 = $connexion->query("SELECT id_presta, descriptif_presta FROM ".$nomE."_prestation");
$listeEmpCpt = $connexion->query("SELECT * FROM ".$nomE."_employe");
$listeEmpVerif = $connexion->query("SELECT nom_employe, prenom_employe FROM ".$nomE."_employe");
$listePlan = $connexion->query("SELECT * FROM ".$nomE."_planning");
$i = $infoE->fetch(PDO::FETCH_OBJ);

if(isset($_POST['ajout'])){
	$ajoutOk = 1;
	if(empty($_POST['nom']) && empty($_POST['prenom'])){
		$ajoutOk = 4;
	}elseif(empty($_POST['tel']) && empty($_POST['mail']) && empty($_POST['adresse'])){
		$ajoutOk = 2;
	}
	if(!empty($_POST['tel']) && (strlen($_POST['tel'])!=10 || !is_numeric($_POST['tel']))){
		$ajoutOk = 5;
	}elseif(!empty($_POST['mail']) && !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		$ajoutOk = 6;
	}
	while($val=$listeEmpVerif->fetch(PDO::FETCH_OBJ)){
		if($val->nom_employe==$_POST['nom'] && $val->prenom_employe==$_POST['prenom']){
			$ajoutOk = 0;
		}
	}
	if($ajoutOk == 1){
		$cpt = 0;
		$prefixe = 'EMPL';
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
			$ajoutOk = 3;
		}
			if($ajoutOk==1){
				$connexion->exec("INSERT INTO ".$nomE."_employe(id_employe, nom_employe, prenom_employe, adresse_emp, mail_emp, telephone_emp, competenceA, competenceB, competenceC) VALUES ('".$code."', '".$_POST['nom']."', '".$_POST['prenom']."', '".$_POST['adresse']."', '".$_POST['mail']."', '".$_POST['tel']."', '".$_POST['presta_1']."', '".$_POST['presta_2']."', '".$_POST['presta_3']."')");
				$LundiM = (isset($_POST['LunM']) )? 1 : 0;		$LundiA = (isset($_POST['LunA']) )? 1 : 0;
				$MardiM = (isset($_POST['MarM']) )? 1 : 0;		$MardiA = (isset($_POST['MarA']) )? 1 : 0;
				$MercrediM = (isset($_POST['MerM']) )? 1 : 0;	$MercrediA = (isset($_POST['MerA']) )? 1 : 0;
				$JeudiM = (isset($_POST['JeuM']) )? 1 : 0;		$JeusiA = (isset($_POST['JeuA']) )? 1 : 0;
				$VendrediM = (isset($_POST['VenM']) )? 1 : 0;	$VendrediA = (isset($_POST['VenA']) )? 1 : 0;
				$SamediM = (isset($_POST['SamM']) )? 1 : 0;		$SamediA = (isset($_POST['SamA']) )? 1 : 0;
				$rqt2 = $connexion->query("SELECT id_employe FROM ".$nomE."_employe WHERE nom_employe = '".$_POST['nom']."'");
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
				}
				$connexion->exec("INSERT INTO ".$nomE."_planning(id_agenda, code_employe, LundiM, LundiA, MardiM, MardiA, MercrediM, MercrediA, JeudiM, JeudiA, VendrediM, VendrediA, SamediM, SamediA) VALUES ('".$code."', '".$idemp->id_employe."', ".$LundiM.", ".$LundiA.", ".$MardiM.", ".$MardiA.", ".$MercrediM.", ".$MercrediA.", ".$JeudiM.", ".$JeusiA.", ".$VendrediM.", ".$VendrediA.", ".$SamediM.", ".$SamediA.")");
			}
		}
		
	}
	

	

if(isset($_POST['supprime'])){
	if($_POST['employe_modif']!=""){
		$rqt = $connexion->query('SELECT * FROM '.$nomE.'_reserv WHERE employe = "'.$_POST['employe_modif'].'"');
		if($rqt->rowCount()==0){
			$connexion->exec("DELETE FROM ".$nomE."_planning WHERE code_employe='".$_POST['employe_modif']."'");
			$connexion->exec("DELETE FROM ".$nomE."_employe WHERE id_employe='".$_POST['employe_modif']."'");
			$supprimeOk = 1;
		}else{
			$supprimeOk = 0;
		}
	}else{
		$supprimeOk = 2;
	}
	
}
if(isset($_POST['modifie'])){
	if($_POST['employe_modif']!=""){
		$tabconfig = parse_ini_file("config.ini");
		$chemin = $tabconfig["chemin"];
		header('Location: http://'.$chemin.'/modif_employe.php?nomEntreprise='.$nomE.'&id_employe='.$_POST['employe_modif']);
	}else{
		$modif=1;
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
							<?php if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} ?>
							<h1><?php echo $nomE?></h1>
							<p>Gestion des employés</p>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
							<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
							<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
							<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
							<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
							<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>

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
							if(isset($_POST['ajout'])){
								if($ajoutOk==0){
									echo "<p> Cet employé existe déjà !</p>";
								}elseif($ajoutOk==4){
									echo "<p> Vous devez obligatoirement saisir un nom ET un prénom. </p>";
								}elseif($ajoutOk==3){
									echo "<p> Nombre maximum d'employé atteint. </p>";
								}elseif($ajoutOk==2){
									echo "<p> Vous devez remplir au moins un des 3 champs suivants : adresse postale, adresse mail ou téléphone</p>";
								}elseif($ajoutOk==5){
									echo "<p> Numéro de téléphone incorrect.</p>";
								}elseif($ajoutOk==6){
									echo "<p> Adresse mail incorrecte.</p>";
								}else{
									echo "<p> Ajout de planning et d'employé réussi. </p>";
								}
							}
							if(isset($_POST['supprime'])){
								if($supprimeOk==1){
									echo "<p> Suppression d'employé effectué. </p>";
								}else if($supprimeOk==2){
									echo "<p> Suppression d'employe impossible : veuillez choisir un employé à supprimer. </p>";	
								}else{
									echo "<p> Suppression d'employe impossible : cet employé à encore des rendez-vous de prévu. </p>";	
								}
							}
							if(isset($_POST['modifie']) && $modif==1){
								echo "<p> Modification d'employe impossible : veuillez choisir un employé à modifier. </p>";
							}
							?>
							<form method="post" action="" class="formulaire">
								<div class="6u 12u$(mobile)"><select name="employe_modif">
								<option value=""></option>
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
									Nom de l'employé : <div class="6u 12u$(mobile)"><input type="text" name="nom"  /></div>	
									</br>
									Prénom de l'employé: <div class="6u 12u$(mobile)"><input type="text" name="prenom" /></div>				
									</br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" /></div>		
									</br>
									Adresse mail : <div class="6u 12u$(mobile)"><input type="text" name="mail" /></div>			
									</br>
									Numéro de téléphone : <div class="6u 12u$(mobile)"><input type="text" name="tel" /></div>					
									</br>
									Compétence 1 : <div class="6u 12u$(mobile)"><select name="presta_1">
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
									Compétence 2 : <div class="6u 12u$(mobile)"><select name="presta_2">
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
									Compétence 3 :<div class="6u 12u$(mobile)"><select name="presta_3">
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

						
			</div>

	</body>
</html>