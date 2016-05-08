<?php
session_start();
$bdd = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('bdd', $bdd);

	


	

if(isset($_GET['id']) AND $_GET['id']>=0)
{
	$getidphoto = intval($_GET['id']);
	$maphoto = mysql_query("SELECT * FROM Photos WHERE ID = '$getidphoto' ");
	$maphoto = mysql_fetch_row($maphoto);
	if(isset($_GET['idU'])){
		$getid = $_GET['idU'];
	}
	$adresse = "Photos/".$maphoto[2];

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
			<h1> VOici ta photo <?php echo $getid ?> </h1>

		<?php
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

			if (isset($_POST['modificationvisi']))
	{
		
			$idPhoto = $_POST['idphoto'];
			$nouvellevisi = $_POST['visibilité']; 
							
			$result = mysql_query("UPDATE Photos SET Visibilite = '$nouvellevisi' WHERE ID = '$idPhoto'");

	}

	if (isset($_POST['supphoto']))
	{
		
			$idPhoto = $_POST['idphoto'];
			$result = mysql_query("DELETE FROM Photos WHERE ID = '$idPhoto' ");

	}

		?>

		
		<div id="postPhoto">

		<div id="affichagePhoto">
			<img  id="laPhoto" src="<?php echo $adresse ?>"/>
		</div>

		<div id="legende">
			<div id="description">
				<?php 
					$message = '"'.$maphoto[1] .'"';
					echo $message;
				?>
			</div>
			<div id="auteur">
				<?php 
					$resultAuteur = mysql_query("SELECT Login FROM Users WHERE ID = '$maphoto[5]'");
					$rowAuteur = mysql_fetch_row($resultAuteur);
					$auteur = $rowAuteur[0];
					echo $auteur;
				?> 
			</div>
			<div id="date">
				<?php echo $maphoto[4] ?> 
			</div>
			<div id="lieu">
				<?php echo $maphoto[3] ?> 
			</div>

			<div id="boutonsImage">

				<div id="epingle">
					<form name = "like" id ="formLike" method="post" action ="">
						<input type="hidden"  name="idphoto"  value="<?php echo $maphotomaphoto[0] ?>">
						<?php
							$photolike = mysql_query("SELECT * FROM MentionAime WHERE IDPhoto = '$maphoto[0]' AND IDUser = '$getid' "); 
							$photolikenum = mysql_num_rows($photolike);
							$like = mysql_query("SELECT * FROM MentionAime WHERE IDPhoto = '$maphoto[0]'");
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
							<input type="hidden"  name="idprop"  value="<?php echo $maphoto[5] ?>">
							<?php
							$follow = mysql_query("SELECT * FROM RelationFollow WHERE IDSuiveur = '$getid' AND IDSuivi = '$maphoto[5]' "); 
							$Follownum = mysql_num_rows($follow);
							$numberfollower = mysql_query("SELECT * FROM RelationFollow WHERE IDSuivi = '$maphoto[5]'");
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

			<div id="infosSup">
				<form name "formInfos" id="formInfos" method="post" action ="">
					<input type="image" src="images/infos.png" name="infos" id="imageInfos">
				</form>
			</div>

			<?php 
					if($maphoto[5] == $getid) {
						?>

							<form method="post" action ="">
							<input type="hidden"  name="idphoto"  value="<?php echo $row2[0] ?>">
								<select name="visibilité">
									<?php
									$result3 = mysql_query("SELECT * FROM Photos WHERE ID = '$row2[0]'");
									$row3 = mysql_fetch_row($result3);
									if($row3[6] == 'Public'){
									?><option value="Public">Public</option>
									<option value="Privee">Privee</option><?php
									}
									else {
										?><option value="Privee">Privee</option>
										<option value="Public">Public</option><?php
									}
									?>
								</select>
							<input type="submit" name="modificationvisi" id="modificationvisi" value="Modifier">
						</form>
						<form method="post" action ="">
							<input type="hidden"  name="idphoto"  value="<?php echo $row2[0] ?>">
							<input type="submit" name="supphoto" id="supphoto" value="Supprimer la Photo">
						</form>

						<?php

					}



			?>
				

			<div id="caseCommentaire">
				<?php 
					$requetenombrecomm = mysql_query("SELECT * FROM Commentaires WHERE IDPhoto = '$maphoto[0]'");
					$nombrecom = mysql_num_rows($requetenombrecomm);
					?>
					<div id="nbCom">
						<?php echo $nombrecom ?> commentaires
					</div>
				
				<form name ="comment" method="post" action ="">
					<input type="hidden"  name="idphoto"  value="<?php echo $maphoto[0] ?>">
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
		
	<div id="submitReglages">
					<a  href="MyAccount.php?id=<?php echo $getid ?>" >
						<input type = "submit" name="formmodif" value="Retour" id="boutonReglages"> </input> 
					</a>
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