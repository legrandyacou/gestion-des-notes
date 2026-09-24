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
//matiere
            $stmMati=$PDO->prepare("SELECT id_matiere,libelle_mat,coefficient,heure FROM matieres WHERE id_matiere = ?");
            $stmMati->execute([$professeur['id_matiere']]);
          //$stmMati = $PDO->query();
          $matiere = $stmMati->fetch(PDO::FETCH_ASSOC);
          $professeur['matiere_libelle'] = $matiere['libelle_mat'] ?? null;
//moyenne
           // Moyenne par matière
                $stmtMoy = $PDO->prepare("SELECT libelle_mat, AVG(note) AS moyenne 
                FROM note 
                WHERE id_prof = ? AND id_periodeNote = 1
                GROUP BY libelle_mat");
                $stmtMoy->execute([$id]);
                $professeur['moyennes'] = $stmtMoy->fetchAll(PDO::FETCH_ASSOC);
          //NOTES
          //Note de la periode 1
          $stmNotes = $PDO->prepare(
              "SELECT id_note, libelle_mat, date_note, note, id_prof
               FROM note
            WHERE id_prof = ? AND id_periodeNote = 1
               ORDER BY date_note DESC, id_note DESC " 
          );
          //Note de la periode 2
         /* $stmNotes = $PDO->prepare(
              "SELECT id_note, libelle_mat, date_note, note, id_prof
               FROM note
            WHERE id_prof = ? AND id_periodeNote = 2
               ORDER BY date_note DESC, id_note DESC " 
          );*/
          //Note de la periode 3
         /* $stmNotes = $PDO->prepare(
              "SELECT id_note, libelle_mat, date_note, note, id_prof
               FROM note
            WHERE id_prof = ? AND id_periodeNote = 3
               ORDER BY date_note DESC, id_note DESC " 
          );*/
          $stmNotes->execute([$id]);
          $professeur['notes'] = $stmNotes->fetchAll(PDO::FETCH_ASSOC);
          

echo json_encode($professeur);
?> 