<?php

class PrestationManager extends AbstractManager
{
    public function getAllPrestations() : array
    {
        $prestations = [];

        $query = "SELECT * FROM prestations";
        $stmt = $this->db->prepare($query);
        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            var_dump($row);
//            die();
            $prestation = new Prestation(null, 0, "","","",0,0.0);
            $prestation->setId($row['id']);
            $prestation->setCategoryId($row['name_category']);
            $prestation->setName($row['name']);
            $prestation->setSlug($row['slug']);
            $prestation->setDescription($row['description']);
            $prestation->setDuration($row['duration']);
            $prestation->setPrice($row['price']);
            $prestations[] = $prestation;
        }

        return $prestations;
    }

    public function getPrestationBySlug(string $prestationSlug) : ?Prestation
    {
        $query = "SELECT * FROM prestations WHERE slug = :slug";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':slug', $prestationSlug, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $prestation = new Prestation(null, 0, "", "", "", 0, 0.0);
        $prestation->setId($row['id']);
//        var_dump($prestation);
        // Récupérer le nom de la catégorie à partir de l'ID de catégorie dans la table de jointure
        $cm = new CategoryManager();
        $categoryId = $row['name_category'];
        $categoryName = $cm->getCategoryNameById($categoryId);
        $prestation->setCategoryName($categoryName);
//        $categoryName = $cm->getCategoryNameById($row['category_id']);
//        $prestation->setCategoryName($categoryName);

        $prestation->setName($row['name']);
        $prestation->setSlug($row['slug']);
        $prestation->setDescription($row['description']);
        $prestation->setDuration($row['duration']);
        $prestation->setPrice($row['price']);

        return $prestation;
    }

    public function getPrestationsByCategoryName(string $categoryName): array
    {
        $prestations = [];
//        var_dump($categoryName);
        $query = "SELECT p.* FROM prestations p INNER JOIN categories_prestations cp ON p.name_category = cp.category_id WHERE cp.slug = :categoryName";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prestation = new Prestation(null, 0, "","","",0,0.0);
            $prestation->setId($row['id']);
            $prestation->setCategoryId($row['name_category']);
            $prestation->setName($row['name']);
            $prestation->setSlug($row['slug']);
            $prestation->setDescription($row['description']);
            $prestation->setDuration($row['duration']);
            $prestation->setPrice($row['price']);
            $prestations[] = $prestation;
        }
