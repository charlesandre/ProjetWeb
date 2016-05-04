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
				$album = mysql_query("SELECT * FROM ALBUMS WHERE IDProprio = '$getid'");
				$nombrealbums = mysql_num_rows($album);
		?>
		<br/><br/>
		<h1>Mes albums</h1>
		<?php 
				

				if (isset($_POST['SuppAlbum'])){

					$nomAlbum = $_POST['nomalbum'];

					$supprimer = mysql_query("DELETE FROM Albums WHERE Nom = '$nomAlbum'");
				}









				if($nombrealbums == 0 ){
						?>
							<h3>Vous n'avez pas d'albums, vous pouvez en créer un en cliquant sur le bouton plus en bas à droite </h3>
							

						<?php
					}
					
					if(isset($_POST['ajoutalbum'])){
						?>
						<h3> Ajouter un album </h3>
						<form method = "post" action = "">
							Choisissez un nom d'album, sa visibilité ainsi que la premeiere photo qui le composeras ! <br/>
							Nom de l'album : <input type = "text" name = "nomnouvelalbum" placeholder = "Nouvel Album ...">
						
							<?php
							
							}
						

						if (isset($_POST['nomnouvelalbum'])){
							$nomalbum = $_POST['nomnouvelalbum'];
							

							$requete = mysql_query("INSERT INTO Albums(Nom, IDProprio) VALUES('$nomalbum', '$getid')");

							header('Location: MesReglages.php?id='.$getid);
							


						}
				
						
					
				
				if($nombrealbums > 0) {

						?> 
							<h2> Vous possedez <?php echo $nombrealbums ?> albums </h2> 
							<table>
								<tr>
									<td>
										Nom de l'album 
									</td>
									<td>
										Nombre de photos
									</td>
									<td>
										Ajouter/supprimer des photos
									</td>
									<td>
										Modifier l'album
									</td>
									<td>
										Supprimer l'album
									</td>
									
								</tr>
							
						<?php
						for($j=0; $j<$nombrealbums; $j++){
							$monalbum = mysql_fetch_row($album);
							$photosdelalbum = mysql_query("SELECT * FROM PhotosAlbums P WHERE IDAlbum = '$monalbum[1]'");
							$nombrephotodansalbum = mysql_num_rows($photosdelalbum);

							?>
								<tr>
									<td>
										<?php 
										echo $monalbum[1] ;
										?>
									</td>
									<td>
										<?php echo $nombrephotodansalbum ?> <form method = "post" action = ""> <input type = "hidden" name ="idalbum" value = "<?php echo $monalbum[0]?>"> <input type = "submit" name = "voiralbum" value = "Voir les photos"> </form> 
									</td>
									<td>
										<form method = "post" action ="">
											<input type = "hidden" name ="idalbum" value = "<?php echo $monalbum[0]?>">
											<input type = "submit" name ="gererphotos" value = "Cliquer ici">
											<?php
												if(isset($_POST['gererphotos'])){
													$idalbum = $_POST['idalbum'];
													if($idalbum == $monalbum[0]){
														$mesphotos = mysql_query("SELECT * FROM Photos WHERE Proprio = '$getid'");
														$nbrmesphotos = mysql_num_rows($mesphotos);
														?> <select name ="choixnouvellephoto"> <?php
														for($k=0;$k<$nbrmesphotos;$k++){
															$maphoto = mysql_fetch_row($mesphotos);
															?>
															<option value = "<?php echo $maphoto[0] ?>"><?php echo $maphoto[1] ?> </option>
															<?php

													}
												}

													?> 
														</select>
													<input type = "submit" name = "ajoutnouvellephoto" value = "ajouter cette photo">
													<?php

												}
											?>
										</form>
									</td>
									<td>
										<form method = "post" action ="">
											<input type = "hidden" name = "nomalbum" value = "<?php echo $monalbum[1]?>">
											<input type = "submit" name ="ModAlbum" value = "Cliquer ici">
											<?php
												if (isset($_POST['ModAlbum'])){
													if($_POST['nomalbum'] == $monalbum[1]){
														?>
															<form method = "post" action = "">
																<input type = "text" name ="nouveaunomalbum" placeholder = "Nouveau nom ...">
															</form>
														<?php
													}
												}
											?>
										</form>
									</td>
									<td>
										<form method = "post" action ="">
											<input type = "hidden" name = "nomalbum" value = "<?php echo $monalbum[1]?>">
											<input type = "submit" name ="SuppAlbum" value = "Cliquer ici">
										</form>
									</td>
									
								<tr>



							<?php
						}

						if(isset($_POST['nouveaunomalbum'])){
							$nouveaunom = $_POST['nouveaunomalbum'];
							$anciennom = $_POST['nomalbum'];

							$request = mysql_query("UPDATE Albums SET Nom = '$nouveaunom' WHERE Nom = '$anciennom'");
						}

						if(isset($_POST['ajoutnouvellephoto'])){
							$idnouvellephoto= $_POST['choixnouvellephoto'];
							$idAlbum = $_POST['idalbum'];

							$request = mysql_query("INSERT INTO PhotosAlbums (IDPhoto, IDAlbum) VALUES ('$idnouvellephoto', '$idAlbum')");

						}

						if(isset($_POST['voiralbum'])){
							$nomAlbumavoir = $_POST['voiralbum'];
							$IDAlbum = $_POST['idalbum'];
							$photos = mysql_query("SELECT * FROM PhotosAlbums WHERE IDAlbum = '$IDAlbum'");
							$nbrphotos = mysql_num_rows($photos);
							for($k=0; $k<$nbrphotos;$k++){
								$photo = mysql_fetch_row($photos);
								$adresse = "Photos/".$row2[2];
								?>

									<div id="affichagePhoto">
										<img  id="dimension" src="<?php echo $adresse ?>"/>
									</div>


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