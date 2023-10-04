<?php

class Role
{
    private $id;
    private $description;

    // Constructeur
    public function __construct($id, $description) {
        $this->id = $id;
        $this->description = $description;
    }

    // Getters et setters
    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}