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

				$result = mysql_query("INSERT INTO Users (Login, Password)  
             VALUES ('$login', '$pw1')");
				if($result)
				{
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
					<p  id="bienvenue">Nom du site</p>
				</div>
			</header>
		

		<div id="inscription">
			
			
			<form method="post" action ="" align ="center" id="formulaireInscription">
				<p id="texteInscription">Inscription</p>
				<div id="champForm">
				<table>
					<tr>
						<td class="champInscription">
							<label for "login"> Pseudo </label>
						</td>
						<td>
							<input id ="login" type="text" name="log" required="required" placeholder="Pseudo" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td class="champInscription">
							<label for "email"> E-mail </label>
						</td>
						<td>
							<input id ="email" type="TEXT" name="email"  required="required" placeholder="E-mail" class="caseConnexion" />
						</td>
					</tr>
					<tr>
						<td class="champInscription">
							<label for "pass"> Mot de passe </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass"  required="required" placeholder="Mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td class="champInscription">
							<label for "pass2"> Confirmer le mot de passe </label>
						</td>
						<td>
							<input id ="pass2" type="password" name="pass2"  required="required" placeholder="Confirmer le mot de passe" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
					<td id="tdInscription" colspan="2">
						<input type = "submit" name="formregister" value="S'inscrire" id="boutonInscription"> </input> 
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

			<div id="imageAccueilInscription">
				<img src="paysage1.png" id="diapoAccueil"/>
			</div>
			
		<script type="text/javascript" src="script.js"> </script>
		
		<footer>
			Charles ANDRE - Antoine DIOULOUFFET - Alexandre TUBIANA - ECE PARIS - 2016
		</footer>

		

	</body>

</html>


