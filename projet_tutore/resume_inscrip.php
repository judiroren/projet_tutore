<!DOCTYPE HTML>
<?php
	try {
		$connexion = new PDO("mysql:dbname=portail_reserv;host=localhost", "root", "" ); 	
		$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMessage();
	}
	
	$treserv = $_POST['entreprise']."_reserv";
	$temploye = $_POST['entreprise']."_employe";
	$tprestation = $_POST['entreprise']."_prestation";
	//$connexion->exec("INSERT INTO entreprise(nomEntreprise, mailEntreprise, loginAdmin, mdpAdmin) VALUES ('".$_POST['entreprise']."', '".$_POST['mail']."', '".$_POST['login']."', '".$_POST['mdp']."')");
   try{
   	print_r($_POST);
	$stmt =  $connexion->prepare("CREATE TABLE ".$treserv." ( test CHAR(10) PRIMARY KEY)");
   //$stmt->bindValue(1, $treserv);
   $stmt->execute();
   } catch (Exception $e) {
   echo	$e->getMessage();
   }
?>

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

					<!-- Social Icons -->
						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
							<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
							<li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
						</ul>

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					
						<div class="container">

							<p> Tables de l'entreprise <?php echo $_POST['entreprise'];?> créé </p>
								
						</div>

						
			</div>

	</body>
</html>