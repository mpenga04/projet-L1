<?php
session_start();
if (!isset($_SESSION['electeur_id'])) {
    header('Location: connexion.php');
    exit;
}
$electeur_id = $_SESSION['electeur_id'];

$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');
$elections = $pdo->query("SELECT * FROM elections WHERE statut = 'active'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Vote - Espace Électeur</title>
    <link rel="stylesheet" href="../css/dashboard_electeur.css">
</head>

<body>
    <div class="container">
        <h1>🎓 Espace Électeur — VoteOnline</h1>

        <?php if (empty($elections)): ?>
            <p class="info">Aucune élection active pour l’instant.</p>
        <?php endif; ?>

        <?php foreach ($elections as $election): ?>
            <div class="election-card">
                <h2><?= htmlspecialchars($election['titre']) ?></h2>

                <?php
                $stmt = $pdo->prepare("SELECT * FROM votes WHERE electeur_id = ? AND election_id = ?");
                $stmt->execute([$electeur_id, $election['id']]);
                $a_vote = $stmt->fetch();
                ?>

                <?php if ($a_vote): ?>
                    <p class="deja-vote">Vous avez déjà voté pour cette élection.</p>
                <?php else: ?>
                    <form action="vote.php" method="POST" class="vote-form">
                        <input type="hidden" name="election_id" value="<?= $election['id'] ?>">

                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM candidats WHERE election_id = ?");
                        $stmt->execute([$election['id']]);
                        $candidats = $stmt->fetchAll();

                        foreach ($candidats as $candidat): ?>
                            <label class="radio-option">
                                <input type="radio" name="candidat_id" value="<?= $candidat['id'] ?>" required>
                                <?= htmlspecialchars($candidat['nom']) ?>
                            </label><br>
                        <?php endforeach; ?>

                        <button type="submit">Voter</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <a href="public.php">Voir les résultats des élections clôturées</a>
    </div>
</body>

</html>