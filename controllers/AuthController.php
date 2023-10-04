<?php

class AuthController extends AbstractController {
    
    private UserManager $userManager;
    private AdminManager $adminManager;
    
    public function __construct() 
    {
        //session_start();
        $this->userManager = new UserManager(); // Assurez-vous que vous instanciez le UserManager ici
        $this->adminManager = new AdminManager();
    }
    
    // Ajoutez ici les méthodes pour gérer l'authentification

    //
    //          USER
    //
    
    /* Pour la page d'inscription */  
    public function register() : void  
    {  
        // render la page avec le formulaire d'inscription
        $this->render("guess/register", []);
    }  
      
    /* Pour vérifier l'inscription */
    public function checkRegister() : void
    {

        if (isset($_POST["formName"]) && $_POST["formName"] === "registerForm") {

        // Récupérer les champs du formulaire
        $username = $_POST["username"];
        $username = $this->clean($username);
        $prenom = null;
        $nom = null;
        $email = $_POST["email"];
        $email = $this->clean($email);
        $password = $_POST["password"];
        $password = $this->clean($password);
        $confirmPassword = $_POST["confirmPassword"];
        $confirmPassword = $this->clean($confirmPassword);
        $role_id = 2; // Remplacez par l'ID du rôle utilisateur

        // Vérifier si le mot de passe correspond à la confirmation du mot de passe
        if ($password !== $confirmPassword) {
                // Les mots de passe ne correspondent pas, affichez un message d'erreur
            $errorMessage = "Les mots de passe ne correspondent pas.";
            $_SESSION["error_message"] = $errorMessage;
            header('Location: /ProjetFinal_LaetitiaNailArts/creer-un-compte'); // Rediriger vers la page de création de compte
            exit;
        }

        // Chiffrer le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Appeler le manager pour créer l'utilisateur en base de données
        $newUser = new User(null, $username,$prenom, $nom ,$email, $hashedPassword,$role_id);
        $createdUser = $this->userManager->createUser($newUser, $role_id);

        // Ajoutez cette ligne pour déboguer
//        var_dump($createdUser);
//        die();

        // Connecter l'utilisateur
        if ($createdUser) {
            $_SESSION["user"] = $createdUser->getId();
            $_SESSION["role"] = $createdUser->getRoleId();
            $_SESSION["username"] = $createdUser->getUsername();
        }

        // Rediriger vers l'accueil
        header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte');
    } else {
        // Rediriger vers la page de création de compte
        header('Location: /ProjetFinal_LaetitiaNailArts/creer-un-compte');
        }
    }
      
    /* Pour la page de connexion */  
    public function login() : void  
    {  
        // render la page avec le formulaire de connexion
        $this->render("user/login", []);
    }  
      
    /* Pour vérifier la connexion */  
    public function checkLogin() : void  
    {
    if (isset($_POST["formLogin"]) && $_POST["formLogin"] === "loginForm") {
        // Récupérer les champs du formulaire
        $email = $_POST["email"];
        $email = $this->clean($email);
        $password = $_POST["password"];
        $password = $this->clean($password);

        // Utiliser le manager pour vérifier si un utilisateur avec cet email existe
        $user = $this->userManager->getUserByEmail($email);
        
        // Ajoutez cette ligne pour déboguer
//        var_dump($user);
//        die();

        // Si un utilisateur avec cet email existe
        if ($user) {
            // Vérifier le mot de passe
            if (password_verify($password, $user->getPassword())) {
                $role = $user->getRoleId();

                if ($role == 2) {
                    $_SESSION["user"] = $user->getId();
                    $_SESSION["role"] = $user->getRoleId();
                    $_SESSION["username"] = $user->getUsername();
                    $_SESSION["nom"] = $user->getNom();
                    $_SESSION["prenom"] = $user->getPrenom();
                    $_SESSION["email"] = $user->getEmail();
                }
                
                // Rediriger vers l'accueil
                header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte');
            } else {
                // Rediriger vers la page de connexion avec une erreur
                $_SESSION["error_message"] = "Vos identifiants sont incorrects.";
                header('Location: /ProjetFinal_LaetitiaNailArts/connexion?error');
            }
        } else {
            // Rediriger vers la page de connexion avec une erreur
            $_SESSION["error_message"] = "Vos identifiants sont incorrects.";
            header('Location: /ProjetFinal_LaetitiaNailArts/connexion?error');
        }
    } else {
        // Rediriger vers la page de connexion
        header('Location: /ProjetFinal_LaetitiaNailArts/connexion');
        var_dump('pourquoi je passe ici');
        }
    }
    
