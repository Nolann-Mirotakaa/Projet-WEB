<?php
// Récupération du numéro de page dans l'URL, sinon page 1 par défaut
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Nombre de posts à afficher par page
$limit = 2;

// Calcul de l'offset pour la requête SQL, selon la page actuelle
$offset = ($page - 1) * $limit;

// Appel au contrôleur pour récupérer les posts de la page demandée
$posts = $postController->getPostsByPage($offset, $limit);
?>

<!-- Boucle d'affichage des posts récupérés -->
<?php foreach ($posts as $post): ?>
    <div class="post">
        <h2><?= htmlspecialchars($post->getTitle()) ?></h2> <!-- Protection contre XSS -->

        <p>
            <em>
                Écrit par
                <?php 
                // Récupération de l'auteur du post par son ID
                $user = $userController->getUserById($post->getAuthorId());
                if ($user) {
                    // Affichage sécurisé du nom de l'auteur
                    echo htmlspecialchars($user->getUsername());
                } else {
                    echo "Auteur inconnu"; // Gestion du cas où l'auteur n'existe plus
                }
                ?>
                le <?= date('d/m/Y à H:i', strtotime($post->getCreatedAt())) ?> <!-- Format date lisible -->
            </em>
        </p>

        <!-- Contenu du post avec gestion des retours à la ligne -->
        <p><?= nl2br(htmlspecialchars($post->getContent())) ?></p>
    </div>
<?php endforeach; ?>
