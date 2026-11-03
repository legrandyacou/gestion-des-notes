<?php
require_once "db_connexion.php";
require_once "session_config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée.');
}

if (
    empty($_SESSION['connecte']) ||
    $_SESSION['connecte'] !== true ||
    empty($_SESSION['id_user'])
) {
    header('Location: formulaire/design-connexion.php');
    exit;
}

$idProf = filter_input(INPUT_POST, 'del', FILTER_VALIDATE_INT);
if ($idProf === false || $idProf === null || $idProf < 1) {
    http_response_code(422);
    exit('Identifiant de professeur invalide.');
}

$suppression = $PDO->prepare(
    'DELETE FROM professeurs WHERE id_prof = :id_prof AND id_user = :id_user'
);
$suppression->execute([
    'id_prof' => $idProf,
    'id_user' => (int) $_SESSION['id_user'],
]);

header('Location: index.php');
exit;
