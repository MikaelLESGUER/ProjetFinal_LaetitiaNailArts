<?php

class AdminController extends AbstractController
{
    private AdminManager $adminManager;
    private CategoryManager $categoryManager;
    private UserManager $userManager;
    private PrestationManager $prestationManager;

    public function __construct()
    {
        $this->adminManager = new AdminManager();
        $this->categoryManager = new CategoryManager();
        $this->userManager = new UserManager();
        $this->prestationManager = new PrestationManager();
    }

    public function admin() : void
    {
        $this->render("admin/admin", []);
    }

    public function adminDashboard() : void
    {
        $this->render("admin/dashboard", []);
    }

    ////////////////////
    ///    ADMINS    ///
    ////////////////////

    public function gererAdmin() :void
    {
        $admins = $this->adminManager->getAllAdmins();

        $this->render("admin/gerer-admin", [
            "admins" => $admins
        ]);
    }

    public function createAdmin() : void
    {

        if (isset($_POST["formName"]) && $_POST["formName"] === "adminRegisterForm") {
            $username = $_POST["new_username"];
            $password = $_POST["new_password"];
            $role_id = 1;


            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $newAdmin = new Admin(null,$role_id,$username,$hashedPassword);
            var_dump ('je suis ici',$newAdmin);

            $createdAdmin =$this->adminManager->createAdmin($newAdmin, $role_id);

            var_dump($createdAdmin);

            header('location: /ProjetFinal_LaetitiaNailArts/admin/gerer-admin');
        }
    }

    public function displayUpdateAdminForm($adminId)
    {
        // Utilisez le gestionnaire de produits pour obtenir les détails du produit
        $admin = $this->adminManager->getAdminById($adminId);

        // Affichez les détails du produit dans le formulaire de mise à jour
        $this->render('admin/update-admin', ['admin' => $admin]);
    }

    // Modifier un administrateur
    public function adminModifyForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminId = $_POST['adminId'];
            $newUsername = $_POST['newUsername'];
            $newPassword = $_POST['newPassword'];

            // Hasher le nouveau mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Appelez la fonction modifyAdmin avec les nouvelles valeurs
            $this->adminManager->modifyAdmin($adminId, $newUsername, $hashedPassword);
        }

        // Récupérez la liste de tous les administrateurs
        $admins = $this->adminManager->getAllAdmins();

        // Chargez la vue avec le formulaire et la liste des administrateurs
        $this->render('admin/gerer-admin', ['admins' => $admins]);
    }

    // Supprimer un administrateur
    public function deleteAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminId = $_POST['admin_id'];
            var_dump($adminId);

            // Appelez la fonction du manager pour supprimer le produit par son ID
            $success = $this->adminManager->deleteAdmin($adminId);

            if ($success) {
                // Redirigez l'utilisateur vers la page de gestion des produits avec un message de succès
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-admin?delete-success=1');
            } else {
                // Redirigez l'utilisateur vers la page de gestion des produits avec un message d'erreur
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-admin?delete-error=1');
            }
            exit;
        }
    }

    ////////////////////
    /// UTILISATEURS ///
    ////////////////////
    public function gererUser() :void
    {
        $users = $this->userManager->getAllUsers();

        $this->render("admin/gerer-utilisateurs", [
            "users" => $users
        ]);
    }

    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            var_dump($userId);

            // Appelez la fonction du manager pour supprimer le produit par son ID
            $success = $this->userManager->deleteUser($userId);
            var_dump($success);
