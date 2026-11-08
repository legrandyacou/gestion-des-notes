<?php
require_once "db_connexion.php";
require_once "session_config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée.');
}

if (empty($_SESSION['connecte']) || $_SESSION['connecte'] !== true || empty($_SESSION['id_user'])) {
    header('Location: formulaire/design-connexion.php');
    exit;
}

$idNote = filter_input(INPUT_POST, 'id_note', FILTER_VALIDATE_INT);
if ($idNote === false || $idNote === null || $idNote < 1) {
    http_response_code(422);
    exit('Identifiant de note invalide.');
}

$suppression = $PDO->prepare('DELETE FROM note WHERE id_note = :id_note AND id_user = :id_user');
$suppression->execute([
    'id_note' => $idNote,
    'id_user' => (int) $_SESSION['id_user'],
]);

if ($suppression->rowCount() !== 1) {
    http_response_code(404);
    exit('Note introuvable.');
}

header('Location: index.php');
exit;
