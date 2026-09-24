<?php
require_once "db_connexion.php";

$idProf = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);
if ($idProf === false || $idProf === null) {
    http_response_code(400);
    exit('Identifiant de professeur invalide.');
}

$suppression = $PDO->prepare('DELETE FROM professeurs WHERE id_prof = :id_prof');
$suppression->execute(['id_prof' => $idProf]);

header('Location: index.php');
exit;
