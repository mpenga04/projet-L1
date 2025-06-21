<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../Css/admin.css">
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

            <button type="submit" class="bouton">Se connecter</button>
            <div class="compte">
                <p>Don't have an account? <a href="inscription.html">create an account</a></p>
            </div>
        </form>
    </div>
</body>

</html>