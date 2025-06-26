<?php
session_start();
require_once '../page_php/connexion.php';
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $check = $pdo->prepare("SELECT * FROM electeurs WHERE email = ?");
    $check->execute([$email]);
    $user = $check->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['electeur_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];
        header("Location: dashboard_electeur.php");
        exit;
    } else {
        echo " Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../Css/connexion.css">
</head>

<body>
    <div class="formulaire">
        <form method="POST" action="">
            <h1>Connexion</h1>
            <h2>Veuillez remplir ces champs</h2>
            <div class="label">
                <input type="text" name="email" id="emailinput" placeholder="votre email" required>
            </div>
            <div class="label">
                <input type="password" name="password" id="passwordinput" placeholder="votre mot de passe" required>
            </div>
            <button type="submit" class="bouton" name="Se connecter">Se connecter</button>
            <div class="compte">
                <p>Don't have an account? <a href="inscription.php">create an account</a></p>
            </div>
        </form>
    </div>
</body>

</html>