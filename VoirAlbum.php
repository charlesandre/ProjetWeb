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


	$result2 = mysql_query("SELECT P.* FROM Photos P, PhotosAlbums A WHERE P.ID = A.IDPhoto AND A.IDAlbum = '$getidalbum'");
	$num_rows2 = mysql_num_rows($result2);

	$photosdelalbum = mysql_query("SELECT * FROM PhotosAlbums WHERE IDAlbum = '$getidalbum'");
	$nombrephotodansalbum = mysql_num_rows($photosdelalbum);

	$proprietaire = mysql_query("SELECT * FROM Users WHERE ID = '$getid'");
	$proprietaire = mysql_fetch_row($proprietaire);
	$login = $proprietaire[1];
	$mdp = $proprietaire[3];

?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Album</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>

	</head>

	<body>

		<header>
			<p> 
				<a  href="Home.php?id=<?php echo $login ?>" >
					<span id="logo"></span>
				</a>
				<div id="recherche"> 
					<form method = "post" action = ""> 
						<input type="text" name="caserecherche" id="caserecherche" placeholder="Rechercher"/> 
					</form>
				</div>
				<div id="boutons"> 
					<a class="onglet" href="MyAccount.php?id=<?php echo $getid ?>"><?php echo $login ?></a> 
				   	<a class="onglet" href = "Connexion.php"> Déconnexion </a>
				</div> 
			</p>
		</header>

		<h1> <?php echo $nomalbum ?> </h1>

		<h1> <?php if($nombrephotodansalbum > 1){ ?>
		     			Il y a <?php echo $nombrephotodansalbum ?> photos dans l'album 
		     <?php }
		     		else{  ?>
		     				Il y a <?php echo $nombrephotodansalbum ?> photo dans votre album
		     <?php }?>
		</h1>

	
	<?php 

		for($j=$num_rows2; $j>0; $j--){
			$row2 = mysql_fetch_row($result2);
			$adresse = "Photos/".$row2[2];


	?>	

		
		

	<div id="postPhoto">

		<div id="affichagePhoto">
			<img  id="laPhoto" src="<?php echo $adresse ?>"/>
		</div>

		<div id="legende">
			<div id="description">
				<?php 
					$message = '"'.$row2[1] .'"';
					echo $message;
				?>
			</div>
			<div id="auteur">
				<?php 
					$resultAuteur = mysql_query("SELECT Login FROM Users WHERE ID = '$row2[5]'");
					$rowAuteur = mysql_fetch_row($resultAuteur);
					$auteur = $rowAuteur[0];
					echo $auteur;
				?> 
			</div>
			<div id="date">
				<?php echo $row2[4] ?> 
			</div>
			<div id="lieu">
				<?php echo $row2[3] ?> 
			</div>

			<div id="boutonsImage">

				<div id="epingle">
					<form name = "like" id ="formLike" method="post" action ="">
						<input type="hidden"  name="idphoto"  value="<?php echo $row2[0] ?>">
						<?php
							$photolike = mysql_query("SELECT * FROM MentionAime WHERE IDPhoto = '$row2[0]' AND IDUser = '$getid' "); 
							$photolikenum = mysql_num_rows($photolike);
							$like = mysql_query("SELECT * FROM MentionAime WHERE IDPhoto = '$row2[0]'");
							$numberlike = mysql_num_rows($like);
							if($photolikenum == 0){
						?>
						
							<input type="image" src="images/epingle.png" name="like" id="imgLike" value="Like">
						
						<?php
							}
							else {
						?>
						
							<input type="image" src="images/epingleRouge.png" name="unlike" id="imgUnlike" value="UnLike">
						
						<?php
							}
						?>
						<span id="nbLikes">
							<?php echo $numberlike ?>
						</span>
									
					</form>
				</div>

				

				<div id="follow">
						<form name ="follow" method="post" action ="">
							<input type="hidden"  name="idprop"  value="<?php echo $row2[5] ?>">
							<?php
							$follow = mysql_query("SELECT * FROM RelationFollow WHERE IDSuiveur = '$getid' AND IDSuivi = '$row2[5]' "); 
							$Follownum = mysql_num_rows($follow);
							$numberfollower = mysql_query("SELECT FROM RelationFollow WHERE IDSuivi = '$row2[5]'");
							$nbrfollower = mysql_num_rows($numberfollower);
							
							if($Follownum == 0){
							?><input type="image" src="images/follow.png" name="follow" id="imgFollow" value="Follow"><?php
							}
							else {
							?><input type="image" src="images/unfollow.png" name="unfollow" id="imgUnfollow" value="UnFollow"><?php
							}
							?>
								<span id="nbFollow">
							<?php echo $nbrfollower ?>
						</span>
						</form>
				</div>
			</div>
				

			<div id="caseCommentaire">
				<?php 
					$requetenombrecomm = mysql_query("SELECT * FROM Commentaires WHERE IDPhoto = '$row2[0]'");
					$nombrecom = mysql_num_rows($requetenombrecomm);
					?>
					<div id="nbCom">
						<?php echo $nombrecom ?> commentaires
					</div>
				
				<form name ="comment" method="post" action ="">
					<input type="hidden"  name="idphoto"  value="<?php echo $row2[0] ?>">
					<input type="text" name="com" id="saisieCom" placeholder="Votre commentaire ...">
				</form>

				<div id="commentaires">
					<?php 
						for($i =0; $i < $nombrecom; $i++){
							$commentaire = mysql_fetch_row($requetenombrecomm);
							$requetenomproprio = mysql_query("SELECT Login FROM Users WHERE ID = '$commentaire[1]'");
							$rowProprio = mysql_fetch_row($requetenomproprio);
							$proprio = $rowProprio[0];
							?>

							<div id="champCom">
								<div id="pseudoCom">
									<?php echo $proprio ?>
								</div>

								<div id="leCom">
									<?php echo $commentaire[2] ?>
								</div>
							</div>

							<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
		
		


			
<?php 

}
?>



	 <div id="ajouterPhoto"> 
		<a href="ReglagesAlbum.php?id=<?php echo $getidalbum ?>"><img  src="images/boutonReglages.png" id="boutonplus"> </a>
	</div>

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