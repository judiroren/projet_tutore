<!DOCTYPE HTML>
<?php
try {
	$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" );
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connexion �chou�e : ' . $e->getMessage();
}

$nom=$_GET['nomEntreprise'];
$rqt = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nom.'"');
$i = $rqt->fetch(PDO::FETCH_OBJ);
$nomE = $i->nomEntreprise;
?>

<html>
	<head>
		<title>Portail de r�servation : Accueil BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							
							<h1><?php echo $nomE?></h1>
							<p>Page d'accueil</p>
						</div>
						<form method="post" action="accueil_backoffice.php">
								<div class="row">
									<div class="6u 12u$(mobile)"><input type="text" name="login" placeholder="Login" /></div>
									</br></br></br>
									<div class="6u 12u$(mobile)"><input type="text" name="mdp" placeholder="Mot de passe" /></div>
								</div>
								</br>
								<div align = "center" class="12u$">
									<input type="submit" value="Connection" />
								</div>
							</form>
								

				</div>

				<div class="bottom">

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