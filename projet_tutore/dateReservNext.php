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
	
	if( verifEntreprise($_SESSION['nomE']) == null ) {
		
		echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donn�e</p>";
		
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
	if( isset($_POST['login']) && isset($_POST['mdp']) ) {
		//r�cup�ration des infos de connexion des clients
		$j = logClient($_POST['login'], $_POST['mdp']);
		if( $_POST['login'] == $j->login_client && $mdp == $j->mdp_client ) {
			$_SESSION["client"] = $j->id_client;
			$_SESSION["estConnecte"] = 1;
			$_SESSION["nomSession"] = $_GET['nomEntreprise'];
			
		}
	}
	$erreur = 0;
	if(isset($_POST['continue'])){
		if(!empty($_POST['daterdv']) && !empty($_POST['heurerdv'])){
				$_SESSION["date"] = $_POST['daterdv'];
				$_SESSION["heure"] = $_POST['heurerdv'];
				header('Location: resume_reserv.php?nomEntreprise='.$nomE);
			}else{
				$erreur = 2;
			}
				
	}else{
		$erreur = 1;
	}
	
	if(isset($_POST['annule'])){
		header('Location: accueil_client.php?nomEntreprise='.$nomE);
	}
	
?>

<html>
	<head>
		<title>Portail de r�servation : Accueil BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />
		<script type="text/javascript" src="jquery-1.12.1.min.js"></script>
		<script type="text/javascript">
			jQuery(function($){ 
			var date = new Date(); 
			var current = date.getMonth()+1; 
			$('.month').hide(); 
			$('#month'+current).show(); 
			$('.months a#linkMonth'+current).addClass('active'); 
			$('.months a').click(function(){ 
			var month = $(this).attr('id').replace('linkMonth',''); 
			if(month != current){ 
			$('#month'+current).slideUp(); 
			$('#month'+month).slideDown(); 
			$('.months a').removeClass('active'); 
			$('.months a#linkMonth'+month).addClass('active'); 
			current = month; 
			} 
			return false; 
			}); 
			});
		</script>
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
							
							<?php } ?>

			</div>
		</div>

		<!-- Main -->
		<div id="main">

				<!-- Intro -->
					
			<div class="container">
			<h1>R�servation : choix de la date et de l'heure</h1>
					<?php
			require('date.php');
			$date = new Date();
			$year = date('Y')+1;
			$dates = $date->getAll($year);
		?>
		<div class="periods">
			<div class="year"><a href="dateReserv.php?nomEntreprise=<?php echo $nomE;?>"><?php echo $year-1; ?></a></div>
			<div class="year"><a href=""><?php echo $year; ?></a> </div>
			</br>
			<div class="months">
				<ul>
					<?php foreach ($date->months as $id=>$m): ?>
						<li><a href="" id="linkMonth<?php echo $id+1; ?>"><?php echo substr($m,0,3); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="clear"></div>
			<?php $dates = current($dates); ?>
			<?php foreach ($dates as $m => $days):?>
			<?php if($m < 10): $m = substr($m,1,1); endif;?>
				<div class="month relative" id="month<?php echo $m; ?>">
				<table class="cal">
					<thead>
						<tr>
							<?php foreach ($date->days as $d): ?>
								<th><?php echo substr($d,0,3); ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<tr>
						<?php $end = end($days); foreach ($days as $d=>$w):?>
							<?php if($d == 1 && $d != $w): ?>
								<td colspan="<?php echo $w-1; ?>" class="padding"></td>
							<?php endif; ?>
							<td>
								<div class="relative">
									<div class="day"><?php echo $d; ?></div>
								</div>
								<div class="daytitle">
									<?php echo $date->days[$w-1]." "; ?><?php echo $d." ";?><?php echo $date->months[$m-1]; ?>
								</div>
								<!-- Evenement : affich� sur le cot� -->
								<ul class="events">
									<li>cr�neaux</li>
								</ul>
							</td>
							<?php if($w == 7):?>
								<tr></tr>
							<?php endif;?>
						<?php endforeach; ?>
						<?php if($end != 7): ?>
							<td colspan="<?php echo 7-$end; ?>" class="padding"></td>
						<?php endif; ?>
						</tr>
					</tbody>
				</table>
				</div>
			<?php endforeach; ?>
		</div>
		<form method="post" action="">
			Jour de la r�servation : </br>
				<input type="date" name="daterdv" />
			</br></br>
			Heure de la r�servation : </br>
				<input type="time" name="heurerdv" />
			</br></br>	
			<div align = "center" class="12u$">
			<input type="submit" name="continue" value="R�server" />
			<input type="submit" name="annule" value="Annuler" />
			</div>
		</form>
							<?php } ?>
			</div>
		</div>
	</body>
</html>