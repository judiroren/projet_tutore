<?php

	session_start();
	
	try {
		
		if(isset($_GET['nomEntreprise'])) {
			$_SESSION["nomE"] = $_GET['nomEntreprise'];
		} else {
			$_SESSION["nomE"] = "Nom de l'entreprise non sp�cifi�e";
		}
	} catch(Exception $e){
		
	}
	
?>
<!DOCTYPE HTML>
<?php

	require "fonctions.inc.php";
	require "bd.inc.php";
	
	
	if( $_SESSION["nomE"] == "Nom de l'entreprise non sp�cifi�e" ) {
		
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else {
		
		$_SESSION["nomE"] = $_GET['nomEntreprise'];	
		
		$connexion = connect();
		$nomE = $_GET['nomEntreprise'];
		//$nomE = str_replace(' ', '_', $nomE);

		//permet de r�cuperer les infos de connexion
		$i = infosEntreprise();
		
		//r�cup�re la liste des prestations de l'entreprise
		$prest = listePrestations();

		//Le mot de passe doit �tre renseigner
		if(isset($_POST['mdp'])) {
			
			//$mdp = md5($_POST['mdp']);
			$mdp = $_POST['mdp'];
		} 
		
		//Les informations doivent �tre correcte
		if( !empty($_POST['login']) && !empty($_POST['mdp']) ) {
			//r�cup�ration des infos de connexion des clients
			$j = logClient($_POST['login'], $_POST['mdp']);
			if( $_POST['login'] == $j->login_client && $_POST['mdp'] == $j->mdp_client ) {
				$_SESSION["client"] = $j->id_client;
				$_SESSION["estConnecte"] = 1;
				$_SESSION["nomSession"] = $_GET['nomEntreprise'];
				
			}
		}
	
	}


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
						
						<?php 
						
							if( $_SESSION["nomE"] == "Nom de l'entreprise non sp�cifi�e" ) {
								
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
							
							<?php 
							}
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non sp�cifi�e" ) {
								
								} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
								} else {
							
							if(isset($_SESSION["estConnecte"])) {
								
							?>
								<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="profil.php?nomEntreprise=<?php echo $nomE ?>"> Acc�der � son profil </a></br>
								<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> R�server </a></br></br>
								<a href="destruct_session_client.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>
							</div>
							
							<?php
							
								} else {
							
							?>
						</div>
						<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
						<a href="inscription.php?nomEntreprise=<?php echo $nomE ?>"> S'inscrire </a></br>
						<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> R�server </a></br></br>
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
							
							<?php 
							
								}
								}	
								
							?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<div class="container">
				<!-- Intro -->
					<h1>Page d'accueil front-office <br>Client
					<?php 
					
					if( $_SESSION["nomE"] == "Nom de l'entreprise non sp�cifi�e" ) {
									
						echo "<p>Le nom de l'entreprise doit �tre renseign� dans l'url sous la forme ?nomEntreprise=nom.</p>";
								
					} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
						echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donn�e</p>";
		
					} else {
					
					?>
					<h2><?php
					echo $i->nomEntreprise?></h2>
					<p align="center"><?php echo $i->adresseEntreprise?><br/>
					Tel :<?php echo $i->telEntreprise?></p>
			
				<p><?php echo $i->descEntreprise ?></p>
				<h3 align="center">les prestations de <?php echo $i->nomEntreprise?> :</h3>
							<table>
							<tr><td>Description</td><td>Prix</td><td>Payable Paypal</td><td>Dur�e</td></tr>
							<?php 
							if($prest != null){
								while ($unePrest = $prest->fetch(PDO::FETCH_OBJ)){
									$unePresta = infosPrestation($unePrest->id_presta);
									$unePresta = $unePresta->fetch(PDO::FETCH_OBJ);
									echo "<tr><td>$unePresta->descriptif_presta</td>
											  <td>$unePresta->cout �</td>
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
							?>
							</table>
			</div>
		</div>
	</body>
</html>