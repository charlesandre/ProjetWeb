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

	$result2 = mysql_query("SELECT P.* FROM Photos P, PhotosAlbums A WHERE P.ID = A.IDPhoto AND A.IDAlbum = '$getidalbum'");
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
<h1> Il y a <?php echo $getid ?> Photos dans votre album </h1>
	
	<?php include('header.php'); 

		for($j=$num_rows2; $j>0; $j--){
	$row2 = mysql_fetch_row($result2);
	$adresse = "Photos/".$row2[2];


	?>	

		
		

	<div id="postPhoto">

		<div id="affichagePhoto">
			<img  id="laPhoto" src="<?php echo $adresse ?>"/>
		</div>

		
	</div>
		
		


			
<?php 

}



	 include('boutonPlus.php'); 
	 include('footer.php'); ?>


	<script type="text/javascript" src="script.js"> </script>

	</body>

</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>