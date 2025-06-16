<?php
require 'header.php'; // Inclut l'en-tête avec la session et la navbar
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Anime News</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="traductible">Publication</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
    <p style="text-align:center;">
        <span id="easter-egg" style="cursor:pointer" class="traductible" role="button" tabindex="0" aria-label="Bienvenue sur BlogAnime">Bienvenue sur BlogAnime !</span>
        <?php if (!empty($_SESSION['is_admin'])): ?>
        <span class="traductible" aria-label="Administrateur connecté"> Administrateur</span>
        <?php endif ?>
    </p>
    <?php else: ?>
    <p id="easter-egg" style="cursor:pointer; text-align:center" class="traductible" role="button" tabindex="0" aria-label="Vous n'êtes pas connecté.">Vous n'êtes pas connecté.</p>
    <?php endif ?>

    <?php include('articles.php'); ?> <!-- Inclusion des articles -->

    <br>
    <div class="pagination" style="text-align:center;" role="navigation" aria-label="Pagination">
        <?php if (isset($page) && $page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" aria-label="Page précédente"><span class="traductible">Page précédente</span></a>
        <?php endif; ?>
        <a href="?page=<?= isset($page) ? $page + 1 : 2 ?>" aria-label="Page suivante"><span class="traductible">Page suivante</span></a>
    </div>
    <br>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="button-color" style="text-align:center;">
        <button class="traductible" onclick="window.location.href='ajouter-post.php'" aria-label="Faire un post">Faire un post</button>
        <button class="traductible" onclick="window.location.href='update_post.php'" aria-label="Modifier un post">Modifier un post</button>
        <button class="traductible" onclick="window.location.href='delete_post.php'" aria-label="Supprimer un post">Supprimer un post</button>
    </div>
    <?php endif; ?>

    <h1 class="traductible">Animes</h1>

    <form id="search-form" style="text-align:center;">
        <input type="text" id="search-input" class="traductible" placeholder="Rechercher un animé...">
        <select id="type-select" style="padding: 0.5rem;">
            <option value="" class="traductible">Tous les types</option>
            <option value="tv" class="traductible">Série TV</option>
            <option value="movie" class="traductible">Film</option>
            <option value="ova" class="traductible">OVA</option>
            <option value="ona" class="traductible">ONA</option>
            <option value="special" class="traductible">Spécial</option>
            <option value="music" class="traductible">Musique</option>
        </select>

        <button type="submit" aria-label="Lancer la recherche"><span class="traductible">Rechercher</span></button>
    </form>

    <h2 id="anime-title" class="section-title"></h2>
    <div id="posts-anime" aria-live="polite"></div>

    <script src="script.js" defer></script>

    <div id="anime-list"></div>
    <div class="pagination" style="text-align:center;" role="navigation" aria-label="Pagination des animes">
        <button onclick="page > 1 && loadAnime(--page)" aria-label="Page précédente des animes"><span class="traductible">Page précédente</span></button>
        <button onclick="loadAnime(++page)" aria-label="Page suivante des animes"><span class="traductible">Page suivante</span></button>
    </div>
</body>

</html>
