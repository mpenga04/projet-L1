<?php 
$bdd= new PDO('mysql:host=localhost;dbname=vote;charset=utf8', 'root', '');
if(isset($_POST[Se connecter])) {
    if(!empty($_POST['pseudo']) && !empty($_POST['password'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['password']);
        
        // Vérification des identifiants dans la base de données
        $requete = $bdd->prepare('SELECT * FROM user WHERE pseudo = ? AND email = ?');
        $requete->execute(array($pseudo, $email));
        
        if($requete->rowCount() > 0) {
            // Connexion réussie
            session_start();
            $_SESSION['pseudo'] = $pseudo;
            header('Location: page_principale.php'); // Redirection vers la page principale
            exit();
        } else {
            $message = "Identifiants incorrects";
        }
    } else {
        $message = "Veuillez remplir tous les champs";
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
        <form action="">
            <h1>Connexion</h1>
            <h2>Veuillez remplir ces champs</h2>
            <div class="label">
                <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre pseudo" required>
            </div>
            <div class="label">
                <input type="tel" name="email" id="tellinput" placeholder="votre mot de passe" required>
            </div>

            <button type="submit" class="bouton" name="Se connecter">Se connecter</button>
            <div class="compte">
                <p>Don't have an account? <a href="inscription.php">create an account</a></p>
            </div>
        </form>
    </div>
</body>

</html>