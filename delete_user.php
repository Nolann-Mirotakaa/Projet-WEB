<?php
require_once 'header.php';
require_once 'UserController.php';

if (!isset($_SESSION['user_id'])) {
    die("Utilisateur non connecté.");
}

$controller = new UserController();
$userId = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if (!empty($password)) {
        if ($controller->verifyPassword($userId, $password)) {
            $controller->deleteUser($userId);
            session_destroy();
            header("Location: login.php");
            exit;
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Veuillez entrer votre mot de passe.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression du compte</title>
</head>
<body>
<div class="post-form">
    <h2>Suppression du compte :</h2>
        <div class="post-form">
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="password">Mot de passe actuel :</label>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit" onclick="return confirm('Êtes-vous sûr ? Cette action est irréversible.');">
            Supprimer définitivement mon compte
            </button>
        </form>
        </div>
</div>
<script src="script.js"></script>
</body>
</html>
