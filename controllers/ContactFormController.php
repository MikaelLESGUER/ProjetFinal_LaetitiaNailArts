<?php

class ContactFormController extends AbstractController
{
    private CategoryManager $categoryManager;
    private PrestationManager $prestationManager;
    private ContactFormManager $contactFormManager;

    public function __construct()
    {
        $this->categoryManager = new CategoryManager();
        $this->prestationManager = new PrestationManager();
        $this->contactFormManager = new ContactFormManager();
    }
    public function displayQuoteForm($prestationId)
    {
        // Récupérez l'ID de prestation à partir de l'URL
        $prestationId = isset($_GET['id']) ? intval($_GET['id']) : null;
//        $prestationId = isset($_GET['id']) ? (int)$_GET['id'] : null;
        var_dump($prestationId);

        // Récupérez la prestation associée à l'ID
        $prestation = $this->prestationManager->getPrestationById($prestationId);

        // Affichez le formulaire de demande de devis
        $this->render('user/devis', ['prestation' => $prestation]);
    }

    public function submitQuoteForm()
    {
        // Vérifiez si le formulaire a été soumis via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire
            $userId = $_SESSION['user'];

            $prestationId = $_POST['prestation_id'];
//            $prestationId = isset($_POST['prestation_id']) ? $_POST['prestation_id'] : null;
            $subject = $_POST['subject'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            var_dump($userId,$prestationId,$subject,$email,$message);

            // Appelez la fonction du manager pour enregistrer la demande de devis
            $success = $this->contactFormManager->createQuote($userId,$prestationId,$subject,$email,$message);
            var_dump($success);
//            die();

            if ($success) {
                $_SESSION['success_message'] = "Votre demande de devis a été enregistrée avec succès.";
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de l'enregistrement de votre demande de devis.";
            }

            // Redirigez l'utilisateur vers la page de confirmation ou d'erreur
            if ($success) {
                header('Location: /ProjetFinal_LaetitiaNailArts/');
            } else {
                header('Location: /ProjetFinal_LaetitiaNailArts/');
            }
            exit;
        }
    }

    public function displayRenseignementsForm()
    {
        // Récupérez la liste des prestations depuis la base de données (remplacez par votre propre méthode)
        $prestations = $this->prestationManager->getAllPrestations();

        // Créez un tableau de données à passer au modèle
        $data = [
            'prestations' => $prestations,
        ];

        // Affichez le formulaire de renseignement
        $this->render('guess/renseignements', $data);
    }

    public function submitRenseignementForm()
    {
        // Vérifiez si le formulaire a été soumis via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire
//            $prestationId = isset($_POST['prestation']) ? intval($_POST['prestation']) : null;
            // Récupérez les données du formulaire
            if (isset($_POST['prestation'])) {
                $prestationId = intval($_POST['prestation']);
                // Si $prestationId est égal à 0, définissez-le à null
                if ($prestationId === 0) {
                    $prestationId = null;
                }
            } else {
                $prestationId = null;
            }
            $subject = $_POST['subject'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $userId = $_SESSION['user'] ?? null; // Utilisez ?? pour définir $userId à null si $_SESSION['user'] n'existe pas
            var_dump($prestationId,$subject,$email,$message,$userId);

            // Appelez la fonction du manager pour enregistrer les renseignements
            $success = $this->contactFormManager->createRenseignement($prestationId, $userId, $subject, $email, $message);
            var_dump($success);
//            die();

            if ($success) {
                $_SESSION['success_message'] = "Vos renseignements ont été enregistrés avec succès.";
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de l'enregistrement de vos renseignements.";
            }

            // Redirigez l'utilisateur vers la page de confirmation ou d'erreur
            if ($success) {
                header('Location: /ProjetFinal_LaetitiaNailArts/');
            } else {
                header('Location: /ProjetFinal_LaetitiaNailArts/');
            }
            exit;
        }
    }

//    public function displayRenseignementsForm()
//    {
//        // Affichez le formulaire de renseignements
//        $this->render('guess/renseignements', []);
//    }


    public function getCategoriesAndPrestations() : void
    {
        // Récupérez les catégories et prestations depuis votre base de données
        $categories = $this->categoryManager->getAllCategories(); // Remplacez par votre propre méthode de récupération des catégories
        $prestations = $this->prestationManager->getAllPrestations(); // Remplacez par votre propre méthode de récupération des prestations

        // Organisez les données dans un tableau associatif
        $data = [
            'categories' => $categories,
            'prestations' => $prestations,
        ];

        // Convertissez le tableau en format JSON
        $jsonData = json_encode($data);

        // Log the JSON data for debugging
        error_log($jsonData);

        // Envoyez la réponse JSON
        header('Content-Type: application/json');
        echo $jsonData;
    }

}