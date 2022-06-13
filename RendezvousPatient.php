<?php
	session_start();

try
{
	// On se connecte à MySQL
	$db = new PDO('mysql:host=localhost;dbname=egosoin;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

$sqlQuery = 'SELECT * FROM consultation WHERE id =';
$rdvStatement = $db->prepare($sqlQuery);
$rdvStatement->execute();
$rdv = $rdvStatement->fetchAll();
?>

<?php $title = "Liste des rendez-vous"; ?>

<?php ob_start(); ?>
<div id="container">
<form action="listeRendezVous.php" method="POST">
	<h2>Mes rendez-vous</h2>
	<br /><br />
	<div>
				<p>Liste des rendez-vous :</p>
				<table>
					<thead>
						<tr>
							<th>Date</th>
							<th>Médecin</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>

	<br />
	<div><a class="button" href="pagedeconnexionSecretaire.php"><strong>Retour</strong></a></div>
			</div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

	
</body>

</html>