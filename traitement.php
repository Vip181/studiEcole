<?php
require_once 'basseDedonnee.php'; // fichier de connexion ($bdd)

if (isset($_POST['ok'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $numSecu = $_POST['num_secu'];

    // (facultatif) affichage de test
    echo "Nom : " . htmlspecialchars($nom) . "<br>";
    echo "Prénom : " . htmlspecialchars($prenom) . "<br>";
    echo "Pseudo : " . htmlspecialchars($pseudo) . "<br>";
    echo "Numéro de sécurité sociale : " . htmlspecialchars($numSecu) . "<br>";
    echo "Mot de passe : " . htmlspecialchars($mdp) . "<br>";

    try {
        // Préparation de la requête d’insertion
        $requete = $bdd->prepare("
            INSERT INTO utilisateur (id, pseudo, nom, prenom, mot_de_passe, numero_securite_sociale)
            VALUES (NULL, :pseudo, :nom, :prenom, :mdp, :numSecu)
        ");

        // Exécution de la requête avec les données
        $requete->execute([
            ':pseudo' => $pseudo,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':mdp' => password_hash($mdp, PASSWORD_DEFAULT),
            ':numSecu' => $numSecu
        ]);

        echo "<p style='color:green;'>✅ Données enregistrées avec succès !</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Erreur lors de l’enregistrement : " . $e->getMessage() . "</p>";
    }
}
?>
