<?php

class ContactController extends AbstractController
{
    private ContactManager$contactManager;
    public function __construct()
    {
        $this->contactManager = new ContactManager();
    }

    public function showContactPage() {
        $contactInfo = $this->contactManager->getContactInfo(); // Appelez la fonction du gestionnaire pour récupérer les informations de contact
//        var_dump($contactInfo);
//        die();
        $this->render('guess/contact', ['contactInfo' => $contactInfo]);
    }
}