<?php
require_once "db_connexion.php";

$idMatiere = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);
if ($idMatiere === false || $idMatiere === null) {
    http_response_code(400);
    exit('Identifiant de matière invalide.');
}

$suppression = $PDO->prepare('DELETE FROM matieres WHERE id_matiere = :id_matiere');
$suppression->execute(['id_matiere' => $idMatiere]);

header('Location: index.php');
exit;
