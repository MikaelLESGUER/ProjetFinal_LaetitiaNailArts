<?php  

abstract class AbstractController  
{  
    
        protected function clean(string $string)
    {
        $clearCode = htmlspecialchars($string);
        return $clearCode;
    }

    protected function createSlug($input)
    {
        // Remplacez l'@ par un tiret
//        $slug = str_replace('@', '-', $input);

        // Remplacez les caractères spéciaux par des tirets
        $slug = preg_replace('/[^a-zA-Z0-9-]+/', '-', $input);

        // Remplacez les espaces par des tirets en utilisant une expression régulière
        $slug = preg_replace('/\s+/', '-', $slug);

        // Convertissez en minuscules
        $slug = strtolower($slug);

        return $slug;
    }
    
    protected function render(string $template, array $values)  
    {  
        $data = $values;  
        $page = $template;  
  
        require "templates/layout.phtml";  
    }  
}