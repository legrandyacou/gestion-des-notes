<?php 
require "db_connexion.php";
header("content-Type: application/json; charset=utf-8"); // elle indique la reponse est au forma json  et assure le bon affichage des caracter
$id = $_GET['id']?? null;// elle recupere l'id envoye pa javascript
if (!$id || !ctype_digit($id)) { //  !$id est vrai et $id est null et !ctype_digit($id) verifie bien que id contien uniquement des chiffres
    http_response_code(400);
    echo json_encode(["erreur" => "Identifiant invalide."]);
    exit;
}

// Requête préparée pour éviter les injections SQL
$stmMati = $PDO->prepare("SELECT id_matiere, libelle, coefficient,heure,id_prof FROM matieres WHERE id_matiere = ?");
$stmMati->execute([$id]);
$LesMatiere = $stmMati->fetch(PDO::FETCH_ASSOC);

if(!$LesMatiere){
    http_response_code(404);
    echo json_encode(["erreur"=>"matiere introuvable."]);
    exit;
}
echo json_encode($LesMatiere);
?>

