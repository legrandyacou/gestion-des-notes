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

$idMatiere = filter_input(INPUT_POST, 'id_matiere', FILTER_VALIDATE_INT);
if ($idMatiere === false || $idMatiere === null || $idMatiere < 1) {
    http_response_code(422);
    exit('Identifiant de matière invalide.');
}

$idUser = (int) $_SESSION['id_user'];
$notes = $PDO->prepare('SELECT COUNT(*) FROM note WHERE id_matiere = ? AND id_user = ?');
$notes->execute([$idMatiere, $idUser]);
if ((int) $notes->fetchColumn() > 0) {
    http_response_code(409);
    exit('Cette matière est utilisée par des notes et ne peut pas être supprimée.');
}

$suppression = $PDO->prepare(
    'DELETE FROM matieres WHERE id_matiere = :id_matiere AND id_user = :id_user'
);
$suppression->execute(['id_matiere' => $idMatiere, 'id_user' => $idUser]);
if ($suppression->rowCount() !== 1) {
    http_response_code(404);
    exit('Matière introuvable.');
}

header('Location: index.php');
exit;
