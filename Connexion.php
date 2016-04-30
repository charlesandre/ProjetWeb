<?php 

@ob_start();

	session_start();	


	$bdd = mysql_connect('localhost', 'root', 'root');
	echo "Pb 1";
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
				<img src="images/logoblanc.png" id="logoAccueil"/>
			</div>
		</header>
	

	<div id="totalConnexion">
		<div id="connexion">
			
			<div id="texteConnexion">Connexion</div>

			<div id="formConnexion">
				<form method="post" action ="" align ="center" id="formulaire">

				<div class="champConnexion">
					<label class="labelConnexion" for "login"> Pseudo </label>
					<input id ="login" type="text" name="log" required="required" placeholder="Pseudo" class="caseConnexion"/>
				</div>

				<div class="champConnexion">
					<label class="labelConnexion" for "pass"> Mot de passe </label>
					<input id ="pass" type="password" name="pass" required="required" placeholder="Mot de passe" class="caseConnexion"/>
				</div>

				<div id="validerConnexion">
					<input type = "submit" name="formconnect" value="Se connecter" id="boutonConnexion"> </input> 
				</div>

				<div id="ligneAide">
					<a class="boutonAide" href="">Mot de passe oublié ? </a> 
					<a class="boutonAide" href="CreateAccount.php">Créer un compte</a>
				</div>
						
						<?php
					if(isset($erreur))
					{
						echo "<p id='erreur'>".$erreur. "</p>";
					}
					
					?> 
					
					

				</form>
			</div>
		


			</div>

		<div id="imageAccueil">
			<img src="paysage1.png" id="diapoAccueil"/>
		</div>
			

		
	</div>

		

	<footer>
		Charles ANDRE - Antoine DIOULOUFFET - Alexandre TUBIANA - ECE PARIS - 2016
	</footer>

	<script type="text/javascript" src="script.js"> </script>

	</body>

</html>