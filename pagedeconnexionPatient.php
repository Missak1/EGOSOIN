<?php 
	session_start();
?>

<?php $title = "Profil"; ?>

<?php ob_start(); ?>

<p>
	<?php
	if(!empty($_SESSION['utilisateur_id']))
	{
		echo  "Bienvenue  ".$_SESSION['utilisateur_pseudo']. '<br />';
	}
	else
	{
		echo "Vous vous êtes bien déconnecté!!!!<br />";
	}
	?>
</p>
<h1>BIENVENUE sur votre espace Patient</h1>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>