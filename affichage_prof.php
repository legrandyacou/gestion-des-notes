<?php
require_once "db_connexion.php";
$professeurs = $PDO->query(
    'SELECT id_prof, nom, prenom, tel, jcours, id_matiere FROM professeurs ORDER BY nom, prenom'
)->fetchAll();
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
                            <a href="suppProf.php?del=<?= (int) $professeur['id_prof'] ?>"
                               onclick="return confirm('Supprimer ce professeur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
