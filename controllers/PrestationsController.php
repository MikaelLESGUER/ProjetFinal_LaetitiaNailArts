<?php

class PrestationsController extends AbstractController
{
    private CategoryManager $categoryManager;
    private PrestationManager $prestationManager;

    public function __construct()
    {
        $this->categoryManager =  new CategoryManager();
        $this->prestationManager = new PrestationManager($this->categoryManager);
    }

    public function prestationDetails(string $prestationSlug) : void
    {
        $prestation = $this->prestationManager->getPrestationBySlug($prestationSlug);

        $this->render("guess/prestation", [
            "prestation" => $prestation
        ]);
    }

    public function prestationsByCategory() : void
    {
        $categories = $this->categoryManager->getAllCategories();
        $prestationsByCategory = [];


        foreach ($categories as $category) {
            $prestations = $this->prestationManager->getPrestationsByCategoryName($category->getSlug());
            $prestationsByCategory[$category->getName()] = $prestations;
        }

        $this->render("guess/prestations_by_category", [
            "prestationsByCategory" => $prestationsByCategory
        ]);

        die();
    }

}
