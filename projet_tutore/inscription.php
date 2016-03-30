<?php

	session_start();
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	
	if(!isset($_GET['nomEntreprise'])) {
		
	} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
		
	} else {
		
		$connexion = connect();
		$nomE = $_GET['nomEntreprise'];
		$nomAffichage = str_replace(' ', '_', $nomE);

		//permet de récuperer les infos de connexion
		$i = infosEntreprise();
		
		//Les informations doivent être correcte
		if( !empty($_POST['login']) && !empty($_POST['mdp']) ) {
			//récupération des infos de connexion des clients
			$j = logClient($_POST['login'], $_POST['mdp']);
			if($j!=null){
				if( $_POST['login'] == $j->login_client && $mdp == $j->mdp_client ) {
					$_SESSION["client"] = $j->id_client;
					$_SESSION["estConnecte"] = 1;
					$_SESSION["nomSession"] = $_GET['nomEntreprise'];
					
				}
			}
		}
		if(isset($_SESSION['prestListe'])){
			unset($_SESSION['prestListe']);
		}
		if(isset($_SESSION['date'])){
			unset($_SESSION['date']);
		}
		if(isset($_SESSION['heure'])){
			unset($_SESSION['heure']);
		}
		if(isset($_SESSION['duree'])){
			unset($_SESSION['duree']);
		}
		if(isset($_SESSION['prix'])){
			unset($_SESSION['prix']);
		}

		if(isset($_POST['valide'])){
			if(existeLoginClient($_POST['loginClient'])==0){
				$_SESSION['loginClient'] = $_POST['loginClient'];
				$_SESSION['mdpClient'] = $_POST['mdpClient'];
				$_SESSION['mailClient'] = $_POST['mailClient'];
				$_SESSION['nomClient'] = $_POST['nomClient'];
				$_SESSION['prenomClient'] = $_POST['prenomClient'];
				header('Location: inscriptionClient_valide.php?nomEntreprise='.$nomE);
			}else{
				$erreur = 1;
			}
		}
	}

?>

<html>
	<head>
		<title>Portail de réservation : Inscription client</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
						
						<?php 
						
							if(!isset($_GET['nomEntreprise'])) {
		
							} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
		
							} else {
						
							if($i->logoEntreprise !="") {
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
						?>
							<h1>
							<?php 
							
								echo $nomAffichage;
							?>
							</h1>
							<p>Page d'inscription client</p>
							
						</div>
						<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
						<a href="inscription.php?nomEntreprise=<?php echo $nomE ?>"> S'inscrire </a></br>
						<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> Réserver </a></br></br>
						<form method="post" action="accueil_client.php?nomEntreprise=<?php echo $nomE;?>">
								<div class="row">
									<div class="6u 12u$(mobile)"><input type="text" name="login" placeholder="Login" /></div>
									</br></br></br>
									<div class="6u 12u$(mobile)"><input type="password" name="mdp" placeholder="Mot de passe" /></div>				
								</div>
								</br>
								<div align = "center" class="12u$">
									<input type="submit" name ="connecte" value="Connection" />
								</div>
							</form>

						<?php
							}
						?>
			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">
				<h1>Inscription d'un client :</h1>
				
				<?php
				if(isset($erreur)){
					echo "Login déjà pris. Veuillez en prendre un autre";
				}
				if(!isset($_GET['nomEntreprise'])) {
								
					echo "<h2>Le nom de l'entreprise doit être rajouté dans l'url à la suite sous la forme : ?nomEntreprise=nom.</h2>";
								
				} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
								
					echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</h2>";
								
				} else {
								
				?>				
				
				<form method="post" action="" class="formulaire">
					</br>
					Nom du client :<div class="6u 12u$(mobile)"><input type="text" name="nomClient" required/></div>
					</br>
					Prénom du client :<div class="6u 12u$(mobile)"><input type="text" name="prenomClient" required/></div>
					</br>
					Adresse mail : <div class="6u 12u$(mobile)"><input type="email" name="mailClient" required/></div>
					</br>
					Login :<div class="6u 12u$(mobile)"><input type="text" name="loginClient" required/></div>
					</br>
					Mot de passe : <div class="6u 12u$(mobile)"><input type="password" name="mdpClient" required/></div>
				</br>
				<div align = "center" class="12u$">
				<input type="submit" value="Valider" />
				</div>
				</form>
							<?php } ?>
			</div>
		</div>
	</body>
</html>