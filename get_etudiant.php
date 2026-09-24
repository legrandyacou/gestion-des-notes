<?php
require "db_connexion.php";

header("Content-Type: application/json; charset=utf-8");

// On récupère l'id envoyé par le JavaScript (via ?id=...)
$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
    http_response_code(400);
    echo json_encode(["erreur" => "Identifiant invalide."]);
    exit;
}

// Requête préparée pour éviter les injections SQL
$stmt = $PDO->prepare("SELECT nom, prenom, email AS Email FROM etudiant WHERE id = ?");
$stmt->execute([$id]);
$etudiants = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiants) {
    http_response_code(404);
    echo json_encode(["erreur" => "Etudiant introuvable."]);
    exit;
}

echo json_encode($etudiants);
?> 