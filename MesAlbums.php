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

		>
		<?php 
				$album = mysql_query("SELECT * FROM ALBUMS WHERE IDProrpio = '$getid'");
				$nombrealbums = mysql_num_rows($album);
		?>
		<br/><br/>
		<h1>Mes albums</h1>
		<?php 
				$album = mysql_query("SELECT * FROM ALBUMS WHERE IDProrpio = '$getid'");
				$nombrealbums = mysql_num_rows($album);

				if($nombrealbums == 0){
						?>
							<h3>Vous n'avez pas d'albums, vous pouvez en créer un en cliquant sur le bouton plus en bas à droite </h3>
							

						<?php
					
					if(isset($_POST['ajoutalbum'])){
						?>
						<form method = "post" action = "">
							Nom de l'album : <input type = "text" name = "nomnouvelalbum" placeholder = "Nouvel Album ...">
						</form>
						<?php

						
					}
						if(isset($_POST['nomnouvelalbum'])){
							?>
								<h4>Commencez par ajouter une photo a votre album <?php echo $_POST['nomnouvelalbum'] ?> ! </h4>
								<h4>Voici vos photos :</h4> 
								<table>
							<?php
							$mesphotos = mysql_query("SELECT * FROM Photos WHERE Proprio = '$getid'");
							$nbrmesphotos = mysql_num_rows($mesphotos);
							for($i=0; $i<$nbrmesphotos; $i++){
								?>
								<tr>
									<td>
									</td>
								</tr>
								<?php
							}
						}
				
						
					
				}
		?>
								</table>
	<div id = "ajouterPhoto">
		<form  method ="post" action =""> 
			<input id = "boutonplus" type = "image" src = "images/boutonplus.png" name ="ajoutalbum" value = "Creer un album"> 
		</form>
	</div>
		


	

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