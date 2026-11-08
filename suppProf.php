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

$idUser = (int) $_SESSION['id_user'];
$notes = $PDO->prepare('SELECT COUNT(*) FROM note WHERE id_prof = ? AND id_user = ?');
$notes->execute([$idProf, $idUser]);
$matieres = $PDO->prepare('SELECT COUNT(*) FROM matieres WHERE id_prof = ? AND id_user = ?');
$matieres->execute([$idProf, $idUser]);
if ((int) $notes->fetchColumn() > 0 || (int) $matieres->fetchColumn() > 0) {
    http_response_code(409);
    exit('Ce professeur est associé à des matières ou des notes et ne peut pas être supprimé.');
}

$suppression = $PDO->prepare(
    'DELETE FROM professeurs WHERE id_prof = :id_prof AND id_user = :id_user'
);
$suppression->execute([
    'id_prof' => $idProf,
    'id_user' => $idUser,
]);
if ($suppression->rowCount() !== 1) {
    http_response_code(404);
    exit('Professeur introuvable.');
}

header('Location: index.php');
exit;
