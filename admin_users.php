<?php
require_once 'UserController.php'; // Chargement du contrôleur utilisateur
require_once 'header.php'; // Démarrage de la session + en-tête HTML

// Vérifie si l'utilisateur est un admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Accès interdit."); // Bloque l'accès aux non-admins
}

$controller = new UserController(); // Instancie le contrôleur utilisateur
$users = $controller->getAllUsers(); // Récupère la liste de tous les utilisateurs
?>

<!-- Formulaire de gestion (interface d’administration) -->
<div class="post-form">
    <h2>Gestion des utilisateurs :</h2>
    <div class="post-form">
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <!-- Boucle sur tous les utilisateurs sauf celui actuellement connecté -->
        <?php foreach ($users as $user): ?>
            <?php if ($user->getId() != $_SESSION['user_id']): ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><?= htmlspecialchars($user->getUsername()) ?></td>
                    <td><?= htmlspecialchars($user->getEmail()) ?></td>
                    <td>
                        <!-- Formulaire de suppression -->
                        <form method="POST" action="admin_delete_user.php" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $user->getId() ?>">
                            <button type="submit" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    </div>
</div>
