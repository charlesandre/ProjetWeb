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

	<?php

		if(isset($_POST['caserecherche'])){
			$motcle = $_POST['caserecherche'];
			$result2 = mysql_query("SELECT DISTINCT P.* FROM Photos P, Users U WHERE P.Visibilite = 'Public' AND (P.Nom LIKE '%$motcle%' OR (P.Proprio = U.ID AND U.Login LIKE '%$motcle%') OR (P.Lieu LIKE '%$motcle%'))");
			$num_rows2 = mysql_num_rows($result2);
		}
		
		else if (!isset($_POST['caserecherche'])){
			$result2 = mysql_query("SELECT DISTINCT P.* FROM Photos P, RelationFollow R WHERE P.Visibilite = 'Public' AND (R.IDSuiveur = '$getid' AND R.IDSuivi = P.Proprio) OR P.Proprio = '$getid' ORDER BY Daate DESC");
			$num_rows2 = mysql_num_rows($result2);
		}


			if (isset($_POST['like']))
				{
					
						$idPhoto = $_POST['idphoto'];
						$idUser = $getid;

					$result = mysql_query("INSERT INTO MentionAime (IDPhoto, IDUser)
			             VALUES ('$idPhoto', '$idUser')");
				
			}
			if (isset($_POST['unlike']))
			{
				
					$idPhoto = $_POST['idphoto'];
					$idUser = $getid;

					$result = mysql_query("DELETE FROM MentionAime WHERE IDPhoto = '$idPhoto' AND IDUser = '$idUser'");
			}

			if (isset($_POST['follow']))
			{
				
					$idProp = $_POST['idprop'];
					$idUser = $getid;


					$result = mysql_query("INSERT INTO RelationFollow (IDSuiveur, IDSuivi) VALUES ('$idUser', '$idProp')");
			}

			if (isset($_POST['unfollow']))
			{
				
					$idProp = $_POST['idprop'];
					$idUser = $getid;

					$result = mysql_query("DELETE FROM RelationFollow WHERE IDSuiveur = '$idUser' AND IDSuivi = '$idProp'");
			}

			if(isset($_POST['com']))
			{
					$iduser = $getid;
					$idphoto = $_POST['idphoto'];
					$contenu = $_POST['com'];
					$result = mysql_query("INSERT INTO Commentaires (IDUser, Contenu, IDPhoto) VALUES ('$iduser', '$contenu', '$idphoto')");
			}
			


			?> <?php

			if ($num_rows2 == 0) {
				if(isset($_POST['caserecherche'])){
					?>
					<h2> Aucune photo ne correspond à votre recherche pour : <span class="motcle"><?php echo $motcle ?></span> </h2>
					<?php
					}
					else{
						?>
					<h2> Nous n'avons pas de photos a vous montrer, ajoutez des photos en cliquant sur le bouton plus en bas a droite ou commencez à suivre des gens ! </h2>
					<?php

				}

			}

			
			else if(isset($_POST['caserecherche'])){
			?>
			<h2> Il y a <?php echo $num_rows2 ?> résultats correspondant a votre recherche : <span class="motcle"><?php echo $motcle ?></span></h2>
			<?php

			}


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
							
							if($Follownum == 0){
							?><input type="image" src="images/follow.png" name="follow" id="imgFollow" value="Follow"><?php
							}
							else {
							?><input type="image" src="images/unfollow.png" name="unfollow" id="imgUnfollow" value="UnFollow"><?php
							}
							?>
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