<?php
require_once 'UserController.php'; // Inclusion du contrôleur de gestion des utilisateurs
require 'header.php'; // Inclusion de l'en-tête HTML ou de la session

// Vérifie que l'utilisateur connecté est un administrateur
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Accès interdit."); // Bloque l'accès si ce n’est pas un admin
}

// Si la requête est POST et contient un ID utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $controller = new UserController(); // Instanciation du contrôleur
    $controller->deleteUserById((int) $_POST['user_id']); // Suppression sécurisée (cast en entier)
}

// Redirection vers la page d’administration après suppression
header("Location: admin_users.php");
exit;
?>
