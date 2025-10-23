<?php
require_once 'basseDedonnee.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['utilisateur_id'];
$nom = htmlspecialchars($_SESSION['nom']);
$prenom = htmlspecialchars($_SESSION['prenom']);

// Crée un dossier personnel pour l’utilisateur si inexistant
$dossierUser = "dossier_utilisateurs/$id";
if (!is_dir($dossierUser)) {
    mkdir($dossierUser, 0777, true);
}

// Mise à jour du médecin choisi
if (isset($_POST['choisir_medecin'])) {
    $medecin_id = intval($_POST['medecin_id']);
    $update = $bdd->prepare("UPDATE utilisateur SET medecin_id = :medecin_id WHERE id = :id");
    $update->execute([
        ':medecin_id' => $medecin_id,
        ':id' => $id
    ]);
    $_SESSION['medecin_id'] = $medecin_id;
    $message = "✅ Médecin mis à jour avec succès !";
}

// Récupère la liste des médecins
$medecins = $bdd->query("SELECT id, nom, prenom, specialite FROM medecin ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour associer un logo à chaque spécialité
function getLogo($specialite) {
    $logos = [
        'Cardiologue' => '❤️',
        'Urologue' => '💧',
        'Pneumologue' => '🌬️',
        'Dermatologue' => '🧴',
        'Gynécologue' => '👶',
        'Pédiatre' => '🧒',
        'Radiologue' => '🩻',
        'Psychiatre' => '🧠',
        'Médecin généraliste' => '🩺',
        'Autre' => '⚕️'
    ];
    return $logos[$specialite] ?? '⚕️';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Utilisateur</title>
  <link rel="stylesheet" href="css/utilisateur.css">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
</head>
<body>

  <header>
    <h1>👤 Bonjour, <?php echo "$prenom $nom"; ?></h1>
    <a href="logout.php" class="logout-btn">Déconnexion</a>
  </header>

  <main>
    <?php if (!empty($message)) echo "<p class='success-message'>$message</p>"; ?>

    <!-- Calendrier -->
    <section class="calendrier">
      <h2>📅 Votre calendrier de rendez-vous</h2>
      <div id="calendar"></div>
    </section>

    <!-- Documents -->
    <section class="documents">
      <h2>📄 Vos documents médicaux</h2>
      <form action="upload_documents.php" method="POST" enctype="multipart/form-data">
        <label>Pièce d'identité :</label>
        <input type="file" name="piece_identite" accept=".pdf,.jpg,.jpeg,.png"><br><br>

        <label>Ordonnance médicale :</label>
        <input type="file" name="ordonnance" accept=".pdf,.jpg,.jpeg,.png"><br><br>

        <button type="submit">📤 Envoyer les fichiers</button>
      </form>

      <div class="liste-docs">
        <h3>Vos fichiers déjà envoyés :</h3>
        <ul>
          <?php
          $fichiers = scandir($dossierUser);
          foreach ($fichiers as $f) {
              if ($f !== '.' && $f !== '..') {
                  echo "<li><a href='$dossierUser/$f' target='_blank'>$f</a></li>";
              }
          }
          ?>
        </ul>
      </div>
    </section>

    <!-- Choix du médecin -->
    <section class="choix-medecin">
      <h2>👨‍⚕️ Choisir votre médecin</h2>
      <form method="POST" id="formChoixMedecin">
        <div class="medecin-grid">
          <?php foreach ($medecins as $m): 
              $isSelected = (isset($_SESSION['medecin_id']) && $_SESSION['medecin_id'] == $m['id']);
              $class = $isSelected ? "medecin-card selection-active" : "medecin-card";
          ?>
              <div class="<?= $class ?>" data-id="<?= $m['id'] ?>">
                  <div class="logo"><?= getLogo($m['specialite']) ?></div>
                  <h3>Dr. <?= htmlspecialchars($m['prenom']) ?> <?= htmlspecialchars($m['nom']) ?></h3>
                  <p><?= htmlspecialchars($m['specialite']) ?></p>
                  <button type="button" class="btn-choisir" onclick="choisirMedecin(<?= $m['id'] ?>)">Choisir</button>
              </div>
          <?php endforeach; ?>
        </div>
        <input type="hidden" name="medecin_id" id="medecin_id">
        <input type="hidden" name="choisir_medecin" value="1">
      </form>
    </section>
  </main>

  <script>
  // Gestion du clic sur les cartes
  function choisirMedecin(id) {
      document.getElementById('medecin_id').value = id;
      document.getElementById('formChoixMedecin').submit();
  }

  document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: 'fr',
          height: 500,
          headerToolbar: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek'
          },
          events: [
              {
                  title: 'Consultation médicale',
                  start: '2025-10-25'
              }
          ]
      });
      calendar.render();
  });
  </script>

</body>
</html>