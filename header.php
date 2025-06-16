<?php
session_start(); 
// Démarre la session pour gérer la connexion utilisateur

// Autoload automatique des classes : dès qu'on instancie une classe, PHP inclut le fichier correspondant
spl_autoload_register(function($class) {
    require "$class.php";
});

// Instanciation des contrôleurs, accessibles dans tout le fichier (ex: pour gérer posts et utilisateurs)
$postController = new PostController();
$userController = new UserController();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"> <!-- Feuille de styles -->
    <title>Site de connexion</title>
</head>
<body>
    <header>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="index.php" class="nav-brand">BlogAnime</a> <!-- Logo ou titre cliquable vers accueil -->
            <button id="toggle-theme">Mode sombre</button> <!-- Bouton pour changer le thème (clair/sombre) -->
        </div>
        <div class="navbar-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Si utilisateur connecté, afficher déconnexion et profil -->
                <a href="logout.php" class="nav-link"><span class="traductible">Déconnexion</span></a>
                <a href="profile.php" class="nav-link"><span class="traductible">Mon Profil</span></a>
            <?php else: ?>
                <!-- Sinon, afficher liens vers login et inscription -->
                <a href="login.php" class="nav-link"><span class="traductible">Connexion</span></a>
                <a href="register.php" class="nav-link"><span class="traductible">Inscription</span></a>
            <?php endif; ?>
        </div>
    </nav>
    </header>
</body>
</html>
