<?php

	session_start();
	
	try {
		
		if(isset($_GET['nomEntreprise'])) {
			$_SESSION["nomE"] = $_GET['nomEntreprise'];
		} else {
			$_SESSION["nomE"] = "Nom de l'entreprise non spécifiée";
		}
	} catch(Exception $e){
		
	}
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	
	if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if (!isset($_SESSION["nomSession"])) {
		
	} else {
		
		$_SESSION["nomE"] = $_GET['nomEntreprise'];	
		
		$connexion = connect();
		$nomE = $_GET['nomEntreprise'];
		//$nomE = str_replace(' ', '_', $nomE);

		//permet de récuperer les infos de connexion
		$i = infosEntreprise();
		
		

		//Le mot de passe doit être renseigner
		if(isset($_POST['mdp'])) {
			
			//$mdp = md5($_POST['mdp']);
			$mdp = $_POST['mdp'];
		} 
		
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
						
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
							} else {
						
							if($i->logoEntreprise !="") {
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
						?>
							<h1>
							<?php 
							
								echo $nomE;
							?>
							</h1>
							<p>Page de gestion de l'entreprise</p>
							
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
				
				if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
					echo "<h2>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</h2>";
								
				} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
					echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</h2>";
								
				} else {
								
				?>				
				
				<form method="post" action="inscriptionClient_valide.php?nomEntreprise=<?php echo $nomE ?>" class="formulaire">
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