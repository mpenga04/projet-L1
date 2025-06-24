<?php
// Connexion à la base
$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

// Si une action est demandée via GET (valider ou supprimer)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($_GET['action'] === 'valider') {
        $stmt = $pdo->prepare("UPDATE elections SET statut = 'active' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_GET['action'] === 'supprimer') {
        $stmt = $pdo->prepare("DELETE FROM elections WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Récupération des élections
$stmt = $pdo->query("SELECT * FROM elections ORDER BY id DESC");
$elections = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Administration des Élections</title>
    <link rel="stylesheet" href="../Css/admin1.css">
</head>

<body>
    <h1>Liste des élections</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Dates</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($elections as $election): ?>
            <tr>
                <td><?= $election['id'] ?></td>
                <td><?= htmlspecialchars($election['titre']) ?></td>
                <td>
                    <?= $election['date_debut'] ?> → <?= $election['date_fin'] ?>
                </td>
                <td>
                    <strong><?= strtoupper($election['statut']) ?></strong>
                </td>
                <td>
                    <?php if ($election['statut'] === 'en_attente'): ?>
                        <a href="?action=valider&id=<?= $election['id'] ?>">
                            <button style="background-color: green; color: white;">Valider</button>
                        </a>
                    <?php endif; ?>
                    <a href="?action=supprimer&id=<?= $election['id'] ?>" onclick="return confirm('Supprimer cette élection ?')">
                        <button style="background-color: red; color: white;">Supprimer</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
<?php
echo '<a href="admin_2.php">suivant</a>';
?>