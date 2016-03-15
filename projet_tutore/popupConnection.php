<!DOCTYPE HTML>
<?php

	session_start();
	
	require "fonctions.inc.php";
	require "bd.inc.php";
	
	$i = infosEntreprise();
	
	$connexion = connect();
	
	$nomE = $_GET['nomEntreprise'];
	
	if(isset($_POST['mdp'])) {
			
			//$mdp = md5($_POST['mdp']);
			$mdp = $_POST['mdp'];
		} 
		
	if( isset($_POST['login']) && isset($_POST['mdp']) ) {
		//récupération des infos de connexion des clients
		$j = logClient($_POST['login'], $_POST['mdp']);
		if( $_POST['login'] == $j->login_client && $_POST['mdp'] == $j->mdp_client ) {
			$_SESSION["client"] = $j->id_client;
			$_SESSION["estConnecte"] = 1;
			$_SESSION["nomSession"] = $_GET['nomEntreprise'];
			?>
				<SCRIPT language="javascript">
					javascript:parent.opener.location.reload();
					window.close();
				</SCRIPT>
				<?php	
		}
	}


?>


<html>

	<head>
	
		<title>Popup de connexion : </title>
		
		<link rel="stylesheet" href="assets/css/main.css" />

	</head>
	
	<body>
				<p>Connectez-vous :</p>
								
						<form method="post" action="">
						
								<div class="row">
								
									<div class="6u 12u$(mobile)"><input type="text" name="login" placeholder="Login" /></div></br></br></br>
									
									<div class="6u 12u$(mobile)"><input type="password" name="mdp" placeholder="Mot de passe" /></div>	
									
								</div></br>
								
								<div align = "center" class="12u$">
								
									<input type="submit" name ="connecte" value="Connection"/>
									
								</div>
								
						</form>
						
					
	</body>
	
</html>