<?php

class User {
    private ?int $userId;
    private ?string $username;
    private ?string $prenom;
    private ?string $nom;
    private ?string $email;
    private ?string $password;
    private ?int $roleId;
//    private ?string $numeroPortable;
//    private DateTime $dateCreation;
//    private ?DateTime $derniereConnexion;


    public function __construct(
        ?int $userId,
        ?string $username,
        ?string $prenom,
        ?string $nom,
        ?string $email,
        ?string $password,
        ?int $roleId
//        ?string $numeroPortable,
//        DateTime $dateCreation,
//        ?DateTime $derniereConnexion,

    )
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId;
//        $this->numeroPortable = $numeroPortable;
//        $this->dateCreation = $dateCreation;
//        $this->derniereConnexion = $derniereConnexion;

    }

    // Getters
    public function getId(): ?int {
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

    /**
     * @return int|null
     */
    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    // Setters
    public function setId(?int $userId): void {
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

    public function setRoleId(?int $roleId): void {
        $this->roleId = $roleId;
    }
}
