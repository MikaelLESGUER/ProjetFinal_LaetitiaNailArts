<?php

class Contact {
    private ?int $id;
    private string $adresse;
    private string $codePostal;
    private string $ville;
    private ?string $numeroFixe;
    private ?string $numeroPortable;

    public function __construct(?int $id, string $adresse, string $codePostal, string $ville, ?string $numeroFixe, ?string $numeroPortable) {
        $this->id = $id;
        $this->adresse = $adresse;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
        $this->numeroFixe = $numeroFixe;
        $this->numeroPortable = $numeroPortable;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function getCodePostal(): string {
        return $this->codePostal;
    }

    public function getVille(): string {
        return $this->ville;
    }

    public function getNumeroFixe(): ?string {
        return $this->numeroFixe;
    }

    public function getNumeroPortable(): ?string {
        return $this->numeroPortable;
    }

    // Setters
    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }

    public function setCodePostal(string $codePostal): void {
        $this->codePostal = $codePostal;
    }

    public function setVille(string $ville): void {
        $this->ville = $ville;
    }

    public function setNumeroFixe(?string $numeroFixe): void {
        $this->numeroFixe = $numeroFixe;
    }

    public function setNumeroPortable(?string $numeroPortable): void {
        $this->numeroPortable = $numeroPortable;
    }
}

