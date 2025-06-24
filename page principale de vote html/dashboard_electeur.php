<?php
session_start();
// Id fictif pour tester : $_SESSION['electeur_id'] = 1;
$electeur_id = $_SESSION['electeur_id'] ?? 1;

$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

// Récupère les élections actives
$elections = $pdo->query("SELECT * FROM elections WHERE statut = 'active'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Vote - Espace Électeur</title>
</head>

<body>
    <h1>Bienvenue sur VoteOn - Espace Électeur</h1>

    <?php foreach ($elections as $election): ?>
        <h2><?= htmlspecialchars($election['titre']) ?></h2>

        <?php
        // Vérifie si l'électeur a déjà voté à cette élection
        $stmt = $pdo->prepare("SELECT * FROM votes WHERE electeur_id = ? AND election_id = ?");
        $stmt->execute([$electeur_id, $election['id']]);
        $a_vote = $stmt->fetch();
        ?>

        <?php if ($a_vote): ?>
            <p><strong>Vous avez déjà voté pour cette élection.</strong></p>
        <?php else: ?>
            <form action="vote.php" method="POST">
                <input type="hidden" name="election_id" value="<?= $election['id'] ?>">

                <?php
                // Affiche les candidats pour cette élection
                $stmt = $pdo->prepare("SELECT * FROM candidats WHERE election_id = ?");
                $stmt->execute([$election['id']]);
                $candidats = $stmt->fetchAll();
                foreach ($candidats as $candidat):
                ?>
                    <input type="radio" name="candidat_id" value="<?= $candidat['id'] ?>" required>
                    <?= htmlspecialchars($candidat['nom']) ?><br>
                <?php endforeach; ?>

                <button type="submit">Voter</button>
            </form>
        <?php endif; ?>
        <hr>
    <?php endforeach; ?>
</body>

</html>