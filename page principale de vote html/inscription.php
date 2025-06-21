<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=vote;charset=utf8', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['Soumettre'])) {
    if ((!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']))) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $insert = $bdd->prepare('INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)');
        $insert->execute(array($pseudo, $email, $password));
    } else {
        echo "Veuillez remplir tous les champs";
    }
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