<?php
$bdd = new PDO('mysql:host=localhost;dbname=vote;charset=utf8', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['pseudo'], $_POST['email'], $_POST['password'])) {
    // Récupérer les données du formulaire
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    // Vérifier si l'email existe déjà
    $check = $bdd->prepare("SELECT * FROM admin WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        echo "Cet email est déjà utilisé. Essayez un autre.";
        exit;
    }
    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Insérer dans la base de données
    $insert = $bdd->prepare("INSERT INTO admin (pseudo, email, password) VALUES (?, ?, ?)");
    $insert->execute([$pseudo, $email, $hashed_password]);
    echo "✅ Inscription réussie ! Vous pouvez maintenant vous connecter.";
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Administrateur</title>
    <link rel="stylesheet" href="../Css/inscri_admin.css">
</head>

<body>
    <div class="formulaire">
        <form action="" method="POST">
            <h1>Inscrivez-vous</h1>
            <h2>Veuillez remplir ces champs</h2>
            <div class="label">
                <input type="text" name="pseudo" id="pseudoinput" placeholder="Entrez un pseudo" required>
            </div>
            <div class="label">
                <input type="email" name="email" id="emailinput" placeholder="Email ex : umbrya@gmail.com" required>
            </div>
            <div class="label">
                <input type="password" name="password" id="passwordinput" placeholder="Entrez un mot de passe" required>
            </div>
            <button type="submit" class="bouton">Soumettre</button>
        </form>
    </div>
</body>

</html>