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
		
		<header>
			<p> <a  href="Home.php?id=<?php echo $getid ?>" ><span id="logo"></span></a>
				<div id="recherche"> <input type="text" name="login" id="caserecherche" placeholder="Rechercher"/> </div>
				<div id="boutons"> <a class="onglet" href="MyAccount.php?id=<?php echo $getid ?>">Profil</a> 
								   <a class="onglet" href="Notifications.html">Notifications</a> </div> 
			</p>
		</header>

 		

 		

		<div id="container">

			<h1> Mon compte </h1>
			<h2> Bienvenue <?php echo $login; ?> Comment allez vous ? </h2>



			<div id="divImageReglages">
				<a href="Reglages.php?id=<?php echo $getid ?>" id="aReglages">
					<img src="images/reglages.png" id="imageReglages"/>
				</a>
				<a href = "MesImages.php?id=<?php echo $getid ?>"> Mes Photos </a>
				<a href = "MesImagesLikees.php?id=<?php echo $getid ?>"> Les photos que j'ai aimée </a>
				<a href = "Connexion.php"> Deconnexion </a>
			</div>
			


		

		
		</div>

	</body>

	<footer>
		Charles ANDRE - Antoine DIOULOUFFET - Alexandre TUBIANA - ECE PARIS - 2016
	</footer>





</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>