//            die();

            if ($success) {
                // Rediriger vers une page de confirmation ou une autre page appropriée
                $_SESSION['success_message'] = "L'utilisateur a été supprimé avec succès.";
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-utilisateurs');
            } else {
                // Message d'erreur en cas d'échec de la suppression
                $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
            }
        } else {
            // Gérer le cas où l'administrateur n'est pas trouvé
            $_SESSION['error_message'] = "L'utilisateur n'a pas été trouvé.";
            header('Location: /ProjetFinal_LaetitiaNailArts/admin/admin-not-found');
        }
    }

    ////////////////////
    ///   PRODUITS   ///
    ////////////////////

    public function listPrestation() : void
    {
        $prestations = $this->prestationManager->getAllPrestationsAndCategories(); // Utilisation du ProductManager
        $categories = $this->categoryManager->getAllCategories();
//        var_dump($products, $categories);
//        die();

        $this->render("admin/gerer-produits", [
            "prestations" => $prestations,
            'categories' => $categories
        ]);
    }

    public function displayUpdatePrestationForm($prestationId)
    {
        // Récupérer l'ID du produit à partir de la requête GET
//        $productId = $_GET['id'];
//        var_dump($_GET['id']);
//die();
        // Utilisez le gestionnaire de produits pour obtenir les détails du produit
        $prestation = $this->prestationManager->getPrestationById($prestationId);
        $categories = $this->categoryManager->getAllCategories();
        $categoryIds = $this->prestationManager->getCategoryIds($prestationId);
        // Affichez les détails du produit dans le formulaire de mise à jour
        $this->render('admin/update-product', ['prestation' => $prestation, 'categories' => $categories, 'categoryIds' => $categoryIds]);
    }

    public function updatePrestation() :void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump('je fonctionne');
//            die();
            // Récupérez les données du formulaire
            $prestationId = $_POST['prestation_id'];
            $name = $_POST['prestation-name'];
            $name = $this->clean($name);
            $rawSlug = $_POST['prestation-slug'];
            $rawSlug = $this->clean($rawSlug);
            $slug = $this->createSlug($rawSlug);
            $description = $_POST['prestation-description'];
            $price = $_POST['prestation-price'];
            $price = $this->clean($price);
            $duration = $_POST['prestation-duration'];
            $duration = $this->clean($duration);
//            var_dump($name, $price);
//            die();
            $categoryId = $_POST['category_id'];
            // Assurez-vous que la variable $categoryId est récupérée du formulaire et convertie en entier
//            $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
//            $categoryIds = isset($_POST['category_ids']) ? $_POST['category_ids'] : [];
//            var_dump($categoryIds);
//            die();
            // Validez les données du formulaire (assurez-vous qu'elles sont correctes)
            // Vérifiez si au moins une catégorie est sélectionnée
            if (empty($categoryId)) {
                // Aucune catégorie sélectionnée, affichez un message d'erreur
                $errorMessage = "Veuillez sélectionner une seule catégorie.";
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
                exit;
            }

            // Vérifiez que le champ "price" contient uniquement des caractères numériques et des points
            if (!preg_match('/^[0-9.]+$/', $price)) {
                // Le champ "price" contient des caractères non autorisés, affichez un message d'erreur
                $errorMessage = "Le champ 'Prix' doit contenir uniquement des chiffres et un point.";
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
                exit;
            }

            // Vérifiez que le prix n'est pas négatif
            if ($price <= 0) {
                // Le prix est inférieur ou égal à zéro, affichez un message d'erreur
                $errorMessage = ("Le prix ne peut pas être négatif ou égal a zéro.");
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
                exit;
            }

            // Vérifiez que le prix n'est pas négatif
            if ($duration <= 0) {
                // Le prix est inférieur ou égal à zéro, affichez un message d'erreur
                $errorMessage = ("Le prix ne peut pas être négatif ou égal a zéro.");
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
                exit;
            }

            // Appelez la fonction du manager pour mettre à jour le produit
            $success = $this->prestationManager->updatePrestation($prestationId, $name, $slug, $description,$duration, $price, $categoryId);
            var_dump($success);
