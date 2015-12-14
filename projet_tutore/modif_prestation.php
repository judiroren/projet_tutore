<!DOCTYPE HTML>
<?php
require "fonctions.inc.php";
$connexion = connect();

$nomE=$_GET['nomEntreprise'];
$id=$_GET['id_presta'];
$infoE = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$i = $infoE->fetch(PDO::FETCH_OBJ);

if(isset($_POST['modif'])){
	$modifOk = 0;
	
	if(!filter_var($_POST['prix'],FILTER_VALIDATE_FLOAT)){
		$modifOk=1;
	}elseif(!filter_var($_POST['duree'],FILTER_VALIDATE_INT)){
		$modifOk=2;
	}elseif(empty($_POST['descrip'])){
		$modifOk = 4;
	}
	$paypal = (isset($_POST['paypal']) )? 1 : 0;
	if($modifOk==0){
		$connexion->exec("UPDATE ".$nomE."_prestation SET descriptif_presta = '".$_POST['descrip']."', prix = '".$_POST['prix']."', duree = '".$_POST['duree']."', paypal = '".$paypal."' WHERE id_presta = '".$_GET['id_presta']."'");
	}
}
$listePresta = $connexion->query("SELECT * FROM ".$nomE."_prestation WHERE id_presta = '".$id."'");
$presta = $listePresta->fetch(PDO::FETCH_OBJ);
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
							if(isset($_POST['modif'])){
								if($modifOk==1){
									echo "<p> Modification impossible : Prix incorrect. Veuillez saisir un nombre décimal  !</p>";
								}elseif($modifOk==2){
									echo "<p> Modification impossible : Durée incorrecte. Veuillez saisir un nombre de minutes (sans chiffre après la virgule) !</p>";
								}elseif($modifOk==3){
									echo "<p> Modification impossible : nombre maximum de prestation atteint !</p>";
								}elseif($modifOk==4){
									echo "<p> Modification impossible : Une description de la prestation est obligatoire !</p>";
								}else{
									echo "<p>Modification effectué !</p>";
								}
							}
							?>
							
							
							</br>
							<h2>Modification d'une prestation</h2>
							<form method="post" action="">
								
								</br>
									Descriptif de la prestation : </br>
									<div class="6u 12u$(mobile)"><textarea name="descrip" ><?php echo $presta->descriptif_presta; ?></textarea></div>			
									</br>
									Prix de la prestation (en €): <div class="6u 12u$(mobile)"><input type="text" name="prix" value=<?php echo $presta->prix;?>></div>				
									</br>
									Durée de la prestation (en minutes) : <div class="6u 12u$(mobile)"><input type="text" name="duree" value=<?php echo $presta->duree;?>></div>	
									</br>
									Paiement PayPal : <input type="checkbox" name="paypal" value=1 <?php if($presta->paypal==1){echo "checked='checked'";}?>/>
								
								</br></br>
								
								<input type="hidden" name="modif" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Modifier" />
								</div>
							</form>
						</div>

						
			</div>

	</body>
</html>