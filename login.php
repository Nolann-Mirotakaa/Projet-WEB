<?php
require 'BD.php';     // Connexion à la base de données via $pdo
require 'header.php'; // Démarrage de session et header HTML

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Recherche de l'utilisateur en base
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Vérification du mot de passe haché
    if ($user && password_verify($password, $user['password'])) {
        // Stockage des infos utilisateur en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];

        // Redirection vers la page principale
        header('Location: index.php');
        exit;
    } else {
        $error = "Nom ou mot de passe incorrect.";
    }
}
?>

<link rel="stylesheet" href="style.css">
<div class="post-form">
    <h2>Connexion :</h2>
    <div class="post-form">
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" novalidate>
            Nom : <input type="text" name="username" required><br>
            Mot de passe : <input type="password" name="password" required><br>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</div>
<script src="script.js" defer></script>
