<?php
$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

// Traitement et ajout d'un candidat
if (isset($_POST['election_id'], $_POST['nom'])) {
    $nom = trim($_POST['nom']);
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

// Selection d'une élection
$election_id_selected = $_GET['election'] ?? $elections[0]['id'] ?? null;

// Candidats de cette élection
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
    <link rel="stylesheet" href="../Css/admin_2.css">
</head>

<body>
    <div class="container">
        <h1>Gestion des Candidats</h1>

        <form method="GET" class="form-select">
            <label for="election">Choisir une élection :</label>
            <select name="election" onchange="this.form.submit()">
                <?php foreach ($elections as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= ($e['id'] == $election_id_selected ? 'selected' : '') ?>>
                        <?= htmlspecialchars($e['titre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($election_id_selected): ?>
            <form method="POST" class="form-ajout">
                <input type="hidden" name="election_id" value="<?= $election_id_selected ?>">
                <input type="text" name="nom" placeholder="Nom du candidat" required>
                <button type="submit">Ajouter</button>
            </form>

            <h2>Candidats enregistrés :</h2>
            <ul class="liste-candidats">
                <?php foreach ($candidats as $c): ?>
                    <li>
                        <?= htmlspecialchars($c['nom']) ?>
                        <a class="supprimer" href="?election=<?= $election_id_selected ?>&delete=<?= $c['id'] ?>">❌</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="resultat_admin.php">
            <button>📊 Voir les résultats</button>
        </a>
        <a href="admin_1.php"><button>Retour</button></a>
    </div>
</body>

</html>