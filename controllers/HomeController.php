<?php

class HomeController extends AbstractController
{
    public function index()
    {
        // Vos opérations de traitement ici
        
        // Définir le contenu spécifique de la page d'accueil
        $content = "<h1>Bienvenue sur notre site !</h1><p>Ceci est la page d'accueil.</p>";

        // Passer le contenu au rendu du modèle
        $this->render('index', ['content' => $content, 'title' => 'Accueil']);
    }
}

// class HomeController extends AbstractController {
//     public function indexAction() : void {
//         // Logique pour récupérer les données nécessaires
        
//         // Exemple de données à transmettre à la vue
//         $data = [
//             'title' => 'Page d\'accueil',
//             // Autres données...
//         ];
        
//         // Affichage de la vue
//         $this->render('templates/index.phtml', $data);
//     }
// }
