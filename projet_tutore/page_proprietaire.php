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
							<form method="post" action="resume_inscrip.php" class="formulaire">
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
									<input type="submit" value="Valider" />
								</div>
							</form>

						</div>

			</div>

	</body>
</html>