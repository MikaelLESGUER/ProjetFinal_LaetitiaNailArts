<?php

class User {
    private ?int $userId;
    private string $username;
    private ?string $prenom;
    private ?string $nom;
    private ?string $email;
    private ?string $numeroPortable;
    private ?string $password;
    private DateTime $dateCreation;
    private ?DateTime $derniereConnexion;
    private int $roleId;

    public function __construct(
        ?int $userId,
        string $username,
        ?string $prenom,
        ?string $nom,
        ?string $email,
        ?string $numeroPortable,
        ?string $password,
        DateTime $dateCreation,
        ?DateTime $derniereConnexion,
        int $roleId
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->numeroPortable = $numeroPortable;
        $this->password = $password;
        $this->dateCreation = $dateCreation;
        $this->derniereConnexion = $derniereConnexion;
        $this->roleId = $roleId;
    }

    // Getters
    public function getUserId(): ?int {
        return $this->userId;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getNumeroPortable(): ?string {
        return $this->numeroPortable;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function getDateCreation(): DateTime {
        return $this->dateCreation;
    }

    public function getDerniereConnexion(): ?DateTime {
        return $this->derniereConnexion;
    }

    public function getRoleId(): int {
        return $this->roleId;
    }

    // Setters
    public function setUserId(?int $userId): void {
        $this->userId = $userId;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function setPrenom(?string $prenom): void {
        $this->prenom = $prenom;
    }

    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    public function setNumeroPortable(?string $numeroPortable): void {
        $this->numeroPortable = $numeroPortable;
    }

    public function setPassword(?string $password): void {
        $this->password = $password;
    }

    public function setDerniereConnexion(?DateTime $derniereConnexion): void {
        $this->derniereConnexion = $derniereConnexion;
    }

    public function setRoleId(int $roleId): void {
        $this->roleId = $roleId;
    }
}
