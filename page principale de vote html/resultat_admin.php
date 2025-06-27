<?php
$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

// Clôture d'une élection (si demandé)
if (isset($_GET['cloturer']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("UPDATE elections SET statut = 'terminée' WHERE id = ?");
    $stmt->execute([$id]);
}

// Récupérer toutes les élections
$elections = $pdo->query("SELECT * FROM elections ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Résultats des élections - Administration</title>
    <link rel="stylesheet" href="../css/admin_resultats.css" />
</head>

<body>
    <h1>Résultats des élections</h1>

    <?php foreach ($elections as $election): ?>
        <h2><?= htmlspecialchars($election['titre']) ?> (Statut : <?= strtoupper($election['statut']) ?>)</h2>

        <?php
        $stmt = $pdo->prepare("SELECT * FROM candidats WHERE election_id = ?");
        $stmt->execute([$election['id']]);
        $candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $votes_count = [];
        foreach ($candidats as $candidat) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE candidat_id = ?");
            $stmt->execute([$candidat['id']]);
            $votes_count[$candidat['id']] = $stmt->fetchColumn();
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Candidat</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidats as $candidat): ?>
                    <tr>
                        <td><?= htmlspecialchars($candidat['nom']) ?></td>
                        <td><?= $votes_count[$candidat['id']] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($election['statut'] !== 'terminée'): ?>
            <a href="?cloturer=1&id=<?= $election['id'] ?>" onclick="return confirm('Clôturer cette élection ? Cette action est irréversible.')">
                <button class="btn-cloturer">Clôturer l'élection</button>
            </a>
        <?php else: ?>
            <p><em>Cette élection est clôturée.</em></p>
        <?php endif; ?>

        <hr />
    <?php endforeach; ?>
    <a href="admin_1.php"><button>Retour au tableau de bord</button></a>
</body>

</html>