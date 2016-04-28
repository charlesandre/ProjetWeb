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
		if (isset($_POST['like']))
			{
				
					$idPhoto = $_POST['idphoto'];
					$idUser = $getid;

					$result = mysql_query("INSERT INTO MentionAime (IDPhoto, IDUser)  
		             VALUES ('$idPhoto', '$idUser')");
			
				
			}

			for($i=$num_rows2; $i>0; $i--){
				$result2 = mysql_query("SELECT * FROM Photos WHERE ID = '$i'");
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
			<div id="auteur">
				<?php echo $row2[6] ?> 
			</div>
			<div id="description">
				<?php echo $row2[1] ?>
			</div>
			<div id="date">
				<?php echo $row2[5] ?> 
			</div>
			<div id="lieu">
				<?php echo $row2[4] ?> 
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