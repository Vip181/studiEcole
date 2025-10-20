<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>
 

  <form method="POST" action="traitement.php">
    <label>Nom :</label>
    <input type="text" name="nom" required>

    <label>Prénom :</label>
    <input type="text" name="prenom" required>

    <label>Pseudo :</label>
    <input type="text" name="pseudo" required>

    <label>Mot de passe :</label>
    <input type="password" name="mdp" required>

    <label>Numéro de sécurité sociale :</label>
    <input type="text" name="num_secu" pattern="[0-9]{15}" title="15 chiffres requis" required>

    <input type="submit" name="ok" value="Créer le compte">
  </form>
</body>
</html>
