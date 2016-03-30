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
				$erreur = "Paswords doesn't match";
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
			
			
			<form method="post" action ="" align ="center">
				<p id="texteInscription">Inscription</p>
				<table>
					<tr>
						<td id="champInscription">
							<label for "login"> Login : </label>
						</td>
						<td>
							<input id ="login" type="text" name="log" placeholder="Your Login" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td id="champInscription">
							<label for "email"> E-mail : </label>
						</td>
						<td>
							<input id ="email" type="TEXT" name="email" placeholder="Your E-Mail" class="caseConnexion" />
						</td>
					</tr>
					<tr>
						<td id="champInscription">
							<label for "pass"> Password : </label>
						</td>
						<td>
							<input id ="pass" type="password" name="pass" placeholder="Your Password" class="caseConnexion"/>
						</td>
					</tr>
					<tr>
						<td id="champInscription">
							<label for "pass2"> Repeat Your Password : </label>
						</td>
						<td>
							<input id ="pass2" type="password" name="pass2" placeholder="Your Password" class="caseConnexion"/>
						</td>
					</tr>
				</table>
					<br/>
					<input type = "submit" name="formregister" value="Register !"> </input> 
					<br/><br/>
					<?php
				if(isset($erreur))
				{
					echo '<font color = "red">'.$erreur. "</font>";
				}
			?>

			</form>
			

		</div>

			
			

		<div id="container">
				</div>

		<footer>
			Charles ANDRE - Antoine DIOULOUFFET - Alexandre TUBIANA - ECE PARIS - 2016
		</footer>

	</body>

</html>


