<?php  
 
class Router {
    
    private HomeController $homeController;
    private PortfolioController $portfolioController;
    
    public function __construct()
    {
        $this->homeController = new HomeController;
        $this->portfolioController = new PortfolioController;
    }
    
    private function splitRouteAndParameters(string $route) : array  
    {  
        $routeAndParams = [];
        $routeAndParams["route"] = null;  
        $routeAndParams["portfolioItem"] = null;  
      
        if(strlen($route) > 0) // si la chaine de la route n'est pas vide (donc si ça n'est pas la home)
        {  
            $tab = explode("/", $route);  
            $routeAndParams["route"] = array_shift($tab);
            $routeAndParams["params"] = $tab;
        }  
        else  
        {  
            $routeAndParams["route"] = ""; 
            $routeAndParams["params"] = [];
        }  
      
        return $routeAndParams;  
    }
    
    public function checkRoute(string $route) : void
    {
        $routeTab = $this->splitRouteAndParameters ($route);
        
        if ($routeTab["route"] === "")
        {
            $this->homeController ->index();
        }
         elseif ($routeTab["route"] === "portfolio")  // Si la route est "/portfolio"
        {
            $this->portfolioController->showPortfolio();  // Appel de la méthode correspondante dans le PortfolioController
        }
        elseif ($routeTab["route"] === "portfolio/:id")  // Si la route est "/portfolio/:id"
        {
            var_dump($itemId);
            die;
            // Obtenez l'ID à partir des paramètres et appelez la méthode correspondante
            $itemId = (int) $routeTab["params"]["id"];
            $this->portfolioController->showPortfolioItemDetails($itemId);
        }
    }
}