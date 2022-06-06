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

// on teste si les variables du formulaire sont déclarées
if (isset($_POST['prenom'])) {
    
	// lancement de la requête
	$sql = 'UPDATE secretaire SET prenom="'.$_POST['prenom'].'",
                            nom="'.$_POST['name'].'",
                            email="'.$_POST['email'].'",
                            numTel="'.$_POST['numTel'].'"
                            WHERE S_id = "'.$_SESSION['utilisateur_id'].'"';

	// on exécute la requête (mysql_query) et on affiche un message au cas où la requête ne se passait pas bien (or die)
    $stmt=$db->query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());

	// un petit message permettant de se rendre compte de la modification effectuée
	echo 'Les nouvelles modifications ont été enregistré';
}
else {
	echo 'Les variables du formulaire ne sont pas déclarées';
}
?>

<?php $title = "Modification de votre profil"; ?>

<?php ob_start(); ?>
<form action="modifierProfilSecretaire.php" method="POST">
	<h1>Modification de votre profil</h1>

        <div>
            <label for="pseudo">Pseudo:</label>
            <input type="text" value="" id="pseudo" placeholder="Entrez votre nouveau pseudo" name="pseudo"/>
        </div> 
        <br />
        <div>
            <label for="name">Nom:</label>
            <input type="text" value="" id="name" placeholder="Entrez votre nouveau nom" name="name"/>
        </div>
        <br />
        <div>
            <label for="prenom">Prénom:</label>
            <input type="text" value="" id="prenom" placeholder="Entrez votre nouveau prénom" name="prenom"/>
        </div>
        <br />
        <div>
            <label for="email">Email:</label>
            <input type="email" value="" id="email" placeholder="Entrez votre nouveau mail" name="email"/>
        </div>
        <br />
        <!-- <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" placeholder="Entrez votre nouveau mot de passe" name="password"/>
        </div>
        <br /> -->
        <div>
            <label for="numTel">Numéro de telephone:</label>
            <input type="tel" value="" id="numTel" placeholder="Entrez votre nouveau numéro de telephone" name="numTel"/>
        </div>
        <br />
        <button type="submit" name="submit">Modifier</button>
        <div><a class="button" href="pagedeconnexionSecretaire.php"><strong>Retour</strong></a></div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>