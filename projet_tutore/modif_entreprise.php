<?php
session_start();
?>
<!DOCTYPE HTML>
<?php

require "fonctions.inc.php";
$connexion = connect();

$nom=$_GET['nomEntreprise'];

$logo = '';
if(!empty($_POST['logo'])){
	$logo = 'images/'.$_POST['logo'];
}
if(isset($_POST['verif'])){
	if(isset($_POST['tel']) || !empty($_POST['mail']) || !empty($_POST['adresse'])){
		if(!empty($_POST['tel']) && strlen($_POST['tel'])==10 && is_numeric($_POST['tel'])){
			if(!empty($_POST['mail']) && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
				if(!empty($_POST['mdp'])){
					$mdp = md5($_POST['mdp']);
					$connexion->exec("UPDATE entreprise SET mailEntreprise = '".$_POST['mail']."', telEntreprise = '".$_POST['tel']."', adresseEntreprise = '".$_POST['adresse']."', logoEntreprise = '".$logo."', descEntreprise = '".$_POST['descrip']."', loginAdmin = '".$_POST['login']."', mdpAdmin = '".$mdp."' WHERE nomEntreprise = '".$nom."'");
				}else{
					$connexion->exec("UPDATE entreprise SET mailEntreprise = '".$_POST['mail']."', telEntreprise = '".$_POST['tel']."', adresseEntreprise = '".$_POST['adresse']."', logoEntreprise = '".$logo."', descEntreprise = '".$_POST['descrip']."', loginAdmin = '".$_POST['login']."' WHERE nomEntreprise = '".$nom."'");
				}
			}else{
				$mailErr=0;
			}
		}else{
			$telErr=0;
		}
	}else{
		$champErr=0;
	}

}
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
							<p>Modification des informations de l'entreprise</p>
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
						
							<h1>Modification des informations de l'entreprise</h1>
							<?php 
							if(isset($_POST['verif'])){
								if(isset($telErr)){
									echo "<p> Changement impossible : Numéro de téléphone incorrect ! </p>";
								}elseif(isset($mailErr)){
									echo "<p> Changement impossible : Adresse mail invalide ! </p>";
								}elseif(isset($champErr)){
									echo "<p> Changement impossible : Au moins 1 des 3 champs suivant doit être renseigné : numéro de téléphone, adresse postale, adresse mail ! </p>";
								}else{
									echo "<p> Changement effectué ! </p>";
								}
							}
							?>
							<form method="post" action="">
								</br>
									<h3>Compte administrateur :	</h3></br>
									Login : <div class="6u 12u$(mobile)"><input type="text" name="login" value="<?php echo $i->loginAdmin?>"/></div>				
									</br>
									Mot de passe (laissez vide pour garder le mot de passe courant): <div class="6u 12u$(mobile)"><input type="text" name="mdp" /></div>								
									</br>
									<h3>Informations générale : </h3></br>
									E-mail : <div class="6u 12u$(mobile)"><input type="text" name="mail" value="<?php echo $i->mailEntreprise?>" /></div>			
									</br>
									Téléphone : <div class="6u 12u$(mobile)"><input type="text" name="tel" value="<?php echo $i->telEntreprise?>"/></div>				
									</br>
									Adresse postale : <div class="6u 12u$(mobile)"><input type="text" name="adresse" value="<?php echo $i->adresseEntreprise?>"/></div>	
									</br>
									<?php 
									$tailleLogo = strlen($i->logoEntreprise)-7;
									$nomlogo = substr($i->logoEntreprise, -$tailleLogo);
									?>
									Logo (nom du logo. Ce dernier doit être dans le dossier images): <div class="6u 12u$(mobile)"><input type="text" name="logo" value="<?php echo $nomlogo ?>"/></div>				
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