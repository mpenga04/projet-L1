<?php
// Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $description = $_POST['description'];

    // Requête d'insertion
    $sql = "INSERT INTO elections (titre, date_debut, date_fin, description, statut)
            VALUES (?, ?, ?, ?, 'en_attente')";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$titre, $date_debut, $date_fin, $description]);

    if ($result) {
        echo "Élection créée avec succès ! 🎉";
        echo '<a href="admin_e.php">Voir la liste des élections</a>';
    } else {
        echo "Une erreur s'est produite... 😢";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer une élection</title>
    <link rel="stylesheet" href="../Css/formulaire_creation.css">
</head>

<body>
    <div class="formulaire">
        <h1>Créer une nouvelle élection</h1>
        <form action="" method="POST">
            <div class="">
                <label>Titre de l'élection :</label><br>
                <input type="text" name="titre" class="case" required><br><br>
            </div>
            <div class="">
                <label>Date de début :</label><br>
                <input type="date" name="date_debut" class="case"><br><br>
            </div>
            <div class="">
                <label>Date de fin :</label><br>
                <input type="date" name="date_fin" class="case" required><br><br>
            </div>
            <div class="">
                <label>Description :</label><br>
                <textarea name="description" class="case" rows="4" cols="40"></textarea><br><br>
            </div>
            <input type="submit" value="Créer" class="case1">
    </div>
    </form>