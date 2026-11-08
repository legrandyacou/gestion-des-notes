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
$action = $_POST['action'] ?? 'creer';
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

$matiere = $PDO->prepare('SELECT libelle_mat FROM matieres WHERE id_matiere = ? AND id_user = ?');
$matiere->execute([$idMatiere, $idUser]);
$libelleMatiere = $matiere->fetchColumn();
if ($libelleMatiere === false) {
    http_response_code(422);
    exit('La matière sélectionnée est introuvable.');
}
$longueurLibelle = $PDO->prepare('SELECT CHAR_LENGTH(?)');
$longueurLibelle->execute([$libelleMatiere]);
if ((int) $longueurLibelle->fetchColumn() > 30) {
    http_response_code(422);
    exit('Le nom de la matière dépasse la longueur maximale autorisée pour une note.');
}

if ($action === 'modifier') {
    $idNote = filter_input(INPUT_POST, 'id_note', FILTER_VALIDATE_INT);
    if ($idNote === false || $idNote === null || $idNote < 1) {
        http_response_code(422);
        exit('Identifiant de note invalide.');
    }

    $noteExistante = $PDO->prepare('SELECT 1 FROM note WHERE id_note = ? AND id_user = ?');
    $noteExistante->execute([$idNote, $idUser]);
    if (!$noteExistante->fetchColumn()) {
        http_response_code(404);
        exit('Note introuvable.');
    }

    $modification = $PDO->prepare(
        'UPDATE note
         SET libelle_mat = :libelle_mat,
             id_periodeNote = :id_periode,
             note.date_note = :date_note,
             note = :valeur_note,
             id_prof = :id_prof,
             id_matiere = :id_matiere
         WHERE id_note = :id_note AND id_user = :id_user'
    );
    $modification->execute([
        'libelle_mat' => $libelleMatiere,
        'id_periode' => $idPeriode,
        'date_note' => $dateNote,
        'valeur_note' => $note,
        'id_prof' => $idProf,
        'id_matiere' => $idMatiere,
        'id_note' => $idNote,
        'id_user' => $idUser,
    ]);
} elseif ($action === 'creer') {
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
} else {
    http_response_code(400);
    exit('Action de note invalide.');
}

header('Location: index.php');
exit;
