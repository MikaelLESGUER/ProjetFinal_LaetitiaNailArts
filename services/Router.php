<?php  
 
class Router {
    private AdminController $adminController;
    private AuthController $authController;
    private ContactController $contactController;
    private ContactFormController $contactFormController;
    private HomeController $homeController;
    private PortfolioController $portfolioController;
    private PrestationsController $prestationsController;
    private UserController $userController;
    
    public function __construct()
    {
        $this->adminController = new AdminController();
        $this->authController = new AuthController();
        $this->contactController = new ContactController();
        $this->contactFormController = new ContactFormController();
        $this->homeController = new HomeController;
        $this->portfolioController = new PortfolioController;
        $this->prestationsController = new PrestationsController();
        $this->userController = new UserController();
    }
    
    private function splitRouteAndParameters(string $route) : array
    {
        $routeAndParams = [];
        $routeAndParams["route"] = null;
        $routeAndParams["prestationSlug"] = null;
        $routeAndParams["id"] = null;

        if(strlen($route) > 0) // si la chaine de la route n'est pas vide (donc si ça n'est pas la home)
        {
            $tab = explode("/", $route);

            if($tab[0] === "prestations") // écrire une condition pour le cas où la route commence par "produits"
            {
                // mettre les bonnes valeurs dans le tableau
                $routeAndParams["route"] = "prestations";

                if(isset($tab[1]))
                {
                    $routeAndParams["prestationSlug"] = $tab[1];
                }
            }
            else if($tab[0] === "portfolio")
            {
                $routeAndParams["route"] = "portfolio";

                if(isset($tab[1]))
                {
                    $routeAndParams["id"] = $tab[1];
                }
            }
            else if($tab[0] === "demander-devis" && isset($_GET["id"]) && is_numeric($_GET["id"]))
            {
                $routeAndParams["route"] = "demander-devis";
                $routeAndParams["prestationId"] = intval($_GET["id"]);
            }
            else if($tab[0] === "check-demander-devis")
            {
                $routeAndParams["route"] = "check-demander-devis";
            }
            else if($tab[0] === "formulaire-de-renseignement")
            {
                $routeAndParams["route"] = "formulaire-de-renseignement";
            }
            else if($tab[0] === "check-formulaire-de-renseignement")
            {
                $routeAndParams["route"] = "check-formulaire-de-renseignement";
            }
            else if($tab[0] === "creer-un-compte")
            {
                $routeAndParams["route"] = "creer-un-compte";
            }
            else if($tab[0] === "check-creer-un-compte")
            {
                $routeAndParams["route"] = "check-creer-un-compte";
            }
            else if($tab[0] === "connexion")
            {
                $routeAndParams["route"] = "connexion";
            }
            else if($tab[0] === "check-connexion")
            {
                $routeAndParams["route"] = "check-connexion";
            }
            else if($tab[0] === "mon-compte")
            {
                $routeAndParams["route"] = "mon-compte";
            }
            else if($tab[0] === "modifier-nom-prenom")
            {
                $routeAndParams["route"] = "modifier-nom-prenom";
            }
            else if($tab[0] === "modifier-email")
            {
                $routeAndParams["route"] = "modifier-email";
            }
            else if($tab[0] === "modifier-username")
            {
                $routeAndParams["route"] = "modifier-username";
            }
            else if($tab[0] === "modifier-password")
            {
                $routeAndParams["route"] = "modifier-password";
            }
            else if($tab[0] === "conditions-generales")
            {
                $routeAndParams["route"] = "conditions-generales";
            }
            else if($tab[0] === "contact")
            {
                $routeAndParams["route"] = "contact";
            }
            else if($tab[0] === "deconnexion")
            {
                $routeAndParams["route"] = "deconnexion";
            }
            else if ($tab[0] === "check-admin-connexion")
            {
                $routeAndParams["route"] = "check-admin-connexion";
            }
            else if ($tab[0] === "admin") {
                $routeAndParams["route"] = "admin";
                if (isset($_SESSION["admin"]) && $_SESSION["role"] === "admin") {
                    if ($tab[1] === "dashboard" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/dashboard";
                    }
                    if ($tab[1] === "gerer-admin" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/gerer-admin";
                    }
                    if ($tab[1] === "create-admin" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/create-admin";
                    }
                    if ($tab[1] === "update-admin" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
                        $routeAndParams["route"] = "admin/update-admin";
                        $routeAndParams["adminId"] = intval($_GET["id"]); // Convertissez l'ID en entier
                    }
                    if ($tab[1] === "modify-admin" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/modify-admin";
                    }
                    if ($tab[1] === "delete-admin" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/delete-admin";
                    }
                    if ($tab[1] === "gerer-utilisateurs" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/gerer-utilisateurs";
                    }
                    if ($tab[1] === "delete-user" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/delete-user";
                    }
                    if ($tab[1] === "gerer-prestations" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/gerer-prestations";
                    }
                    if ($tab[1] === "update-prestation" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
                        $routeAndParams["route"] = "admin/update-prestation";
                        $routeAndParams["prestationId"] = intval($_GET["id"]); // Convertissez l'ID en entier
                    }
                    if ($tab[1] === "check-update-prestation" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/check-update-prestation";
                    }
                    if ($tab[1] === "check-create-prestation" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/check-create-prestation";
                    }
                    if ($tab[1] === "delete-product" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/delete-product";
                    }
                    if ($tab[1] === "list-categories" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/list-categories";
                    }
                    if ($tab[1] === "edit-category" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
                        $routeAndParams["route"] = "admin/edit-category";
                        $routeAndParams["categoryId"] = intval($_GET["id"]); // Convertissez l'ID en entier
                    }
                    if ($tab[1] === "update-category" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/update-category";
                    }
                    if ($tab[1] === "create-category" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/create-category";
                    }
                    if ($tab[1] === "delete-category" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/delete-category";
                    }
                    if ($tab[1] === "gerer-formulaire" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/gerer-formulaire";
                    }
                    if ($tab[1] === "formulaire-detail" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
                        $routeAndParams["route"] = "admin/formulaire-detail";
                        $routeAndParams["messageId"] = intval($_GET["id"]); // Convertissez l'ID en entier
                    }
                    if ($tab[1] === "delete-contact-form" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/delete-contact-form";
                    }
                    if ($tab[1] === "gerer-contact" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/gerer-contact";
                    }
                    if ($tab[1] === "update-address" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/update-address";
                    }
                    if ($tab[1] === "update-url-geo" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/update-url-geo";
                    }
                    if ($tab[1] === "update-phone-numbers" && !isset($tab[2])) {
                        $routeAndParams["route"] = "admin/update-phone-numbers";
                    }
                }
            }
        }
        else
        {
            $routeAndParams["route"] = "";
        }

        return $routeAndParams;
    }
    
