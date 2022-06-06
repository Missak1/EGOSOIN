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

$selectedMedecin = $_GET['medecin'] ?? null;

$sqlQuery = 'SELECT * FROM medecin';
$medecinsStatement = $db->prepare($sqlQuery);
$medecinsStatement->execute();
$medecins = $medecinsStatement->fetchAll();


$sqlQuery = 'SELECT * FROM consultation
	LEFT JOIN medecin ON medecin.M_code = consultation.code_m
	LEFT JOIN patient ON patient.P_id = consultation.id_p
';
if(!empty($selectedMedecin)){
	$sqlQuery .= ' WHERE code_m = :code_m';
}

$consultationsStatement = $db->prepare($sqlQuery);
$consultationsStatement->execute(
    array(
        'code_m' => $selectedMedecin
    )
);
$consultationsExistantes = $consultationsStatement->fetchAll();

?>

<?php $title = "Liste des rendez-vous"; ?>

<?php ob_start(); ?>
<form action="listeRendezVous.php" method="POST">
	<h1>Liste des rendez-vous</h1>
	<br /><br />
	<div>
		<form method="GET">
			<select name="medecin" id="medecin" onChange="this.parentNode.submit()">
				<option value="">--Choisissez un médecin--</option>
				<?php
                foreach ($medecins as $key => $medecin) {
                    ?>
				<option value="<?php echo $medecin['M_code']; ?>" <?php echo $selectedMedecin == $medecin['M_code'] ? 'selected' : '' ?>>
					<?php echo $medecin['M_nom'] . ' ' . $medecin['M_prenom'] . ' (' . $medecin['M_specialite'] . ')'; ?>
				</option>
				<?php
                }
            ?>
			</select>
		</form>
	</div>


	<div>
		<p>Liste des rendez-vous :</p>
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Médecin</th>
					<th>Patient</th>
				</tr>

			</thead>
			<tbody>
				<?php
                foreach ($consultationsExistantes as $key => $consultation) {
                    ?>

				<tr>
					<td><?php echo $consultation['C_date']; ?></td>
					<td><?php echo $consultation['M_nom'] . ' ' . $consultation['M_prenom']; ?></td>
					<td><?php echo $consultation['nom'] . ' ' . $consultation['prenom']; ?></td>
				</tr>

				<?php
                }
            ?>
			</tbody>
		</table>
	</div>


	<br />
	<div><a class="button" href="pagedeconnexionSecretaire.php"><strong>Retour</strong></a></div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

	
</body>

</html>