<?php
require 'header.php'; // Inclusion du fichier header (souvent pour démarrer session, inclure le HTML commun)
require_once 'PostController.php'; // Inclusion de la classe PostController

// Création d'une instance du contrôleur pour gérer les posts
$controller = new PostController();

// Vérification que l'utilisateur est connecté, sinon message d'erreur et arrêt du script
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté.</p>";
    exit;
}

$userId = $_SESSION['user_id']; // Récupération de l'ID utilisateur en session
$role = $_SESSION['role'] ?? 'user'; // Récupération du rôle (admin ou user), 'user' par défaut

$userPosts = $controller->getPostsByUser($userId); // Récupération des posts de l'utilisateur connecté

$message = ''; // Variable pour stocker un message utilisateur (erreur ou succès)
$messageType = ''; // Variable pour stocker le type de message (success ou error)

$postToEdit = null; // Variable qui contiendra le post à modifier si sélectionné

// Si un paramètre "edit" est passé dans l'URL, on récupère le post à modifier
if (isset($_GET['edit'])) {
    $postId = (int) $_GET['edit']; // Conversion en entier pour sécurité
    $post = $controller->getPost($postId); // Récupération du post correspondant

    // Vérification que le post existe et que l'utilisateur a le droit de le modifier (propriétaire ou admin)
    if ($post && ($post->getAuthorId() === $userId || $role === 'admin')) {
        $postToEdit = $post; // Le post peut être édité, on le stocke
    } else {
        $message = "Vous ne pouvez pas modifier ce post."; // Message d'erreur si pas autorisé
        $messageType = "error";
    }
}

// Traitement du formulaire envoyé en POST pour modifier un post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie que les champs titre, contenu, et id du post sont présents et non vides
    if (!empty($_POST['title']) && !empty($_POST['content']) && isset($_POST['post_id'])) {
        // Nettoyage des données reçues pour éviter injection XSS
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $postId = (int) $_POST['post_id']; // Conversion en entier

        // Appel de la méthode updatePost pour modifier le post
        $updated = $controller->updatePost($postId, $title, $content, $userId, $role);

        if ($updated) {
            $message = "Le post a été modifié avec succès."; // Message de succès
            $messageType = "success";
            $postToEdit = null; // On masque le formulaire après modification
        } else {
            $message = "Erreur ou autorisation insuffisante."; // Message d'erreur si problème
            $messageType = "error";
        }
    } else {
        $message = "Tous les champs sont requis."; // Message d'erreur si champs manquants
        $messageType = "error";
    }
}
?>

<!-- Inclusion du fichier CSS -->
<link rel="stylesheet" href="style.css">

<div class="post-form">
    <h2>Vos posts :</h2>

    <!-- Affichage d'un message s'il existe -->
    <?php if (!empty($message)): ?>
        <p class="<?= $messageType ?>-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- Liste des posts de l'utilisateur -->
    <ul>
        <?php
        foreach ($userPosts as $p) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($p->getTitle()) . "</strong> - <br>"; // Titre du post
            echo "<a href='?edit=" . $p->getId() . "' class='link-modify'>Modifier</a>"; // Lien vers la modification
            echo "</li>";
        }
        ?>
    </ul>

    <!-- Formulaire d'édition affiché seulement si un post est sélectionné -->
    <?php if ($postToEdit): ?>
        <form method="POST" class="post-form">
            <input type="hidden" name="post_id" value="<?= $postToEdit->getId() ?>"> <!-- ID caché du post -->

            <h2>Modifier le post :</h2><br>

            <label for="title">Titre :</label><br>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($postToEdit->getTitle()) ?>" required><br><br>

            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content" rows="5" required><?= htmlspecialchars($postToEdit->getContent()) ?></textarea><br><br>

            <button type="submit">Enregistrer</button>
        </form>
    <?php endif; ?>
    
    <!-- Inclusion du script JS -->
    <script src="script.js"></script>
</div>

