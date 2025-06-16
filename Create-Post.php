<?php
session_start(); // Démarre la session pour accéder aux données utilisateur

require_once 'PostController.php'; // Chargement du contrôleur des posts

$controller = new PostController();

// Vérifie que l'utilisateur est connecté (session active avec user_id)
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour publier un post.";
    exit; // Arrêt du script si non connecté
}

// Vérifie que les champs 'title' et 'content' du formulaire ne sont pas vides
if (!empty($_POST['title']) && !empty($_POST['content'])) {
    // Protection contre les injections HTML/JS avec htmlspecialchars()
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    // Récupération sécurisée de l'id utilisateur depuis la session
    $authorId = (int) $_SESSION['user_id'];

    // Appel au contrôleur pour créer le post en base
    if ($controller->createPost($title, $content, $authorId)) {
        // Redirection vers la page principale après succès
        header("Location: index.php");
        exit;
    } else {
        // Message d'erreur si la création échoue
        echo "Erreur lors de l'ajout du post.";
    }
} else {
    // Message si les champs ne sont pas remplis
    echo "Veuillez remplir tous les champs.";
}
?>
