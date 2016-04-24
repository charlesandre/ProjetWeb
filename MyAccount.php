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

			if($pw2 == $pw3)
			{
				if($pw1 == $pw){

				$result = mysql_query("UPDATE Users SET Login = '$loginform', Email = '$emailform', Password = '$pw3' WHERE ID = '$getid'");
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


			<div id ="modificationinfo">
				<form method="post" action ="" align ="center">
				<p id="texteInscription">Modifier mes informations</p>
				<div>
				<table>
					<tr>
						<td>
							<label for "login"> Pseudo : </label>
						</td>
						<td>
							<input id ="login" type="text" name="log" required="required" placeholder="<?php echo $login; ?>" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for "email"> E-mail : </label>
						</td>
						<td>
							<input id ="email" type="TEXT" name="email"  required="required" placeholder="<?php echo $email; ?>" class="caseConnexion" />
						</td>
					</tr>
					<tr>
						<td>
							<label for "pass">Ancien mot de passe </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass"  required="required" placeholder="Ancien mot de passe" class="caseConnexion"/>
						</td>
					</tr>

					<tr>
						<td>
							<label for "pass">Nouveau mot de passe </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass2"  required="required" placeholder="Nouveau mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for "pass2"> Confirmer le nouveau mot de passe </label>
						</td>
						<td>
							<input id ="pass2" type="password" name="pass3"  required="required" placeholder="Nouveau mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
					<td>
						<input type = "submit" name="formmodif" value="Sauvegarder les modifications"> </input> 
					</td>
				</tr>

				</table>


					
				</div>

			

			<?php
			if(isset($erreur))
			{
				echo "<p id='erreurInscription'>".$erreur. "</p>";
			}
			?>

					
			</form>


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