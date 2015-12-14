<?php
session_start();
?>
<!DOCTYPE HTML>
<?php
require "fonctions.inc.php";
$connexion = connect();

$nomE=$_GET['nomEntreprise'];
$rqt = $connexion->query('SELECT * FROM entreprise WHERE nomEntreprise = "'.$nomE.'"');
$i = $rqt->fetch(PDO::FETCH_OBJ);
if(isset($_POST['mdp'])){
	$mdp =md5($_POST['mdp']);
}
if(isset($_POST['login']) && isset($_POST['mdp']) && $_POST['login']==$i->loginAdmin && $mdp == $i->mdpAdmin ){
	$_SESSION["estConnecte"]=1;
}
majAbsence($nomE);
$planning = $connexion->query('SELECT * FROM '.$nomE.'_planning JOIN '.$nomE.'_employe ON code_employe = id_employe');
$absences = $connexion->query('SELECT * FROM '.$nomE.'_absence JOIN '.$nomE.'_employe ON code_employe = id_employe WHERE absenceFini = 0');
if(isset($_POST['p�riode']) && $_POST['p�riode']==4){
	$reserva = $connexion->query('SELECT * FROM '.$nomE.'_reserv JOIN '.$nomE.'_employe ON employe = id_employe JOIN '.$nomE.'_client ON client = id_client JOIN '.$nomE.'_prestation ON presta = id_presta WHERE date < CURDATE()');
}elseif(isset($_POST['p�riode']) && $_POST['p�riode']==3){
	$reserva = $connexion->query('SELECT * FROM '.$nomE.'_reserv JOIN '.$nomE.'_employe ON employe = id_employe JOIN '.$nomE.'_client ON client = id_client JOIN '.$nomE.'_prestation ON presta = id_presta WHERE date > CURDATE()');
}elseif(isset($_POST['p�riode']) && $_POST['p�riode']==2){
	$reserva = $connexion->query('SELECT * FROM '.$nomE.'_reserv JOIN '.$nomE.'_employe ON employe = id_employe JOIN '.$nomE.'_client ON client = id_client JOIN '.$nomE.'_prestation ON presta = id_presta WHERE date = CURDATE()');
}elseif(!isset($_POST['p�riode']) || (isset($_POST['p�riode']) && $_POST['p�riode']==1)){
	$tableau = tableauDate();
	$reserva = $connexion->query('SELECT * FROM '.$nomE.'_reserv JOIN '.$nomE.'_employe ON employe = id_employe JOIN '.$nomE.'_client ON client = id_client JOIN '.$nomE.'_prestation ON presta = id_presta WHERE date BETWEEN "'.$tableau[0][0].'" AND "'.$tableau[6][0].'"');
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
						<?php if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
						} ?>
							<h1><?php echo $nomE?></h1>
							<p>Page de gestion de l'entreprise</p>
							<?php 
							if(isset($_SESSION["estConnecte"])){
							?>
							
								<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
								<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
								<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employ�s </a></br>
								<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
								<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
								<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="D�connexion"></a>
							</div>
							<?php
							}else{
							
							?>
						</div>
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
							<h1>Page d'accueil back-office <br> Entreprise <?php echo $nomE;?></h1>
							<h3>Planning : </h3>
							<?php if($planning->rowCount()==0){ echo "Pas de planning � afficher.";}else{?>
							<table>
									<tr><td rowspan="2"></td><td colspan="2">Lundi</td><td colspan="2">Mardi</td><td colspan="2">Mercredi</td><td colspan="2">Jeudi</td><td colspan="2">Vendredi</td><td colspan="2">Samedi</td></tr>
									<tr>
										<?php 
											$cpt = 0;
											while($cpt != 6){
												echo "<td>Matin</td><td>Apr�s-Midi</td>";
												$cpt = $cpt + 1;
											}
										?>
									</tr>
									<?php 
									
										while($valeur = $planning->fetch(PDO::FETCH_OBJ)){
											$id_employe = $valeur->code_employe;
											$identite = $valeur->nom_employe ." ". $valeur->prenom_employe;
											$tab = absence($nomE, $id_employe);
											$num = 0;
											if($tab==null){
												?>
												<tr><td><?php echo $identite?></td><td><?php if($valeur->LundiM==1){echo "X";}?></td><td><?php if($valeur->LundiA==1){echo "X";}?></td><td><?php if($valeur->MardiM==1){echo "X";}?></td><td><?php if($valeur->MardiA==1){echo "X";}?></td><td><?php if($valeur->MercrediM==1){echo "X";}?></td><td><?php if($valeur->MercrediA==1){echo "X";}?></td><td><?php if($valeur->JeudiM==1){echo "X";}?></td><td><?php if($valeur->JeudiA==1){echo "X";}?></td><td><?php if($valeur->VendrediM==1){echo "X";}?></td><td><?php if($valeur->VendrediA==1){echo "X";}?></td><td><?php if($valeur->SamediM==1){echo "X";}?></td><td><?php if($valeur->SamediA==1){echo "X";}?></td></tr>
												<?php
											}else{
												?>
												<tr><td><?php echo $identite?></td><td><?php echo $tab[0][0];?></td><td><?php echo $tab[0][1];?></td><td><?php echo $tab[1][0];?></td><td><?php echo $tab[1][1];?></td><td><?php echo $tab[2][0];?></td><td><?php echo $tab[2][1];?></td><td><?php echo $tab[3][0];?></td><td><?php echo $tab[3][1];?></td><td><?php echo $tab[4][0];?></td><td><?php echo $tab[4][1];?></td><td><?php echo $tab[5][0];?></td><td><?php echo $tab[5][1];?></td></tr>
												<?php 											
											}
									
										}
								}
									?>
								</table>
								
								<h3>Liste des r�servations : </h3>
								<form class="formulaire" method="post" action="">
								<div class="6u 12u$(mobile)">
								<select name="p�riode">
								<?php 
								if(isset($_POST['p�riode']) && $_POST['p�riode']==4){
								?>
									<option value=1>R�servation de la semaine</option>
									<option value=2>R�servation de la journ�e</option>
									<option value=3> Toutes les r�servations � venir</option>
									<option value=4 selected="selected"> R�servations d�j� pass�s</option>
								<?php 
								}elseif(isset($_POST['p�riode']) && $_POST['p�riode']==3){
								?>
									<option value=1>R�servation de la semaine</option>
									<option value=2>R�servation de la journ�e</option>
									<option value=3 selected="selected"> Toutes les r�servations � venir</option>
									<option value=4> R�servations d�j� pass�s</option>
								<?php 
								}elseif(isset($_POST['p�riode']) && $_POST['p�riode']==2){
								?>
									<option value=1>R�servation de la semaine</option>
									<option value=2 selected="selected">R�servation de la journ�e</option>
									<option value=3> Toutes les r�servations � venir</option>
									<option value=4> R�servations d�j� pass�s</option>
								<?php 
								}elseif(!isset($_POST['p�riode']) || (isset($_POST['p�riode']) && $_POST['p�riode']==1)){
								?>	
									<option value=1 selected="selected">R�servation de la semaine</option>
									<option value=2>R�servation de la journ�e</option>
									<option value=3> Toutes les r�servations � venir</option>
									<option value=4> R�servations d�j� pass�s</option>
								<?php 
								}
								?>
									
								</select>
								<input class="periode" type="submit" value="Valider" >
								</div>
								</form>
								<?php if($reserva->rowCount()==0){ echo "Pas de r�servation en attente."; } else { ?>
								
								<table>
								<tr><td>Date </br>(ann�e:mois:jour)</td><td>Heure</td><td>Employ�</td><td>Client</td><td>Prestation</td><td>D�j� pay� ?</td></tr>
								<?php 
									while($valeur2 = $reserva->fetch(PDO::FETCH_OBJ)){
										$idClient = $valeur2->nom_client ." ". $valeur2->prenom_client;
										$idEmploye = $valeur2->nom_employe ." ". $valeur2->prenom_employe;
								?>
									<tr><td><?php echo $valeur2->date;?></td><td><?php echo $valeur2->heure;?></td><td><?php echo $idEmploye?></td><td><?php echo $idClient;?></td><td><?php echo $valeur2->descriptif_presta;?></td><td><?php if($valeur2->paye==1){echo "oui";}else{echo "non";}?></td></tr>
								<?php 
									}
								?>
								</table>
								<?php } ?>
								
								<h3>Liste des absences : </h3>
								<?php if($absences->rowCount()==0){ echo "Pas d'absences d'enregistr�e."; } else { ?>
								<table>
								<tr><td> Employ� </td><td>Date de d�but du cong�</td><td>Date de fin du cong�</td><td> Motif </td></tr>
								<?php 
									while($valeur3 = $absences->fetch(PDO::FETCH_OBJ)){
										$idEmploye = $valeur3->nom_employe ." ". $valeur3->prenom_employe;
								?>
									<tr><td> <?php echo $idEmploye;?> </td><td><?php echo $valeur3->dateDebut;?></td><td><?php echo $valeur3->dateFin;?></td><td><?php echo $valeur3->motif;?></td></tr>
								<?php 
									}
								?>
								</table>
								<?php } ?>
						</div>

						
			</div>

	</body>
</html>