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


			<div id="divImageReglages">
				<a href="Reglages.php?id=<?php echo $getid ?>" id="aReglages">
					<img src="images/reglages.png" alt="" id="imageReglages"/>
				</a>
				
			</div>

			<div id="barreOngletsProfils">

				<a class="boutonProfil" href = "MesImages.php?id=<?php echo $getid ?>">Mes Photos</a>
				<a class="boutonProfil" href = "MesImagesLikees.php?id=<?php echo $getid ?>">Photos accrochées</a>
				<a class="boutonProfil" href = "MesAlbums.php?id=<?php echo $getid ?>">Mes albums</a>
				<a class="boutonProfil" href = "Connexion.php"> Deconnexion </a>
			</div>

			<div id="galeriePhotosProfil">
				<?php

				$mesphotos= mysql_query("SELECT * FROM Photos WHERE Proprio = '$getid'");
				$nombrephotos = mysql_num_rows($mesphotos);
				
				$mesphotoslikees = mysql_query("SELECT P.* FROM Photos P, MentionAime M WHERE M.IDUser = '$getid' AND M.IDPhoto = P.ID");
				$nbrphotoslikees = mysql_num_rows($mesphotoslikees);
				
				$mesalbums = mysql_query("SELECT * FROM Albums WHERE IDProprio = '$getid'");
				$nombredemesalbums = mysql_num_rows($mesalbums);
				
			
				
				for($i=0; $i<5; $i++){
					$maphoto = mysql_fetch_row($mesphotos);
					$maphotolikee = mysql_fetch_row($mesphotoslikees);
					$monalbum = mysql_fetch_row($mesalbums);
					$adressephoto = "Photos/".$maphoto[2];
					$adressephotolikee = "Photos/".$maphotolikee[2];


					?>
					<tr>
						<td> 
							<?php 
							if ($nombrephotos > $i){
								?>
								<img id="maPhoto" src ="<?php echo $adressephoto ?>" /> 
								<?php
							}
							?>
						</td>
						<td>
							<?php 
							if ($nbrphotoslikees > $i){
								?>
								<img id="maPhoto" src ="<?php echo $adressephotolikee ?>" /> 
								<?php
							}
							?>
						</td>
						<td>
							<?php 
							if ($nombredemesalbums > $i){
								?>
							<?php echo $monalbum[1] ?>
								<?php
							}
							?>
						</td>
					</tr>



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