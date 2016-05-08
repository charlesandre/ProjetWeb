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

	$result2 = mysql_query("SELECT P.* FROM Photos P, PhotosAlbums A WHERE P.ID = A.IDPhoto AND A.IDAlbum = '$getidalbum'");
	$num_rows2 = mysql_num_rows($result2);

	$photosdelalbum = mysql_query("SELECT * FROM PhotosAlbums WHERE IDAlbum = '$getidalbum'");
	$nombrephotodansalbum = mysql_num_rows($photosdelalbum);

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Formulaire</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>
		
	</head>

	<body>
		
		<?php include('header.php'); ?>

	<div id="reglages">
			
			<div id="texteReglages">Modifier mon album</div>

			<div id="formReglages">
				<form  method="post" action ="" align ="center" id="formulaireReglages">

				<div class="champReglagesAlbum">
					<label class="labelConnexion" for "avatar"> Changer le nom de l'album </label>
					<input id ="nouveauNom" type="text" name="nouveaunomalbum"  placeholder="Nouveau nom" class="caseReglages" />	
					<input type = "submit" name = "ajoutnouvellephoto" value = "Valider">
				</div>

				<div class="champReglagesAlbum">
					<label class="labelConnexion" for "login"> Ajouter une photo </label>
						<?php
							
								$idalbum = $_POST['idalbum'];
								$mesphotos = mysql_query("SELECT * FROM PhotosAlbums WHERE IDAlbum = '$getid'");
								$nbrmesphotos = mysql_num_rows($mesphotos);
								?> <select name ="choixnouvellephoto"> <?php
								for($k=0;$k<$nbrmesphotos;$k++){
									$maphoto = mysql_fetch_row($mesphotos);
									?>
									<option value = "<?php echo $maphoto[0] ?>"><?php echo $maphoto[1] ?> </option>
									<?php

							}
						

							?> 
								</select>
							<input type = "submit" name = "ajoutnouvellephoto" value = "Supprimer cette photo">
							<?php

						
					?>			
				</div>

				<div class="champReglagesAlbum">
					<label class="labelConnexion" for "email"> Supprimer une photo</label>
						<?php
							
								$idalbum = $_POST['idalbum'];
								$mesphotos = mysql_query("SELECT * FROM PhotosAlbums WHERE IDAlbum = '$getid'");
								$nbrmesphotos = mysql_num_rows($mesphotos);
								?> <select name ="choixnouvellephoto"> <?php
								for($k=0;$k<$nbrmesphotos;$k++){
									$maphoto = mysql_fetch_row($mesphotos);
									?>
									<option value = "<?php echo $maphoto[0] ?>"><?php echo $maphoto[1] ?> </option>
									<?php

							}
						

							?> 
								</select>
							<input type = "submit" name = "ajoutnouvellephoto" value = "Supprimer cette photo">
							<?php

						
					?>				
				</div>

				<div class="champReglagesAlbum">
					<label class="labelConnexion" for "pass"> Supprimer l'album </label>
					<input id ="pass" type="password" name="pass"  required="required" placeholder="Ancien mot de passe" class="caseReglages"/>
				</div>


				<div id="submitReglages">
					<input type = "submit" name="formmodif" value="Retour" id="boutonReglages"> </input> 
				</div>
						
						<?php
					if(isset($erreur))
					{
						echo "<p id='erreurReglages'>".$erreur. "</p>";
					}
					
					?> 
					
					

				</form>
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