<?php

class ReseauSocial {
    private ?int $id;
    private string $nomReseauSocial;
    private string $url;

    public function __construct(
        ?int $id,
        string $nomReseauSocial,
        string $url
    ) {
        $this->id = $id;
        $this->nomReseauSocial = $nomReseauSocial;
        $this->url = $url;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getNomReseauSocial(): string {
        return $this->nomReseauSocial;
    }

    public function getUrl(): string {
        return $this->url;
    }

    // Setters
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setNomReseauSocial(string $nomReseauSocial): void {
        $this->nomReseauSocial = $nomReseauSocial;
    }

    public function setUrl(string $url): void {
        $this->url = $url;
    }
}

