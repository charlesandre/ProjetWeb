<?php
session_start();
$bdd = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('bdd', $bdd);

	


	

if(isset($_GET['id']) AND $_GET['id']>0)
{
	$getidphoto = intval($_GET['idp']);

	$getid = intval($_GET['id']);

	$result = mysql_query("SELECT * FROM Photos WHERE ID = '$getidphoto'");
	$row = mysql_fetch_row($result);
	$legende = $row[1];


?>

<html>

	<head>
		<meta charset="utf-8" />
		<title>Index</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>

	</head>
		<?php include('header.php'); ?>


	<body>
		<div>
			<h1> Photo : <span id='legendeExif'> <?php echo $legende  ?> </span></h1>
			<?php
			$photos = mysql_query("SELECT * FROM Photos WHERE ID = '$getidphoto'");
			$maphoto = mysql_fetch_row($photos);
			$adresse = "Photos/".$maphoto[2];

			$exif = exif_read_data($adresse, 0, true);

			?>

			<div id="conteneurExif">

				<div id="caseExif">

					<?php

					foreach ($exif as $key => $section) 
								{
									foreach ($section as $name => $val) 
									{
										echo "$key.$name: $val<br />\n";
									}
								}

					?>

				</div>
			</div>
		</div>

		<div id="submitReglages">
			<a  href="Home.php?id=<?php echo $getid ?>" >
				<input type = "submit" name="formmodif" value="Retour" id="boutonReglages"> </input> 
			</a>
		</div>


		
			<?php include('footer.php'); ?>
	</body>
</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>
