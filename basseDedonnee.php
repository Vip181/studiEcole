<?php
session_start(); // Active les sessions pour vérifier le rôle utilisateur

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donnée";

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si l'utilisateur est administrateur, afficher le message
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo "Connexion réussie à la base de données ✅";
    }

    // Si ce n’est pas un admin, ne rien afficher du tout

} catch (PDOException $e) {
    // En cas d’erreur, afficher les détails uniquement aux admins
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo "Erreur de connexion : " . $e->getMessage();
    }
    // Les autres ne voient rien
}
?>

