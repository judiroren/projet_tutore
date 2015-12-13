<!DOCTYPE HTML>
<?php
require "fonctions.inc.php";
$connexion = connect();

$nomE=$_GET['nomEntreprise'];
$infoE = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$listePresta = $connexion->query("SELECT id_presta, descriptif_presta FROM ".$nomE."_prestation");
$i = $infoE->fetch(PDO::FETCH_OBJ);
$emp = $connexion->query('SELECT * FROM '.$nomE.'_employe');

if(isset($_POST['ajout'])){
	$ajoutOk = 0;
	
	if(!filter_var($_POST['prix'],FILTER_VALIDATE_FLOAT)){
		$ajoutOk=1;
	}elseif(!filter_var($_POST['duree'],FILTER_VALIDATE_INT)){
		$ajoutOk=2;
	}elseif(empty($_POST['descrip'])){
		$ajoutOk = 4;
	}
	
	$cpt = 0;
	$prefixe = 'PRES';
	while($val=$listePresta->fetch(PDO::FETCH_OBJ)){
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
	
	$paypal = (isset($_POST['paypal']) )? 1 : 0;
	if($ajoutOk==0){
		$connexion->exec("INSERT INTO ".$nomE."_prestation(id_presta, descriptif_presta, prix, paypal, duree) VALUES ('".$code."', '".$_POST['descrip']."', '".$_POST['prix']."', '".$paypal."', '".$_POST['duree']."')");
		$modifEmploye = $connexion->query("SELECT * FROM ".$nomE."_employe WHERE id_employe = '".$_POST['employe']."'");
		$val = $modifEmploye->fetch(PDO::FETCH_OBJ);
		if($val->competenceA == ""){
			$connexion->exec("UPDATE ".$nomE."_employe SET competenceA = '".$code."' WHERE id_employe = '".$_POST['employe']."'");
		}elseif($val->competenceB ==""){
			$connexion->exec("UPDATE ".$nomE."_employe SET competenceB = '".$code."' WHERE id_employe = '".$_POST['employe']."'");
		}else{
			$connexion->exec("UPDATE ".$nomE."_employe SET competenceC = '".$code."' WHERE id_employe = '".$_POST['employe']."'");
		}
	}
}

if(isset($_POST['supprime'])){
	if($_POST['employe_modif']!=""){
		$rqt = $connexion->query('SELECT * FROM '.$nomE.'_reserv WHERE presta = "'.$_POST['presta_modif'].'"');
		if($rqt->rowCount()==0){
			$connexion->exec("DELETE FROM ".$nomE."_prestation WHERE id_presta='".$_POST['presta_modif']."'");
			$supprimeOk = 1;
		}else{
			$supprimeOk = 0;
		}
	}else{
		$supprimeOk = 2;
	}
}
if(isset($_POST['modifie'])){
	if($_POST['presta_modif']!=""){
		$tabconfig = parse_ini_file("config.ini");
		$chemin = $tabconfig["chemin"];
		header('Location: http://'.$chemin.'/modif_prestation.php?nomEntreprise='.$nomE.'&id_presta='.$_POST['presta_modif']);
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
							<p>Gestion des prestations</p>
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
							<h1>Gestion des prestations de l'entreprise</h1>
							<?php 
							if(isset($_POST['ajout'])){
								if($ajoutOk==1){
									echo "<p> Ajout impossible : Prix incorrect. Veuillez saisir un nombre décimal  !</p>";
								}elseif($ajoutOk==2){
									echo "<p> Ajout impossible : Durée incorrecte. Veuillez saisir un nombre de minutes (sans chiffre après la virgule) !</p>";
								}elseif($ajoutOk==3){
									echo "<p> Ajout impossible : nombre maximum de prestation atteint !</p>";
								}elseif($ajoutOk==4){
									echo "<p> Ajout impossible : Une description de la prestation est obligatoire !</p>";
								}else{
									echo "<p>Ajout effectué !</p>";
								}
							}
							if(isset($_POST['supprime'])){
								if($supprimeOk==1){
									echo "<p> Suppression de prestation effectuée. </p>";
								}else if($supprimeOk==2){
									echo "<p> Suppression de prestation impossible : veuillez choisir une prestation à supprimer. </p>";	
								}else{
									echo "<p> Suppression de prestation impossible : cette prestation est encore associé à des rendez-vous de prévu. </p>";	
								}
							}
							if(isset($_POST['modifie']) && $modif==1){
								echo "<p> Modification de prestation impossible : veuillez choisir une prestation à modifier. </p>";
							}
							?>
							<form method="post" action="">
								<div class="6u 12u$(mobile)"><select name="presta_modif">
								<option value=""></option>
								<?php 
								while($donnees=$listePresta->fetch(PDO::FETCH_OBJ)){
								?>
									<option value="<?php echo $donnees->id_presta ?>"><?php echo $donnees->descriptif_presta; ?></option>   
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
							<h3>Ajout d'une prestation</h3>
							<form method="post" action="">
								</br>
									Descriptif de la prestation : </br>
									<div class="6u 12u$(mobile)"><textarea name="descrip" ></textarea></div>			
									</br>
									Prix de la prestation (en €): <div class="6u 12u$(mobile)"><input type="text" name="prix" /></div>				
									</br>
									Durée de la prestation (en minutes) : <div class="6u 12u$(mobile)"><input type="text" name="duree" /></div>	
									</br>
									Paiement PayPal : <input type="checkbox" name="paypal" value=1 />
								
								</br></br>
								<h3>Associer un employe à la nouvelle prestation</h3>
								<select name="employe">
									<?php 
									while($valeur=$emp->fetch(PDO::FETCH_OBJ)){
										if($valeur->competenceA == "" || $valeur->competenceB == "" || $valeur->competenceC == "" ){
										$identite = $valeur->nom_employe." ".$valeur->prenom_employe;
									?>
										<option value="<?php echo $valeur->id_employe ?>"><?php echo $identite; ?></option>   
									<?php 
										}
									}
									?>
								</select>
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