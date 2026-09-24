<?php
require_once "db_connexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$idMatiere = filter_input(INPUT_POST, 'id_matiere', FILTER_VALIDATE_INT);
$idProf = filter_input(INPUT_POST, 'id_prof', FILTER_VALIDATE_INT);
$dateNote = $_POST['date_note'] ?? '';
$id_periodeNote = $_POST['id_periodeNote'] ?? '';
$note = filter_input(INPUT_POST, 'note', FILTER_VALIDATE_FLOAT);
$dateValide = DateTime::createFromFormat('Y-m-d', $dateNote);

if (
    $idMatiere === false || $idProf === false || $note === false ||
    $note < 0 || $note > 20 || !$dateValide || $dateValide->format('Y-m-d') !== $dateNote
) {
    http_response_code(422);
    exit('Données de note invalides.');
}

$professeur = $PDO->prepare('SELECT id_prof FROM professeurs WHERE id_prof = ?');
$professeur->execute([$idProf]);
if (!$professeur->fetchColumn()) {
    http_response_code(422);
    exit('Le professeur sélectionné est introuvable.');
}

$insertion = $PDO->prepare(
    'INSERT INTO note (libelle_mat,id_periodeNote,  date_note, note, id_prof, id_matiere)
     SELECT libelle_mat,:id_periodeNote, :date_note, :note, :id_prof, id_matiere
     FROM matieres WHERE id_matiere = :id_matiere'
);
$insertion->execute([
    'date_note' => $dateNote,
    'note' => $note,
    'id_periodeNote' => $id_periodeNote,
    'id_prof' => $idProf,
    'id_matiere' => $idMatiere,
]);

if ($insertion->rowCount() !== 1) {
    http_response_code(422);
    exit('La matière sélectionnée est introuvable.');
}

header('Location: index.php');
exit;
