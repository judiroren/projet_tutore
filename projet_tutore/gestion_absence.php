<?php

	session_start();
	
?>

<!DOCTYPE HTML>

<?php
 
	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	$nomE = $_SESSION["nomSession"];
	$connexion = connect();
	
	if( $_SESSION["nomE"] == null ) {
		
		echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
		
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
		echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
		
	} else {
	
	$i = infosEntreprise();

	$employe = infosEmploye();
	
	$listeAbs = listeAbscences();

	if (isset($_POST['ajout'])) {
		
		$erreurNbAbs = 0;
		$cpt = 0;
		
		while($val=$listeAbs->fetch(PDO::FETCH_OBJ)) {
			
			$cpt++;
		}
		
		$prefixe = 'ABSC';
		$cpt++;
		
		if($cpt<9) {
			
			$code = $prefixe.'000'.$cpt;
		}else if($cpt<99){
			$code = $prefixe.'00'.$cpt;
		}else if($cpt<999){
			$code = $prefixe.'0'.$cpt;
		}else if($cpt<9999){
			$code = $prefixe.$cpt;
		}else{
			$erreurNbAbs = 1;
			
		}
		
		$ok = 0;
		$erreurDate = 0;
		$erreurReserv = 0;
		
		//Appel de la fonction pour savoir si l'employé possède une reséervation durant le temps de l'absence
		$reserv = dateReservation($_POST['employe_absent'], $_POST['debut'], $_POST['fin']);
		
		if($_POST['debut']>$_POST['fin']) {
			
			$erreurDate = 1;
			
		} else if ($reserv == NULL) {
			
			$erreurReserv = 1;
		
		} else {
			
			$ok = 1;
			$fin = 0;
			
			//Appel de la fonction qui ajoute une réservation
			ajoutReservation($connexion, $code, $_POST['employe_absent'], $_POST['motif'], $_POST['debut'], $_POST['fin'], $fin);
			
		}
	}

?>

<html>
	<head>
		<title>Portail de réservation : BackOffice</title>
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
							<p>Gestion des absences</p>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
							<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
							<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
							<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
							<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
							<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>

						</div>
						
				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
						<div class="container">
							<h1>Gestion des absences des employés</h1>
							<?php 
							if(isset($_POST['ajout'])){
								if($erreurDate==1){
									echo "<p> Erreur : la date de début doit être inférieure à celle de fin !</p>";
								}
								if($erreurReserv==1){
									echo "<p> Erreur : L'employe à au moins une réservation de prévu sur cette période !</p>";
								}
								if($erreurNbAbs == 1){
									echo "<p> Erreur : Nombre d'absence max atteint !</p>";
								}
								if($ok==1){
									echo "<p> Ajout d'absence effectué </p>";
								}
								
							}
							
							?>
							</br>
							<h2>Ajout d'une absence</h2>
							<form method="post" action="">
								</br>
									<div class="6u 12u$(mobile)"><select name="employe_absent">
									<?php 
									while($donnees=$employe->fetch(PDO::FETCH_OBJ)){
										$identite = $donnees->nom_employe." ".$donnees->prenom_employe;
									?>
											Employe : <option value="<?php echo $donnees->id_employe;?>"> <?php echo $identite;?></option>
									<?php 
									}
									?>
									</select>
									</br>
									Motif de l'absence : <div class="6u 12u$(mobile)"><input type="text" name="motif"  /></div>			
									</br>
									Début de l'absence : <div class="6u 12u$(mobile)"><input type="date" name="debut"></div>
									</br>
									Fin de l'absence : <div class="6u 12u$(mobile)"><input type="date" name="fin"></div>
									</br>
									</div>
								</br>			
								<input type="hidden" name="ajout" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Ajouter" />
								</div>
							</form>
						</div>
						
						<?php
						
							}
						
						?>
						
			</div>

	</body>
</html>