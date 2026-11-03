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
$action = $_POST['action'] ?? '';

if ($action === 'Enregistrer le professeur') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $tel = trim($_POST['tel'] ?? '');
    $jcours = trim($_POST['jcours'] ?? '');

    if ($nom === '' || $prenom === '' || $tel === '' || $jcours === '') {
        http_response_code(422);
        exit('Données de professeur invalides.');
    }

    $insertion = $PDO->prepare(
        'INSERT INTO professeurs (nom, prenom, tel, jcours, id_user)
         VALUES (:nom, :prenom, :tel, :jcours, :id_user)'
    );
    $insertion->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'tel' => $tel,
        'jcours' => $jcours,
        'id_user' => $idUser,
    ]);
} elseif ($action === 'supprimer') {
    $idProf = filter_input(INPUT_POST, 'id_prof', FILTER_VALIDATE_INT);
    if ($idProf === false || $idProf === null || $idProf < 1) {
        http_response_code(422);
        exit('Identifiant de professeur invalide.');
    }

    $suppression = $PDO->prepare(
        'DELETE FROM professeurs WHERE id_prof = :id_prof AND id_user = :id_user'
    );
    $suppression->execute([
        'id_prof' => $idProf,
        'id_user' => $idUser,
    ]);
} else {
    http_response_code(400);
    exit('Action invalide.');
}

header('Location: index.php');
exit;
