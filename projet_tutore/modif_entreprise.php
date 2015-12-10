<?php
session_start();
?>
<!DOCTYPE HTML>
<?php

require "fonctions.inc.php";
$connexion = connect();

$nom=$_GET['nomEntreprise'];
$rqt = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nom.'"');
$i = $rqt->fetch(PDO::FETCH_OBJ);
$nomE = $i->nomEntreprise;

if(isset($_POST['verif'])){
	if(!empty($_POST['mdp'])){
		$mdp = md5($_POST['mdp']);
		$connexion->exec("UPDATE entreprise SET mailEntreprise = '".$_POST['mail']."', telEntreprise = '".$_POST['tel']."', adresseEntreprise = '".$_POST['adresse']."', logoEntreprise = '".$_POST['logo']."', descEntreprise = '".$_POST['descrip']."', loginAdmin = '".$_POST['login']."', mdpAdmin = '".$mdp."' WHERE nomEntreprise = '".$nomE."'");
	}else{
		$connexion->exec("UPDATE entreprise SET mailEntreprise = '".$_POST['mail']."', telEntreprise = '".$_POST['tel']."', adresseEntreprise = '".$_POST['adresse']."', logoEntreprise = '".$_POST['logo']."', descEntreprise = '".$_POST['descrip']."', loginAdmin = '".$_POST['login']."' WHERE nomEntreprise = '".$nomE."'");
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
							<p>Modification des informations de l'entreprise</p>
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
						
							<h1>Modification des informations de l'entreprise</h1>
							<?php 
							if(isset($_POST['verif'])){
								echo "<p> Changement effectué </p>";
							}
							?>
							<form method="post" action="">
								</br>
									<h3>Compte administrateur :	</h3></br>
									Login : <div class="6u 12u$(mobile)"><input type="text" name="login" value="<?php echo $i->loginAdmin?>"/></div>				
									</br>
									Mot de passe : <div class="6u 12u$(mobile)"><input type="text" name="mdp" /></div>								
									</br>
									<h3>Informations générale : </h3></br>
									E-mail : <div class="6u 12u$(mobile)"><input type="text" name="mail" value="<?php echo $i->mailEntreprise?>" /></div>			
									</br>
									Téléphone : <div class="6u 12u$(mobile)"><input type="text" name="tel" value="<?php echo $i->telEntreprise?>"/></div>				
									</br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" value="<?php echo $i->adresseEntreprise?>"/></div>	
									</br>
									URL du logo : <div class="6u 12u$(mobile)"><input type="text" name="logo" value="<?php echo $i->logoEntreprise?>"/></div>				
									</br>
									Description de l'entreprise : <div class="6u 12u$(mobile)"><textarea name="descrip" ><?php echo $i->descEntreprise?></textarea></div>				
								
								
									<input type="hidden" name="verif" value="ok"> 
								
								</br>
								<div align = "center" class="12u$">
									<input type="submit" value="Valider" />
								</div>
							</form>
						</div>

						
			</div>

	</body>
</html>