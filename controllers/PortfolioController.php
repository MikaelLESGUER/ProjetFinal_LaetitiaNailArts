<?php

    class PortfolioController extends AbstractController
{
    public function showPortfolio()
    {
        $data = [
            'title' => 'Portfolio - Laetitia Nail Arts',
            'items' => $this->renderPortfolioContent(),
        ];

        $this->render('portfolio', $data);
    }

    private function renderPortfolioContent()
    {
        // Créez ici le contenu de votre portfolio fictif
        // Par exemple, un tableau d'éléments de portfolio
        
        $portfolioItems = [
            [
                'id' => 1,
                'title' => 'Projet 1',
                'description' => 'Description du projet 1.',
                'image' => 'chemin/vers/image1.jpg',
            ],
            [
                'id' => 2,
                'title' => 'Projet 2',
                'description' => 'Description du projet 2.',
                'image' => 'chemin/vers/image2.jpg',
            ],
        ];
            
        return $portfolioItems;
    }
    
    public function showItem($params)
    {
        $itemId = $params['id'];
        // Chargez les données du projet en utilisant l'identifiant $itemId
        // Par exemple, $projectData = $this->portfolioManager->getProjectById($itemId);
        
        $data = [
            'title' => 'Détails du projet',
            'content' => 'portfolio_item.phtml', 
            'projectData' => $projectData,
        ];
        
        $this->render('portfolio_item', $data);
    }
    
    public function showPortfolioItemDetails($itemId)
    {
        // Utilisez l'ID pour récupérer les détails du projet correspondant
        $portfolioItem = $this->getPortfolioItemById($itemId);

        if ($portfolioItem) {
            $data = [
                'title' => $portfolioItem['title'],  // Titre de la page
                'portfolioItem' => $portfolioItem,    // Données du projet
            ];

            $this->render('portfolio_item', $data);  // Utilisez le template pour afficher les détails
        } else {
            echo "vous etes mal rediriger";
            // Gérer le cas où l'ID du projet n'est pas valide
            // Par exemple, rediriger vers une page d'erreur
            // ou afficher un message d'erreur
        }
    }

    private function getPortfolioItemById($itemId)
    {
        // Recherchez le projet dans le tableau fictif en utilisant l'ID
        $portfolioItems = $this->renderPortfolioContent();
        foreach ($portfolioItems as $item) {
            if ($item['id'] == $itemId) {
                return $item;
            }
        }
        return null;  // Renvoyez null si l'ID n'a pas été trouvé
    }
}