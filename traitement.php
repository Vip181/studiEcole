<?php
require_once 'basseDedonnee.php'; // fichier de connexion ($bdd)

if (isset($_POST['ok'])) {
    // Récupération des données du formulaire
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $pseudo = trim($_POST['pseudo']);
    $mdp = $_POST['mdp'];
    $numSecu = trim($_POST['num_secu']);

    try {
        // Vérifier si la table "utilisateur" existe
        $tableCheck = $bdd->query("SHOW TABLES LIKE 'utilisateur'");
        if ($tableCheck->rowCount() == 0) {
            // Création automatique si la table n’existe pas
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

        // Vérifier si un utilisateur existe déjà
        $verif = $bdd->prepare("
            SELECT * FROM utilisateur 
            WHERE pseudo = :pseudo 
               OR email = :email 
               OR numero_securite_sociale = :numSecu
        ");
        $verif->execute([
            ':pseudo' => $pseudo,
            ':email' => $email,
            ':numSecu' => $numSecu
        ]);

        if ($verif->rowCount() > 0) {
            echo "
            <div style='
                text-align:center;
                font-family:Arial, sans-serif;
                margin-top:50px;
                color:red;
            '>
                <h2>⚠️ Utilisateur déjà existant !</h2>
                <p>Le pseudo, l’adresse e-mail ou le numéro de sécurité sociale est déjà utilisé.</p>
                <button onclick=\"window.location.href='inscription.php'\" 
                        style='
                            background-color:#3498db;
                            color:white;
                            padding:10px 20px;
                            border:none;
                            border-radius:8px;
                            cursor:pointer;
                        '>
                    🔙 Retour à la page d’inscription
                </button>
            </div>";
            exit; // Stoppe le script ici
        }

        // Si tout est bon, on insère
        $requete = $bdd->prepare("
            INSERT INTO utilisateur (pseudo, nom, prenom, email, mot_de_passe, numero_securite_sociale)
            VALUES (:pseudo, :nom, :prenom, :email, :mdp, :numSecu)
        ");

        $requete->execute([
            ':pseudo' => $pseudo,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mdp' => password_hash($mdp, PASSWORD_DEFAULT),
            ':numSecu' => $numSecu
        ]);

        echo "<p style='color:green; text-align:center;'>✅ Données enregistrées avec succès !</p>";
        retourPagePrincipale('index.php', 3);

    } catch (PDOException $e) {
        // Gestion des erreurs PDO (doublons, format invalide, etc.)
        echo "
        <div style='
            text-align:center;
            font-family:Arial, sans-serif;
            margin-top:50px;
            color:red;
        '>
            <h2>❌ Erreur lors de l’enregistrement</h2>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
            <button onclick=\"window.location.href='inscription.php'\"
                    style='
                        background-color:#e74c3c;
                        color:white;
                        padding:10px 20px;
                        border:none;
                        border-radius:8px;
                        cursor:pointer;
                    '>
                🔁 Retour à la page d’inscription
            </button>
        </div>";
        exit;
    }
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
