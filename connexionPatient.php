<?php 
	session_start();

	if(isset($_POST['pseudo'])){
		// Récupération des données depuis le formulaire
		$pseudo = $_POST['pseudo'];
		$password = $_POST['password'];


		// Vérifier que l'utilisateur demandé existe en BDD et récupérer cet utilisateur
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=egosoin;charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}

		$req = $bdd->prepare('SELECT * FROM patient WHERE pseudo = :pseudo');
		$req->execute(
			array(
				'pseudo' => $pseudo
			)
		);

		$utilisateur = $req->fetch();
		if(empty($utilisateur))
		{
			echo "Aucun utilisateur trouvé...";
		}
		else
		{
			//echo "L'utilisateur trouvé est le numéro " . $utilisateur['S_id'] . "<br />";
			//echo "Le mot de passe essayé est : " . $password . "<br />";
			//echo "Le hash en bdd est : " . $utilisateur['pass'] . "<br />";

			// Les mots de passe correspondent-ils ?
			if(!password_verify($password, $utilisateur['pass']))
			{
				echo "Les mots de passe ne correspondent pas...";
			}
			else
			{
				// Les mots de passe correspondent
				
				// Enregistrer l'utilisateur en session
				$_SESSION = array();
				$_SESSION['utilisateur_id'] = $utilisateur['P_id'];
				$_SESSION['utilisateur_pseudo'] = $utilisateur['pseudo'];
				$_SESSION['patient'] = 'true';

				// Rediriger l'utilisateur vers la page d'accueil
				header("Location: pagedeconnexionPatient.php");
				
			}
		}
	}
?>

<?php $title = "Connexion"; ?>

<?php ob_start(); ?>
<div id="container">
<form action="connexionPatient.php" method="POST">
	<h2>Espace Patient</h2>

	<label><b>Identifiant</b></label>
	<input type="text" placeholder="Entrer votre identifiant" name="pseudo" required>
	<br /><br />

	<label><b>Mot de passe</b></label>
	<input type="password" placeholder="Entrer le mot de passe" name="password" required>
	<br /><br />
	<input type="submit" id='submit' value='LOGIN'>
</form>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>