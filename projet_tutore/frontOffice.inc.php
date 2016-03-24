<?php
	
//Contient les fonctions nécéssaires au FrontOffice

//Permet d'ajouter un client à une entreprise
function ajoutClient($connexion, $id, $nom, $prenom, $mail, $login, $mdp, $nomE) {
	
	$rqtAjoutClient = $connexion->prepare("INSERT INTO ".$nomE."_client(id_client, nom_client, prenom_client, mail, login_client, mdp_client) 
						VALUES (:id, :nom, :prenom, :mail, :login, :mdp)");
						
	$rqtAjoutClient->execute(array("id" => $id, "nom" => $nom, "prenom" => $prenom, "mail" => $mail, "login" => $login, "mdp" => $mdp));	
								
}


?>