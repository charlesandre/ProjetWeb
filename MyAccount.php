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
	$email = $row[2];
	$pw = $row[3];
	$avatar = "Avatars/".$row[4];
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

				<a class="boutonProfil" >Mes Photos</a>
				<a class="boutonProfil" href = "MesImagesLikees.php?id=<?php echo $getid ?>">Photos accrochées</a>
				<a class="boutonProfil" href = "MesAlbums.php?id=<?php echo $getid ?>">Mes albums</a>
				
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
				
				
				for($i=0; $i<$nombrephotos/5; $i++){
					


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
								if($adressephoto != "Photos/" && $nombrephotos > $j){
								?>
									<a  class="lienMaPhoto"  href="AffichageImage.php?id=<?php echo $maphoto[0] ?>" >
										<img id="maPhoto" class="lesPhotos" src ="<?php echo $adressephoto ?>" href="Home.php"/> 
									</a>
									<a  href="AffichageImage.php?id=<?php echo $row2[0] ?>" >
									<div id="afficherInfos" class="affichageInfos">
										<img id="epingleBlanche" src ="images/epingleBlanche.png" /> 
										<span id="infosLike"> <?php echo $nombreLikesPhoto ?> </span>
										<img id="imgCommentaires" src ="images/commentaires.png" /> 
										<span id="infosLike"> <?php echo $nombrecommentairephoto ?> </span>
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

		<?php include('ajouterPhoto.php'); ?>

		<?php include('footer.php'); ?>


	</body>



	





</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>