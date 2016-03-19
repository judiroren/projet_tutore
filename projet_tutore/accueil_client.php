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
								
		//if(isset($_SESSION["estConnecteClient"])) {
						
			if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
						
			} else {
				
			$connexion = connect();
			$nomE = $_GET['nomEntreprise'];
			$nomAffichage = str_replace(' ', '_', $nomE);

			//permet de récuperer les infos de connexion
			$i = infosEntreprise();
				
			//récupère la liste des prestations de l'entreprise
			$prest = listePrestations();

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
					if( $_POST['login'] == $j->login_client && $_POST['mdp'] == $j->mdp_client ) {
						$_SESSION["client"] = $j->id_client;
						$_SESSION["estConnecteClient"] = 1;
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
		}
	}
//	}


?>

<html>
	<head>
		<title>Portail de réservation : Accueil BackOffice</title>
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
								
								if(isset($_SESSION["estConnecteClient"])) {
						
									if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
						
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
							<p>Page de gestion de l'entreprise</p>
							
							<?php 
							}	
							}
							}
							
							if(!isset($_GET['nomEntreprise'])) {
		
							} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
								
							} else {
								
								//if(isset($_SESSION["estConnecteClient"])) {
						
									if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
									} else {
							
							if(isset($_SESSION["estConnecteClient"])) {
								
							?>
								<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="profil.php?nomEntreprise=<?php echo $nomE ?>"> Accéder à son profil </a></br>
								<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> Réserver </a></br></br>
								<a href="destruct_session_client.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>
							</div>
							
							<?php
							
								} else {
							
							?>
						</div>
						<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
						<a href="inscription.php?nomEntreprise=<?php echo $nomE ?>"> S'inscrire </a></br>
						<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> Réserver </a></br></br>
						<form method="post" action="">
								<div class="row">
									<div class="6u 12u$(mobile)"><input type="text" name="login" placeholder="Login" required/></div>
									</br></br></br>
									<div class="6u 12u$(mobile)"><input type="password" name="mdp" placeholder="Mot de passe" required/></div>				
								</div>
								</br>
								<div align = "center" class="12u$">
									<input type="submit" name ="connecte" value="Connection" />
								</div>
							</form>
							
							<?php 
							
								}
								}
							}
						//	}
								
							?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<div class="container">
				<!-- Intro -->
					<h1>Page d'accueil front-office <br>Client
					<?php 
								
					if(!isset($_GET['nomEntreprise'])) {
						
						echo "<h2>Le nom de l'entreprise doit être rajouté dans l'url à la suite sous la forme : ?nomEntreprise=nom.</h2>";
		
					} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
						
						echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</h2>";	
						
					} else {			
					
						//if(isset($_SESSION["estConnecteClient"])) {
						
							if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<h2>Vous devez d'abord vous connectez sur le coté client de cette entreprise </h2>";
						
							} else {
					
					
					?>
					<h2><?php
					echo $i->nomEntreprise?></h2>
					<p align="center"><?php echo $i->adresseEntreprise?><br/>
					Tel :<?php echo $i->telEntreprise?></p>
			
				<p><?php echo $i->descEntreprise ?></p>
				<h3 align="center">les prestations de <?php echo $i->nomEntreprise?> :</h3>
							<table>
							<tr><td>Description</td><td>Prix</td><td>Payable Paypal</td><td>Durée</td></tr>
							<?php 
							if($prest != null){
								while ($unePrest = $prest->fetch(PDO::FETCH_OBJ)){
									$unePresta = infosPrestation($unePrest->id_presta);
									echo "<tr><td>$unePresta->descriptif_presta</td>
											  <td>$unePresta->cout €</td>
											  <td>";
									if ($unePresta->paypal >= 1 ) {
										echo "oui";
									}else{
										echo"non";
									}
									echo "</td>
										  <td>$unePresta->duree min</td></tr>";
								}
							}
						} 
						
					}
				//	}
						?>
							</table>
			</div>
		</div>
	</body>
</html>