<?php

class PortfolioController extends AbstractController
{
    private PortfolioManager $portfolioManager;

    public function __construct()
    {
        $this->portfolioManager = new PortfolioManager();
    }

    public function showPortfolio()
    {
        // Récupérer tous les éléments du portfolio depuis le gestionnaire
        $portfolioItems = $this->portfolioManager->getAllPortfolioItems();
        
        // Préparer les valeurs à passer au template
        $values = [
            "content" => $this->renderTemplate("portfolio", ["portfolioItems" => $portfolioItems]),
        ];
        
        // Appeler la méthode render pour afficher la page
        $this->render("index", $values);
    }

    public function showPortfolioItemDetails(int $itemId)
    {
        // Récupérer les détails d'un élément spécifique du portfolio
        $portfolioItem = $this->portfolioManager->getPortfolioItemById($itemId);
        
        // Gérer le cas où l'élément du portfolio n'existe pas
        if (!$portfolioItem) {
            // Gérer par exemple en affichant un message d'erreur ou en redirigeant
        }
        
        // Préparer les valeurs à passer au template
        $values = [
            "content" => $this->renderTemplate("portfolio_item", ["portfolioItem" => $portfolioItem]),
        ];
        
        // Appeler la méthode render pour afficher la page
        $this->render("index", $values);
    }

    private function renderTemplate(string $template, array $values): string
    {
        // Démarrer la capture de sortie
        ob_start();
        
        // Inclure le template en utilisant les valeurs passées
        require "templates/$template.phtml";
        
        // Récupérer la sortie capturée et la vider
        return ob_get_clean();
    }
}
