<?php
	session_start();


try
{
	// On se connecte à MySQL
	$mysqlClient = new PDO('mysql:host=localhost;dbname=egosoin;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}
if(isset($_SESSION['utilisateur_id'])){
	$sqlQuery = 'SELECT * FROM patient WHERE P_id = '.$_SESSION['utilisateur_id'] ;
	$recipesStatement = $mysqlClient->prepare($sqlQuery);
	$recipesStatement->execute();
	$recipes = $recipesStatement->fetch();

?>
<?php $title = "Mon profil"; ?>

<?php ob_start(); ?>
<h1>Voici le profil de <?php echo $recipes['pseudo']; ?></h1>
<div id="container">
<form action="profilPatient.php" method="POST">
	

	<div>Quelques informations sur vous : </div>
	<ul>
		<li>Votre nom  : <?php echo $recipes['nom']; ?></li>
		<br />
		<li>Votre prenom  : <?php echo $recipes['prenom']; ?></li>
		<br />
		<li>Votre mail : <?php echo $recipes['email']; ?></li>
		<br />
		<li>Votre numero de telephone : <?php echo $recipes['numTel']; ?></li>
		<br />
		<li>Votre date de naissance : <?php echo $recipes['dateNaiss']; ?></li>
		<br />
		<li>Votre taille : <?php echo $recipes['taille']; ?> cm</li>
		<br />
		<li>Votre poids : <?php echo $recipes['poids']; ?> kg</li>
		<br />
		
		<div><a class="button" href="modifierProfilPatient.php"><strong>Modifier son profil</strong></a> </div>
		<div><a class="button" href="pagedeconnexionPatient.php"><strong>Retour</strong></a> </div>
	</ul>

<?php
}
else{
	echo "Pas d'utilisateurs trouvé";
}
?>
</form>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
