<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>
 
  <form action="traitement_medecin.php" method="POST">
    <label>Nom :</label>
    <input type="text" name="nom" required><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" required><br>

    <label>Spécialité :</label>
    <select name="specialite" required>
        <option value="">-- Sélectionnez une spécialité --</option>
        <option value="Médecin généraliste">Médecin généraliste</option>
        <option value="Cardiologue">Cardiologue</option>
        <option value="Urologue">Urologue</option>
        <option value="Pneumologue">Pneumologue</option>
        <option value="Dermatologue">Dermatologue</option>
        <option value="Gynécologue">Gynécologue</option>
        <option value="Pédiatre">Pédiatre</option>
        <option value="Radiologue">Radiologue</option>
        <option value="Psychiatre">Psychiatre</option>
        <option value="Autre">Autre</option>
    </select><br>

    <label>Email :</label>
    <input type="email" name="email" required><br>

    <label>Pseudo :</label>
    <input type="text" name="pseudo" required><br>

    <label>Mot de passe :</label>
    <input type="password" name="mdp" required><br>

    <label>Numéro RPPS :</label>
    <input type="text" name="NUMERO_rpps" required><br><br>

    <button type="submit" name="ok">S'inscrire</button>
</form>

</body>
</html>

