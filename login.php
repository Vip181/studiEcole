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

</body>
</html>