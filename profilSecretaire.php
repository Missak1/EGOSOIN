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
	$sqlQuery = 'SELECT * FROM secretaire WHERE S_id = '.$_SESSION['utilisateur_id'] ;
	$recipesStatement = $mysqlClient->prepare($sqlQuery);
	$recipesStatement->execute();
	$recipes = $recipesStatement->fetch();

?>


<?php $title = "Mon profil"; ?>

<?php ob_start(); ?>
<form action="profilSecretaire.php" method="POST">
	<h1>Voici le profil de <?php echo $recipes['pseudo']; ?></h1>

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
		<div><a class="button" href="modifierProfilSecretaire.php"><strong>Modifier son profil</strong></a> </div>
		<div><a class="button" href="pagedeconnexionSecretaire.php"><strong>Retour</strong></a> </div>
	</ul>

<?php
}
else{
	echo "Pas d'utilisateurs trouvé";
}
?>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
