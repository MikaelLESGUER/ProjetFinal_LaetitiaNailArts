<?php

class AdminController extends AbstractController
{
    private AdminManager $adminManager;
    private CategoryManager $categoryManager;
    private ContactManager $contactManager;
    private ContactFormManager $contactFormManager;
    private UserManager $userManager;
    private PrestationManager $prestationManager;

    public function __construct()
    {
        $this->adminManager = new AdminManager();
        $this->categoryManager = new CategoryManager();
        $this->contactManager = new ContactManager();
        $this->contactFormManager= new ContactFormManager();
        $this->userManager = new UserManager();
        $this->prestationManager = new PrestationManager();
    }

    public function admin() : void
    {
        $this->render("admin/admin", []);
    }

    public function adminDashboard() : void
    {
        $results = $this->contactFormManager->countMessagesByRole();
        $this->render("admin/dashboard", ['results' => $results]);
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
        $categories = $this->categoryManager->getAllCategories();
        $prestationsByCategory = [];


        foreach ($categories as $category) {
            $prestations = $this->prestationManager->getPrestationsByCategoryName($category->getSlug());

            // Appliquer htmlspecialchars_decode() à la description de chaque prestation
            foreach ($prestations as $prestation) {
                $prestation->setDescription(htmlspecialchars_decode($prestation->getDescription()));
            }

            $prestationsByCategory[$category->getName()] = $prestations;
        }

        $this->render("admin/gerer-produits", [
            "prestationsByCategory" => $prestationsByCategory,
        ]);
    }

