<?php
require 'BD.php';
require 'header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $pdo->prepare("SELECT id FROM user WHERE email = ?");
    $check->execute([$email]);

    if ($check->fetch()) {
        $message = "Cet email est déjà utilisé.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $password]);
            $message = "Inscription réussie. <a href='login.php'>Connectez-vous</a>";
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<div class="post-form">
    <h2>Inscription :</h2>
    <div class="post-form">
        <?php if (!empty($message)) : ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <form method="post">
            Nom : <input type="text" name="username" required><br>
            Email : <input type="email" name="email" required><br>
            Mot de passe : <input type="password" name="password" required><br>
            <button type="submit">S'inscrire</button>
        </form>
    </div>
</div>
<script src="script.js"></script>
