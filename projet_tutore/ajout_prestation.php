<!DOCTYPE HTML>
<?php
try {
	$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" );
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connexion �chou�e : ' . $e->getMessage();
}

$nomE=$_GET['nomEntreprise'];
$infoE = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$listePresta = $connexion->query("SELECT id_presta, descriptif_presta FROM ".$nomE."_prestation");
$i = $infoE->fetch(PDO::FETCH_OBJ);


if(isset($_POST['ajout'])){
	$cpt = 0;
	$prefixe = 'PRES';
	$ajout = oui;
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
}

if(isset($_POST['supprime'])){
	$connexion->exec("DELETE FROM ".$nomE."_prestation WHERE id_presta='".$_POST['presta_modif']."'");
}
if(isset($_POST['modifie'])){
	header('Location: http://localhost/projet_tutore/projet_tutore/modif_prestation.php?nomEntreprise=tiff&id_presta='.$_POST['presta_modif']);
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
							<p>Gestion des prestations</p>
							<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
							<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employ�s </a></br>
							<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>

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
									echo "<p> Ajout de prestation effectu� </p>";
								}
							}
							if(isset($_POST['supprime'])){
								echo "<p> Suppression de prestation effectu� </p>";
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
							<h2>Ajout d'une prestation</h2>
							<form method="post" action="">
								<div class="row">
								</br>
									Descriptif de la prestation : </br>
									<div class="6u 12u$(mobile)"><textarea name="descrip" ></textarea></div>			
									</br></br></br>
									</br></br></br>
									</br></br></br></br></br>
									Prix de la prestation (en �): <div class="6u 12u$(mobile)"><input type="text" name="prix" /></div>				
									</br></br></br>
									Dur�e de la prestation (en minutes) : <div class="6u 12u$(mobile)"><input type="text" name="duree" /></div>	
									</br></br></br>
									Paiement PayPal :</br> <input type="checkbox" name="paypal" value=1 />
									
									 
								</div>
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