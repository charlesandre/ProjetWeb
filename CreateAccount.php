<?php 
@ob_start();
	
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


	if (isset($_POST['formregister']))
	{
		if(!empty($_POST['log']) AND !empty($_POST['email']) AND !empty($_POST['pass']) AND !empty($_POST['pass2']))
		{
			$login = htmlspecialchars($_POST['log']);
			$email = htmlspecialchars($_POST['email']);
			$pw1 = htmlspecialchars($_POST['pass']);
			$pw2 = htmlspecialchars($_POST['pass2']);

			if($pw1 == $pw2)
			{

				$result = mysql_query("INSERT INTO Users (Login, Email, Password)  
             VALUES ('$login', '$email', '$pw1')");
				if($result)
				{
					$result2 = mysql_query("SELECT ID FROM Users WHERE Login = '$login' AND Email = '$email'");
					$num_rows = mysql_num_rows($result2);
					$row = mysql_fetch_row($result);
					$ID = $row[0];
			
					header('Location: Connexion.php');
					exit;
				}
				
				
			}
			else
			{
				$erreur = "Les mots de passe sont différents";
			}
		}	
		else
		{
			$erreur = "All fields must be completed";		}
		
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
					<img src="images/logoblanc.png" alt="" id="logoAccueil"/>
				</div>
			</header>

		<div id="totalInscription">

			<div id="imageAccueilInscription">
				<img src="paysage1.png" alt="" id="diapoAccueil"/>
			</div>
			
			<div id="inscription">
				
				<div id="texteInscription">Inscription</div>

				<div id="formInscription">
					<form method="post" action ="" align ="center" id="formulaire">

					<div class="champInscription">
						<label class="labelConnexion" for "login"> Pseudo </label>
						<input id ="login" type="text" name="log" required="required" placeholder="Pseudo" class="caseConnexion"/>
					</div>

					<div class="champInscription">
						<label class="labelConnexion" for "email"> E-mail </label>
						<input id ="email" type="TEXT" name="email"  required="required" placeholder="E-mail" class="caseConnexion" />
					</div>

					<div class="champInscription">
						<label class="labelConnexion" for "pass"> Mot de passe </label>
						<input id ="pass" type="password" name="pass"  required="required" placeholder="Mot de passe" class="caseConnexion"/>
					</div>

					<div class="champInscription">
						<label class="labelConnexion" for "pass2"> Confirmer le mot de passe </label>
						<input id ="pass2" type="password" name="pass2"  required="required" placeholder="Confirmer le mot de passe" class="caseConnexion"/>
					</div>

					<div id="validerInscription">
						<input type = "submit" name="formregister" value="S'inscrire" id="boutonInscription"> </input> 
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
				
			
			

		
	</div>

		
			
		<script type="text/javascript" src="script.js"> </script>
		
		<footer>
			Charles ANDRE - Antoine DIOULOUFFET - Alexandre TUBIANA - ECE PARIS - 2016
		</footer>

		

	</body>

</html>


