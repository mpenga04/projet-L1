<?php
session_start();
require_once '../page_php/connexion.php';
if (isset($_POST['email'], $_POST['password'])) {
  $email = htmlspecialchars($_POST['email']);
  $password = $_POST['password'];

  // Vérifier si l'email existe
  $query = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
  $query->execute([$email]);
  $user = $query->fetch();

  if ($user && password_verify($password, $user['password'])) {
    // Connexion réussie
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['pseudo'] = $user['pseudo'];
    header("Location:dashboard_admin.php"); // Rediriger vers le tableau de bord
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
  <title>Admin</title>
  <link rel="stylesheet" href="../Css/admin.css">
</head>

<body>
  <div class="formulaire">
    <form action="" method="POST">
      <h1>Connexion Admin</h1>
      <h2>Veuillez remplir ces champs</h2>
      <div class="label">
        <input type="email" name="email" id="nomipunt" placeholder="Entrez votre email" required>
      </div>
      <div class="label">
        <input type="password" name="password" id="passewordinput" placeholder="Entrez votre mot de passe admin"
          required>
      </div>
      <div class="bou">
        <button type="submit" class="bouton">Connexion</button>
      </div>
      <div class="compte">
        <p>Don't have an account? <a href="inscri_admin.php">create an account</a></p>
      </div>
    </form>
  </div>
</body>

</html>