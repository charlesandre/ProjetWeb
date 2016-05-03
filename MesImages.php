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

	$result2 = mysql_query("SELECT * FROM Photos WHERE  Proprio = '$getid'");
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
					<div id="recherche"> <input type="text" name="login" id="caserecherche" placeholder="Rechercher"/> </div>
					<div id="boutons"> <a class="onglet" href="MyAccount.php?id=<?php echo $getid ?>">Profil</a> 
									   <a class="onglet" href="Notifications.html">Notifications</a> </div> 
				</p>
			</header>

		<div id="ajouterPhoto"> 
				<a href="AddImage.php?id=<?php echo $getid ?>"><img  src="images/boutonplus.png" id="boutonplus" onclick="new_div()"> </a>
		</div>
		
		<table>	
		
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

			$result2 = mysql_query("SELECT * FROM Photos WHERE Proprio = '$getid'");
			$num_rows2 = mysql_num_rows($result2);
			if ($num_rows2 == 0) {

			?>
			<h2> Vous n'avez aimée aucune photo ! </h2>
			<?php
			

			}


	for($i=$num_rows2; $i>0; $i--){
		$row2 = mysql_fetch_row($result2);
		$adresse = "Photos/".$row2[2];


?>	
<tr>
	<td>

			<div>
				<img src="<?php echo $adresse ?>"/>
			</div>
	</td>
	<td>
			<table>
				<tr>
					<?php echo $row2[1] ?>
				</tr>
				<tr>
					<td>
						Legende : 
					</td>
					<td>
						<?php echo $row2[3] ?> 
					<td>
				</tr>
				<tr>
					<td>
						Lieu : 
					</td>
					<td>
						<?php echo $row2[4] ?> 
					<td>
				</tr>
				<tr>
					<td>
						Date : 
					</td>
					<td>
						<?php echo $row2[5] ?> 
					<td>
				</tr>
				<tr>
					<td>
						Auteur  : 
					</td>
					<td>
						<?php echo $row2[6] ?> 
					<td>
				</tr>
				<tr>
					<td>
						<form method="post" action ="">
							<input type="hidden"  name="idphoto"  value="<?php echo $row2[0] ?>">
							<?php
							$photolike = mysql_query("SELECT * FROM MentionAime WHERE IDPhoto = '$row2[0]' AND IDUser = '$getid' "); 
							$photolikenum = mysql_num_rows($photolike);
							if($photolikenum == 0){
							?><input type="submit" name="like" id="Like" value="Like"><?php
							}
							else {
								?><input type="submit" name="unlike" id="UnLike" value="UnLike"><?php
							}
							?>
						</form>
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
					</td>
				</tr>
			</table>

	</td>

<tr>
			
<?php 

}
?>
</table>



	

		<footer>
			Charles ANDRE - Antoine DIOULOUFFET - Alexandre TUBIANA - ECE PARIS - 2016
		</footer>

	<script type="text/javascript" src="script.js"> </script>

	</body>

</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>