//            die();
            if ($success) {
                $_SESSION['success_message'] = "Le produit a été mis à jour avec succès.";
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de la mise à jour du produit.";
            }
            if ($success) {
                // Redirigez l'utilisateur vers la page de gestion des produits ou affichez un message de succès
                echo ('je suis passé');
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
            } else {
                // Affichez un message d'erreur en cas d'échec de la mise à jour
                echo ('je suis pas passé');
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
            }
            exit;
        }
    }

    public function createProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire
            $name = $_POST['product-name'];
            $name = $this->clean($name);
            $rawSlug = $_POST['product-slug'];
            $rawSlug = $this->clean($rawSlug);
            $slug = $this->createSlug($rawSlug);
            $description = $_POST['product-description'];
            $price = $_POST['product-price'];
            $price = $this->clean($price);
            $duration = $_POST['product-duration'];
            $duration = $this->clean($duration);
            $categoryId = $_POST['category_id'];
            var_dump($name,$slug,$description,$duration,$price,$categoryId);
//            die();
//            $categoryIds = isset($_POST['category-ids']) ? $_POST['category-ids'] : [];

            // Vérifiez si au moins une catégorie est sélectionnée
            if (empty($categoryId)) {
                // Aucune catégorie sélectionnée, affichez un message d'erreur
                $errorMessage = "Veuillez sélectionner au moins une catégorie.";
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits');
                exit;
            }

            // Vérifiez que le champ "price" contient uniquement des caractères numériques et des points
            if (!preg_match('/^[0-9.]+$/', $price)) {
                // Le champ "price" contient des caractères non autorisés, affichez un message d'erreur
                $errorMessage = "Le champ 'Prix' doit contenir uniquement des chiffres et un point.";
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits');
                exit;
            }

            // Vérifiez que le prix n'est pas négatif
            if ($price <= 0) {
                // Le prix est inférieur ou égal à zéro, affichez un message d'erreur
                $errorMessage = ("Le prix ne peut pas être négatif ou égal a zéro.");
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits');
                exit;
            }
            var_dump($price);
            var_dump($price<0);
//            die();
            // Vérifiez si le nom de produit est unique en appelant la fonction du manager
//            if (!$this->productManager->isProductNameUnique(strtolower($name))) {
//                // Le nom de produit n'est pas unique, affichez un message d'erreur
//                $errorMessage = urlencode("Le nom de produit '$name' existe déjà. Veuillez choisir un nom unique.");
//                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits?error=' . $errorMessage);
//                exit;
//            }

            // Appelez la fonction du manager pour créer le produit
            $success = $this->prestationManager->createPrestation($name, $slug, $description, $duration, $price, $categoryId);
            var_dump($success);
//            die();
            if ($success) {
                $_SESSION['success_message'] = "Le produit a été créé avec succès.";
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de la création du produit.";
            }

            if ($success) {
                // Redirigez l'utilisateur vers la page de gestion des produits ou affichez un message de succès
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
            } else {
                // Affichez un message d'erreur en cas d'échec de la création
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
            }
            exit;

        }
    }
