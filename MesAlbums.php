<?php
session_start();
$bdd = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('bdd', $bdd);

	


	

if(isset($_GET['id']) AND $_GET['id']>0)
{
	$getid = intval($_GET['id']);
	$result = mysql_query("SELECT * FROM Users WHERE ID = '$getid'");
	$row = mysql_fetch_row($result);
	$login = $row[1];


	$avatar = "Avatars/".$row[4];




?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Index</title>
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
		<div id="profil">

			<div id="carteProfil">

				<div id="avatar">
					<img src="<?php echo $avatar ?>">
				</div>

				<div id="infosProfil">

					<div id="nomReglages">
						<div id="nomProfil"><?php echo $login ?></div>
						<div id="divImageReglages">
							<a href="Reglages.php?id=<?php echo $getid ?>" id="aReglages">
								<img src="images/reglages.png" alt="" id="imageReglages"/>
							</a>
							
						</div>
					</div>

					<?php
						$publications = mysql_query("SELECT * FROM Photos WHERE Proprio = '$getid' "); 
						$nbPublications = mysql_num_rows($publications);

						$like = mysql_query("SELECT * FROM MentionAime WHERE IDUser = '$getid' "); 
						$numberlike = mysql_num_rows($like);

						$abonnes = mysql_query("SELECT * FROM RelationFollow WHERE IDSuivi = '$getid'");
						$nbAbonnes = mysql_num_rows($abonnes);

						$abonnements = mysql_query("SELECT * FROM RelationFollow WHERE IDSuiveur = '$getid'");
						$nbAbonnements = mysql_num_rows($abonnements);
					?>

					<div id="caseStats">

						<div class="statsProfil"><?php echo $nbPublications ?> photos publiées</div>
						<div class="statsProfil"><?php echo $numberlike ?> photos accrochées</div>
						<div class="statsProfil"><?php echo $nbAbonnes ?> abonnés</div>
						<div class="statsProfil"><?php echo $nbAbonnements ?> abonnements</div>
					</div>
				</div>	

			</div>


			

			<div id="barreOngletsProfils">

				<a class="boutonProfil" href = "MyAccount.php?id=<?php echo $getid ?>">Mes Photos</a>
				<a class="boutonProfil" href = "MesImagesLikees.php?id=<?php echo $getid ?>">Photos accrochées</a>
				<a class="boutonProfil">Mes albums</a>
				
			</div>


			<div id="galeriePhotosProfil">
				<?php

				$mesphotos= mysql_query("SELECT * FROM Photos WHERE Proprio = '$getid' ORDER BY Daate DESC");
				$nombrephotos = mysql_num_rows($mesphotos);
				
				$mesphotoslikees = mysql_query("SELECT P.* FROM Photos P, MentionAime M WHERE M.IDUser = '$getid' AND M.IDPhoto = P.ID");
				$nbrphotoslikees = mysql_num_rows($mesphotoslikees);
				
				$mesalbums = mysql_query("SELECT * FROM Albums WHERE IDProprio = '$getid'");
				$nombredemesalbums = mysql_num_rows($mesalbums);
				
				$j=0;
				
				
				for($i=0; $i<$nombredemesalbums/5; $i++){
					


					?>
					<!--<tr>
						<td> -->
					<div id="lignePhotos">
							<?php 
							for($j=0; $j<5; $j++){
								$maphoto = mysql_fetch_row($mesphotos);
								$maphotolikee = mysql_fetch_row($mesphotoslikees);
								$monalbum = mysql_fetch_row($mesalbums);
								$adressephoto = "Photos/".$maphoto[2];
								$adressephotolikee = "Photos/".$maphotolikee[2];



								//CALCULER NOMBRE DE LIKES D'UNE PHOTO
								$resultatLikePhoto = mysql_query("SELECT * FROM MentionAime WHERE IDPhoto = '$maphoto[0]'");
								$nombreLikesPhoto = mysql_num_rows($resultatLikePhoto);
								$resultatcommentairephoto = mysql_query("SELECT * FROM Commentaires WHERE IDPhoto = '$maphoto[0]'");
								$nombrecommentairephoto = mysql_num_rows($resultatcommentairephoto);

							$photosdelalbum = mysql_query("SELECT * FROM PhotosAlbums WHERE IDAlbum = '$monalbum[0]'");
							$nombrephotodansalbum = mysql_num_rows($photosdelalbum);
								if($nombredemesalbums > $j){
								?>
								<div id="imageAlbum">
										<img id ="photoDossier" src ="images/album.png"> 
								</div>
								<div id="afficherInfosAlbum" class="affichageInfos">
									<form method = "post" id="formulaireAlbum" action = "">
										<span id="nbPhotosAlbum"><?php echo $nombrephotodansalbum ?> </span>
										<input type = "hidden" name ="idalbum" value = "<?php echo $monalbum[0]?>">
										<a  href = "VoirAlbum.php?id=<? echo $monalbum[0] ?>?idU=<? echo $getid ?>">
											<img type = "image" id ="fondVide" src ="images/fondVide.png"name = "voiralbum" value = "Voir les photos"> 
										</a>
									</form>
									<div id="titreAlbum">
										<?php echo $monalbum[1] ?>
									</div>
								</div>
									
									<?php
								}
							}
							?>
					</div>
						<!--</td>
						<td>
							<!--<?php 
							if ($nbrphotoslikees > $i){
								?>
								<img id="maPhoto" src ="<?php echo $adressephotolikee ?>" /> 
								<?php
							}
							?>-->
						<!--</td>
						<td>
							<?php 
							if ($nombredemesalbums > $i){
								?>
							<?php echo $monalbum[1] ?>
								<?php
							}
							?>-
						</td>
					</tr>-->



					<?php

				}


		
				?>
			</div>
		
		</div>

		<?php 
				$album = mysql_query("SELECT * FROM ALBUMS WHERE IDProprio = '$getid'");
				$nombrealbums = mysql_num_rows($album);
		?>
		<br/><br/>
		<h1>Mes albums</h1>
		<?php 
				

				if (isset($_POST['SuppAlbum'])){

					$nomAlbum = $_POST['nomalbum'];

					$supprimer = mysql_query("DELETE FROM Albums WHERE Nom = '$nomAlbum'");
				}









				if($nombrealbums == 0 ){
						?>
							<h3>Vous n'avez pas d'albums, vous pouvez en créer un en cliquant sur le bouton plus en bas à droite </h3>
							

						<?php
					}
					
					if(isset($_POST['ajoutalbum'])){
						?>
						<h3> Ajouter un album </h3>
						<form method = "post" action = "">
							Choisissez un nom d'album, sa visibilité ainsi que la premeiere photo qui le composeras ! <br/>
							Nom de l'album : <input type = "text" name = "nomnouvelalbum" placeholder = "Nouvel Album ...">
						
							<?php
							
							}
						

						if (isset($_POST['nomnouvelalbum'])){
							$nomalbum = $_POST['nomnouvelalbum'];
							

							$requete = mysql_query("INSERT INTO Albums(Nom, IDProprio) VALUES('$nomalbum', '$getid')");

							header('Location: MesReglages.php?id='.$getid);
							


						}
				
						
					
				
				if($nombrealbums > 0) {

						?> 
							<h2> Vous possedez <?php echo $nombrealbums ?> albums </h2> 
							<table>
								<tr>
									<td>
										Nom de l'album 
									</td>
									<td>
										Nombre de photos
									</td>
									<td>
										Ajouter/supprimer des photos
									</td>
									<td>
										Modifier l'album
									</td>
									<td>
										Supprimer l'album
									</td>
									
								</tr>
							
						<?php
						for($j=0; $j<$nombrealbums; $j++){
							$monalbum = mysql_fetch_row($album);
							$photosdelalbum = mysql_query("SELECT * FROM PhotosAlbums WHERE IDAlbum = '$monalbum[0]'");
							$nombrephotodansalbum = mysql_num_rows($photosdelalbum);

							?>
								<tr>
									<td>
										<?php 
										echo $monalbum[1] ;
										?>
									</td>
									<td>
										<?php echo $nombrephotodansalbum ?> <form method = "post" action = ""> <input type = "hidden" name ="idalbum" value = "<?php echo $monalbum[0]?>"> <input type = "submit" name = "voiralbum" value = "Voir les photos"> </form> 
									</td>
									<td>
										<form method = "post" action ="">
											<input type = "hidden" name ="idalbum" value = "<?php echo $monalbum[0]?>">
											<input type = "submit" name ="gererphotos" value = "Cliquer ici">
											<?php
												if(isset($_POST['gererphotos'])){
													$idalbum = $_POST['idalbum'];
													if($idalbum == $monalbum[0]){
														$mesphotos = mysql_query("SELECT * FROM Photos WHERE Proprio = '$getid'");
														$nbrmesphotos = mysql_num_rows($mesphotos);
														?> <select name ="choixnouvellephoto"> <?php
														for($k=0;$k<$nbrmesphotos;$k++){
															$maphoto = mysql_fetch_row($mesphotos);
															?>
															<option value = "<?php echo $maphoto[0] ?>"><?php echo $maphoto[1] ?> </option>
															<?php

													}
												}

													?> 
														</select>
													<input type = "submit" name = "ajoutnouvellephoto" value = "ajouter cette photo">
													<?php

												}
											?>
										</form>
									</td>
									<td>
										<form method = "post" action ="">
											<input type = "hidden" name = "nomalbum" value = "<?php echo $monalbum[1]?>">
											<input type = "submit" name ="ModAlbum" value = "Cliquer ici">
											<?php
												if (isset($_POST['ModAlbum'])){
													if($_POST['nomalbum'] == $monalbum[1]){
														?>
															<form method = "post" action = "">
																<input type = "text" name ="nouveaunomalbum" placeholder = "Nouveau nom ...">
															</form>
														<?php
													}
												}
											?>
										</form>
									</td>
									<td>
										<form method = "post" action ="">
											<input type = "hidden" name = "nomalbum" value = "<?php echo $monalbum[1]?>">
											<input type = "submit" name ="SuppAlbum" value = "Cliquer ici">
										</form>
									</td>
									
								<tr>



							<?php
						} 
						

						if(isset($_POST['nouveaunomalbum'])){
							$nouveaunom = $_POST['nouveaunomalbum'];
							$anciennom = $_POST['nomalbum'];

							$request = mysql_query("UPDATE Albums SET Nom = '$nouveaunom' WHERE Nom = '$anciennom'");
						}

						if(isset($_POST['ajoutnouvellephoto'])){
							$idnouvellephoto= $_POST['choixnouvellephoto'];
							$idAlbum = $_POST['idalbum'];

							$request = mysql_query("INSERT INTO PhotosAlbums (IDPhoto, IDAlbum) VALUES ('$idnouvellephoto', '$idAlbum')");

						}

						if(isset($_POST['voiralbum'])){
							$idAlbum = $_POST['idalbum'];
							$photos = mysql_query("SELECT P.* FROM PhotosAlbums A, Photos P WHERE A.IDAlbum = '$idAlbum' AND A.IDPhoto = P.ID");
							$nbrphotos = mysql_num_rows($photos);
							?>
							Nombre de photos a afficher : <?php echo $nbrphotos; 
							for($k=0; $k<$nbrphotos;$k++){
								$photo = mysql_fetch_row($photos);
								$adresse = "Photos/".$photo[2];
								?>

									<div id="affichagePhoto">
										<img  id="dimension" src="<?php echo $adresse ?>"/>
									</div>


								<?php
							} 

						}






				}
		?>	
							</table>
										
									
	<div id = "ajouterPhoto">
		<form  method ="post" action =""> 
			<input id = "boutonplus" type = "image" src = "images/boutonplus.png" name ="ajoutalbum" value = "Creer un album"> 
		</form>
	</div>
		


		<?php include('footer.php'); ?>


	</body>

</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>