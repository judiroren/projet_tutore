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
		
	/*} else if (!isset($_SESSION["nomSession"])) {*/
		
	} else {
		
	$_SESSION["nomE"] = $_GET['nomEntreprise'];	
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$nomE = str_replace(' ', '_', $nomE);

	//permet de récuperer les infos de connexion
	$i = infosEntreprise();
	
	//récupère la liste des prestations de l'entreprise
	$prest = listePrestations();

	$catego = listeCategorie();
	
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

	
	if(isset($_POST['categorie'])){
		$categActuelle = $_POST['categorie'];
		if(!empty($_POST['choix'])){
			if(!isset($_SESSION["prestListe"])){
				$_SESSION["prestListe"] = $_POST['choix'];
			}else{
				foreach($_POST['choix'] as $val){
					if(!in_array($val,$_SESSION["prestListe"])){
						array_push($_SESSION["prestListe"],$val);
					}
				}
				foreach($_SESSION["prestListe"] as $val){
					$c = getCategorie($val);
					$categAncienne = getCategorie($_POST['choix'][0]);
					if($c->categorie==$categAncienne){
						if(!in_array($val,$_POST['choix'])){
							unset($_SESSION["prestListe"][array_search($val, $_SESSION["prestListe"])]);
						}
					}
				}
			}
			
		}else{
			if(!empty($_SESSION["prestListe"])){
				foreach($_SESSION["prestListe"] as $val){
					$c = getCategorie($val);
					if($c->categorie==$_POST['categAncienne']){
						unset($_SESSION["prestListe"][array_search($val, $_SESSION["prestListe"])]);
					}
				}	
			}
		}
	}
	
	$erreur = 0;
	if(isset($_POST['reserv'])){
		if(empty($_POST['choix']) && empty($_SESSION['prestListe'])){
			$erreur = 1;
		}else if(!empty($_POST['choix']) && empty($_SESSION['prestListe'])){
			$liste = employeOk($_POST['choix']);
			if($liste->rowCount()!=0){
				$_SESSION["employeRes"] = $liste->employe;
				$_SESSION["prestListe"] = $_POST['choix'];
				header('Location: dateReserv.php?nomEntreprise='.$nomE);
			}else{
				$erreur = 2;
			}
		}else if(!empty($_POST['choix'])){
			foreach($_POST['choix'] as $val){
				if(!in_array($val,$_SESSION["prestListe"])){
					array_push($_SESSION["prestListe"],$val);
				}
			}
			foreach($_SESSION["prestListe"] as $val){
				$c = getCategorie($val);
				if($c->categorie==$categAncienne){
					if(!in_array($val,$_POST['choix'])){
						unset($_SESSION["prestListe"][array_search($val, $_SESSION["prestListe"])]);
					}
				}
			}
			$liste = employeOk($_SESSION["prestListe"]);
			if($liste->rowCount()!=0){
				$_SESSION["employeRes"] = $liste->employe;
				header('Location: dateReserv.php?nomEntreprise='.$nomE);
			}else{
				$erreur = 2;
			}
		}else{
			$liste = employeOk($_SESSION["prestListe"]);
			if($liste->rowCount()!=0){
				$_SESSION["employeRes"] = $liste->employe;
				header('Location: dateReserv.php?nomEntreprise='.$nomE);
			}else{
				$erreur = 2;
			}
		}
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
							
							<?php } } ?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">
	
					<center><h1>Réservation</h1></center>
					<?php 
					
					if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
					echo "<h2>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</h2>";
								
				} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
					echo "<h2>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</h2>";
								
				} else {
					
						if($erreur==1 && empty($_SESSION["prestListe"])){
							echo "Vous devez sélectionnez au moins une prestation pour faire une réservation !</br>";	
						}else if($erreur == 2){
							echo "Aucun employé ne peut satisfaire votre demande ! Veuillez changer vos prestations !</br>";
						}	
					?>
					
					<?php 
					if(!empty($_SESSION["prestListe"])){
						echo "Prestations choisies :</br>";
						foreach($_SESSION["prestListe"] as $val){
							$info = infosPrestation($val);
							echo "$info->descriptif_presta $info->categorie, $info->duree minutes ($info->cout €)</br>";
						}
					}
					?>
					<form method="post" action="">
						Catégorie : <div class="6u 12u$(mobile)"><select name="categorie">
						<option value=""></option>
						<?php while($donnees = $catego->fetch(PDO::FETCH_OBJ)){
							echo "<option value='$donnees->categorie'>$donnees->categorie</option>";
						}?>
						</select></div></br>
						<input type="submit" name="ChoixCat" value="Choisir"/></br></br>
						Liste des prestations possibles : </br>
						<table>
							<tr><td>Choix</td><td>Description</td><td>Prix</td><td>Payable Paypal</td><td>Durée</td></tr>
							<?php 
							if($prest != null){
								while ($unePrest = $prest->fetch(PDO::FETCH_OBJ)){
									if(isset($_POST['categorie'])){
										?>
										<input type="hidden" name="categAncienne" value="<?php echo $_POST['categorie'];?>">
										<?php 
										if($unePrest->categorie == $_POST['categorie']){
											if(!empty($_SESSION['prestListe']) && in_array($unePrest->id_presta, $_SESSION['prestListe'])){
												echo "<tr><td> <input type='checkbox' name='choix[]' value='$unePrest->id_presta' checked='checked'></td>";
											}else{
												echo "<tr><td> <input type='checkbox' name='choix[]' value='$unePrest->id_presta' ></td>";
											}
											
											$unePresta = infosPrestation($unePrest->id_presta);
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
									}else{
										$p = "'".$unePrest->id_presta."'";
										if(!empty($_SESSION['prestListe']) && in_array($p, $_SESSION['prestListe'])){
												echo "<tr><td> <input type='checkbox' name='choix[]' value='$unePrest->id_presta' selected='selected'></td>";
												echo "hey";
											}else{
												echo "<tr><td> <input type='checkbox' name='choix[]' value='$unePrest->id_presta' ></td>";
											}
										$unePresta = infosPrestation($unePrest->id_presta);
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
							}

							?>
							</table>
							<input type="hidden" name="ajout" value="ok"> 
							<div align = "center" class="12u$">
								<input type="submit" name="reserv" value="Réserver" />
							</div>
					</form>

							<?php } ?>
			</div>
		</div>
	</body>
</html>