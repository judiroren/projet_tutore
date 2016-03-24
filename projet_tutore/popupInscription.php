<!DOCTYPE HTML>
<?php

	session_start();
	
	require "fonctions.inc.php";
	require "bd.inc.php";
	
	$i = infosEntreprise();
	
	$connexion = connect();
	
	$nomE = $_GET['nomEntreprise'];
	
	if( isset($_POST['nomClient']) && isset($_POST['mailClient']) && isset($_POST['prenomClient']) && isset($_POST['loginClient']) 
																										&& isset($_POST['mdpClient']) ) {
		//récupération des infos de connexion des clients
		
		$code = code($nomE."_client", 'id_client');	
		$id = $code;	
		$nomClient = $_POST['nomClient'];
		$prenomClient = $_POST['prenomClient'];
		$mail = $_POST['mailClient'];
		$login = $_POST['loginClient'];
			
		//faire fonction ajouter client
		ajoutClient($connexion, $id, $nomClient, $prenomClient, $mail, $login, $_POST['mdpClient'], $nomE);
	
		$_SESSION["estConnecte"] = 1;
		$_SESSION["nomSession"] = $_GET['nomEntreprise'];
		?>
			<SCRIPT language="javascript">
				javascript:parent.opener.location.reload();
				window.close();
			</SCRIPT>
		<?php	
		}
?>


<html>

	<head>
	
		<title>Popup d'inscription : </title>
		
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	
	<body>
				<p>Inscrivez-vous :</p>
								
						<form method="post" action="inscriptionClient_valide.php?nomEntreprise=<?php echo $nomE ?>" class="formulaire">
					</br>
					Nom du client :<div class="6u 12u$(mobile)"><input type="text" name="nomClient" required/></div>
					</br>
					Prénom du client :<div class="6u 12u$(mobile)"><input type="text" name="prenomClient" required/></div>
					</br>
					Adresse mail : <div class="6u 12u$(mobile)"><input type="email" name="mailClient" required/></div>
					</br>
					Login :<div class="6u 12u$(mobile)"><input type="text" name="loginClient" required/></div>
					</br>
					Mot de passe : <div class="6u 12u$(mobile)"><input type="password" name="mdpClient" required/></div>
				</br>
				<div align = "center" class="12u$">
				<input type="submit" value="Valider" />
				</div>
				</form>
						
					
	</body>
	
</html>