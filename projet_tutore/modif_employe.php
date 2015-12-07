<!DOCTYPE HTML>
<?php
try {
	$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" );
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}

$nomE=$_GET['nomEntreprise'];
$rqtEmp = $connexion->query("SELECT * FROM ".$nomE."_employe WHERE id_employe = ".$_GET['id_employe']);
$valEmp = $rqtEmp->fetch(PDO::FETCH_OBJ);
$rqtPlan = $connexion->query("SELECT * FROM ".$nomE."_planning WHERE code_employe = ".$_GET['id_employe']);
$valPlan = $rqtPlan->fetch(PDO::FETCH_OBJ);
$infoE = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$i = $infoE->fetch(PDO::FETCH_OBJ);

if(isset($_POST['modif'])){
	$connexion->exec("UPDATE ".$nomE."_employe SET nom_employe = '".$_POST['nom']."', prenom_employe = '".$_POST['prenom']."', adresse_emp = '".$_POST['adresse']."', mail_emp = '".$_POST['mail']."', telephone_emp = '".$_POST['tel']."', competenceA = '".$_POST['presta_1']."', competenceB = '".$_POST['presta_2']."', competenceC = '".$_POST['presta_3']."' WHERE id_employe = '".$_GET['id_employe']."'");
	$LundiM = (isset($_POST['LunM']) )? 1 : 0;		$LundiA = (isset($_POST['LunA']) )? 1 : 0;
	$MardiM = (isset($_POST['MarM']) )? 1 : 0;		$MardiA = (isset($_POST['MarA']) )? 1 : 0;
	$MercrediM = (isset($_POST['MerM']) )? 1 : 0;	$MercrediA = (isset($_POST['MerA']) )? 1 : 0;
	$JeudiM = (isset($_POST['JeuM']) )? 1 : 0;		$JeudiA = (isset($_POST['JeuA']) )? 1 : 0;
	$VendrediM = (isset($_POST['VenM']) )? 1 : 0;	$VendrediA = (isset($_POST['VenA']) )? 1 : 0;
	$SamediM = (isset($_POST['SamM']) )? 1 : 0;		$SamediA = (isset($_POST['SamA']) )? 1 : 0;
	$connexion->exec("UPDATE ".$nomE."_planning SET LundiM = ".$LundiM.", LundiA = ".$LundiA.", MardiM = ".$MardiM.", MardiA = ".$MardiA.", MercrediM = ".$MercrediM.", MercrediA = ".$MercrediA.", JeudiM = ".$JeudiM.", JeudiA = ".$JeudiA.", VendrediM = ".$VendrediM.", VendrediA = ".$VendrediA.", SamediM = ".$SamediM.", SamediA = ".$SamediA." WHERE code_employe = ".$_GET['id_employe']);
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
							if(isset($_POST['modif'])){
								echo "<p> Modification d'employé effectué </p>";
							}
							?>
							</br>
							<h2>Modification d'un employé</h2>
							<form method="post" action="">
								<div class="row">
								</br>
									Nom de l'employé : <div class="6u 12u$(mobile)">
									<input type="text" name="nom"  value="<?php echo $valEmp->nom_employe;?>"></div>			
									</br></br></br>
									Prénom de l'employé: <div class="6u 12u$(mobile)">
									<input type="text" name="prenom" value="<?php echo $valEmp->prenom_employe;?>"></div>				
									</br></br></br>
									Adresse postale : <div class="6u 12u$(mobile)">
									<input type="text" name="adresse" value="<?php echo $valEmp->adresse_emp;?>"></div>	
									</br></br></br>
									Adresse mail : <div class="6u 12u$(mobile)">
									<input type="text" name="mail" value="<?php echo $valEmp->mail_emp;?>"></div>				
									</br></br></br>
									Numéro de téléphone : <div class="6u 12u$(mobile)">
									<input type="text" name="tel" value="<?php echo $valEmp->telephone_emp;?>"></div>				
									</br></br></br>
									Compétence 1 : <div class="6u 12u$(mobile)">
									<input type="text" name="presta_1" value="<?php echo $valEmp->competenceA;?>"></div>
									</br></br></br>
									Compétence 2 : <div class="6u 12u$(mobile)">
									<input type="text" name="presta_2" value="<?php echo $valEmp->competenceB;?>"></div>
									</br></br></br>
									Compétence 3 : <div class="6u 12u$(mobile)">
									<input type="text" name="presta_3" value="<?php echo $valEmp->competenceC;?>"></div>
								</div>
								</br>

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
									<input type="submit" value="Modifier" />
								</div>
							</form>
						</div>

						
			</div>

	</body>
</html>