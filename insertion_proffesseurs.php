<?php
require_once "db_connexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$tel = trim($_POST['tel'] ?? '');
$jcours = trim($_POST['jcours'] ?? '');
$idMatiere = filter_input(INPUT_POST, 'id_matiere', FILTER_VALIDATE_INT);

if ($nom === '' || $prenom === '' || $tel === '' || $jcours === '' || $idMatiere === false) {
    http_response_code(422);
    exit('Données de professeur invalides.');
}

$insertion = $PDO->prepare(
    'INSERT INTO professeurs (nom, prenom, tel, jcours, id_matiere)
     VALUES (:nom, :prenom, :tel, :jcours, :id_matiere)'
);
$insertion->execute([
    'nom' => $nom,
    'prenom' => $prenom,
    'tel' => $tel,
    'jcours' => $jcours,
    'id_matiere' => $idMatiere,
]);

header('Location: index.php');
exit;
