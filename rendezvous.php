<?php
session_start();
require_once 'basseDedonnee.php';

if (!isset($_SESSION['utilisateur_id'])) exit;

$id = $_SESSION['utilisateur_id'];
$sql = "
  SELECT r.date_rdv, m.nom, m.prenom, r.specialite
  FROM rendezvous r
  JOIN medecin m ON r.medecin_id = m.id
  WHERE r.utilisateur_id = :id
";
$stmt = $bdd->prepare($sql);
$stmt->execute([':id' => $id]);
$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = [
        'title' => "Dr. {$row['prenom']} {$row['nom']} ({$row['specialite']})",
        'start' => $row['date_rdv']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);