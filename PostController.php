<?php
require_once 'Post.php';

class PostController
{
    private PDO $db;

    public function __construct()
    {
        $host = "localhost";
        $dbName = "anime";
        $port = 3306;
        $userName = "root";
        $password = "";

        try {
            $this->setDb(new PDO(
                "mysql:host=$host;dbname=$dbName;port=$port;charset=utf8mb4",
                $userName,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Gestion des erreurs en exception
            ));
        } catch (PDOException $error) {
            // Idéalement logger l'erreur plutôt que echo
            echo "Erreur de connexion à la base de données : " . $error->getMessage();
            exit; // arrêter l'exécution si DB inaccessible
        }
    }

    public function setDb(PDO $db): self
    {
        $this->db = $db;
        return $this;
    }

    // Création d'un post
    public function createPost(string $title, string $content, int $authorId): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO post (title, content, authorId) VALUES (?, ?, ?)");
            return $stmt->execute([$title, $content, $authorId]);
        } catch (PDOException $e) {
            // Logger erreur
            echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false;
        }
    }

    // Récupérer un post via son ID
    public function getPost(int $id): ?Post
    {
        $stmt = $this->db->prepare("SELECT * FROM post WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Post($data) : null;
    }

    // Récupérer tous les posts d'un utilisateur
    public function getPostsByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM post WHERE authorId = ?");
        $stmt->execute([$userId]);
        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $posts = [];
        foreach ($datas as $data) {
            $posts[] = new Post($data);
        }
        return $posts;
    }

    // Récupérer posts paginés
    public function getPostsByPage(int $offset, int $limit): array
    {
        $stmt = $this->db->prepare("SELECT * FROM post LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $posts = [];
        foreach ($datas as $data) {
            $posts[] = new Post($data);
        }
        return $posts;
    }

    // Modifier un post (admin ou auteur)
    public function updatePost(int $postId, string $title, string $content, int $userId, string $role): bool
    {
        if ($role === 'admin') {
            $stmt = $this->db->prepare("UPDATE post SET title = ?, content = ? WHERE id = ?");
            return $stmt->execute([$title, $content, $postId]);
        }

        $stmt = $this->db->prepare("UPDATE post SET title = ?, content = ? WHERE id = ? AND authorId = ?");
        return $stmt->execute([$title, $content, $postId, $userId]);
    }

    // Supprimer un post (admin ou auteur)
    public function deletePost(int $postId, int $userId, string $role): bool
    {
        $post = $this->getPost($postId);
        if (!$post) return false;

        if ($post->getAuthorId() !== $userId && $role !== 'admin') {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM post WHERE id = ?");
        return $stmt->execute([$postId]);
    }
}
