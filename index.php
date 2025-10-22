<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h2 class="logo">Medicale Studi</h2>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
            <a href="#">À propos</a>
        </nav>
        <a href="login.php" class="login-btn">Login</a>
    </header>

    <main>
        <h1>Bienvenue sur mon site !</h1>
        <p>Cliquez sur un des boutons ci-dessous pour accéder à la page d'inscription.</p>
        
        <!-- Bouton inscription utilisateur -->
        <form action="inscription.php" method="get" id="bt-utilisteur">
            <button type="submit">Créer un compte utilisateur</button>
        </form>
<p> 

</p>
        <!-- Bouton inscription médecin -->
        <form action="inscription_medecin.php" method="get" id="btn-medecin">
            <button type="submit">Créer un compte médecin</button>
        </form>
    </main>
</body>
</html>
