<?php 
session_start();
require ("bd.inc.php");
if(isset($_POST['valide'])){
	if( $_POST['entreprise'] == null || $_POST['mail'] == null || $_POST['login'] == null || $_POST['mdp'] == null ) {
		$erreur = 2;	
	} else {
		if(existeLoginEntreprise($_POST['login'])==0){
			$_SESSION["entreprise"] = $_POST["entreprise"];
			$_SESSION["mail"] = $_POST["mail"];
			$_SESSION["login"] = $_POST["login"];
			$_SESSION["mdp"] = $_POST["mdp"];
			$_SESSION["creneau"] = $_POST["creneau"];
			header('Location: resume_inscrip.php');
		}else{
			$erreur = 1;
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Portail de réservation : Propriétaire</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							
							<h1> Portail de réservation</h1>
							<p>Page propriétaire</p>
						</div>

				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">
							
							<h1>Inscription d'une entreprise sur le portail</h1>
							<?php if(isset($erreur)){
								echo "Login déjà existant. Veuillez en changer !";
							}?>
							<form method="post" action="" class="formulaire">
									</br>
									Nom de l'entreprise :</br>
									<font size=3>format du champs : Seul les chiffres, lettres et espaces sont acceptés (ex : la boulangerie du 82)</font>
									<div class="6u 12u$(mobile)"><input type="text" pattern="[\w\s]+" name="entreprise" required/></div>
									</br>
									Login de l'administrateur :<div class="6u 12u$(mobile)"><input type="text" name="login" required/></div>
									</br>
									Mot de passe de l'administrateur : <div class="6u 12u$(mobile)"><input type="text" name="mdp" required/></div>
									</br>
									Adresse mail de l'administrateur : </br>
									<font size=3>format du champs : email classique avec un seul '@' et un seul '.' après l'@ (ex : truc.machin@hotmail.com)</font>
									<div class="6u 12u$(mobile)"><input type="email" name="mail" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+$" required/></div>
									</br>
									Type de créneau : </br>
									Libre : <input type="radio" name="creneau" value="1" checked="checked" /></br>
									Fixe : <input type="radio" name="creneau" value="0" /></br>
								<div align = "center" class="12u$">
									<input type="submit" name="valide" value="Valider" />
								</div>
							</form>

						</div>

			</div>

	</body>
</html>