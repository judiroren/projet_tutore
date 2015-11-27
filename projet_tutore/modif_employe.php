<!DOCTYPE HTML>
<?php
try {
	$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" );
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}

$nom=$_GET['nomEntreprise'];
$rqt = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nom.'"');
$i = $rqt->fetch(PDO::FETCH_OBJ);
$nomE = $i->nomEntreprise;
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
							<a href="modif_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
							<a href="modif_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
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
							if(isset($_POST['verif'])){
								echo "<p> Changement effectué </p>";
							}
							?>
							<form method="post" action="">
								<div class="row">
								</br>
									Nom de l'employé : <div class="6u 12u$(mobile)"><input type="text" name="mail" value="<?php echo $i->mailEntreprise?>" /></div>			
									</br></br></br>
									Prénom de l'employé: <div class="6u 12u$(mobile)"><input type="text" name="tel" value="<?php echo $i->telEntreprise?>"/></div>				
									</br></br></br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" value="<?php echo $i->adresseEntreprise?>"/></div>	
									</br></br></br>
									Adresse mail : <div class="6u 12u$(mobile)"><input type="text" name="logo" value="<?php echo $i->logoEntreprise?>"/></div>				
									</br></br></br>
									Numéro de téléphone : <div class="6u 12u$(mobile)"><input type="text" name="login" value="<?php echo $i->loginAdmin?>"/></div>				
									</br></br></br>
									Compétence 1 : <div class="6u 12u$(mobile)"><input type="text" name="mdp" value="<?php echo $i->mdpAdmin?>"/></div>								
									</br></br></br>
									Compétence 2 : <div class="6u 12u$(mobile)"><input type="text" name="mdp" value="<?php echo $i->mdpAdmin?>"/></div>								
									</br></br></br>
									Compétence 3 : <div class="6u 12u$(mobile)"><input type="text" name="mdp" value="<?php echo $i->mdpAdmin?>"/></div>								
									</br></br></br>
									
								</div>
								</br>
									
<table>
<tr><td></td><td>Matin</td><td>Après-Midi</td></tr>
<tr><td>Lundi</td><td><input type="checkbox" name="presence[]" value="LunM" /></td><td><input type="checkbox" name="presence[]" value="LunA" /></td></tr>
<tr><td>Mardi</td><td><input type="checkbox" name="presence[]" value="MarM" /></td><td><input type="checkbox" name="presence[]" value="MarA" /></td></tr>
<tr><td>Mercredi</td><td><input type="checkbox" name="presence[]" value="MerM" /></td><td><input type="checkbox" name="presence[]" value="MerA" /></td></tr>
<tr><td>Jeudi</td><td><input type="checkbox" name="presence[]" value="JeuM" /></td><td><input type="checkbox" name="presence[]" value="JeuA" /></td></tr>
<tr><td>Vendredi</td><td><input type="checkbox" name="presence[]" value="VenM" /></td><td><input type="checkbox" name="presence[]" value="VenA" /></td></tr>
<tr><td>Samedi</td><td><input type="checkbox" name="presence[]" value="SamM" /></td><td><input type="checkbox" name="presence[]" value="SamA" /></td></tr>
</table>
								</br>
								<input type="hidden" name="verif" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Ajouter" />
								</div>
							</form>
						</div>

						
			</div>

	</body>
</html>