<?php
session_start();
$electeur_id = $_SESSION['electeur_id'] ?? null;

if (!$electeur_id || !isset($_POST['election_id'], $_POST['candidat_id'])) {
    die("Accès non autorisé.");
}

$election_id = intval($_POST['election_id']);
$candidat_id = intval($_POST['candidat_id']);

$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

// Vérifie si l'utilisateur a déjà voté
$stmt = $pdo->prepare("SELECT * FROM votes WHERE electeur_id = ? AND election_id = ?");
$stmt->execute([$electeur_id, $election_id]);
$vote_exist = $stmt->fetch();

if ($vote_exist) {
    echo "⚠️ Vous avez déjà voté pour cette élection.<br>";
    echo '<a href="dashboard_electeur.php">Retour</a>';
    exit();
}

// Enregistrement du vote
$stmt = $pdo->prepare("INSERT INTO votes (electeur_id, election_id, candidat_id) VALUES (?, ?, ?)");
if ($stmt->execute([$electeur_id, $election_id, $candidat_id])) {
    echo " Votre vote a été enregistré avec succès !<br>";
    echo '<a href="dashboard_electeur.php">Retour au tableau de bord</a>';
} else {
    echo " Une erreur est survenue lors de l'enregistrement.";
    header("refresh:20;url=dashboard_electeur.php");
}
