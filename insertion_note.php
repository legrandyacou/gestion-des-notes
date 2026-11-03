<?php
require_once "db_connexion.php";
require_once "session_config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (
    empty($_SESSION['connecte']) ||
    $_SESSION['connecte'] !== true ||
    empty($_SESSION['id_user'])
) {
    header('Location: formulaire/design-connexion.php');
    exit;
}

$idUser = (int) $_SESSION['id_user'];
$idMatiere = filter_input(INPUT_POST, 'id_matiere', FILTER_VALIDATE_INT);
$idProf = filter_input(INPUT_POST, 'id_prof', FILTER_VALIDATE_INT);
$idPeriode = filter_input(INPUT_POST, 'id_periodeNote', FILTER_VALIDATE_INT);
$dateNote = $_POST['date_note'] ?? '';
$note = filter_input(INPUT_POST, 'note', FILTER_VALIDATE_FLOAT);
$dateValide = is_string($dateNote) ? DateTime::createFromFormat('Y-m-d', $dateNote) : false;
$dateErrors = DateTime::getLastErrors();

if (
    $idMatiere === false || $idMatiere === null || $idMatiere < 1 ||
    $idProf === false || $idProf === null || $idProf < 1 ||
    $idPeriode === false || $idPeriode === null || $idPeriode < 1 ||
    $note === false || $note === null || $note < 0 || $note > 20 ||
    !$dateValide ||
    ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0)) ||
    $dateValide->format('Y-m-d') !== $dateNote
) {
    http_response_code(422);
    exit('Données de note invalides.');
}

$periode = $PDO->prepare('SELECT 1 FROM periodenotes WHERE id_periodeNote = ?');
$periode->execute([$idPeriode]);
if (!$periode->fetchColumn()) {
    http_response_code(422);
    exit('La période sélectionnée est invalide.');
}

$professeur = $PDO->prepare('SELECT 1 FROM professeurs WHERE id_prof = ? AND id_user = ?');
$professeur->execute([$idProf, $idUser]);
if (!$professeur->fetchColumn()) {
    http_response_code(422);
    exit('Le professeur sélectionné est introuvable.');
}

$insertion = $PDO->prepare(
    'INSERT INTO note (libelle_mat, id_periodeNote, date_note, note, id_prof, id_matiere, id_user)
     SELECT libelle_mat, :id_periode, :date_note, :note, :prof_id, id_matiere, id_user
     FROM matieres
     WHERE id_matiere = :matiere_id AND id_user = :user_id'
);
$insertion->execute([
    'id_periode' => $idPeriode,
    'date_note' => $dateNote,
    'note' => $note,
    'prof_id' => $idProf,
    'matiere_id' => $idMatiere,
    'user_id' => $idUser,
]);

if ($insertion->rowCount() !== 1) {
    http_response_code(422);
    exit('La matière sélectionnée est introuvable.');
}

header('Location: index.php');
exit;