//        var_dump($prestation);

        return $prestations;
    }

    public function getPrestationById($id)
    {
        $query = "SELECT * FROM prestations WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $prestation = new Prestation(
            $row['id'],
            $row['name_category'],
            $row['name'],
            $row['slug'],
            $row['description'],
            $row['duration'],
            $row['price'],
        // Autres champs du produit ici
        );

        return $prestation;
    }

    public function getAllPrestationsAndCategories(): array
    {
        $prestations = [];

        $query = "SELECT p.*, GROUP_CONCAT(c.name) AS category_names
              FROM prestations p
              LEFT JOIN categories_prestations cp ON p.name_category = cp.category_id
              LEFT JOIN categories_prestations c ON cp.category_id = c.category_id
              GROUP BY p.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prestation = new Prestation(
                $row['id'],
                $row['name_category'],
                $row['name'],
                $row['slug'],
                $row['description'],
                $row['duration'],
                $row['price'],
            );

            // Récupérez les catégories sous forme de tableau
            $categories = explode(',', $row['category_names']);
            $prestation->setCategories($categories);

            $prestations[] = $prestation;
        }

        return $prestations;
    }

    public function deletePrestation(int $id): bool
    {
        $query = "DELETE FROM prestations WHERE id = :prestation_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':prestation_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
//    function getPrestationCategories($prestationId) {
//        // Établir la connexion à la base de données
//        $dbHost = 'votre_host';
//        $dbUser = 'votre_utilisateur';
//        $dbPassword = 'votre_mot_de_passe';
//        $dbName = 'votre_base_de_données';
//
//        $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
//
//        // Vérifier la connexion
//        if ($conn->connect_error) {
//            die("La connexion à la base de données a échoué : " . $conn->connect_error);
//        }
//
//        // Préparer la requête SQL pour récupérer la catégorie de la prestation
//        $sql = "SELECT categories_prestations.name
//            FROM prestations
//            JOIN categories_prestations ON prestations.name_category = categories_prestations.category_id
//            WHERE prestations.id = ?";
//
//        // Préparer la déclaration
//        $stmt = $conn->prepare($sql);
//
//        if ($stmt === false) {
//            die("Erreur de préparation de la requête : " . $conn->error);
//        }
//
//        // Binder le paramètre
//        $stmt->bind_param("i", $prestationId);
//
//        // Exécuter la requête
//        $stmt->execute();
//
//        // Lier le résultat
//        $stmt->bind_result($categoryName);
//
//        // Récupérer la catégorie en string
//        $stmt->fetch();
//
//        // Fermer la déclaration et la connexion
//        $stmt->close();
//        $conn->close();
//
//        return $categoryName;
//    }

    // Exemple d'utilisation de la fonction
    //$prestationId = 1; // Remplacez par l'ID de la prestation souhaitée
    //$category = getPrestationCategories($prestationId);
    //echo "Catégorie de la prestation : " . $category;


    public function getCategoryIds(int $prestationId): int
    {
        $categoryId = 0;

        $query = "SELECT name_category FROM prestations WHERE id = :prestation_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':prestation_id', $prestationId, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoryId = $row['name_category'];
        }

        return $categoryId;
    }

    public function updatePrestation(int $prestationId, string $name, string $slug, string $description, int $duration, int $price, int $categoryId): bool
    {
        try {
            // Commencez une transaction, car vous effectuerez plusieurs opérations SQL
            $this->db->beginTransaction();

            // Mettez à jour les informations de base de la prestation
            $query = "UPDATE prestations SET name_category = :name_category, name = :name, slug = :slug, description = :description, duration = :duration, price = :price WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':name_category', $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':duration', $duration, PDO::PARAM_INT);
            $stmt->bindValue(':price', $price, PDO::PARAM_INT);
            $stmt->bindValue(':id', $prestationId, PDO::PARAM_INT);
            $stmt->execute();

            // Validez la transaction
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annulez la transaction
            $this->db->rollBack();
            return false;
        }
    }

    public function createPrestation(string $name, string $slug, string $description, int $duration, int $price, int $categoryId): bool
    {
        try {
            // Commencez une transaction
            $this->db->beginTransaction();

            // Insérez d'abord la nouvelle prestation
            $query = "INSERT INTO prestations (name_category, name, slug, description, duration, price) VALUES (:name_category, :name, :slug, :description, :duration, :price)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':name_category', $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':duration', $duration, PDO::PARAM_INT);
            $stmt->bindValue(':price', $price, PDO::PARAM_INT);
            $stmt->execute();

            // Validez la transaction
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annulez la transaction
            $this->db->rollBack();
            return false;
        }
    }

//    a garder pour plus tard
//    public function getCategoryIds(int $prestationId): array
//    {
//        $categoryIds = [];
//
//        $query = "SELECT name_category FROM prestations WHERE id = :prestation_id";
//        $stmt = $this->db->prepare($query);
//        $stmt->bindValue(':prestation_id', $prestationId, PDO::PARAM_INT);
//        $stmt->execute();
//
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $categoryIds[] = $row['name_category'];
//        }
//
//        return $categoryIds;
//    }

    public function getPrestationCategories($prestationId)
    {
        // Préparez la requête SQL pour récupérer les catégories associées à la prestation
        $query = "SELECT c.* FROM categories c
              INNER JOIN prestation_category pc ON c.id = pc.category_id
              WHERE pc.prestation_id = :prestation_id";

        // Préparez la requête avec PDO
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':prestation_id', $prestationId, PDO::PARAM_INT);
        $stmt->execute();

        // Récupérez les résultats sous forme de tableau d'objets Category (supposons que vous ayez une classe Category pour représenter les catégories)
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category(
                $row['id'],
                $row['name'],
                $row['slug'],
                $row['description']
            // Ajoutez d'autres propriétés de la classe Category au besoin
            );
        }

        return $categories;
    }

}