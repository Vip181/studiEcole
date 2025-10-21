<?php
session_start();
require_once 'basseDedonnee.php';

// Vérifie si connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['utilisateur_id'];
$nom = htmlspecialchars($_SESSION['nom']);
$prenom = htmlspecialchars($_SESSION['prenom']);

// Crée dossier personnel si pas encore existant
$dossierUser = "dossier_utilisateurs/$id";
if (!is_dir($dossierUser)) {
    mkdir($dossierUser, 0777, true);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Utilisateur</title>
  <link rel="stylesheet" href="./css/utilisateurcss.css">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
</head>
<body>

  <header>
    <h1>👤 Bonjour, <?php echo "$prenom $nom"; ?></h1>
    <a href="logout.php" class="logout-btn">Déconnexion</a>
  </header>

  <main>
    <section class="calendrier">
      <h2>📅 Votre calendrier de rendez-vous</h2>
      <div id="calendar"></div>
    </section>

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
  </main>

  <script>
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
              // Exemple d'événement — on pourra le rendre dynamique ensuite
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