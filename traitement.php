<?php
require_once 'basseDedonnee.php'; // fichier de connexion ($bdd)

if (isset($_POST['ok'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $numSecu = $_POST['num_secu'];

    try {
        // Vérifier si la table "utilisateur" existe
        $tableCheck = $bdd->query("SHOW TABLES LIKE 'utilisateur'");
        if ($tableCheck->rowCount() == 0) {
            // Création de la table si elle n'existe pas
            $createTableSQL = "
                CREATE TABLE utilisateur (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    pseudo VARCHAR(100) NOT NULL UNIQUE,
                    nom VARCHAR(100) NOT NULL,
                    prenom VARCHAR(100) NOT NULL,
                    email VARCHAR(150) NOT NULL UNIQUE,
                    mot_de_passe VARCHAR(255) NOT NULL,
                    numero_securite_sociale VARCHAR(15) NOT NULL UNIQUE,
                    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ";
            $bdd->exec($createTableSQL);
            echo "<p style='color:blue;'>ℹ️ Table <b>utilisateur</b> créée automatiquement.</p>";
        }

        // Préparation de la requête d’insertion
        $requete = $bdd->prepare("
            INSERT INTO utilisateur (pseudo, nom, prenom, email, mot_de_passe, numero_securite_sociale)
            VALUES (:pseudo, :nom, :prenom, :email, :mdp, :numSecu)
        ");

        // Exécution de la requête avec les données sécurisées
        $requete->execute([
            ':pseudo' => $pseudo,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mdp' => password_hash($mdp, PASSWORD_DEFAULT),
            ':numSecu' => $numSecu
        ]);

        echo "<p style='color:green;'>✅ Données enregistrées avec succès !</p>";

    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Erreur lors de l’enregistrement : " . $e->getMessage() . "</p>";
    }

    retourPagePrincipale('index.php', 3);
}


function retourPagePrincipale($url = 'index.php', $delai = 3) {
    echo "
    <div style='
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        font-family: Arial, sans-serif;
    '>
        <div style='text-align: center;'>
            <div class='loader' style=\"
                border: 6px solid #f3f3f3;
                border-top: 6px solid #3498db;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px auto;
            \"></div>
            <p>Redirection en cours... Veuillez patienter.</p>
        </div>
    </div>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        setTimeout(function() {
            window.location.href = '$url';
        }, " . ($delai * 1000) . ");
    </script>
    ";
}
?>
