<!DOCTYPE HTML>
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

	require "fonctions.inc.php";
	require "bd.inc.php";
	require "ajout.inc.php";
	
	if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
	} else if (!isset($_GET['id_presta'])) {
	
	} else if( verifEntreprise($_SESSION['nomE']) == null ) {
		
	} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
		
	} else {
	
		$connexion = connect();
		$nomE = $_SESSION["nomSession"];
		
		$id = $_GET['id_presta'];
		
		if (isset($_POST['modif'])) {
			
			$paypal = (isset($_POST['paypal']) )? 1 : 0;
			
			//Permet de modifier une prestation
			majPresta($connexion, $_POST['descrip'], $_POST['cout'], $_POST['duree'], $_POST['categorie'], $paypal, $id);
			if(isset($_POST['dejaCap'])){
				ajouteComp2($connexion, $_POST['dejaCap'], $id);
			}else{
				ajouteComp2($connexion, null, $id);
			}
		
		}
		
		if(isset($_POST['creer'])){
			header('Location: ajout_prestation.php?nomEntreprise='.$nomE);
		}
		
		if(isset($_POST['supprime'])){
			if(isset($_POST['presta_modif'])){
				supprimerPresta($connexion, $_POST['presta_modif']);
				$supprimeok = 1;
			}
		}
		if(isset($_POST['modifie'])){
			if(isset($_POST['presta_modif'])){
				header('Location: modif_prestation.php?nomEntreprise='.$nomE.'&id_presta='.$_POST['presta_modif']);
			}
		}
		
		$i = infosEntreprise();

		$listePresta = listePrestations();
		
		$presta = infosPrestation($id);

		$empComp = listeEmpCapable($id);
		$empNonComp = listeEmpNonCapable($id);
	
	}
?>

