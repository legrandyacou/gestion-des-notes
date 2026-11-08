<?php
require_once "db_connexion.php";
require_once "session_config.php";

if (empty($_SESSION['connecte']) || $_SESSION['connecte'] !== true || empty($_SESSION['id_user'])) {
    header('Location: formulaire/design-connexion.php');
    exit;
}

$idNote = filter_input(INPUT_GET, 'id_note', FILTER_VALIDATE_INT);
if ($idNote === false || $idNote === null || $idNote < 1) {
    http_response_code(400);
    exit('Identifiant de note invalide.');
}

$idUser = (int) $_SESSION['id_user'];
$requete = $PDO->prepare(
    'SELECT id_note, id_matiere, id_periodeNote, date_note, note, id_prof
     FROM note WHERE id_note = ? AND id_user = ?'
);
$requete->execute([$idNote, $idUser]);
$note = $requete->fetch();
if (!$note) {
    http_response_code(404);
    exit('Note introuvable.');
}

$matieres = $PDO->prepare(
    'SELECT id_matiere, libelle_mat FROM matieres WHERE id_user = ? ORDER BY libelle_mat'
);
$matieres->execute([$idUser]);
$matieres = $matieres->fetchAll();

$professeurs = $PDO->prepare(
    'SELECT id_prof, nom, prenom FROM professeurs WHERE id_user = ? ORDER BY nom, prenom'
);
$professeurs->execute([$idUser]);
$professeurs = $professeurs->fetchAll();

$periodes = $PDO->query('SELECT id_periodeNote, periode FROM periodenotes ORDER BY id_periodeNote');
$periodes = $periodes->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une note | Gestion des notes</title>
    <link rel="stylesheet" href="doc css/style-index.css">
    <link rel="stylesheet" href="doc css/responsive.css">
</head>
<body>
    <main class="edit-record-page">
        <h1>Modifier une note</h1>
        <form action="insertion_note.php" method="post" class="forMuLaire">
            <input type="hidden" name="action" value="modifier">
            <input type="hidden" name="id_note" value="<?= (int) $note['id_note'] ?>">
            <label for="note-matiere">Matière</label>
            <select id="note-matiere" name="id_matiere" required>
                <?php foreach ($matieres as $matiere): ?>
                    <option value="<?= (int) $matiere['id_matiere'] ?>" <?= (int) $matiere['id_matiere'] === (int) $note['id_matiere'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($matiere['libelle_mat'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="note-periode">Période</label>
            <select id="note-periode" name="id_periodeNote" required>
                <?php foreach ($periodes as $periode): ?>
                    <option value="<?= (int) $periode['id_periodeNote'] ?>" <?= (int) $periode['id_periodeNote'] === (int) $note['id_periodeNote'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($periode['periode'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="note-professeur">Professeur</label>
            <select id="note-professeur" name="id_prof" required>
                <?php foreach ($professeurs as $professeur): ?>
                    <option value="<?= (int) $professeur['id_prof'] ?>" <?= (int) $professeur['id_prof'] === (int) $note['id_prof'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($professeur['nom'] . ' ' . $professeur['prenom'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="date-note">Date de l’évaluation</label>
            <input id="date-note" type="date" name="date_note" required value="<?= htmlspecialchars($note['date_note'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="valeur-note">Note sur 20</label>
            <input id="valeur-note" type="number" name="note" min="0" max="20" step="0.5" required value="<?= htmlspecialchars((string) $note['note'], ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit">Enregistrer les modifications</button>
            <a href="index.php">Annuler</a>
        </form>
    </main>
</body>
</html>
