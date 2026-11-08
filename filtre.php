<?php
require_once "db_connexion.php";
require_once "session_config.php";

if (
    empty($_SESSION['connecte']) ||
    $_SESSION['connecte'] !== true ||
    empty($_SESSION['id_user'])
) {
    header('Location: formulaire/design-connexion.php');
    exit;
}

$idProf = filter_input(INPUT_GET, 'id_prof', FILTER_VALIDATE_INT);
if ($idProf === false || $idProf === null || $idProf < 1) {
    http_response_code(400);
    exit('Identifiant de professeur invalide.');
}
$idUser = (int) $_SESSION['id_user'];

$query = $PDO->prepare(
    'SELECT id_prof, nom, prenom, tel, jcours
     FROM professeurs
     WHERE id_prof = ? AND id_user = ?'
);
$query->execute([$idProf, $idUser]);
$professeur = $query->fetch();
if (!$professeur) {
    http_response_code(404);
    exit('Professeur introuvable.');
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
         WHERE id_prof = :id_prof AND id_user = :id_user'
    );
    $update->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'tel' => $tel,
        'jcours' => $jcours,
        'id_prof' => $idProf,
        'id_user' => $idUser,
    ]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un professeur</title>
     <link rel="stylesheet" href="doc css/modf_prof.css">
    
</head>
<body>
    
     </div>
     
    <form action="filtre.php?id_prof=<?= (int) $professeur['id_prof'] ?>" method="post">
        <div>
        <h1>Modification</h1>
     </div>
        <input type="text" name="nom" value="<?= htmlspecialchars($professeur['nom']) ?>" required> <br>
        <input type="text" name="prenom" value="<?= htmlspecialchars($professeur['prenom']) ?>" required><br>
        <input type="tel" name="tel" value="<?= htmlspecialchars($professeur['tel']) ?>" required> <br>
        <input type="text" name="jcours" value="<?= htmlspecialchars($professeur['jcours']) ?>" required> <br>
        <div class="box_sub">
            <button type="submit">Enregistrer</button>
        <a href="index.php">Annuler</a>
        </div>
        
    </form>
    <script src="fonction_js/chargement.js"></script>
</body>
</html>