<html>
	<head>
		<title>Portail de réservation : BackOffice</title>
		<link rel="stylesheet" href="assets/css/main.css" />
		<SCRIPT LANGUAGE="JavaScript">
			function Deplacer( liste_depart, liste_arrivee ){
		    	for( i = 0; i < liste_depart.options.length; i++ ){
      				if( liste_depart.options[i].selected && liste_depart.options[i] != "" ){
        				o = new Option( liste_depart.options[i].text, liste_depart.options[i].value );
        				liste_arrivee.options[liste_arrivee.options.length] = o;
        				liste_depart.options[i] = null;
        				i = i - 1 ;
      				}else{
       					 // alert( "aucun element selectionne" );
      				}
    			}
  			}

			function Valider( liste_1, liste_2 ){
		    	for( i = 0; i < liste_1.options.length; i++ ){
      				liste_1.options[i].selected=true;
    			}
		    	for( i = 0; i < liste_2.options.length; i++ ){
      				liste_2.options[i].selected=true;
    			}
		    	document.getElementById("dejaCap").disabled = true;
		    	document.getElementById("nonCap").disabled = true;
  			}
			function Debloque(){
		    	document.getElementById("dejaCap").disabled = false;
		    	document.getElementById("nonCap").disabled = false;
  			}
		
		</SCRIPT>
	</head>
	<body>

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
		
							} else if (!isset($_GET['id_presta'])) {
							
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
							} else {
							
							if($i->logoEntreprise !=""){
							echo "<span class='image avatar48'><img src='".$i->logoEntreprise."' alt='' /></span>";
							} 
							
							?>
							<h1><?php echo $nomE?></h1>
							<p>Gestion des prestations</p>
							<a href="accueil_backoffice.php?nomEntreprise=<?php echo $nomE ?>"> Accueil </a></br>
							<a href="modif_entreprise.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des informations de l'entreprise </a></br>
							<a href="ajout_employe.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des employés </a></br>
							<a href="ajout_prestation.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des prestations </a></br>
							<a href="modif_categorie.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des catégories </a></br>
							<a href="gestion_absence.php?nomEntreprise=<?php echo $nomE ?>"> Gestion des absences </a></br>
							<a href="destruct_session.php?nomEntreprise=<?php echo $nomE ?>"><input type="button" value="Déconnexion"></a>
							
							<?php
							}
							?>

						</div>
						
				</div>

				<div class="bottom">

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->

						<div class="container">
							<h1>Gestion des prestations de l'entreprise</h1>
							
							<?php 
							
							if( $_SESSION["nomE"] == "Nom de l'entreprise non spécifiée" ) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme ?nomEntreprise=nom.</p>";
		
							} else if (!isset($_GET['id_presta'])) {
								
								echo "<p>Le nom de l'entreprise doit être renseigné dans l'url sous la forme &id_employe=id.</p>";
							
							} else if( verifEntreprise($_SESSION['nomE']) == null ) {
								
								echo "<p>Le nom de l'entreprise contenue dans l'url n'existe pas dans la base de donnée</p>";
								
							} else if($_SESSION["nomSession"] != $_GET['nomEntreprise']) {
								
								echo "<p>Vous devez d'abord vous connectez sur l'accueil de l'entreprise </p>";
								
							} else {
							
							if(isset($_POST['modif'])){
								echo "<p> Modification de prestation effectué </p>";
							}
							?>
							<form method="post" action="">
								<div class="6u 12u$(mobile)"><select name="presta_modif">
								<?php 
								while($donnees=$listePresta->fetch(PDO::FETCH_OBJ)){
								?>
									<option value="<?php echo $donnees->id_presta ?>"><?php echo $donnees->descriptif_presta." ".$donnees->categorie; ?></option>   
								<?php
								}
								?>
								</select></div></br>
								<div align = "center" class="12u$">
									<input type="submit"  name="supprime" value="Supprimer" />
									<input type="submit"  name="modifie" value="Modifier" /></br></br>
									<input type="submit"  name="creer" value="Créer une nouvelle prestation" />
								</div>
							</form>
							
							</br>
							<h2>Modification d'une prestation</h2>
							<form method="post" action="">
								
								</br>
									Descriptif de la prestation : </br>
									<div class="6u 12u$(mobile)"><textarea name="descrip" ><?php echo $presta->descriptif_presta; ?></textarea></div>			
									</br>
									Prix de la prestation (en €): </br>
									<font size=-1>format du champs : chiffres suivi d'un "." suivi de chiffres (ex : 15.90)</font>
									<div class="6u 12u$(mobile)"><input type="text" pattern="[0-9]{1,}[.,]{0,1}[0-9]{0,2}" name="cout" value="<?php echo $presta->cout;?>"></div>				
									</br>
									Durée de la prestation (en minutes) : </br>
									<font size=-1>format du champs : chiffres uniquement (ex : 65)</font>
									<div class="6u 12u$(mobile)"><input type="text" pattern="[0-9]+" name="duree" value="<?php echo $presta->duree;?>"></div>	
									</br>
									Paiement PayPal : <input type="checkbox" name="paypal" value="1" <?php if($presta->paypal==1){echo "checked='checked'";}?>/>
								
								</br>
								Employés pouvant faire la prestation : <div class="6u 12u$(mobile)"><select name="dejaCap[]" id="dejaCap" size=3 multiple>
									<?php 
									while($rqt=$empComp->fetch(PDO::FETCH_OBJ)){
										$identite = $rqt->nom_employe." ".$rqt->prenom_employe;
									?>
										<option value="<?php echo $rqt->employe;?>"><?php echo $identite;?></option>
									<?php 	
									
									}
									?>
								</select>
								</div><center>
									<INPUT type="button" value="\/" onClick="Deplacer(this.form.dejaCap,this.form.nonCap)">
									<INPUT type="button" value="/\" onClick="Deplacer(this.form.nonCap,this.form.dejaCap)">	
										<INPUT type="button" value="Valider" onClick="Valider(this.form.nonCap,this.form.dejaCap)">
									</center>
								</br>
								Autres employés : <div class="6u 12u$(mobile)"><select name="nonCap[]" id="nonCap" size=3 multiple>
									<?php 
									while($rqt=$empNonComp->fetch(PDO::FETCH_OBJ)){
										$identite = $rqt->nom_employe." ".$rqt->prenom_employe;
									?>
										<option value="<?php echo $rqt->id_employe;?>"><?php echo $identite;?></option>
									<?php 	
									
									}
									?>
								</select>
								</div>
								</br>
								Categorie:
								<div class="6u 12u$(mobile)">
								<select name="categorie">
								<option value=""></option>
								<?php 
								$listecat = $connexion->query("SELECT * FROM ".$nomE."_categorie");
								while($donnees=$listecat->fetch(PDO::FETCH_OBJ)){
									$option = $donnees->categorie;
								?>
									<option value="<?php echo $donnees->categorie ?>" <?php if($presta->categorie == $option){ echo "selected='selected'";} ?>><?php echo $option; ?></option>   
								<?php
								}
								?>
								</select>
								</br>
								<input type="hidden" name="modif" value="ok"> 
								<div align = "center" class="12u$">
									<input type="submit" value="Modifier" onClick="Debloque()"/>
								</div>
							</form>
						</div>
						
						<?php
						
							}
						
						?>
						
			</div>

	</body>
</html>