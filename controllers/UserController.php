<?php

class UserController extends AbstractController
{
    private UserManager $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    public function account() : void
    {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION["user"])) {
            // L'utilisateur est connecté, vous pouvez accéder au nom d'utilisateur
            $userId = $_SESSION["user"];

            // Render la page compte utilisateur et transmettez le nom d'utilisateur
            $this->render("user/mon-compte", ["userId" => $userId]);
        } else {
            // L'utilisateur n'est pas connecté, vous pouvez rediriger vers la page de connexion
            header('Location: /ProjetFinal_LaetitiaNailArts/connexion');
        }
    }

    public function modifyUsername() : void
    {
        // Vérifier que l'utilisateur est connecté
        if (isset($_SESSION["user"])) {
            if (isset($_POST["formUsername"]) && $_POST["formUsername"] === "modifyUsernameForm") {
                $id = $_SESSION["user"];
                $newUsername = $_POST["new_username"];

                // Vérifier que le nouveau nom d'utilisateur n'est pas vide
                if (!empty($newUsername)) {
                    // Mettre à jour le nom d'utilisateur
                    $success = $this->userManager->updateUserUsername($id, $newUsername);
                    $_SESSION["username"] = $newUsername;

                    if ($success) {
                        header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte?success=username_updated');
                    } else {
                        header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte?error=update_failed');
                    }
                } else {
                    header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte/modifier-username?error=empty_username');
                }
            } else {
                // Rediriger vers la page de modification du nom d'utilisateur
                header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte');
            }
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /ProjetFinal_LaetitiaNailArts/connexion');
        }
    }

    public function modifyEmail() : void
    {
        // Vérifier que l'utilisateur est connecté
        if (isset($_SESSION["user"])) {

            if (isset($_POST["formEmail"]) && $_POST["formEmail"] === "modifyEmailForm") {
                $id = $_SESSION["user"];
                $oldEmail = $_POST["old_email"];
                $newEmail = $_POST["new_email"];
                $confirmEmail = $_POST["confirm_email"];

                // Vérifier que l'ancien e-mail correspond
                $user = $this->userManager->getUserById($id);

                if ($user && $user->getEmail() === $oldEmail) {
                    // Vérifier que le nouveau e-mail correspond à la confirmation
                    if ($newEmail === $confirmEmail) {
                        // Mettre à jour l'e-mail
                        $success = $this->userManager->updateUserEmail($id, $newEmail);
                        $_SESSION["email"] = $newEmail;

                        if ($success) {
                            $errorMessage = "votre email a était changer avec succés.";
                            $_SESSION['error_message'] = $errorMessage;
                            header('Location: /ProjetFinal_LaetitiaNailArts/connexion');
                        } else {
                            header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte?error=update_failed');
                        }
                    } else {
                        header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte/modifier-email?error=email_mismatch');
                    }
                } else {
                    header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte/modifier-email?error=invalid_email');
                }
            } else {
                // Rediriger vers la page de modification d'e-mail
                header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte');
            }
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /ProjetFinal_LaetitiaNailArts/connexion');
        }
    }

    public function modifyPassword() : void
    {
        echo ('je suis lu');
        // Vérifier que l'utilisateur est connecté
        if (isset($_SESSION["user"])) {
            if (isset($_POST["formName"]) && $_POST["formName"] === "modifyPasswordForm") {
                $id = $_SESSION["user"];
                $oldPassword = $_POST["old_password"];
                $newPassword = $_POST["new_password"];
                $confirmPassword = $_POST["confirm_password"];
                var_dump($newPassword);

                // Vérifier que l'ancien mot de passe correspond
                $user = $this->userManager->getUserById($id);

                if ($user && password_verify($oldPassword, $user->getPassword())) {
                    // Vérifier que le nouveau mot de passe correspond à la confirmation
                    if ($newPassword === $confirmPassword) {
                        // Mettre à jour le mot de passe
                        $success = $this->userManager->updateUserPassword($id, $newPassword);

                        if ($success) {
                            $errorMessage = "votre mot de passe a était changer avec succés.";
                            $_SESSION['error_message'] = $errorMessage;
                            header('Location: /ProjetFinal_LaetitiaNailArts/connexion');
                        } else {
                            header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte?error=update_failed');
                        }
                    } else {
                        header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte/modifier-password?error=password_mismatch');
                    }
                } else {
                    header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte/modifier-password?error=invalid_password');
                }
            } else {
                // Rediriger vers la page de modification de mot de passe
                header('Location: /ProjetFinal_LaetitiaNailArts/mon-compte');
            }
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /ProjetFinal_LaetitiaNailArts/connexion');
        }
    }

    public function updateNameAndLastName() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formName']) && $_POST['formName'] === 'modifyNameForm') {
            var_dump("je fonctionne");

            // Récupérer les données du formulaire
            $newName = $_POST['new_name'];
            $newLastName = $_POST['new_lastname'];
            var_dump("$newName, $newLastName");

            // Valider et mettre à jour les données dans la base de données (utiliser le manager)
            $userManager = new UserManager(); // Assurez-vous d'avoir une classe UserManager pour gérer les opérations sur l'utilisateur

            $userId = $_SESSION['user']; // Supposons que vous avez stocké l'ID de l'utilisateur en session
            $result = $userManager->updateNameAndLastName($userId, $newName, $newLastName);
            $_SESSION["nom"] = $newName;
            $_SESSION["prenom"] = $newLastName;
            var_dump($userId);
            var_dump($result);
//            die();

            if ($result) {
                // Rediriger avec un message de succès
                header("Location: /ProjetFinal_LaetitiaNailArts/mon-compte?success=name_updated");
                exit();
            } else {
                // Rediriger avec un message d'erreur
                header("Location: /ProjetFinal_LaetitiaNailArts/mon-compte?error=name_update_failed");
                exit();
            }
        } else {
            // Gérer les cas d'accès non autorisé ou les erreurs
            header("Location: /ProjetFinal_LaetitiaNailArts/mon-compte?error=invalid_request");
            exit();
        }
    }

//    public function account() : void
//    {
//        // render la page compte utilisateur
//        $this->render("user/mon-compte", []);
//    }
}