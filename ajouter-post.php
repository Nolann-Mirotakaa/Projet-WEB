<?php
require 'header.php';
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un article</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>    
<div class="post-form">
    <form method="POST" action="Create-Post.php" class="post-form">
        <h2>Nouvelle Publication :</h2><br>
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" required>

        <label for="content">Contenu :</label>
        <textarea name="content" id="content" required></textarea>

        <button type="submit">Publier</button>
    </form>
    <script src="script.js"></script>
</body>
</html>
