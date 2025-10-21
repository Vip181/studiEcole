<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>

  <form method="POST" action="traitementConnexion.php">
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

    <label for="mdp">Mot de passe :</label>
    <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required>

    <input type="submit" value="Se connecter">
  </form>


  <?php
require_once 'basseDedonnee.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mdp = $_POST['mdp'];

    $requete = $bdd->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $requete->execute([':email' => $email]);
    $user = $requete->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mdp, $user['mot_de_passe'])) {
        // Enregistrer les infos de session
        $_SESSION['utilisateur_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        header('Location: utilisateur.php');
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Email ou mot de passe incorrect.</p>";
        echo "<p style='text-align:center;'><a href='login.php'>🔙 Retour</a></p>";
    }
}
?>
</body>

</html>
