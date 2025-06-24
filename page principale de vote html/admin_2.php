<?php
$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

// Traitement ajout candidat
if (isset($_POST['election_id'], $_POST['nom'])) {
    $nom = $_POST['nom'];
    $election_id = intval($_POST['election_id']);

    $stmt = $pdo->prepare("INSERT INTO candidats (election_id, nom) VALUES (?, ?)");
    $stmt->execute([$election_id, $nom]);
}

// Suppression d’un candidat
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM candidats WHERE id = ?");
    $stmt->execute([$id]);
}

// Récupérer toutes les élections
$elections = $pdo->query("SELECT * FROM elections")->fetchAll();

// Si une élection est sélectionnée
$election_id_selected = $_GET['election'] ?? $elections[0]['id'] ?? null;

// Candidats pour l’élection sélectionnée
$candidats = [];
if ($election_id_selected) {
    $stmt = $pdo->prepare("SELECT * FROM candidats WHERE election_id = ?");
    $stmt->execute([$election_id_selected]);
    $candidats = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Candidats</title>
</head>

<body>
    <h1>Ajouter un candidat</h1>

    <form method="GET">
        <label>Choisir une élection :</label>
        <select name="election" onchange="this.form.submit()">
            <?php foreach ($elections as $e): ?>
                <option value="<?= $e['id'] ?>" <?= ($e['id'] == $election_id_selected ? 'selected' : '') ?>>
                    <?= $e['titre'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($election_id_selected): ?>
        <form method="POST">
            <input type="hidden" name="election_id" value="<?= $election_id_selected ?>">
            <input type="text" name="nom" placeholder="Nom du candidat" required>
            <button type="submit">Ajouter</button>
        </form>

        <h2>Candidats pour cette élection :</h2>
        <ul>
            <?php foreach ($candidats as $c): ?>
                <li>
                    <?= htmlspecialchars($c['nom']) ?>
                    <a href="?election=<?= $election_id_selected ?>&delete=<?= $c['id'] ?>">❌ Supprimer</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>