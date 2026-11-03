<?php
require_once "db_connexion.php";
require_once "session_config.php";

header("Content-Type: application/json; charset=utf-8");

if (
    empty($_SESSION['connecte']) ||
    $_SESSION['connecte'] !== true ||
    empty($_SESSION['id_user'])
) {
    http_response_code(401);
    echo json_encode(["erreur" => "Connexion requise."]);
    exit;
}

$id = $_GET['id'] ?? null;
if (!is_string($id) || !ctype_digit($id)) {
    http_response_code(400);
    echo json_encode(["erreur" => "Identifiant invalide."]);
    exit;
}

$idUser = (int) $_SESSION['id_user'];
$stmMati = $PDO->prepare(
    'SELECT matieres.id_matiere, matieres.libelle_mat, matieres.coefficient, matieres.heure,
            CONCAT_WS(" ", professeurs.prenom, professeurs.nom) AS professeur
     FROM matieres
     LEFT JOIN professeurs
       ON professeurs.id_prof = matieres.id_prof
      AND professeurs.id_user = matieres.id_user
     WHERE matieres.id_matiere = ? AND matieres.id_user = ?'
);
$stmMati->execute([$id, $idUser]);
$matiere = $stmMati->fetch(PDO::FETCH_ASSOC);

if (!$matiere) {
    http_response_code(404);
    echo json_encode(["erreur" => "Matière introuvable."]);
    exit;
}

echo json_encode($matiere);
