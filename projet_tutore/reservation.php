<?php

	session_start();
	//$_SESSION["nomE"] = $_GET['nomEntreprise'];
	
	try {
		//$_SESSION["nomE"] = $_GET['nomEntreprise'];
		if($_GET['nomEntreprise'] != null) {
			$_SESSION["nomE"] = $_GET['nomEntreprise'];
		} else {
			throw new Exception("Notice: Undefined offset");
		}
	} catch(Exception $e){
		echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
	}
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	
	if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
		
	} else {
		
	$_SESSION["nomE"] = $_GET['nomEntreprise'];	
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$nomE = str_replace(' ', '_', $nomE);

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
	if( isset($_POST['login']) && isset($_POST['mdp']) ) {
		//récupération des infos de connexion des clients
		$j = logClient($_POST['login'], $_POST['mdp']);
		if( $_POST['login'] == $j->login_client && $mdp == $j->mdp_client ) {
			$_SESSION["client"] = $j->id_client;
			$_SESSION["estConnecte"] = 1;
			$_SESSION["nomSession"] = $_GET['nomEntreprise'];
			
		}
	}
	$erreur = 0;
	if(isset($_POST['ajout'])){
		if(!empty($_POST['choix'])){
			$liste = employeOk($_POST['choix']);
			if($liste->rowCount()!=0){
				$_SESSION["employeRes"] = $liste->employe;
				$_SESSION["prestListe"] = $_POST['choix'];
				header('Location: dateReserv.php?nomEntreprise='.$nomE);
			}else{
				$erreur = 2;
			}
				
		}else{
			$erreur = 1;
		}
	}
	
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
	
					<center><h1>Réservation</h1></center>
					<?php 
						if($erreur==1){
							echo "Vous devez sélectionnez au moins une prestation pour faire une réservation !</br>";	
						}else if($erreur == 2){
							echo "Aucun employé ne peut satisfaire votre demande ! Veuillez changer vos prestations !";
						}	
					?>
					<form method="post" action="">
					Liste des prestations possibles : </br>
					<table>
							<tr><td>Choix</td><td>Description</td><td>Prix</td><td>Payable Paypal</td><td>Durée</td></tr>
							<?php 
							if($prest != null){
								while ($unePrest = $prest->fetch(PDO::FETCH_OBJ)){
									echo "<tr><td> <input type='checkbox' name='choix[]' value='$unePrest->id_presta'</td>";
									$unePresta = infosPrestation($unePrest->id_presta);
									$unePresta = $unePresta->fetch(PDO::FETCH_OBJ);
									echo "<td>$unePresta->descriptif_presta</td>
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

							?>
							</table>
							<input type="hidden" name="ajout" value="ok"> 
							<div align = "center" class="12u$">
								<input type="submit" value="Réserver" />
							</div>
					</form>

							<?php } ?>
			</div>
		</div>
	</body>
</html>