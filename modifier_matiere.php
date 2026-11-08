<?php
require_once "db_connexion.php";
require_once "session_config.php";

if (empty($_SESSION['connecte']) || $_SESSION['connecte'] !== true || empty($_SESSION['id_user'])) {
    header('Location: formulaire/design-connexion.php');
    exit;
}

$idMatiere = filter_input(INPUT_GET, 'id_matiere', FILTER_VALIDATE_INT);
if ($idMatiere === false || $idMatiere === null || $idMatiere < 1) {
    http_response_code(400);
    exit('Identifiant de matière invalide.');
}

$idUser = (int) $_SESSION['id_user'];
$requete = $PDO->prepare(
    'SELECT id_matiere, libelle_mat, coefficient, heure, id_prof
     FROM matieres WHERE id_matiere = ? AND id_user = ?'
);
$requete->execute([$idMatiere, $idUser]);
$matiere = $requete->fetch();
if (!$matiere) {
    http_response_code(404);
    exit('Matière introuvable.');
}

$requeteProfs = $PDO->prepare(
    'SELECT id_prof, nom, prenom FROM professeurs WHERE id_user = ? ORDER BY nom, prenom'
);
$requeteProfs->execute([$idUser]);
$professeurs = $requeteProfs->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une matière | Gestion des notes</title>
    <link rel="stylesheet" href="doc css/style-index.css">
    <link rel="stylesheet" href="doc css/responsive.css">
</head>
<body>
    <main class="edit-record-page">
        <h1>Modifier une matière</h1>
        <form action="insertion_matiere.php" method="post" class="forMuLaire">
            <input type="hidden" name="action" value="modifier">
            <input type="hidden" name="id_matiere" value="<?= (int) $matiere['id_matiere'] ?>">
            <label for="libelle-matiere">Nom de la matière</label>
            <input id="libelle-matiere" type="text" name="libelle_mat" maxlength="30" required value="<?= htmlspecialchars($matiere['libelle_mat'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="coefficient-matiere">Coefficient</label>
            <input id="coefficient-matiere" type="number" name="coefficient" min="0.01" step="0.01" required value="<?= htmlspecialchars((string) $matiere['coefficient'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="heures-matiere">Nombre d’heures</label>
            <input id="heures-matiere" type="number" name="Heure" min="0" required value="<?= (int) $matiere['heure'] ?>">
            <label for="professeur-matiere">Professeur référent</label>
            <select id="professeur-matiere" name="id_prof" required>
                <option value="">Choisir un professeur</option>
                <?php foreach ($professeurs as $professeur): ?>
                    <option value="<?= (int) $professeur['id_prof'] ?>" <?= (int) $professeur['id_prof'] === (int) $matiere['id_prof'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($professeur['nom'] . ' ' . $professeur['prenom'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Enregistrer les modifications</button>
            <a href="index.php">Annuler</a>
        </form>
    </main>
</body>
</html>
