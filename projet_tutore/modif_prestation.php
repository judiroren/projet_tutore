<!DOCTYPE HTML>
<?php
require "fonctions.inc.php";
$connexion = connect();

$nomE=$_GET['nomEntreprise'];
$id=$_GET['id_presta'];
$infoE = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$listePresta = $connexion->query("SELECT * FROM ".$nomE."_prestation WHERE id_presta = '".$id."'");
$i = $infoE->fetch(PDO::FETCH_OBJ);
$presta = $listePresta->fetch(PDO::FETCH_OBJ);
if(isset($_POST['modif'])){
	$paypal = (isset($_POST['paypal']) )? 1 : 0;
	$connexion->exec("UPDATE ".$nomE."_prestation SET descriptif_presta = '".$_POST['descrip']."', prix = '".$_POST['prix']."', duree = '".$_POST['duree']."', paypal = '".$paypal."' WHERE id_presta = '".$_GET['id_presta']."'");
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
							<h1>Gestion des prestations de l'entreprise</h1>
							<?php 
							if(isset($_POST['modif'])){
								echo "<p> Modification de prestation effectué </p>";
							}
							?>
							
							
							</br>
							<h2>Ajout d'une prestation</h2>
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