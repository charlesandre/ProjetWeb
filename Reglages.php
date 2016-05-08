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

if (isset($_POST['formmodif']))
	{
		if(!empty($_POST['log']) AND !empty($_POST['email']) AND !empty($_POST['pass']) AND !empty($_POST['pass2']) AND !empty($_POST['pass3']))
		{
			
			$loginform = htmlspecialchars($_POST['log']);
			$emailform = htmlspecialchars($_POST['email']);
			$pw1 = htmlspecialchars($_POST['pass']);
			$pw2 = htmlspecialchars($_POST['pass2']);
			$pw3 = htmlspecialchars($_POST['pass3']);

			if(!empty($_FILES))
			{
				// fonction présent dans le fichier imgClass
				$img=$_FILES['avatar'];
				//strtolower: Renvoie une chaîne en minuscules substr:           Retourne un segment de chaîne
				$ext= strtolower(substr($img['name'],-3));
				$allow_ext=array('jpg','png','gif');
				if(in_array($ext,$allow_ext))
				{
					//Déplace un fichier téléchargé
					move_uploaded_file($img['tmp_name'],"Avatars/".$img['name']); 
					$avatar = $img['name'];
				}
			}
			else
			{
				$erreur ="Votre fichier n'est pas une image"; 
			}
		

			if($pw2 == $pw3)
			{
				if($pw1 == $pw){

				$result = mysql_query("UPDATE Users SET Login = '$loginform', Email = '$emailform', Password = '$pw3' , Avatar = $avatar WHERE ID = '$getid' ");
					if($result)
					{
						header('Location: Home.php?id=<?php echo $getid ?>');
						
					}
				}
				else 
				{
					$erreur = "L'ancien mot de passe ne correspond pas";
				}
				
			}
			else
			{
				$erreur = "Les mots de passe sont différents";
			}
		}	
		else
		{
			$erreur = "All fields must be completed";		
		}
		
	}

	
 

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Réglages</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>
		
	</head>

	<body>
		
		<?php include('header.php'); ?>

	<div id="reglages">
			
			<div id="texteReglages">Modifier mes informations</div>

			<div id="formReglages">
				<form  method="post" action ="" align ="center" id="formulaireReglages">

				<div class="champReglages">
					<label class="labelConnexion" for "avatar"> Avatar </label>
					<input id ="changerAvatar" type="file" name="avatar" required="required" class="caseReglages"/>
				</div>

				<div class="champReglages">
					<label class="labelConnexion" for "login"> Pseudo </label>
					<input id ="login" type="text" name="log" required="required" placeholder="<?php echo $login; ?>" class="caseReglages"/>
				</div>

				<div class="champReglages">
					<label class="labelConnexion" for "email"> E-mail</label>
					<input id ="email" type="TEXT" name="email"  required="required" placeholder="<?php echo $email; ?>" class="caseReglages" />				
				</div>

				<div class="champReglages">
					<label class="labelConnexion" for "pass"> Ancien mot de passe </label>
					<input id ="pass" type="password" name="pass"  required="required" placeholder="Ancien mot de passe" class="caseReglages"/>
				</div>

				<div class="champReglages">
					<label class="labelConnexion" for "pass2"> Nouveau mot de passe </label>
					<input id ="pass" type="password" name="pass2"  required="required" placeholder="Nouveau mot de passe" class="caseReglages"/>
				</div>

				<div class="champReglages">
					<label class="labelConnexion" for "pass3"> Confirmer le nouveau mot de passe </label>
					<input id ="pass2" type="password" name="pass3"  required="required" placeholder="Nouveau mot de passe" class="caseReglages"/>
				</div>

				<div id="submitReglages">
					<input type = "submit" name="formmodif" value="Sauvegarder" id="boutonReglages"> </input> 
				</div>
						
						<?php
					if(isset($erreur))
					{
						echo "<p id='erreurReglages'>".$erreur. "</p>";
					}
					
					?> 
					
					

				</form>
		</div>
		


	</div>	
 		
<!--
	<div id ="reglages">
				<form method="post" action ="" align ="center">
				<p id="texteReglages">Modifier mes informations</p>
				<table>
					<tr>
						<td class="champReglages">
							<label for "login"> Pseudo : </label>
						</td>
						<td>
							<input id ="login" type="text" name="log" required="required" placeholder="<?php echo $login; ?>" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td class="champReglages">
							<label for "email"> E-mail : </label>
						</td>
						<td>
							<input id ="email" type="TEXT" name="email"  required="required" placeholder="<?php echo $email; ?>" class="caseConnexion" />
						</td>
					</tr>
					<tr>
						<td class="champReglages">
							<label for "pass">Ancien mot de passe </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass"  required="required" placeholder="Ancien mot de passe" class="caseConnexion"/>
						</td>
					</tr>

					<tr>
						<td class="champReglages">
							<label for "pass">Nouveau mot de passe </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass2"  required="required" placeholder="Nouveau mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td class="champReglages">
							<label for "pass2"> Confirmer le nouveau mot de passe </label>
						</td>
						<td>
							<input id ="pass2" type="password" name="pass3"  required="required" placeholder="Nouveau mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td id="tdReglages" colspan="2">
							<input type = "submit" name="formmodif" value="Sauvegarder" id="boutonReglages"> </input> 
						</td>
					</tr>

				</table>


					

			

			<?php
			//if(isset($erreur))
			{
				//echo "<p id='erreurReglages'>".$erreur. "</p>";
			}
			?>

					
			</form>


	</div>

	-->

	</body>

	<?php include('footer.php'); ?>





</html>
<?php

}

else{
header("Location: Connexion.php");
}
?>