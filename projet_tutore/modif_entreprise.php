<!DOCTYPE HTML>
<?php
require "fonction.inc.php";

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

if(isset($_POST['verif'])){
	if($nomE != $_POST['nom']){
		$url = "http://localhost/projet_tutore/projet_tutore/accueil_backoffice.php?nomEntreprise=".$_POST['nom'];
	}
		$connexion->exec("UPDATE entreprise SET nomEntreprise = '".$_POST['nom']."', mailEntreprise = '".$_POST['mail']."', telEntreprise = '".$_POST['tel']."', adresseEntreprise = '".$_POST['adresse']."', logoEntreprise = '".$_POST['logo']."', descEntreprise = '".$_POST['descrip']."', loginAdmin = '".$_POST['login']."', mdpAdmin = '".$_POST['mdp']."' WHERE nomEntreprise = '".$nomE."'");
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
							<h1>Modification des informations de l'entreprise</h1>
							<?php 
							if(isset($_POST['verif'])){
								echo "<p> Changement effectué </p>";
								if(isset($url)){
									echo "<p> Nouvelle Url : <a href='".$url."'>".$url."</a>";							
								}
							}
							?>
							<form method="post" action="">
								<div class="row">
								</br>
									Nom : <div class="6u 12u$(mobile)"><input type="text" name="nom" value="<?php echo $nomE?>"/></div>
									</br></br></br>
									E-mail : <div class="6u 12u$(mobile)"><input type="text" name="mail" value="<?php echo $i->mailEntreprise?>" /></div>			
									</br></br></br>
									Téléphone : <div class="6u 12u$(mobile)"><input type="text" name="tel" value="<?php echo $i->telEntreprise?>"/></div>				
									</br></br></br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" value="<?php echo $i->adresseEntreprise?>"/></div>	
									</br></br></br>
									URL du logo : <div class="6u 12u$(mobile)"><input type="text" name="logo" value="<?php echo $i->logoEntreprise?>"/></div>				
									</br></br></br>
								Compte administrateur :	</br>
									Login : <div class="6u 12u$(mobile)"><input type="text" name="login" value="<?php echo $i->loginAdmin?>"/></div>				
									</br></br></br>
									Mot de passe : <div class="6u 12u$(mobile)"><input type="text" name="mdp" value="<?php echo $i->mdpAdmin?>"/></div>								
									</br></br></br>
								Description de l'entreprise : <div class="6u 12u$(mobile)"><textarea name="descrip" ><?php echo $i->descEntreprise?></textarea></div>				
									<input type="hidden" name="verif" value="ok"> 
								</div>
								</br>
								<div align = "center" class="12u$">
									<input type="submit" value="Valider" />
								</div>
							</form>
						</div>

						
			</div>

	</body>
</html>