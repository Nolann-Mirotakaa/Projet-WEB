<?php
require_once 'UserController.php';
require_once 'header.php';


if (!isset($_SESSION['user_id'])) {
    die("Utilisateur non connecté.");
}

$controller = new UserController();
$userId = $_SESSION['user_id'];
$user = $controller->getUserById($userId);
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);
    $newPassword = $_POST['new_password'];
    $currentPassword = $_POST['current_password'];

    if ($controller->verifyPassword($userId, $currentPassword)) {
        if ($controller->updateUser($userId, $newUsername, $newPassword)) {
            $_SESSION['username'] = $newUsername;
            $message = "Informations mises à jour avec succès.";
        } else {
            $message = "Erreur lors de la mise à jour.";
        }
    } else {
        $message = "Mot de passe actuel incorrect.";
    }
}
?>
<div class="post-form">
<h2>Modifier mes informations :</h2>
    <div class="post-form">
    <p><?= $message ?></p>
    <form method="post">
        Nom d'utilisateur : <input type="text" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required><br>
        Nouveau mot de passe : <input type="password" name="new_password" required><br>
        Mot de passe actuel : <input type="password" name="current_password" required><br>
        <button type="submit" >Mettre à jour</button>
    </form>
    </div>
    <script src="script.js"></script>
</div>
