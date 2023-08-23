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
        'title' => 'Projet 1',
        'description' => 'Description du projet 1.',
        'image' => 'chemin/vers/image1.jpg',
        'link' => 'lien-vers-projet1'
        ],
        [
        'title' => 'Projet 2',
        'description' => 'Description du projet 2.',
        'image' => 'chemin/vers/image2.jpg',
        'link' => 'lien-vers-projet2'
        ],
        ];
        
     return $portfolioItems;
    }
}