<?php
require_once "db_connexion.php";

$idProf = filter_input(INPUT_GET, 'id_prof', FILTER_VALIDATE_INT);
if ($idProf === false || $idProf === null) {
    http_response_code(400);
    exit('Identifiant de professeur invalide.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $tel = trim($_POST['tel'] ?? '');
    $jcours = trim($_POST['jcours'] ?? '');

    if ($nom === '' || $prenom === '' || $tel === '' || $jcours === '') {
        http_response_code(422);
        exit('Tous les champs sont obligatoires.');
    }

    $update = $PDO->prepare(
        'UPDATE professeurs SET nom = :nom, prenom = :prenom, tel = :tel, jcours = :jcours
         WHERE id_prof = :id_prof'
    );
    $update->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'tel' => $tel,
        'jcours' => $jcours,
        'id_prof' => $idProf,
    ]);

    header('Location: index.php');
    exit;
}

$query = $PDO->prepare('SELECT id_prof, nom, prenom, tel, jcours FROM professeurs WHERE id_prof = ?');
$query->execute([$idProf]);
$professeur = $query->fetch();
if (!$professeur) {
    http_response_code(404);
    exit('Professeur introuvable.');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un professeur</title>
</head>
<body>
    <form action="filtre.php?id_prof=<?= (int) $professeur['id_prof'] ?>" method="post">
        <input type="text" name="nom" value="<?= htmlspecialchars($professeur['nom']) ?>" required>
        <input type="text" name="prenom" value="<?= htmlspecialchars($professeur['prenom']) ?>" required>
        <input type="tel" name="tel" value="<?= htmlspecialchars($professeur['tel']) ?>" required>
        <input type="text" name="jcours" value="<?= htmlspecialchars($professeur['jcours']) ?>" required>
        <button type="submit">Enregistrer</button>
        <a href="index.php">Annuler</a>
    </form>
</body>
</html>
