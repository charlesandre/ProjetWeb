<?php
session_start();
$bdd = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('bdd', $bdd);

	


	

if(isset($_GET['id']) AND $_GET['id']>=0)
{
	$getidalbum = intval($_GET['id']);
	$result = mysql_query("SELECT * FROM Albums WHERE ID = '$getidalbum'");
	$row = mysql_fetch_row($result);
	$getid = $row[2];
	$nomalbum = $row[1];

	$proprietaire = mysql_query("SELECT * FROM Users WHERE ID = '$getid'");
	$proprietaire = mysql_fetch_row($proprietaire);
	$login = $proprietaire[1];
	$mdp = $proprietaire[3];

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Formulaire</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>
		
	</head>

	<body>
		
<header>
	<p> 
		<a  href="Home.php?id=<?php echo $getid ?>" >
			<span id="logo"></span>
		</a>
		<div id="recherche"> 
			<form method = "post" action = ""> 
				<input type="text" name="caserecherche" id="caserecherche" placeholder="Rechercher"/> 
			</form>
		</div>
		<div id="boutons"> 
			<a class="onglet" href="MyAccount.php?id=<?php echo $getid ?>"><?php echo $login ?></a> 
		   	<a class="onglet" href="Notifications.html">Notifications</a> 
		   	<a class="onglet" href = "Connexion.php"> Déconnexion </a>
		</div> 
	</p>
</header>
	


	<div id="reglagesAlbum">
			
			<div id="texteReglages">Modifier mon album</div>

			<div id="formReglages">
				<form  method="post" action ="" align ="center">
					<div class="champReglagesAlbum">
						<label class="labelConnexion" for "avatar"> Changer le nom de l'album </label>
						<input id ="nouveauNom" type="text" name="nouveaunomalbum"  placeholder="<?php echo $nomalbum ?>" class="caseReglages" />	
						

					
						<div class="validerRegAlbum">
								<input type = "submit" name = "modifnomalbum" value = "Valider">
						</div>
					</div>
				</form>


					<!-- AJOUTER PHOTO -->
				<form  method="post" action ="" align ="center">
					<div class="champReglagesAlbum">
						
							<label class="labelConnexion" for "logchoixnouvellephotoin"> Ajouter une photo </label>
								<?php
									
										$idalbum = $_POST['idalbum'];
										$mesphotos = mysql_query("SELECT DISTINCT P.* FROM Photos P, PhotosAlbums A WHERE A.IDAlbum = '$getidalbum' AND A.IDPhoto != P.ID");
										$nbrmesphotos = mysql_num_rows($mesphotos);
										?> <select class="validerAjoutSupp" name ="choixnouvellephoto"> <?php
										
										for($k=0;$k<$nbrmesphotos;$k++){
											$maphoto = mysql_fetch_row($mesphotos);
											?>
											<option value = "<?php echo $maphoto[0] ?>"><?php echo $maphoto[1] ?> </option>
											<?php

									}
								

									?> 
										</select>
								<div class="validerRegAlbum">
									<input class="submitModifAlbum" type = "submit" name = "ajoutnouvellephoto" value = "Ajouter">
								</div>
						
					</div>
				</form>	

				<!-- SUPPRIMER PHOTO -->
				<form  method="post" action ="" align ="center">
					<div class="champReglagesAlbum">
						<label class="labelConnexion" for "choixnouvellephoto"> Supprimer une photo</label>
							<?php
								
									$idalbum = $_POST['idalbum'];
									$mesphotos = mysql_query("SELECT P.* FROM Photos P, PhotosAlbums A WHERE A.IDAlbum = '$getidalbum' AND A.IDPhoto = P.ID");
									$nbrmesphotos = mysql_num_rows($mesphotos);
									?> <select class="validerAjoutSupp" name ="choixnouvellephoto"> <?php
									for($k=0;$k<$nbrmesphotos;$k++){
										$maphoto = mysql_fetch_row($mesphotos);
										?>
										<option value = "<?php echo $maphoto[0] ?>"><?php echo $maphoto[1] ?> </option>
										<?php

								}
							

								?> 
									</select>
							<div class="validerRegAlbum">
								<input class="submitModifAlbum" type = "submit" name = "suppphoto" value = "Supprimer">
							</div>
					</div>
				</form>
					
					<!-- SUPPRIMER ALBUM -->
				<form  method="post" action ="" align ="center">
					<div class="champReglagesAlbum">
						
							<label class="labelConnexion" for "pass"> Supprimer l'album </label>
							<input id ="pass" type="password" name="pass"  placeholder="Mot de passe" class="caseReglages"/>
							<div class="validerRegAlbum">
								<input type = "submit" name = "supprimeralbum" value = "Valider">
							</div>
					</div>
				</form>


				<div id="submitReglages">
					<a href = "VoirAlbum.php?id=<? echo $idalbum ?>" id="retourAlbum"> Retour </a> 
				</div>
						
						<?php


				if (isset($_POST['ajoutnouvellephoto'])){

					$idphoto = $_POST['choixnouvellephoto'];

					$ajout = mysql_query("INSERT INTO PhotosAlbums (IDPhoto, IDAlbum) VALUES ('$idphoto', '$getidalbum')");


				}

				if (isset($_POST['suppphoto'])){

					$idphoto = $_POST['choixnouvellephoto'];

					$ajout = mysql_query("DELETE FROM PhotosAlbums WHERE IDPhoto = '$idphoto'");


				}



				if (isset($_POST['supprimeralbum'])){

					$motdepasse = $_POST['pass'];
					if($motdepasse == $mdp){

					$supprimer = mysql_query("DELETE FROM Albums WHERE ID = '$getidalbum'");


				}
				else {
					$erreur = "Mauvais mot de passe";
				}


				}

				if (isset($_POST['modifnomalbum'])){
							
							$nomalbum = $_POST['nouveaunomalbum'];
							
							$requete = mysql_query("UPDATE Albums SET Nom = '$nomalbum' WHERE ID = '$getidalbum'");

							


						}


					if(isset($erreur))
					{
						echo "<p id='erreurReglages'>".$erreur. "</p>";
					}
					
					?> 
					
					

		</div>
		


	</div>	
 		
<!--
	<div id ="reglages">
				<form method="post" action ="" align ="center">
				<p id="texteReglages">Modifier mes informations</p>
				<table>
					<tr>
						<td class="champReglages">
							<label for "login"> Pseudo : </label>
						</td>
						<td>
							<input id ="login" type="text" name="log" required="required" placeholder="<?php echo $login; ?>" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td class="champReglages">
							<label for "email"> E-mail : </label>
						</td>
						<td>
							<input id ="email" type="TEXT" name="email"  required="required" placeholder="<?php echo $email; ?>" class="caseConnexion" />
						</td>
					</tr>
					<tr>
						<td class="champReglages">
							<label for "pass">Ancien mot de passe </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass"  required="required" placeholder="Ancien mot de passe" class="caseConnexion"/>
						</td>
					</tr>

					<tr>
						<td class="champReglages">
							<label for "pass">Nouveau mot de passe </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass2"  required="required" placeholder="Nouveau mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td class="champReglages">
							<label for "pass2"> Confirmer le nouveau mot de passe </label>
						</td>
						<td>
							<input id ="pass2" type="password" name="pass3"  required="required" placeholder="Nouveau mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td id="tdReglages" colspan="2">
							<input type = "submit" name="formmodif" value="Sauvegarder" id="boutonReglages"> </input> 
						</td>
					</tr>

				</table>


					

			

			<?php
			//if(isset($erreur))
			{
				//echo "<p id='erreurReglages'>".$erreur. "</p>";
			}
			?>

					
			</form>


	</div>

	-->

	</body>

	<?php include('footer.php'); ?>





</html>
<?php

}

else{
header("Location: Connexion.php");
}
?>