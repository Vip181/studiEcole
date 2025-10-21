<?php
session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['utilisateur_id'];
$dossierUser = "dossier_utilisateurs/$id";
if (!is_dir($dossierUser)) mkdir($dossierUser, 0777, true);

function uploadFichier($nomChamp, $dossier) {
    if (!empty($_FILES[$nomChamp]['name'])) {
        $fichier = $_FILES[$nomChamp];
        $ext = pathinfo($fichier['name'], PATHINFO_EXTENSION);
        $nomFichier = $nomChamp . '_' . time() . '.' . $ext;
        $destination = "$dossier/$nomFichier";

        // Vérifie le type
        $typesAutorises = ['pdf','jpg','jpeg','png'];
        if (in_array(strtolower($ext), $typesAutorises)) {
            move_uploaded_file($fichier['tmp_name'], $destination);
            echo "<p style='color:green;'>✅ Fichier $nomChamp envoyé avec succès.</p>";
        } else {
            echo "<p style='color:red;'>❌ Format de fichier non autorisé ($nomChamp).</p>";
        }
    }
}

uploadFichier('piece_identite', $dossierUser);
uploadFichier('ordonnance', $dossierUser);

echo "<p><a href='utilisateur.php'>🔙 Retour à votre espace</a></p>";
?>