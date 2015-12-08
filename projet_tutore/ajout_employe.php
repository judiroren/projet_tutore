<!DOCTYPE HTML>
<?php 
try {
	$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" );
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}

$nomE=$_GET['nomEntreprise'];
$rqt = $connexion->query("SELECT * FROM ".$nomE."_employe");
$infoE = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$listePresta = $connexion->query("SELECT id_presta FROM ".$nomE."_prestation");
$listeEmpCpt = $connexion->query("SELECT * FROM ".$nomE."_employe");
$listePlan = $connexion->query("SELECT * FROM ".$nomE."_planning");
$i = $infoE->fetch(PDO::FETCH_OBJ);

if(isset($_POST['ajout'])){
	$cpt = 0;
	$prefixe = 'EMPL';
	$ajout = "oui";
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
		$ajout = "non";
	}
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
	$ajout = "oui";
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
		$ajout = "non";
	}
	$connexion->exec("INSERT INTO ".$nomE."_planning(id_agenda, code_employe, LundiM, LundiA, MardiM, MardiA, MercrediM, MercrediA, JeudiM, JeudiA, VendrediM, VendrediA, SamediM, SamediA) VALUES ('".$code."', '".$idemp->id_employe."', ".$LundiM.", ".$LundiA.", ".$MardiM.", ".$MardiA.", ".$MercrediM.", ".$MercrediA.", ".$JeudiM.", ".$JeusiA.", ".$VendrediM.", ".$VendrediA.", ".$SamediM.", ".$SamediA.")");
}

if(isset($_POST['supprime'])){
	$connexion->exec("DELETE FROM ".$nomE."_planning WHERE code_employe='".$_POST['employe_modif']."'");
	$connexion->exec("DELETE FROM ".$nomE."_employe WHERE id_employe='".$_POST['employe_modif']."'");
}
if(isset($_POST['modifie'])){
	header('Location: http://localhost/projet_tutore/projet_tutore/modif_employe.php?nomEntreprise='.$nomE.'&id_employe='.$_POST['employe_modif']);
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
							<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
							<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
							<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
							<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>

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
								echo "<p> Ajout d'employé effectué </p>";
							}
							if(isset($_POST['supprime'])){
								echo "<p> Suppression d'employé effectué </p>";
							}
							?>
							<form method="post" action="">
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
							<form method="post" action="">
								<div class="row">
								</br>
									Nom de l'employé : <div class="6u 12u$(mobile)"><input type="text" name="nom"  /></div>			
									</br></br></br>
									Prénom de l'employé: <div class="6u 12u$(mobile)"><input type="text" name="prenom" /></div>				
									</br></br></br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" /></div>	
									</br></br></br>
									Adresse mail : <div class="6u 12u$(mobile)"><input type="text" name="mail" /></div>				
									</br></br></br>
									Numéro de téléphone : <div class="6u 12u$(mobile)"><input type="text" name="tel" /></div>				
									</br></br></br>
									Compétence 1 : <div class="6u 12u$(mobile)"><input type="text" name="presta_1" /></div>
									</br></br></br>
									Compétence 2 : <div class="6u 12u$(mobile)"><input type="text" name="presta_2" /></div>
									</br></br></br>
									Compétence 3 : <div class="6u 12u$(mobile)"><input type="text" name="presta_3" /></div>
								</div>
								</br>
									
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