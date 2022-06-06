<?php 
	session_start();
?>

<?php $title = "Accueil"; ?>

<?php ob_start(); ?>

<p>
	<?php
	if(!empty($_SESSION['utilisateur_id']))
	{
		echo "Bienvenue ".$_SESSION['utilisateur_pseudo']. '<br />';
	}
	else
	{
		echo "Vous vous êtes bien déconnecté<br />";
	}
	?>
</p>
<h1>BIENVENUE CHEZ EGOSOIN</h1>
    <Div Align=Center><a class="button" href="connexionPatient.php"><strong>Pour prendre un rendez-vous</strong></a> </Div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>