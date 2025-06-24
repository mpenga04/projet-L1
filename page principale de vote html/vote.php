<?php
session_start();
$electeur_id = $_SESSION['electeur_id'] ?? 1;

$pdo = new PDO('mysql:host=localhost;dbname=vote', 'root', '');

$election_id = $_POST['election_id'];
$candidat_id = $_POST['candidat_id'];

$stmt = $pdo->prepare("INSERT INTO votes (electeur_id, election_id, candidat_id) VALUES (?, ?, ?)");
if ($stmt->execute([$electeur_id, $election_id, $candidat_id])) {
    echo "✅ Votre vote a été enregistré avec succès !";
    echo '<br><a href="dashboard_electeur.php">Retour au tableau de bord</a>';
} else {
    echo "❌ Vous avez déjà voté pour cette élection.";
}
// Redirection vers le tableau de bord après 5 secondes
header("refresh:20;url=dashboard_electeur.php");
