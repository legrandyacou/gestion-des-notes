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
$libelle = trim($_POST['libelle_mat'] ?? '');
$coefficient = filter_input(INPUT_POST, 'coefficient', FILTER_VALIDATE_FLOAT);
$heure = filter_input(INPUT_POST, 'Heure', FILTER_VALIDATE_INT);
$idProf = filter_input(INPUT_POST, 'id_prof', FILTER_VALIDATE_INT);

if (
    $libelle === '' ||
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

header('Location: index.php');
exit;
