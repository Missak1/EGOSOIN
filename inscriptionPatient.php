<?php 
	session_start();

	if(isset($_POST['pseudo'])){
		// Vérification de la validité des informations
		$pseudo = $_POST['pseudo'];
		$email = $_POST['email'];
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$poids = $_POST['poids'];
		$taille = $_POST['taille'];
		$numTel = $_POST['numTel'];
		$dateNaiss = $_POST['dateNaiss'];

		
		// Hachage du mot de passe
		$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=egosoin;charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
			
		// Insertion
		$req = $bdd->prepare('INSERT INTO patient(pseudo, nom, prenom, pass, email, poids, taille, numTel, dateNaiss) 
							VALUES(:pseudo, :nom, :prenom, :pass, :email, :poids, :taille, :numTel, :dateNaiss)');
		
		$result = $req->execute(
			array(
				'pseudo' => $pseudo,
				'nom' => $nom,
				'prenom' => $prenom,
				'pass' => $pass_hache,
				'email' => $email,
				'taille' => $taille,
				'dateNaiss' => $dateNaiss,
				'numTel' => $numTel,
				'poids' => $poids
			)
		);

		if($result)
		{
			echo "Inscription réussie";
			
		}
		else
		{
			echo "Erreur";
		}
		
		header('Location: connexionPatient.php');
	}
?>
<?php $title = "Inscription"; ?>

<?php ob_start(); ?>
<div id="container">
<form method="post" action="inscriptionPatient.php">
	<h2>Inscription Espace Patient</h2>

	Pseudo: <input type="text" name="pseudo">
	<br />
	Nom: <input type="text" name="nom">
	<br />
	Prenom: <input type="text" name="prenom">
	<br /><br />
	Votre date de naissance: <input type="date" name="dateNaiss">
	<br /><br />
	Votre email: <input type="text" name="email">
	<br />
	Mot de passe : <input type="password" name="pass">
	<br />
	Retapez votre mot de passe : <input type="password" name="pass2">
	<br /><br />
	Votre poids: <input type="number" name="poids">
	<br /><br />
	Votre numéro de téléphone: <input type="tel" name="numTel">
	<br /><br />
	Votre Taille: <input type="number" name="taille">
	<br /><br />
	<input type="submit" value="S'inscrire">
</form>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>