    public function logout() : void {
        // Détruire la session
        session_destroy();
        
        // Rediriger vers la page d'accueil ou toute autre page
        header("Location: /ProjetFinal_LaetitiaNailArts/");
    }

    //
    //          ADMIN
    //



//    public function adminLogin() : void
//    {
//        // render la page avec le formulaire de connexion
//        $this->render("admin-login", []);
//    }

    public function adminCkeckLogin(): void
    {
        echo('je fonctionne');
        // Vérifiez si le formulaire a été soumis
        if (isset($_POST["formName"]) && $_POST["formName"] === "adminLoginForm") {
            $username = $_POST["username"];
            $password = $_POST["password"];
            var_dump($_POST["username"], $_POST["password"]);

            // Utilisez le manager pour vérifier si un administrateur avec cet username existe
            $admin = $this->adminManager->getAdminByUsername($username);
            var_dump($admin);
//            die();
            if ($admin) {
                var_dump($admin);
                // Vérifiez le mot de passe
                if (password_verify($password, $admin->getPassword())) {
                    var_dump($admin->getPassword());

                    // Utilisez la fonction getAdminRoleName pour obtenir le rôle de l'administrateur
                    $roleManager = new RoleManager();
                    $adminRoleName = $roleManager->getRoleNameByUsername($username);

                    var_dump($adminRoleName);

                    if ($adminRoleName === 'admin') {
                        $_SESSION["admin"] = $admin->getId();
                        $_SESSION["role"] = "admin";
                        // L'administrateur est authentifié et a le rôle administrateur
                        // Vous pouvez stocker des informations de session ici si nécessaire
                        // Redirigez-le vers la page d'administration
                        header('Location: /ProjetFinal_LaetitiaNailArts/admin/dashboard');
                    } else {
                        // L'administrateur n'a pas le rôle administrateur
                        // Redirigez-le ou traitez-le en conséquence
                        header('Location: /ProjetFinal_LaetitiaNailArts/connexion?error=not_admin');
                    }
                } else {
                    // Le mot de passe est incorrect
                    header('Location: /ProjetFinal_LaetitiaNailArts/connexion?error=invalid_password');
                }
            } else {
                // L'administrateur avec cet username n'existe pas
                header('Location: /ProjetFinal_LaetitiaNailArts/connexion?error=admin_not_found');
            }
        } else {
            // Si le formulaire n'a pas été soumis, redirigez vers la page de connexion
            header('Location: /ProjetFinal_LaetitiaNailArts/admin');
        }
    }

//    public function adminCkeckLogin() : void
//    {
//
//        if (isset($_POST["formName"]) && $_POST["formName"] === "adminLoginForm") {
//            $username = $_POST["username"];
//            $password = $_POST["password"];
//            var_dump($username);
//
//            // Utiliser le manager pour vérifier si un admin avec cet username existe
//            $admin = $this->adminManager->getAdminByUsername($username);
//
//            if ($admin) {
//                if (password_verify($password, $admin->getPassword()))
//                {
//
//                    $_SESSION["admin"] = $admin->getId();
////                    if(isset($_SESSION) && $_SESSION["role"] === "Admin") {
//
//                    // Rediriger vers la page d'administration ou toute autre page appropriée
//                    header('Location: /ProjetFinal_LaetitiaNailArts/admin/dashboard');
////                    }
//                }
//
//            } else {
//                // Les informations d'identification sont incorrectes, afficher un message d'erreur
//                header ('/ProjetFinal_LaetitiaNailArts/connexion?error=invalid_password');
//            }
//        } else {
//            // Si la méthode HTTP n'est pas POST, affichez la page de connexion de l'administrateur
//            header('Location: /ProjetFinal_LaetitiaNailArts/admin-login');
//        }
//    }

//    public function adminRegister() : void
//    {
//        // render la page avec le formulaire d'inscription
//        $this->render("admin-register", []);
//    }

//    public function adminCheckRegister() : void
//    {
//
//        if (isset($_POST["formName"]) && $_POST["formName"] === "adminRegisterForm") {
//            $username = $_POST["new_username"];
//            $password = $_POST["new_password"];
//            $role_id = 1;
//
//
//            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//
//            $newAdmin = new Admin(null,$role_id,$username,$hashedPassword);
//            var_dump ('je suis ici',$newAdmin);
//
//            $createdAdmin =$this->adminManager->createAdmin($newAdmin, $role_id);
//
//            var_dump($createdAdmin);
////            die();
//
////            if ($createdAdmin) {
////                $_SESSION["admin_id"] = $createdAdmin->getId();
////            }
//
//            header('location: /ProjetFinal_LaetitiaNailArts/admin/dashboard');
//        }
//    }


}
