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


$sqlQuery = 'SELECT * FROM consultation WHERE code_m = :code_m';
$consultationsStatement = $db->prepare($sqlQuery);
$consultationsStatement->execute(
    array(
        'code_m' => $selectedMedecin
    )
);
$consultationsExistantes = $consultationsStatement->fetchAll();


if (isset($_POST) && !empty($_POST)) {
    
    if(!empty($_POST['medecin']) && !empty($_POST['dateRendezVous'])) {
        // TODO : valider que $_POST['medecin'] est bien un médecin valide

        // Valider que dateRendezVous est bien une date valide
        $consultationWithSameDateAndSameMedecin = current(array_filter($consultationsExistantes, function($element) { 
            return $element['C_date'] == $_POST['dateRendezVous'] && $element['code_m'] == $_POST['medecin'];
        }));

        if(empty($consultationWithSameDateAndSameMedecin)){
            $req = $db->prepare('INSERT INTO consultation(C_date, C_heure, id_s, id_p, code_m) 
                                 VALUES(:C_date, :C_heure, :id_s, :id_p, :code_m)');
                        

            $result = $req->execute(
                array(
                    'C_date' => $_POST['dateRendezVous'],
                    'C_heure' => '',
                    'id_s' => null,
                    'id_p' => $_SESSION['utilisateur_id'],
                    'code_m' => $_POST['medecin']
                )
            );

				echo "Le rendez-vous a été pris !";
			}
			else{
				echo "Attention : ce médecin a déjà un rendez-vous à cette date...";
			}

       
    }


}

// print_r($medecins);

?>


<?php $title = "Prendre un rendez-vous"; ?>

<?php ob_start(); ?>
		<div id="container">
			<form method="POST">
					<h2>Prendre un rendez-vous</h2>
						<div>
							<select name="medecin" id="medecin" onChange="window.location.href='prendreRendezVous.php?medecin=' + this.value">
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
						</div>

						<?php 
							if(!empty($selectedMedecin)){
								?>
						<div>
							<p>Veuillez ne pas choisir ces dates SVP :</p>
							<ul>
								<?php
								foreach ($consultationsExistantes as $key => $consultation) {
									?>
								<li><?php echo $consultation['C_date']; ?></li>
								<?php
								}
							?>
							</ul>
						</div>
						<div>
							<label>
								Date du rendez-vous :
								<input type="date" name="dateRendezVous" />
							</label>
						</div>
						<?php
							}
						?>

						<br />
						<button type="submit" name="submit">Valider le rendez-vous</button>
						<!-- <div><a class="button" href="pagedeconnexionPatient.php"><strong>Retour</strong></a></div> -->
			</form>
		</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>