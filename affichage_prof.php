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

$id_user = (int) $_SESSION['id_user'];
$professeurs = $PDO->prepare('SELECT id_prof, nom, prenom, tel, jcours FROM professeurs WHERE id_user = ? ORDER BY nom, prenom');
$professeurs->execute([$id_user]);
$professeurs = $professeurs->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Professeurs</title>
</head>
<body>
    <h1>Professeurs</h1>
    <?php if (!$professeurs): ?>
        <p>Aucun professeur enregistré.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Jours de cours</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($professeurs as $professeur): ?>
                    <tr>
                        <td><?= htmlspecialchars($professeur['nom']) ?></td>
                        <td><?= htmlspecialchars($professeur['prenom']) ?></td>
                        <td><?= htmlspecialchars($professeur['tel']) ?></td>
                        <td><?= htmlspecialchars($professeur['jcours']) ?></td>
                        <td>
                            <a href="filtre.php?id_prof=<?= (int) $professeur['id_prof'] ?>">Modifier</a>
                            <form action="suppProf.php" method="post" onsubmit="return confirm('Supprimer ce professeur ?');">
                                <input type="hidden" name="del" value="<?= (int) $professeur['id_prof'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
