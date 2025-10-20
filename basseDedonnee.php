<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donnée";

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    
    // Activation du mode d’erreur pour afficher les exceptions en cas de problème
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

