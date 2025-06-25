<?php
$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

// Récupérer toutes les élections terminées
$elections = $pdo->query("SELECT * FROM elections WHERE statut = 'terminée' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Résultats publics - VoteOn</title>
    <link rel="stylesheet" href="../css/publics.css">
</head>

<body>
    <h1>Résultats des élections clôturées</h1>

    <?php if (empty($elections)): ?>
        <p>Aucune élection clôturée pour le moment.</p>
    <?php endif; ?>

    <?php foreach ($elections as $election): ?>
        <h2><?= htmlspecialchars($election['titre']) ?></h2>

        <?php
        $stmt = $pdo->prepare("SELECT * FROM candidats WHERE election_id = ?");
        $stmt->execute([$election['id']]);
        $candidats = $stmt->fetchAll();

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
                    <th>Nombre de votes</th>
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
        <hr>
    <?php endforeach; ?>
</body>

</html>