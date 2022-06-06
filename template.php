<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a href="index.php">Accueil</a></li>
				<li><a href="connexionSecretaire.php">Espace secretaire</a></li>
				<li><a href="connexionPatient.php">Espace Patient</a></li>
				<li><a href="inscriptionPatient.php">Inscription Patient </a></li>
			</ul>
		</nav>
	</header>
	<p>
		<?php
    if(!empty($_SESSION['patient']))
	{
		?>
		<div style="text-align: right"><a class="button" href="deconnexion.php"><strong>Déconnexion</strong></a> </div>
		<div style="text-align: right"><a class="button" href="profilPatient.php"><strong>Mon profil</strong></a> </div>
		<div style="text-align: right"><a class="button" href="prendreRendezVous.php"><strong>Prendre un rendez-vous</strong></a> </div>
		<div style="text-align: right"><a class="button" href="RendezvousPatient.php"><strong> Mes rendez-vous</strong></a> </div>
		<?php
	}
    ?>
	<?php
    if(!empty($_SESSION['secretaire']))
	{
		?>
		<div style="text-align: right"><a class="button" href="deconnexion.php"><strong>Déconnexion</strong></a> </div>
		<div style="text-align: right"><a class="button" href="profilSecretaire.php"><strong>Mon profil</strong></a> </div>
		<div style="text-align: right"><a class="button" href="listeRendezVous.php"><strong>Tous les rendez-vous</strong></a> </div>
		<div style="text-align: right"><a class="button" href="prendreRendezVousSecretaire.php"><strong>Prendre un rendez-vous</strong></a> </div>
		<?php
	}
    ?>
	</p>
	<?php echo $content; ?>
</body>

</html>