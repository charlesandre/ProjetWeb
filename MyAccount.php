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

 		

 		

		<div id="container">

			<h1> Mon compte </h1>
			<h2> Bienvenue <?php echo $login; ?> Comment allez vous ? </h2>



			<div id="divImageReglages">
				<a href="Reglages.php?id=<?php echo $getid ?>" id="aReglages">
					<img src="images/reglages.png" id="imageReglages"/>
				</a>
				<a href = "MesImages.php?id=<?php echo $getid ?>"> Mes Photos </a>
				<a href = "MesImagesLikees.php?id=<?php echo $getid ?>"> Les photos que j'ai aimée </a>
				<a href = "MesAlbums.php?id=<?php echo $getid ?>"> Mes albums </a>
				<a href = "Connexion.php"> Deconnexion </a>
			</div>
			


		

		
		</div>

	</body>

	<?php include('footer.php'); ?>





</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>