<!DOCTYPE HTML>
<?php
	//import des fichiers requis
	require "fonctions.inc.php";
	
	require "bd.inc.php";
	//$connexion = connect();
	//$nom=$_GET['nomEntreprise'];

	//récupération des infos
	$i = infosEntreprise();

	$nomE = $i->nomEntreprise;
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
							
							<?php 
							
							if(isset($_SESSION["estConnecte"])) {
								
							?>
							
								<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								
							</div>
							
							<?php
							
								} else {
							
							?>
						</div>
						<form method="post" action="">
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
							<?php } ?>

				</div>


			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">

							
						</div>

						
			</div>

	</body>
</html>