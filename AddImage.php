<?php
include_once('cookie_connect.php');	
$bdd = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('bdd', $bdd);


if(isset($_GET['id']) AND $_GET['id']>0)
{
	$getid = intval($_GET['id']);
	$result = mysql_query("SELECT * FROM Users WHERE ID = '$getid'");
	$row = mysql_fetch_row($result);
	$login = $row[1];


	if (isset($_POST['importer']))
	{
			
		$NomImage = htmlspecialchars($_POST['NomImg']);
		$Lieu = htmlspecialchars($_POST['lieu']);
		$Visibilité = htmlspecialchars($_POST['visibilité']);
		
		
		if(!empty($_FILES))
			{
			// fonction présent dans le fichier imgClass
		$img=$_FILES['img'];
		//strtolower: Renvoie une chaîne en minuscules substr:           Retourne un segment de chaîne
		$ext= strtolower(substr($img['name'],-3));
		$allow_ext=array("jpg",'png','gif');
		if(in_array($ext,$allow_ext))
			{
			//Déplace un fichier téléchargé
			move_uploaded_file($img['tmp_name'],"Photos/".$img['name']); 
			$Adresse = $img['name'];


			}
		else
			{
			$erreur ="Votre fichier n'est pas une image"; 
			}
		}

		if(!empty($_POST['NomImg']) AND !empty($_POST['lieu']))
		{

		


			
			$result = mysql_query("INSERT INTO Photos (Nom, Adresse, Lieu, Proprio, Visibilite)
             VALUES ('$NomImage', '$Adresse', '$Lieu', '$getid', '$Visibilité')");
				if($result)
				{
					header('Location: Home.php?id='.$_SESSION['ID']);
					exit;
				}
		}
	else
	{
		$erreur = "Veuillez remplir tous les champs";

	}
			
	
		
	}
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
		

	<div id = "caseAjout">

		Ajouter une photo
		
		<form method="POST" action="" enctype="multipart/form-data">
		
		<div class="formAjout">
			<div class="labelAjout">
				Charger l'image
			</div>
			<div class="champAjout">
				<input type="file" id="file" name="img"/>
			</div>
		</div>

		<div class="formAjout">
			<div class="labelAjout">
				Entrer la légende
			</div>
			<div class="champAjout">
				<textarea name="NomImg" id="Nom_Fichier"></textarea>
			</div>
		</div>

		<div class="formAjout">
			<div class="labelAjout">
				Entrer le lieu
			</div>
			<div class="champAjout">
				<input type="text" name="lieu" id="Lieu" />
			</div>
		</div>

		<div class="formAjout">
			<div class="labelAjout">
				Choisir la confidentialité
			</div>
			<div  class="champAjout">
				<select name="visibilité">
					<option value="Public">Public</option>
					<option value="Privee">Privee</option>
				</select>
			</div>
		</div>

		<div id="submitImage">
			<input type="submit" name="importer" id="Importer" value="Valider"></code>
		</div>

	</div>

		<!--
		<li>chargez votre image</li>		
		<input type="file" id="file" name="img"/>
		</br>
		</br>
		<li>Nom de l'image</li>
		<input type="text" name="NomImg" id="Nom_Fichier"/>
		</br>
		</br>
		<li>Lieu</li>
		<input type="text" name="lieu" id="Lieu" />
		</br>
		</br>
		<li>Confidentialité</li>
		<select name="visibilité">
			<option value="Public">Public</option>
			<option value="Privee">Privee</option>
		</select>
		</br>
		</br>
		<li>Description</li>
		<textarea name="legende"></textarea>
		</br>
		</br>
		<input type="submit" name="importer" id="Importer" value="GO"></code>
		</br>
		</form>
		<?php
			//if(isset($erreur))
			{
				//echo "<p id='erreurInscription'>".$erreur. "</p>";
			}
	?>
</div> -->


		<?php include('footer.php'); ?>


	</body>

</html>
<?php

}
else{
header("Location: Connexion.php");
}
?>