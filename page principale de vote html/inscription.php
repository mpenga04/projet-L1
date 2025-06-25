<?php
require_once '../page_php/connexion.php';
if (isset($_POST['pseudo'], $_POST['email'], $_POST['password'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Vérifier l'existence
    $check = $pdo->prepare("SELECT * FROM electeurs WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        echo "❌ Cet email est déjà inscrit.";
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $insert = $pdo->prepare("INSERT INTO electeurs (pseudo, email, password) VALUES (?, ?, ?)");
    $insert->execute([$pseudo, $email, $hash]);

    header('Location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../Css/inscription.css">
</head>

<body>
    <div class="formulaire">
        <form method="post" action="">
            <h1>Inscrivez-vous</h1>
            <h2>Veuillez remplir ces champs</h2>
            <div class="label">
                <input type="text" name="pseudo" placeholder="Entrez votre pseudo" autocomplete="off">
            </div>
            <div class="label">
                <input type="email" name="email" placeholder="email ex:umbrya@gmail.com" autocomplete="off">
            </div>
            <div class="label">
                <input type="password" name="password" placeholder="Entrez un mot de passe" autocomplete="off">
            </div>
            <button type="submit" class="bouton" name="Soumettre">Soumettre</button>
        </form>
    </div>
</body>

</html>