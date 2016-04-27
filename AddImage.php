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
		$Date = htmlspecialchars($_POST['date']);
		$Lieu = htmlspecialchars($_POST['lieu']);
		$Visibilité = htmlspecialchars($_POST['visibilité']);
		$Legende = htmlspecialchars($_POST['legende']);
		
		
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

		if(!empty($_POST['NomImg']) AND !empty($_POST['date']) AND !empty($_POST['date']) AND !empty($_POST['lieu']) AND !empty($_POST['legende']))
		{

		


			
			$result = mysql_query("INSERT INTO Photos (Nom, Adresse, Legende, Lieu, Daate, Proprio, Visibilite)
             VALUES ('$NomImage', '$Adresse','$Legende', '$Lieu', '$Date', '$getid', '$Visibilité')");
				if($result)
				{
					header('Location: Homeee.php?id='.$_SESSION['ID']);
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
			<header>
				<p> <a  href="Home.php?id=<?php echo $getid ?>" ><span id="logo"></span></a>
					<div id="recherche"> <input type="text" name="login" id="caserecherche" placeholder="Rechercher"/> </div>
					<div id="boutons"> <a class="onglet" href="MyAccount.php?id=<?php echo $getid ?>">Profil</a> 
									   <a class="onglet" href="Notifications.html">Notifications</a> </div> 
				</p>
			</header>

	<div id = "container">
		<br/><br/>
		Bienvenue  :   <?php echo $login; ?> t'es trop beau! 
		Ton numero d'utilisateur est le : <?php echo $getid ?> ! 
		<form method="POST" action="" enctype="multipart/form-data">
	</br>
		</br>
		<li>chargez votre image</li>		
		<input type="file" id="file" name="img"/>
		</br>
		</br>
		<li>Nom de l'image</li>
		<input type="text" name="NomImg" id="Nom_Fichier"/>
		</br>
		</br>
		<li>Date</li>
		<input type="date" name="date" placeholder="JJ/MM/AAAA" id="Date"/>
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
			if(isset($erreur))
			{
				echo "<p id='erreurInscription'>".$erreur. "</p>";
			}
	?>
</div>


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