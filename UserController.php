<?php

class UserController
{
    private PDO $db; // Propriété PDO pour la connexion à la base de données

    public function __construct()
    {
        // Paramètres de connexion à la base
        $host = "localhost";
        $dbName = "anime";
        $port = 3306;
        $userName = "root";
        $password = "";

        // Tentative de connexion PDO avec gestion des erreurs
        try {
            $this->setDb(new PDO("mysql:host=$host;dbname=$dbName;port=$port;charset=utf8mb4", $userName, $password));
        } catch (PDOException $error) {
            echo $error->getMessage(); // Affiche le message d'erreur en cas d'échec
        }
    }

    // Setter pour la connexion PDO
    public function setDb($db)
    {
        $this->db = $db;
        return $this; // Retourne l'objet courant pour chaînage éventuel
    }

    // Récupère un utilisateur par son ID, retourne un objet User ou null si non trouvé
    public function getUserById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null; // Instancie un objet User si trouvé
    }

    // Met à jour le nom d'utilisateur et le mot de passe (hashé) d'un utilisateur
    public function updateUser(int $id, string $username, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash du mot de passe sécurisé

        $stmt = $this->db->prepare("UPDATE user SET username = ?, password = ? WHERE id = ?");
        return $stmt->execute([$username, $hashedPassword, $id]);
    }

    // Supprime un utilisateur par son ID (sans retour)
    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Vérifie qu'un mot de passe donné correspond bien au hash stocké pour un utilisateur donné
    public function verifyPassword(int $id, string $password): bool
    {
        $stmt = $this->db->prepare("SELECT password FROM user WHERE id = ?");
        $stmt->execute([$id]);
        $hash = $stmt->fetchColumn(); // Récupère le hash stocké
        return $hash && password_verify($password, $hash); // Vérifie la correspondance
    }

    // Récupère tous les utilisateurs, retourne un tableau d'objets User
    public function getAllUsers(): array
    {
        $stmt = $this->db->query("SELECT * FROM user");
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($data) => new User($data), $usersData); // Création des objets User
    }

    // Supprime un utilisateur par ID, retourne true/false selon succès de la requête
    public function deleteUserById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id = ?");
        return $stmt->execute([$id]);
    }
}