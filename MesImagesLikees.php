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

			$result2 = mysql_query("SELECT Nom, Adresse, Legende, Lieu, Daate, Visibilite  FROM Photos P, MentionAime M WHERE '$getid' = M.IDUser AND P.ID = M.IDPhoto");


			for($i=$num_rows2; $i>0; $i--){
				$row2 = mysql_fetch_row($result2);
				$adresse = "Photos/".$row2[1];


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
					<?php echo $row2[0] ?>
				</tr>
				<tr>
					<td>
						Legende : 
					</td>
					<td>
						<?php echo $row2[2] ?> 
					<td>
				</tr>
				<tr>
					<td>
						Lieu : 
					</td>
					<td>
						<?php echo $row2[3] ?> 
					<td>
				</tr>
				<tr>
					<td>
						Date : 
					</td>
					<td>
						<?php echo $row2[4] ?> 
					<td>
				</tr>
				<tr>
					<td>
						Auteur  : 
					</td>
					<td>
						<?php echo $row2[5] ?> 
					<td>
				</tr>
				<tr>
					<td>
						<form method="post" action ="">
							<input type="hidden"  name="idphoto"  value="<?php echo $i ?>">
							<input type="submit" name="like" id="Like" value="Like">
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