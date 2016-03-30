<?php 
@ob_start();

	session_start();	

	$bdd = mysql_connect('localhost', 'root', 'root');
	if (!$bdd) 
		{
    die('Not connected : ' . mysql_error());
		}

	$db_selected = mysql_select_db('bdd', $bdd);
	if (!$db_selected) 
		{
    die ('Can\'t use foo : ' . mysql_error());
		}


	if (isset($_POST['formconnect']))
	{
		if(!empty($_POST['log']) AND !empty($_POST['pass']))
		{
			$login=$_POST['log'];
			$pass=$_POST['pass'];


			$result = mysql_query("SELECT * FROM Users WHERE Login = '$login' AND Password = '$pass'");
			$num_rows = mysql_num_rows($result);

			if($num_rows ==1)
			{
				$row = mysql_fetch_row($result);
				$_SESSION['ID'] = $row[0];
				$_SESSION['Login'] = $row[1];
				header('Location: Home.php?id='.$_SESSION['ID']);

			}	
			else
			{
				$erreur = "Pseudo ou mot de passe incorrect";
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
		<title>Index</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script:700' rel='stylesheet' type='text/css'>
	</head>


	<body>

		<header>
			
			<div id="headerConnexion">
				<p  id="bienvenue">Nom du site</p>
			</div>
		</header>
	

	<div id="connexion">
		
	
		<form method="post" action ="" align ="center" id="formulaire">
			<p id="texteConnexion">Connexion</p>
			<table>
				<tr>
					<td class="champConnexion">
						<label for "login"> Pseudo </label>
					</td>
					<td>
						<input id ="login" type="text" name="log" required="required" placeholder="Pseudo" class="caseConnexion"/>
					</td>
				</tr>
				
				<tr>
					<td class="champConnexion">
						<label for "pass"> Mot de passe </label>
					</td>
					<td>
						<input id ="pass" type="password" name="pass" required="required" placeholder="Mot de passe" class="caseConnexion"/>
					</td>
				</tr>

				<tr>
					<td id="tdConnexion" colspan="2">
						<input type = "submit" name="formconnect" value="Se connecter" id="boutonConnexion"> </input> 
					</td>
				</tr>
				<tr id="ligneAide">
					<td class="boutonAide">
						<a href="">Mot de passe oublié ? </a> 
					</td>
					<td class="boutonAide">
						<a href="CreateAccount.php">Créer un compte</a>
					</td>
				</tr>
			</table>
				
				
				
				<?php
			if(isset($erreur))
			{
				echo "<p id='erreur'>".$erreur. "</p>";
			}
			
			?> 
			
			

		</form>

		<div id="imageAccueil">
			<img src="paysage1.png" id="diapoAccueil"/>
		</div>
		

	</div>

		
		

	<div id="container">
			</div>

	<footer>
		Charles ANDRE - Antoine DIOULOUFFET - Alexandre TUBIANA - ECE PARIS - 2016
	</footer>

	<script type="text/javascript" src="script.js"> </script>

	</body>

</html>