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

	$result2 = mysql_query("SELECT * FROM Photos");
	$num_rows2 = mysql_num_rows($result2);

?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Index</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>

	</head>

	<body>
	

	<?php include('header.php'); ?>

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
										<input type = "image" id ="fondVide" src ="images/fondVide.png"name = "voiralbum" value = "Voir les photos"> 
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
	


	<?php include('boutonPlus.php'); ?>
	<?php include('footer.php'); ?>


	<script type="text/javascript" src="script.js"> </script>

	</body>

</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>