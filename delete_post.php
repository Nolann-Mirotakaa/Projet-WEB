<?php
require_once 'header.php'; // Chargement des sessions, configurations, etc.
require_once 'PostController.php'; // Contrôleur pour gérer les posts

$controller = new PostController();

// Récupération de l'id utilisateur et son rôle depuis la session (null ou chaîne vide si non définis)
$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';

// Traitement du formulaire de suppression de post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $postId = (int) $_POST['post_id']; // Conversion sécurisée en entier

    // Appel à la méthode deletePost, qui doit vérifier si l'utilisateur peut supprimer ce post
    if ($userId && $controller->deletePost($postId, $userId, $role)) {
        $message = "Le post a été supprimé avec succès.";
        $messageType = 'success'; // Pour afficher un message vert
    } else {
        $message = "Vous n'avez pas le droit de supprimer ce post.";
        $messageType = 'error'; // Pour afficher un message rouge
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="post-form">
    <div class="post-form">
        <h2 style="text-align:center;">Vos posts :</h2>

        <!-- Affichage conditionnel du message de retour -->
        <?php if (isset($message)): ?>
            <p class="<?= $messageType ?>-message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <ul>
            <?php
            // Récupération de tous les posts de l'utilisateur connecté
            $userPosts = $controller->getPostsByUser($userId);
            foreach ($userPosts as $p):
            ?>
                <li>
                    <strong><?= htmlspecialchars($p->getTitle()) ?></strong> - 
                    <!-- Formulaire pour supprimer un post -->
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">
                        <input type="hidden" name="post_id" value="<?= $p->getId() ?>">
                        <button type="submit" class="link-delete">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="script.js"></script>
</div>
    
</body>
</html>