    public function displayUpdatePrestationForm($prestationId)
    {
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
            $categoryId = $_POST['category_id'];
            $categoryId = $this->clean($categoryId);

            // Vérifiez que le champ "price" contient uniquement des caractères numériques et des points
            if (!preg_match('/^[0-9.]+$/', $price)) {
                // Le champ "price" contient des caractères non autorisés, affichez un message d'erreur
                $errorMessage = "Le champ 'Prix' doit contenir uniquement des chiffres et un point.";
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
                exit;
            }

            // Vérifiez que La durée de la prestation n'est pas négatif
            if ($duration <= 0) {
                // Le prix est inférieur ou égal à zéro, affichez un message d'erreur
                $errorMessage = ("Le prix ne peut pas être négatif ou égal a zéro.");
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
                exit;
            }

            // Appelez la fonction du manager pour mettre à jour le produit
            $success = $this->prestationManager->updatePrestation($prestationId, $name, $slug, $description,$duration, $price, $categoryId);
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
            $categoryId = $this->clean($categoryId);

            // Vérifiez que le champ "price" contient uniquement des caractères numériques et des points
            if (!preg_match('/^[0-9.]+$/', $price)) {
                // Le champ "price" contient des caractères non autorisés, affichez un message d'erreur
                $errorMessage = "Le champ 'Prix' doit contenir uniquement des chiffres et un point.";
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-produits');
                exit;
            }

            // Vérifiez que La durée de la prestation n'est pas négatif
            if ($duration <= 0) {
                // Le prix est inférieur ou égal à zéro, affichez un message d'erreur
                $errorMessage = ("Le prix ne peut pas être négatif ou égal a zéro.");
                $_SESSION['error_message'] = $errorMessage;
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-prestations');
                exit;
            }

            // Appelez la fonction du manager pour créer le produit
            $success = $this->prestationManager->createPrestation($name, $slug, $description, $duration, $price, $categoryId);
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

    /////////////////////
    ///   CATEGORIE   ///
    /////////////////////

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
    
   //////////////////////
    ///   formulaire   ///
    //////////////////////

    public function displayAllContactForms() : void
    {
        // Créez une instance du gestionnaire de formulaires de contact
        $contactForms = $this->contactFormManager->getAllContactForms();

        // Chargez la vue pour afficher les formulaires
        $this->render('admin/list-formulaire', ['contactForms' => $contactForms]);
    }

    public function displayContactFormDetails($messageId) :void
    {
        // Créez une instance du gestionnaire de formulaires de contact
        $contactFormManager = new ContactFormManager();

        // Appelez la fonction du gestionnaire pour marquer le formulaire comme "lu"
        $contactFormManager->markContactFormAsRead($messageId);

        // Appelez la fonction pour obtenir les détails du formulaire de contact
        $contactForm = $this->contactFormManager->getContactFormById($messageId);

        // Chargez la vue pour afficher les détails du formulaire de contact
        $this->render('admin/view-form', ['contactForm' => $contactForm]);
    }

    public function deleteContactForm() : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez l'ID de la catégorie à supprimer
            $messageId = $_POST['contactForm_id'];

            // Appelez la fonction du gestionnaire pour supprimer la catégorie
            $success = $this->contactFormManager->deleteContactForm($messageId);

            if ($success) {
                $_SESSION['success_message'] = "Le formulaire a été supprimé avec succès.";
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de la suppression du formulaire.";
            }

            if ($success) {
                // Redirigez l'utilisateur vers la page de gestion des catégories avec un message de succès
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-formulaire');
            } else {
                // Redirigez l'utilisateur vers la page de gestion des catégories avec un message d'erreur
                header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-formulaire');
            }
            exit;
        }
    }

    ///////////////////
    ///   contact   ///
    ///////////////////

    public function showManageContact() :void
    {
        $contactInfo = $this->contactManager->getContactInfo(); // Appelez la fonction du gestionnaire pour récupérer les informations de contact
        $this->render('admin/manage-contact', ['contactInfo' => $contactInfo]);
    }

    public function updateAddress() :void
    {
        // Récupérez les données soumises depuis le formulaire
        $adresse = $_POST['adresse'];
        $adresse = $this->clean($adresse);
        $codePostal = $_POST['code_postal'];
        $codePostal = $this->clean($codePostal);
        $ville = $_POST['ville'];
        $ville = $this->clean($ville);

        // Appelez la fonction du gestionnaire pour mettre à jour l'adresse
        $this->contactManager->updateAddress($adresse, $codePostal, $ville);

        // Redirigez l'utilisateur vers la page de contact après la mise à jour
        $sucessMessage = ("L'adresse' a était mise a jour avec succès.");
        $_SESSION['sucess_message'] = $sucessMessage;
        header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-contact');
    }

    public function updateUrlGeo() :void
    {
        // Récupérez l'URL Google Maps soumise depuis le formulaire
        $urlGeo = $_POST['url_geo'];
        $urlGeo = $this->clean($urlGeo);

        // Appelez la fonction du gestionnaire pour mettre à jour l'URL Google Maps
        $this->contactManager->updateUrlGeo($urlGeo);

        // Redirigez l'utilisateur vers la page de contact après la mise à jour
        $sucessMessage = ("L'url de géolocalisation a était mise a jour avec succès.");
        $_SESSION['sucess_message'] = $sucessMessage;
        header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-contact');
    }

    public function updatePhoneNumbers() :void
    {
        // Récupérez les numéros de téléphone soumis depuis le formulaire
        $numeroFixe = $_POST['numero_fixe'];
        $numeroFixe = $this->clean($numeroFixe);
        $numeroPortable = $_POST['numero_portable'];
        $numeroPortable = $this->clean($numeroPortable);

        // Appelez la fonction du gestionnaire pour mettre à jour les numéros de téléphone
        $this->contactManager->updatePhoneNumbers($numeroFixe, $numeroPortable);

        // Redirigez l'utilisateur vers la page de contact après la mise à jour
        $sucessMessage = ("Les numéros de téléphone ont était mise a jour avec succès.");
        $_SESSION['sucess_message'] = $sucessMessage;
        header('Location: /ProjetFinal_LaetitiaNailArts/admin/gerer-contact');
    }
}