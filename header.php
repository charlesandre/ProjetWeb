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
	}
?>

<header>
	<p> <a  href="Home.php?id=<?php echo $getid ?>" ><span id="logo"></span></a>
		<div id="recherche"> <form method = "post" action = ""> <input type="text" name="caserecherche" id="caserecherche" placeholder="Rechercher"/> </form></div>
		<div id="boutons"> <a class="onglet" href="MyAccount.php?id=<?php echo $getid ?>"><?php echo $login ?></a> 
						   <a class="onglet" href="Notifications.html">Notifications</a> </div> 
	</p>
</header>