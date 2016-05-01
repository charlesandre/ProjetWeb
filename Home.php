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
			$result2 = mysql_query("SELECT DISTINCT P.ID, P.Nom, P.Adresse, P.Lieu, P.Daate, P.Visibilite FROM Photos P, Users U WHERE P.Visibilite = 'Public' AND (P.Nom LIKE '%$motcle%' OR (P.Proprio = U.ID AND U.Login LIKE '%$motcle%') OR (P.Lieu LIKE '%$motcle%'))");
			$num_rows2 = mysql_num_rows($result2);
		}
		else {
			$result2 = mysql_query("SELECT * FROM Photos WHERE Visibilite = 'Public' ORDER BY Daate DESC");
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
				
					$idPhoto = $_POST['idphoto'];
					$idUser = $getid;

					$result3 = mysql_query("SELECT Proprio FROM Photos WHERE ID = $idPhoto");
					$row3 = mysql_fetch_row($result3);
					$idSuivi = $row3[0];


					$result = mysql_query("INSERT INTO RelationFollow (IDSuiveur, IDSuivi)
		             VALUES ('$idUser', '$idSuivi')");
			
				
			}

			?> <br/><br/><br/> <?php

			if ($num_rows2 == 0) {
				if(isset($_POST['caserecherche'])){
					?>
					<h2> Aucune photo ne correspond à votre recherche pour : <span class="motcle"><?php echo $motcle ?></span> </h2>
					<?php
					}
					else {
						?>
					<h2> Nous n'avons pas de photos a vous montrer, ajoutez des photos en cliquant sur le bouton plus en bas a droite ou ajoutez des amis ! </h2>
					<?php

				}

			}

			else if($num_rows2 == 1){
				?>
				<h2> Il y a <?php echo $num_rows2 ?> résultat correspondant a votre recherche : <span class="motcle"><?php echo $motcle ?></span></h2>
				<?php
			}
			else if(isset($_POST['caserecherche'])){
			?>
			<h2> Il y a <?php echo $num_rows2 ?> résultats correspondant a votre recherche : <span class="motcle"><?php echo $motcle ?></span></h2>
			<?php

			}



	for($i=$num_rows2; $i>0; $i--){
		$row2 = mysql_fetch_row($result2);
		$adresse = "Photos/".$row2[2];


	?>	

		
		

	<div id="postPhoto">

		<div id="affichagePhoto">
			<img  id="dimension" src="<?php echo $adresse ?>"/>
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
					<form method="post" action ="">
									<input type="hidden"  name="idphoto"  value="<?php echo $row2[0] ?>">
									<?php
									$photolike = mysql_query("SELECT * FROM MentionAime WHERE IDPhoto = '$row2[0]' AND IDUser = '$getid' "); 
									$photolikenum = mysql_num_rows($photolike);
									if($photolikenum == 0){
									?><input type="image" src="images/epingle.png" name="like" id="Like" value="Like"><?php
									}
									else {
										?><input type="image" src="images/epingleRouge.png" name="unlike" id="UnLike" value="UnLike"><?php
									}
									?>
					</form>
				</div>

				<div id="follow">
						<form method="post" action ="">
									<input type="hidden"  name="idphoto"  value="<?php echo $row2[0] ?>">
									<?php
									$follow = mysql_query("SELECT * FROM RelationFollow WHERE IDSuiveur=1 AND IDSuivi=4 "); 
									$Follownum = mysql_num_rows($follow);
									if($Followenum == 0){
									?><input type="image" src="images/follow.png" name="follow" id="imgFollow" value="Follow"><?php
									}
									else {
										?><input type="image" src="images/epingle.png" name="unfollow" id="UnFollow" value="UnFollow"><?php
									}
									?>
						</form>
				</div>
			</div>

				
		</div>

		
	</div>
		
		


			
<?php 

}
?>

	<div id="ajouterPhoto"> 
				<a href="AddImage.php?id=<?php echo $getid ?>"><img  src="images/boutonplus.png" id="boutonplus" onclick="new_div()"> </a>
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