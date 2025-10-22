<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>
 
  <form method="POST" action="">
    <label>Nom :</label>
    <input type="text" name="nom" required>

    <label>Prénom :</label>
    <input type="text" name="prenom" required>

    <label>Email :</label>
    <input type="email" name="email" placeholder="exemple@domaine.com" required>

    <label>Pseudo :</label>
    <input type="text" name="pseudo" required>

    <label>Mot de passe :</label>
    <input type="password" name="mdp" required>

    <label>Numéro rpps :</label>
    <input type="text" name="num_rpps" pattern="[0-9]{11}" title="11 chiffres requis" required>

    <input type="submit" name="ok" value="Créer le compte">
  </form>

</body>
</html>

