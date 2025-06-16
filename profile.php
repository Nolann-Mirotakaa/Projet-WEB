<?php 
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
</head>
<body>
<div class="post-form">
        <h2>Mon profil :</h2>
    <div class="post-form">
        <p>Vous êtes connecté
        </p>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <button onclick="window.location.href='admin_users.php'" class="pagination">Gérer les utilisateurs</button><br><br>
        <?php endif; ?>
        <button onclick="window.location.href='update_user.php'" class="pagination">Modifier mes informations</button><br><br>
        <button onclick="window.location.href='delete_user.php'" class="pagination">Supprimer mon compte</button>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>