    public function checkRoute(string $route) : void
    {
        $routeTab = $this->splitRouteAndParameters($route);
//        var_dump($routeTab);

        if ($routeTab["route"] === "") {
            // Appeler la méthode du contrôleur pour afficher la page d'accueil
            $this->homeController ->index();
        }
        else if ($routeTab["route"] === "portfolio"&& $routeTab["id"] === null)  // Si la route est "/portfolio"
        {
            $this->portfolioController->showPortfolio();  // Appel de la méthode correspondante dans le PortfolioController
        }
        else if ($routeTab["route"] === "portfolio" && !empty($routeTab["id"])) // ($routeTab["route"] === "produits" && $routeTab["productSlug"] !== null)
        {
            $this->portfolioController->showPortfolioItemDetails($itemId);
        }
        else if ($routeTab["route"] === "prestations" && $routeTab["prestationSlug"] === null)
        {
            $this->prestationsController->prestationsByCategory();
        }
        else if ($routeTab["route"] === "prestations" && !empty($routeTab["prestationSlug"])) // ($routeTab["route"] === "produits" && $routeTab["productSlug"] !== null)
        {
            // Appeler la méthode du contrôleur pour afficher le détail d'un produit
            $this->prestationsController->prestationDetails($routeTab["prestationSlug"]);
        }
        else if ($routeTab["route"] === "demander-devis" && isset($routeTab["prestationId"]))
        {
            $this->contactFormController->displayQuoteForm($routeTab["prestationId"]);
        }
        else if ($routeTab["route"] === "check-demander-devis")
        {
            $this->contactFormController->submitQuoteForm();
        }
        else if ($routeTab["route"] === "formulaire-de-renseignement")
        {
            $this->contactFormController->displayRenseignementsForm();
        }
        else if ($routeTab["route"] === "check-formulaire-de-renseignement")
        {
            $this->contactFormController->submitRenseignementForm();
        }
        else if ($routeTab["route"] === "creer-un-compte") // condition pour afficher la page du formulaire d'inscription
        {
            $this->authController->register();
        }
        else if ($routeTab["route"] === "check-creer-un-compte") // condition pour l'action du formulaire d'inscription
        {
            $this->authController->checkRegister();
        }
        else if ($routeTab["route"] === "connexion") // condition pour afficher la page du formulaire de connexion
        {
            $this->authController->login();
        }
        else if ($routeTab["route"] === "check-connexion") // condition pour l'action du formulaire de connexion
        {
            $this->authController->checkLogin();
        }
        else if ($routeTab["route"] === "mon-compte")
        {
            $this->userController->account();
        }
        else if ($routeTab["route"] === "modifier-nom-prenom")
        {
            $this->userController->updateNameAndLastName();
        }
        else if ($routeTab["route"] === "modifier-email")
        {
            $this->userController->modifyEmail();
        }
        else if ($routeTab["route"] === "modifier-username")
        {
            $this->userController->modifyUsername();
        }
        else if ($routeTab["route"] === "modifier-password")
        {
            $this->userController->modifyPassword();
        }
        else if ($routeTab["route"] === "conditions-generales")
        {
            $this->homeController->conditionGeneral();
        }
        else if ($routeTab["route"] === "contact")
        {
            $this->contactController->showContactPage();
        }
        else if ($routeTab["route"] === "deconnexion")
        {
            $this->authController->logout();
        }
        else if ($routeTab["route"] === "admin")
        {
            $this->adminController->admin();
        }
        else if ($routeTab["route"] === "check-admin-connexion")
        {
            $this->authController->adminCkeckLogin();
        }
        else if(isset($_SESSION["admin"]) && $_SESSION["role"] === "admin")
        {
            if ($routeTab["route"] === 'admin/dashboard')
            {
                $this->adminController->adminDashboard();
            }
            elseif ($routeTab["route"] === "admin/gerer-admin")
            {
                $this->adminController->gererAdmin();
            }
            elseif ($routeTab["route"] === "admin/create-admin")
            {
                $this->adminController->createAdmin();
            }
            else if ($routeTab["route"] === "admin/update-admin" && isset($routeTab["adminId"]))
            {
                $this->adminController->displayUpdateAdminForm($routeTab["adminId"]);
            }
            elseif ($routeTab["route"] === "admin/modify-admin")
            {
                $this->adminController->adminModifyForm();
            }
            elseif ($routeTab["route"] === "admin/delete-admin")
            {
                $this->adminController->deleteAdmin();
            }
            elseif ($routeTab["route"] === "admin/gerer-utilisateurs")
            {
                $this->adminController->gererUser();
            }
            elseif ($routeTab["route"] === "admin/delete-user")
            {
                $this->adminController->deleteUser();
            }
            elseif ($routeTab["route"] === "admin/gerer-prestations")
            {
                $this->adminController->listPrestation();
            }
            else if ($routeTab["route"] === "admin/update-prestation" && isset($routeTab["prestationId"]))
            {
                $this->adminController->displayUpdatePrestationForm($routeTab["prestationId"]);
            }
            elseif ($routeTab["route"] === "admin/check-update-prestation")
            {
                $this->adminController->updatePrestation();
            }
            elseif ($routeTab["route"] === "admin/check-create-prestation")
            {
                $this->adminController->createProduct();
            }
            elseif ($routeTab["route"] === "admin/delete-product")
            {
                $this->adminController->deletePrestation();
            }
            elseif ($routeTab["route"] === "admin/list-categories")
            {
                $this->adminController->listCategories();
            }
            else if ($routeTab["route"] === "admin/edit-category" && isset($routeTab["categoryId"]))
            {
                $this->adminController->editCategory($routeTab["categoryId"]);
            }
            elseif ($routeTab["route"] === "admin/update-category")
            {
                $this->adminController->updateCategory();
            }
            elseif ($routeTab["route"] === "admin/create-category")
            {
                $this->adminController->createCategory();
            }
            elseif ($routeTab["route"] === "admin/delete-category")
            {
                $this->adminController->deleteCategory();
            }
            elseif ($routeTab["route"] === "admin/gerer-formulaire")
            {
                $this->adminController->displayAllContactForms();
            }
            else if ($routeTab["route"] === "admin/formulaire-detail" && isset($routeTab["messageId"]))
            {
                // Appeler la méthode du contrôleur pour afficher le détail du produit par son ID
                $this->adminController->displayContactFormDetails($routeTab["messageId"]);
            }
            elseif ($routeTab["route"] === "admin/delete-contact-form")
            {
                $this->adminController->deleteContactForm();
            }
            elseif ($routeTab["route"] === "admin/gerer-contact")
            {
                $this->adminController->showManageContact();
            }
            elseif ($routeTab["route"] === "admin/update-address")
            {
                $this->adminController->updateAddress();
            }
            elseif ($routeTab["route"] === "admin/update-url-geo")
            {
                $this->adminController->updateUrlGeo();
            }
            elseif ($routeTab["route"] === "admin/update-phone-numbers")
            {
                $this->adminController->updatePhoneNumbers();
            }
        }
    }
//        elseif ($routeTab["route"] === "portfolio/:id")  // Si la route est "/portfolio/:id"
//        {
//            var_dump($itemId);
//            die;
//            // Obtenez l'ID à partir des paramètres et appelez la méthode correspondante
//            $itemId = (int) $routeTab["params"]["id"];
//            $this->portfolioController->showPortfolioItemDetails($itemId);
//        }
//    }
}