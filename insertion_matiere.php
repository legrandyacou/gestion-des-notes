<?php
require_once "db_connexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$libelle = trim($_POST['libelle_mat'] ?? '');
$coefficient = filter_input(INPUT_POST, 'coefficient', FILTER_VALIDATE_FLOAT);
$heure = filter_input(INPUT_POST, 'Heure', FILTER_VALIDATE_INT);
$idProf = filter_input(INPUT_POST, 'id_prof', FILTER_VALIDATE_INT);

if ($libelle === '' || $coefficient === false || $coefficient <= 0 || $heure === false || $heure < 0 || $idProf === false) {
    http_response_code(422);
    exit('Données de matière invalides.');
}

$insertion = $PDO->prepare(
    'INSERT INTO matieres (libelle_mat, coefficient, heure, id_prof)
     VALUES (:libelle_mat, :coefficient, :heure, :id_prof)'
);
$insertion->execute([
    'libelle_mat' => $libelle,
    'coefficient' => $coefficient,
    'heure' => $heure,
    'id_prof' => $idProf,
]);

header('Location: index.php');
exit;
