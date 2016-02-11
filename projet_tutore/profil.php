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
		echo "<p>Le nom de l'entreprise doit �tre renseign� dans l'url sous la forme ?nomEntreprise=nom.</p>";
	}
	
?>
<!DOCTYPE HTML>
<?php
	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donn�e</p>";
		
	} else {
		
	$_SESSION["nomE"] = $_GET['nomEntreprise'];	
	
	$connexion = connect();
	$nomE = $_GET['nomEntreprise'];
	//$nomE = str_replace(' ', '_', $nomE);

	if(isset($_POST['verif'])){
		if(!empty($_POST['mdp'])){
			if($_POST['mdp']==$_POST['mdp2']){
				modifClientMdp($connexion, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['login'], $_POST['mdp']);
			}else{
				$erreur = 1;
			}
		}else{
			modifClient($connexion, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['login']);
		}
	}
	//permet de r�cuperer les infos de connexion
	$i = infosEntreprise();
	
	//r�cup�ration des infos du client
	$infoC = infosClients();
	
	//R�cup�ration des r�servations du client
	$reserv = reservClient();

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
							
								<a href="accueil_client.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="profil.php?nomEntreprise=<?php echo $nomE ?>"> Acc�der � son profil </a></br>
								<a href="reservation.php?nomEntreprise=<?php echo $nomE ?>"> R�server </a></br></br>
								<a href="destruct_session_client.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>
							</div>
							

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">

				<?php 
				if(isset($erreur)){
					echo "Si vous changez de mot de passe, saisissez le nouveau dans les 2 champs !";	
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
				R�servation effectu�es : </br>
				<table>
				<tr><td>R�servation</td><td>Date</td><td>Heure</td><td>Employe</td><td>Prix</td><td>Pay�</td></tr>
				
				<?php 
					while($donnees = $reserv->fetch(PDO::FETCH_OBJ))
					{	
						$identite = $donnees->nom_employe." ".$donnees->prenom_employe;
						$paye = $donnees->paye=='1'?'oui':'non';
						echo "<tr>";
						echo "<td>".$donnees->descriptif_presta."</td>";
						echo "<td>".$donnees->date."</td>";
						echo "<td>".$donnees->heure."</td>";
						echo "<td>".$identite."</td>";
						echo "<td>".$donnees->prix."</td>";
						echo "<td>".$paye."</td>";
						echo "</tr>";
					}
				?>
				</table>
				<?php } ?>
			</div>
		</div>
	</body>
</html>