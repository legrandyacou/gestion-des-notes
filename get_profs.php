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
$stmt = $PDO->prepare("SELECT id_prof,nom,prenom,tel,jcours,id_matiere FROM professeurs WHERE id_prof = ?");
$stmt->execute([$id]);
$professeur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$professeur) {
    http_response_code(404);
    echo json_encode(["erreur" => "Professeur introuvable."]);
    exit;
}

echo json_encode($professeur);
?> 