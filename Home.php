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
	
<header>
	<p> <a  href="Home.php?id=<?php echo $getid ?>" ><span id="logo"></span></a>
		<div id="recherche"> <form method = "post" action = ""> <input type="text" name="caserecherche" id="caserecherche" placeholder="Rechercher"/> </form></div>
		<div id="boutons"> <a class="onglet" href="MyAccount.php?id=<?php echo $getid ?>">Profil</a> 
						   <a class="onglet" href="Notifications.html">Notifications</a> </div> 
	</p>
</header>

	<?php

		if(isset($_POST['caserecherche'])){
			$motcle = $_POST['caserecherche'];
			$result2 = mysql_query("SELECT DISTINCT P.ID, P.Nom, P.Adresse, P.Legende, P.Lieu, P.Daate, P.Visibilite FROM Photos P, Users U WHERE P.Visibilite = 'Public' AND (P.Nom LIKE '%$motcle%' OR (P.Proprio = U.ID AND U.Login LIKE '%$motcle%') OR (P.Lieu LIKE '%$motcle%'))");
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
			

			?> <br/><br/><br/> <?php

			if ($num_rows2 == 0) {
				if(isset($_POST['caserecherche'])){
			?>
			<h2> Aucune photo ne correspond à votre recherche pour : <?php echo $motcle ?> </h2>
			<?php
			}
			else {
				?>
			<h2> Nous n'avons pas de photos a vous montrer, ajoutez des photos en cliquant sur le bouton plus en bas a droite ou ajoutez des amis ! </h2>
			<?php

			}

			}
			else if(isset($_POST['caserecherche'])){
			?>
			<h2> Il y a <?php echo $num_rows2 ?> résultat(s) correspondant a votre recherche : <?php echo $motcle ?></h2>
			<?php

			}



	for($i=$num_rows2; $i>0; $i--){
		$row2 = mysql_fetch_row($result2);
		$adresse = "Photos/".$row2[2];


	?>	

		
		<div id="ajouterPhoto"> 
				<a href="AddImage.php?id=<?php echo $getid ?>"><img  src="images/boutonplus.png" id="boutonplus" onclick="new_div()"> </a>
		</div>

	<div id="postPhoto">

		<div id="affichagePhoto">
			<img  id="dimension" src="<?php echo $adresse ?>"/>
		</div>

		<div id="legende">
			<div id="description">
				<?php echo $row2[1] ?>
			</div>
			<div id="auteur">
				<?php 
					$resultAuteur = mysql_query("SELECT Login FROM Users WHERE ID = '$row2[6]'");
					$rowAuteur = mysql_fetch_row($resultAuteur);
					$auteur = $rowAuteur[0];
					echo $auteur;
				?> 
			</div>
			<div id="date">
				<?php echo $row2[5] ?> 
			</div>
			<div id="lieu">
				<?php echo $row2[4] ?> 
			</div>
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

				
		</div>

		
	</div>
		
		


			
<?php 

}
?>



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