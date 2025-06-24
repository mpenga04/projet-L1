<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "vote");

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupération des données du formulaire
$pseudo = htmlspecialchars(trim($_POST['pseudo']));
$email = htmlspecialchars(trim($_POST['email']));
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // mot de passe sécurisé

// Vérifier si l'email est déjà utilisé
$sql_check = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Cet email est déjà utilisé.";
} else {
    // Insérer dans la base de données
    $sql = "INSERT INTO admin (pseudo, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $pseudo, $email, $password);

    if ($stmt->execute()) {
        echo "Inscription réussie ! 🎉";
        // header("Location: login_admin.html"); // à activer si tu veux rediriger
    } else {
        echo "Erreur lors de l'inscription : " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
