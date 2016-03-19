<?php

	session_start();
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	if(!isset($_GET['nomEntreprise'])) {
		
	} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
								
	} else {
								
		if(isset($_SESSION["estConnecteClient"])) {
						
			if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
						
			} else {
		
	$_SESSION["nomE"] = $_GET['nomEntreprise'];	
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	$nomAffichage = str_replace(' ', '_', $nomE);

	if(isset($_POST['verif'])){
		if(!empty($_POST['mdp'])){
			if($_POST['mdp']==$_POST['mdp2']){
				modifClientMdp($connexion, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['login'], $_POST['mdp']);
				$ok = 1;
			}else{
				$erreur = 1;
			}
		}else{
			modifClient($connexion, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['login']);
		}
		$ok = 1;
	}
	//permet de r�cuperer les infos de connexion
	$i = infosEntreprise();
	
	//r�cup�ration des infos du client
	$infoC = infosClients();
	
	//R�cup�ration des r�servations du client
	$reserv = reservClient();
	
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
	} } }

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
							
								<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="profil.php?nomEntreprise=<?php echo $nomE ?>"> Acc�der � son profil </a></br>
								<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> R�server </a></br></br>
								<a href="destruct_session_client.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>
							</div>
							
						<?php
							} } }
						?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">
			<h1>Page de gestion du profil client :</h1>
			
				<?php 
				
				if(!isset($_GET['nomEntreprise'])) {
						
						echo "<h2>Le nom de l'entreprise doit �tre rajout� dans l'url � la suite sous la forme : ?nomEntreprise=nom.</h2>";
		
					} else if( verifEntreprise($_GET['nomEntreprise']) == null ) {
						
						echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donn�e</h2>";	
						
					} else {			
					
						if(isset($_SESSION["estConnecteClient"])) {
						
							if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<h2>Vous devez d'abord vous connectez sur le cot� client de cette entreprise </h2>";
						
							} else {
				
				if(isset($erreur)){
					echo "Si vous changez de mot de passe, saisissez le nouveau dans les 2 champs !";	
				}
				if(isset($ok)){
					echo "Changement r�ussi";	
				}
					
				?>
				<form method="post" action="">
				</br>
					<h3>Compte :	</h3>
					Login : <div class="6u 12u$(mobile)"><input type="text" name="login" value="<?php echo $infoC->login_client?>"/></div>				
					</br>
					Nouveau mot de passe (ne rien mettre pour garder l'ancien) : <div class="6u 12u$(mobile)"><input type="password" name="mdp" /></div>								
					</br>
					Confirmer nouveau mot de passe (remplir seulement si changement) : <div class="6u 12u$(mobile)"><input type="password" name="mdp2" /></div>								
					</br>
					<h3>Informations g�n�rale : </h3>
					Nom : <div class="6u 12u$(mobile)"><input type="text" name="nom" value="<?php echo $infoC->nom_client?>"/></div>	
					</br>
					Pr�nom : <div class="6u 12u$(mobile)"><input type="text" name="prenom" value="<?php echo $infoC->prenom_client?>"/></div>				
					</br>
					E-mail : <div class="6u 12u$(mobile)"><input type="email" name="mail" value="<?php echo $infoC->mail?>" /></div>			

					<input type="hidden" name="verif" value="ok"> 
					</br>
						<div align = "center" class="12u$">
						<input type="submit" value="Modifier" />
					</div>
				</form>
				</br>
				<h3>R�servation effectu�es : </h3>
							
				<?php 
					while($donnees = $reserv->fetch(PDO::FETCH_OBJ))
					{	
						$identite = $donnees->nom_employe." ".$donnees->prenom_employe;
						$paye = $donnees->paye=='1'?'Paiement d�j� effectu�':'Paiement non effectu�';
						echo "<strong><h4>R�servation du ".$donnees->date." a ".$donnees->heure." : </strong></h4>";
						echo "Employ� : ".$identite."</br>";
						echo "Prix : ".$donnees->prix." ( ".$paye." )</br>";
						echo "Prestations : </br>";
						$prest = prestaReserv($donnees->id_reserv);
						while($donnees2 = $prest->fetch(PDO::FETCH_OBJ)){
							echo $donnees2->descriptif_presta." ( ".$donnees2->prix." � )";
						}
						echo "</br></br>";
					}
				?>
				
					<?php } } } ?>
			</div>
		</div>
	</body>
</html>