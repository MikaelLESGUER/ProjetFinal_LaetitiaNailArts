<?php  
 
class CategoryManager extends AbstractManager 
{
    public function getAllCategories() : array
    {
        $categories = [];

        $query = "SELECT * FROM categories_prestations";
        $stmt = $this->db->prepare($query);
        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            var_dump($row);
//            die();
            $category = new Category(null, "", "", "");
            $category->setId($row['category_id']);
            $category->setSlug($row['slug']);
            $category->setName($row['name']);
            $category->setDescription($row['description']);
            $categories[] = $category;
        }

        return $categories;
    }

    public function getCategoryByName(string $categoryName) : ?Category
    {
        $query = "SELECT * FROM categories_prestations WHERE slug = :name";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $categoryName, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//        var_dump($row);
        if (!$row) {
            return null;
        }

        $category = new Category(null, "", "","");
        $category->setId($row['category_id']);
        $category->setSlug($row['slug']);
        $category->setName($row['name']);
        $category->setDescription($row['description']);

        return $category;
    }
//    public function getCategoryByName(string $categoryName) : ?Category
//    {
//        $query = "SELECT * FROM categoriesprestations WHERE slug = :slug";
//        $stmt = $this->db->prepare($query);
//        $stmt->bindValue(':slug', $categoryName, PDO::PARAM_STR);
//        $stmt->execute();
//
//        $row = $stmt->fetch(PDO::FETCH_ASSOC);
////        var_dump($row);
//        if (!$row) {
//            return null;
//        }
//
//        $category = new Category(null, "", "","");
//        $category->setId($row['category_id']);
//        $category->setSlug($row['slug']);
//        $category->setName($row['name']);
//        $category->setDescription($row['description']);
//
//        return $category;
//    }

    public function getCategoryNameById(int $categoryId) : string
    {
        $query = "SELECT name FROM categories_prestations WHERE category_id = :categoryId";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
//        var_dump($categoryId);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['name'])) {
            return $result['name'];
        }

        return "category non trouvé"; // Retourne une chaîne vide si la catégorie n'est pas trouvée
    }

    public function getCategoryById(int $categoryId)
    {
        // Sélectionnez la catégorie à partir de la base de données en utilisant son ID
        $query = "SELECT * FROM categories_prestations WHERE category_id = :categoryId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        // Récupérez les données de la catégorie
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Créez un objet Catégorie à partir des données récupérées
        $category = new Category(0,'','','');
        $category->setId($categoryData['category_id']);
        $category->setName($categoryData['name']);
        $category->setSlug($categoryData['slug']);
        $category->setDescription($categoryData['description']);

        return $category;
    }

    public function updateCategory(int $categoryId, string $name, string $slug, string $description): bool
    {
        // Mettez à jour les informations de la catégorie
        $query = "UPDATE categories_prestations SET name = :name, slug = :slug, description = :description WHERE category_id = :categoryId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    public function createCategory(string $name, string $slug, string $description): bool
    {
        try {
            // Préparez la requête d'insertion
            $query = "INSERT INTO categories_prestations (name, slug, description) VALUES (:name, :slug, :description)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);

            // Exécutez la requête d'insertion
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteCategoryAndAssociatedPrestations($categoryId)
    {
        try {
            // Commencez une transaction
            $this->db->beginTransaction();

            // Supprimez d'abord les prestations associées à la catégorie en utilisant une jointure
            $deletePrestationsQuery = "DELETE p FROM prestations p
                JOIN categories_prestations c ON p.name_category = c.category_id
                WHERE c.category_id = :categoryId";

            $stmt = $this->db->prepare($deletePrestationsQuery);
            $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();

            // Ensuite, supprimez la catégorie elle-même
            $deleteCategoryQuery = "DELETE FROM categories_prestations WHERE category_id = :categoryId";
            $stmt = $this->db->prepare($deleteCategoryQuery);
            $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();

            // Validez la transaction
            $this->db->commit();

            return true; // La suppression s'est effectuée avec succès
        } catch (PDOException $e) {
            // En cas d'erreur, annulez la transaction
            $this->db->rollBack();
            // Vous pouvez également journaliser l'erreur ou la gérer de manière appropriée
            return false; // La suppression a échoué
        }
    }

    public function deleteCategory(int $categoryId): bool
    {
        try {
            // Commencez une transaction
            $this->db->beginTransaction();

            // Supprimez d'abord les produits associés à la catégorie
            $query = "DELETE FROM prestations WHERE name_category = :name_category";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':name_category', $categoryId, PDO::PARAM_INT);
            $stmt->execute();

            // Ensuite, supprimez la catégorie
            $query = "DELETE FROM categories_prestations WHERE category_id = :categoryId";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
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
    //   public function getAllCategories() : array
    // {
    //     $list = [];

    //     // Pour accéder à la base de données utilisez $this->db

    //     return $list;
    // }

    // public function getCategoryBySlug() : Category
    // {
    //     $category = new Category();

    //     // Pour accéder à la base de données utilisez $this->db

    //     return $category;
    // }
}