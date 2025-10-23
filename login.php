<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>

  <h2 style="text-align:center;">🔐 Connexion</h2>

  <form method="POST" action="login.php" style="max-width:400px;margin:auto;">
    <label for="type_compte">Type de compte :</label>
    <select name="type_compte" id="type_compte" required>
      <option value="utilisateur">Utilisateur (Patient)</option>
      <option value="medecin">Médecin</option>
    </select><br><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" placeholder="Entrez votre email" required><br><br>

    <label for="mdp">Mot de passe :</label>
    <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required><br><br>

    <input type="submit" name="ok" value="Se connecter">
  </form>

  <?php
  require_once 'basseDedonnee.php';


  if (isset($_POST['ok'])) {
      $type = $_POST['type_compte'];
      $email = trim($_POST['email']);
      $mdp = $_POST['mdp'];

      if ($type === 'utilisateur') {
          $req = $bdd->prepare("SELECT * FROM utilisateur WHERE email = :email");
      } else {
          $req = $bdd->prepare("SELECT * FROM medecin WHERE email = :email");
      }

      $req->execute([':email' => $email]);
      $user = $req->fetch(PDO::FETCH_ASSOC);

      if ($user && password_verify($mdp, $user['mot_de_passe'])) {
          if ($type === 'utilisateur') {
              $_SESSION['utilisateur_id'] = $user['id'];
              $_SESSION['nom'] = $user['nom'];
              $_SESSION['prenom'] = $user['prenom'];
              header('Location: utilisateur.php');
          } else {
              $_SESSION['medecin_id'] = $user['id'];
              $_SESSION['medecin_nom'] = $user['nom'];
              $_SESSION['medecin_prenom'] = $user['prenom'];
              $_SESSION['NUMERO_rpps'] = $user['NUMERO_rpps'];
              header('Location: medecin.php');
          }
          exit;
      } else {
          echo "<p style='color:red; text-align:center;'>❌ Email ou mot de passe incorrect.</p>";
      }
  }
  ?>
</body>
</html>