//
//    public function createProduct()
//    {
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            // Récupérez les données du formulaire
//            $name = $_POST['product-name'];
//            // Vérifiez si le nom de produit est unique en appelant la fonction du manager
////           if (!$this->productManager->isProductNameUnique(strtolower($name))) {
//                // Utilisez header pour rediriger avec un message d'erreur dans l'URL
////              $errorMessage = urlencode("Le nom de produit '$name' existe déjà. Veuillez choisir un nom unique.");
////              var_dump("Product name '$name' already exists");
////                die();
////              header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits?error=' . $errorMessage);
////               exit;
////           }
////            $slug = $_POST['product-slug'];
//            $rawSlug = $_POST['product-slug'];
//            var_dump($rawSlug);
//            $rawSlug = $this->clean($rawSlug);
//            var_dump($rawSlug);
////            die();
//            $slug = $this->createSlug($rawSlug);
//            var_dump($slug);
////            die();
////            if (!empty($slug)) {
////                // Le slug est valide, vous pouvez l'utiliser pour créer le produit
////            } else {
////                // Le slug est invalide, affichez un message d'erreur à l'utilisateur
////                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits?create-error=1&slug-error=1');
////                exit;
////            }
//            $description = $_POST['product-description'];
//            $price = $_POST['product-price'];
//            $categoryIds = isset($_POST['category-ids']) ? $_POST['category-ids'] : [];
//
//            // Appelez la fonction du manager pour créer le produit
//            $success = $this->productManager->createProduct($name, $slug, $description, $price, $categoryIds);
//
//            if ($success) {
//                // Redirigez l'utilisateur vers la page de gestion des produits ou affichez un message de succès
//                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits?create-success=1');
//            } else {
//                // Affichez un message d'erreur en cas d'échec de la création
//                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits?create-error=1');
//            }
//            exit;
//        }
//    }

    public function deletePrestation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prestationId = $_POST['product_id'];

            // Appelez la fonction du manager pour supprimer le produit par son ID
            $success = $this->prestationManager->deletePrestation($prestationId);

            if ($success) {
                $_SESSION['success_message'] = "Le produit a été supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de la suppression du produit.";
            }

            if ($success) {
                // Redirigez l'utilisateur vers la page de gestion des produits avec un message de succès
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations?delete-success=1');
            } else {
                // Redirigez l'utilisateur vers la page de gestion des produits avec un message d'erreur
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations?delete-error=1');
            }
            exit;
        }
    }

    public function listCategories()
    {
        // Récupérez toutes les catégories depuis le gestionnaire de catégories
        $categories = $this->categoryManager->getAllCategories();

        // Affichez la vue pour afficher les catégories
        $this->render('admin/list-categories', ['categories' => $categories]);
    }

    public function editCategory(int $categoryId)
    {
        var_dump('je fonctionne');
        // Récupérez les détails de la catégorie depuis le gestionnaire de catégories
        $category = $this->categoryManager->getCategoryById($categoryId);

        // Affichez la vue pour modifier la catégorie
        $this->render('admin/edit-category', ['category' => $category]);
    }

    public function updateCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = $_POST['category_id'];
            $name = $_POST['category-name'];
            $slug = $_POST['category-slug']; // Récupérez le champ "slug"
            $description = $_POST['category-description'];

            // Appelez la fonction du gestionnaire pour mettre à jour la catégorie
            if ($this->categoryManager->updateCategory($categoryId, $name, $slug, $description)) {
                // Redirigez l'utilisateur vers la page de liste des catégories ou affichez un message de succès
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/list-categories?update-success=1');
                exit;
            } else {
                // Affichez un message d'erreur en cas d'échec de la mise à jour
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/list-categories?update-error=1');
                exit;
            }
        }
    }

    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire
            $name = $_POST['category-name'];
            $slug = $_POST['category-slug'];
            $description = $_POST['category-description'];

            // Appelez la fonction du manager pour créer une nouvelle catégorie
            $success = $this->categoryManager->createCategory($name, $slug, $description);

            if ($success) {
                // Redirigez l'utilisateur vers la page de gestion des catégories avec un message de succès
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/list-categories?create-success=1');
            } else {
                // Redirigez l'utilisateur vers la page de gestion des catégories avec un message d'erreur
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/list-categories?create-error=1');
            }
            exit;
        }
    }

    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez l'ID de la catégorie à supprimer
            $categoryId = $_POST['category_id'];

            // Appelez la fonction du gestionnaire pour supprimer la catégorie
            $success = $this->categoryManager->deleteCategoryAndAssociatedPrestations($categoryId);
            var_dump($success);
//            die();

            if ($success) {
                // Redirigez l'utilisateur vers la page de gestion des catégories avec un message de succès
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/list-categories?delete-success=1');
            } else {
                // Redirigez l'utilisateur vers la page de gestion des catégories avec un message d'erreur
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/list-categories?delete-error=1');
            }
            exit;
        }
    }

}