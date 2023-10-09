<?php

class HomeController extends AbstractController
{
    public function index() :void
    {
        // Passer le contenu au rendu du modèle
        $this->render('guess/homepage', []);
    }

    public function conditionGeneral() :void
    {
        $this->render('guess/CGU', []);
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
