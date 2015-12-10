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
	$cpt = 0;
	$prefixe = 'PRES';
	$ajout = "oui";
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
		$ajout = "non";
	}
	
	$paypal = (isset($_POST['paypal']) )? 1 : 0;
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

if(isset($_POST['supprime'])){
	$connexion->exec("DELETE FROM ".$nomE."_prestation WHERE id_presta='".$_POST['presta_modif']."'");
}
if(isset($_POST['modifie'])){
	header('Location: http://localhost/projet_tutore/projet_tutore/modif_prestation.php?nomEntreprise='.$nomE.'&id_presta='.$_POST['presta_modif']);
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
								if($ajout=="non"){
									echo "<p> Ajout impossible : nombre maximum de prestation atteint";
								}else{
									echo "<p> Ajout de prestation effectué </p>";
								}
							}
							if(isset($_POST['supprime'])){
								echo "<p> Suppression de prestation effectué </p>";
							}
							?>
							<form method="post" action="">
								<div class="6u 12u$(mobile)"><select name="presta_modif">
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