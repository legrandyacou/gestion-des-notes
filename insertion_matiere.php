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
$libelle = trim($_POST['libelle_mat'] ?? '');
$coefficient = filter_input(INPUT_POST, 'coefficient', FILTER_VALIDATE_FLOAT);
$heure = filter_input(INPUT_POST, 'Heure', FILTER_VALIDATE_INT);
$idProf = filter_input(INPUT_POST, 'id_prof', FILTER_VALIDATE_INT);
$longueurLibelle = $PDO->prepare('SELECT CHAR_LENGTH(?)');
$longueurLibelle->execute([$libelle]);
$longueurLibelle = (int) $longueurLibelle->fetchColumn();

if (
    $libelle === '' ||
    $longueurLibelle > 30 ||
    $coefficient === false || $coefficient === null || $coefficient <= 0 ||
    $heure === false || $heure === null || $heure < 0 ||
    $idProf === false || $idProf === null || $idProf < 1
) {
    http_response_code(422);
    exit('Données de matière invalides.');
}

$professeur = $PDO->prepare('SELECT 1 FROM professeurs WHERE id_prof = ? AND id_user = ?');
$professeur->execute([$idProf, $idUser]);
if (!$professeur->fetchColumn()) {
    http_response_code(422);
    exit('Le professeur sélectionné est introuvable.');
}

if ($action === 'modifier') {
    $idMatiere = filter_input(INPUT_POST, 'id_matiere', FILTER_VALIDATE_INT);
    if ($idMatiere === false || $idMatiere === null || $idMatiere < 1) {
        http_response_code(422);
        exit('Identifiant de matière invalide.');
    }

    $PDO->beginTransaction();
    $modification = $PDO->prepare(
        'UPDATE matieres
         SET libelle_mat = :libelle_mat, coefficient = :coefficient,
             heure = :heure, id_prof = :id_prof
         WHERE id_matiere = :id_matiere AND id_user = :id_user'
    );
    $modification->execute([
        'libelle_mat' => $libelle,
        'coefficient' => $coefficient,
        'heure' => $heure,
        'id_prof' => $idProf,
        'id_matiere' => $idMatiere,
        'id_user' => $idUser,
    ]);

    if ($modification->rowCount() === 0) {
        $existante = $PDO->prepare('SELECT 1 FROM matieres WHERE id_matiere = ? AND id_user = ?');
        $existante->execute([$idMatiere, $idUser]);
        if (!$existante->fetchColumn()) {
            $PDO->rollBack();
            http_response_code(404);
            exit('Matière introuvable.');
        }
    }

    $miseAJourNotes = $PDO->prepare(
        'UPDATE note SET libelle_mat = :libelle_mat
         WHERE id_matiere = :id_matiere AND id_user = :id_user'
    );
    $miseAJourNotes->execute([
        'libelle_mat' => $libelle,
        'id_matiere' => $idMatiere,
        'id_user' => $idUser,
    ]);
    $PDO->commit();
} elseif ($action === 'creer') {
    $insertion = $PDO->prepare(
        'INSERT INTO matieres (libelle_mat, coefficient, heure, id_prof, id_user)
         VALUES (:libelle_mat, :coefficient, :heure, :id_prof, :id_user)'
    );
    $insertion->execute([
        'libelle_mat' => $libelle,
        'coefficient' => $coefficient,
        'heure' => $heure,
        'id_prof' => $idProf,
        'id_user' => $idUser,
    ]);
} else {
    http_response_code(400);
    exit('Action de matière invalide.');
}

header('Location: index.php');
exit;
