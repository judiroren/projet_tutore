<!DOCTYPE HTML>
<?php
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
						<?php if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
						} ?>
							<h1><?php echo $nomE?></h1>
							<p>Page de gestion de l'entreprise</p>
							<?php 
							if(!empty($_POST['login']) && !empty($_POST['mdp']) && $_POST['login']==$i->loginAdmin && $_POST['mdp']==$i->mdpAdmin ){
							?>
								<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
								<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
								<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
								<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>
							<?php
							}else{
							
							?>
						</div>
						<form method="post" action="">
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
							<?php } ?>

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