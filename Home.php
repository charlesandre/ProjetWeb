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
			<p> <a  href="Home.php"><span id="logo"></span></a>
				<div id="recherche"> <input type="text" name="login" id="caserecherche" placeholder="Rechercher"/> </div>
				<div id="boutons"> <a class="onglet" href="MyAccount.html">Profil</a> 
								   <a class="onglet" href="Notifications.html">Notifications</a> </div> 
			</p>
		</header>

		<div id="ajouterPhoto"> <img  src="images/boutonplus.png" id="boutonplus" onclick="new_div()"> </div>
		<div id="elementParent">
  <span id="elementEnfant">foo bar</span>
</div>

		<div>
			Bienvenue  :   <?php echo $login; ?> t'es trop beau! 
		</div>
		<?php

			if(isset($erreur))
			{
				echo '<font color = "red">'.$erreur. "</font>";
			}
			
		?>
		


		<!--<div id="testHome">
			<img src="paysage1.png"/>
		</div>

		<div id="caseCommentaire">
		</div>-->









	

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